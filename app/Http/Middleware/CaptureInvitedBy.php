<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CaptureInvitedBy
{
    /**
     * If 'invited_by' is present in the query string, store it in the session.
     */
    public function handle(Request $request, Closure $next)
    {

        if (request()->is('*gcamp*')) {
            session(['invited_by' => 'google']);

        }

        if ($request->has('invited_by') && $request->query('invited_by')) {
            session(['invited_by' => $request->query('invited_by')]);
        }

        return $next($request);
    }
}
