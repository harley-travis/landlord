@extends('layouts.app')

@section('content')
<div class="container">

    @if (session('info'))
        <div class="alert alert-success" role="alert">
            {{ session('info') }}
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
								<!-- <a href="#" class="text-primary">Set Default</a> -->
								<a href="#" class="btn btn-outline-danger" data-toggle="modal" data-target="#deleteACH">Delete Account</a>

                                <!-- Delete ACH Modal -->
                                <div class="modal fade" id="deleteACH" tabindex="-1" role="dialog" aria-labelledby="deleteACHLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteACHLabel">Are you sure you want to delete this ACH account?</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            If you delete your ACH account, it will remove all information regarding this account. If you would like to continue using this account, click cancel.
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-success" data-dismiss="modal">GO BACK</button>
                                            <a href="{{ route('settings.billing.ach.delete', ['id' => $bank_account->id ]) }}" class="btn btn-outline-danger">YES, DELETE ACCOUNT</a>
                                        </div>
                                        </div>
                                    </div>
                                </div>

                                @if($bank_account->status != "verified")
                                <a href="{{ route('settings.billing.ach.verify', ['id' => $bank_account->id ]) }}" class="btn btn-success">Verify ACH Account</a>
                                @endif

							</span>
						</li>
						@endforeach 
					</ul>
                    
                    <div class="mt-3">
                        <a href="{{ route('settings.billing.ach.create') }}" class="btn btn-primary">Add ACH Account</a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

@endsection
