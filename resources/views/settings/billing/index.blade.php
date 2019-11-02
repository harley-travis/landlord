@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row justify-content-center pb-5">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Billing Management</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <a href="{{ route('settings.billing.create') }}" class="btn btn-primary">Add Payment Method</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center pb-5">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">Invoices</div>
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
                <div class="card-header">Credit Cards</div>

                <div class="card-body">

                    <ul class="list-group">
						
					</ul>


    

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
					
					</ul>
                    

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
