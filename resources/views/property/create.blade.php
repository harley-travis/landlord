@extends('layouts.app', ['page_title' => "Add Property"])

@section('content')
@include('layouts.headers.cards')

<div class="container-fluid mt--9">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Add New Property</h3>
                        </div>
                        <div class="col-4 text-right">
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

                    <div class="alert alert-default" role="alert">
                        <h2 class="alert-heading">Heads up!</h2>
                        <p>Your pricing depends on the number of properties you have and the amount of money you charge for rent. We'll let you know if you are approaching the minimum amount of $200. If you're curious how many properties you can use, check out our calculator <a href="#">here.</a></p>
                        <p class="mb-0">If you have questions about pricing, please contact us at Support@SenRent.com</p>
                    </div>

                    <form action="{{ route('property.add') }}" method="post">

                        <div class="accordion" id="accordionExample">
                            <div class="card">
                                <div class="card-header bg-purple" id="headingOne">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link text-white" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            Property Details <small class="text-danger pl-2">required</small>
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                                    <div class="card-body">

                                        <div class="form-group">
                                            <label for="address_1">Address 1 <small class="text-danger pl-2">required</small></label>
                                            <input type="text" class="form-control {{ $errors->has('address_1') ? 'is-invalid' : '' }}" name="address_1" aria-describedby="address_1" placeholder="Enter address 1" value="{{ old('address_1') }}">
                                            @error('address_1')
                                            <span class='invalid-feedback'>{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="address_2">Address 2</label>
                                            <input type="text" class="form-control" name="address_2" aria-describedby="address_2" placeholder="Enter address 2" value="{{ old('address_2') }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="address_3">Address 3</label>
                                            <input type="text" class="form-control" name="address_3" aria-describedby="address_3" placeholder="Enter address 3" value="{{ old('address_3') }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="city">City <small class="text-danger pl-2">required</small></label>
                                            <input type="text" class="form-control {{ $errors->has('city') ? 'is-invalid' : '' }}" name="city" aria-describedby="city" placeholder="Enter city" value="{{ old('city') }}">
                                            @error('city')
                                            <span class='invalid-feedback'>{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="state">State <small class="text-danger pl-2">required</small></label>
                                            <input type="text" class="form-control {{ $errors->has('state') ? 'is-invalid' : '' }}" name="state" aria-describedby="state" placeholder="Enter state" value="{{ old('state') }}">
                                            @error('state')
                                            <span class='invalid-feedback'>{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="zip">Zip <small class="text-danger pl-2">required</small></label>
                                            <input type="text" class="form-control {{ $errors->has('zip') ? 'is-invalid' : '' }}" name="zip" aria-describedby="zip" placeholder="Enter zip" value="{{ old('zip') }}">
                                            @error('zip')
                                            <span class='invalid-feedback'>{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="country">Country <small class="text-danger pl-2">required</small></label>
                                            <input type="text" class="form-control {{ $errors->has('country') ? 'is-invalid' : '' }}" name="country" aria-describedby="country" placeholder="Enter country" value="{{ old('country') }}">
                                            @error('country')
                                            <span class='invalid-feedback'>{{ $message }}</span>
                                            @enderror
                                        </div>

                                        @if( Auth::user()->product === 1 ||  Auth::user()->product === 2 || Auth::user()->product === 10 )

                                        <div class="form-group">
                                            <label for="occupied">Occupied</label>
                                            <div class="custom-control custom-radio mb-3">
                                                <input name="occupied" class="custom-control-input" id="occupied_no" type="radio" value="0" checked="">
                                                <label class="custom-control-label" for="occupied_no">No</label>
                                            </div>
                                            <div class="custom-control custom-radio mb-3">
                                                <input name="occupied" class="custom-control-input" id="occupied_yes" type="radio" value="1">
                                                <label class="custom-control-label" for="occupied_yes">Yes</label>
                                            </div>
                                        </div>

                                        <!-- <div class="form-group">
                                            <label for="occupied">Vacancy</label>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="occupied" id="occupied_yes" value="0" checked>
                                                <label class="form-check-label" for="occupied_yes">No</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="occupied" id="occupied_no" value="1">
                                                <label class="form-check-label" for="occupied_no">Yes</label>
                                            </div>
                                        </div>  -->
<!-- 
                                        <div class="form-group">
                                            <label for="pet">Pets Allowed</label>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="pet" id="pet_yes" value="0" checked>
                                                <label class="form-check-label" for="pet_yes">No</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="pet" id="pet_no" value="1">
                                                <label class="form-check-label" for="pet_no">Yes</label>
                                            </div>
                                        </div> -->

                                        <div class="form-group">
                                            <label for="pet">Pets Allowed</label>
                                            <div class="custom-control custom-radio mb-3">
                                                <input name="pet" class="custom-control-input" id="pet_no" type="radio" value="0" checked="">
                                                <label class="custom-control-label" for="pet_no">No</label>
                                            </div>
                                            <div class="custom-control custom-radio mb-3">
                                                <input name="pet" class="custom-control-input" id="pet_yes" type="radio" value="1">
                                                <label class="custom-control-label" for="pet_yes">Yes</label>
                                            </div>
                                        </div>

                                        @endif

                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header bg-purple" id="headingTwo">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link text-white collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            Rent Information <small class="text-danger pl-2">required</small>
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                    <div class="card-body">
                                  
                                        <div class="form-group">
                                            <label for="lease_length">Lease Length</label>
                                            <input type="text" class="form-control" name="lease_length" aria-describedby="lease_length" placeholder="Enter length of lease" value="{{ old('lease_length') }}">
                                        </div>

                                        @if( Auth::user()->product === 1 ||  Auth::user()->product === 2 || Auth::user()->product === 10 )

                                        <div class="form-group">
                                            <label for="rent_amount">Lease Amount <small class="text-danger pl-2">required</small></label>
                                            <input type="text" class="form-control  {{ $errors->has('rent_amount') ? 'is-invalid' : '' }}" name="rent_amount" aria-describedby="rent_amount" placeholder="Enter amount of lease" value="{{ old('rent_amount') }}">
                                            @error('rent_amount')
                                            <span class='invalid-feedback'>{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="deposit_amount">Deposit Amount</label>
                                            <input type="text" class="form-control" name="deposit_amount" aria-describedby="deposit_amount" placeholder="Enter deposit amount" value="{{ old('deposit_amount') }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="amount_refundable">Refundable Amount</label>
                                            <input type="text" class="form-control" name="amount_refundable" aria-describedby="amount_refundable" placeholder="Enter amount refundable" value="{{ old('amount_refundable') }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="pet_deposit_amount">Pet Deposit Amount</label>
                                            <input type="text" class="form-control" name="pet_deposit_amount" aria-describedby="pet_deposit_amount" placeholder="Enter pet deposit amount" value="{{ old('pet_deposit_amount') }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="late_date">What day of the month is past due? </label>
                                            <input type="text" class="form-control" name="late_date" aria-describedby="late_date" placeholder="Enter late day of the month" value="{{ old('late_date') }}">
                                            <small>EX: Enter '10' if the 10th of the month is considered past due</small>
                                        </div>

                                        <div class="form-group">
                                            <label for="late_fee">Late Fee Amount</label>
                                            <input type="text" class="form-control" name="late_fee" aria-describedby="late_fee" placeholder="Enter the late fee amount" value="{{ old('late_fee') }}">
                                        </div>

                                        @endif

                                    </div>
                                </div>
                            </div>

                            @if( Auth::user()->product === 1 ||  Auth::user()->product === 2 || Auth::user()->product === 10 )
                            <div class="card">
                                <div class="card-header bg-purple" id="headingThree">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link text-white collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                            Additional Property Information
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                                    <div class="card-body">
                                   
                                        <div class="form-group">
                                            <label for="bed_amount">Number of Bedrooms</label>
                                            <input type="text" class="form-control" name="bed_amount" aria-describedby="bed_amount" placeholder="Enter number of bedrooms" value="{{ old('bed_amount') }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="bath_amount">Number of Bathrooms</label>
                                            <input type="text" class="form-control" name="bath_amount" aria-describedby="bath_amount" placeholder="Enter number of bathrooms" value="{{ old('bath_amount') }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="square_footage">Square Footage</label>
                                            <input type="text" class="form-control" name="square_footage" aria-describedby="square_footage" placeholder="Enter square footage" value="{{ old('square_footage') }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="description">Property Description</label>
                                            <textarea class="form-control" name="description" rows="5"> {{ old('description') }}</textarea>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>

                        <div class="p-0 mb-3"></div>

                        @csrf
                        
                        <button type="submit" class="btn btn-success shadow">Save Property</button>

                    </form>

                </div>
            </div>
        </div>
    </div>

    @include('layouts.footers.auth')
</div>
@endsection
