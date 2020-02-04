<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Mail;
use App\User;
use App\Tenant;
use App\Rent;
use App\Property;
use App\Company;
use App\Transaction;
use Carbon\Carbon;
use Stripe_Error;
use Illuminate\Http\Request;
use App\Mail\UserCreated;
use App\Mail\PaymentConfirmation;

class BillingController extends Controller {

    /**
     * https://www.youtube.com/watch?v=OtLmqDpH-C8
     */

    public function __construct() {
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
    }

    public function getUser() {
        $user = User::find(Auth::user()->id);

        return $user;
    }

    public function getCustomer() {
        $customer = \Stripe\Customer::retrieve($this->getUser()->stripe_id);

        return $customer;
    }

    public function getTenant() {
        $tenant = Tenant::where('user_id', '=', Auth::user()->id)->first();
        
        return $tenant;
    }

    public function getInvoices() {
        $invoices = \Stripe\Invoice::all(
            [
                 // 'limit' => 12,
                "customer" => $this->getUser()->stripe_id,
            ]
        );

        return $invoices;
    }

    private function getBankAccounts() {

        $bank_accounts = \Stripe\Customer::allSources(
            $this->getUser()->stripe_id,
            [
              'object' => 'bank_account',
            ]
        );

        //dd($bank_accounts);

        return $bank_accounts;

    }

    public function getStripeAccount() {

        $connect_bank_account = \Stripe\Account::retrieve(
            $this->getUser()->stripe_account
        );

        return $connect_bank_account;

    }
    
    public function index() {

        $user = User::find(Auth::user()->id);

        return view('settings.billing.index', [
            'user' => $this->getUser(),
            'bank_accounts' => $this->getBankAccounts(), 
            'invoices' => $this->getInvoices(),
            'customer' => $this->getCustomer(), 
            'intent' => $user->createSetupIntent(),
            'connect_accounts' => $this->getStripeAccount(),
        ]);

    }

    public function getTrialBeginView() {
        return view('settings.billing.trial.begin');
    }

    public function getTrialEndView() {
        return view('settings.billing.trial.end');
    }

    public function showConfirmation() {
        return view('settings.billing.express');
    }

    public function create() {

        $user = User::find(Auth::user()->id);

        return view('settings.billing.subscription.create', [
            'intent' => $user->createSetupIntent()
        ]);

    }

    public function store(Request $request) {

        $user = auth()->user();

        $paymentMethod = $request->payment_method;

        // monthly $15/mon $2 property
        $planId = 'plan_GFq5J9sIXkOyh4';

        // plan based on the user product
        //$plan = $user->product;

        /**
         * NEED TO CREATE/GRAB ALL THE PLAN IDS FOR THIS 
         */
        // if($plan === 1) {
        //     $planId = 'plan_GFq5J9sIXkOyh4';
        // } else if ($plan === 2 ) {
        //     $planId = 'plan_GFq5J9sIXkOyh4';
        // } else if ($plan === 3) {
        //     $planId = 'plan_GFq5J9sIXkOyh4';
        // } else if ($plan === 4) {
        //     $planId = 'plan_GFq5J9sIXkOyh4';
        // }

        // if we want to grab it from the form
        //$planId = $request->plan;

        if( Auth::user()->role != 0 ) {

            $subscription = \Stripe\Subscription::create([
                'customer' => $user->stripe_id,
                'items' => [
                    [
                        'plan' => $planId,
                    // 'quantity' => 100,
                    ],
                ],
            ]);

        } else {

            $customer = \Stripe\Customer::update([
                Auth::user()->stripe_id,
                'source' => $request->input('stripeToken'),
            ]);

        }

        //$user->newSubscription('default', $planId)->create($paymentMethod);

        // /$user->subscription('default')->incrementQuantity(100);

        //return response(['status' => 'success']);
        return view('settings.billing.subscription.index');     

    }


