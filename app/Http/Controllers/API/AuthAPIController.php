<?php

namespace App\Http\Controllers\API;

use App\Http\Middleware\TrackApiAccess;
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
     *
     * Accepts either email+password or phone/MOP+password.
     * When a phone number is sent, email is not required and its validation is skipped.
     */
    public function login(Request $request)
    {
        $phone = $this->extractLoginPhone($request);
        $loginByPhone = $phone !== '';

        $rules = [
            'password' => 'required|string|min:6',
        ];

        $messages = [
            'password.required' => 'حقل كلمة المرور مطلوب.',
            'password.string'   => 'كلمة المرور يجب أن تكون نصاً.',
            'password.min'      => 'كلمة المرور يجب أن تكون 6 أحرف على الأقل.',
            'email.required'    => 'حقل البريد الإلكتروني مطلوب.',
            'email.email'       => 'صيغة البريد الإلكتروني غير صحيحة.',
            'phone.required'    => 'حقل رقم الهاتف مطلوب.',
            'phone.min'         => 'رقم الهاتف يجب أن يكون 10 أرقام على الأقل.',
            'phone.max'         => 'رقم الهاتف يجب ألا يتجاوز 15 رقمًا.',
            'MOP.required'      => 'حقل رقم الهاتف مطلوب.',
            'MOP.min'           => 'رقم الهاتف يجب أن يكون 10 أرقام على الأقل.',
            'MOP.max'           => 'رقم الهاتف يجب ألا يتجاوز 15 رقمًا.',
        ];

        if ($loginByPhone) {
            $phoneField = $request->filled('phone') ? 'phone' : ($request->filled('MOP') ? 'MOP' : 'email');
            $rules[$phoneField] = 'required|string|min:10|max:15';
        } else {
            $rules['email'] = 'required|email';
        }

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return $this->sendError('خطأ في البيانات المدخلة.', 422, $validator->errors());
        }

        $user = $loginByPhone
            ? $this->findUserByPhone($phone)
            : User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return $this->sendError('Invalid credentials', 401);
        }

        if ($user->status != 1) {
            return $this->sendError('Your account is inactive', 403);
        }
        $newToken = $user->createToken('auth_token');
        TrackApiAccess::stamp($newToken->accessToken, $request);
        $token = $newToken->plainTextToken;


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
     * Phone from dedicated fields, or from email when the value is a number not an address.
     */
    private function extractLoginPhone(Request $request): string
    {
        foreach (['phone', 'MOP'] as $field) {
            $value = trim((string) $request->input($field, ''));
            if ($value !== '') {
                return $value;
            }
        }

        $email = trim((string) $request->input('email', ''));
        if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL) && preg_match('/^[0-9+\s]+$/', $email)) {
            return $email;
        }

        return '';
    }

    private function findUserByPhone(string $phone): ?User
    {
        $candidates = array_values(array_unique(array_filter([
            $phone,
            $this->normalizePhone($phone),
        ])));

        return User::whereIn('MOP', $candidates)->first();
    }

    private function normalizePhone(string $phone): string
    {
        $phone = trim($phone);
        $phone = str_replace(
            ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'],
            ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'],
            $phone
        );
        $phone = preg_replace('/[^0-9+]/', '', $phone) ?? $phone;

        if (str_starts_with($phone, '0020')) {
            return '0' . substr($phone, 4);
        }

        if (str_starts_with($phone, '+20')) {
            return '0' . substr($phone, 3);
        }

        if (str_starts_with($phone, '20') && strlen($phone) >= 12) {
            return '0' . substr($phone, 2);
        }

        return $phone;
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
