@extends('layouts.app', ['page_title' => "Review Payment"])

@section('content')
@include('layouts.headers.cards')

<div class="container-fluid mt--9">

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
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row mb-5">

                        <div class="col-sm-6 mb-4">
                            Amount
                        </div>
                        
                        <div class="col-sm-6 mb-4">
                            $1000
                        </div>

                        <div class="col-sm-6 mb-4">
                            Date
                        </div>
                        
                        <div class="col-sm-6 mb-4">
                            12/6/2019
                        </div>

                        <div class="col-sm-6 mb-4">
                            Payment Method
                        </div>

                        <div class="col-sm-6 mb-4">
                            ACH
                        </div>

                        <div class="col-sm-6 mb-4">
                            Confirmation Email
                        </div>

                        <div class="col-sm-6 mb-4">
                            user@email.com
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-12 mb-3">

                            <div class="custom-control custom-control-alternative custom-checkbox mb-3">
                                <input class="custom-control-input" id="customCheck5" type="checkbox">
                                <label class="custom-control-label " for="customCheck5">
                                    I agree to pay and agree to pay the amount here.
                                </label>
                            </div>

                        </div>

                        <div class="col-12">
                            <a href="{{ route('tenants.billing.index') }}" class="btn btn-link">Cancel</a>
                            <a href="#" class="btn btn-primary">Submit Payment</a>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
