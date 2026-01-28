<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingSiteTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('SettingSite', function (Blueprint $table) {
            $table->increments('id');
            $table->string('Title');
            $table->string('Address');
            $table->string('Mobile');
            $table->string('Phone_land_line')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('mail');
            $table->text('facebook');
            $table->text('linkedin');
            $table->text('insta');
            $table->text('tiwiter');
            $table->text('youtube');
            $table->text('map_link')->nullable();
            $table->text('meta_title')->nullable();
            $table->text('meta_keyword')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('logo');
            $table->string('icon');
            $table->text('short_dis_about')->nullable();
            $table->text('featured_ads_dis')->nullable();
            $table->text('estate_sale_dis')->nullable();
            $table->text('estate_sale_rent')->nullable();
            $table->text('services_dis')->nullable();
            $table->text('most_searched_dis')->nullable();
            $table->text('connect_us_dis')->nullable();
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
        Schema::drop('SettingSite');
    }
}
