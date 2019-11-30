@extends('layouts.app', ['page_title' => "Billing"])

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
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Add Credit Card</h3>
                        </div>
                        <div class="col-4 text-right">
                            
                        </div>
                    </div>
                </div>

                <div class="card-body">


                <input placeholder="Card Holder" class="form-control" id="card-holder-name" type="text">

                <!-- Stripe Elements Placeholder -->
                <div id="card-element"></div>

                <button class="mt-2 btn btn-primary" id="card-button" data-secret="{{ $intent->client_secret }}">
                    Add Credit Card and Subscribe
                </button>


                </div>
            </div>
        </div>
    </div>

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
                    axios.post('/settings/billing/subscribe',{
                        payment_method: setupIntent.payment_method,
                        //plan : plan
                    }).then((data)=>{
                        location.replace(data.data.success_url)
                    });
                }
            });
        })

    </script>

@endsection


