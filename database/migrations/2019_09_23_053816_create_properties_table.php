<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('company_id');
            $table->timestamps();
            $table->string('address_1');
            $table->string('address_2')->nullable();
            $table->string('address_3')->nullable();
            $table->string('city');
            $table->string('state');
            $table->string('zip');
            $table->string('country');
            $table->integer('occupied')->comment('0 = no 1 = yes');
            $table->string('lease_length');
            $table->integer('rent_amount')->nullable();
            $table->integer('pet')->comment('0 = no 1 = yes');
            $table->integer('deposit_amount');
            $table->integer('pet_deposit_amount')->nullable();
            $table->integer('amount_refundable');
            $table->integer('bed_amount')->nullable();
            $table->integer('bath_amount')->nullable();
            $table->integer('square_footage')->nullable();
            $table->text('description')->nullable();

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
        Schema::dropIfExists('properties');
    }
}
