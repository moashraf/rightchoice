<?php

namespace App\Http\Controllers;

use App\Models\PriceVip;
use App\Models\Pricing;
use Illuminate\Http\Request;

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
     * Start the existing Fawry subscription flow with the promotional amount.
     *
     * The discounted amount is calculated from the package stored in the
     * database. We intentionally do not trust a price sent by the browser.
     */
    public function subscribe(Request $request, string $locale, Pricing $pricing)
    {
        if ((float) $pricing->price <= 0) {
            return redirect()->to(url($locale . '/pricing-seller'));
        }

        $discountMultiplier = (100 - self::DISCOUNT_PERCENT) / 100;
        $discountedAmount = round((float) $pricing->price * $discountMultiplier, 2);

        $request->merge([
            'price_id' => $pricing->id,
            'price' => $discountedAmount,
            'pricePoints' => $pricing->points,
        ]);

        return app(PricController::class)->store($request);
    }
}
