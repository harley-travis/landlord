@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Add New ACH Account</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

					@if (session('danger'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('danger') }}
                        </div>
                    @endif

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
								<input type="password" class="form-control" placeholder="routing number" name="routing_number">
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
								<input type="text" class="form-control" placeholder="account holder type: IE: company" name="account_holder_type">
							</div>
						</div>


						@csrf

						<br>
						<p>By clicking 'Add ACH' you authorize SenRent to charge you for your monthly payment</p>

                        <div class="mt-3">
						    <button class="btn btn-primary">Add ACH</button>
                        </div>
					</form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
