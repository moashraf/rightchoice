<?php

namespace App\Services;

use App\Contracts\SmsProviderInterface;
use App\Models\aqar;
use App\Models\FawryPayment;
use App\Models\PriceVip;
use App\Models\PropertyPromotion;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use DomainException;

class PropertyPromotionService
{
    public function __construct(private SmsProviderInterface $smsProvider)
    {
    }

    public function activate(
        aqar $property,
        PriceVip $package,
        bool $sendSms = true,
        ?FawryPayment $payment = null
    ): aqar {
        if (!$property->isEligibleForPromotion()) {
            throw new DomainException('العقار يجب أن يكون منشورًا وغير مميز حاليًا.');
        }

        $startedAt = now();
        $durationDays = (int) $package->duration_days;
        $expiresAt = $startedAt->copy()->addDays($durationDays);

        DB::transaction(function () use ($property, $package, $payment, $startedAt, $expiresAt, $durationDays) {
            $property->forceFill([
                'vip'            => 1,
                'vip_price_id'   => $package->id,
                'vip_started_at' => $startedAt,
                'vip_expires_at' => $expiresAt,
            ])->save();

            $this->recordActiveSubscription($property, $package, $payment, $startedAt, $expiresAt, $durationDays);
        });

        if ($sendSms) {
            $this->sendActivationSms($property, $package);
        }

        return $property->refresh();
    }

    /**
     * Create or promote the property_promotions row that tracks this subscription.
     *
     * Preference order for locating an existing row:
     *   1) same payment            → flip it to active
     *   2) pending row for (user, aqar, package) with no payment linked → flip it to active + attach payment
     * Otherwise, insert a brand new active row (used when admins fulfill manually
     * without an initial pending record).
     */
    private function recordActiveSubscription(
        aqar $property,
        PriceVip $package,
        ?FawryPayment $payment,
        \Illuminate\Support\Carbon $startedAt,
        \Illuminate\Support\Carbon $expiresAt,
        int $durationDays
    ): void {
        $amount = $payment ? (float) $payment->paymentAmount : (float) $package->price;

        $subscription = null;

        if ($payment) {
            $subscription = PropertyPromotion::where('fawry_payment_id', $payment->id)->first();
        }

        if (!$subscription) {
            $subscription = PropertyPromotion::where('user_id', $property->user_id)
                ->where('aqar_id', $property->id)
                ->where('price_vip_id', $package->id)
                ->where('status', PropertyPromotion::STATUS_PENDING)
                ->orderByDesc('id')
                ->first();
        }

        if ($subscription) {
            $subscription->fill([
                'status'           => PropertyPromotion::STATUS_ACTIVE,
                'duration_days'    => $durationDays,
                'started_at'       => $startedAt,
                'expires_at'       => $expiresAt,
                'fawry_payment_id' => $payment?->id ?? $subscription->fawry_payment_id,
                'amount_paid'      => $amount,
            ])->save();

            return;
        }

        PropertyPromotion::create([
            'user_id'          => $property->user_id,
            'aqar_id'          => $property->id,
            'price_vip_id'     => $package->id,
            'fawry_payment_id' => $payment?->id,
            'status'           => PropertyPromotion::STATUS_ACTIVE,
            'amount_paid'      => $amount,
            'duration_days'    => $durationDays,
            'started_at'       => $startedAt,
            'expires_at'       => $expiresAt,
        ]);
    }

    private function sendActivationSms(aqar $property, PriceVip $package): void
    {
        $phone = optional($property->user)->MOP;

        if (empty($phone)) {
            Log::warning('Promotion activation SMS skipped: user has no phone.', [
                'aqar_id' => $property->id,
                'user_id' => $property->user_id,
            ]);
            return;
        }

        try {
            $phone = SmsService::normalizeRecipient($phone);
            $message = sprintf(
                'تم الاشتراك في باقة %s وتم تمييز إعلانك لمدة %d يوم حتى %s. RightChoice',
                strip_tags((string) $package->name),
                (int) $package->duration_days,
                $property->vip_expires_at->format('Y-m-d H:i')
            );

            $result = $this->smsProvider->send($phone, $message);

            if (!$result->success) {
                Log::error('Promotion activation SMS failed.', [
                    'aqar_id' => $property->id,
                    'user_id' => $property->user_id,
                    'reason' => $result->failureReason,
                ]);
            }
        } catch (\Throwable $exception) {
            Log::error('Promotion activation SMS exception.', [
                'aqar_id' => $property->id,
                'user_id' => $property->user_id,
                'message' => $exception->getMessage(),
            ]);
        }
    }
}
