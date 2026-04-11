<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateaqarAPIRequest;
use App\Http\Requests\API\UpdateaqarAPIRequest;
use App\Models\aqar;
use App\Repositories\aqarRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

class aqarAPIController extends AppBaseController
{
    private $aqarRepository;

    public function __construct(aqarRepository $aqarRepo)
    {
        $this->aqarRepository = $aqarRepo;
    }

    /**
     * GET /api/aqars
     *
     * Exact-match filters (passed as query params):
     *   status, slug, title, description, vip, finannce_bank, licensed, trade,
     *   number_of_floors, total_area, rooms, baths, floor, ground_area, land_area,
     *   downpayment, installment_time, installment_value, monthly_rent, rent_long_time,
     *   offer_type, property_type, license_type, mtr_price, reciving, rec_time,
     *   user_id, category, location, call_id, endorsement, total_price, finishtype,
     *   governrate_id, district_id, area_id, compound, points_avail, views
     *
     * Range filters (min / max):
     *   total_price_min, total_price_max, total_area_min, total_area_max,
     *   rooms_min, rooms_max, baths_min, baths_max, ground_area_min, ground_area_max,
     *   land_area_min, land_area_max, downpayment_min, downpayment_max,
     *   installment_value_min, installment_value_max, monthly_rent_min, monthly_rent_max,
     *   mtr_price_min, mtr_price_max, number_of_floors_min, number_of_floors_max,
     *   floor_min, floor_max, views_min, views_max
     *
     * Text search (LIKE):
     *   search  → searches in title, description, slug
     *
     * Sorting:
     *   sort_by  (default: id)
     *   sort_dir (default: desc)  asc | desc
     *
     * Pagination:
     *   skip, limit
     */
    public function index(Request $request)
    {
        $query = aqar::with([
            'images',
            'aqarLocation',
            'governrateq',
            'districte',
            'subAreaa',
            'callTimes',              // وقت الاتصال
            'offerTypes',             // نوع العرض
            'categoryRel',            // التصنيف
            'finishType',             // نوع التشطيب
            'mzaya',                  // المزايا
            'user:id,name,email,MOP,AGE,TYPE,Job_title,profile_image,created_at', // بيانات المالك
            'user.companiess',        // شركات المالك
        ]);

        // ── Exact-match filters ──────────────────────────────────────────
        $exactFields = [
            'status', 'slug', 'title', 'description', 'vip', 'finannce_bank',
            'licensed', 'trade', 'number_of_floors', 'total_area', 'rooms',
            'baths', 'floor', 'ground_area', 'land_area', 'downpayment',
            'installment_time', 'installment_value', 'monthly_rent',
            'rent_long_time', 'offer_type', 'property_type', 'license_type',
            'mtr_price', 'reciving', 'rec_time', 'user_id', 'category',
            'location', 'call_id', 'endorsement', 'total_price', 'finishtype',
            'governrate_id', 'district_id', 'area_id', 'compound',
            'points_avail', 'views',
        ];

        foreach ($exactFields as $field) {
            if ($request->filled($field)) {
                $query->where($field, $request->input($field));
            }
        }

        // ── Range filters (min / max) ───────────────────────────────────
        $rangeFields = [
            'total_price', 'total_area', 'rooms', 'baths', 'ground_area',
            'land_area', 'downpayment', 'installment_value', 'monthly_rent',
            'mtr_price', 'number_of_floors', 'floor', 'views',
        ];

        foreach ($rangeFields as $field) {
            if ($request->filled("{$field}_min")) {
                $query->where($field, '>=', $request->input("{$field}_min"));
            }
            if ($request->filled("{$field}_max")) {
                $query->where($field, '<=', $request->input("{$field}_max"));
            }
        }

        // ── Text search (LIKE) ──────────────────────────────────────────
        if ($request->filled('search')) {
            $term = $request->input('search');
            $query->where(function ($q) use ($term) {
                $q->where('title', 'LIKE', "%{$term}%")
                  ->orWhere('description', 'LIKE', "%{$term}%")
                  ->orWhere('slug', 'LIKE', "%{$term}%");
            });
        }

        // ── Sorting ─────────────────────────────────────────────────────
        $sortBy  = $request->input('sort_by', 'id');
        $sortDir = $request->input('sort_dir', 'desc');
        if (in_array($sortBy, $exactFields) || $sortBy === 'id' || $sortBy === 'created_at') {
            $query->orderBy($sortBy, $sortDir === 'asc' ? 'asc' : 'desc');
        }

        // ── Pagination (skip / limit) ───────────────────────────────────
        if ($request->filled('skip')) {
            $query->skip((int) $request->input('skip'));
        }
        if ($request->filled('limit')) {
            $query->limit((int) $request->input('limit'));
        }

        $aqars = $query->get();

        return $this->sendResponse($aqars->toArray(), 'Aqars retrieved successfully');
    }

    public function store(CreateaqarAPIRequest $request)
    {
        $aqar = $this->aqarRepository->create($request->all());
        return $this->sendResponse($aqar->toArray(), 'Aqar saved successfully');
    }

    public function show($id)
    {
        $aqar = aqar::with([
            'images',
            'aqarLocation',
            'governrateq',
            'districte',
            'subAreaa',
            'callTimes',              // وقت الاتصال
            'offerTypes',             // نوع العرض
            'categoryRel',            // التصنيف
            'finishType',             // نوع التشطيب
            'mzaya',                  // المزايا
            'user:id,name,email,MOP,AGE,TYPE,Job_title,profile_image,created_at', // بيانات المالك
            'user.companiess',        // شركات المالك
        ])->find($id);

        if (empty($aqar)) {
            return $this->sendError('Aqar not found');
        }
        return $this->sendResponse($aqar->toArray(), 'Aqar retrieved successfully');
    }

    public function update($id, UpdateaqarAPIRequest $request)
    {
        $aqar = $this->aqarRepository->find($id);
        if (empty($aqar)) {
            return $this->sendError('Aqar not found');
        }
        $aqar = $this->aqarRepository->update($request->all(), $id);
        return $this->sendResponse($aqar->toArray(), 'Aqar updated successfully');
    }

    public function destroy($id)
    {
        $aqar = $this->aqarRepository->find($id);
        if (empty($aqar)) {
            return $this->sendError('Aqar not found');
        }
        $aqar->delete();
        return $this->sendSuccess('Aqar deleted successfully');
    }
}
