<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;

/**
 * Class AuthAPIController
 * @package App\Http\Controllers\API
 */
class AuthAPIController extends AppBaseController
{
    /**
     * Login user and create token
     * POST /api/login
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required|string|min:6',
        ], [
            'email.required'    => 'حقل البريد الإلكتروني مطلوب.',
            'email.email'       => 'صيغة البريد الإلكتروني غير صحيحة.',
            'password.required' => 'حقل كلمة المرور مطلوب.',
            'password.string'   => 'كلمة المرور يجب أن تكون نصاً.',
            'password.min'      => 'كلمة المرور يجب أن تكون 6 أحرف على الأقل.',
        ]);

        if ($validator->fails()) {
            return $this->sendError('خطأ في البيانات المدخلة.', 422, $validator->errors());
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return $this->sendError('Invalid credentials', 401);
        }

        if ($user->status != 1) {
            return $this->sendError('Your account is inactive', 403);
        }
        $token = $user->createToken('auth_token')->plainTextToken;


        $result = [
            'user' => [
                'id'      => $user->id,
                'name'    => $user->name,
                'email'   => $user->email,
                'phone'   => $user->MOP ?? null,
                'type'    => $user->TYPE ?? null,
                'isAdmin' => $user->isAdmin ?? null,
                'status'  => $user->status,
            ],
            'token' => $token,
        ];

        return $this->sendResponse($result, 'User logged in successfully');
    }

    /**
     * Logout user
     * POST /api/logout
     */
    public function logout(Request $request)
    {
        // Revoke Sanctum token if authenticated
        if ($request->user() && Schema::hasTable('personal_access_tokens')) {
            $request->user()->currentAccessToken()->delete();
        }

        return $this->sendSuccess('User logged out successfully');
    }
}
