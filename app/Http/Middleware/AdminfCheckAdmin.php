<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Middleware to restrict access to admin-only routes.
 * Uses 'admin' guard to check isolated admin session.
 */
class AdminfCheckAdmin
{
    public function handle(Request $request, Closure $next)
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::guard('admin')->user();

        if (!$user) {
            return redirect()->route('sitemanagement.login');
        }

        if (!$user->isAdmin) {
            Auth::guard('admin')->logout();
            return redirect()->route('sitemanagement.login')->withErrors([
                'email' => 'This account does not have admin access.',
            ]);
        }

        return $next($request);
    }
}
