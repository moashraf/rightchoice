<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('price_vip', function (Blueprint $table) {
            $table->unsignedSmallInteger('duration_days')->default(7)->after('views');
        });

        Schema::table('aqar', function (Blueprint $table) {
            $table->unsignedBigInteger('vip_price_id')->nullable()->after('vip');
            $table->timestamp('vip_started_at')->nullable()->after('vip_price_id');
            $table->timestamp('vip_expires_at')->nullable()->index()->after('vip_started_at');
        });

        $durations = [7, 14, 30];
        DB::table('price_vip')->orderBy('price')->pluck('id')->each(function ($id, $index) use ($durations) {
            DB::table('price_vip')->where('id', $id)->update([
                'duration_days' => $durations[min($index, count($durations) - 1)],
            ]);
        });

        DB::table('aqar')
            ->where('vip', 1)
            ->update([
                'vip_started_at' => now(),
                'vip_expires_at' => now()->addDays(7),
            ]);
    }

    public function down(): void
    {
        Schema::table('aqar', function (Blueprint $table) {
            $table->dropIndex(['vip_expires_at']);
            $table->dropColumn(['vip_price_id', 'vip_started_at', 'vip_expires_at']);
        });

        Schema::table('price_vip', function (Blueprint $table) {
            $table->dropColumn('duration_days');
        });
    }
};
