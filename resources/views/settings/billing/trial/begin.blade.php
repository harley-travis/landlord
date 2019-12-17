@extends('layouts.app', ['page_title' => "Begin Your 14 Free Day Trial"])

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
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header bg-success border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0 text-white">Begin Your 14 Free Day Trial</h3>
                        </div>
                        <div class="col-4 text-right">
                           
                        </div>
                    </div>
                </div>

                <div class="card-body">

                    <p class="pb-5">Thank you for joining SenRent! This is your 14 day free trial! In order to start your free trial, go ahead and click on the activate button. You will have 14 days to test SenRent to see it's simplicity. After your 14 day trial, you will be prompted to enter your ACH account number. Join SenRent, the world's most affordable property manager.</p><br>

                    <form action="{{ route('settings.billing.trial.activate') }}" method="post">

                        @csrf

                        <button type="submit" class="btn btn-success btn-lg text-uppercase shadow">Activate 14 Day Trial</button>

                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.footers.auth')
</div>
@endsection
