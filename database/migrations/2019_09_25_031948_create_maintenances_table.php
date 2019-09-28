<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaintenancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->timestamps();
            $table->string('subject');
            $table->enum('type', [
                'Alarm System',
                'Appliances',
                'Balcony/Patio',
                'Blinds',
                'Cabinets',
                'Carbon Monoxide Detectors',
                'Counter Top',
                'Doors',
                'Electrical',
                'Fire Alarm/Fire Sprinklers/Extinguishers',
                'Flood',
                'Floors/Carpet',
                'Garage/Carport',
                'Garbage Disposal',
                'Gas Leak',
                'Glass/Windows/Screens',
                'Hardware',
                'Heating/Ventilation/AC',
                'Landscaping/Grounds',
                'Lighting',
                'Locks/Keys',
                'Paint',
                'Pest Control',
                'Plumbing',
                'Roof',
                'Smoke Detectors',
                'Storage Unit',
                'Toilet Problems',
                'Tub/Shower',
                'Other',
                ]); 
            $table->longText('description');
            $table->integer('emergency')->comment('0=>no 1=>yes');
            $table->integer('permission')->comment('0=>no 1=>yes');
            $table->integer('status')->comment('0=>pending 1=>review 2=>in progress 3=>completed');

            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('maintenances');
    }
}