    /**
     * Property owners monthly payment fee to SenRent
     */
    public function singleOwnerCharge() {

        /**
         * before I charge the card i must figure out how to work the intent. 
         * you only need to get the intet once???
         * 
         * NEED TO DECLARE THEY PAYMENT METHOD!
         */

        $user = User::find(Auth::user()->id);

        $paymentMethod = $user->paymentMethod();
        
        $numberOfProperties = DB::table('company_tenant')->where('company_id', '=', $user->company_id)->count();

        if( $user->product === 1 ) {

            $base = 1500; // $15
            $freeProperties = 5; // 5 free properties
            $amountPerProperty = 200; // $2
            $sum = ( $numberOfProperties - $freeProperties * $amountPerProperty ) + $base * 100;
            $taxAmount = .12; // 12% NEED TO TALK TO MOORE ABOUT THIS. I THINK I NEED AN ARRAY TO PULL FROM TO CHARGE
            $total = ( $sum * $taxAmount ) + $sum;

            try {

                $payment = $user->charge($total, $paymentMethod, [
                    'custom_option' => $total,
                ]);

                return redirect()
                        ->route('billing.index')
                        ->with('info', 'We have successfully charged your account. The payment will take 3-5 business days to process.');
            
            } catch (Exception $e) {
                
                return redirect()
                        ->route('billing.index')
                        ->with('danger', 'There was an error processing your payment. Please try again, or contact customer support');
    
            }
            
        } else if( $user->product === 2 ) {

            $base = 1500; // $15
            $freeProperties = 5; // 5 free properties
            $amountPerProperty = 200; // $2
            $sum = ( $numberOfProperties - $freeProperties * $amountPerProperty ) + $base * 100;
            $taxAmount = .12; // 12% NEED TO TALK TO MOORE ABOUT THIS. I THINK I NEED AN ARRAY TO PULL FROM TO CHARGE
            $total = ( $sum * $taxAmount ) + $sum;

            try {

                $payment = $user->charge($total, $paymentMethod, [
                    'custom_option' => $total,
                ]);

                return redirect()
                        ->route('billing.index')
                        ->with('info', 'We have successfully charged your account. The payment will take 3-5 business days to process.');
    
            } catch (Exception $e) {
                
                return redirect()
                        ->route('billing.index')
                        ->with('danger', 'There was an error processing your payment. Please try again, or contact customer support');
    
            }

        } else if( $user->product === 3 ) {

            $base = 1500; // $15
            $freeProperties = 5; // 5 free properties
            $amountPerProperty = 200; // $2
            $sum = ( $numberOfProperties - $freeProperties * $amountPerProperty ) + $base * 100;
            $taxAmount = .12; // 12% NEED TO TALK TO MOORE ABOUT THIS. I THINK I NEED AN ARRAY TO PULL FROM TO CHARGE
            $total = ( $sum * $taxAmount ) + $sum;

            try {

                $payment = $user->charge($total, $paymentMethod, [
                    'custom_option' => $total,
                ]);

                return redirect()
                        ->route('billing.index')
                        ->with('info', 'We have successfully charged your account. The payment will take 3-5 business days to process.');
    
            } catch (Exception $e) {
                
                return redirect()
                        ->route('billing.index')
                        ->with('danger', 'There was an error processing your payment. Please try again, or contact customer support');
    
            }

        }

    }

    public function singleTenantCharge() {

    }

    /**
     * allow the tenant to enroll in autopay
     */
    public function createTenantSubscription() {

    }

    public function taxPercentage() {
        /**
         * This function can only work on subscriptions 
         */
        return 20;
    }
    
    public function createACH() {
        $user = User::find(Auth::user()->id);

        return view('settings.billing.ach.create', [
            'intent' => $user->createSetupIntent(),
        ]);
    }

