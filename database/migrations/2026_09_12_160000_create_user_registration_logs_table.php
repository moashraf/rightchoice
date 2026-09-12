<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_registration_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();
            $table->enum('source', ['app', 'web']);
            $table->string('event')->default('new_registration');
            $table->timestamps();

            $table->index(['source', 'event']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_registration_logs');
    }
};
