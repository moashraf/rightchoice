<?php

namespace App\Http\Controllers\API;

use App\Models\aqar;
use App\Models\Category;
use App\Models\Compound;
use App\Models\District;
use App\Models\Finish_type;
use App\Models\Governrate;
use App\Models\Mzaya;
use App\Models\OfferTypes;
use App\Models\SubArea;
use App\Models\property_type;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Config;

/**
 * Search & Filter Aqars API.
 */
class SearchAPIController extends AppBaseController
{
    /**
     * GET /api/search
     */
    public function search(Request $request): JsonResponse
    {
        $query = aqar::where('status', 1)->orderBy('vip', 'DESC')->orderBy('created_at', 'DESC');

        // Category
        if ($request->filled('licat')) {
            $query->where('category', $request->licat);
        }

        // Property type
        if ($request->filled('Propertytype')) {
            $query->where('property_type', $request->Propertytype);
        }

        // Offer type / sale type
        if ($request->filled('saletype')) {
            $saletype = $request->saletype;
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

        // Governorate
        if ($request->filled('location1')) {
            $query->where('governrate_id', $request->location1);
        }

        // District
        if ($request->filled('location2')) {
            $query->where('district_id', $request->location2);
        }

        // SubArea
        if ($request->filled('area')) {
            $areaw = $request->area;
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
        if ($request->filled('compound')) {
            $query->where('compound', $request->compound);
        }

        // Finish type
        if ($request->filled('finishtype2')) {
            $query->where('finishtype', $request->finishtype2);
        }

        // Area range
        if ($request->filled('minArea')) {
            $query->where('total_area', '>=', $request->minArea);
        }
        if ($request->filled('maxArea')) {
            $query->where('total_area', '<=', $request->maxArea);
        }

        // Price range
        if ($request->filled('minPrice')) {
            $query->where('total_price', '>=', $request->minPrice);
        }
        if ($request->filled('maxPrice')) {
            $query->where('total_price', '<=', $request->maxPrice);
        }

        // Rooms range
        if ($request->filled('minRooms')) {
            $query->where('rooms', '>=', $request->minRooms);
        }
        if ($request->filled('maxRooms')) {
            $query->where('rooms', '<=', $request->maxRooms);
        }

        // Baths range
        if ($request->filled('minBaths')) {
            $query->where('baths', '>=', $request->minBaths);
        }
        if ($request->filled('maxBaths')) {
            $query->where('baths', '<=', $request->maxBaths);
        }

        // Mzaya (features)
        if ($request->filled('mzaya')) {
            $mzayaIds = is_array($request->mzaya) ? $request->mzaya : [$request->mzaya];
            $query->whereHas('mzayaAqar', function ($q) use ($mzayaIds) {
                $q->whereIn('mzaya_id', $mzayaIds);
            });
        }

        // Keywords
        if ($request->filled('keywords')) {
            $keyWords = $request->keywords;
            $query->where(function ($q) use ($keyWords) {
                $v1 = str_replace('ى', 'ي', $keyWords);
                $v2 = str_replace('ي', 'ى', $keyWords);
                $q->orWhere('title', 'like', "%{$v1}%")
                  ->orWhere('title', 'like', "%{$v2}%")
                  ->orWhere('title', 'like', "%{$keyWords}%")
                  ->orWhere('description', 'like', "%{$keyWords}%");
            });
        }

        // Sort
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'price_asc':
                    $query->orderBy('total_price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('total_price', 'desc');
                    break;
                case 'area_asc':
                    $query->orderBy('total_area', 'asc');
                    break;
                case 'area_desc':
                    $query->orderBy('total_area', 'desc');
                    break;
                case 'newest':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'oldest':
                    $query->orderBy('created_at', 'asc');
                    break;
            }
        }

        $results = $query->with(['images', 'mainImage', 'firstImage', 'governrateq', 'districte', 'subAreaa', 'offerTypes'])
            ->paginate($request->get('per_page', 15));

        return $this->sendResponse($results->toArray(), 'Search results retrieved successfully');
    }

    /**
     * GET /api/search/filters
     * Return all available filter options.
     */
    public function filters(): JsonResponse
    {
        return $this->sendResponse([
            'categories'     => Category::all(),
            'governrates'    => Governrate::with('districts')->get(),
            'finish_types'   => Finish_type::all(),
            'offer_types'    => OfferTypes::all(),
            'mzayas'         => Mzaya::all(),
            'compounds'      => Compound::all(),
        ], 'Filter options retrieved successfully');
    }

    /**
     * GET /api/search/property-types?cat_id=x
     */
    public function propertyTypes(Request $request): JsonResponse
    {
        $types = property_type::select('id', 'property_type')
            ->where('cat_id', $request->cat_id)
            ->get();

        return $this->sendResponse($types->toArray(), 'Property types retrieved successfully');
    }

    /**
     * GET /api/search/districts?governrate_id=x
     */
    public function districts(Request $request): JsonResponse
    {
        $districts = District::where('governrate_id', $request->governrate_id)->get();

        return $this->sendResponse($districts->toArray(), 'Districts retrieved successfully');
    }
}

