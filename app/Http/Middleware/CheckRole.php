<?php

namespace App\Http\Middleware;

use App\Enums\RoleEnum;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * CheckRole Middleware
 *
 * Restricts a route to users with a specific role.
 *
 * Registration in Kernel.php:
 *   'role' => \App\Http\Middleware\CheckRole::class,
 *
 * Usage in routes:
 *   Route::get('/admin/...')->middleware('role:admin');
 *
 * Usage in controllers:
 *   $this->middleware('role:admin');
 *   $this->middleware('role:admin,viewer');  // multi-role OR logic
 */
class CheckRole
{
    public function handle(Request $request, Closure $next, string ...$roles): mixed
    {
        // Determine which guard to use: admin guard for sitemanagement routes
        $guard = $request->is('sitemanagement*') ? 'admin' : null;
        $user  = $guard ? Auth::guard($guard)->user() : Auth::user();

        if (! $user) {
            return $this->denyAccess($request);
        }

        // Allow if user matches ANY of the listed roles
        foreach ($roles as $role) {
            if ($user->hasRole(trim($role))) {
                return $next($request);
            }
        }

        return $this->denyAccess($request);
    }

    private function denyAccess(Request $request): mixed
    {
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Forbidden. Insufficient role.'], 403);
        }

        abort(403, 'You do not have the required role to access this page.');
    }
}
