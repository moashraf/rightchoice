<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedSmallInteger('phone_change_otp')
                ->nullable()
                ->after('phone_sms_otp');
            $table->string('pending_phone', 20)
                ->nullable()
                ->after('phone_change_otp');
            $table->timestamp('phone_otp_expires_at')
                ->nullable()
                ->after('pending_phone');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone_change_otp',
                'pending_phone',
                'phone_otp_expires_at',
            ]);
        });
    }
};
