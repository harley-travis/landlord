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
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#transactionModal">Save Transaction</button>                 

                </div>
            </div>
        </div>
    </div>


     <!-- Modal -->
     <div class="modal fade" id="transactionModal" tabindex="-1" role="dialog" aria-labelledby="transactionModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="transactionModalLabel">Are you sure you want to add this transaction?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to save this payment? You will be able to update this transaction at a later time.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success shadow">Yes, Create Transaction</button>
            </div>
            </div>
        </div>
    </div>

    </form>

    @include('layouts.footers.auth')
</div>
@endsection
