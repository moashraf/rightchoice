<?php

namespace App\Http\Controllers;

use App\Models\aqar;
use App\Models\PriceVip;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SellFasterController extends Controller
{
    private const DISCOUNT_PERCENT = 80;

    /**
     * Show the promotional landing page.
     */
    public function index(string $locale)
    {
        $packages = PriceVip::query()
            ->where('price', '>', 0)
            ->orderBy('price')
            ->get();

        return view('promotions.sell-faster', [
            'packages' => $packages,
            'discountPercent' => self::DISCOUNT_PERCENT,
        ]);
    }

    /**
     * Show the authenticated seller's properties before checkout.
     */
    public function subscribe(Request $request, string $locale, PriceVip $pricing)
    {
        if ((float) $pricing->price <= 0) {
            return redirect()
                ->route('sell-faster.index', ['locale' => $locale])
                ->with('success', $locale === 'en'
                    ? 'This package is not available.'
                    : 'هذه الباقة غير متاحة حاليًا.');
        }

        if (auth()->user()->isCompanyAccount()) {
            return redirect()
                ->route('sell-faster.index', ['locale' => $locale])
                ->with('success', $locale === 'en'
                    ? 'Seller promotion packages are not available for company accounts.'
                    : 'باقات تمييز العقارات غير متاحة لحسابات الشركات.');
        }

        $properties = aqar::query()
            ->with(['mainImage', 'firstImage', 'governrateq', 'districte'])
            ->where('user_id', auth()->id())
            ->where('status', 1)
            ->latest('id')
            ->get();

        return view('promotions.select-property', [
            'pricing' => $pricing,
            'properties' => $properties,
            'discountPercent' => self::DISCOUNT_PERCENT,
        ]);
    }

    /**
     * Validate the selected property and continue to the checkout page.
     */
    public function selectProperty(
        Request $request,
        string $locale,
        PriceVip $pricing
    ) {
        $validated = $request->validate([
            'aqar_id' => [
                'required',
                'integer',
                Rule::exists('aqar', 'id')->where(function ($query) {
                    $query->where('user_id', auth()->id())
                        ->where('status', 1)
                        ->whereNull('deleted_at');
                }),
            ],
        ], [
            'aqar_id.required' => $locale === 'en'
                ? 'Please select a property first.'
                : 'من فضلك اختر العقار الذي تريد تمييزه.',
            'aqar_id.exists' => $locale === 'en'
                ? 'Only published and active properties can be promoted.'
                : 'يمكن تمييز العقارات المنشورة والمفعلة فقط.',
        ]);

        $property = aqar::query()
            ->where('id', $validated['aqar_id'])
            ->where('user_id', auth()->id())
            ->where('status', 1)
            ->firstOrFail();

        return redirect()->route('sell-faster.checkout', [
            'locale' => $locale,
            'pricing' => $pricing->id,
            'aqar' => $property->id,
        ]);
    }

    /**
     * Show the existing seller-package checkout for the selected property.
     */
    public function checkout(
        string $locale,
        PriceVip $pricing,
        aqar $aqar
    ) {
        abort_unless(
            (int) $aqar->user_id === (int) auth()->id()
                && $aqar->isEligibleForPromotion(),
            403,
            $locale === 'en'
                ? 'Only published and active properties can be promoted.'
                : 'يمكن تمييز العقارات المنشورة والمفعلة فقط.'
        );

        $discountMultiplier = (100 - self::DISCOUNT_PERCENT) / 100;
        $discountedPrice = round((float) $pricing->price * $discountMultiplier, 2);

        $PriceVip = clone $pricing;
        $PriceVip->price = $discountedPrice;

        session([
            'sell_faster_checkout' => [
                'price_vip_id' => $pricing->id,
                'aqar_id' => $aqar->id,
                'original_price' => (float) $pricing->price,
                'discounted_price' => $discountedPrice,
                'discount_percent' => self::DISCOUNT_PERCENT,
            ],
        ]);

        return view('aqar_tmez_singel', [
            'PriceVip' => $PriceVip,
            'vipid' => $pricing->id,
            'aqarSingle_id' => $aqar->id,
            'promotionDiscountPercent' => self::DISCOUNT_PERCENT,
        ]);
    }
}
