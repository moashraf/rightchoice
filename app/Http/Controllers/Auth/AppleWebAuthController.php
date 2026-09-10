<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Auth\SocialTokenVerifier;
use DomainException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use InvalidArgumentException;
use UnexpectedValueException;

class AppleWebAuthController extends Controller
{
    public function login(Request $request, SocialTokenVerifier $verifier, ?string $locale = null): RedirectResponse
    {
        $data = $request->validate([
            'credential' => ['required', 'string', 'max:16384'],
            'name' => ['nullable', 'string', 'max:90'],
        ]);

        try {
            $claims = $verifier->verify('apple', $data['credential']);
        } catch (UnexpectedValueException | InvalidArgumentException | DomainException $e) {
            return back()->withErrors(['apple' => 'تعذر التحقق من حساب Apple. حاول مرة أخرى.']);
        } catch (ConnectionException | RequestException | GuzzleException $e) {
            return back()->withErrors(['apple' => 'خدمة Apple غير متاحة مؤقتًا. حاول مرة أخرى.']);
        }

        try {
            $user = DB::transaction(function () use ($claims, $data) {
                $user = User::withTrashed()
                    ->where('provider', 'apple')
                    ->where('provider_id', $claims['sub'])
                    ->lockForUpdate()
                    ->first();

                if ($user && ($user->trashed() || (int) $user->status !== 1)) {
                    throw new DomainException('inactive');
                }

                if ($user) {
                    return $user;
                }

                $email = $claims['email'] ?? null;
                $verified = in_array($claims['email_verified'] ?? null, [true, 'true', 1, '1'], true);

                if (!is_string($email)
                    || strlen($email) > 90
                    || !filter_var($email, FILTER_VALIDATE_EMAIL)
                    || !$verified) {
                    throw new DomainException('email');
                }

                if (User::withTrashed()->where('email', $email)->exists()) {
                    throw new DomainException('conflict');
                }

                $name = $data['name'] ?? ($claims['name'] ?? 'RightChoice user');

                $user = new User();
                $user->provider = 'apple';
                $user->provider_id = $claims['sub'];
                $user->name = Str::limit(
                    is_string($name) && trim($name) !== '' ? trim($name) : 'RightChoice user',
                    90,
                    ''
                );
                $user->email = $email;
                $user->email_verified_at = now();
                $user->password = null;
                $user->TYPE = 1;
                $user->isAdmin = 0;
                $user->status = 1;
                $user->phone_verfied_sms_status = 0;
                $user->save();

                return $user;
            });
        } catch (DomainException $e) {
            $message = match ($e->getMessage()) {
                'inactive' => 'هذا الحساب غير نشط.',
                'conflict' => 'يوجد حساب مسجل بالفعل بهذا البريد. سجل الدخول بالطريقة الحالية للحساب.',
                default => 'يجب أن يوفر حساب Apple بريدًا إلكترونيًا موثقًا عند أول تسجيل.',
            };

            return back()->withErrors(['apple' => $message]);
        } catch (QueryException $e) {
            if (in_array($e->errorInfo[1] ?? null, [1062, 19], true) || $e->getCode() === '235голь05') {
                return back()->withErrors(['apple' => 'حدث تعارض أثناء إنشاء الحساب. حاول تسجيل الدخول مرة أخرى.']);
            }

            throw $e;
        }

        Auth::guard('web')->login($user, true);
        $request->session()->regenerate();

        $locale = in_array($locale, ['ar', 'en'], true) ? $locale : app()->getLocale();

        return redirect()->intended('/'.$locale.'/dashboard');
    }
}
