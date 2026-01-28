<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company', function (Blueprint $table) {
            $table->increments('id');
            $table->string('Name');
            $table->text('slug');
            $table->unsignedBigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('governrate_id')->unsigned();
            $table->foreign('governrate_id')->references('id')->on('governrate')->onDelete('cascade');
            $table->integer('district_id')->unsigned();
            $table->foreign('district_id')->references('id')->on('district')->onDelete('cascade');
            $table->integer('area_id')->unsigned()->nullable();
            $table->foreign('area_id')->references('id')->on('subarea')->onDelete('cascade');
            $table->integer('Serv_id')->unsigned();
            $table->foreign('Serv_id')->references('id')->on('services')->onDelete('cascade');
            $table->string('Employee_Name')->nullable();
            $table->string('Job_title')->nullable();
            $table->string('Phone')->nullable();
            $table->integer('building_number')->nullable();
            $table->integer('Floor')->unsigned();
            $table->foreign('Floor')->references('id')->on('floor')->onDelete('cascade');
            $table->integer('unit_number')->nullable();
            $table->longText('details')->nullable();
            $table->string('Tax_card')->nullable();
            $table->string('Commercial_Register')->nullable();
            $table->string('photo')->nullable();
            $table->integer('Company_activity')->nullable();
            $table->integer('status')->default(0);
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
        Schema::drop('company');
    }
}
