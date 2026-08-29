<?php

namespace App\Services;

use App\Enums\PaymentStatusEnum;
use App\Models\aqar;
use App\Models\FawryPayment;
use App\Models\PriceVip;
use App\Models\Pricing;
use App\Models\UserPriceing;
use DomainException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Handles activating the package a user paid for.
 *
 * There are two flows:
 *   - Buyer (paqaat_priceing_sale_id > 0) → creates a UserPriceing subscription that adds points
 *     according to the selected priceing_sale package.
 *   - Seller (tmyezz_price_vip_id > 0)     → activates PropertyPromotionService for the property linked
 *     to the payment using the selected price_vip package (duration_days).
 *
 * Idempotent: safe to call multiple times for the same payment; the second call becomes a no-op.
 */
class PackageFulfillmentService
{
    private const EVENT_FULFILLED = 'package_fulfilled';
    private const EVENT_FULFILLMENT_SKIPPED = 'package_fulfillment_skipped';
    private const EVENT_FULFILLMENT_FAILED = 'package_fulfillment_failed';

    public function __construct(private PropertyPromotionService $promotionService)
    {
    }

    /**
     * Fulfil the package associated with the payment (buyer subscription or seller property promotion).
     *
     * @return bool true if fulfillment was performed in this call, false if it was skipped
     *              (payment not paid, already fulfilled, or missing linked package).
     */
    public function fulfill(FawryPayment $payment, ?int $performedBy = null): bool
    {
        if ($payment->paymentStatus !== PaymentStatusEnum::PAID) {
            return false;
        }

        if ($this->alreadyFulfilled($payment)) {
            return false;
        }

        $saleId = (int) ($payment->paqaat_priceing_sale_id ?? 0);
        $vipId  = (int) ($payment->tmyezz_price_vip_id ?? 0);

        if ($saleId > 0) {
            return $this->fulfillBuyerSubscription($payment, $saleId, $performedBy);
        }

        if ($vipId > 0) {
            return $this->fulfillSellerPromotion($payment, $vipId, $performedBy);
        }

        $payment->logStatusChange(
            self::EVENT_FULFILLMENT_SKIPPED,
            $payment->paymentStatus,
            $payment->paymentStatus,
            'الدفعة مدفوعة لكنها غير مرتبطة بأي باقة (لا باقة نقاط ولا باقة تمييز).',
            null,
            $performedBy
        );

        return false;
    }

    private function alreadyFulfilled(FawryPayment $payment): bool
    {
        return $payment->statusLogs()
            ->where('event_type', self::EVENT_FULFILLED)
            ->exists();
    }

    /**
     * Buyer flow: create the points subscription in users_priceing_sale.
     */
    private function fulfillBuyerSubscription(FawryPayment $payment, int $priceingSaleId, ?int $performedBy): bool
    {
        $package = Pricing::find($priceingSaleId);

        if (!$package) {
            $payment->logStatusChange(
                self::EVENT_FULFILLMENT_FAILED,
                $payment->paymentStatus,
                $payment->paymentStatus,
                "باقة النقاط رقم {$priceingSaleId} غير موجودة، تعذر تفعيل الاشتراك.",
                null,
                $performedBy
            );

            return false;
        }

        try {
            $subscription = DB::transaction(function () use ($payment, $package) {
                $current = 0;
                $existing = UserPriceing::where('user_id', $payment->user_id)
                    ->where('statues', 1)
                    ->orderByDesc('id')
                    ->first();

                if ($existing) {
                    $existing->update(['statues' => 0]);
                    if ((int) $existing->current_points >= 0) {
                        $current = (int) $existing->current_points;
                    }
                }

                return UserPriceing::create([
                    'user_id'        => $payment->user_id,
                    'pricing_id'     => $package->id,
                    'statues'        => 1,
                    'start_points'   => $package->points,
                    'current_points' => (int) $package->points + $current,
                    'sub_points'     => 0,
                ]);
            });
        } catch (\Throwable $exception) {
            Log::error('Buyer subscription fulfillment failed.', [
                'payment_id' => $payment->id,
                'pricing_id' => $package->id,
                'user_id'    => $payment->user_id,
                'message'    => $exception->getMessage(),
            ]);

            $payment->logStatusChange(
                self::EVENT_FULFILLMENT_FAILED,
                $payment->paymentStatus,
                $payment->paymentStatus,
                'تعذر إنشاء اشتراك النقاط: ' . $exception->getMessage(),
                null,
                $performedBy
            );

            return false;
        }

        $payment->logStatusChange(
            self::EVENT_FULFILLED,
            $payment->paymentStatus,
            $payment->paymentStatus,
            sprintf(
                'تم تفعيل باقة النقاط "%s" (%d نقطة) للمستخدم رقم %d.',
                strip_tags((string) ($package->type ?? '#' . $package->id)),
                (int) $package->points,
                (int) $payment->user_id
            ),
            [
                'flow'             => 'buyer_pricing_sale',
                'pricing_sale_id'  => $package->id,
                'user_id'          => $payment->user_id,
                'points_added'     => (int) $package->points,
                'subscription_id'  => $subscription->id ?? null,
            ],
            $performedBy
        );

        return true;
    }

