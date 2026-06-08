<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\SmsService;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Laravel\Fortify\Contracts\FailedPasswordResetLinkRequestResponse;
use Laravel\Fortify\Contracts\SuccessfulPasswordResetLinkRequestResponse;
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;
class CustomPasswordResetLinkController extends Controller
{
    public function store(Request $request): Responsable
    {
        $request->validate([
            'email' => ['required', 'string', 'max:255'],
        ]);

        $value = trim($request->input('email'));

        $user = $this->findUserByEmailOrPhone($value);

        if (!$user || empty($user->email)) {
            return app(FailedPasswordResetLinkRequestResponse::class, [
                'status' => Password::INVALID_USER,
            ]);
        }

        $resetPasswordLink = null;

        ResetPasswordNotification::createUrlUsing(function ($notifiable, string $token) use (&$resetPasswordLink ,$user) {
            $resetPasswordLink = route('password.reset', [
                'token' => $token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ]);
            SmsService::sendOtp($user->MOP, $resetPasswordLink);

            return $resetPasswordLink;
        });

        $status = $this->broker()->sendResetLink([
            'email' => $user->email,
        ]);

        // هنا معاك لينك الريسيت في متغير
        // استخدمه زي ما تحب
        // logger($resetPasswordLink);

        return $status == Password::RESET_LINK_SENT
            ? app(SuccessfulPasswordResetLinkRequestResponse::class, ['status' => $status])
            : app(FailedPasswordResetLinkRequestResponse::class, ['status' => $status]);
    }

//    public function store2(Request $request): Responsable
//    {
//        $request->validate([
//            'email' => ['required', 'string', 'max:255'],
//        ], [
//            'email.required' => 'Please enter your email address or phone number.',
//        ]);
//
//        $value = trim($request->input('email'));
//
//        $user = $this->findUserByEmailOrPhone($value);
//
//        /*
//         * مهم أمنيًا:
//         * لا تظهر للمستخدم هل الإيميل/الموبايل موجود ولا لا.
//         * رجّع نفس رسالة النجاح لتجنب كشف الحسابات.
//         */
//        if (!$user || empty($user->email)) {
//            return app(SuccessfulPasswordResetLinkRequestResponse::class, [
//                'status' => Password::RESET_LINK_SENT,
//            ]);
//        }
//
//
//        $status = Password::broker(config('fortify.passwords'))->sendResetLink([
//            'email' => $user->email,
//        ]);
//
//        return $status == Password::RESET_LINK_SENT
//            ? app(SuccessfulPasswordResetLinkRequestResponse::class, ['status' => $status])
//            : app(FailedPasswordResetLinkRequestResponse::class, ['status' => $status]);
//    }

    private function findUserByEmailOrPhone(string $value): ?User
    {
        if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return User::where('email', Str::lower($value))->first();
        }

        $phone = $this->normalizePhone($value);

        /*
         * عدّل أسماء الأعمدة حسب جدول users عندك:
         * phone / mobile / mobile1 / mobile2 / mobile3
         */
        return User::where(function ($query) use ($value, $phone) {
            $query->where('MOP', $value)
                ->orWhere('MOP', $phone) ;
        })->first();
    }

    private function normalizePhone(string $phone): string
    {
        $phone = trim($phone);

        $arabic = ['٠','١','٢','٣','٤','٥','٦','٧','٨','٩'];
        $english = ['0','1','2','3','4','5','6','7','8','9'];
        $phone = str_replace($arabic, $english, $phone);

        $phone = preg_replace('/[^0-9+]/', '', $phone);

        if (str_starts_with($phone, '0020')) {
            return '+20' . substr($phone, 4);
        }

        if (str_starts_with($phone, '01')) {
            return '+20' . substr($phone, 1);
        }

        if (str_starts_with($phone, '20')) {
            return '+' . $phone;
        }

        return $phone;
    }
}
