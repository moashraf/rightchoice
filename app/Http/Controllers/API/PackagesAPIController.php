<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Models\aqar;
use App\Models\PriceVip;
use App\Models\PropertyPromotion;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PackagesAPIController extends AppBaseController
{
    /**
     * GET /api/my-seller-packages
     */
    public function mySellerPackages(Request $request): JsonResponse
    {
        $user = $request->user();

        $promotions = PropertyPromotion::with([
                'package:id,name,name_en,price,duration_days,description,description_en,views,bgColor',
                'aqar:id,title,title_en,slug,slug_en,vip,vip_expires_at,status',
                'payment:id,paymentStatus,paymentMethod,referenceNumber,paid_at,paymentAmount',
            ])
            ->where('user_id', $user->id)
            ->orderByDesc('id')
            ->get();

        $active = $promotions->filter(fn (PropertyPromotion $row) => $row->status === PropertyPromotion::STATUS_ACTIVE);

        return $this->sendResponse([
            'active_count' => $active->count(),
            'active'       => $active->map(fn (PropertyPromotion $row) => $this->formatSellerSubscription($row))->values(),
            'history'      => $promotions->map(fn (PropertyPromotion $row) => $this->formatSellerSubscription($row))->values(),
        ], 'تم استرجاع اشتراكات باقات البائع بنجاح.');
    }

    /**
     * GET /api/my-properties-for-promotion
     * Properties the seller can feature with a VIP package.
     */
    public function propertiesForPromotion(Request $request): JsonResponse
    {
        $properties = aqar::query()
            ->with(['mainImage', 'firstImage', 'governrateq', 'districte'])
            ->where('user_id', $request->user()->id)
            ->where('status', 1)
            ->latest('id')
            ->get()
            ->filter(fn (aqar $property) => $property->isEligibleForPromotion())
            ->values()
            ->map(function (aqar $property) {
                $image = $property->mainImage ?: $property->firstImage;

                return [
                    'id'          => $property->id,
                    'title'       => $property->title,
                    'title_en'    => $property->title_en,
                    'slug'        => $property->slug,
                    'governrate'  => $property->governrateq->governrate ?? null,
                    'district'    => $property->districte->district ?? null,
                    'image'       => $image?->img_url,
                    'is_eligible' => true,
                ];
            });

        return $this->sendResponse($properties, 'تم استرجاع العقارات المتاحة للتمييز بنجاح.');
    }

    private function formatSellerPackage(PriceVip $package): array
    {
        return [
            'id'             => $package->id,
            'package_kind'   => 'seller',
            'name'           => $package->name,
            'name_en'        => $package->name_en,
            'description'    => $package->description,
            'description_en' => $package->description_en,
            'price'          => (float) $package->price,
            'views'          => $package->views,
            'duration_days'  => (int) $package->duration_days,
            'bgColor'        => $package->bgColor,
        ];
    }

    private function formatSellerSubscription(PropertyPromotion $promotion): array
    {
        $aqar = $promotion->aqar;

        return [
            'id'            => $promotion->id,
            'status'        => $promotion->status,
            'amount_paid'   => (float) $promotion->amount_paid,
            'duration_days' => (int) $promotion->duration_days,
            'started_at'    => optional($promotion->started_at)->toIso8601String(),
            'expires_at'    => optional($promotion->expires_at)->toIso8601String(),
            'package'       => $promotion->package ? $this->formatSellerPackage($promotion->package) : null,
            'aqar'          => $aqar ? [
                'id'       => $aqar->id,
                'title'    => $aqar->title,
                'title_en' => $aqar->title_en,
                'is_vip'   => (int) $aqar->vip === 1,
            ] : null,
            'payment'       => $promotion->payment ? [
                'id'              => $promotion->payment->id,
                'status'          => $promotion->payment->paymentStatus,
                'method'          => $promotion->payment->paymentMethod,
                'referenceNumber' => $promotion->payment->referenceNumber,
                'paid_at'         => optional($promotion->payment->paid_at)->toIso8601String(),
            ] : null,
        ];
    }
}
