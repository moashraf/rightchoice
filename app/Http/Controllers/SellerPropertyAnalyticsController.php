<?php

namespace App\Http\Controllers;

use App\Models\aqar;
use App\Services\SellerPropertyAnalyticsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

/**
 * لوحة تحليلات البائع لعقار محدد.
 *
 * المسار: /{locale}/my-properties/{aqar}/analytics
 * تخضع لمصادقة المستخدم (middleware CheackUser) ولـ Policy التحقق من ملكية العقار.
 */
class SellerPropertyAnalyticsController extends Controller
{
    public function show(
        Request $request,
        string $locale,
        aqar $aqar,
        SellerPropertyAnalyticsService $service
    ) {
        $user = Auth::user();

        if (! $user) {
            return redirect()->route('user.login', ['locale' => $locale]);
        }

        if (! $user->can('view', $aqar)) {
            abort(403, 'ليست لديك صلاحية الاطلاع على تحليلات هذا العقار');
        }

        $days = (int) $request->query('days', SellerPropertyAnalyticsService::DEFAULT_PERIOD);
        $validator = Validator::make(['days' => $days], [
            'days' => 'required|integer|in:' . implode(',', SellerPropertyAnalyticsService::ALLOWED_PERIODS),
        ]);
        if ($validator->fails()) {
            $days = SellerPropertyAnalyticsService::DEFAULT_PERIOD;
        }

        $aqar->load(['mainImage', 'firstImage', 'offerTypes', 'categoryRel', 'governrateq', 'districte', 'subAreaa']);

        $summary = $service->summarize($aqar, $days);

        return view('auth.seller_analytics', [
            'aqar'    => $aqar,
            'summary' => $summary,
            'days'    => $days,
            'periods' => SellerPropertyAnalyticsService::ALLOWED_PERIODS,
        ]);
    }
}
