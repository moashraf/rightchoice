<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement(
            "ALTER TABLE user_registration_logs MODIFY COLUMN source VARCHAR(100) NOT NULL"
        );
    }

    public function down(): void
    {
        DB::statement(
            "ALTER TABLE user_registration_logs MODIFY COLUMN source ENUM('app', 'web', 'google') NOT NULL"
        );
    }
};
