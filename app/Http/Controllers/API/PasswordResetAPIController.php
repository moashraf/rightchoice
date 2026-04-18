<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Services\SmsService;

/**
 * Phone-based Password Reset API.
 */
class PasswordResetAPIController extends AppBaseController
{
    /**
     * Request password reset OTP.
     * POST /api/password/request-otp
     */
    public function requestOtp(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string|min:10|max:11',
        ], [
            'phone.required' => 'حقل رقم الهاتف مطلوب.',
            'phone.string'   => 'رقم الهاتف يجب أن يكون نصاً.',
            'phone.min'      => 'رقم الهاتف يجب أن يكون 10 أرقام على الأقل.',
            'phone.max'      => 'رقم الهاتف يجب ألا يتجاوز 11 رقمًا.',
        ]);

        if ($validator->fails()) {
            return $this->sendError('خطأ في البيانات المدخلة.', 422, $validator->errors());
        }

        $user = User::where('MOP', $request->phone)->first();

        if (!$user) {
            return $this->sendError('لا يوجد مستخدم بهذا الرقم.', 404);
        }

        $otpCode = random_int(1000, 9999);
        $user->update(['phone_sms_otp' => $otpCode]);

        SmsService::sendOtp($user->MOP, $otpCode);

        return $this->sendResponse([
            'user_id'  => $user->id,
            'otp_sent' => true,
        ], 'OTP sent to your phone');
    }

    /**
     * Verify the reset OTP.
     * POST /api/password/verify-otp
     */
    public function verifyResetOtp(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer|exists:users,id',
            'otp'     => 'required|string',
        ], [
            'user_id.required' => 'حقل معرف المستخدم مطلوب.',
            'user_id.integer'  => 'معرف المستخدم يجب أن يكون رقمًا صحيحًا.',
            'user_id.exists'   => 'المستخدم غير موجود في النظام.',
            'otp.required'     => 'حقل رمز التحقق OTP مطلوب.',
        ]);

        if ($validator->fails()) {
            return $this->sendError('خطأ في البيانات المدخلة.', 422, $validator->errors());
        }

        $user = User::find($request->user_id);

        if ($user->phone_sms_otp != $request->otp) {
            return $this->sendError('رمز التحقق غير صحيح.', 400);
        }

        return $this->sendSuccess('تم التحقق من الرمز بنجاح.');
    }

    /**
     * Reset the password after OTP verification.
     * POST /api/password/reset
     */
    public function resetPassword(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'phone'    => 'required|string|min:10|max:11',
            'otp'      => 'required|string',
            'password' => 'required|min:6',
        ], [
            'phone.required'    => 'حقل رقم الهاتف مطلوب.',
            'phone.min'         => 'رقم الهاتف يجب أن يكون 10 أرقام على الأقل.',
            'phone.max'         => 'رقم الهاتف يجب ألا يتجاوز 11 رقمًا.',
            'otp.required'      => 'حقل رمز التحقق مطلوب.',
            'password.required' => 'حقل كلمة المرور مطلوب.',
            'password.min'      => 'كلمة المرور يجب أن تكون 6 أحرف على الأقل.',
        ]);

        if ($validator->fails()) {
            return $this->sendError('خطأ في البيانات المدخلة.', 422, $validator->errors());
        }

        $user = User::where('MOP', $request->phone)->first();

        if (!$user) {
            return $this->sendError('لا يوجد مستخدم بهذا الرقم.', 404);
        }

        if ($user->phone_sms_otp != $request->otp) {
            return $this->sendError('رمز التحقق غير صحيح.', 400);
        }

        $user->update(['password' => Hash::make($request->password)]);

        return $this->sendSuccess('تم تغيير كلمة المرور بنجاح.');
    }
}

