@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-danger text-white">Free Trial Expiration</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p>Your account has expired. To keep using the software, please add an ACH account to begin your billing cycle. <p>
                    
                    <p>Our pricing starts out at just $15 a month that comes with 5 properties. Add additional properties for just $2 a property.</p>

                    <a href="{{ route('settings.billing.ach.create') }}" class="btn btn-success">Add an ACH account now</a>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
