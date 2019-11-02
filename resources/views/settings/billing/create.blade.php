@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Add Payment Method</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif


                <form action="{{ route('settings.billing.add') }}" method="post">

                    <label>Card holder name</label>
                    <input id="card-holder-name" class="form-control" type="text">

                    <!-- Stripe Elements Placeholder -->
                    <div id="card-element"></div>

                    <input type="hidden" name="ds" value="{{ $intent->client_secret }}">

                    <button id="card-button" class="btn btn-primary" data-secret="{{ $intent->client_secret }}">
                        Add Credit Card
                    </button>

                    @csrf

                </form>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const stripe = Stripe('{{ config('services.stripe.secret') }}');

    const elements = stripe.elements();
    const cardElement = elements.create('card');

    cardElement.mount('#card-element');

    const cardHolderName = document.getElementById('card-holder-name');
    const cardButton = document.getElementById('card-button');
    const clientSecret = cardButton.dataset.secret;

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
            console.log(error);
        } else {
            // The card has been verified successfully...
            console.log('it worked!');
        }
    });


</script>

@endsection
