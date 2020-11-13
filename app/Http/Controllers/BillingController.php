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
use App\SetupPayment;
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

    public function getPaymentSetup() {

        $company_id = Company::where('id', '=', Auth::user()->company_id)->pluck('id');
        $paymentSetup = SetupPayment::where('company_id', '=', $company_id)->first();

        return $paymentSetup;

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

        if( $user->role != 0 ) {

            return view('settings.billing.index', [
                'user' => $this->getUser(),
                'bank_accounts' => $this->getBankAccounts(), 
                'invoices' => $this->getInvoices(),
                'customer' => $this->getCustomer(), 
                'intent' => $user->createSetupIntent(),
                'connect_accounts' => $this->getStripeAccount(),
                'bill' => $this->getPaymentSetup(),
            ]);

        } else {

            $charges = \Stripe\Charge::all(
                [
                   "customer" => $user->stripe_id
               ]
            );
    
            $tenant = Tenant::where('user_id', '=', $user->id)->first();
            $transactions = Transaction::where('tenant_id', '=', $tenant->id)
                                    ->where('payment_method', '=', 'cash/check')
                                    ->get();
    
            return view('settings.billing.index', [
                'user' => $this->getUser(),
                'bank_accounts' => $this->getBankAccounts(), 
                'invoices' => $this->getInvoices(),
                'charges' => $charges, 
                'transactions' => $transactions,
                'customer' => $this->getCustomer(), 
                'intent' => $user->createSetupIntent(),
                'connect_accounts' => $this->getStripeAccount(),
            ]);

        }

    }

    public function showCancel() {
        return view('settings.billing.cancel');
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

    public function landlordManualPaymentOverride() {

        // i need to create a gui for this 
        // maybe we lock in the price for the people rather than updating automatically

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
       
        // handle this with a token \
        $token = \Stripe\Token::create([
            'bank_account' => [
                'country' => 'US',
                'currency' => 'usd',
                'account_holder_name' => $request->input('account_holder_name'),
                'account_holder_type' => $request->input('account_holder_type'),
                'routing_number' => $request->input('routing_number'),
                'account_number' => $request->input('account_number'),
            ],
        ]);

        /// i need to see if this is working. i haven't tested just the token
        // $bank_account = \Stripe\Customer::createSource(
        //     $user->stripe_id,
        //   [$token]
        // );

        $bank_account = \Stripe\Customer::createSource(
            $user->stripe_id,
          ['source' => $token]
        );


        // old method
        // $bank_account = \Stripe\Customer::createSource(
        //     $user->stripe_id,
        //   [
        //     'bank_account' => [
        //         'account_holder_name' => $request->input('account_holder_name'),
        //         'routing_number' => $request->input('routing_number'),
        //         'account_number' => $request->input('account_number'),
        //         'account_holder_type' => $request->input('account_holder_type'),
        //         'country' => 'US',
        //         'currency' => 'usd',     
        //     ],
        //   ]
        // );


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
                'bill' => $this->getPaymentSetup(),
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
                    'bill' => $this->getPaymentSetup(),
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
                'bill' => $this->getPaymentSetup(),
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
                'bill' => $this->getPaymentSetup(),
            ])->with('info', 'Your account was successfully deleted.');

        }

    }

    public function activateTrial() {
        
        // create stripe account for new user
        $user = User::find(Auth::user()->id);
        $user->createAsStripeCustomer();
        $user->trial_ends_at = now()->addDays(14);
        $user->save();

        // calculate monthly cost
        $amount = $this->calculateUsage();

        // create a price object for the subscription
        $priceObj = \Stripe\Price::create([
            "unit_amount" => $amount * 100,
            'currency' => 'usd',
            'recurring' => [
                'interval' => 'month',
                'usage_type' => 'metered',
            ],
            "product" => env('MONTHY_SUBSCRIPTION_PRODUCT'), // hard coded. i think i just need one of these
        ]);

        // // create and assign the subscription to the user
        $user->newSubscription('Home Owners', $priceObj->id)
            ->anchorBillingCycleOn(Carbon::now()->day(27)->timestamp)
            ->trialDays(14)
            ->quantity(0)
            ->create();



        // update the pricingAmount in the setup_table 

        // testing email
        // $e = 'travis.harley@senrent.com';
        // Mail::to($e)->send(new UserCreated($user));

        // live
        Mail::to($user->email)->send(new UserCreated($user));

        return redirect()
            ->route('dashboard')
            ->with('info', 'Your account was successfully created.');
    }

    public function calculateUsage() {

        /**
         * I NEED TO SEE IF THE PRICINGAMOUNT IN THE DB IS UPDATED OR IF I HAVE TO ENTER 
         * THE RECORD IN THIS FUNCTION
         */

        $company_id = Company::where('id', '=', Auth::user()->company_id)->pluck('id');
        $paymentSetup = SetupPayment::where('company_id', '=', $company_id)->first();

        $numberOfProperties = $paymentSetup->numberOfProperties;
        $highestRentAmount = $paymentSetup->highestRentAmount; 

        // Stripe fee calculations 
        $totalMonthlyRentAmount = $highestRentAmount * $numberOfProperties;
        $payoutFee = number_format($totalMonthlyRentAmount * 0.0025,2); // 0.0025 is the payout fee
        $totalFees = $payoutFee + 2; // 2 is the number of active user dollars

        /**
         * NEED TO ROUND UP!!! WE COULD STILL LOSE MONEY IF IT IS IN CENTS
         * when filtering names, we need to remove the ones that have pricing setup
         */
        $pricing = ($totalFees *.5) + $totalFees; 
        $priceAmount = '';

        if($pricing > 100) {

            $priceAmount = $pricing;
            return $priceAmount;

        } else {

            $priceAmount = 200; 
            return $priceAmount;

        }

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
            'bill' => $this->getPaymentSetup(),
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

        // complete onboarding
        $onboarding = SetupPayment::where('company_id', '=', Auth::user()->company_id)->first();
        $onboarding->onboarding = 1;
        $onboarding->save();

        // change the payout to once a month
        $account = \Stripe\Account::update(
            $user->stripe_account,
            [
                'settings' => [
                    'payouts' => [
                        'schedule' => [
                            'interval' => 'monthly',
                            'monthly_anchor' => 28
                        ],
                    ],
                ],
            ]
        );

        return redirect()
            ->route('settings.billing.index', [
            'bank_accounts' => $this->getBankAccounts(), 
            'customer' => $this->getCustomer(), 
            'invoices' => $this->getInvoices(),
            'bill' => $this->getPaymentSetup(),
        ])->with('info', 'You have successfully completed the onboarding process! Have fun!');

    }

    /**
     * Determine when the rent is due for the tenant
     * Calculate the late date, and due periods
     */
    public function calculateRentDueDate() {

        $property = Property::join('rents', 'rents.property_id', '=', 'properties.id')
                            ->where('properties.id', '=', $this->getTenant()->property_id)
                            ->first();

        // set the late date
        if( !isset($property->late_date) || $property->late_date === null || $property->late_date === 0 ) {
            $late_date = 17;
        } else {
            $late_date = $property->late_date;
        }

        // set the between dates rent is due
        $begin = Carbon::create(Carbon::now()->year, Carbon::now()->month, $late_date);
        $end = Carbon::create(Carbon::now()->year, Carbon::now()->month, Carbon::now()->daysInMonth);

        $comparison = Carbon::now()->isBetween(Carbon::now(), $begin, $end);

        return $comparison;

    }

    /**
     * Tenant dashboard view
     * Shows the rent amount and when rent is due
     */
    public function showPayIndex() {

        $property = Property::join('rents', 'rents.property_id', '=', 'properties.id')
                            ->where('properties.id', '=', $this->getTenant()->property_id)
                            ->first();

        $findPropertyId = Tenant::where('user_id', '=', Auth::user()->user_id)->first(); 
        
        $balance = '';
        $betweenDates = '';

        if($findPropertyId === null) {
            $property_id = 0;
            $balance = 0;          
        
        } else {
            $property_id = $findPropertyId->property_id;
            $balance = $this->findRentBalance($this->getTenant()->id) + $property->rent_amount;
            $betweenDates = $this->calculateRentDueDate();
        }
       
        return view('tenants.billing.index', [
                    'tenant' => $this->getTenant(),
                    'property' => $property,
                    'balance' => $balance,
                    'betweenDates' => $betweenDates,
        ]);
    }

    /**
     * Take the tenant through the checkout process
     */
    public function showPay(Request $request) {
       
        $property = Property::join('rents', 'rents.property_id', '=', 'properties.id')
                            ->where('properties.id', '=', $this->getTenant()->property_id)
                            ->first();

        /**
         * here we need to pull the balance amount and then calculate
         * any fees.
         */
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

    /**
     * Show the tenant the totals due
     */
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

    /**
     * Allow the tenant to pay their rent
     * Collect the money and send to the landlord
     */
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
                    'bill' => $this->getPaymentSetup(),
                ])->with('danger',  $e);

        } 

        // calculate the new balance
        // $currentBalance = $this->calculateRentBalance();
        // $newBalance = ( $request->input('rent') + $currentBalance ) - $currentBalance;

        $amount_paid = $amount / 100;
        $currentBalance  = $this->findRentBalance($tenant->id);
        $newBalance = $this->calculateNewBalance($currentBalance, $amount_paid, $property->rent_amount); 

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
            'amount_paid' => $amount_paid,
            'balance' => $newBalance,
            'payment_method' => $charge->payment_method_details->type,
            'paid_in_full' => 0,
            'late_fee_amount' => $lateFee,
            'confirmation' => $confirmationNumber,
        ]);
        $transaction->save();

        // find the next due date 
        $numberOfMonths = $amount_paid / $property->rent_amount; 
        $roundMonth = floor($numberOfMonths); // always round down
        
        // save balance to rents table 
        $rents = Rent::where('property_id', '=', $property->id)->first();
        $rents->balance = $newBalance;
        $rents->next_due_date = Carbon::now()->addMonths($roundMonth);
        $rents->save();
            
        return view('tenants.billing.confirmation', [
            'confirmation_number' => $confirmationNumber,
            'amount' => $charge->amount,
            'payment_method' => $charge->payment_method_details->type,
            'date' => $transaction->created_at,
        ]);

    }

    /**
     * Check to see if there are late fees
     */
    public function calculateLateFee($latefee) {

        if( $latefee === null || $latefee <= 0) {
            return 0;
        } else {
            return $latefee;
        }

    }

    /**
     * Find the rent balance for the tenant
     */
    public function findRentBalance($tenant_id) {

        $findPropertyId = Tenant::where('id', '=', $tenant_id)->first(); 
        $property_id = $findPropertyId->property_id;

        if( $property_id === null ) {
            return 0;
        } else {

            $balanceAmount = Rent::where('property_id', '=', $property_id)->first();
            $balance = $balanceAmount->balance;
    
            if( $balanceAmount === null || $balanceAmount === 0 ) {
                return 0;
            } else {
                return $balance;
            }
        }

    }

    /**
     * Calculate the new balance after rent has been paid
     */
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

    /**
     * Calculate the new balance after rent has been paid
     */
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

    /**
     * Show the payment confirmation after rent has been paid
     */
    public function showPaymentConfirmation() {
        return view('tenants.billing.confirmation');
    }

    // CONNECT CUSTOM ACCOUNT

    // DON'T FORGET TO ADD THE STRIPE TERMS OF USE ACCEPT FORM
    // https://stripe.com/docs/connect/updating-accounts#referencing-the-agreement

    /**
     * Show the onboarding view
     */
    public function viewOnboarding() {
        return view('settings.billing.onboarding.index');
    }

    /**
     * ONBOARDING - Collect the following information
     * currently in development not working
     */
    public function CustomAccountOnboarding(Request $request) {

        // need to inform that whoever is filling out the form that it has to be created on the property admins account
        // restirct it to their view as well.

        $ach_token = \Stripe\Token::create([
            'bank_account' => [
                'country' => 'US',
                'currency' => 'usd',
                'account_holder_name' => $request->input('account_holder_name'),
                'account_holder_type' => $request->input('account_holder_type'),
                'routing_number' => $request->input('routing_number'),
                'account_number' => $request->input('account_number'),
            ],
        ]);

        $account_token = $request->input('token-account');
        $person_token = $request->input('token-person');

        // create the account based on the business_type
        $account = \Stripe\Account::create([
            'country' => 'US',
            'type' => 'custom',
            'account_token' => $account_token,
            'requested_capabilities' => [
                'card_payments', 
                'transfers', 
                'tax_reporting_us_1099_misc', 
                'tax_reporting_us_1099_k'
            ],
            'business_profile' => [
                'mcc' => '6513',
                'url' => $request->input('url'),
            ],
            'settings' => [
                'payouts' => [
                    'schedule' => [
                        'interval' => 'monthly',
                        'monthly_anchor' => 20
                    ],
                ],
            ],
            'external_account' => $ach_token,
        ]);

        if( $request->input('business_type') === 'company' ) {
            $person = \Stripe\Account::createPerson(
                $account->id,
                [
                    'person_token' => $person_token,
                ]
            );
        }

        /**
         * Normally I wouldn't allow so much happening in a single method
         * However, adding the customer account and the connect account 
         * has proven to be challenging. 
         * 
         * I can not add the ACH account for the connect account and intercept
         * the token to add to their Customer account to charge them monthly. 
         * 
         * And I have to create two tokens with the same data.
         * 
         * I have to do it in the same method on the same page as the onboarding. 
         */

        $ach_token2 = \Stripe\Token::create([
            'bank_account' => [
                'country' => 'US',
                'currency' => 'usd',
                'account_holder_name' => $request->input('account_holder_name'),
                'account_holder_type' => $request->input('account_holder_type'),
                'routing_number' => $request->input('routing_number'),
                'account_number' => $request->input('account_number'),
            ],
        ]);

        $user = User::find(Auth::user()->id);

        $bank_account = \Stripe\Customer::update(
            $user->stripe_id,
            ['source' => $ach_token2]
        );

        // store the id to the database
        
        $user->stripe_account = $account->id; 
        $user->save();

        return redirect()
                ->back()
                ->with('info', 'Congratulations! Your account has been onboarded!');

        /**
         * TO DO 
         * Eventually we are going to have to have a way for users to upload files 
         * for future verification
         * 
         * https://stripe.com/docs/connect/account-tokens#file-upload
         */

    }


}
