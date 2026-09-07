<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('priceing_sale', function (Blueprint $table) {
            $table->unsignedTinyInteger('discount_percentage')
                ->default(80)
                ->after('price');
        });

        Schema::table('price_vip', function (Blueprint $table) {
            $table->unsignedTinyInteger('discount_percentage')
                ->default(80)
                ->after('price');
        });
    }

    public function down(): void
    {
        Schema::table('priceing_sale', function (Blueprint $table) {
            $table->dropColumn('discount_percentage');
        });

        Schema::table('price_vip', function (Blueprint $table) {
            $table->dropColumn('discount_percentage');
        });
    }
};
