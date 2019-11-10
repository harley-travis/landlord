@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header">Verify ACH Account</div>

                <div class="card-body">
                @if (session('info'))
                    <div class="alert alert-success shadow-sm" role="alert">
                        <i class="fas fa-info-circle pr-2"></i>{{ session('info') }}
                    </div>
                @endif

                @if (session('danger'))
                    <div class="alert alert-danger shadow-sm" role="alert">
                        <i class="fas fa-exclamation-circle pr-2"></i>{{ session('danger') }}
                    </div>
                @endif


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

                        @csrf

                        <a href="{{ route('settings.billing.index') }}" class="btn btn-outline-secondary">Cancel</a>
                        <button type="submit" class="btn btn-success shadow">Verify Acccout Now</button>

                    </form>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection
