@extends('layouts.app', ['page_title' => "Enter Rent Manually"])

@section('content')
@include('layouts.headers.cards')

<div class="container-fluid mt--9">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Enter Rent For {{ $tenant->name }}</h3>
                        </div>
                        <div class="col-4 text-right">
                            
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    
                    <p>Paying rent with cash or check? Add the transaction here.</p>

                    <form action="{{ route('tenants.billing.payment.create') }}" method="post">

                        <div class="form-group">
                            <label for="name">Rent Amount <small class="text-danger pl-2">required</small></label>
                            <input type="text" class="form-control {{ $errors->has('amount_paid') ? 'is-invalid' : '' }}" name="amount_paid" aria-describedby="amount_paid" placeholder="Enter rent amount paid" value="{{ old('amount_paid') }}">
                            @error('amount_paid')
                            <span class='invalid-feedback'>{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="phone">Late Fee Amount</label>
                            <input type="text" class="form-control" name="late_fee_amount" aria-describedby="late_fee_amount" placeholder="Enter late fee amount">
                        </div>

                        <input type="hidden" name="tenant_id" value="{{ $tenant->id }}">
                        
                        @csrf

                        <button type="submit" class="btn btn-success shadow">Save Transaction</button>

                    </form>

                </div>
            </div>
        </div>
    </div>

    @include('layouts.footers.auth')
</div>
@endsection
