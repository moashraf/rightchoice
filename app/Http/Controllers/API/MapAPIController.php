<?php

namespace App\Http\Controllers\API;

use App\Models\aqar;
use App\Models\AqarLocation;
use App\Models\Governrate;
use App\Models\property_type;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\AppBaseController;
use App\Http\Controllers\MapController;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;

/**
 * Map API Controller.
 */
class MapAPIController extends AppBaseController
{
    /**
     * GET /api/map/aqars
     */
    public function getAqars(Request $request): JsonResponse
    {
        $locale = $request->get('locale', 'ar');

        $query = aqar::query()
            ->where('status', 1)
            ->whereHas('aqarLocation', function ($q) {
                $q->whereNotNull('lat')
                  ->whereNotNull('lon')
                  ->where(function ($qq) {
                      $qq->where('lat', '!=', 0)->orWhere('lon', '!=', 0);
                  });
            })
            ->with([
                'aqarLocation',
                'governrateq',
                'propertyType',
                'images' => function ($q) {
                    $q->where('main_img', 1)->limit(1);
                },
            ]);

        if ($request->filled('governrate_id')) {
            $query->where('governrate_id', $request->governrate_id);
        }

        if ($request->filled('property_type')) {
            $query->where('property_type', $request->property_type);
        }

        if ($request->filled('search')) {
            $keyword = $request->search;
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'LIKE', "%{$keyword}%")
                  ->orWhere('title_en', 'LIKE', "%{$keyword}%");
            });
        }

        $aqars = $query->get();

        $results = $aqars->map(function ($item) use ($locale) {
            $loc = $item->aqarLocation;
            if (!$loc || !AqarLocation::isValidCoordinate($loc->lat, $loc->lon)) {
                return null;
            }

            $image = $item->images->first();
            $imageUrl = $image ? asset($image->img_url) : asset('assets/img/placeholder.png');
            $price = $item->total_price ?? $item->monthly_rent ?? null;

            $govName = null;
            if ($item->governrateq) {
                $govName = ($locale === 'en' && $item->governrateq->governrate_en)
                    ? $item->governrateq->governrate_en
                    : $item->governrateq->governrate;
            }

            $propTypeName = null;
            if ($item->propertyType) {
                $propTypeName = ($locale === 'en' && $item->propertyType->property_type_en)
                    ? $item->propertyType->property_type_en
                    : $item->propertyType->property_type;
            }

            $title = ($locale === 'en' && $item->title_en) ? $item->title_en : $item->title;
            $description = ($locale === 'en' && $item->description_en) ? $item->description_en : $item->description;
            $description = Str::limit(strip_tags($description), 100);

            return [
                'id'              => $item->id,
                'title'           => $title,
                'description'     => $description,
                'lat'             => (float) $loc->lat,
                'lon'             => (float) $loc->lon,
                'price'           => $price,
                'price_formatted' => $price ? number_format($price, 0) : null,
                'image_url'       => $imageUrl,
                'governorate'     => $govName,
                'property_type'   => $propTypeName,
                'rooms'           => $item->rooms,
                'baths'           => $item->baths,
                'total_area'      => $item->total_area,
            ];
        })->filter()->values();

        return $this->sendResponse([
            'count' => $results->count(),
            'data'  => $results,
        ], 'Map aqars retrieved successfully');
    }

    /**
     * POST /api/map/location
     */
    public function storeLocation(Request $request): JsonResponse
    {
        $request->validate([
            'id_aqar' => 'required|integer|exists:aqar,id',
            'lat'     => 'required|numeric|between:-90,90',
            'lon'     => 'required|numeric|between:-180,180',
        ]);

        $location = AqarLocation::updateOrCreate(
            ['id_aqar' => $request->id_aqar],
            ['lat' => $request->lat, 'lon' => $request->lon]
        );

        return $this->sendResponse($location->toArray(), 'Location saved successfully');
    }

    /**
     * GET /api/map/governorate-coords?governrate_id=x
     */
    public function getGovernorateCoords(Request $request): JsonResponse
    {
        $govId = (int) $request->governrate_id;
        $coords = MapController::getGovernorateCoords();

        if (isset($coords[$govId])) {
            return $this->sendResponse($coords[$govId], 'Coordinates retrieved');
        }

        return $this->sendResponse(['lat' => 30.04439900, 'lon' => 31.23571400], 'Default coordinates (Cairo)');
    }
}

