@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Verify ACH Account</div>

                <div class="card-body">
                    @if (session('info'))
                        <div class="alert alert-success" role="alert">
                            {{ session('info') }}
                        </div>
                    @endif

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
                        <button type="submit" class="btn btn-success">Verify Acccout Now</button>

                    </form>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection
