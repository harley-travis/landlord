@extends('layouts.app', ['page_title' => "Pricing Wizard"])

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
                            <h3 class="mb-0">Pricing Wizard</h3>
                        </div>
                        <div class="col-4 text-right">
                            @if(Auth::user()->role >= 4)
                            <a class="btn btn-success" href="{{ route('pricing-wizard.create') }}"><i class="fas fa-plus-circle pr-2"></i> Add Pricing</a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">   

                    @if( $check->isEmpty() || $check->count() === 0)

                    <p class="text-center">It doesn't look like there is pricing setup for your account. Let's setup your pricing!</p>
                    <div class="pb-5 text-center">
                        <a class="btn btn-success" href="{{ route('pricing-wizard.create') }}"><i class="fas fa-plus-circle pr-2"></i> Setup Pricing</a>
                    </div>

                    @else

                        @if(Auth::user()->role >= 4)
                        <table class="table align-items-center table-flush table-hover mb-5">
                            <thead class="thead-light">
                                <tr>
                                    <th>User</th>
                                    <th>Number of Properties</th>
                                    <th>Stripe Payout Fees</th>
                                    <th>Monthly Charges</th>
                                    <th></th>
                                </tr>
                            </thead>
                            @foreach($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->numberOfProperties }}</td>
                                <td>${{ $user->payoutFee }}</td>
                                <td>${{ $user->pricingAmount }}</td>
                                <td><a href="{{ route('pricing-wizard.edit', ['id' => $user->id ]) }}" class="btn btn-info">Edit Pricing</a></td>
                            </tr>
                            @endforeach()
                                    
                        </table>

                        @else

                        <p>If the number of properties you manage changes, please contact Support to update that change.</p>

                        <table class="table">
                            <tr>
                                <th>User</th>
                                <th>Number of Properties</th>
                                <th>Monthly Charges</th>
                            </tr>       
                            <tr>
                                <td>{{ $singleUser->name }}</td>
                                <td>{{ $singleUser->numberOfProperties }}</td>
                                <td>${{ $singleUser->pricingAmount }}</td>
                            </tr>
                        </table>

                        @endif

                    @endif
                </div>
            </div>
        </div>
    </div>

    @include('layouts.footers.auth')
</div>
@endsection
