@extends('layouts.app', ['page_title' => "Make Payment"])

@section('head')
    <style>
#loading{
    position: fixed, 
    top: 0; left: 0; 
    width: 100%; height:100%; 
    background-color: rgba(255, 255, 255, 0.6); 
    z-index: 1000;
    display:none;
}
#loading img {
    position: absolute;
    left: 50%;
    width: 50px;
    margin-left: -30px;
    z-index: 99999999999999999;
}
    </style>
@endsection

@section('content')
@include('layouts.headers.cards')

<div id="loading"><img src="{{url('/img/loading/loading.gif')}}" /></div>

<div class="container-fluid mt--9">

    <div class="row">
        <div class="col">
            @if(Session::has('info'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <h4 class="alert-heading">PAYMENT FAILED!</h4>
                    <p>{{ Session::get('info') }}</p>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
        </div>
    </div>

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
                            @if( $late_fee === null )
                            <span class="text-success font-weight-bold display-4">@if( $amount === 0 || $amount === null) $0.00 @else ${{ number_format($amount, 2) }} @endif</span>
                            <input type="hidden" name="amount" value="{{ $amount }}">
                            <input type="hidden" name="late_fee" value="{{ $late_fee }}">
                            @else
                            <span class="text-success font-weight-bold display-4">${{ number_format($amount $late_fee, 2) }}</span>
                            <input type="hidden" name="amount" value="{{ $amount }}">
                            <input type="hidden" name="late_fee" value="{{ $late_fee }}">
                            @endif
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
                                @if($bank_account->status === "verified")
                                <div class="custom-control custom-radio mb-3">
                                    <input name="source" class="custom-control-input" id="agree-{{ $bank_account->id }}" type="radio" value="{{ $bank_account->id }}">
                                    <label class="custom-control-label" for="agree-{{ $bank_account->id }}">

                                        <i class="fas fa-university ml-4 mr-2"></i> {{ $bank_account->bank_name }}
                                        <span class="pl-3">********  {{ $bank_account->last4 }}</span>
                                
                                    </label>
                                </div>
                                @endif
                                @endif

                            </div>

                            @endforeach 

                        </div>
                        <div class="col text-right">
                            <a href="{{ route('settings.billing.index') }}" class="btn btn-link text-success">Add Another Payment Method</a>
                        </div>
                    </div>
                    
                    <a href="{{ route('tenants.billing.index') }}" class="btn btn-link">Cancel</a>
                    <button id="submit" type="submit" class="btn btn-primary">Continue</button>
                   
                </div>
            </div>
        </div>
    </div>

        @csrf
        
    </form>

    @include('layouts.footers.auth')
</div>
@endsection


@section('otherJs')

<script>
    $('#submit').on('click', function(e){

        $('#loading').show();
        //$('#form').submit();

    });
</script>

@endsection