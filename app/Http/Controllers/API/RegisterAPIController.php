<?php

namespace App\Http\Controllers\API;

use App\Http\Middleware\TrackApiAccess;
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
     * Return the user account types available during registration.
     * GET /api/user-types
     */
    public function userTypes(): JsonResponse
    {
        $userTypes = [
            'حساب شخصي' => 1,
            'مطور عقاري' => 3,
        ];

        return $this->sendResponse($userTypes, 'User types retrieved successfully.');
    }

    /**
     * Register a new user and send OTP to their phone.
     * POST /api/register
     *
     * @bodyParam name              string required  الاسم الكامل (3-90 حرف)
     * @bodyParam email             string required  البريد الإلكتروني (فريد)
     * @bodyParam MOP               string required  رقم الهاتف 10-11 رقم (فريد)
     * @bodyParam password          string required  كلمة المرور
     * @bodyParam password_confirmation string required  تأكيد كلمة المرور
     * @bodyParam TYPE              int    required  نوع المستخدم (1=حساب شخصي، 3=مطور عقاري)
     * @bodyParam AGE               string optional  العمر
     * @bodyParam Commercial_Register string optional السجل التجاري
     * @bodyParam name_of_real_estate_developer string required_if:TYPE,3 اسم شركة التطوير العقاري
     * @bodyParam company_logo      file   required_if:TYPE,3 لوجو شركة التطوير العقاري
     * @bodyParam Tax_card          string optional  البطاقة الضريبية
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
//            'TYPE'      => 'required|integer|in:1,3',
            'name_of_real_estate_developer' => 'required_if:TYPE,3|string|max:255',
            'company_logo' => 'required_if:TYPE,3|image|mimes:jpeg,jpg,png,webp|max:5120',
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
            'TYPE.required'       => 'حقل نوع المستخدم مطلوب.',
            'TYPE.integer'        => 'نوع المستخدم يجب أن يكون رقمًا صحيحًا.',
            'TYPE.in'             => 'نوع المستخدم يجب أن يكون حسابًا شخصيًا أو مطورًا عقاريًا.',
            'name_of_real_estate_developer.required_if' => 'اسم شركة التطوير العقاري مطلوب.',
            'name_of_real_estate_developer.string' => 'اسم شركة التطوير العقاري يجب أن يكون نصًا.',
            'name_of_real_estate_developer.max' => 'اسم شركة التطوير العقاري يجب ألا يتجاوز 255 حرفًا.',
            'company_logo.required_if' => 'لوجو شركة التطوير العقاري مطلوب.',
            'company_logo.image'  => 'لوجو شركة التطوير العقاري يجب أن يكون صورة.',
            'company_logo.mimes'  => 'اللوجو يجب أن يكون من نوع: jpeg, jpg, png أو webp.',
            'company_logo.max'    => 'حجم اللوجو يجب ألا يتجاوز 5 ميجابايت.',
        ]);

        if ($validator->fails()) {
            return $this->sendError('خطأ في البيانات المدخلة.', 422, $validator->errors());
        }

        $profileImage = null;

        if ($request->hasFile('company_logo')) {
            $profileImage = _uploadFileWeb($request->file('company_logo'), 'user/');

            if (!$profileImage) {
                return $this->sendError('تعذر رفع لوجو شركة التطوير العقاري.', 500);
            }
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
            'name_of_real_estate_developer' => $request->name_of_real_estate_developer,
            'profile_image'       => $profileImage,
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
                'name_of_real_estate_developer' => $user->name_of_real_estate_developer,
                'company_logo' => $user->profile_image ? url($user->profile_image) : null,
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

        $newToken = $user->createToken('auth_token');
        TrackApiAccess::stamp($newToken->accessToken, $request);
        $token = $newToken->plainTextToken;

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

