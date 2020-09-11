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
            @if(Session::has('warning'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <h4 class="alert-heading">Warning!</h4>
                    <p>{{ Session::get('warning') }}</p>
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
                            <h3 class="mb-0">Edit Pricing</h3>
                        </div>
                        <div class="col-4 text-right">
                        </div>
                    </div>
                </div>
                <div class="card-body">   

                    <form action="{{ route('pricing-wizard.update') }}" method="post">

                        <div class="form-group">
                            <label for="numberOfProperties">Number of Properties <small class="text-danger pl-2">required</small></label>
                            <input type="text" class="form-control {{ $errors->has('numberOfProperties') ? 'is-invalid' : '' }}" name="numberOfProperties" aria-describedby="numberOfProperties" value="{{ $payment->numberOfProperties }}">
                            @error('numberOfProperties')
                            <span class='invalid-feedback'>{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="highestRentAmount">Highest Rent Amount</label>
                            <input type="text" class="form-control" name="highestRentAmount" aria-describedby="highestRentAmount" value="{{ $payment->highestRentAmount }}">
                        </div>

                        @if(Auth::user()->role >= 4)
                        <!-- for senrent admins options -->
                        <div class="form-group">
                            <label for="minimumPricing">Minimum Pricing Amount</label>
                            <input type="text" class="form-control" name="minimumPricing" aria-describedby="minimumPricing" value="{{ $payment->minimumPricing }}">
                            <small id="minimumPricing" class="form-text text-warning">Optional. Only if you want to overrid the current Stripe fees.</small>
                        </div>

                        <div class="form-group">
                            <label for="percentAmount">Percent Markup</label>
                            <input type="text" class="form-control" name="percentAmount" aria-describedby="percentAmount" value="{{ $payment->percentAmount }}">
                            <small id="percentAmount" class="form-text text-warning">Optional. Only if you want to overrid the current Stripe fees.</small>
                        </div>

                        <div class="form-group">
                            <label for="fixedPricing">Fixed Pricing Amount</label>
                            <input type="text" class="form-control" name="fixedPricing" aria-describedby="fixedPricing" value="{{ $payment->fixedPricing }}">
                            <small id="fixedPricing" class="form-text text-warning">What you type here will override the other options that you input in the other values. Be careful, if you enter a loss then SenRent will pay the user a monthly Stripe fees.</small>
                        </div>
                        <!-- end senrent admin options -->
                        @endif

                        <div class="form-group">
                            <label for="user_id">User</label>
                            <select id="user_id" name="user_id" class="form-control">
                                @foreach($users as $user)
                                <option {{ $payment->user_id === $user->id ? 'selected':'' }} value='{{ $user->id }}'>
                                    {{ $user->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>   

                        <input type="hidden" name="id" value="{{ $payment->id}}">
                        
                        @csrf

                        <button type="submit" class="btn btn-success shadow">Update</button>

                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.footers.auth')
</div>
@endsection
