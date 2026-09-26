<?php

namespace App\Services;

use App\Enums\PaymentStatusEnum;
use App\Models\FawryPayment;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class PackageSubscriptionNotifier
{
    private const EVENT_NOTIFIED = 'package_subscription_notified';

    public function notify(FawryPayment $payment): void
    {
        if ($payment->paymentStatus !== PaymentStatusEnum::PAID) {
            return;
        }

        $title = 'تم الاشتراك في الباقة';
        $message = 'تم الاشتراك في الباقة وجارٍ مراجعة البيانات.';

        try {
            $user = DB::transaction(function () use ($payment, $title, $message) {
                $lockedPayment = FawryPayment::query()->lockForUpdate()->find($payment->id);
                if (!$lockedPayment || $lockedPayment->paymentStatus !== PaymentStatusEnum::PAID) {
                    return null;
                }

                if ($lockedPayment->statusLogs()->where('event_type', self::EVENT_NOTIFIED)->exists()) {
                    return null;
                }

                $user = User::find($lockedPayment->user_id);
                if (!$user) {
                    return null;
                }

                Notification::create([
                    'user_id' => $user->id,
                    'type' => 0,
                    'title' => $title,
                    'message' => $message,
                    'title_en' => 'Package subscription received',
                    'message_en' => 'Your package subscription was received. Your details are being reviewed.',
                    'status' => 0,
                ]);

                $lockedPayment->logStatusChange(
                    self::EVENT_NOTIFIED,
                    $lockedPayment->paymentStatus,
                    $lockedPayment->paymentStatus,
                    $message
                );

                return $user;
            });
        } catch (Throwable $exception) {
            Log::warning('Package subscription notification could not be saved.', [
                'payment_id' => $payment->id,
                'error' => $exception->getMessage(),
            ]);
            return;
        }

        if (!$user) {
            return;
        }

        try {
            app(FcmNotificationService::class)->sendToUser(
                $user,
                $title,
                $message,
                ['type' => 'package_subscription', 'payment_id' => (string) $payment->id]
            );
        } catch (Throwable $exception) {
            Log::warning('Package subscription push could not be sent.', [
                'payment_id' => $payment->id,
                'error' => $exception->getMessage(),
            ]);
        }
    }
}
