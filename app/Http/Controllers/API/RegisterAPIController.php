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
 * Class RegisterAPIController
 * @package App\Http\Controllers\API
 *
 * Handles user registration and phone OTP verification via API.
 */
class RegisterAPIController extends AppBaseController
{
    /**
     * Register a new user and send OTP to their phone.
     * POST /api/register
     *
     * @bodyParam name              string required  الاسم الكامل (3-90 حرف)
     * @bodyParam email             string required  البريد الإلكتروني (فريد)
     * @bodyParam MOP               string required  رقم الهاتف 10-11 رقم (فريد)
     * @bodyParam password          string required  كلمة المرور
     * @bodyParam password_confirmation string required  تأكيد كلمة المرور
     * @bodyParam TYPE              int    optional  نوع المستخدم (1=مشتري, 2=بائع, 3=مطور, 4=شركة)
     * @bodyParam AGE               string optional  العمر
     * @bodyParam Commercial_Register string optional اسم الشركة / السجل التجاري
     * @bodyParam Tax_card          string optional  البطاقة الضريبية
     * @bodyParam Employee_Name     string optional  اسم الموظف المسؤول
     * @bodyParam Job_title         string optional  المسمى الوظيفي
     * @bodyParam invited_by        string optional  كود الدعوة
     */
    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|min:3|max:90',
            'email'    => 'required|email|max:90|unique:users',
            'MOP'      => 'required|min:10|max:11|unique:users',
            'password' => 'required|confirmed|min:6|max:255',
        ], [
            'name.required'      => 'حقل الاسم مطلوب.',
            'name.min'           => 'الاسم يجب أن يكون 3 أحرف على الأقل.',
            'name.max'           => 'الاسم يجب ألا يتجاوز 90 حرفًا.',
            'email.required'     => 'حقل البريد الإلكتروني مطلوب.',
            'email.email'        => 'صيغة البريد الإلكتروني غير صحيحة.',
            'email.unique'       => 'البريد الإلكتروني مستخدم مسبقًا.',
            'MOP.required'       => 'حقل رقم الهاتف مطلوب.',
            'MOP.min'            => 'رقم الهاتف يجب أن يكون 10 أرقام على الأقل.',
            'MOP.max'            => 'رقم الهاتف يجب ألا يتجاوز 11 رقمًا.',
            'MOP.unique'         => 'رقم الهاتف مستخدم مسبقًا.',
            'password.required'  => 'حقل كلمة المرور مطلوب.',
            'password.confirmed' => 'تأكيد كلمة المرور غير متطابق.',
            'password.min'       => 'كلمة المرور يجب أن تكون 6 أحرف على الأقل.',
        ]);

        if ($validator->fails()) {
            return $this->sendError('خطأ في البيانات المدخلة.', 422, $validator->errors());
        }

        $otpCode = random_int(1000, 9999);

        $user = User::create([
            'name'                => $request->name,
            'email'               => $request->email,
            'MOP'                 => $request->MOP,
            'password'            => Hash::make($request->password),
            'phone_sms_otp'       => $otpCode,
            'TYPE'                => $request->TYPE,
            'AGE'                 => $request->AGE,
            'Commercial_Register' => $request->Commercial_Register,
            'Tax_card'            => $request->Tax_card,
            'Employee_Name'       => $request->Employee_Name,
            'Job_title'           => $request->Job_title,
            'invited_by'          => $request->invited_by,
        ]);

        // Send OTP SMS to the user's phone
        SmsService::sendOtp($request->MOP, $otpCode);

        $result = [
            'user' => [
                'id'    => $user->id,
                'name'  => $user->name,
                'email' => $user->email,
                'phone' => $user->MOP,
                'type'  => $user->TYPE,
            ],
            'otp_sent' => true,
        ];

        return $this->sendResponse($result, 'User registered successfully. Please verify your phone.');
    }

    /**
     * Verify the phone OTP code and activate the account.
     * POST /api/verify-otp
     *
     * @bodyParam user_id int    required  معرف المستخدم
     * @bodyParam otp     string required  رمز التحقق OTP
     */
    public function verifyOtp(Request $request): JsonResponse
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

        $user->update([
            'phone_verfied_sms_status' => true,
            'status'                   => 1,
        ]);

        // Create Sanctum token for authenticated requests
            $token = $user->createToken('auth_token')->plainTextToken;

        $result = [
            'user' => [
                'id'     => $user->id,
                'name'   => $user->name,
                'email'  => $user->email,
                'phone'  => $user->MOP,
                'type'   => $user->TYPE,
                'status' => $user->status,
            ],
            'token' => $token,
        ];

        return $this->sendResponse($result, 'Phone verified and account activated successfully');
    }

    /**
     * Resend OTP code to the user's phone.
     * POST /api/resend-otp
     *
     * @bodyParam user_id int required  معرف المستخدم
     */
    public function resendOtp(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer|exists:users,id',
        ], [
            'user_id.required' => 'حقل معرف المستخدم مطلوب.',
            'user_id.integer'  => 'معرف المستخدم يجب أن يكون رقمًا صحيحًا.',
            'user_id.exists'   => 'المستخدم غير موجود في النظام.',
        ]);

        if ($validator->fails()) {
            return $this->sendError('خطأ في البيانات المدخلة.', 422, $validator->errors());
        }

        $user = User::find($request->user_id);

        if ($user->phone_verfied_sms_status == 1) {
            return $this->sendError('رقم الهاتف مفعّل مسبقًا.', 400);
        }

        $otpCode = random_int(1000, 9999);
        $user->update(['phone_sms_otp' => $otpCode]);

        SmsService::sendOtp($user->MOP, $otpCode);

        return $this->sendSuccess('OTP code resent successfully');
    }
}