    public function storeACH(Request $request) {
 
        $user = User::find(Auth::user()->id);

        // what i had before i started changing things
        $bank_account = \Stripe\Customer::createSource(
            $user->stripe_id,
          [
            'bank_account' => [
                'account_holder_name' => $request->input('account_holder_name'),
                'routing_number' => $request->input('routing_number'),
                'account_number' => $request->input('account_number'),
                'account_holder_type' => $request->input('account_holder_type'),
                'country' => 'US',
                'currency' => 'usd',     
            ],
          ]
        );

        /**
         * MOVED THIS TO IT'S OWN FUNCTION
         */

        // if the user is not a tenant create a subscription
        // if( $user->product > 1 ) { 
        //     $this->createOwnerSubscription();
        // } else {
        //     $this->createTenantSubscription();
        // }

        // delete the trial period in the database
        // should setup logic to make sure that all the bank information is added.
        // otherwise it will unlock it for them regardless
        $user->trial_ends_at = null;
        $user->save();

        return redirect()
            ->route('settings.billing.index', [
                'bank_accounts' => $this->getBankAccounts(), 
                'customer' => $this->getCustomer(), 
                'invoices' => $this->getInvoices(),
            ])->with('info', 'Your account was successfully added. Check your account in 1-2 business days to see 2 small deposits. Verify you account by entering in those deposit amounts. Deposits take 1-3 business days.');

    }

    public function verifyACH($id) {
        return view('settings.billing.ach.verify', ['id' => $id]);
    }

    public function storeVerifyACH(Request $request) {

        $user = User::find(Auth::user()->id);
        $customer = \Stripe\Customer::retrieve($user->stripe_id);

        // get the existing bank account
        $bank_account = \Stripe\Customer::retrieveSource(
            $user->stripe_id,
            $request->input('id')
        );
        
        try {

            // verify the amounts
            $bank_account->verify([
                'amounts' => [
                    $request->input('value1') * 100, 
                    $request->input('value2') * 100,
                ]
            ]);

            $bank_accounts = \Stripe\Customer::allSources(
                $user->stripe_id,
                [
                    'object' => 'bank_account',
                ]
            );

            $invoices = \Stripe\Invoice::all(
                [
                    // 'limit' => 12,
                    "customer" => $user->stripe_id,
                ]
            );

            /**
             * this might not work becuase what if it returns and error?
             * i did this assuming only successful attempts would work.
             * 
             * this is why it might be useful to have a separte verify button
             */
            // authorize / create subscription service
            //$this->createOwnerSubscription($bank_account->id);

            return redirect()
                ->route('settings.billing.index', [
                    'bank_accounts' => $bank_accounts, 
                    'customer' => $customer, 
                    'invoices' => $invoices,
                ])->with('info', 'Your account was successfully verified.');

        } 
        
        catch(\Stripe\Exception\CardException $e) {
            // Since it's a decline, \Stripe\Exception\CardException will be caught
            // echo 'Status is:' . $e->getHttpStatus() . '\n';
            // echo 'Type is:' . $e->getError()->type . '\n';
            // echo 'Code is:' . $e->getError()->code . '\n';
            // // param is '' in this case
            // echo 'Param is:' . $e->getError()->param . '\n';
            // echo 'Message is:' . $e->getError()->message . '\n';

            $bank_accounts = \Stripe\Customer::allSources(
                $user->stripe_id,
                [
                    'object' => 'bank_account',
                ]
            );

            $invoices = \Stripe\Invoice::all(
                [
                     // 'limit' => 12,
                    "customer" => $user->stripe_id,
                ]
            );

            return redirect()
                ->back()
                ->with('danger',  $e->getError()->message);


          } catch (\Stripe\Exception\RateLimitException $e) {

            $bank_accounts = \Stripe\Customer::allSources(
                $user->stripe_id,
                [
                    'object' => 'bank_account',
                ]
            );

            $invoices = \Stripe\Invoice::all(
                [
                     // 'limit' => 12,
                    "customer" => $user->stripe_id,
                ]
            );

            return redirect()
                ->back()
                ->with('danger',  $e->getError()->message);

          } catch (\Stripe\Exception\InvalidRequestException $e) {

            $bank_accounts = \Stripe\Customer::allSources(
                $user->stripe_id,
                [
                    'object' => 'bank_account',
                ]
            );

            $invoices = \Stripe\Invoice::all(
                [
                     // 'limit' => 12,
                    "customer" => $user->stripe_id,
                ]
            );

            return redirect()
                ->back()
                ->with('danger',  $e->getError()->message);

          } catch (\Stripe\Exception\AuthenticationException $e) {

            $bank_accounts = \Stripe\Customer::allSources(
                $user->stripe_id,
                [
                    'object' => 'bank_account',
                ]
            );

            $invoices = \Stripe\Invoice::all(
                [
                     // 'limit' => 12,
                    "customer" => $user->stripe_id,
                ]
            );

            return redirect()
                ->back()
                ->with('danger',  $e->getError()->message);

            // (maybe you changed API keys recently)
          } catch (\Stripe\Exception\ApiConnectionException $e) {

            $bank_accounts = \Stripe\Customer::allSources(
                $user->stripe_id,
                [
                    'object' => 'bank_account',
                ]
            );

            $invoices = \Stripe\Invoice::all(
                [
                     // 'limit' => 12,
                    "customer" => $user->stripe_id,
                ]
            );

            return redirect()
                ->back()
                ->with('danger',  $e->getError()->message);

          } catch (\Stripe\Exception\ApiErrorException $e) {

            $bank_accounts = \Stripe\Customer::allSources(
                $user->stripe_id,
                [
                    'object' => 'bank_account',
                ]
            );

            $invoices = \Stripe\Invoice::all(
                [
                     // 'limit' => 12,
                    "customer" => $user->stripe_id,
                ]
            );

            return redirect()
                ->back()
                ->with('danger',  $e->getError()->message);

            // yourself an email
          } catch (Exception $e) {

            $bank_accounts = \Stripe\Customer::allSources(
                $user->stripe_id,
                [
                    'object' => 'bank_account',
                ]
            );

            $invoices = \Stripe\Invoice::all(
                [
                     // 'limit' => 12,
                    "customer" => $user->stripe_id,
                ]
            );

            return redirect()
                ->back()
                ->with('danger',  $e->getError()->message);

          }  
    }

