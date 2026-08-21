<?php

namespace App\Services;

use App\Contracts\SmsProviderInterface;
use App\Models\aqar;
use App\Models\PriceVip;
use Illuminate\Support\Facades\Log;

class PropertyPromotionService
{
    public function __construct(private SmsProviderInterface $smsProvider)
    {
    }

    public function activate(aqar $property, PriceVip $package, bool $sendSms = true): aqar
    {
        $startedAt = now();
        $expiresAt = $startedAt->copy()->addDays((int) $package->duration_days);

        $property->forceFill([
            'vip' => 1,
            'vip_price_id' => $package->id,
            'vip_started_at' => $startedAt,
            'vip_expires_at' => $expiresAt,
        ])->save();

        if ($sendSms) {
            $this->sendActivationSms($property, $package);
        }

        return $property->refresh();
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
