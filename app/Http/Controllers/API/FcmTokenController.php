<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Models\FcmToken;
use App\Services\FcmNotificationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Throwable;

class FcmTokenController extends AppBaseController
{
    public function store(
        Request $request,
        FcmNotificationService $fcmService
    ): JsonResponse {
        abort_unless((int) $request->user()->status === 1, 403, 'Your account is inactive');

        $validator = Validator::make($request->all(), [
            'token' => ['required', 'string', 'max:512', 'regex:/\A[\x21-\x7E]+\z/'],
        ], [
            'token.required' => 'The device FCM token is required.',
            'token.string' => 'The device FCM token must be a string.',
            'token.max' => 'The device FCM token must not exceed 512 characters.',
            'token.regex' => 'The device FCM token format is invalid.',
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

        // One device token has one owner, including after account switching.
        FcmToken::upsert([
            ['token' => $data['token'], 'user_id' => $user->id,
                'created_at' => now(), 'updated_at' => now()],
        ], ['token'], ['user_id', 'updated_at']);

        try {
            $result = $fcmService->sendToToken(
                $user,
                $data['token'],
                'RightChoice',
                'مرحبًا بك في RightChoice',
                [
                    'type' => 'welcome',
                    'screen' => 'home',
                ]
            );

            Log::info('Login welcome FCM notification processed.', [
                'user_id' => $user->id,
                'sent_count' => $result['sent'],
                'removed_token_count' => $result['removed'],
            ]);
        } catch (Throwable $exception) {
            // FCM availability must not prevent login/device-token registration.
            Log::warning('Login welcome FCM notification failed.', [
                'user_id' => $user->id,
                'exception' => get_class($exception),
                'error' => $exception->getMessage(),
            ]);
        }

        return $this->sendSuccess('Device token registered and welcome notification processed.');
    }

    public function destroy(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'token' => ['required', 'string', 'max:512'],
        ], [
            'token.required' => 'The device FCM token is required.',
            'token.string' => 'The device FCM token must be a string.',
            'token.max' => 'The device FCM token must not exceed 512 characters.',
        ]);

        if ($validator->fails()) {
            return $this->sendError(
                'Validation failed.',
                422,
                $validator->errors()->toArray()
            );
        }

        $data = $validator->validated();
        $request->user()->fcmTokens()->where('token', $data['token'])->delete();

        return $this->sendSuccess('Device token removed.');
    }
}
