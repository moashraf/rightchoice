<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Middleware to restrict access to admin-only routes.
 * Checks if the authenticated user has isAdmin flag set.
 */
class AdminfCheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('admin.login');
        }

        if (!$user->isAdmin) {
            Auth::logout();
            return redirect()->route('admin.login')->withErrors([
                'email' => 'This account does not have admin access.',
            ]);
        }

        return $next($request);
    }
}
