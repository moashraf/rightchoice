<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_activities', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('loggable_type');
            $table->unsignedBigInteger('loggable_id');
            $table->longText('comment')->nullable();
            $table->tinyInteger('sent_email')
                ->comment('1 = sent email, 0 = unsent email')
            ->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('log_activities');
    }
}
