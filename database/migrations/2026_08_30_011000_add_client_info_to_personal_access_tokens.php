<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('personal_access_tokens')) {
            return;
        }

        Schema::table('personal_access_tokens', function (Blueprint $table) {
            if (!Schema::hasColumn('personal_access_tokens', 'ip_address')) {
                $table->string('ip_address', 45)->nullable()->after('last_used_at');
            }
            if (!Schema::hasColumn('personal_access_tokens', 'user_agent')) {
                $table->string('user_agent', 512)->nullable()->after('ip_address');
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('personal_access_tokens')) {
            return;
        }

        Schema::table('personal_access_tokens', function (Blueprint $table) {
            if (Schema::hasColumn('personal_access_tokens', 'user_agent')) {
                $table->dropColumn('user_agent');
            }
            if (Schema::hasColumn('personal_access_tokens', 'ip_address')) {
                $table->dropColumn('ip_address');
            }
        });
    }
};
