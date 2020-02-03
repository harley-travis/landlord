<?php

namespace App\Http\Controllers;

use Mail;
use Auth;
use App\User;
use App\Rent;
use App\Property;
use App\Tenant;
use App\Transaction;
use Carbon\Carbon;
use App\Mail\PaymentConfirmation;
use Illuminate\Http\Request;

class TransactionController extends Controller {


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id) {

        // get tenant by id
        $tenant = User::join('tenants', 'users.id', '=', 'tenants.user_id')
                            ->where('users.id', '=', $id)
                            ->first();

        return view('tenants.billing.payment.create', ['tenant' => $tenant]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        
        $request->validate([
            'amount_paid' => 'required',
        ]);

        
        $tenant_id = $request->input('tenant_id');
        $findPropertyId = Tenant::where('id', '=', $tenant_id)->first(); 
        $property_id =  $findPropertyId->property_id;
        $landlord_id = Auth::user()->id;
        $user = User::where('id', '=', $findPropertyId->user_id)->first();

        // figure the late fee
        $latefee = $this->calculateLateFee($request->input('late_fee_amount'));
        
        $property = Property::join('rents', 'rents.property_id', '=', 'properties.id')
                            ->where('properties.id', '=', $property_id)
                            ->first();

        // calculate the balance
        $amount_paid = $request->input('amount_paid');
        $currentBalance  = $this->calculateRentBalance($tenant_id) + $property->rent_amount;
        $newBalance = $this->calculateNewBalance($currentBalance, $amount_paid, $property->rent_amount); 


        //dd($newBalance);

        // calc paid in full
        $paid_in_full = 0;
        if( $newBalance  <= 0 ) {
            $paid_in_full = 1;
        }

        // generate the confirmation code
        $confirmationNumber = str_random(10);

        $transaction = new Transaction([
            'tenant_id' => $tenant_id,
            'landlord_id' => $landlord_id,
            'property_id' => $property_id,
            'amount_paid' => $amount_paid,
            //'balance' => $newBalance,
            'payment_method' => 'cash/check',
            'paid_in_full' => $paid_in_full,
            'late_fee_amount' => $latefee,
            'confirmation' => $confirmationNumber,
        ]);
        $transaction->save();


        //dd($newBalance);

        // save balance to rents table 
        $rents = Rent::where('property_id', '=', $property_id)->first();
        $rents->balance = $newBalance;
        $rents->save();

        // send email to tenant
       // Mail::to($user->email)->send(new PaymentConfirmation($user, $amount_paid));

        return redirect()
                ->route('tenants.index')
                ->with('info', 'Good job! You have successfully entered the tenants rent payment for the month. It will reflect on the tenants page.');

    }

    public function calculateLateFee($latefee) {

        if( $latefee === null || $latefee <= 0) {
            return 0;
        } else {
            return $latefee;
        }

    }

    public function calculateRentBalance($tenant_id) {

        $findPropertyId = Tenant::where('id', '=', $tenant_id)->first(); 
        $property_id =  $findPropertyId->property_id;

        $balanceAmount = Rent::where('property_id', '=', $property_id)->first();
        $balance = $balanceAmount->balance;

        if( $balanceAmount === null || $balanceAmount === 0 ) {
            return 0;
        } else {
            return $balance;
        }

    }

    public function calculateNewBalance($currentBalance, $amount_paid, $rent_amount) {
        
        $newBalance = 0;

        if( $currentBalance < 0 ) {

            $newBalance = (-$currentBalance) + $rent_amount;
            return $newBalance;

        } else  {

            $newBalance = $currentBalance - $amount_paid;
            return $newBalance;
        }

    }

    public function show($id) {

        $transaction = Transaction::where('id', '=', $id)->first();
        $tenant = User::join('tenants', 'users.id', '=', 'tenants.user_id')
                            ->where('tenants.id', '=', $transaction->tenant_id)
                            ->first();

        return view('tenants.billing.history.show', [
            'transaction' => $transaction, 
            'tenant'=> $tenant
        ]);

    }

    public function destroy($id) {

        // grab the last transaction amount

        // update the new balance 

        // delete the transaction

        $transaction = Transaction::find($id);
        $transaction->delete();

        return redirect()
            ->route('tenants.index')
            ->with('info', 'The transaction was deleted successfully.');

    }

}