    public function destroyACH($id) {

        if( count($this->getBankAccounts()->data) <= 1 ) { 

            return redirect()
            ->route('settings.billing.index', [
                'bank_accounts' => $this->getBankAccounts(), 
                'customer' => $this->getCustomer(), 
            ])->with('danger', 'You are not able to remove an ACH account if there is no other account on file. Please add an ACH account then remove this account after. If you have any problems, please contact support for help');

        } else {

            \Stripe\Customer::deleteSource(
                $this->getUser()->stripe_id,
                $id
            );

            return redirect()
            ->route('settings.billing.index', [
                'bank_accounts' => $this->getBankAccounts(), 
                'customer' => $this->getCustomer(), 
                'invoices' => $this->getInvoices(),
            ])->with('info', 'Your account was successfully deleted.');

        }

    }

    public function activateTrial() {
        
        $user = User::find(Auth::user()->id);
        $user->createAsStripeCustomer();
        $user->trial_ends_at = now()->addDays(14);
        $user->save();

        $plan = \Stripe\Plan::create([
            "nickname" => $user->name ." Home Owner Metered Monthly",
            "product" => "prod_GVRCMzXFI6A2wS", // hard coded. i think i just need one of these
            "amount" => 0,
            "currency" => "usd",
            "interval" => "month",
            "usage_type" => "licensed",
           // "trial_end" => carbon()->now()->days(14),
        ]);

        // testing email
        // $e = 'travis.harley@senrent.com';
        // Mail::to($e)->send(new UserCreated($user));

        // live
        Mail::to($user->email)->send(new UserCreated($user));

        return redirect()
            ->route('dashboard')
            ->with('info', 'Your account was successfully created.');
    }

