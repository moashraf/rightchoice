<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RequireVerifiedPhone
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if ($user && trim((string) $user->MOP) !== '' && (int) $user->phone_verfied_sms_status === 1) {
            return $next($request);
        }

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'يجب إضافة رقم الهاتف والتحقق منه أولاً.',
                'redirect_url' => route('phone.complete', ['locale' => app()->getLocale()]),
            ], 403);
        }

        session()->put('url.intended', $request->fullUrl());
        session()->flash('error', 'يجب إضافة رقم الهاتف والتحقق منه أولاً.');

        return redirect()->route('phone.complete', ['locale' => app()->getLocale()]);
    }
}
