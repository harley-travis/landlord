<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Rent;
use App\Property;
use App\Tenant;
use App\Transaction;
use Carbon\Carbon;
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

        // figure the late fee
        if( $request->input('late_fee_amount') === null || $request->input('late_fee_amount') <= 0) {
            $latefee = 0;
        } else {
            $latefee = $request->input('late_fee_amount');
        }

        $property = Property::join('rents', 'rents.property_id', '=', 'properties.id')
                            ->where('properties.id', '=', $property_id)
                            ->first();

        // calculate the balance
        $currentBalance = $this->calculateRentBalance($tenant_id) + $property->rent_amount;
        $newBalance = 0;

        if( $currentBalance != 0 ) {

            if( $currentBalance > $request->input('amount_paid') || $currentBalance === $property->rent_amount || $currentBalance < $property->rent_amount && $currentBalance >= 0 ) {
                $newBalance = $currentBalance - $request->input('amount_paid');
            } elseif( $currentBalance < 0 ) {
                $calcTotal = number_format( (-$currentBalance) + $property->rent_amount );
            }

            
        } else {
            $newBalance = ( $property->rent_amount - $request->input('amount_paid'));
        }

        // calc paid in full
        $paid_in_full = 0;
        if( $newBalance <= 0 ) {
            $paid_in_full = 1;
        }

        // generate the confirmation code
        $confirmationNumber = str_random(10);

        $transaction = new Transaction([
            'tenant_id' => $tenant_id,
            'landlord_id' => $landlord_id,
            'property_id' => $property_id,
            'amount_paid' => $request->input('amount_paid'),
            'balance' => $newBalance,
            'payment_method' => 'cash/check',
            'paid_in_full' => $paid_in_full,
            'late_fee_amount' => $latefee,
            'confirmation' => $confirmationNumber,
        ]);
        $transaction->save();

        // send email to tenant

        return redirect()
                ->route('tenants.index')
                ->with('info', 'Good job! You have successfully entered the tenants rent payment for the month. It will reflect on the tenants page.');

    }

    public function calculateRentBalance($tenant_id) {

        $balanceAmount = Transaction::where('tenant_id', '=', $tenant_id)->get();
        $balance = $balanceAmount->pluck('balance');

        if( $balanceAmount === null || !isset($balanceAmount) ) {
            return 0;
        }

        if( count($balance) === 0 ) {
            return 0;
        } else {

            $b = 0;
            foreach ( $balanceAmount as $value ) {
                $b += $value->balance;

                // update the record to 0 so we're only writing the current balance
                $transaction = Transaction::where('tenant_id', '=', $tenant_id)->where('id', '=', $value->id)->first();
                $transaction->balance = 0;
                $transaction->save();
            }
            
        }

        return $b;
    }

}
