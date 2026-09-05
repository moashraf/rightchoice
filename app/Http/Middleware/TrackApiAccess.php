<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Laravel\Sanctum\PersonalAccessToken;

class TrackApiAccess
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        $user = $request->user();
        if ($user && method_exists($user, 'currentAccessToken')) {
            $token = $user->currentAccessToken();
            if ($token instanceof PersonalAccessToken) {
                static::stamp($token, $request);
            }
        }

        return $response;
    }

    public static function stamp(?PersonalAccessToken $token, Request $request): void
    {
        if (!$token || !Schema::hasColumn('personal_access_tokens', 'ip_address')) {
            return;
        }

        $ip = (string) $request->ip();
        $ua = mb_substr((string) $request->userAgent(), 0, 512);

        if ($token->ip_address === $ip && $token->user_agent === $ua) {
            return;
        }

        $token->forceFill([
            'ip_address' => $ip ?: null,
            'user_agent' => $ua ?: null,
        ])->save();
    }
}
