<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;

class UpdateLastLoginAt
{
    /**
     * Update the user's last login timestamp on every successful login
     * (works for any guard: web, admin, sanctum, loginUsingId, attempt, …).
     */
    public function handle(Login $event): void
    {
        $user = $event->user;

        if ($user && method_exists($user, 'forceFill')) {
            // Avoid touching updated_at and avoid model events to keep this lightweight.
            $user->forceFill(['last_login_at' => now()])->saveQuietly();
        }
    }
}

