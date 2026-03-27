<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

/**
 * Seed SMS-related permissions into the permissions table.
 *
 * Run with: php artisan db:seed --class=SmsPermissionSeeder
 */
class SmsPermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            ['name' => 'sms.view',   'label' => 'عرض تقارير الرسائل',     'module' => 'sms'],
            ['name' => 'sms.send',   'label' => 'إرسال رسائل SMS',        'module' => 'sms'],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission['name']],
                $permission
            );
        }

        $this->command->info('SMS permissions seeded successfully.');
    }
}
