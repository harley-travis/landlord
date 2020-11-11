<?php

namespace App\Http\Controllers;

use Auth;
use DB;
use App\User;
use Carbon\Carbon;
use App\Property;
use App\Rent;
use App\Tenant;
use App\Company;
use App\Community;
use App\SetupPayment;
use Illuminate\Http\Request;
use Illuminate\Session\Store;

class PropertyController extends Controller {
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $properties = Property::where('company_id', '=', Auth::user()->company_id)
            ->paginate(15);

        // $rents = Rent::where('company_id', '=', Auth::user()->company_id)
        //     ->paginate(15);

        $rents = Rent::join('properties', 'rents.property_id', '=', 'properties.id')
            ->where('properties.company_id', '=', Auth::user()->company_id)
            ->paginate(15);

        $communities = Community::join('properties', 'communities.id', '=', 'properties.community_id')
            ->where('communities.company_id', '=', Auth::user()->company_id)
            ->paginate(15);


        $avaliable = Property::join('rents', 'rents.property_id', '=', 'properties.id')
            ->where('properties.company_id', '=', Auth::user()->company_id)
            ->where('properties.occupied', '=', 0)
            ->paginate(15);

        $occupied = User::join('tenants', 'users.id', '=', 'tenants.user_id')
            ->join('properties', 'tenants.property_id', '=', 'properties.id')
            ->where('properties.company_id', '=', Auth::user()->company_id)
            ->where('users.company_id', '=', Auth::user()->company_id)
            ->where('tenants.active', '=', 1)
            ->paginate(15);

        $company = Company::where('id', '=', Auth::user()->company_id)->first();
        
