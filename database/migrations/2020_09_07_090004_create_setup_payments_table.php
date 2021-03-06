<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSetupPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {

        Schema::create('setup_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->integer('numberOfProperties')->default(0);
            $table->integer('highestRentAmount')->default(0);
            $table->integer('percentAmount')->default('.50');
            $table->integer('fixedPricing')->nullable();
            $table->integer('pricingAmount')->default(0);
            $table->integer('onboarding')->default(0)->comment('0=no yes=1');
            $table->timestamps();

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
        Schema::dropIfExists('setup_payments');
    }
}