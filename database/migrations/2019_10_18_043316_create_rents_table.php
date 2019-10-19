<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rents', function (Blueprint $table) {

            /**
             * making these nullable because HOA and property owners don't need the same information
             * but we're sharing the same data table. rs
             */

            $table->bigIncrements('id');
            $table->unsignedBigInteger('property_id');
            $table->integer('rent_amount')->nullable();
            $table->integer('deposit_amount')->nullable();
            $table->integer('pet_deposit_amount')->nullable();
            $table->integer('amount_refundable')->nullable();
            $table->string('lease_length')->nullable();
            $table->integer('late_date')->nullable();
            $table->integer('late_fee')->nullable();
            $table->text('account_number')->nullable();
            $table->integer('hoa_amount')->nullable();
            $table->timestamps();

            $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rents');
    }
}
