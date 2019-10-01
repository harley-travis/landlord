<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTenantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('property_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();
            $table->string('phone');
            $table->string('work_phone')->nullable();
            $table->string('secondary_name')->nullable();
            $table->string('secondary_phone')->nullable();
            $table->string('secondary_work_phone')->nullable();
            $table->string('secondary_email')->nullable();
            $table->integer('number_occupants');
            $table->integer('active')->comment('0 = not active 1 = actives');

            $table->foreign('property_id')->references('id')->on('properties');
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::create('company_tenant', function (Blueprint $table) {
            $table->integer('company_id');
            $table->integer('tenant_id');
            $table->primary(['company_id', 'tenant_id']);
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
        Schema::dropIfExists('tenants');
        Schema::dropIfExists('company_tenant');
    }
}
