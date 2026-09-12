<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Services\FcmNotificationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Throwable;

class FcmSendController extends AppBaseController
{
    public function store(
        Request $request,
        FcmNotificationService $fcmService
    ): JsonResponse {
        $validator = Validator::make($request->all(), [
            'token' => ['required', 'string', 'max:512', 'regex:/\A[\x21-\x7E]+\z/'],
            'message' => ['required', 'string', 'max:2000'],
            'title' => ['sometimes', 'string', 'max:255'],
            'data' => ['sometimes', 'array'],
            'data.*' => ['string', 'max:1000'],
        ], [
            'token.required' => 'The device FCM token is required.',
            'token.string' => 'The device FCM token must be a string.',
            'token.max' => 'The device FCM token must not exceed 512 characters.',
            'token.regex' => 'The device FCM token format is invalid.',
            'message.required' => 'The notification message is required.',
            'message.string' => 'The notification message must be a string.',
            'message.max' => 'The notification message must not exceed 2000 characters.',
            'title.string' => 'The notification title must be a string.',
            'title.max' => 'The notification title must not exceed 255 characters.',
            'data.array' => 'The notification data must be an object.',
            'data.*.string' => 'Every notification data value must be a string.',
            'data.*.max' => 'Every notification data value must not exceed 1000 characters.',
        ]);

        if ($validator->fails()) {
            return $this->sendError(
                'Validation failed.',
                422,
                $validator->errors()->toArray()
            );
        }

        $data = $validator->validated();
        $user = $request->user();

        if (!$user->fcmTokens()->where('token', $data['token'])->exists()) {
            return $this->sendError(
                'The device token is not registered to the authenticated user.',
                404
            );
        }

        try {
            $result = $fcmService->sendToToken(
                $user,
                $data['token'],
                $data['title'] ?? 'RightChoice',
                $data['message'],
                $data['data'] ?? []
            );

            Log::info('FCM device notification sent through API.', [
                'user_id' => $user->id,
                'sent_count' => $result['sent'],
                'removed_token_count' => $result['removed'],
            ]);

            return $this->sendResponse($result, 'Notification processed successfully.');
        } catch (Throwable $exception) {
            Log::error('FCM device notification API failed.', [
                'user_id' => $user->id,
                'exception' => get_class($exception),
                'error' => $exception->getMessage(),
            ]);

            return $this->sendError(
                'The notification could not be sent. Please try again later.',
                503
            );
        }
    }
}
