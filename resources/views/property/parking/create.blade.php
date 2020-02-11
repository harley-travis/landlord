@extends('layouts.app', ['page_title' => "Add Parking Space"])

@section('content')
@include('layouts.headers.cards')

<div class="container-fluid mt--9">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Add New Parking Space</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('property.parking') }}" class="btn btn-primary">Go Back</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">

                    @if ($errors->any())
                        <div class="alert alert-danger" role="alert">
                            <h4 class="alert-heading">Hold the phone! You forgot something...</h4>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('property.parking.add') }}" method="post">

                        <div class="form-group">
                            <label for="location">Parking Location <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="location" aria-describedby="location" placeholder="Enter parking location" value="{{ old('location') }}" required>
                            @error('location')
                                <span class='invalid-feedback'>{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- need a drop down here -->
                        <div class="form-group">
                            <label for="location">Parking Type <span class="text-danger">*</span></label>
                            <select id="type" name="type" class="form-control form-control-alternative" required>
                                <option value="" disabled selected>Select Parking Type</option>
                                <option value="0">Carport</option>
                                <option value="1">Garage</option>
                            </select>
                            @if ($errors->has('type'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('type') }}</strong>
                                </span>
                            @endif
                        </div>   

                        <div class="form-group">
                            <label for="parking_deposit_amount">Parking Deposit Amount</label>
                            <input type="text" class="form-control" name="parking_deposit_amount" aria-describedby="parking_deposit_amount" placeholder="Enter the deposit amount" value="{{ old('parking_deposit_amount') }}">
                        </div>

                        <div class="form-group">
                            <label for="monthly_fee">Monthly Charge For Parking Space</label>
                            <input type="text" class="form-control" name="monthly_fee" aria-describedby="monthly_fee" placeholder="Enter parking location" value="{{ old('monthly_fee') }}">
                        </div>

                        @csrf
                        
                        <button type="submit" class="btn btn-success shadow">Save Parking Space</button>

                    </form>

                </div>
            </div>
        </div>
    </div>

    @include('layouts.footers.auth')
</div>
@endsection
