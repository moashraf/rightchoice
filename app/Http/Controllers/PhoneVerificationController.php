<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use InvalidArgumentException;

class PhoneVerificationController extends Controller
{
    public function show()
    {
        $user = auth()->user();

        if ($this->hasVerifiedPhone($user)) {
            return redirect()->intended(route('homeBlade', ['locale' => app()->getLocale()]));
        }

        return view('auth.complete-phone', [
            'pendingPhone' => session('phone_verification.phone'),
        ]);
    }

    public function requestOtp(Request $request)
    {
        $user = $request->user();
        $validated = $request->validate([
            'phone' => [
                'required',
                'string',
                'regex:/^01[0125][0-9]{8}$/',
                Rule::unique('users', 'MOP')->ignore($user->id),
            ],
        ], [
            'phone.required' => 'رقم الهاتف مطلوب.',
            'phone.regex' => 'رقم الهاتف يجب أن يكون رقم موبايل مصريًا صحيحًا مكونًا من 11 رقمًا.',
            'phone.unique' => 'رقم الهاتف مستخدم بالفعل في حساب آخر.',
        ]);

        try {
            $phone = SmsService::normalizeRecipient($validated['phone']);
        } catch (InvalidArgumentException $exception) {
            return back()->withErrors(['phone' => 'رقم الهاتف غير صالح.'])->withInput();
        }

        $otp = random_int(1000, 9999);
        if (SmsService::sendOtp($phone, $otp) === false) {
            return back()->withErrors(['phone' => 'تعذر إرسال رمز التحقق. حاول مرة أخرى.'])->withInput();
        }

        $user->forceFill(['phone_sms_otp' => $otp])->save();
        session()->put('phone_verification', [
            'phone' => $phone,
            'expires_at' => now()->addMinutes(10)->timestamp,
        ]);

        return back()->with('success', 'تم إرسال رمز التحقق إلى رقم الهاتف.');
    }

    public function verify(Request $request)
    {
        $validated = $request->validate([
            'otp' => ['required', 'digits:4'],
        ], [
            'otp.required' => 'رمز التحقق مطلوب.',
            'otp.digits' => 'رمز التحقق يجب أن يتكون من 4 أرقام.',
        ]);

        $user = $request->user();
        $phone = session('phone_verification.phone');
        $expiresAt = (int) session('phone_verification.expires_at');

        if (!$phone || !$user->phone_sms_otp || !$expiresAt) {
            return back()->withErrors(['otp' => 'اطلب رمز تحقق جديدًا أولاً.']);
        }

        if (now()->timestamp > $expiresAt) {
            $user->forceFill(['phone_sms_otp' => null])->save();
            session()->forget('phone_verification');

            return back()->withErrors(['otp' => 'انتهت صلاحية رمز التحقق. اطلب رمزًا جديدًا.']);
        }

        if (!hash_equals((string) $user->phone_sms_otp, (string) $validated['otp'])) {
            return back()->withErrors(['otp' => 'رمز التحقق غير صحيح.']);
        }

        if (User::where('MOP', $phone)->where('id', '!=', $user->id)->exists()) {
            return back()->withErrors(['phone' => 'رقم الهاتف مستخدم بالفعل في حساب آخر.']);
        }

        DB::transaction(function () use ($user, $phone) {
            $user->forceFill([
                'MOP' => $phone,
                'phone_verfied_sms_status' => 1,
                'phone_sms_otp' => null,
            ])->save();
        });

        session()->forget('phone_verification');

        return redirect()->intended(route('homeBlade', ['locale' => app()->getLocale()]))
            ->with('success', 'تم حفظ رقم الهاتف والتحقق منه بنجاح.');
    }

    private function hasVerifiedPhone(?User $user): bool
    {
        return $user
            && trim((string) $user->MOP) !== ''
            && (int) $user->phone_verfied_sms_status === 1;
    }
}
