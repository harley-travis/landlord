@extends('layouts.app', ['page_title' => "Confirmation"])

@section('content')
@include('layouts.headers.cards')

<div class="container-fluid mt--9">

    <div class="row mb-3">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0 bg-success">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0 text-white">Payment Confirmation!</h3>
                        </div>
                        <div class="col-4 text-right">
                           
                        </div>
                    </div>
                </div>
                <div class="card-body pb-5 pt-5">

                    <p><i class="ni ni-check-bold text-success mr-3"></i>Thank you for your payment! You will see the funds withdrawn from your account in 1-3 business days.</p>
                    <p>An email confirmation has been sent to you at {{ Auth::user()->email }}</p>
                    <p>Please print this page for your records.</p>


                    <h3<>Payment Details</h3>
                    <div class="table-responsive">
                        <table class="table borderless">
                            <tr>
                                <td>Confirmation Number</td>
                                <td>{{ $confirmation_number }}</td>
                            </tr>
                            <tr>
                                <td>Payment Amount</td>
                                <td>{{ $amount }}</td>
                            </tr>
                            <tr>
                                <td>Payment Method</td>
                                <td>{{ $payment_method }}</td>
                            </tr>
                            <tr>
                                <td>Payment Date</td>
                                <td>{{ $date }}</td>
                            </tr>
                            <tr>
                                <td>Payment Submitted</td>
                                <td>{{ $date }}</td>
                            </tr>
                        </table>
                    </div>
           
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

