<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersPriceingSaleTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_priceing_sale', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('pricing_id')->unsigned();
            $table->foreign('pricing_id')->references('id')->on('priceing_sale')->onDelete('cascade');
            $table->integer('start_points');
            $table->integer('current_points');
            $table->integer('sub_points');
            $table->integer('statues')->default(1);
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
        Schema::drop('users_priceing_sale');
    }
}
