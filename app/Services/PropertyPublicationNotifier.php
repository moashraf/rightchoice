<?php

namespace App\Services;

use App\Models\aqar;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Throwable;

class PropertyPublicationNotifier
{
    public function notify(aqar $aqar): void
    {
        if ((int) $aqar->status !== 1 || $aqar->trashed()) {
            return;
        }

        $user = User::find($aqar->user_id);
        if (!$user) {
            return;
        }

        $title = 'تم نشر إعلانك';
        $message = "وافق الأدمن على إعلانك رقم {$aqar->id} وأصبح منشورًا الآن.";

        try {
            Notification::create([
                'user_id' => $user->id,
                'type' => 0,
                'title' => $title,
                'message' => $message,
                'title_en' => 'Your listing is published',
                'message_en' => "Your listing #{$aqar->id} has been approved and is now published.",
                'status' => 0,
            ]);
        } catch (Throwable $exception) {
            Log::warning('Property publication notification could not be saved.', [
                'aqar_id' => $aqar->id,
                'user_id' => $user->id,
                'error' => $exception->getMessage(),
            ]);
        }

        try {
            app(FcmNotificationService::class)->sendToUser(
                $user,
                $title,
                $message,
                ['type' => 'property_published', 'aqar_id' => (string) $aqar->id]
            );
        } catch (Throwable $exception) {
            Log::warning('Property publication push could not be sent.', [
                'aqar_id' => $aqar->id,
                'user_id' => $user->id,
                'error' => $exception->getMessage(),
            ]);
        }
    }
}
