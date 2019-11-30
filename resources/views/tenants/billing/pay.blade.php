@extends('layouts.app', ['page_title' => "Make Payment"])

@section('content')
@include('layouts.headers.cards')

<div class="container-fluid mt--9">

    <div class="row mb-3">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Make Payment</h3>
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

                    <!-- display the total here -->
                    Payment Amount: 

                    <!-- select date -->
                    Payment Date:

                    <!-- select payment method -->
                    Payment Method:

                    <a href="#" class="btn btn-link">Cancel</a>
                    <a href="#" class="btn btn-primary">Continue</a>
                   

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
