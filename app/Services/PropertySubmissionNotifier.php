<?php

namespace App\Services;

use App\Models\aqar;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Throwable;

class PropertySubmissionNotifier
{
    public function notify(aqar $aqar): void
    {
        $user = User::find($aqar->user_id);
        if (!$user) {
            return;
        }

        $title = 'تم إضافة عقارك بنجاح';
        $message = 'تم إضافة عقارك بنجاح، وجارٍ مراجعته.';

        try {
            Notification::create([
                'user_id' => $user->id,
                'type' => 0,
                'title' => $title,
                'message' => $message,
                'status' => 0,
            ]);
        } catch (Throwable $exception) {
            Log::warning('Property submission notification could not be saved.', [
                'user_id' => $user->id,
                'aqar_id' => $aqar->id,
                'error' => $exception->getMessage(),
            ]);
        }

        try {
            app(FcmNotificationService::class)->sendToUser(
                $user,
                $title,
                $message,
                ['type' => 'property_submitted', 'aqar_id' => (string) $aqar->id]
            );
        } catch (Throwable $exception) {
            Log::warning('Property submission push could not be sent.', [
                'user_id' => $user->id,
                'aqar_id' => $aqar->id,
                'error' => $exception->getMessage(),
            ]);
        }
    }
}
