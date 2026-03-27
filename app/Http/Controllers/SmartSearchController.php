<?php

namespace App\Http\Controllers;

use App\Models\aqar;
use App\Models\Category;
use App\Models\Compound;
use App\Models\District;
use App\Models\Finish_type;
use App\Models\Governrate;
use App\Models\Mzaya;
use App\Models\OfferTypes;
use App\Models\SubArea;
use App\Services\PropertySearchParser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

class SmartSearchController extends Controller
{
    protected $parser;

    public function __construct(PropertySearchParser $parser)
    {
        $this->parser = $parser;
    }

    /**
     * Show the smart search chat page.
     */
    public function index($locale)
    {
        return view('smart-search.index');
    }

    /**
     * Process a chat message and return search results.
     */
    public function search(Request $request, $locale)
    {
        $validator = Validator::make($request->all(), [
            'message' => 'required|string|max:500',
            'context' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error' => __('langsite.smart_search_invalid_input'),
            ], 422);
        }

        $message = $request->input('message');
        $context = $request->input('context', []);

        // Parse the message
        $parsed = $this->parser->parse($message);
        $filters = $parsed['filters'];

        // Merge with conversation context (previous filters)
        if (!empty($context)) {
            $filters = array_merge($context, $filters);
        }

        // Build query using the same logic as AqarController@filter
        $query = aqar::where('status', 1)->orderBy('vip', 'DESC')->orderBy('created_at', 'DESC');

        // Apply filters
        $this->applyFilters($query, $filters);

        // Get results
        $results = $query->with(['images', 'mainImage', 'firstImage', 'districte', 'governrateq', 'subAreaa', 'offerTypes'])
            ->take(12)
            ->get();

        // Format results for JSON response
        $formattedResults = $results->map(function ($aqar) use ($locale) {
            $imageUrl = null;
            if ($aqar->mainImage) {
                $imageUrl = URL::to('/') . '/images/' . $aqar->mainImage->img_url;
            } elseif ($aqar->firstImage) {
                $imageUrl = URL::to('/') . '/images/' . $aqar->firstImage->img_url;
            } else {
                $imageUrl = URL::to('/') . '/images/FBO.png';
            }

            $price = '';
            $priceLabel = '';
            if ($aqar->offerTypes && in_array($aqar->offerTypes->id, [3, 4])) {
                $price = number_format($aqar->monthly_rent);
                $priceLabel = $locale === 'en' ? '/month' : '/شهر';
            } else {
                $price = number_format($aqar->total_price);
                $priceLabel = '';
            }

            $location = '';
            if ($aqar->governrateq) {
                $location = $locale === 'en'
                    ? ($aqar->governrateq->governrate_en ?? $aqar->governrateq->governrate)
                    : $aqar->governrateq->governrate;
            }
            if ($aqar->districte) {
                $districtName = $locale === 'en'
                    ? ($aqar->districte->district_en ?? $aqar->districte->district)
                    : $aqar->districte->district;
                $location .= ($location ? ' - ' : '') . $districtName;
            }

            return [
                'id' => $aqar->id,
                'title' => mb_strimwidth($aqar->title, 0, 60, '...'),
                'slug' => $aqar->slug,
                'url' => URL::to(Config::get('app.locale') . '/aqars/' . $aqar->slug),
                'image' => $imageUrl,
                'price' => $price,
                'priceLabel' => $priceLabel,
                'currency' => $locale === 'en' ? 'EGP' : 'جنيه',
                'rooms' => $aqar->rooms,
                'baths' => $aqar->baths,
                'area' => $aqar->total_area,
                'location' => $location,
                'views' => $aqar->views,
                'vip' => $aqar->vip == 1,
            ];
        });

        // Build response
        $response = [
            'success' => true,
            'results' => $formattedResults,
            'resultCount' => $results->count(),
            'filters' => $filters,
            'followUpQuestions' => $parsed['followUpQuestions'],
            'detectedIntents' => array_unique($parsed['detectedIntents']),
        ];

        // If no results, try relaxed search
        if ($results->isEmpty()) {
            $relaxedResults = $this->relaxedSearch($filters, $locale);
            $response['relaxedResults'] = $relaxedResults;
            $response['noResults'] = true;
        }

