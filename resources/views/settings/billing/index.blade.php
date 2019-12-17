@extends('layouts.app', ['page_title' => "Billing Settings"])

@section('head')

<script src="https://js.stripe.com/v3/"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>

<style>
        .StripeElement {
            box-sizing: border-box;
            height: 40px;
            padding: 10px 12px;
            border: 1px solid transparent;
            border-radius: 4px;
            background-color: white;
            box-shadow: 0 1px 3px 0 #e6ebf1;
            -webkit-transition: box-shadow 150ms ease;
            transition: box-shadow 150ms ease;
        }
        .StripeElement--focus {
            box-shadow: 0 1px 3px 0 #cfd7df;
        }
        .StripeElement--invalid {
            border-color: #fa755a;
        }
        .StripeElement--webkit-autofill {
            background-color: #fefde5 !important;
        }
    </style>

@endsection

@section('content')
@include('layouts.headers.cards')

<div class="container-fluid mt--9">

    <div class="row">
        <div class="col">
            @if(Session::has('info'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <h4 class="alert-heading">Success!</h4>
                    <p>{{ Session::get('info') }}</p>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if (session('danger'))
                <div class="alert alert-danger shadow-sm alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle pr-2"></i>{{ session('danger') }}
                </div>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            @endif
        </div>
    </div>

    @if($user->stripe_account === null && $user->role >= 1)
    <div class="row mb-3">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Account Onboarding</h3>
                        </div>
                        <div class="col-4 text-right">
                           
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <p>In order to start accepting rent from your tenants, we will have to onboard you accept payment from your tenants. Click the link below to get started.</p>
                    <a href="https://dashboard.stripe.com/express/oauth/authorize?response_type=code&client_id={{ env('STRIPE_CLIENT_ID') }}&scope=read_write" class="btn btn-primary">Start Onboarding</a>
                </div>
            </div> <!-- card -->
        </div> <!-- col -->
    </div> <!-- row -->
    @endif

    @if($user->role != 0 )
    <!-- <div class="row mb-3">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="mb-0">Add Credit Card</h3>
                            <small class="mt-4">Paying with a credit card results in a 2.9% convience fee. We recommend paying with ACH account to avoid large convience fees.</small>
                        </div>
                    </div>
                </div>

                <div class="card-body">

                    
                    <input placeholder="Card Holder Name" class="form-control mb-2" id="card-holder-name" type="text"> -->

                    <!-- Stripe Elements Placeholder -->
                    <!-- <div id="card-element"></div>

                    <button class="mt-3 btn btn-primary" id="card-button" data-secret="{{ $intent->client_secret }}">
                        Add Credit Card and Subscribe
                    </button>

                </div>
            </div>
        </div>
    </div> -->
    @endif

    @if($user->role === 3 )
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">ACH Accounts</h3>
                        </div>
                        <div class="col-4 text-right">
                          
                        </div>
                    </div>
                </div>

                <div class="card-body">

                    <ul class="list-group">
                        @if( !isset($connect_accounts) )
                        @foreach($connect_accounts->external_accounts->data as $b)

						<li class="list-group-item">
							<span class="col-6"> 
                                <i class="fas fa-university mr-2"></i> {{ $b->bank_name }} 
                                <span class="pl-3">********  {{ $b->last4 }}</span>
                            </span>

							<span class="col-6">
                                <div class="float-right">

                                </div>
							</span>
						</li>

                        @endforeach
                        @endif
	
					</ul>
     
                </div>
            </div> <!-- card -->
        </div> <!-- col -->
    </div> <!-- row -->
    @endif

    

    @if($user->role != 3 )
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">ACH Accounts</h3>
                        </div>
                        <div class="col-4 text-right">
                            <i class="fas fa-question-circle color-purple mr-3" data-toggle="tooltip" data-placement="left" title="Currently we do not support credit cards"></i>
                            <!-- <a href="{{ route('settings.billing.subscription.create') }}" class="btn btn-primary"><i class="fas fa-plus-circle pr-2"></i>Add Subscription</a> -->
                            <a href="{{ route('settings.billing.ach.create') }}" class="btn btn-success"><i class="fas fa-plus-circle pr-2"></i>Add ACH Account</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">

                    <ul class="list-group">
					    @foreach( $bank_accounts as $bank_account )
						<li class="list-group-item">
							<span class="col-6"> 
                                <i class="fas fa-university mr-2"></i> {{ $bank_account->bank_name }} 
                                <span class="pl-3">********{{ $bank_account->last4 }}</span>
                            
                                @if($bank_account->id == $customer->default_source)
                                    <span class="badge badge-primary">Default</span>
                                @endif
                            </span>

							<span class="col-6">
                                <div class="float-right">

                                    @if( $bank_account->id != $customer->default_source )
                                    <a href="#" class="btn btn-link" data-toggle="modal" data-target="#setDefault">Set Default</a>

                                    <!-- Authorize ACH Modal -->
                                    <div class="modal fade" id="setDefault" tabindex="-1" role="dialog" aria-labelledby="setDefaultLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="setDefaultLabel">Are you sure you want to authorize this ACH account?</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>In order to process your payment, you need to authorize SenRent to charge this account on file. Authorizing payment will auto enroll into our monthly payment program of $15/month for 5 properties and an additional $2 charge per additional property.</p>
                                                <p>Each month may vary the cost, depending on how many properties you added this month.</p>
                                                <p>By clicking, 'Authorize Payment', you agree to our Terms and Conditions and authorize SenRent to charge the account on file.
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cancel</button>
                                                <a href="{{ route('settings.billing.setDefault', ['id' => $bank_account->id ]) }}" class="btn btn-success shadow">Set Default and Authorize</a> 
                                   
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    
                                    @endif

                                    <a href="#" class="btn btn-outline-danger" data-toggle="modal" data-target="#deleteACH"><i class="far fa-trash-alt pr-2"></i> Delete Account</a>

                                    <!-- Delete ACH Modal -->
                                    <div class="modal fade" id="deleteACH" tabindex="-1" role="dialog" aria-labelledby="deleteACHLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteACHLabel">Are you sure you want to delete this ACH account?</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                If you delete your ACH account, it will remove all information regarding this account. If you would like to continue using this account, click cancel.
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-success" data-dismiss="modal">Go Back</button>
                                                <a href="{{ route('settings.billing.ach.delete', ['id' => $bank_account->id ]) }}" class="btn btn-outline-danger"><i class="far fa-trash-alt pr-2"></i> YES, DELETE ACCOUNT</a>
                                            </div>
                                            </div>
                                        </div>
                                    </div>

                                    @if($bank_account->status != "verified")
                                    <a href="{{ route('settings.billing.ach.verify', ['id' => $bank_account->id ]) }}" class="btn btn-success"><i class="fas fa-user-check pr-2"></i> Verify ACH Account</a>
                                    @endif

                                    @if( $invoices->isEmpty() && $bank_account->status === "verified" && $user->role != 0)
                                    <!-- NEED TO LOCK THE APP IF THEY DON'T AUTHORIZE THIS PAYMENT AFTER TRIAL PERID. PULL THE TRIAL PERID FROM THE DB -->
                                    <!-- NEED TO PULL UP A MODEL TO TELL THEM THAT WE ARE GOING TO CHARGE THEIR CARD -->
                                     <a href="{{ route('settings.billing.ach.authorize', ['id' => $bank_account->id ]) }}" class="btn btn-success text-white"><i class="fas fa-user-check pr-2"></i> Authorize ACH Account</a>
                                    @endif

                                </div>
							</span>
						</li>
						@endforeach 
					</ul>
     
                </div>
            </div> <!-- card -->
        </div> <!-- col -->
    </div> <!-- row -->
    @endif

    <div class="row mt-3">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Billing History</h3>
                        </div>
                        <div class="col-4 text-right">
                        
                        </div>
                    </div>
                </div>

                <div class="card-body">

                @if( $invoices->isEmpty() ) 
                    <p class="text-center">No transactions at this time</p>
                @else

                    <div class="table-responsive">
                        <table class="table align-items-center table-flush table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Date</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Paid</th>
                                    <th scope="col">Receipt</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach( $invoices as $invoice )
                                <tr>
                                    <td scope="row">{{ \Carbon\Carbon::createFromTimestamp($invoice->created)->toFormattedDateString() }}</td>
                                    <td>Automatic Charge</td>
                                    <td>${{ $invoice->amount_paid / 100 }}</td>
                                    <td>
                                        @if($invoice->attempted == 1)
                                            <span class="text-success"><i class="fas fa-check pr-2"></i> Success</span>
                                        @else
                                            <span class="text-danger"><i class="fas fa-times pr-2"></i> Failed</span>
                                        @endif
                                    </td>
                                    <td><a href="{{ $invoice->invoice_pdf }}"><i class="fas fa-download pr-2"></i> Download Invoice</a></td>
                                </tr>
                                @endforeach
						    </tbody>
					    </table>
                    </div>

                    <!-- to do: create pagination for billing -->
                @endif
                </div> <!-- card-body -->
            </div><!-- card -->
        </div><!-- col -->
    </div> <!-- row -->

    @include('layouts.footers.auth')

</div>

@endsection

@section('otherJs')

    <script>
        window.addEventListener('load', function() {
            const stripe = Stripe('{{config('services.stripe.key')}}');
            const elements = stripe.elements();
            const cardElement = elements.create('card');
            cardElement.mount('#card-element');
            const cardHolderName = document.getElementById('card-holder-name');
            const cardButton = document.getElementById('card-button');
            const clientSecret = cardButton.dataset.secret;
            //const plan = document.getElementById('subscription-plan').value;
            cardButton.addEventListener('click', async (e) => {
                const { setupIntent, error } = await stripe.handleCardSetup(
                    clientSecret, cardElement, {
                        payment_method_data: {
                            billing_details: { name: cardHolderName.value }
                        }
                    }
                );
                if (error) {
                    // Display "error.message" to the user...
                    console.log(error.message)
                } else {
                    // The card has been verified successfully...
                    console.log('handling success', setupIntent.payment_method);

                    if( {{ Auth::user()->role }} === 0 ) {

                        // need to buid this out for a future release. this is code that i found on stripes site
                        // https://stripe.com/docs/payments/accept-a-payment-charges#php
                        // we don't want to encourage our users to use a Credit Card because of the high rates

                        function stripeTokenHandler(token) {
                        // Insert the token ID into the form so it gets submitted to the server
                        var form = document.getElementById('payment-form');
                        var hiddenInput = document.createElement('input');
                        hiddenInput.setAttribute('type', 'hidden');
                        hiddenInput.setAttribute('name', 'stripeToken');
                        hiddenInput.setAttribute('value', token.id);
                        form.appendChild(hiddenInput);

                        // Submit the form
                        form.submit();

                        }

                    } else {

                        axios.post('/settings/billing/subscribe',{
                            payment_method: setupIntent.payment_method,
                            //plan : plan
                        }).then((data)=>{
                            location.replace(data.data.success_url)
                        });

                    }
  
                }
            });
        })

    </script>

@endsection
