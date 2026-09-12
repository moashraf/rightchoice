<?php

namespace App\Services;

use App\Models\FcmToken;
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
            $deviceResult = $this->sendToDevice($device, $title, $body, $data);
            $result['sent'] += $deviceResult['sent'];
            $result['removed'] += $deviceResult['removed'];
        }

        return $result;
    }

    public function sendToToken(
        User $user,
        string $token,
        string $title,
        string $body,
        array $data = []
    ): array {
        $result = ['sent' => 0, 'removed' => 0];
        if ($user->trashed() || (int) $user->status !== 1) {
            return $result;
        }

        $device = $user->fcmTokens()->where('token', $token)->first();
        if (!$device) {
            return $result;
        }

        return $this->sendToDevice($device, $title, $body, $data);
    }

    private function sendToDevice(
        FcmToken $device,
        string $title,
        string $body,
        array $data
    ): array {
        $message = CloudMessage::withTarget('token', $device->token)
            ->withNotification(Notification::create($title, $body))
            ->withData($data);

        try {
            $this->messaging->send($message);

            return ['sent' => 1, 'removed' => 0];
        } catch (MessagingException $exception) {
            $details = $exception->errors()['error']['details'] ?? [];
            $unregistered = collect($details)->contains(fn ($detail) =>
                ($detail['@type'] ?? '') === 'type.googleapis.com/google.firebase.fcm.v1.FcmError'
                && ($detail['errorCode'] ?? '') === 'UNREGISTERED'
            );

            if (!$unregistered) {
                // Payload, credentials, quota and network errors do not invalidate a device.
                throw $exception;
            }

            $removed = FcmToken::where('id', $device->id)
                ->where('token', $device->token)
                ->delete();

            return ['sent' => 0, 'removed' => $removed];
        }
    }
}
