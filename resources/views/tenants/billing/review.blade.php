@extends('layouts.app', ['page_title' => "Review Payment"])

@section('head')
    <style>
#loading{
    position: fixed, 
    top: 0; left: 0; 
    width: 100%; height:100%; 
    background-color: rgba(255, 255, 255, 0.6); 
    z-index: 1000;
    display:none;
}
#loading img {
    position: absolute;
    left: 50%;
    width: 50px;
    margin-left: -30px;
    z-index: 99999999999999999;
}
    </style>
@endsection

@section('content')
@include('layouts.headers.cards')

<div id="loading"><img src="{{url('/img/loading/loading.gif')}}" /></div>

<div class="container-fluid mt--9">

    <div class="row">
        <div class="col">
            @if(Session::has('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <h4 class="alert-heading">Success!</h4>
                    <p>{{ Session::get('status') }}</p>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
        </div>
    </div>

    <div class="row mb-3">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Review Payment</h3>
                        </div>
                        <div class="col-4 text-right">
                           
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    <div class="row mb-5">

                        <div class="col-sm-6 mb-4">
                            Date
                        </div>
                        
                        <div class="col-sm-6 mb-4">
                            {{ $date }}
                        </div>

                        <div class="col-sm-6 mb-4">
                            Payment Method
                        </div>

                        <div class="col-sm-6 mb-4"> 

                            @foreach($bank_account as $b)

                                <i class="fas fa-university mr-2"></i> {{ $b->bank_name }}
                                <span class="pl-3">******** {{ $b->last4 }} </span>
                        
                                @if($b->id == $customer->default_source)
                                    <span class="badge badge-primary">Default</span>
                                @endif

                            @endforeach
                        </div>

                        <div class="col-sm-6 mb-4">
                            Confirmation Email
                        </div>

                        <div class="col-sm-6 mb-4">
                            {{ Auth::user()->email }}
                        </div>

                        <div class="col-sm-6 mb-4">
                            Amount
                        </div>
                        
                        <div class="col-sm-6 mb-4">
                            ${{ $amount }}
                        </div>

                        <div class="col-sm-6 mb-4">
                            Late Fee
                        </div>

                        
                        <div class="col-sm-6 mb-4">
                        @if( $late_fee === null || $late_fee != 0 ) 
                            $20
                        @else
                            ${{ $late_fee }}
                        @endif
                        </div>

                        <div class="col-sm-6 mb-4">
                            Processing Fee
                        </div>
                        
                        <div class="col-sm-6 mb-4">
                            ${{ number_format( $convenience,2 ) }}
                        </div>

                        <div class="col-sm-6 mb-4">
                            <span class="font-weight-bold">TOTAL</span>
                        </div>
                        
                        <div class="col-sm-6 mb-4">
                            <span class="text-success font-weight-bold">${{ $amount + number_format( $convenience,2 ) }}</span>
                        </div>

                    </div>

                <form action="{{ route('tenants.billing.payRent') }}" method="post" id="payment-form">

                    <div class="row">

                        <div class="col-12 mb-3">

                            <div class="custom-control custom-control-alternative custom-checkbox mb-3">
                                <input class="custom-control-input" id="agree" name="agree" value="1" type="checkbox" required>
                                <label class="custom-control-label" for="agree">
                                    I agree to pay the amount shown above.
                                </label>
                            </div>

                        </div>

                        <div class="col-12">
                            <a href="{{ route('tenants.billing.index') }}" class="btn btn-link">Cancel</a>
                            <button id="submit" type="submit" class="btn btn-primary">Submit Payment</button>
                        </div>

                    </div>

                    <input type="hidden" name="date" value="{{ $date }}">
                    <input type="hidden" name="late_fee" value="{{ $late_fee }}">
                    <input type="hidden" name="total" value="{{ $amount + number_format( $convenience,2 ) }}">
                    <input type="hidden" name="rent" value="{{ $amount }}">
                    <input type="hidden" name="convenience" value="{{ $convenience }}">
                    <input type="hidden" name="source" value="{{ $customer->default_source }}">

                    @csrf

                </form>

                </div>
            </div>
        </div>
    </div>
    @include('layouts.footers.auth')
</div>
@endsection

@section('otherJs')

    <script>
        function myFunction() {
            var x = document.getElementById("agree").required;
            document.getElementById("demo").innerHTML = x;
        }
    </script>

    <script>
        $('#submit').on('click', function(e){

            $('#loading').show();
            //$('#form').submit();

        });
    </script>

    <!-- <script src="https://js.stripe.com/v3/"></script>

    <script>

        var stripe = Stripe('{{config('services.stripe.key')}}');
        var elements = stripe.elements();

        // Create a token or display an error when the form is submitted.
        var form = document.getElementById('payment-form');

        form.addEventListener('submit', function(event) {
            event.preventDefault();

            stripe.createToken(card).then(function(result) {
                if (result.error) {

                    // Inform the customer that there was an error.
                    var errorElement = document.getElementById('card-errors');
                    errorElement.textContent = result.error.message;

                } else {

                    // Send the token to your server.
                    stripeTokenHandler(result.token);

                }
            });
        });

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

    </script> -->


@endsection