@extends('layouts.app')

@section('content')
<div class="container">

    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <div class="row justify-content-center pb-5">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">Billing History</div>
                <div class="card-body">

                    <table class="table table-borderless">
						<thead>
							<tr>
								<th scope="col">Date</th>
								<th scope="col">Type</th>
								<th scope="col">Amount</th>
								<th scope="col">Paid</th>
								<th scope="col">Receipt</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>

                </div>
            </div>
        </div>
    </div>

    <!-- <div class="row justify-content-center pb-5">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Credit Cards</div>

                <div class="card-body">

                    <ul class="list-group">
						
					</ul>

                    <div class="mt-3">
                        <a href="{{ route('settings.billing.create') }}" class="btn btn-primary">Add Payment Method</a>
                    </div>
                </div>
            </div>

        </div>
    </div> -->

    <div class="row justify-content-center pb-5">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">ACH Accounts</div>

                <div class="card-body">

                    <ul class="list-group">
					    @foreach( $bank_accounts as $bank_account )
						<li class="list-group-item">
							<span class="col-6">
							<i class="fas fa-university"></i> {{ $bank_account->bank_name }}
								<span class="pl-3">**** {{ $bank_account->last4 }} </span>
							</span>
							@if($bank_account->id == $customer->default_source)
								<span class="badge badge-primary">Default</span>
							@endif
							<span class="col-6 float-right text-right">
								<a href="#" class="text-primary">Set Default</a>
								<a href="#" class="text-danger"><i class="far fa-trash-alt"></i></a>
							</span>
						</li>
						@endforeach 
					</ul>
                    
                    <div class="mt-3">
                        <a href="{{ route('settings.billing.createACH') }}" class="btn btn-primary">Add ACH Account</a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
