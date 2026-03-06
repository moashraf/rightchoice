<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Sets a separate session cookie name for admin routes.
 * This ensures admin session is completely isolated from user session.
 */
class AdminSessionCookie
{
    public function handle(Request $request, Closure $next)
    {
        // Override the session cookie name for admin routes
        config(['session.cookie' => Str::slug(config('app.name', 'laravel'), '_') . '_admin_session']);

        return $next($request);
    }
}
