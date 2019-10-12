<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('company_id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->integer('role')->comment('100=inactive 0=tenant 1=maintenance 2=officeManager 3=propertyOwner 4=superAdmin 10=travis');
            $table->integer('product')->comment('0=tenant 1=home owners 2=apt 3=hoa');
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies');
        });
    }

    /**
     * USER ROLE BREAKDOWN
     * 0) Tenant - only see dashboard, maintence request they sent, billing, settings.
     * 1) Maintanence - only see maintence CRUD, settings
     * 2) Office Manager - only see dashboard, properties, tenants, tenants billing. they can make changes to properties and tenants
     * 3) Property Owner - see everything
     * 4) Super Admin - Internal use for SenRent. We see everything. extra dashboard with user infomration TBB (to be built)
     * 5) Travis - sees everything and revenue  
     */

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
