<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('seo_title');
            $table->integer('status');
            $table->string('main_img_alt');
            $table->string('single_photo');
            $table->integer('sort_num');
            $table->longText('meta_description');
            $table->integer('number_of_visits');
            $table->string('title');
            $table->longText('description');
            $table->text('slug');
            $table->text('canonical');
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
        Schema::drop('blogs');
    }
}
