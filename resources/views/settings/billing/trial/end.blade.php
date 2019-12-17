@extends('layouts.app', ['page_title' => "Free Trial Expiration"])

@section('content')
@include('layouts.headers.cards')

<div class="container-fluid mt--9">

    <div class="row">
        <div class="col">
            @if(Session::has('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <h4 class="alert-heading">Success!</h4>
                    <p>{{ Session::get('status') }}</p>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="card shadow">
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

                    <p>Your account has expired. To keep using the software, please add an ACH account to begin your billing cycle. <p>
                    
                    <p>Our pricing starts out at just $15 a month that comes with 5 properties. Add additional properties for just $2 a property.</p>

                    <a href="{{ route('settings.billing.ach.create') }}" class="btn btn-success shadow">Add an ACH account now</a>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
