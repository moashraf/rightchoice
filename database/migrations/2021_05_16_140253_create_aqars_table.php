<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAqarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aqars', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->string('description');
            $table->text('excerpt');
            $table->boolean('vip')->nullable();
            $table->boolean('finannce_bank')->nullable();
            $table->boolean('licensed')->nullable();
            $table->boolean('trade')->nullable();
            $table->integer('number_of_floors')->nullable();
            $table->double('total_area')->nullable();
            $table->integer('rooms')->nullable();
            $table->integer('baths')->nullable();
            $table->integer('floor')->nullable();
            $table->double('ground_area')->nullable();
            $table->double('land_area')->nullable();
            $table->double('downpayment')->nullable();
            $table->integer('installment_time')->nullable();
            $table->double('installment_value')->nullable();
            $table->double('monthly_rent')->nullable();
            $table->boolean('rent_long_time')->nullable();
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
        Schema::dropIfExists('aqars');
    }
}
