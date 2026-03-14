<?php

namespace App\Enums;

/**
 * RBAC Role Name Constants
 *
 * Use these constants instead of magic strings throughout the codebase.
 *
 * Usage:
 *   $user->hasRole(RoleEnum::ADMIN)
 *   $user->hasPermission('users.create')
 */
class RoleEnum
{
    /** Full access to all modules and actions */
    const ADMIN  = 'admin';

    /** Normal authenticated user — limited front-facing access */
    const USER   = 'user';

    /** Read-only staff — can view, cannot create / update / delete */
    const VIEWER = 'viewer';
}
