<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAqarsImgsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aqars_imgs', function (Blueprint $table) {
            $table->increments('id');
            $table->text('img_url');
            $table->boolean('main_img');
            $table->integer('aqar_id')->unsigned();
            $table->foreign('aqar_id')->references('id')->on('aqar')->onDelete('cascade');
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
        Schema::drop('aqars_imgs');
    }
}
