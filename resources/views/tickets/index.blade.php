@extends('layouts.app', ['page_title' => "Documentation and Help Guide"])

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
                            <h3 class="mb-0">Need help? Checkout our guides below.</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('tickets.create') }}" class="btn btn-primary">Submit a Ticket</a>
                        </div>
                    </div>
                    <div class="mt-5">
                        <p>Can't figure something out? Check the documentation and videos below for help. Still can't find what you're looking for? Submit a ticket and we'll get back to you within 24 hours</p>
                    </div>
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
                            <h3 class="mb-0">Frequently Asked Questions</h3>
                        </div>
                        <div class="col-4 text-right">
                            
                        </div>
                    </div>
                    <div class="mt-5">

                        <p class="mt-5 mb-5">Can't find what you're looking for? <a href="{{ route('tickets.create') }}">Submit a ticket for help</a>.</p>

                        <div class="accordion" id="accordionExample">
                            <div class="card">
                                <div class="card-header bg-purple" id="headingOne">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link text-white" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            Properties
                                        </button>
                                    </h2>
                                </div>

                                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                                    <div class="card-body">
                                        <ul>
                                            <li><a href="#">Creating properties</a></li>
                                            <li><a href="#">Editing properties</a></li>
                                            <li><a href="#">Deleting properties</a></li>
                                            <li><a href="#">Assign a tenant to a property</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header bg-purple" id="headingTwo">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link text-white collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            Tenants
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                    <div class="card-body">
                                        <ul>
                                            <li><a href="#">Creating tenants</a></li>
                                            <li><a href="#">Editing tenants</a></li>
                                            <li><a href="#">Archiving tenants</a></li>
                                            <li><a href="#">Assign a tenant to a property</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header bg-purple" id="headingThree">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link text-white collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                            User Management
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                                    <div class="card-body">
                                        <ul>
                                            <li><a href="#">Creating users</a></li>
                                            <li><a href="#">Editing user & user permissions</a></li>
                                            <li><a href="#">Archiving users</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>


                            <div class="card">
                                <div class="card-header bg-purple" id="headingFour">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link text-white collapsed" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                            Billing Managment
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionExample">
                                    <div class="card-body">
                                        <ul>
                                            <li><a href="#">Adding an ACH account</a></li>
                                            @if( Auth::user()->role >= 3 )<li><a href="#">Start accepting payments & onboarding</a></li>@endif
                                            <li><a href="#">Editing ACH account</a></li>
                                            <li><a href="#">Changing default payment method</a></li>
                                            <li><a href="#">Remove ACH account</a></li>
                                            <li><a href="#">Adding credit card payment</a></li>
                                            <li><a href="#">How to pay rent</a></li>
                                            <li><a href="#">Where to find past transactions</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header bg-purple" id="headingFive">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link text-white collapsed" type="button" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                            Maintence
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordionExample">
                                    <div class="card-body">
                                        <ul>
                                            <li><a href="#">Adding maintenance request</a></li>
                                            <li><a href="#">View maintenance request status</a></li>
                                            @if( Auth::user()->role > 0 )
                                            <li><a href="#">Update maintenance request</a></li>
                                            <li><a href="#">View archived maintenance requests</a></li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.footers.auth')
</div>
@endsection
