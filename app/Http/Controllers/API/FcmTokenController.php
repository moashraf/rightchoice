<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Models\FcmToken;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FcmTokenController extends AppBaseController
{
    public function store(Request $request): JsonResponse
    {
        abort_unless((int) $request->user()->status === 1, 403, 'Your account is inactive');
        $data = $request->validate(['token' => ['required', 'string', 'max:512', 'regex:/\A[\x21-\x7E]+\z/']]);

        // One device token has one owner, including after account switching.
        FcmToken::upsert([
            ['token' => $data['token'], 'user_id' => $request->user()->id,
                'created_at' => now(), 'updated_at' => now()],
        ], ['token'], ['user_id', 'updated_at']);

        return $this->sendSuccess('Device token registered.');
    }

    public function destroy(Request $request): JsonResponse
    {
        $data = $request->validate(['token' => 'required|string|max:512']);
        $request->user()->fcmTokens()->where('token', $data['token'])->delete();

        return $this->sendSuccess('Device token removed.');
    }
}
