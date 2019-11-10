@extends('layouts.app')

@section('content')
<div class="container">

    @if (session('info'))
        <div class="alert alert-success shadow-sm" role="alert">
            <i class="fas fa-info-circle pr-2"></i>{{ session('info') }}
        </div>
    @endif

    @if (session('danger'))
        <div class="alert alert-danger shadow-sm" role="alert">
            <i class="fas fa-exclamation-circle pr-2"></i>{{ session('danger') }}
        </div>
    @endif

    <div class="row justify-content-center pb-4">
        <div class="col-md-12">

            <div class="card shadow">
                <div class="card-header">ACH Accounts</div>

                <div class="card-body">

                    <ul class="list-group">
					    @foreach( $bank_accounts as $bank_account )
						<li class="list-group-item">
							<span class="col-6">
                                <i class="fas fa-university"></i> {{ $bank_account->bank_name }}
                                <span class="pl-3">******** {{ $bank_account->last4 }} </span>
                            
                                @if($bank_account->id == $customer->default_source)
                                    <span class="badge badge-primary">Default</span>
                                @endif
                            </span>

							<span class="col-6">
                                <div class="float-right">

                                    @if( $bank_account->id != $customer->default_source )
                                    <a href="#" class="btn btn-link" data-toggle="modal" data-target="#setDefault">Set Default</a>

                                    <!-- Authorize ACH Modal -->
                                    <div class="modal fade" id="setDefault" tabindex="-1" role="dialog" aria-labelledby="setDefaultLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="setDefaultLabel">Are you sure you want to authorize this ACH account?</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>In order to process your payment, you need to authorize SenRent to charge this account on file. Authorizing payment will auto enroll into our monthly payment program of $15/month for 5 properties and an additional $2 charge per additional property.</p>
                                                <p>Each month may vary the cost, depending on how many properties you added this month.</p>
                                                <p>By clicking, 'Authorize Payment', you agree to our Terms and Conditions and authorize SenRent to charge the account on file.
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cancel</button>
                                                <a href="{{ route('settings.billing.setDefault', ['id' => $bank_account->id ]) }}" class="btn btn-success shadow">Set Default and Authorize</a> 
                                   
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    
                                    @endif

                                    <a href="#" class="btn btn-outline-danger" data-toggle="modal" data-target="#deleteACH"><i class="far fa-trash-alt pr-2"></i> Delete Account</a>

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
                                                <button type="button" class="btn btn-success" data-dismiss="modal">Go Back</button>
                                                <a href="{{ route('settings.billing.ach.delete', ['id' => $bank_account->id ]) }}" class="btn btn-outline-danger"><i class="far fa-trash-alt pr-2"></i> YES, DELETE ACCOUNT</a>
                                            </div>
                                            </div>
                                        </div>
                                    </div>

                                    @if($bank_account->status != "verified")
                                    <a href="{{ route('settings.billing.ach.verify', ['id' => $bank_account->id ]) }}" class="btn btn-success"><i class="fas fa-user-check pr-2"></i> Verify ACH Account</a>
                                    @endif

<!-- 

    LEFT OFF HERE 
    FOR SOME REAONS THE AUTHORIZE PAYMENT IS NOT SHOWING UP ANY MORE
    I NEED TO FIND A WAY TO SHOW THAT AGAIN
    I SEEMS THAT PENDING STATUS IS NO LONGER AN OPTION?
    PERHAPS IT'S BECAUSE IT ONLY WORKS ON THE FIRST ACH ACCOUNT. 
    IF YOU ADD ANOTHER ONE I DON'T THINK TAHT IT SHOWS IT

    OKAY SO IT'S NOT BECAUSE THERE ARE MULTIPLE ACCOUNTS. IT JUST DOESN'T SHOW PENDING ANYMORE
    I HAVE CHANGED THE SET DEFAULT FUNCTION TO NOW POP UP AND ASK TO AUTHORIZE
    I NEED TO SET UP THAT FUNCTINALITY

    I NEED TO FIGURE OUT A BETTER WAY TO ASK TO AUTHORIZE THE ACCOUNT
    MAYBE I REDIRECT AFTER THE ACCOUNT HAS BEEN VERIFED TO THE AUTHORIZE PAGE

    IF THE SET A NEW ACCOUNT AS DEFAULT, THEN THE POP WILL ALSO AUTHORIZE THE ACCOUNT
-->

                                    @if($bank_account->status === "pending")
                                    <a href="#" class="btn btn-success" data-toggle="modal" data-target="#authorizeACH"><i class="fas fa-check pr-2"></i> Authorize Payment</a>

                                    <!-- Authorize ACH Modal -->
                                    <div class="modal fade" id="authorizeACH" tabindex="-1" role="dialog" aria-labelledby="authorizeACHLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="authorizeACHLabel">Are you sure you want to authorize this ACH account?</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>In order to process your payment, you need to authorize SenRent to charge this account on file. Authorizing payment will auto enroll into our monthly payment program of $15/month for 5 properties and an additional $2 charge per additional property.</p>
                                                <p>Each month may vary the cost, depending on how many properties you added this month.</p>
                                                <p>By clicking, 'Authorize Payment', you agree to our Terms and Conditions and authorize SenRent to charge the account on file.
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cancel</button>
                                                <a href="{{ route('settings.billing.ach.authorize', ['id' => $bank_account->id ]) }}" class="btn btn-success"><i class="fas fa-check pr-2"></i> Authorize Payment</a>
                                            </div>
                                            </div>
                                        </div>
                                    </div>


                                    @endif
                                </div>
							</span>
						</li>
						@endforeach 
					</ul>
                    
                    <div class="mt-3">
                        <a href="{{ route('settings.billing.ach.create') }}" class="btn btn-outline-success"><i class="fas fa-plus-circle pr-2"></i>Add ACH Account</a>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card shadow">
                <div class="card-header">Billing History</div>
                <div class="card-body">

                    <table class="table table-borderless table-hover">
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

                            @foreach( $invoices as $invoice )
							<tr>
								<td scope="row">{{ \Carbon\Carbon::createFromTimestamp($invoice->created)->toFormattedDateString() }}</td>
								<td>Automatic Charge</td>
								<td>${{ $invoice->amount_paid / 100 }}</td>
								<td>
									@if($invoice->attempted == 1)
										<span class="text-success"><i class="fas fa-check pr-2"></i> Success</span>
									@else
										<span class="text-danger"><i class="fas fa-times pr-2"></i> Failed</span>
									@endif
								</td>
								<td><a href="{{ $invoice->invoice_pdf }}"><i class="fas fa-download pr-2"></i> Download Invoice</a></td>
							</tr>
							@endforeach

						</tbody>
					</table>

                    <!-- to do: create pagination for billing -->

                </div>
            </div>
        </div>
    </div>

</div>

@endsection
