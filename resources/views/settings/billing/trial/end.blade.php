@extends('layouts.app', ['page_title' => "Free Trial Expiration"])

@section('content')
@include('layouts.headers.cards')

<div class="container-fluid mt--9">
    <div class="row">
        <div class="col">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-danger border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0 text-white">Free Trial Expiration</h3>
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

                    <p>Your account has expired. To keep using the software, please add an ACH account to begin your billing cycle. <p>
                    
                    <p>Our pricing starts out at just $15 a month that comes with 5 properties. Add additional properties for just $2 a property.</p>

                    <a href="{{ route('settings.billing.ach.create') }}" class="btn btn-success shadow">Add an ACH account now</a>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
