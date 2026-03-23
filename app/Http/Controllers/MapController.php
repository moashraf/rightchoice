<?php

namespace App\Http\Controllers;

use App\Models\aqar;
use App\Models\AqarLocation;
use App\Models\Governrate;
use App\Models\TypeOfProp;
use App\Models\property_type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;

class MapController extends Controller
{
    /**
     * Display the map page with filter dropdowns.
     */
    public function index($locale = null)
    {
        $governrates   = Governrate::orderBy('governrate')->get();
        $propertyTypes = property_type::orderBy('property_type')->get();

        return view('map', compact('governrates', 'propertyTypes'));
    }

    /**
     * Return JSON of properties with valid coordinates for the map.
     * Supports filters: governrate_id, property_type, search (title keyword).
     */
    public function getAqars(Request $request)
    {
        $locale = App::getLocale();

        $query = aqar::query()
            ->where('status', 1)                       // only active properties
            ->whereHas('aqarLocation', function ($q) {  // must have valid coordinates
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

        // Filter by governorate
        if ($request->filled('governrate_id')) {
            $query->where('governrate_id', $request->governrate_id);
        }

        // Filter by property type
        if ($request->filled('property_type')) {
            $query->where('property_type', $request->property_type);
        }

        // Search by title keyword
        if ($request->filled('search')) {
            $keyword = $request->search;
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'LIKE', "%{$keyword}%")
                  ->orWhere('title_en', 'LIKE', "%{$keyword}%");
            });
        }

        $aqars = $query->get();

        // Build clean JSON response
        $results = $aqars->map(function ($item) use ($locale) {
            $loc = $item->aqarLocation;

            // Double-check coordinate validity
            if (!$loc || !AqarLocation::isValidCoordinate($loc->lat, $loc->lon)) {
                return null;
            }

            // Determine best image URL
            $image = $item->images->first();
            $imageUrl = $image ? asset($image->img_url) : asset('assets/img/placeholder.png');

            // Price: prefer total_price, fallback to monthly_rent
            $price = $item->total_price ?? $item->monthly_rent ?? null;

            // Governorate name
            $govName = null;
            if ($item->governrateq) {
                $govName = ($locale === 'en' && $item->governrateq->governrate_en)
                    ? $item->governrateq->governrate_en
                    : $item->governrateq->governrate;
            }

            // Property type name
            $propTypeName = null;
            if ($item->propertyType) {
                $propTypeName = ($locale === 'en' && $item->propertyType->property_type_en)
                    ? $item->propertyType->property_type_en
                    : $item->propertyType->property_type;
            }

            // Title
            $title = ($locale === 'en' && $item->title_en) ? $item->title_en : $item->title;

            // Description (truncated)
            $description = ($locale === 'en' && $item->description_en)
                ? $item->description_en
                : $item->description;
            $description = \Illuminate\Support\Str::limit(strip_tags($description), 100);

            // Detail page URL
            $detailUrl = url(Config::get('app.locale') . '/aqars/' . $item->id);

            return [
                'id'            => $item->id,
                'title'         => $title,
                'description'   => $description,
                'lat'           => (float) $loc->lat,
                'lon'           => (float) $loc->lon,
                'price'         => $price,
                'price_formatted' => $price ? number_format($price, 0) : null,
                'image_url'     => $imageUrl,
                'governorate'   => $govName,
                'property_type' => $propTypeName,
                'detail_url'    => $detailUrl,
                'rooms'         => $item->rooms,
                'baths'         => $item->baths,
                'total_area'    => $item->total_area,
            ];
        })->filter()->values();

        return response()->json([
            'success' => true,
            'count'   => $results->count(),
            'data'    => $results,
        ]);
    }

    /**
     * Store or update a property's map coordinates.
     * Can be used from admin panel or front-end.
     */
    public function storeLocation(Request $request)
    {
        $request->validate([
            'id_aqar' => 'required|integer|exists:aqar,id',
            'lat'     => 'required|numeric|between:-90,90',
            'lon'     => 'required|numeric|between:-180,180',
        ]);

        $location = AqarLocation::updateOrCreate(
            ['id_aqar' => $request->id_aqar],
            [
                'lat' => $request->lat,
                'lon' => $request->lon,
            ]
        );

        return response()->json([
            'success' => true,
            'data'    => $location,
        ]);
    }
}
