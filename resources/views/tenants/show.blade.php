@extends('layouts.app', ['page_title' => 'Tenant Profile'])

@section('content')
@include('layouts.headers.cards')

<div class="container-fluid mt--9">

    <div class="row">
        <div class="col">
            @if(Session::has('info'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <h4 class="alert-heading">Success!</h4>
                    <p>{{ Session::get('info') }}</p>
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
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">{{ $tenant->name }}</h3>
                        </div>
                        <div class="col-4 text-right">
                        </div>
                    </div>
                </div>

                <div class="card-body">
                
                    <table class="table">
                        <tr>
                            <td>Phone Number</td>
                            <td>{{ $tenant->phone }}</td>
                        </tr>
                        <tr>
                            <td>Work Phone</td>
                            <td>{{ $tenant->work_phone }}</td>
                        </tr>
                        <tr>
                            <td>Email Address</td>
                            <td>{{ $tenant->email }}</td>
                        </tr>
                        <tr>
                            <td>Tenant Partner</td>
                            <td>{{ $tenant->secondary_name }}</td>
                        </tr>
                        <tr>
                            <td>Partner Phone</td>
                            <td>{{ $tenant->secondary_phone }}</td>
                        </tr>
                        <tr>
                            <td>Partner Work Phone</td>
                            <td>{{ $tenant->secondary_work_phone }}</td>
                        </tr>
                        <tr>
                            <td>Partner Email</td>
                            <td>{{ $tenant->secondary_email }}</td>
                        </tr>
                        <tr>
                            <td>Number of Occupants</td>
                            <td>{{ $tenant->number_occupants }}</td>
                        </tr>
                        <tr>
                            <td>Resident</td>
                            <td>
                                @if($tenant->active === 0)
                                    Not a current resident
                                @else
                                    Current Resident
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>Property</td>
                            <td>
                                @if( $property != null )
                                {{ $property->address_1 }} {{ $property->address_2 }} {{ $property->address_3 }}
                                @endif
                            </td>
                        </tr>
                    </table>

                    @if($tenant->active === 1)
                    <div class="mt-5">
                        <a href="{{ route('tenants.archive', ['id' => $tenant->user_id ]) }}" class="btn btn-danger">Archive Tenanat</a>
                        <a href="{{ route('tenants.edit', ['id' => $tenant->user_id ]) }}" class="btn btn-primary shadow">Edit Tenanat</a>
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Billing History</h3>
                        </div>
                        <div class="col-4 text-right">
                        </div>
                    </div>
                </div>

                <div class="card-body">
                
                    @if( $invoices->isEmpty() ) 
                        <p class="text-center">No transactions at this time</p>
                    @else

                        <div class="table-responsive">
                            <table class="table align-items-center table-flush table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Date</th>
                                        <th scope="col">Type</th>
                                        <th scope="col">Amount</th>
                                        <th scope="col">Paid In Full</th>
                                        <!-- <th scope="col">Receipt</th> -->
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach( $invoices as $invoice )
                                    <tr>
                                        <td scope="row">
                                            @if( $invoice->payment_method === 'cash/check')
                                                <a href="{{ route('tenants.billing.history.show', ['id' => $invoice->id]) }}">{{ \Carbon\Carbon::parse($invoice->created_at)->toFormattedDateString() }}</a></td>
                                            @else
                                                {{ \Carbon\Carbon::parse($invoice->created_at)->toFormattedDateString() }}
                                            @endif
                                        <td>{{ $invoice->payment_method }}</td>
                                        <td>${{ $invoice->amount_paid }}</td>
                                        <td>
                                            @if($invoice->paid_in_full === 1)
                                                <span class="text-success"><i class="fas fa-check pr-2"></i> Yes</span>
                                            @else
                                                <span class="text-danger"><i class="fas fa-times pr-2"></i> No</span>
                                            @endif
                                        </td>
                                        <!-- <td><a href="{{ $invoice->invoice_pdf }}"><i class="fas fa-download pr-2"></i> Download Invoice</a></td> -->
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- to do: create pagination for billing -->
                    @endif

                </div>
            </div>
        </div>
    </div>

    @include('layouts.footers.auth')
</div>
@endsection
