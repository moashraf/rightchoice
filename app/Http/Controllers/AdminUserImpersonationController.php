<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AdminUserImpersonationController extends Controller
{
    private const TOKEN_TTL_SECONDS = 60;

    public function start(Request $request, User $user): RedirectResponse
    {
        $admin = Auth::guard('admin')->user();

        abort_unless(
            $admin && ($admin->isAdminRole() || (bool) $admin->isAdmin),
            403,
            'هذه العملية متاحة للأدمن فقط.'
        );

        abort_if((bool) $user->isAdmin, 422, 'لا يمكن تسجيل الدخول بهذه الطريقة إلى حساب أدمن آخر.');

        $validated = $request->validate([
            'locale' => ['required', 'in:ar,en'],
        ]);

        $token = Str::random(64);

        Cache::put('admin_impersonation:' . $token, [
            'admin_id' => $admin->id,
            'user_id' => $user->id,
        ], now()->addSeconds(self::TOKEN_TTL_SECONDS));

        Log::notice('Admin requested user impersonation.', [
            'admin_id' => $admin->id,
            'user_id' => $user->id,
            'ip' => $request->ip(),
        ]);

        return redirect()->route('admin.impersonation.consume', [
            'locale' => $validated['locale'],
            'token' => $token,
        ]);
    }

    public function consume(Request $request, string $locale, string $token): RedirectResponse
    {
        abort_unless(in_array($locale, ['ar', 'en'], true), 404);

        $impersonation = Cache::pull('admin_impersonation:' . $token);

        abort_unless($impersonation, 410, 'انتهت صلاحية رابط تسجيل الدخول أو تم استخدامه من قبل.');

        $user = User::findOrFail($impersonation['user_id']);
        abort_if((bool) $user->isAdmin, 403);

        Auth::guard('web')->login($user);
        $request->session()->regenerate();
        $request->session()->put('impersonated_by_admin_id', $impersonation['admin_id']);
        $request->session()->put('impersonation_started_at', now()->toIso8601String());

        Log::notice('Admin impersonation login completed.', [
            'admin_id' => $impersonation['admin_id'],
            'user_id' => $user->id,
            'ip' => $request->ip(),
        ]);

        return redirect()->route('user_ads', ['locale' => $locale]);
    }
}