    /**
     * Seller flow: promote the linked property for the duration defined on price_vip.
     */
    private function fulfillSellerPromotion(FawryPayment $payment, int $priceVipId, ?int $performedBy): bool
    {
        $package = PriceVip::find($priceVipId);

        if (!$package) {
            $payment->logStatusChange(
                self::EVENT_FULFILLMENT_FAILED,
                $payment->paymentStatus,
                $payment->paymentStatus,
                "باقة التمييز رقم {$priceVipId} غير موجودة، تعذر تمييز الإعلان.",
                null,
                $performedBy
            );

            return false;
        }

        $aqarId = $this->resolveAqarId($payment);
        $aqar = $aqarId ? aqar::find($aqarId) : null;

        if (!$aqar) {
            $payment->logStatusChange(
                self::EVENT_FULFILLMENT_FAILED,
                $payment->paymentStatus,
                $payment->paymentStatus,
                'تعذر تحديد العقار المرتبط بعملية التمييز.',
                ['flow' => 'seller_vip', 'aqar_id' => $aqarId],
                $performedBy
            );

            return false;
        }

        if ($aqar->isPromotionActive() && (int) $aqar->vip_price_id === (int) $package->id) {
            $payment->logStatusChange(
                self::EVENT_FULFILLED,
                $payment->paymentStatus,
                $payment->paymentStatus,
                sprintf(
                    'العقار رقم %d مميز بالفعل بنفس الباقة "%s" حتى %s.',
                    $aqar->id,
                    strip_tags((string) ($package->name ?? '#' . $package->id)),
                    optional($aqar->vip_expires_at)->format('Y-m-d H:i') ?? '-'
                ),
                [
                    'flow'          => 'seller_vip',
                    'price_vip_id'  => $package->id,
                    'aqar_id'       => $aqar->id,
                    'already_active' => true,
                ],
                $performedBy
            );

            return false;
        }

        try {
            $activated = $this->promotionService->activate($aqar, $package);
        } catch (DomainException $exception) {
            Log::warning('Seller promotion fulfillment blocked.', [
                'payment_id'   => $payment->id,
                'price_vip_id' => $package->id,
                'aqar_id'      => $aqar->id,
                'message'      => $exception->getMessage(),
            ]);

            $payment->logStatusChange(
                self::EVENT_FULFILLMENT_FAILED,
                $payment->paymentStatus,
                $payment->paymentStatus,
                'تعذر تفعيل تمييز الإعلان: ' . $exception->getMessage(),
                ['flow' => 'seller_vip', 'price_vip_id' => $package->id, 'aqar_id' => $aqar->id],
                $performedBy
            );

            return false;
        } catch (\Throwable $exception) {
            Log::error('Seller promotion fulfillment failed.', [
                'payment_id'   => $payment->id,
                'price_vip_id' => $package->id,
                'aqar_id'      => $aqar->id,
                'message'      => $exception->getMessage(),
            ]);

            $payment->logStatusChange(
                self::EVENT_FULFILLMENT_FAILED,
                $payment->paymentStatus,
                $payment->paymentStatus,
                'خطأ غير متوقع أثناء تمييز الإعلان: ' . $exception->getMessage(),
                ['flow' => 'seller_vip', 'price_vip_id' => $package->id, 'aqar_id' => $aqar->id],
                $performedBy
            );

            return false;
        }

        $payment->logStatusChange(
            self::EVENT_FULFILLED,
            $payment->paymentStatus,
            $payment->paymentStatus,
            sprintf(
                'تم تمييز العقار رقم %d بالباقة "%s" لمدة %d يوم حتى %s.',
                $aqar->id,
                strip_tags((string) ($package->name ?? '#' . $package->id)),
                (int) $package->duration_days,
                optional($activated->vip_expires_at)->format('Y-m-d H:i') ?? '-'
            ),
            [
                'flow'           => 'seller_vip',
                'price_vip_id'   => $package->id,
                'aqar_id'        => $aqar->id,
                'duration_days'  => (int) $package->duration_days,
                'vip_started_at' => optional($activated->vip_started_at)->toIso8601String(),
                'vip_expires_at' => optional($activated->vip_expires_at)->toIso8601String(),
            ],
            $performedBy
        );

        return true;
    }

    /**
     * The aqar_id is stored inside gateway_response as JSON when the VIP checkout is initiated.
     * We accept a raw JSON object or the newline-separated concatenated JSON objects that
     * appendGatewayResponse produces.
     */
    private function resolveAqarId(FawryPayment $payment): ?int
    {
        $raw = trim((string) $payment->gateway_response);

        if ($raw === '') {
            return null;
        }

        $decoded = json_decode($raw, true);
        if (is_array($decoded) && isset($decoded['aqar_id']) && is_numeric($decoded['aqar_id'])) {
            return (int) $decoded['aqar_id'];
        }

        // Handle the "appended responses" format ({..},\n{..}) by scanning each block.
        foreach (preg_split('/\r?\n/', $raw) as $line) {
            $line = rtrim($line, ", \t\r\n");
            if ($line === '' || $line[0] !== '{') {
                continue;
            }

            $item = json_decode($line, true);
            if (is_array($item) && isset($item['aqar_id']) && is_numeric($item['aqar_id'])) {
                return (int) $item['aqar_id'];
            }
        }

        $callback = json_decode((string) $payment->callback_payload, true);
        if (is_array($callback)) {
            $profileId = (string) ($callback['customerMerchantId'] ?? $callback['customerProfileId'] ?? '');
            if ($profileId !== '' && str_contains($profileId, '55555')) {
                $pieces = explode('55555', $profileId, 2);
                if (count($pieces) === 2 && ctype_digit($pieces[1])) {
                    return (int) $pieces[1];
                }
            }
        }

        return null;
    }
}
