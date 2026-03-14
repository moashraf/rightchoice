<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            AqarSeeder::class,

            // ── RBAC ────────────────────────────────────────────────────
            // 1. Create roles + permissions and assign them
//            RolesAndPermissionsSeeder::class,
            // 2. Map existing users: isAdmin=1 → admin, others → user
//            MigrateUsersToRolesSeeder::class,
        ]);
    }
}
