<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * MigrateUsersToRolesSeeder
 *
 * Data-migration seeder — maps existing users to the new RBAC roles:
 *
 *   isAdmin = 1  →  admin role
 *   isAdmin = 0  →  user role   (default for all non-admin users)
 *
 * Safe to re-run: only processes users where role_id IS NULL.
 */
class MigrateUsersToRolesSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::where('name', RoleEnum::ADMIN)->first();
        $userRole  = Role::where('name', RoleEnum::USER)->first();

        if (! $adminRole || ! $userRole) {
            $this->command->error(
                '❌ Roles not found. Run RolesAndPermissionsSeeder first.'
            );
            return;
        }

        // ── Migrate old isAdmin=1 users to admin role ────────────────────
        $adminCount = User::whereNull('role_id')
            ->where('isAdmin', 1)
            ->update(['role_id' => $adminRole->id]);

        // ── Assign user role to everyone else ────────────────────────────
        $userCount = User::whereNull('role_id')
            ->update(['role_id' => $userRole->id]);

        $this->command->info('✅ User migration complete:');
        $this->command->info("   → {$adminCount} user(s) assigned role: admin");
        $this->command->info("   → {$userCount}  user(s) assigned role: user");
    }
}
