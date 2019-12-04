@extends('layouts.app', ['page_title' => "Rent Preview"])

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

    <div class="row mb-3">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Rent Preview</h3>
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

                    @if( $tenant->property_id === null )

                        <span class="text-danger font-weight-bold">Your landlord has not assigned you to a property yet. Contact them if you don't see your property in a day or two.</span>

                    @else


                    @if( $property->rent_amount === 0) 
                    <span>$0.00</span>
                    @else
                    <h2 class="display-2 text-success mb-5">${{ $property->rent_amount }}</h2>
                    <p>Payment due {{ \Carbon\Carbon::now()->addMonth()->format('F') }} 1, {{ \Carbon\Carbon::now()->year }}</p>
                    @endif

                    <p>Payment late on {{ $property->late_date}} 15, {{ \Carbon\Carbon::now()->addMonth()->format('F') }}, {{ \Carbon\Carbon::now()->year }}</p>

                    <br><a id="submit" href="{{ route('tenants.billing.pay') }}" class="btn btn-primary">Make a Payment</a>
                   
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('otherJs')

<script>
    $('#submit').on('click', function(e){

        $('#loading').show();
        //$('#form').submit();
        console.log('heey')
    });
</script>

@endsection