        return response()->json($response);
    }

    /**
     * Apply parsed filters to the query builder.
     */
    protected function applyFilters($query, array $filters): void
    {
        // Governorate
        if (!empty($filters['location1'])) {
            $query->where('governrate_id', $filters['location1']);
        }

        // District
        if (!empty($filters['location2'])) {
            $query->where('district_id', $filters['location2']);
        }

        // SubArea (text-based search)
        if (!empty($filters['area'])) {
            $areaw = $filters['area'];
            $keys = explode(" ", $areaw);
            if (isset($keys[1])) {
                $areaIDs = SubArea::where('area', 'like', "%{$keys[0]}%")
                    ->orWhere('area', 'like', "%{$keys[1]}%")->pluck('id')->toArray();
            } else {
                $areaIDs = SubArea::where('area', 'like', "%{$areaw}%")->pluck('id')->toArray();
            }
            if (!empty($areaIDs)) {
                $query->whereIn('area_id', $areaIDs);
            }
        }

        // Compound
        if (!empty($filters['compound'])) {
            $query->where('compound', $filters['compound']);
        }

        // Category
        if (!empty($filters['licat'])) {
            $query->where('category', $filters['licat']);
        }

        // Property type
        if (!empty($filters['Propertytype'])) {
            $query->where('property_type', $filters['Propertytype']);
        }

        // Offer type / sale type
        if (!empty($filters['saletype'])) {
            $saletype = $filters['saletype'];
            if ($saletype == 5) {
                $query->where('finannce_bank', 1);
            } elseif ($saletype === 'ALL1') {
                $query->whereIn('offer_type', [1, 2]);
            } elseif ($saletype === 'ALL2') {
                $query->whereIn('offer_type', [3, 4]);
            } else {
                $query->where('offer_type', $saletype);
            }
        }

        // Finish type
        if (!empty($filters['finishtype2'])) {
            $query->where('finishtype', $filters['finishtype2']);
        }

        // Area range
        if (!empty($filters['minArea'])) {
            $query->where('total_area', '>=', $filters['minArea']);
        }
        if (!empty($filters['maxArea'])) {
            $query->where('total_area', '<=', $filters['maxArea']);
        }

        // Price range
        if (!empty($filters['minPrice'])) {
            $query->where('total_price', '>=', $filters['minPrice']);
        }
        if (!empty($filters['maxPrice'])) {
            $query->where('total_price', '<=', $filters['maxPrice']);
        }

        // Rooms range
        if (!empty($filters['minRooms'])) {
            $query->where('rooms', '>=', $filters['minRooms']);
        }
        if (!empty($filters['maxRooms'])) {
            $query->where('rooms', '<=', $filters['maxRooms']);
        }

        // Baths range
        if (!empty($filters['minBaths'])) {
            $query->where('baths', '>=', $filters['minBaths']);
        }
        if (!empty($filters['maxBaths'])) {
            $query->where('baths', '<=', $filters['maxBaths']);
        }

        // Mzaya (features)
        if (!empty($filters['mzaya'])) {
            $mzayaIds = $filters['mzaya'];
            $query->whereHas('mzayaAqar', function ($q) use ($mzayaIds) {
                $q->whereIn('mzaya_id', $mzayaIds);
            });
        }

        // Keywords
        if (!empty($filters['keywords'])) {
            $keyWords = $filters['keywords'];
            $query->where(function ($q) use ($keyWords) {
                $v1 = str_replace('ى', 'ي', $keyWords);
                $v2 = str_replace('ي', 'ى', $keyWords);

                $q->orWhere('title', 'like', "%{$v1}%");
                $q->orWhere('title', 'like', "%{$v2}%");
                $q->orWhere('title', 'like', "%{$keyWords}%");
                $q->orWhere('description', 'like', "%{$keyWords}%");
                $q->orWhere('description', 'like', "%{$v1}%");
                $q->orWhere('description', 'like', "%{$v2}%");
            });
        }
    }

    /**
     * Try a relaxed search when no exact results found.
     * Removes price constraint and area constraints to find nearest matches.
     */
    protected function relaxedSearch(array $filters, string $locale): array
    {
        // Remove strict constraints
        $relaxed = $filters;
        unset($relaxed['minPrice'], $relaxed['maxPrice'], $relaxed['minArea'], $relaxed['maxArea']);

        $query = aqar::where('status', 1)->orderBy('vip', 'DESC')->orderBy('created_at', 'DESC');
        $this->applyFilters($query, $relaxed);

        $results = $query->with(['images', 'mainImage', 'firstImage', 'districte', 'governrateq', 'subAreaa', 'offerTypes'])
            ->take(6)
            ->get();

        return $results->map(function ($aqar) use ($locale) {
            $imageUrl = null;
            if ($aqar->mainImage) {
                $imageUrl = URL::to('/') . '/images/' . $aqar->mainImage->img_url;
            } elseif ($aqar->firstImage) {
                $imageUrl = URL::to('/') . '/images/' . $aqar->firstImage->img_url;
            } else {
                $imageUrl = URL::to('/') . '/images/FBO.png';
            }

            $price = '';
            if ($aqar->offerTypes && in_array($aqar->offerTypes->id, [3, 4])) {
                $price = number_format($aqar->monthly_rent);
            } else {
                $price = number_format($aqar->total_price);
            }

            return [
                'id' => $aqar->id,
                'title' => mb_strimwidth($aqar->title, 0, 60, '...'),
                'slug' => $aqar->slug,
                'url' => URL::to(Config::get('app.locale') . '/aqars/' . $aqar->slug),
                'image' => $imageUrl,
                'price' => $price,
                'rooms' => $aqar->rooms,
                'baths' => $aqar->baths,
                'area' => $aqar->total_area,
            ];
        })->toArray();
    }

    /**
     * Get suggestion chips based on popular searches.
     */
    public function suggestions(Request $request, $locale)
    {
        $governrates = Governrate::take(5)->get();
        $categories = Category::all();

        $suggestions = [];

        if ($locale === 'en') {
            $suggestions = [
                'Apartment for sale in Cairo',
                'Villa with garden',
                'Furnished apartment for rent',
                'Duplex installment',
                'Office for rent',
                'Chalet by the sea',
            ];
        } else {
            $suggestions = [
                'شقة للبيع في القاهرة',
                'فيلا بحديقة',
                'شقة مفروشة للايجار',
                'دوبلكس بالتقسيط',
                'مكتب للايجار',
                'شاليه على البحر',
            ];
        }

        return response()->json([
            'success' => true,
            'suggestions' => $suggestions,
        ]);
    }
}
