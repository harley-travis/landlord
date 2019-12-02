@extends('layouts.app', ['page_title' => "Make Payment"])

@section('content')
@include('layouts.headers.cards')

<div class="container-fluid mt--9">

    <div class="row mb-3">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Payment Amount</h3>
                        </div>
                        <div class="col-4 text-right">
                           
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="responsive-table">
                        <table class="table">
                            <tr>
                                <td>Current balance due: 1 {{ \Carbon\Carbon::now()->addMonth()->format('F') }}, {{ \Carbon\Carbon::now()->year }}</td>
                                <td>$ {{ $property->rent_amount }}</td>
                            </tr>
                        </table>
                    </div>


                </div>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Payment Date</h3>
                        </div>
                        <div class="col-4 text-right">
                           
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="responsive-table">
                        <table class="table">
                            <tr>
                                <td>Select a payment date</td>
                                <td><input type="date" class="form-control" name="date"></td>
                            </tr>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Payment Method</h3>
                        </div>
                        <div class="col-4 text-right">
                           
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <a href="{{ route('tenants.billing.index') }}" class="btn btn-link">Cancel</a>
                    <a href="{{ route('tenants.billing.review') }}" class="btn btn-primary">Continue</a>
                   

                </div>
            </div>
        </div>
    </div>

</div>
@endsection
