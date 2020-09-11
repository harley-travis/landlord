<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\SetupPayment;
use Illuminate\Http\Request;

class SetupPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $users = SetupPayment::join('users', 'setup_payments.user_id', '=', 'users.id')
                ->paginate(20);

        $singleUser = SetupPayment::join('users', 'setup_payments.user_id', '=', 'users.id')
                ->where('users.id', '=', Auth::user()->id)
                ->paginate(20);
        
        $check = SetupPayment::get();

                /**
                 * need to figure out a way to display the add payment option if there is no pricing setup for both admins and for users.
                 * how to check that
                 */

        return view('pricing-wizard.index', ['users' => $users, 'check' => $check, 'singleUser' => $singleUser]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $users = User::where('role', '====', '3')->get();
        //$users = SetupPayment::join('users', 'setup_payments.user_id', '=', 'users.id')
                            ///->where('users.role', '!=', '3')->get();

        // $users = User::join('setup_payments', 'users.id', 'setup_payments.user_id')
        //                     ->where('setup_payments.user_id', '=', null)->get();

        return view('pricing-wizard.create', ['users' => $users]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        
        $request->validate([
            'numberOfProperties' => 'required',
        ]);

        /**
         * need to put this check someowhere. not sure how to add a proceed button without checking. 
         * 
         * poup alert. save if there is a current check. 
         * 
         * maybe we don't even need to check it. just have a popup windwo that says if there is currently pricing that it will override and 
         * have them click confirm to proceed.
         */
        // if there is a record, then we need alert them and ask them to replace the current pricing. 
        $check = SetupPayment::where('user_id', '=', $request->input('user_id'))->first();

        if($check === null) {

            // $fees = $this->calculateStripeFees($request);
            // $priceAmount = $this->calculatePricing($request);    
            
            $numberOfProperties = $request->input('numberOfProperties');
            $highestRentAmount = $request->input('highestRentAmount'); 

            // Stripe fee calculations 
            $totalMonthlyRentAmount = $highestRentAmount * $numberOfProperties;
            $payoutFee = number_format($totalMonthlyRentAmount * 0.0025,2); // 0.0025 is the payout fee
            $totalFees = $payoutFee + 2; // 2 is the number of active user dollars

            // pricing total
            /**
             * NEED TO ROUND UP!!! WE COULD STILL LOSE MONEY IF IT IS IN CENTS
             * when filtering names, we need to remove the ones that have pricing setup
             */
            $pricing = ($totalFees *.5) + $totalFees; 
            $priceAmount = '';

            if($pricing > 100) {
                $priceAmount = $pricing;
            } else {
                $priceAmount = 200; 
            }

            // find the company id 
            $company = User::where('id', '=', $request->input('user_id'))->first();
            $company_id = $company->company_id;

            $pricing = new SetupPayment([
                'numberOfProperties' => $request->input('numberOfProperties'),
                'highestRentAmount' => $request->input('highestRentAmount'),
                'payoutFee' => $totalFees,
                'fixedPricing' => $request->input('fixedPricing'),
                'pricingAmount' => $priceAmount, 
                'company_id' => $company_id,
            ]);
            $pricing->save();

            return redirect()
                    ->route('pricing-wizard.index')
                    ->with('info', 'Good News! The pricing for the account has been set.');

        } else {

            return redirect()
                ->back()
                ->with('warning', 'It looks like that there is already pricing attached to this user. If you save, it will remove the current pricing.');

        }

    }

    public function calculateStripeFees(Request $request) {

        $numberOfProperties = $request->input('numberOfProperties');
        $highestRentAmount = $request->input('highestRentAmount'); 

        // Stripe fee calculations 
        $totalMonthlyRentAmount = $highestRentAmount * $numberOfProperties;
        $payoutFee = number_format($totalMonthlyRentAmount * 0.0025,2); // 0.0025 is the payout fee 
        $totalFees = $payoutFee + 2; // 2 is the number of active user dollars

        return $totalFees;

    }

    public function calculatePricing(Request $request) {

        $numberOfProperties = $request->input('numberOfProperties');
        $highestRentAmount = $request->input('highestRentAmount'); 

        // Stripe fee calculations 
        $totalMonthlyRentAmount = $highestRentAmount * $numberOfProperties;
        $payoutFee = $totalMonthlyRentAmount * 0.0025; // 0.0025 is the payout fee
        $totalFees = $payoutFee + 2; // 2 is the number of active user dollars

        // pricing total
        /**
         * NEED TO ROUND UP!!! WE COULD STILL LOSE MONEY IF IT IS IN CENTS
         * when filtering names, we need to remove the ones that have pricing setup
         */
        $pricing = ($totalFees *.5) + $totalFees; 
        $priceAmount = '';

        if($pricing > 100) {
            $priceAmount = $pricing;
        } else {
            $priceAmount = 200; 
        }

        return $priceAmount; 

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SetupPayment  $setupPayment
     * @return \Illuminate\Http\Response
     */
    public function show(SetupPayment $setupPayment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SetupPayment  $setupPayment
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $payment = SetupPayment::where('user_id', '=', $id)->first();
        $users = User::where('role', '====', '3')->get();

        return view('pricing-wizard.edit', ['payment' => $payment, 'users' => $users]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SetupPayment  $setupPayment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SetupPayment $setupPayment) {
        
        $request->validate([
            'numberOfProperties' => 'required',
        ]);

        /**
         * NEED TO CALL THE OTHER FUNCTIONS TO CALCULATE THE PRICING HERRE
         */

        

        $payment = SetupPayment::find($request->input('id'));
        $payment->numberOfProperties = $request->input('numberOfProperties');
        $payment->highestRentAmount = $request->input('highestRentAmount');
        $payment->minimumPricing = $request->input('minimumPricing');
        $payment->percentAmount = $request->input('percentAmount');
        $payment->fixedPricing = $request->input('fixedPricing');
        $payment->save();

        return redirect()
                ->route('pricing-wizard.index')
                ->with('info', 'Hey great news, that pricing was updated boss!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SetupPayment  $setupPayment
     * @return \Illuminate\Http\Response
     */
    public function destroy(SetupPayment $setupPayment)
    {
        //
    }
}
