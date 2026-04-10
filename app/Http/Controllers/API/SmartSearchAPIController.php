<?php

namespace App\Http\Controllers\API;

use App\Models\aqar;
use App\Models\Category;
use App\Models\Governrate;
use App\Models\SubArea;
use App\Services\PropertySearchParser;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;

/**
 * Smart Search (AI Chat) API Controller.
 */
class SmartSearchAPIController extends AppBaseController
{
    protected $parser;

    public function __construct(PropertySearchParser $parser)
    {
        $this->parser = $parser;
    }

    /**
     * POST /api/smart-search
     */
    public function search(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'message' => 'required|string|max:500',
            'context' => 'nullable|array',
            'locale'  => 'nullable|string|in:ar,en',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation Error', 'errors' => $validator->errors()], 422);
        }

        $locale = $request->get('locale', 'ar');
        $message = $request->input('message');
        $context = $request->input('context', []);

        $parsed = $this->parser->parse($message);
        $filters = $parsed['filters'];

        if (!empty($context)) {
            $filters = array_merge($context, $filters);
        }

        $query = aqar::where('status', 1)->orderBy('vip', 'DESC')->orderBy('created_at', 'DESC');
        $this->applyFilters($query, $filters);

        $results = $query->with(['images', 'mainImage', 'firstImage', 'districte', 'governrateq', 'subAreaa', 'offerTypes'])
            ->take(12)
            ->get();

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
                'id'         => $aqar->id,
                'title'      => mb_strimwidth($aqar->title, 0, 60, '...'),
                'slug'       => $aqar->slug,
                'image'      => $imageUrl,
                'price'      => $price,
                'priceLabel' => $priceLabel,
                'currency'   => $locale === 'en' ? 'EGP' : 'جنيه',
                'rooms'      => $aqar->rooms,
                'baths'      => $aqar->baths,
                'area'       => $aqar->total_area,
                'location'   => $location,
                'views'      => $aqar->views,
                'vip'        => $aqar->vip == 1,
            ];
        });

        return response()->json([
            'success'          => true,
            'results'          => $formattedResults,
            'resultCount'      => $results->count(),
            'filters'          => $filters,
            'followUpQuestions' => $parsed['followUpQuestions'],
            'detectedIntents'  => array_unique($parsed['detectedIntents']),
            'noResults'        => $results->isEmpty(),
        ]);
    }

    /**
     * GET /api/smart-search/suggestions
     */
    public function suggestions(Request $request): JsonResponse
    {
        $locale = $request->get('locale', 'ar');

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

        return $this->sendResponse(['suggestions' => $suggestions], 'Suggestions retrieved');
    }

    /**
     * Apply parsed filters to the query.
     */
    protected function applyFilters($query, array $filters): void
    {
        if (!empty($filters['location1'])) {
            $query->where('governrate_id', $filters['location1']);
        }
        if (!empty($filters['location2'])) {
            $query->where('district_id', $filters['location2']);
        }
        if (!empty($filters['area'])) {
            $areaw = $filters['area'];
            $keys = explode(" ", $areaw);
            $areaIDs = isset($keys[1])
                ? SubArea::where('area', 'like', "%{$keys[0]}%")->orWhere('area', 'like', "%{$keys[1]}%")->pluck('id')->toArray()
                : SubArea::where('area', 'like', "%{$areaw}%")->pluck('id')->toArray();
            if (!empty($areaIDs)) {
                $query->whereIn('area_id', $areaIDs);
            }
        }
        if (!empty($filters['compound'])) {
            $query->where('compound', $filters['compound']);
        }
        if (!empty($filters['licat'])) {
            $query->where('category', $filters['licat']);
        }
        if (!empty($filters['Propertytype'])) {
            $query->where('property_type', $filters['Propertytype']);
        }
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
        if (!empty($filters['finishtype2'])) {
            $query->where('finishtype', $filters['finishtype2']);
        }
        if (!empty($filters['minArea'])) {
            $query->where('total_area', '>=', $filters['minArea']);
        }
        if (!empty($filters['maxArea'])) {
            $query->where('total_area', '<=', $filters['maxArea']);
        }
        if (!empty($filters['minPrice'])) {
            $query->where('total_price', '>=', $filters['minPrice']);
        }
        if (!empty($filters['maxPrice'])) {
            $query->where('total_price', '<=', $filters['maxPrice']);
        }
        if (!empty($filters['minRooms'])) {
            $query->where('rooms', '>=', $filters['minRooms']);
        }
        if (!empty($filters['maxRooms'])) {
            $query->where('rooms', '<=', $filters['maxRooms']);
        }
        if (!empty($filters['minBaths'])) {
            $query->where('baths', '>=', $filters['minBaths']);
        }
        if (!empty($filters['maxBaths'])) {
            $query->where('baths', '<=', $filters['maxBaths']);
        }
        if (!empty($filters['mzaya'])) {
            $mzayaIds = $filters['mzaya'];
            $query->whereHas('mzayaAqar', function ($q) use ($mzayaIds) {
                $q->whereIn('mzaya_id', $mzayaIds);
            });
        }
        if (!empty($filters['keywords'])) {
            $keyWords = $filters['keywords'];
            $query->where(function ($q) use ($keyWords) {
                $v1 = str_replace('ى', 'ي', $keyWords);
                $v2 = str_replace('ي', 'ى', $keyWords);
                $q->orWhere('title', 'like', "%{$v1}%")
                  ->orWhere('title', 'like', "%{$v2}%")
                  ->orWhere('title', 'like', "%{$keyWords}%")
                  ->orWhere('description', 'like', "%{$keyWords}%");
            });
        }
    }
}

