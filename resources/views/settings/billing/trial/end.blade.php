@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Free Trial Expiration</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    Your account has expired. To keep using the software, please add an ACH account to begin your billing cycle. 
                    Checkout our pricing here. 

                    DISPLAY PRICING

                    ADD BUTTON TO ADD ACH HERE
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