    /**
     * allow the home owner to enroll in autopay
     * be sure to clairfy that the payment will auto increase
     * if they add a new proprty
     */
    public function createOwnerSubscription($id) {

        /**
         * every time i delete or add a new account
         * it creates another subscription for me. 
         * need to figure out how to prevent adding more subscriptions 
         * so the user isn't charged mulitple times
         */

        /**
         * DO I NEED TO CREATE A SINGLE PRODUCT AND ATTACH PLANS TO THAT?
         * NAME THE PLAN'S AFTER THE CUSTOMERS NAME
         */

        /**
         * need to figure out how metered works. does it check every pay period? and then 
         * charge? 
         * does it charge based on unit price?
         */
        
        /**
         * Does the trial period work, and does it apply every month?
         */

         /**
          * NEED TO MAKE SURE THAT IT'S SUBSCRIBING TO THE DEFAULT PAYMENT.
          * IF THEY ADD A NEW PAYMENT, NEED TO MAKE SURE THEY'RE USING THIS PAYMENT
          */

          /**
           * when you verify and athorize, it charges immedialty. Which it should
           * unless you're still in your 14 day trial. 
           * not really a big bug though.
           * 
           * it's charge $0. need to see why it's not getting at least the $15 monthly fee
           */

        $user = User::find(Auth::user()->id);
        $customer = \Stripe\Customer::retrieve($user->stripe_id);

        $bank_accounts = \Stripe\Customer::allSources(
            $user->stripe_id,
            [
                'limit' => 3,
                'object' => 'bank_account',
            ]
        );

        $invoices = \Stripe\Invoice::all(
            [
                 // 'limit' => 12,
                "customer" => $user->stripe_id,
            ]
        );

        $base = 1500; // $15
        $additionalProperties = 200; // $2
        $freeUnits = 5;
        $usage = $this->calculateUsage();
        $amount = null;

        if( $usage <= $freeUnits ) {
            $amount = $base;
        } else if($usage === 1) {
            $amount = 0;
        } else {
            $amount = ( $usage - $freeUnits ) * $additionalProperties + $base;
        }

        try {

            $plan = \Stripe\Plan::create([
                "nickname" => $user->name ." Home Owner Metered Monthly",
                "product" => "prod_GVRCMzXFI6A2wS", // hard coded. i think i just need one of these
                "amount" => $amount,
                "billing_scheme" => "per_unit",
                "currency" => "usd",
                "interval" => "month",
                "interval_count" => 1,
                "trial_period_days" => 14,
            ]);

            $subscription = \Stripe\Subscription::create([
                "customer" => $user->stripe_id,
                "items" => [
                    [
                        "plan" => $plan->id,
                    ],
                ],
            ]);

            return redirect()
                ->route('settings.billing.index', [
                    'bank_accounts' => $bank_accounts, 
                    'customer' => $customer, 
                    'invoices' => $invoices,
                ])->with('info', 'You have successfully authorized this account. SenRent will bill you automatically each month. Check back here to see your billing history.');

          } catch(\Stripe\Exception\CardException $e) {
            
            return redirect()
                ->route('settings.billing.index', [
                    'bank_accounts' => $bank_accounts, 
                    'customer' => $customer, 
                    'invoices' => $invoices,
                ])->with('danger',  $e->getError()->message);

          } catch (\Stripe\Exception\RateLimitException $e) {
            
            return redirect()
                ->route('settings.billing.index', [
                    'bank_accounts' => $bank_accounts, 
                    'customer' => $customer, 
                    'invoices' => $invoices,
                ])->with('danger',  $e->getError()->message);

          } catch (\Stripe\Exception\InvalidRequestException $e) {
            
            return redirect()
                ->route('settings.billing.index', [
                    'bank_accounts' => $bank_accounts, 
                    'customer' => $customer, 
                    'invoices' => $invoices,
                ])->with('danger',  $e->getError()->message);

          } catch (\Stripe\Exception\AuthenticationException $e) {
            
            return redirect()
                ->route('settings.billing.index', [
                    'bank_accounts' => $bank_accounts, 
                    'customer' => $customer, 
                    'invoices' => $invoices,
                ])->with('danger',  $e->getError()->message);

          } catch (\Stripe\Exception\ApiConnectionException $e) {
            
            return redirect()
                ->route('settings.billing.index', [
                    'bank_accounts' => $bank_accounts, 
                    'customer' => $customer, 
                    'invoices' => $invoices,
                ])->with('danger',  $e->getError()->message);

          } catch (\Stripe\Exception\ApiErrorException $e) {
            
            return redirect()
                ->route('settings.billing.index', [
                    'bank_accounts' => $bank_accounts, 
                    'customer' => $customer, 
                    'invoices' => $invoices,
                ])->with('danger',  $e->getError()->message);

          } catch (Exception $e) {
            
            return redirect()
                ->route('settings.billing.index', [
                    'bank_accounts' => $bank_accounts, 
                    'customer' => $customer, 
                    'invoices' => $invoices,
                ])->with('danger',  $e->getError()->message);

          }
    }

