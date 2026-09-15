<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('property_promotions')) {
            return;
        }

        Schema::create('property_promotions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('aqar_id');
            $table->unsignedBigInteger('price_vip_id');
            $table->unsignedBigInteger('fawry_payment_id')->nullable();

            $table->enum('status', ['pending', 'active', 'expired', 'cancelled'])
                ->default('pending');

            $table->decimal('amount_paid', 10, 2)->default(0);
            $table->unsignedSmallInteger('duration_days')->default(0);
            $table->timestamp('started_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'status']);
            $table->index(['aqar_id', 'status']);
            $table->index('price_vip_id');
            $table->index('fawry_payment_id');
            $table->index('expires_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('property_promotions');
    }
};
