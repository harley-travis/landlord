@extends('layouts.app', ['page_title' => "Onboarding"])

@section('head')

<script src="https://js.stripe.com/v3/"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>

@endsection

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

            @if (session('danger'))
                <div class="alert alert-danger shadow-sm alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle pr-2"></i>{{ session('danger') }}
                </div>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            @endif
        </div>
    </div>

    <div class="row mt-3">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Billing Onboarding</h3>
                        </div>
                        <div class="col-4 text-right">
                        </div>
                    </div>
                </div>

                <div class="card-body">

                    <div class="alert alert-primary alert-dismissible fade show mb-5" role="alert">
                        <h4 class="alert-heading">Heads up!</h4>
                        <p>In order to receive direct deposits, you are required to fill out the following information. You will not be able to receive direct deposits without completing this onboarding form. Make sure that you are the property owner and that you are signed in under the property owner account as you fill out this information.</p>
                    </div>

                    <form class="my-form" action="{{ route('settings.billing.onboarding.add') }}" method="post">

                        <!-- onboarding -->
                        <h4 class="mb-3">Account Type</h4>

                        <div class="form-group mb-4">
                            <div class="custom-control custom-radio mb-3">
                                <input class="custom-control-input" type="radio" id="company" name="business_type" value="company" checked="">
                                <label class="custom-control-label" for="company">
                                    Business
                                </label>
                            </div>
                            <div class="custom-control custom-radio mb-3">
                                <input class="custom-control-input" type="radio" id="individual" name="business_type" value="individual">
                                <label class="custom-control-label" for="individual">
                                    Individual
                                </label>
                            </div>
                        </div>

                        <!-- show if they clicked on the company business_type -->
                        <div class="form-group">
                            <label for="company_name">Company Name</label>
                            <input type="text" class="form-control" name="company_name" aria-describedby="company_name">
                        </div>
                        <!-- show if they clicked on the company business_type -->

                        <div class="form-group">
                            <label for="business_profile_url">Business Website</label>
                            <input type="text" class="form-control" name="business_profile_url" aria-describedby="business_profile_url">
                        </div>

                        <div class="form-group">
                            <label for="product_description">Product Description</label>
                            <textarea class="form-control" name="product_description" rows="3"></textarea>
                        </div>

                        
                        <!-- Person -->
                        <h4 class="mt-5 mb-3">Personal Information</h4>

                        <div class="form-row mb-3">
                            <div class="col-6">
                                <label for="first_name">First Name</label>
                                <input type="text" class="form-control" name="first_name" aria-describedby="first_name">
                            </div>

                            <div class="col-6">
                                <label for="last_name">Last Name</label>
                                <input type="text" class="form-control" name="last_name" aria-describedby="last_name">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="country">Select Country</label>
                            <input type="text" class="form-control" name="country" aria-describedby="country" placeholder="United States" value="United States">
                            <small id="emailHelp" class="form-text text-muted">Currently we only support the United States.</small>
                        </div>

                        <div class="form-group">
                            <label for="ssn_last_4">Last 4 of your Social Security Number</label>
                            <input type="text" class="form-control" name="ssn_last_4" aria-describedby="ssn_last_4">
                        </div>

                        <h4 class="mt-5 mb-3">Date of Birth</h4>
                        
                        <div class="form-row mb-5">

                            <div class="col-4">
                                <label for="day">Day</label>
                                <select class="form-control" name="day">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                    <option value="13">13</option>
                                    <option value="14">14</option>
                                    <option value="15">15</option>
                                    <option value="16">16</option>
                                    <option value="17">17</option>
                                    <option value="18">18</option>
                                    <option value="19">19</option>
                                    <option value="20">20</option>
                                    <option value="21">21</option>
                                    <option value="22">22</option>
                                    <option value="23">23</option>
                                    <option value="24">24</option>
                                    <option value="25">25</option>
                                    <option value="26">26</option>
                                    <option value="27">27</option>
                                    <option value="28">28</option>
                                    <option value="29">29</option>
                                    <option value="30">30</option>
                                    <option value="31">31</option>
                                </select>
                            </div>

                            <div class="col-4">
                                <label for="month">Month</label>
                                <select class="form-control" name="month">
                                    <option value="1">January</option>
                                    <option value="2">February</option>
                                    <option value="3">March</option>
                                    <option value="4">April</option>
                                    <option value="5">May</option>
                                    <option value="6">June</option>
                                    <option value="7">July</option>
                                    <option value="8">August</option>
                                    <option value="9">September</option>
                                    <option value="10">October</option>
                                    <option value="11">November</option>
                                    <option value="12">December</option>
                                </select>
                            </div>

                            <div class="col-4">
                                <label for="year">Year</label>
                                <input type="text" class="form-control" name="year" aria-describedby="year" placeholder="EX: 1955">
                            </div>

                        </div>

                        <p>By clicking, you agree to <a href="https://senrent.com/terms-of-service.php" target="_blank">our terms</a> and the <a href="https://stripe.com/connect-account/legal" target="_blank">Stripe Connected Account Agreement</a>.</p>
                        <button type="submit" class="btn btn-success">Save Account Information</button>

                        <input type="hidden" name="token-account" id="token-account">
                        <input type="hidden" name="token-person" id="token-person">

                        @csrf

                    </form>
                    
                </div> <!-- card-body -->
            </div><!-- card -->
        </div><!-- col -->
    </div> <!-- row -->

    @include('layouts.footers.auth')

</div>

@endsection

@section('otherJs')

    <script>

        const stripe = Stripe('{{config('services.stripe.key')}}');
        const myForm = document.querySelector('.my-form');
        myForm.addEventListener('submit', handleForm);

        async function handleForm(event) {

            event.preventDefault();

            const accountResult = await stripe.createToken('account', {
                business_type: 'company',
                company: {
                    name: document.querySelector('.inp-company-name').value,
                    address: {
                        line1: document.querySelector('.inp-company-street-address1').value,
                        city: document.querySelector('.inp-company-city').value,
                        state: document.querySelector('.inp-company-state').value,
                        postal_code: document.querySelector('.inp-company-zip').value,
                    },
                },
                tos_shown_and_accepted: true,
            });

            const personResult = await stripe.createToken('person', {
                person: {
                    first_name: document.querySelector('.inp-person-first-name').value,
                    last_name: document.querySelector('.inp-person-last-name').value,
                    address: {
                        line1: document.querySelector('.inp-person-street-address1').value,
                        city: document.querySelector('.inp-person-city').value,
                        state: document.querySelector('.inp-person-state').value,
                        postal_code: document.querySelector('.inp-person-zip').value,
                    },
                },
            });

            if (accountResult.token && personResult.token) {
                document.querySelector('#token-account').value = accountResult.token.id;
                document.querySelector('#token-person').value = personResult.token.id;
                myForm.submit();
            }
        }

    </script>

@endsection
