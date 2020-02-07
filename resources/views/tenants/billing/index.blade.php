@extends('layouts.app', ['page_title' => "Rent Preview"])

@section('content')
@include('layouts.headers.cards')

<div class="container-fluid mt--9">

    <div class="row">
        <div class="col">
            @if(Session::has('info'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <h4 class="alert-heading">Success!</h4>
                    <p>{{ Session::get('info') }}</p>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
        </div>
    </div>

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

                    @if( $tenant->property_id === null )
                        <span class="text-danger font-weight-bold">Your landlord has not assigned you to a property yet. Contact them if you don't see your property in a day or two.</span>
                    @else

                    <form action="{{ route('tenants.billing.pay') }}" method="post">
                                                       
                        @if( $property->balance === 0 ) 
                            <h2 class="display-2 text-success mb-5">$0.00</h2>

                        @elseif ( $betweenDates === false && $property->balance > 0) 
                            <h2 class="display-2 text-danger mb-5">{{ $property->balance }}</h2>

                        @elseif ( $betweenDates === true ) 
                            <h2 class="display-2 text-danger mb-5">${{ $property->rent_amount + $property->balance + $property->late_fee }}</h2>
                            <p>Payment was due {{ \Carbon\Carbon::now()->addMonth()->format('F') }} 1, {{ \Carbon\Carbon::now()->year }}</p>
                            <p class="text-danger font-weight-bold">Added late fee: 
                            
                            @if( $property->late_fee === null ) 
                                $20 
                                <input type="hidden" name="late_fee" value="20">
                            @else 
                                ${{ $property->late_fee }} 
                                <input type="hidden" name="late_fee" value="{{ $property->late_fee }}">
                            @endif
                            </p>

                            <input type="hidden" name="amount" value="{{ $property->rent_amount + $property->balance + $property->late_fee }}">
                        @else
                            <h2 class="display-2 text-danger mb-5">${{ $property->rent_amount + $property->balance }}</h2>
                            <p>Payment due {{ \Carbon\Carbon::now()->addMonth()->format('F') }} 1, {{ \Carbon\Carbon::now()->year }}</p>
                            
                            <input type="hidden" name="amount" value="{{ $property->rent_amount + $property->balance }}">
                        @endif

                        <p>If the full amount is not paid by the <span class="text-danger">{{ \Carbon\Carbon::now()->addMonth()->format('F') }} @if( $property->late_date === null || $property->late_date == '' ) 17, @else {{ $property->late_date }},@endif {{ \Carbon\Carbon::now()->year }}</span>, then a late fee of <span class="text-danger"> @if( $property->late_fee === null ) $20 @else ${{ $property->late_fee }} @endif</span> taxed on.</p>

                        @csrf

                        <br><button type="submit" class="btn btn-primary">Make a Payment</a>
                   
                    @endif

                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.footers.auth')
</div>
@endsection
