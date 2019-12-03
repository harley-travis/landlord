@extends('layouts.app', ['page_title' => "Make Payment"])

@section('content')
@include('layouts.headers.cards')

<div class="container-fluid mt--9">

    <form action="{{ route('tenants.billing.review') }}" method="post">

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
                            <input type="hidden" name="amount" value="{{ $property->rent_amount }}">
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



                            <div class="form-group">

                                @if($bank_account->id == $customer->default_source)
                                <div class="custom-control custom-radio mb-3">
                                    <input name="source" class="custom-control-input" id="agree-{{ $bank_account->id }}" type="radio" value="{{ $bank_account->id }}" checked="">
                                    <label class="custom-control-label" for="agree-{{ $bank_account->id }}">
                                    
                                        <i class="fas fa-university ml-4 mr-2"></i> {{ $bank_account->bank_name }}
                                        <span class="pl-3">********  {{ $bank_account->last4 }}</span>
                                        <span class="badge badge-primary">Default</span>

                                    </label>
                                </div>
                                @else
                                <div class="custom-control custom-radio mb-3">
                                    <input name="source" class="custom-control-input" id="agree-{{ $bank_account->id }}" type="radio" value="{{ $bank_account->id }}">
                                    <label class="custom-control-label" for="agree-{{ $bank_account->id }}">

                                        <i class="fas fa-university ml-4 mr-2"></i> {{ $bank_account->bank_name }}
                                        <span class="pl-3">********  {{ $bank_account->last4 }}</span>
                                
                                    </label>
                                </div>
                                @endif

                            </div>


                            @endforeach 

                        </div>
                        <div class="col text-right">
                            <a href="{{ route('settings.billing.index') }}" class="btn btn-link text-success">Add Another Payment Method</a>
                        </div>
                    </div>
                    
                    <a href="{{ route('tenants.billing.index') }}" class="btn btn-link">Cancel</a>
                    <button type="submit" class="btn btn-primary">Continue</button>
                   
                </div>
            </div>
        </div>
    </div>

        @csrf
        
    </form>

</div>
@endsection