    public function calculateUsage() {

        $amount = DB::table('company_tenant')->where('company_id', '=', $this->getUser()->company_id)->count();

        return $amount;

    }

    public function setDefaultPaymentMethod($payment) {

        $update = \Stripe\Customer::update(
            $this->getUser()->stripe_id,
            [
              'default_source' => $payment,
            ]
        );

        return redirect()
            ->route('settings.billing.index', [
            'bank_accounts' => $this->getBankAccounts(), 
            'customer' => $this->getCustomer(), 
            'invoices' => $this->getInvoices(),
        ])->with('info', 'Your default payment has be set successfully!');

    }

    public function showExpressConnection() {
        return view('settings.billing.express');
    }

    public function completeExpressConnection(Request $request) {

        $response = \Stripe\OAuth::token([
            'grant_type' => 'authorization_code',
            'code' => $request->input('code'),
        ]);
            
        // Access the connected account id in the response
        $connected_account_id = $response->stripe_user_id;

        $user = User::find(Auth::user()->id);
        $user->stripe_account = $response->stripe_user_id;
        $user->save();

        return redirect()
            ->route('settings.billing.index', [
            'bank_accounts' => $this->getBankAccounts(), 
            'customer' => $this->getCustomer(), 
            'invoices' => $this->getInvoices(),
        ])->with('info', 'You have successfully completed the onboarding process! Have fun!');

    }

    public function calculateRentDueDate() {

        $property = Property::join('rents', 'rents.property_id', '=', 'properties.id')
                            ->where('properties.id', '=', $this->getTenant()->property_id)
                            ->first();

        if( !isset($property->late_date) || $property->late_date === null || $property->late_date === 0 ) {
            $late_date = 17;
        } else {
            $late_date = $property->late_date;
        }

        $begin = Carbon::create(Carbon::now()->year, Carbon::now()->month, $late_date);
        $end = Carbon::create(Carbon::now()->year, Carbon::now()->month, Carbon::now()->daysInMonth);

        $comparison = Carbon::now()->isBetween(Carbon::now(), $begin, $end);

        return $comparison;

    }

    public function showPayIndex() {

        $property = Property::join('rents', 'rents.property_id', '=', 'properties.id')
                            ->where('properties.id', '=', $this->getTenant()->property_id)
                            ->first();
        
        $balance = $this->calculateRentBalance();
        $betweenDates = $this->calculateRentDueDate();
       
        return view('tenants.billing.index', [
                    'tenant' => $this->getTenant(),
                    'property' => $property,
                    'balance' => $balance,
                    'betweenDates' => $betweenDates,
        ]);
    }

    public function showPay(Request $request) {
       
        $property = Property::join('rents', 'rents.property_id', '=', 'properties.id')
                            ->where('properties.id', '=', $this->getTenant()->property_id)
                            ->first();

        $amount = $request->input('amount');
        $late_fee = $request->input('late_fee');

        return view('tenants.billing.pay', [
                    'tenant' => $this->getTenant(),
                    'property' => $property,
                    'bank_accounts' => $this->getBankAccounts(),
                    'customer' => $this->getCustomer(),
                    'amount' => $amount,
                    'late_fee' => $late_fee,
        ]);
        
    }

    public function storePayReview(Request $request) {

        $date = $request->input('date');
        $source = $request->input('source');
        $amount = $request->input('amount');
        $late_fee = $request->input('late_fee');
        $convenience = 5;
        $total = $amount + $convenience;

        return view('tenants.billing.review', [
            'date' => $date,
            'source' => $source,
            'amount' => $amount,
            'late_fee' => $late_fee,
            'bank_account' => $this->getBankAccounts(),
            'customer' => $this->getCustomer(),
            'convenience' => $convenience,
        ]);
    }

