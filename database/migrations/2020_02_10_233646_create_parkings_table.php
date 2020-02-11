<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParkingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parkings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('property_id')->nullable();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->string('location')->nullable();
            $table->integer('type')->comment('0=carport 1=garage')->nullable();
            $table->integer('parking_deposit_amount')->nullable();
            $table->integer('monthly_fee')->nullable();
            $table->integer('avaliable')->comment('0=yes 1=no')->nullable();
            $table->timestamps();

            $table->foreign('property_id')->references('id')->on('properties');
            $table->foreign('company_id')->references('id')->on('companies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parkings');
    }
}
