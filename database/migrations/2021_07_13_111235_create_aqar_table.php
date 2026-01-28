<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAqarTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aqar', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('status')->default(0);
            $table->string('slug')->unique();
            $table->string('title');
            $table->longText('description');
            $table->integer('vip')->nullable();
            $table->integer('finannce_bank')->nullable();
            $table->integer('licensed')->nullable();
            $table->integer('trade')->nullable();
            $table->bigInteger('number_of_floors')->nullable();
            $table->double('total_area')->nullable();
            $table->integer('rooms')->nullable();
            $table->integer('baths')->nullable();
            $table->integer('floor')->unsigned()->nullable();
            $table->foreign('floor')->references('id')->on('floor')->onDelete('cascade');
            $table->double('ground_area')->nullable();
            $table->double('land_area')->nullable();
            $table->double('downpayment')->nullable();
            $table->integer('installment_time')->nullable();
            $table->double('installment_value')->nullable();
            $table->double('monthly_rent')->nullable();
            $table->integer('rent_long_time')->nullable();
            $table->integer('offer_type')->unsigned();
            $table->foreign('offer_type')->references('id')->on('offer_type')->onDelete('cascade');
            $table->integer('property_type')->unsigned();
            $table->foreign('property_type')->references('id')->on('property_type')->onDelete('cascade');
            $table->integer('license_type')->unsigned();
            $table->foreign('license_type')->references('id')->on('license_type')->onDelete('cascade');
            $table->double('mtr_price')->nullable();
            $table->integer('reciving')->nullable();
            $table->text('rec_time')->nullable();
            $table->unsignedBigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('category')->unsigned();
            $table->foreign('category')->references('id')->on('aqar_category')->onDelete('cascade');
            $table->text('location')->nullable();
            $table->integer('call_id')->default(3);
            $table->bigInteger('endorsement')->nullable();
            $table->double('total_price')->nullable();
            $table->integer('finishtype')->unsigned();
            $table->foreign('finishtype')->references('id')->on('finish_type')->onDelete('cascade');
            $table->integer('governrate_id')->unsigned();
            $table->foreign('governrate_id')->references('id')->on('governrate')->onDelete('cascade');
            $table->integer('district_id')->unsigned();
            $table->foreign('district_id')->references('id')->on('district')->onDelete('cascade');
            $table->integer('area_id')->unsigned()->nullable();
            $table->foreign('area_id')->references('id')->on('subarea')->onDelete('cascade');
            $table->integer('compound')->unsigned();
            $table->foreign('compound')->references('id')->on('compound')->onDelete('cascade');
            $table->integer('points_avail')->nullable();
            $table->integer('views')->default(0);
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
        Schema::drop('aqar');
    }
}
