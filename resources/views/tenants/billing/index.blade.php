@extends('layouts.app', ['page_title' => "Rent Preview"])

@section('content')
@include('layouts.headers.cards')

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

                    <form action="{{ route('tenants.billing.pay') }}" method="post">

                    
                        @if( $property->paid === 1 && Carbon\Carbon::now()->gte(Carbon\Carbon::parse($property->last_date_paid)) && $property->isPastDue == 0 ) 
                            <h2 class="display-2 text-success mb-5">$0.00</h2>

                        @elseif ( Carbon\Carbon::now()->gte(Carbon\Carbon::parse($property->late_date)) || Carbon\Carbon::now()->gte(Carbon\Carbon::parse(15)) ) 
                            <h2 class="display-2 text-danger mb-5">${{ $property->rent_amount + $property->late_fee }}</h2>
                            <p>Payment due {{ \Carbon\Carbon::now()->addMonth()->format('F') }} 1, {{ \Carbon\Carbon::now()->year }}</p>
                            <p class="text-danger font-weight-bold">Added late fee: ${{ $property->late_fee }}</p>

                            <input type="hidden" name="amount" value="{{ $property->rent_amount + $property->late_fee }}">
                        @else
                            <h2 class="display-2 text-danger mb-5">${{ $property->rent_amount }}</h2>
                            <p>Payment due {{ \Carbon\Carbon::now()->addMonth()->format('F') }} 1, {{ \Carbon\Carbon::now()->year }}</p>
                            
                            <input type="hidden" name="amount" value="{{ $property->rent_amount }}">
                        @endif

                        <p>If the full amount is not paid by the <span class="text-danger">{{ \Carbon\Carbon::now()->addMonth()->format('F') }} @if( $property->late_date === null || $property->late_date == '' ) 15 @else {{ $property->late_date }},@endif {{ \Carbon\Carbon::now()->year }}</span>, then a late fee of <span class="text-danger">${{ $property->late_fee }}</span> taxed on.</p>

                            @csrf

                        <br><button type="submit" class="btn btn-primary">Make a Payment</a>
                   
                    @endif

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
