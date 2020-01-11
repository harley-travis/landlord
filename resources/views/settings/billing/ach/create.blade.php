@extends('layouts.app', ['page_title' => "Add ACH Account"])

@section('content')
@include('layouts.headers.cards')

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

			@if (session('danger'))
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
					<p>{{ session('danger') }}</p>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
				</div>
			@endif
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Add ACH Account</h3>
                        </div>
                        <div class="col-4 text-right">
                           
                        </div>
                    </div>
                </div>

                <div class="card-body">

					<div class="alert alert-warning" role="alert">
                        <b>NOTE</b> This information is just for testing purposes. Will remove this when we go live. <br><br>
						<h5>Bank Account Information </h5>
						<small>Provided by Stripe for Testing</small><br><br>

						<h6>For success added</h6>
						<ul>
							<li>Routing Number: 110000000</li>
							<li>Account number: 000123456789</li>
						</ul>

						<h6>For failure upon use</h6>
						<ul>
							<li>Routing Number: 110000000</li>
							<li>Account number: 000111111116</li>
						</ul>

						<h6>For account closed</h6>
						<ul>
							<li>Routing Number: 110000000</li>
							<li>Account number: 000111111113</li>
						</ul>

						<h6>For NSF/insufficent funds</h6>
						<ul>
							<li>Routing Number: 110000000</li>
							<li>Account number: 000222222227 </li>
						</ul>

						<h6>For debit not authorized</h6>
						<ul>
							<li>Routing Number: 110000000</li>
							<li>Account number: 000333333335</li>
						</ul>
					</div>


                    <small>At this time, we only support ACH accounts in the United States.</small><br>
                    <span>NOTE: You must verify your ACH account before you can use it. Follow the instructions below:</span>
                    <ul>
                        <li>2 small deposits will be deposited into your account in 1-2 business days. The statement will say AMTS.</li>
                        <li>You will need to verify those amounts.</li>
                        <li>There is a limit of 10 attempts.</li>
                    </ul>
					
					<form action="{{ route('settings.billing.ach.create') }}" method="post" id="payment-form">

						<div class="">
							<div class="form-group">
								<label for="account_holder_name">Name on Account</label>
								<input type="text" class="form-control" placeholder="name on account" name="account_holder_name">
							</div>
							<div class="form-group">
								<label for="routing_number">Routing Number</label>
								<input type="text" class="form-control" placeholder="routing number" name="routing_number">
							</div>
							<div class="form-group">
								<label for="">Account Number</label>
								<input type="password" class="form-control" placeholder="account number">
							</div>
							<div class="form-group">
								<label for="account_number">Confirm Account Number</label>
								<input type="password" class="form-control" placeholder="confirm account number" name="account_number">
							</div>
							<div class="form-group">
								<label for="account_holder_type">Account Holder Type</label>
								<select id="account_holder_type" name="account_holder_type" class="form-control">
									<option value="individual">Individual</option>
									<option value="company">Company</option>
								</select>
							</div>
						</div>

						@csrf

						<br><p>By clicking 'Add ACH' you authorize SenRent to charge you for your monthly payment</p><br>

                        <div class="mt-3">
							<button class="btn btn-primary shadow" id="card-button" data-secret="{{ $intent->client_secret }}">
								Add ACH
							</button>
                        </div>
					</form>

                </div>
            </div>
        </div>
    </div>

	@include('layouts.footers.auth')
</div>
@endsection

@section('otherJs')

    <script src="https://js.stripe.com/v3/"></script>

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

    </script>


@endsection