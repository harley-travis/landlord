<?php

use App\User;
use App\Company;
use App\Community;
use App\Property;
use App\Rent;
use App\Tenant;
use App\Maintenance;
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
        DB::table('companies')->insert([
            'name' => 'SenRent',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // SENRENT - USERS
        DB::table('users')->insert([
            'name' => 'Travis Harley',
            'email' =>'travis@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => bcrypt('test'),
            'company_id' => '1',
            'role' => '10',
            'product' => '10', 
            'remember_token' => '',
            'stripe_id' => 'cus_G3TGgX2v2na3KD', // dummy data. sorry no good hackers
            'card_brand' => 'Visa', 
            'card_last_four' => '5555',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // create 100 Home Owners
        $homeOwners = factory(Company::class, 1)->create(); 

        foreach( $homeOwners as $homeOwner ) {
            
            $ho_company_id = $homeOwner->id;

            // create the property owner
            factory(User::class)->create([
                'role' => '3',
                'product' => '1', 
                'company_id' => $ho_company_id
            ]);

            // create tenants       
            $ho_properties = factory(Property::class, 3)->create([
                'company_id' => $ho_company_id,
            ]);

            foreach($ho_properties as $ho_property){
            
                $ho_tenant = factory(Tenant::class)->create([
                    'property_id' => $ho_property->id,
                    'user_id' => factory(User::class)->create([
                        'role' => 0,
                        'product' => 0,
                        'company_id' => $ho_company_id,
                    ])
                ]);   
                
                $ho_rent = factory(Rent::class)->create([
                    'property_id' => $ho_property->id,
                    'account_number' => null,
                    'hoa_amount' => null,
                ]);

                DB::table('company_tenant')->insertGetId([
                    'company_id' => $ho_company_id,
                    'tenant_id' => $ho_tenant->id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),  
                ]);
    
            }

        }
        
        // create 100 Apartment Complexes
        $apartment_companies = factory(Company::class, 1)->create(); 

        foreach( $apartment_companies as $apartment_company ) {
            
            $a_company_id = $apartment_company->id;

            // create a maintenace worker
            factory(User::class)->create([
                'role' => '1',
                'product' => '2', 
                'company_id' => $a_company_id
            ]);

            // create an office manager
            factory(User::class)->create([
                'role' => '2',
                'product' => '2', 
                'company_id' => $a_company_id
            ]);

            // create the property owner
            factory(User::class)->create([
                'role' => '3',
                'product' => '2', 
                'company_id' => $a_company_id
            ]);

            // create tenants                 
            $a_properties = factory(Property::class, 15)->create([
                'company_id' => $a_company_id,
            ]);

            foreach($a_properties as $a_property){
            
                $a_tenant = factory(Tenant::class)->create([
                    'property_id' => $a_property->id,
                    'user_id' => factory(User::class)->create([
                        'role' => 0,
                        'product' => 0,
                        'company_id' => $a_company_id,
                    ])
                ]);
                
                $a_rent = factory(Rent::class)->create([
                    'property_id' => $a_property->id,
                    'account_number' => null,
                    'hoa_amount' => null,
                ]);

                DB::table('company_tenant')->insertGetId([
                    'company_id' => $a_company_id,
                    'tenant_id' => $a_tenant->id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),  
                ]);
    
            }
        }

        // create 100 Home Owner Associations 
        $hoa_companies = factory(Company::class, 1)->create(); 

        foreach( $hoa_companies as $hoa_company ) {
            
            $hoa_company_id = $hoa_company->id;

            // create a maintenace worker
            factory(User::class)->create([
                'role' => '1',
                'product' => '3', 
                'company_id' => $hoa_company_id
            ]);

            // create an office manager
            factory(User::class)->create([
                'role' => '2',
                'product' => '3', 
                'company_id' => $hoa_company_id
            ]);

            // create the property owner
            factory(User::class)->create([
                'role' => '3',
                'product' => '3', 
                'company_id' => $hoa_company_id
            ]);

            // create the communities
            $communities = factory(Community::class, 20)->create([
                'company_id' => $hoa_company_id,
            ]);

            foreach( $communities as $community ) {

                // create tenants         
                $hoa_properties = factory(Property::class, 10)->create([
                    'company_id' => $hoa_company_id,
                    'community_id' => $community->id,
                ]);

                foreach( $hoa_properties as $hoa_property ){

                    $hoa_tenant = factory(Tenant::class)->create([
                        'property_id' => $hoa_property->id,
                        'user_id' => factory(User::class)->create([
                            'role' => 0,
                            'product' => 0,
                            'company_id' => $hoa_company_id,
                        ])
                    ]);    

                    $hoa_rent = factory(Rent::class)->create([
                        'property_id' => $hoa_property->id,
                        'rent_amount' => null,
                        'deposit_amount' => null,
                        'pet_deposit_amount' => null,
                        'amount_refundable' => null,
                    ]);

                    DB::table('company_tenant')->insertGetId([
                        'company_id' => $hoa_company_id,
                        'tenant_id' => $hoa_tenant->id,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),  
                    ]);

                    DB::table('community_property')->insertGetId([
                        'community_id' => $community->id,
                        'property_id' => $hoa_property->id,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),  
                    ]);
        
                }

            }

        }


        // FEEDBACK
        DB::table('feedback')->insert([
            'subject' => 'Tenant background application checks',
            'description' => 'It would be cool if I could do tenant background checks through the app',
            'status' => '0',
            'company_id' => '2',
            'user_id' => '2',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

    }

}
