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
                            <h3 class="mb-0">Payment Amount</h3>
                        </div>
                        <div class="col-4 text-right">
                            <span class="text-success font-weight-bold display-4">${{ $property->rent_amount }}</span>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row pb-5">   
                        <div class="col">
                            <span>Current balance due {{ \Carbon\Carbon::now()->addMonth()->format('F') }} 1, {{ \Carbon\Carbon::now()->year }}</span>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Payment Date</h3>
                        </div>
                        <div class="col-4 text-right">
                           
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    <div class="row pb-5">   
                        <div class="col">
                            <span>Select a payment date</span>
                        </div>
                        <div class="col-md-3">
                            <input type="date" class="form-control" name="date" value="{{ \Carbon\Carbon::now()->subDay(1)->format('Y-m-d') }}">
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Payment Method</h3>
                        </div>
                        <div class="col-4 text-right">
                           
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    <div class="row pb-5">  
                        <div class="col">

                            @foreach( $bank_accounts as $bank_account )

                                <div class="custom-control custom-control-alternative custom-checkbox mb-3">
                                    <input class="custom-control-input" id="customCheck5" type="checkbox" checked>
                                    <label class="custom-control-label " for="customCheck5">

                                        <i class="fas fa-university ml-4    "></i> {{ $bank_account->bank_name }}
                                        <span class="pl-3">******** {{ $bank_account->last4 }} </span>
                                    
                                        @if($bank_account->id == $customer->default_source)
                                            <span class="badge badge-primary">Default</span>
                                        @endif
                                        </span>

                                    </label>
                                </div>

                            @endforeach 

                        </div>
                    </div>
                    
                    
                    <a href="{{ route('tenants.billing.index') }}" class="btn btn-link">Cancel</a>
                    <a href="{{ route('tenants.billing.review') }}" class="btn btn-primary">Continue</a>
                   

                </div>
            </div>
        </div>
    </div>

</div>
@endsection
