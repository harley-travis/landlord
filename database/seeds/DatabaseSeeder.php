<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run() {

        // COMPANIES
        // home owners product
        DB::table('companies')->insert([
            'name' => 'company 1',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'product' => '0',
        ]);

        // apt product
        DB::table('companies')->insert([
            'name' => 'company 2',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'product' => '1',
        ]);

        // hoa product
        DB::table('companies')->insert([
            'name' => 'company 2',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'product' => '2',
        ]);

        
        // LANDLORD - USERS
        // home owner user
        DB::table('users')->insert([
            'name' => 'Tony Stark',
            'email' =>'tony@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => bcrypt('test'),
            'company_id' => '1',
            'remember_token' => '',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // apt user
        DB::table('users')->insert([
            'name' => 'Steven Strange',
            'email' =>'strange@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => bcrypt('test'),
            'company_id' => '2',
            'remember_token' => '',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // hoa user
        DB::table('users')->insert([
            'name' => 'Clint Barton',
            'email' =>'clint@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => bcrypt('test'),
            'company_id' => '3',
            'remember_token' => '',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        
        // PROPERTIES
        DB::table('properties')->insert([
            'address_1' => '1234 N 4567 W',
            'address_2' =>'',
            'address_3' => '',
            'city' => 'Logan',
            'state' => 'Utah',
            'zip' => '84336',
            'country' => 'United States',
            'occupied' => '0',
            'lease_length' => '6',
            'rent_amount' => '1500',
            'pet' => '1',
            'deposit_amount' => '500',
            'pet_deposit_amount' => '200',
            'amount_refundable' => '500',
            'bed_amount' => '5',
            'bath_amount' => '2',
            'square_footage' => '2300',
            'description' => 'great place to live',
            'company_id' => '1',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('properties')->insert([
            'address_1' => '1234 W Maple',
            'address_2' => 'APT 23',
            'address_3' => '',
            'city' => 'Gilbert',
            'state' => 'Arizona',
            'zip' => '85395',
            'country' => 'United States',
            'occupied' => '1',
            'lease_length' => '12',
            'rent_amount' => '900',
            'pet' => '0',
            'deposit_amount' => '300',
            'pet_deposit_amount' => '300',
            'amount_refundable' => '100',
            'bed_amount' => null,
            'bath_amount' => null,
            'square_footage' => null,
            'description' => null,
            'company_id' => '1',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('properties')->insert([
            'address_1' => '2nd W 4th N',
            'address_2' => 'APT 345',
            'address_3' => '',
            'city' => 'New York',
            'state' => 'New York',
            'zip' => '758441',
            'country' => 'United States',
            'occupied' => '1',
            'lease_length' => '24',
            'rent_amount' => '3500',
            'pet' => '1',
            'deposit_amount' => '700',
            'pet_deposit_amount' => '150',
            'amount_refundable' => '0',
            'bed_amount' => '7',
            'bath_amount' => '9',
            'square_footage' => '5502',
            'description' => 'supa big',
            'company_id' => '2',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);


        // TENANTS

        // tenant 1 user account
        DB::table('users')->insert([
            'name' => 'Steve Rogers',
            'email' => 'steve.rogers@avengers.com',
            'email_verified_at' => Carbon::now(),
            'password' => bcrypt('test'),
            'company_id' => '1',
            'remember_token' => '',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('tenants')->insert([
            'phone' => '7895477854',
            'work_phone' => '9998885412',
            'secondary_name' => '',
            'secondary_phone' => '',
            'secondary_work_phone' => '',
            'secondary_email' => '',
            'number_occupants' => '1',
            'active' => '1',
            'property_id' => '1', // tie to their property
            'user_id' => '4', // tie to their user account
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        
        // tenant 2 user account
        DB::table('users')->insert([
            'name' => 'Thor Odinson',
            'email' => 'thor.odinson@avengers.com',
            'email_verified_at' => Carbon::now(),
            'password' => bcrypt('test'),
            'company_id' => '1',
            'remember_token' => '',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('tenants')->insert([     
            'phone' => '5457847896',
            'work_phone' => '9996665412',
            'secondary_name' => '',
            'secondary_phone' => '',
            'secondary_work_phone' => '',
            'secondary_email' => '',
            'number_occupants' => '1',
            'active' => '1',
            'user_id' => '5',
            'property_id' => '2',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // tenant 3 user account
        DB::table('users')->insert([
            'name' => 'Harry Osborn',
            'email' => 'harry@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => bcrypt('test'),
            'company_id' => '2',
            'remember_token' => '',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('tenants')->insert([    
            'phone' => '8004569875',
            'work_phone' => '',
            'secondary_name' => '',
            'secondary_phone' => '',
            'secondary_work_phone' => '',
            'secondary_email' => '',
            'number_occupants' => '1',
            'active' => '1',
            'user_id' => '6',
            'property_id' => '3',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // TENANTS_COMPANY TABLE
        DB::table('tenants_companies')->insert([    
            'company_id' => '1',
            'tenant_id' => '1',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('tenants_companies')->insert([    
            'company_id' => '1',
            'tenant_id' => '2',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('tenants_companies')->insert([    
            'company_id' => '2',
            'tenant_id' => '3',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);


        // MAINTENANCE
        DB::table('maintenances')->insert([
            'subject' => 'Dishwasher leak! Help!',
            'type' => 'Appliances',
            'description' => 'My dishwasher has leaked through my flooring! Its dripping into my basement ceiling!',
            'emergency' => '1',
            'permission' => '1',
            'status' => '0',
            'company_id' => '1',
            'user_id' => '1',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('maintenances')->insert([
            'subject' => 'Shingles flying off my roof',
            'type' => 'Roof',
            'description' => 'After the storm yesterday, all my shingles are flying off the roof. Lets fix it before another storm hits us.',
            'emergency' => '0',
            'permission' => '1',
            'status' => '2',
            'company_id' => '1',
            'user_id' => '1',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('maintenances')->insert([
            'subject' => 'Toliet is clogged',
            'type' => 'Toilet Problems',
            'description' => 'I ate McDonalds and now its not flushing...',
            'emergency' => '1',
            'permission' => '1',
            'status' => '1',
            'company_id' => '2',
            'user_id' => '3',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);



    }
}
