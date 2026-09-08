<?php

namespace App\Services;

use App\Models\User;
use Kreait\Firebase\Contract\Messaging;
use Kreait\Firebase\Exception\MessagingException;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class FcmNotificationService
{
    public function __construct(private Messaging $messaging)
    {
    }

    public function sendToUser(User $user, string $title, string $body, array $data = []): array
    {
        $result = ['sent' => 0, 'removed' => 0];
        if ($user->trashed() || (int) $user->status !== 1) {
            return $result;
        }

        foreach ($user->fcmTokens()->get() as $device) {
            $message = CloudMessage::withTarget('token', $device->token)
                ->withNotification(Notification::create($title, $body))
                ->withData($data);
            try {
                $this->messaging->send($message);
                $result['sent']++;
            } catch (MessagingException $e) {
                $details = $e->errors()['error']['details'] ?? [];
                $unregistered = collect($details)->contains(fn ($detail) =>
                    ($detail['@type'] ?? '') === 'type.googleapis.com/google.firebase.fcm.v1.FcmError'
                    && ($detail['errorCode'] ?? '') === 'UNREGISTERED');
                if (!$unregistered) {
                    // Payload, credentials, quota and network errors do not invalidate a device.
                    throw $e;
                }
                $result['removed'] += $user->fcmTokens()->where('id', $device->id)
                    ->where('token', $device->token)->delete();
            }
        }

        return $result;
    }
}
