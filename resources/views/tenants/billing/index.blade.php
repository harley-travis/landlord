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

                    @if( $property->paid === 0 && \Carbon\Carbon::now() > $property->last_date_paid && $property->isPastDue == 0 ) 
                        <h2 class="display-2 text-success mb-5">$0.00</h2>
                    @else if ( $property->paid === 2 ) 
                        <h2 class="display-2 text-danger mb-5">${{ $property->rent_amount + $property->late_fee }}</h2>
                        <p>Payment due {{ \Carbon\Carbon::now()->addMonth()->format('F') }} 1, {{ \Carbon\Carbon::now()->year }}</p>
                    @else
                        <h2 class="display-2 text-danger mb-5">${{ $property->rent_amount }}</h2>
                        <p>Payment due {{ \Carbon\Carbon::now()->addMonth()->format('F') }} 1, {{ \Carbon\Carbon::now()->year }}</p>
                    @endif

                    <p>Payment late will be late on {{ \Carbon\Carbon::now()->addMonth()->format('F') }} 15, {{ \Carbon\Carbon::now()->year }}</p>

                    <br><a href="{{ route('tenants.billing.pay') }}" class="btn btn-primary">Make a Payment</a>
                   
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
