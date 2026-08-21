<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('aqar', function (Blueprint $table) {
            $table->timestamp('auto_suspended_at')->nullable()->after('vip_expires_at')->index();
        });
    }

    public function down(): void
    {
        Schema::table('aqar', function (Blueprint $table) {
            $table->dropIndex(['auto_suspended_at']);
            $table->dropColumn('auto_suspended_at');
        });
    }
};