        return view('property.index', [
            'properties' => $properties, 
            'communities' => $communities, 
            'company' => $company,
            'occupied' => $occupied,
            'avaliable' => $avaliable,
            'rents' => $rents
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {

        $communities = Community::where('company_id', '=', Auth::user()->company_id)->get();
        return view('property.create'
        );

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {

        $request->validate([
            'address_1' => 'required',
            'city' => 'required',
            'zip' => 'required',
            'state' => 'required',
            'country' => 'required',
            'city' => 'required',
            'rent_amount' => 'required',
        ]);

        $property = new Property([
            'address_1' => $request->input('address_1'),
            'address_2' => $request->input('address_2'),
            'address_3' => $request->input('address_3'),
            'city' => $request->input('city'),
            'state' => $request->input('state'),
            'zip' => $request->input('zip'),
            'country' => $request->input('country'),
            'occupied' => 0,
            'pet' => $request->input('pet'),
            'bed_amount' => $request->input('bed_amount'),
            'bath_amount' => $request->input('bath_amount'),
            'square_footage' => $request->input('square_footage'),
            'description' => $request->input('description'),
            'community_id' => $request->input('community_id'),
            'company_id' => Auth::user()->company_id,
        ]);
        $property->save();

        $rent = new Rent([
            'lease_length'=> $request->input('lease_length'),
            'rent_amount' => $request->input('rent_amount'),
            'deposit_amount' => $request->input('deposit_amount'),
            'pet_deposit_amount' => $request->input('pet_deposit_amount'),
            'amount_refundable' => $request->input('amount_refundable'),
            'late_date' => $request->input('late_date'),
            'late_fee' => $request->input('late_fee'),
            'account_number' => $request->input('account_number'),
            'hoa_amount' => $request->input('hoa_amount'),
            'property_id' => $property->id,
            'company_id' => Auth::user()->company_id,
            'paid' => 0,
        ]);
        $rent->save();

        // update the total number of properties
        $numberOfProperties = SetupPayment::where('company_id', '=', Auth::user()->company_id)->first();
        $numberOfProperties->numberOfProperties++;
        $newPrice = $this->calculateUsage();
        $numberOfProperties->pricingAmount = $newPrice;
        $numberOfProperties->save();

        // update the setup payment table
        $this->updatePricing( $request->input('rent_amount') );
        
        return redirect()
                ->route('property.index')
                ->with('info', 'Good job! Your property was saved successfully! Head over to the Tenants page to assign the property to a tenant');

    }

    public function updatePricing($a) {

        $rentAmount = $a;

        // find the pricing table
        $numberOfProperties = SetupPayment::where('company_id', '=', Auth::user()->company_id)->first();

        // if the price that is passed through is higher than set in the db, update it
        if($rentAmount > $numberOfProperties->highestRentAmount) {
            $numberOfProperties->highestRentAmount = $rentAmount;
        } 

        // Stripe fee calculations 
        $totalMonthlyRentAmount = $numberOfProperties->highestRentAmount * ($numberOfProperties->numberOfProperties);
        $payoutFee = $totalMonthlyRentAmount * 0.0025; // 0.0025 is the payout fee
        $totalFees = $payoutFee + 3; // 2 is the number of active user dollars | adding an extra dollar for rounds. 

        // pricing total
        $pricing = ($totalFees *.5) + $totalFees; 
        $priceAmount = '';

        if($pricing > 200) {
            $priceAmount = $pricing;
        } else {
            $priceAmount = 200; 
        }

        $numberOfProperties->pricingAmount = $priceAmount;
        $numberOfProperties->save();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {

        $property = Property::where('company_id', '=', Auth::user()->company_id)->first();
        $rent = Rent::where('property_id', '=', $id)->first();
        $communities = Community::where('company_id', '=', Auth::user()->company_id)->get();
        $tenant = Tenant::where('property_id', '=', $id)->first();

        return view('property.edit', [
            'property' => $property, 
            'rent' => $rent, 
            'tenant' => $tenant,
            'property_id' => $id,
            'communities' => $communities
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Property $property) {

        $request->validate([
            'address_1' => 'required',
            'city' => 'required',
            'zip' => 'required',
            'state' => 'required',
            'country' => 'required',
            'city' => 'required',
        ]);
          
        $property = Property::find($request->input('property_id'));
        $property->address_1 = $request->input('address_1');
        $property->address_2 = $request->input('address_2');
        $property->city = $request->input('city');
        $property->state = $request->input('state');
        $property->zip = $request->input('zip');
        $property->country = $request->input('country');
        $property->occupied = $request->input('occupied');
        $property->pet = $request->input('pet');
        $property->bed_amount = $request->input('bed_amount');
        $property->bath_amount = $request->input('bath_amount');
        $property->square_footage = $request->input('square_footage');
        $property->description = $request->input('description');
        $property->community_id = $request->input('community_id');
        $property->save();

        $rent = Rent::find($request->input('rent_id'));
        $rent->rent_amount = $request->input('rent_amount');
        $rent->deposit_amount = $request->input('deposit_amount');
        $rent->pet_deposit_amount = $request->input('pet_deposit_amount');
        $rent->amount_refundable = $request->input('amount_refundable');
        $rent->lease_length = $request->input('lease_length');
        $rent->late_date = $request->input('late_date');
        $rent->late_fee = $request->input('late_fee');
        $rent->account_number = $request->input('account_number');
        $rent->hoa_amount = $request->input('hoa_amount');
        $rent->save();

        return redirect()
                ->route('property.index')
                ->with('info', 'Good job! Your property was updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {

        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        $property = Property::find($id);
        $property->delete();

        // // update the total number of properties
        $numberOfProperties = SetupPayment::where('company_id', '=', Auth::user()->company_id)->first();
        $numberOfProperties->numberOfProperties--;

        // recalucate the monthly price
        $newPrice = $this->calculateUsage();
        
        if($numberOfProperties->numberOfProperties < 1) {
            $numberOfProperties->numberOfProperties = 0;
            $numberOfProperties->highestRentAmount = 0;
        } else {
            $numberOfProperties->pricingAmount = $newPrice;
        }

        $numberOfProperties->save();

        // update the pricing
        $this->updateSubscription($numberOfProperties);
        
        return redirect()
            ->route('property.index')
            ->with('info', 'Your property was successfully deleted');

    }

    public function updateSubscription($numberOfProperties) {

        // retreive the subscription data
        $subscriptionCost = DB::table('subscriptions')->where('user_id', '=', Auth::user()->id)->first();
        $subscription = \Stripe\Subscription::retrieve(
            $subscriptionCost->stripe_id
        );

        $priceId = $subscription->items->data[0]->price->id; // dont think i need this anymore
        $subscriptionAmount = $subscription->plan->amount_decimal / 100; // remove the cents

        // if the pricing does not match then update it
        if($numberOfProperties->pricingAmount != $subscriptionAmount) {

            // create a new pricing plan
            $priceObj = \Stripe\Price::create([
                "unit_amount" => $numberOfProperties->pricingAmount * 100,
                'currency' => 'usd',
                'recurring' => [
                    'interval' => 'month',
                    'usage_type' => 'metered',
                ],
                "product" => env('MONTHY_SUBSCRIPTION_PRODUCT'), // hard coded. i think i just need one of these
            ]);

            // update the subscription to the new price
            \Stripe\Subscription::update($subscriptionCost->stripe_id, [
            'items' => [
                    [
                        'id' => $subscription->items->data[0]->id,
                        'price' => $priceObj->id,
                    ],
                ],
            "billing_cycle_anchor" => "unchanged",
            ]);

        }
        
    }

    public function calculateUsage() {

        $company_id = Company::where('id', '=', Auth::user()->company_id)->pluck('id');
        $paymentSetup = SetupPayment::where('company_id', '=', Auth::user()->company_id)->first();

        $numberOfProperties = $paymentSetup->numberOfProperties;
        $highestRentAmount = DB::table('rents')
                ->where('company_id', '=', Auth::user()->company_id)
                ->max('rent_amount');
        

        if($highestRentAmount === null ) {
            $highestRentAmount = 0;
        }

        // Stripe fee calculations 
        $totalMonthlyRentAmount = $highestRentAmount * $numberOfProperties;
        $payoutFee = number_format($totalMonthlyRentAmount * 0.0025,2); // 0.0025 is the payout fee
        $totalFees = round($payoutFee + 3); // 2 is the number of active user dollars

        $pricing = ($totalFees *.5) + $totalFees; 
        $priceAmount = '';

        if($pricing > 100) {

            $priceAmount = $pricing;
            $paymentSetup->highestRentAmount = $highestRentAmount;
            $paymentSetup->pricingAmount = $priceAmount;
            $paymentSetup->save();

            return $priceAmount;

        } else {

            $priceAmount = 200; 
            $paymentSetup->highestRentAmount = $highestRentAmount;
            $paymentSetup->pricingAmount = $priceAmount;
            $paymentSetup->save();

            return $priceAmount;
        }

    }
}
