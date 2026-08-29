<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('aqar_analytics_events')) {
            return;
        }

        Schema::create('aqar_analytics_events', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('aqar_id');
            $table->string('event_type', 40);
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('visitor_hash', 64)->nullable();
            $table->string('session_id', 100)->nullable();
            $table->string('source', 40)->nullable();
            $table->json('metadata')->nullable();
            $table->timestamp('occurred_at')->useCurrent();
            $table->timestamps();

            $table->index('aqar_id', 'aqar_analytics_aqar_idx');
            $table->index('event_type', 'aqar_analytics_event_type_idx');
            $table->index('occurred_at', 'aqar_analytics_occurred_at_idx');
            $table->index('user_id', 'aqar_analytics_user_idx');
            $table->index('visitor_hash', 'aqar_analytics_visitor_hash_idx');
            $table->index(
                ['aqar_id', 'event_type', 'occurred_at'],
                'aqar_analytics_aqar_type_occurred_idx'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('aqar_analytics_events');
    }
};
