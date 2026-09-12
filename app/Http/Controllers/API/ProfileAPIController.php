<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\aqar;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Services\SmsService;

/**
 * Profile & Password management API.
 */
class ProfileAPIController extends AppBaseController
{
    // ...existing code...

    /**
     * GET /api/profile/phone-status
     * Check whether the authenticated user needs to add a phone number.
     */
    public function phoneStatus(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer|exists:users,id',
        ], [
            'user_id.required' => 'معرّف المستخدم مطلوب.',
            'user_id.integer' => 'معرّف المستخدم يجب أن يكون رقمًا صحيحًا.',
            'user_id.exists' => 'المستخدم المحدد غير موجود.',
        ]);

        if ($validator->fails()) {
            return $this->sendError(
                'خطأ في البيانات المدخلة.',
                422,
                $validator->errors()->toArray()
            );
        }

        $user = User::findOrFail($validator->validated()['user_id']);
        $hasPhone = trim((string) $user->MOP) !== '';

        return $this->sendResponse([
            'user_id' => $user->id,
            'has_phone' => $hasPhone,
            'requires_phone' => !$hasPhone,
        ], $hasPhone
            ? 'المستخدم لديه رقم هاتف مسجل.'
            : 'المستخدم ليس لديه رقم هاتف مسجل.'
        );
    }


    /**
     * POST /api/profile/phone/request-otp
     * Send an OTP to the new phone number before changing it.
     */
    public function requestPhoneChangeOtp(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer|exists:users,id',
            'phone' => [
                'required',
                'string',
                'regex:/^01[0125][0-9]{8}$/',
                Rule::unique('users', 'MOP')->ignore($request->user_id),
            ],
        ], $this->phoneChangeValidationMessages());

        if ($validator->fails()) {
            return $this->sendError(
                'خطأ في البيانات المدخلة.',
                422,
                $validator->errors()->toArray()
            );
        }
         if ((int) $request->user_id !== (int) $request->user()->id) {
            return $this->sendError('غير مسموح لك بتغيير رقم هاتف مستخدم آخر.', 403);
        }

        $otp = random_int(1000, 9999);
        $smsResponse = SmsService::sendOtp($request->phone, $otp);

        if ($smsResponse === false) {
            return $this->sendError('تعذر إرسال رمز التحقق. يرجى المحاولة مرة أخرى.', 500);
        }

        $user = User::findOrFail($request->user_id);
        $user->update([
            'phone_sms_otp' => $otp,
        ]);

        return $this->sendResponse([
            'user_id' => (int) $request->user_id,
            'phone' => $request->phone,
            'otp_sent' => true,
        ], 'تم إرسال رمز التحقق إلى رقم الهاتف الجديد.');
    }

    /**
     * POST /api/profile/phone/update
     * Verify the OTP and update the authenticated user's phone number.
     */
    public function updatePhone(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer|exists:users,id',
            'phone' => [
                'required',
                'string',
                'regex:/^01[0125][0-9]{8}$/',
                Rule::unique('users', 'MOP')->ignore($request->user_id),
            ],
            'otp' => 'required|digits:4',
        ], $this->phoneChangeValidationMessages());

        if ($validator->fails()) {
            return $this->sendError(
                'خطأ في البيانات المدخلة.',
                422,
                $validator->errors()->toArray()
            );
        }

        if ((int) $request->user_id !== (int) $request->user()->id) {
            return $this->sendError('غير مسموح لك بتغيير رقم هاتف مستخدم آخر.', 403);
        }

        $user = User::findOrFail($request->user_id);

        if (empty($user->phone_sms_otp)) {
            return $this->sendError(
                'لم يتم طلب رمز تحقق لهذا المستخدم.',
                422,
                ['otp' => ['اطلب رمز تحقق جديدًا ثم حاول مرة أخرى.']]
            );
        }

        if (!hash_equals((string) $user->phone_sms_otp, (string) $request->otp)) {
            return $this->sendError(
                'رمز التحقق غير صحيح.',
                422,
                ['otp' => ['رمز التحقق الذي أدخلته غير صحيح.']]
            );
        }

        $user->update([
            'MOP' => $request->phone,
            'phone_verfied_sms_status' => true,
            'phone_sms_otp' => null,
        ]);

        return $this->sendResponse([
            'user_id' => $user->id,
            'phone' => $user->MOP,
            'phone_verified' => true,
        ], 'تم تحديث رقم الهاتف والتحقق منه بنجاح.');
    }

    private function phoneChangeValidationMessages(): array
    {
        return [
            'user_id.required' => 'معرّف المستخدم مطلوب.',
            'user_id.integer' => 'معرّف المستخدم يجب أن يكون رقمًا صحيحًا.',
            'user_id.exists' => 'المستخدم المحدد غير موجود.',
            'phone.required' => 'رقم الهاتف الجديد مطلوب.',
            'phone.string' => 'رقم الهاتف الجديد يجب أن يكون نصًا.',
            'phone.regex' => 'رقم الهاتف يجب أن يكون رقم موبايل مصريًا صحيحًا مكونًا من 11 رقمًا.',
            'phone.unique' => 'رقم الهاتف مستخدم بالفعل في حساب آخر.',
            'otp.required' => 'رمز التحقق OTP مطلوب.',
            'otp.digits' => 'رمز التحقق OTP يجب أن يتكون من 4 أرقام.',
        ];
    }

    /**
     * POST /api/profile/full
     * عرض البيانات الشخصية الكاملة للمستخدم المسجّل مع pagination
     */
    public function fullProfile(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'per_page'        => 'nullable|integer|min:1|max:100',
            'ads_per_page'    => 'nullable|integer|min:1|max:100',
        ], [
            'per_page.integer'     => 'per_page يجب أن يكون رقماً صحيحاً',
            'per_page.min'         => 'per_page يجب أن يكون على الأقل 1',
            'per_page.max'         => 'per_page يجب ألا يتجاوز 100',
            'ads_per_page.integer' => 'ads_per_page يجب أن يكون رقماً صحيحاً',
            'ads_per_page.min'     => 'ads_per_page يجب أن يكون على الأقل 1',
            'ads_per_page.max'     => 'ads_per_page يجب ألا يتجاوز 100',
        ]);

        if ($validator->fails()) {
            return $this->sendError('خطأ في البيانات المدخلة', 422, $validator->errors()->toArray());
        }

        $user       = $request->user();
        $perPage    = $request->input('per_page', 15);
        $adsPerPage = $request->input('ads_per_page', 15);

        // البيانات الشخصية الكاملة
        $user->load([
            'companiess',
            'userpricing.pricing',
            'userpricin',
            'wishlist.aqarInfo',
            'notification',
        ]);

        // إعلانات المستخدم مع كل التفاصيل
        $ads = aqar::where('user_id', $user->id)
            ->with([
                'images',
                'aqarLocation',
                'governrateq',
                'districte',
                'subAreaa',
                'callTimes',
                'offerTypes',
                'categoryRel',
                'finishType',
                'mzaya',
                'propertyType',
            ])
            ->latest()
            ->paginate($adsPerPage);

        return $this->sendResponse([
            'personal_info' => [
                'id'                  => $user->id,
                'name'                => $user->name,
                'email'               => $user->email,
                'phone'               => $user->MOP,
                'age'                 => $user->AGE,
                'type'                => $user->TYPE,
                'type_label'          => $user->getUserType(),
                'status'              => $user->status,
                'status_label'        => $user->getStatus(),
                'job_title'           => $user->Job_title,
                'name_of_real_estate_developer'       => $user->name_of_real_estate_developer,
                'tax_card'            => $user->Tax_card,
                'commercial_register' => $user->Commercial_Register,
                'profile_image'       => $user->profile_image_url,
                'is_online'           => $user->isOnline(),
                'created_at'          => $user->created_at,
                'Job_title' => $user->Job_title,
                'Tax_card' => $user->Tax_card,
                'Commercial_Register' => $user->Commercial_Register,
                'MOP' => $user->MOP,
                'AGE' => $user->AGE,
                'TYPE' => $user->TYPE,
                'logo_real_estate_development_company' => $user->logo_real_estate_development_company,
                'email_verified_at' => $user->email_verified_at,
                'last_login_at' => $user->last_login_at,
                'updated_at' => $user->updated_at,
                'phone_verfied_sms_status' => $user->phone_verfied_sms_status,
                'isAdmin' => $user->isAdmin,
                'role_id' => $user->role_id,
                'invited_by' => $user->invited_by,
                'deleted_at' => $user->deleted_at,
                'updated_by' => $user->updated_by,
                'provider' => $user->provider,
                'provider_id' => $user->provider_id,
            ],
            'companies'             => $user->companiess,
            'current_package'       => $user->userpricin,
            'pricing_history'       => $user->userpricing,
            'notifications_count'   => $user->notification->count(),
            'ads'                   => $ads->toArray(),
        ], 'تم جلب البيانات الشخصية الكاملة بنجاح');
    }

    /**
     * GET /api/profile
     */
    public function show(Request $request): JsonResponse
    {
        $user = $request->user();

        return $this->sendResponse([
            'id'                  => $user->id,
            'name'                => $user->name,
            'email'               => $user->email,
            'phone'               => $user->MOP,
            'type'                => $user->TYPE,
            'age'                 => $user->AGE,
            'profile_image'       => $user->profile_image_url,
            'status'              => $user->status,
            'name_of_real_estate_developer'       => $user->name_of_real_estate_developer,
            'Job_title'           => $user->Job_title,
            'Tax_card'            => $user->Tax_card,
            'Commercial_Register' => $user->Commercial_Register,
            'MOP' => $user->MOP,
            'AGE' => $user->AGE,
            'TYPE' => $user->TYPE,
            'logo_real_estate_development_company' => $user->logo_real_estate_development_company,
            'email_verified_at' => $user->email_verified_at,
            'last_login_at' => $user->last_login_at,
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at,
            'phone_verfied_sms_status' => $user->phone_verfied_sms_status,
            'isAdmin' => $user->isAdmin,
            'role_id' => $user->role_id,
            'invited_by' => $user->invited_by,
            'deleted_at' => $user->deleted_at,
            'updated_by' => $user->updated_by,
            'provider' => $user->provider,
            'provider_id' => $user->provider_id,
        ], 'Profile retrieved successfully');
    }

    /**
     * POST /api/profile/update
     */
    public function update(Request $request): JsonResponse
    {
        $user = $request->user();

        if ($request->has('MOP') && (string) $request->MOP !== (string) $user->MOP) {
            return $this->sendError('لا يمكن تغيير رقم الهاتف من الملف الشخصي.', 422, [
                'MOP' => ['لا يمكن تغيير رقم الهاتف من الملف الشخصي.'],
            ]);
        }

        $validator = Validator::make($request->all(), [
            'name'                => 'required|max:255',
             'TYPE'                => 'nullable|integer',
            'name_of_real_estate_developer'       => ($request->TYPE == 3 ? 'required' : 'nullable'),
             'img'                 => 'nullable|image|mimes:jpeg,jpg,png,gif|max:5120',
            'logo_real_estate_development_company' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:5120',
        ], [
            'name.required'                => 'حقل الاسم مطلوب.',
            'name.max'                     => 'الاسم يجب ألا يتجاوز 255 حرفًا.',
            'email.required'               => 'حقل البريد الإلكتروني مطلوب.',
            'email.email'                  => 'صيغة البريد الإلكتروني غير صحيحة.',
            'email.unique'                 => 'البريد الإلكتروني مستخدم مسبقًا.',
             'TYPE.integer'                 => 'نوع المستخدم يجب أن يكون رقمًا صحيحًا.',
              'img.image'                    => 'الملف يجب أن يكون صورة.',
            'img.mimes'                    => 'الصورة يجب أن تكون من نوع: jpeg, jpg, png, gif.',
            'img.max'                      => 'حجم الصورة يجب ألا يتجاوز 5 ميجابايت.',
            'logo_real_estate_development_company.image' => 'لوجو الشركة يجب أن يكون صورة.',
            'logo_real_estate_development_company.mimes' => 'لوجو الشركة يجب أن يكون من نوع: jpeg, jpg, png, gif.',
            'logo_real_estate_development_company.max' => 'حجم لوجو الشركة يجب ألا يتجاوز 5 ميجابايت.',
        ]);

        if ($validator->fails()) {
            return $this->sendError('خطأ في البيانات المدخلة.', 422, $validator->errors());
        }

        $data = $request->only(['name', 'email', 'AGE', 'TYPE', 'name_of_real_estate_developer', 'Job_title', 'Tax_card', 'Commercial_Register']);

        if ($request->hasFile('logo_real_estate_development_company')) {
            $logoPath = _uploadFileWeb($request->file('logo_real_estate_development_company'), 'user/');

            if (empty($logoPath)) {
                return $this->sendError('تعذر رفع لوجو الشركة. يرجى المحاولة مرة أخرى.', 500);
            }

            // Assign the uploaded path explicitly because this field is not mass assignable.
            $user->logo_real_estate_development_company = $logoPath;
        }

        if ($request->hasFile('img')) {
            $data['profile_image'] = _uploadFileWeb($request->img, 'user/');
        }

        $user->update($data);

        return $this->sendResponse($user->fresh()->only([
            'id', 'name', 'email', 'MOP', 'AGE', 'TYPE', 'profile_image',
            'logo_real_estate_development_company',
            'name_of_real_estate_developer', 'Job_title', 'Tax_card', 'Commercial_Register',
        ]), 'Profile updated successfully');
    }

    /**
     * POST /api/profile/change-password
     */
    public function changePassword(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required|min:6',
            'password'     => 'required|confirmed|min:6',
        ], [
            'old_password.required' => 'حقل كلمة المرور الحالية مطلوب.',
            'old_password.min'      => 'كلمة المرور الحالية يجب أن تكون 6 أحرف على الأقل.',
            'password.required'     => 'حقل كلمة المرور الجديدة مطلوب.',
            'password.confirmed'    => 'تأكيد كلمة المرور الجديدة غير متطابق.',
            'password.min'          => 'كلمة المرور الجديدة يجب أن تكون 6 أحرف على الأقل.',
        ]);

        if ($validator->fails()) {
            return $this->sendError('خطأ في البيانات المدخلة.', 422, $validator->errors());
        }

        $user = $request->user();

        if (!Hash::check($request->old_password, $user->password)) {
            return $this->sendError('كلمة المرور الحالية غير صحيحة.', 400);
        }

        $user->update(['password' => Hash::make($request->password)]);

        return $this->sendSuccess('Password changed successfully');
    }
}
