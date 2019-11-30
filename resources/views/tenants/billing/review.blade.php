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

                    Amount: $1000
                    Due: 12/6/2019
                    Payment Method: VISA
                    Confirmation Email: user@email.com

                    <input type="checkbox" name="agree">I agree to pay and agree to pay the amount here.

                    <a href="#" class="btn btn-link">Cancel</a>
                    <a href="#" class="btn btn-primary">Submit Payment</a>
                   

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