    public function payRent(Request $request) {

        $user = Auth::user();
        $customer = \Stripe\Customer::retrieve($user->stripe_id);
        $tenant = Tenant::where('user_id', '=', Auth::user()->id)->first();

        $property = Property::join('rents', 'rents.property_id', '=', 'properties.id')
                            ->where('properties.id', '=', $this->getTenant()->property_id)
                            ->first();

        $company = Company::where('id', '=', Auth::user()->company_id);

        $proprietor = User::where('company_id', '=', Auth::user()->company_id)
                            ->where('role', '=', '3')
                            ->first();

        $bank_account = \Stripe\Customer::retrieveSource(
            $user->stripe_id,
            $request->input('source')
        );

        $amount = $request->input('rent') * 100;
        $setAmount = $property->rent_amount * 100;
        $findLateFeeAmount = $amount - $setAmount;
        $convenience = 500;
        $total = $amount + $convenience;
        $confirmationNumber = str_random(10);

     
        try {

            /**
             * CURRENTLY THIS IS USING THE CHARGE METHOD WHICH 
             * I THINK WORKS BUT IS MEANT FOR REGULAR CHARGES 
             * AND FOR CREDIT CARDS
             * 
             * WITH CONNECT, WE WANT TO USE THE TRANSFER METHOD
             * https://stripe.com/docs/api/transfers/create
             */

            $charge = \Stripe\Charge::create([
                'amount' => $total, 
                'currency' => "usd",
                'source' => $bank_account, 
                'customer' => $this->getCustomer()->id,
                'metadata' => [
                    'ConfirmationNumber' => $confirmationNumber,
                    'email' => $user->email,
                ],
                'transfer_data' => [
                    'amount' => $total, 
                    'destination' => $proprietor->stripe_account, 
                ],
            ]);  

        } catch( Exception $e ) {

            // for failure upon use
            // I don't think this is doing anything. but i'll leave it for safe keeping
            return redirect()
                ->route('settings.billing.index', [
                    'user' => $this->getUser(),
                    'bank_accounts' => $this->getBankAccounts(), 
                    'invoices' => $this->getInvoices(),
                    'customer' => $this->getCustomer(), 
                    'intent' => $this->getUser(),
                    'connect_accounts' => $this->getStripeAccount(),
                ])->with('danger',  $e);

        } 

            // calculate the new balance
            $currentBalance = $this->calculateRentBalance();
            $newBalance = ( $request->input('rent') + $currentBalance ) - $currentBalance;

            // i don't think i add this here. i'm not charging the late fee
            // need to read more about this 
            $lateFee = 0;
            if( $amount > $setAmount ) {
                $lateFee = $findLateFeeAmount;
            }

            $transaction = new Transaction([
                'tenant_id' => $tenant->id,
                'landlord_id' => $proprietor->id,
                'property_id' => $property->id,
                'amount_paid' => $charge->amount,
                'balance' => $newBalance,
                'payment_method' => $charge->payment_method_details->type,
                'paid_in_full' => 0,
                'late_fee_amount' => $lateFee,
                'confirmation' => $confirmationNumber,
            ]);
            $transaction->save();
                
            return view('tenants.billing.confirmation', [
                'confirmation_number' => $confirmationNumber,
                'amount' => $charge->amount,
                'payment_method' => $charge->payment_method_details->type,
                'date' => $transaction->created_at,
            ]);
    }

    public function calculateRentBalance() {

        $id = User::join('tenants', 'tenants.user_id', '=', 'users.id')
                ->where('tenants.user_id', '=', Auth::user()->id)
                ->first();

        $balanceAmount = Transaction::where('tenant_id', '=', $id->id)->get();

        if( count($balanceAmount) === 0 ) {
            return 0;
        } else {

            $b = 0;
            foreach ( $balanceAmount as $value ) {
                $b += $value->balance;
            }
            
        }

        return $b;
    }

    public function showPaymentConfirmation() {
        return view('tenants.billing.confirmation');
    }

}
