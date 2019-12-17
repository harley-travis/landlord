@extends('layouts.app', ['page_title' => "Verify ACH Account"])

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
                            <h3 class="mb-0">Verify ACH Account</h3>
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
							<li>Value 1: 0.32</li>
							<li>Value 2: 0.45</li>
						</ul>

						<h6>For failure upon use</h6>
						<ul>
							<li>any other combo</li>
						</ul>
					</div>

                    <p>Enter the two values deposited into your account to verify your bank account.</p>
                    <p>Deposits can take 2-3 business days. If you do not see the deposit amount, please contact our <a href="mailto:support@senrent.com">support team.</a></p>
                   
                    <form action="{{ route('settings.billing.ach.verifyCheck') }}" method="post">

                        <div class="form-group">
                            <label for="value1">Value 1</label>
                            <input type="text" class="form-control" name="value1">
                            <small>Enter the amount in cents. EX <i>0.05</i></small>
                        </div>
                        <div class="form-group">
                            <label for="value2">Value 2</label>
                            <input type="text" class="form-control" name="value2">
                            <small>Enter the amount in cents. EX <i>0.05</i></small>
                        </div>

                        <input type="hidden" name="id" value="{{ $id }}">

                        <br>
                        <p>In order to process your payment, you need to authorize SenRent to charge this account on file. Authorizing payment will auto enroll you into our monthly payment program of $15/month for 5 properties and an additional $2 charge per additional property.</p>
                        <p>Each month may vary the cost, depending on how many properties you added this month.</p>
                        <p>By clicking, 'Verify and Authorize', you agree to our Terms and Conditions and authorize SenRent to charge the account on file.</p>
                        <br>
                        
                        @csrf

                        <a href="{{ route('settings.billing.index') }}" class="btn btn-outline-secondary">Cancel</a>
                        <button type="submit" class="btn btn-success shadow"><i class="fas fa-check pr-2"></i> Verify and Authorize</button>

                    </form>

                </div>
            </div>
        </div>
    </div>

    @include('layouts.footers.auth')
</div>
@endsection
