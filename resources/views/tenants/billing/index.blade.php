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


                    @if( $property->rent_amount === 0) 
                    Amount: $0.00
                    @else
                    Amount: ${{ $property->rent_amount }}
                    Due: 1 {{ \Carbon\Carbon::now()->addMonth()->format('F') }}, {{ \Carbon\Carbon::now()->year }}
                    @endif

                    <p>Payment late on the {{ $property->late_date}} {{ \Carbon\Carbon::now()->addMonth()->format('F') }}, {{ \Carbon\Carbon::now()->year }}</p>

                    <br><a href="{{ route('tenants.billing.pay') }}" class="btn btn-primary">Make a Payment</a>
                   

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
