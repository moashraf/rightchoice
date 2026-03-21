<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

/**
 * RolesAndPermissionsSeeder
 *
 * Creates the three default roles, defines all granular permissions,
 * and assigns them according to the access matrix:
 *
 *  admin   → ALL permissions
 *  viewer  → only *.view permissions (read-only staff)
 *  user    → front-facing creation / update permissions
 */
class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // ── 1. Create Roles ──────────────────────────────────────────────────
        $admin  = Role::firstOrCreate(
            ['name' => RoleEnum::ADMIN],
            ['label' => 'Administrator', 'description' => 'Full access to all modules and actions.']
        );

        $user   = Role::firstOrCreate(
            ['name' => RoleEnum::USER],
            ['label' => 'User', 'description' => 'Standard authenticated user with front-facing access.']
        );

        $viewer = Role::firstOrCreate(
            ['name' => RoleEnum::VIEWER],
            ['label' => 'Viewer', 'description' => 'Read-only staff. Can view data but cannot create/update/delete.']
        );

        // ── 2. Define All Permissions ────────────────────────────────────────
        //  Format: ['name' => 'module.action', 'label' => 'Human Label', 'module' => 'module']

        $permissionDefinitions = [
            // Dashboard
            ['name' => 'dashboard.view',       'label' => 'View Dashboard',           'module' => 'dashboard'],

            // Users
            ['name' => 'users.view',           'label' => 'View Users',               'module' => 'users'],
            ['name' => 'users.create',         'label' => 'Create Users',             'module' => 'users'],
            ['name' => 'users.update',         'label' => 'Update Users',             'module' => 'users'],
            ['name' => 'users.delete',         'label' => 'Delete Users',             'module' => 'users'],
            ['name' => 'users.export',         'label' => 'Export Users',             'module' => 'users'],
            ['name' => 'users.block',          'label' => 'Block/Activate Users',     'module' => 'users'],

            // Real Estate (Aqars)
            ['name' => 'aqars.view',           'label' => 'View Aqars',               'module' => 'aqars'],
            ['name' => 'aqars.create',         'label' => 'Create Aqars',             'module' => 'aqars'],
            ['name' => 'aqars.update',         'label' => 'Update Aqars',             'module' => 'aqars'],
            ['name' => 'aqars.delete',         'label' => 'Delete Aqars',             'module' => 'aqars'],
            ['name' => 'aqars.refund',         'label' => 'Refund Points (Aqars)',    'module' => 'aqars'],

            // Companies
            ['name' => 'companies.view',       'label' => 'View Companies',           'module' => 'companies'],
            ['name' => 'companies.create',     'label' => 'Create Companies',         'module' => 'companies'],
            ['name' => 'companies.update',     'label' => 'Update Companies',         'module' => 'companies'],
            ['name' => 'companies.delete',     'label' => 'Delete Companies',         'module' => 'companies'],

            // Reports
            ['name' => 'reports.view',         'label' => 'View Reports',             'module' => 'reports'],

            // Settings
            ['name' => 'settings.manage',      'label' => 'Manage Settings',          'module' => 'settings'],

            // Blogs
            ['name' => 'blogs.view',           'label' => 'View Blogs',               'module' => 'blogs'],
            ['name' => 'blogs.create',         'label' => 'Create Blogs',             'module' => 'blogs'],
            ['name' => 'blogs.update',         'label' => 'Update Blogs',             'module' => 'blogs'],
            ['name' => 'blogs.delete',         'label' => 'Delete Blogs',             'module' => 'blogs'],

            // Complaints
            ['name' => 'complaints.view',      'label' => 'View Complaints',          'module' => 'complaints'],
            ['name' => 'complaints.update',    'label' => 'Update Complaints',        'module' => 'complaints'],
            ['name' => 'complaints.delete',    'label' => 'Delete Complaints',        'module' => 'complaints'],

            // Contact Forms
            ['name' => 'contact_forms.view',   'label' => 'View Contact Forms',       'module' => 'contact_forms'],
            ['name' => 'contact_forms.delete', 'label' => 'Delete Contact Forms',     'module' => 'contact_forms'],

            // Notifications
            ['name' => 'notifications.view',   'label' => 'View Notifications',       'module' => 'notifications'],
            ['name' => 'notifications.manage', 'label' => 'Manage Notifications',     'module' => 'notifications'],

            // Pricing / Packages
            ['name' => 'pricing.view',         'label' => 'View Pricing Packages',    'module' => 'pricing'],
            ['name' => 'pricing.manage',       'label' => 'Manage Pricing Packages',  'module' => 'pricing'],

            // Compounds & Locations
            ['name' => 'locations.view',       'label' => 'View Location Data',       'module' => 'locations'],
            ['name' => 'locations.manage',     'label' => 'Manage Location Data',     'module' => 'locations'],

            // Activity Logs
            ['name' => 'activity_logs.view',   'label' => 'View Activity Logs',       'module' => 'activity_logs'],
            ['name' => 'activity_logs.delete', 'label' => 'Delete Activity Logs',     'module' => 'activity_logs'],
        ];

        // Upsert all permissions (idempotent)
        foreach ($permissionDefinitions as $def) {
            Permission::firstOrCreate(
                ['name' => $def['name']],
                ['label' => $def['label'], 'module' => $def['module']]
            );
        }

        // Reload all permissions from DB
        $allPermissions = Permission::all();

        // ── 3. Assign Permissions ────────────────────────────────────────────

        // ADMIN → ALL permissions
        $admin->permissions()->sync($allPermissions->pluck('id')->toArray());

        // VIEWER → only *.view permissions (read-only)
        $viewPermissions = $allPermissions->filter(
            fn($p) => str_ends_with($p->name, '.view')
        )->pluck('id')->toArray();
        $viewer->permissions()->sync($viewPermissions);

        // USER → front-facing: view + create + update on aqars, plus own dashboard
        $userPermissionNames = [
            'dashboard.view',
            'aqars.view',
            'aqars.create',
            'aqars.update',
            'companies.view',
            'companies.create',
            'companies.update',
        ];
        $userPermissions = $allPermissions->whereIn('name', $userPermissionNames)->pluck('id')->toArray();
        $user->permissions()->sync($userPermissions);

        $this->command->info('✅ RBAC roles and permissions seeded successfully.');
        $this->command->table(
            ['Role', 'Permission Count'],
            [
                [RoleEnum::ADMIN,  $admin->permissions()->count()],
                [RoleEnum::VIEWER, $viewer->permissions()->count()],
                [RoleEnum::USER,   $user->permissions()->count()],
            ]
        );
    }
}
