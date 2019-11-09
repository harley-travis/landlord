@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-success text-white">Begin Your 14 Free Day Trial</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p class="pb-5">Thank you for joining SenRent! This is your 14 day free trial! In order to start your free trial, go ahead and click on the activate button. You will have 14 days to test SenRent to see it's simplicity. After your 14 day trial, you will be prompted to enter your ACH account number. Join SenRent, the world's most affordable property manager.</p><br>

                    <form action="{{ route('settings.billing.trial.activate') }}" method="post">

                        @csrf

                        <button type="submit" class="btn btn-success btn-lg text-uppercase shadow">Activate 14 Day Trial</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
