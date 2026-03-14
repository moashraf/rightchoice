<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * CheckPermission Middleware
 *
 * Restricts a route to users whose role includes a specific permission.
 *
 * Registration in Kernel.php:
 *   'permission' => \App\Http\Middleware\CheckPermission::class,
 *
 * Usage in routes:
 *   Route::post('/users')->middleware('permission:users.create');
 *   Route::delete('/users/{id}')->middleware('permission:users.delete');
 *
 * Usage in controllers:
 *   $this->middleware('permission:users.create')->only(['create', 'store']);
 *   $this->middleware('permission:users.delete')->only(['destroy', 'forceDelete']);
 *
 * Multiple permissions (AND logic — user must have ALL):
 *   ->middleware('permission:users.create,users.update')
 */
class CheckPermission
{
    public function handle(Request $request, Closure $next, string ...$permissions): mixed
    {
        // Determine which guard to use: admin guard for sitemanagement routes
        $guard = $request->is('sitemanagement*') ? 'admin' : null;
        $user  = $guard ? Auth::guard($guard)->user() : Auth::user();

        if (! $user) {
            return $this->denyAccess($request);
        }

        // Check that user has ALL listed permissions
        foreach ($permissions as $permission) {
            if (! $user->hasPermission(trim($permission))) {
                return $this->denyAccess($request, trim($permission));
            }
        }

        return $next($request);
    }

    private function denyAccess(Request $request, string $permission = ''): mixed
    {
        if ($request->expectsJson()) {
            return response()->json([
                'message' => "Forbidden. Missing permission: {$permission}",
            ], 403);
        }

        abort(403, "You do not have permission to perform this action." . ($permission ? " (Required: {$permission})" : ''));
    }
}
