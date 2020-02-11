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
            $table->unsignedBigInteger('community_id')->nullable();
            $table->string('address_1');
            $table->string('address_2')->nullable();
            $table->string('address_3')->nullable();
            $table->string('city');
            $table->string('state');
            $table->string('zip');
            $table->string('country');
            $table->integer('occupied')->nullable()->comment('0 = no 1 = yes');
            $table->date('date_occupied')->nullable();
            $table->date('date_available')->nullable();
            $table->integer('pet')->nullable()->comment('0 = no 1 = yes');     
            $table->integer('bed_amount')->nullable();
            $table->integer('bath_amount')->nullable();
            $table->integer('square_footage')->nullable();
            $table->text('description')->nullable();
            $table->integer('assigned_parking')->default(0)->comment('0 = no 1 = yes');
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('community_id')->references('id')->on('communities');
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
