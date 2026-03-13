<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Middleware to restrict access to admin-only routes.
 * Uses 'admin' guard to check isolated admin session.
 *
 * RBAC: checks the new role system (hasRole('admin') / isAdminRole()).
 * Legacy fallback: also accepts isAdmin = 1 for users not yet migrated.
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

        // ── RBAC check (new system) ──────────────────────────────────────
        // Accept admin role OR legacy isAdmin flag (during transition period).
        // Once all users are migrated (MigrateUsersToRolesSeeder run),
        // you can remove the `|| $user->isAdmin` part.
        $isAdmin = $user->isAdminRole() || (bool) $user->isAdmin;

        if (!$isAdmin) {
            Auth::guard('admin')->logout();
            return redirect()->route('sitemanagement.login')->withErrors([
                'email' => 'This account does not have admin access.',
            ]);
        }

        return $next($request);
    }
}
