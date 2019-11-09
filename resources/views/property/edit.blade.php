@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Edit Property</div>

                <div class="card-body">

                    <div class="mb-3 text-right">
                        <a href="{{ route('property.index') }}" class="btn btn-info text-white">Go Back</a>
                    </div>
                    
                    <form action="{{ route('property.update') }}" method="post">

                        <div class="accordion" id="accordionExample">
                            <div class="card">
                                <div class="card-header" id="headingOne">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            Property Details
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                                    <div class="card-body">

                                        <div class="form-group">
                                            <label for="address_1">Address 1 <small class="text-danger pl-2">required</small></label>
                                            <input type="text" class="form-control {{ $errors->has('address_1') ? 'is-invalid' : '' }}" name="address_1" aria-describedby="address_1" value="{{ $property->address_1 }}">
                                            @error('address_1')
                                            <span class='invalid-feedback'>{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="address_2">Address 2</label>
                                            <input type="text" class="form-control" name="address_2" aria-describedby="address_2" value="{{ $property->address_2 }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="address_3">Address 3</label>
                                            <input type="text" class="form-control" name="address_3" aria-describedby="address_3" value="{{ $property->address_3 }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="city">City <small class="text-danger pl-2">required</small></label>
                                            <input type="text" class="form-control {{ $errors->has('address_1') ? 'is-invalid' : '' }}" name="city" aria-describedby="city" value="{{ $property->city }}">
                                            @error('city')
                                            <span class='invalid-feedback'>{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="state">State <small class="text-danger pl-2">required</small></label>
                                            <input type="text" class="form-control {{ $errors->has('address_1') ? 'is-invalid' : '' }}" name="state" aria-describedby="state" value="{{ $property->state }}">
                                            @error('state')
                                            <span class='invalid-feedback'>{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="zip">Zip <small class="text-danger pl-2">required</small></label>
                                            <input type="text" class="form-control {{ $errors->has('address_1') ? 'is-invalid' : '' }}" name="zip" aria-describedby="zip" value="{{ $property->zip }}">
                                            @error('zip')
                                            <span class='invalid-feedback'>{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="country">Country <small class="text-danger pl-2">required</small></label>
                                            <input type="text" class="form-control {{ $errors->has('address_1') ? 'is-invalid' : '' }}" name="country" aria-describedby="country" value="{{ $property->country }}">
                                            @error('country')
                                            <span class='invalid-feedback'>{{ $message }}</span>
                                            @enderror
                                        </div>

                                        @if( Auth::user()->product === 1 ||  Auth::user()->product === 2 || Auth::user()->product === 10 )

                                            @if($property->occupied === 0)

                                            <div class="form-group">
                                                <label for="occupied">Vacancy</label>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="occupied" id="occupied_yes" value="{{$property->occupied}}" checked>
                                                    <label class="form-check-label" for="occupied_yes">No</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="occupied" id="occupied_no" value="1">
                                                    <label class="form-check-label" for="occupied_no">Yes</label>
                                                </div>
                                            </div>

                                            @elseif($property->occupied === 1)

                                            <div class="form-group">
                                                <label for="vacany">Vacancy</label>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="occupied" id="occupied_yes" value="0">
                                                    <label class="form-check-label" for="occupied_yes">No</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="occupied" id="occupied_no" value="{{$property->occupied}}" checked>
                                                    <label class="form-check-label" for="occupied_no">Yes</label>
                                                </div>
                                            </div>

                                            @endif

                                            @if($property->pet === 0)

                                            <div class="form-group">
                                                <label for="pet">Pets Allowed</label>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="pet" id="pet_yes" value="{{$property->pet}}" checked>
                                                    <label class="form-check-label" for="pet_no">No</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="pet" id="pet_no" value="1">
                                                    <label class="form-check-label" for="pet_yes">Yes</label>
                                                </div>
                                            </div>

                                            @elseif($property->pet === 1)

                                            <div class="form-group">
                                                <label for="pet">Pets Allowed</label>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="pet" id="pet_yes" value="0">
                                                    <label class="form-check-label" for="pet_no">No</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="pet" id="pet_no" value="{{$property->pet}}" checked>
                                                    <label class="form-check-label" for="pet_yes">Yes</label>
                                                </div>
                                            </div>

                                            @endif

                                        @endif

                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingTwo">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            Rent Information
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                    <div class="card-body">
                                  
                                        <div class="form-group">
                                            <label for="lease_length">Lease Length</label>
                                            <input type="text" class="form-control" name="lease_length" aria-describedby="lease_length" value="{{ $rent->lease_length }}">
                                        </div>

                                        @if( Auth::user()->product === 1 ||  Auth::user()->product === 2 || Auth::user()->product === 10 )

                                        <div class="form-group">
                                            <label for="rent_amount">Lease Amount</label>
                                            <input type="text" class="form-control" name="rent_amount" aria-describedby="rent_amount" value="{{ $rent->rent_amount }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="deposit_amount">Deposit Amount</label>
                                            <input type="text" class="form-control" name="deposit_amount" aria-describedby="deposit_amount" value="{{ $rent->deposit_amount }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="amount_refundable">Refundable Amount</label>
                                            <input type="text" class="form-control" name="amount_refundable" aria-describedby="amount_refundable" value="{{ $rent->amount_refundable }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="pet_deposit_amount">Pet Deposit Amount</label>
                                            <input type="text" class="form-control" name="pet_deposit_amount" aria-describedby="pet_deposit_amount" value="{{ $rent->pet_deposit_amount }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="late_date">What day of the month is past due? </label>
                                            <input type="text" class="form-control" name="late_date" aria-describedby="late_date" value="{{ $rent->late_date }}">
                                            <small>EX: Enter '10' if the 10th of the month is considered past due</small>
                                        </div>

                                        <div class="form-group">
                                            <label for="late_fee">Late Fee Amount</label>
                                            <input type="text" class="form-control" name="late_fee" aria-describedby="late_fee" value="{{ $rent->late_fee }}">
                                        </div>

                                        @endif

                                        <!-- HOA USERS -->
                                        @if( Auth::user()->product === 3 || Auth::user()->product === 10 )

                                        <div class="form-group">
                                            <label for="account_number">HOA Account Number</label>
                                            <input type="text" class="form-control" name="account_number" aria-describedby="account_number" value="{{ $rent->account_number }}">
                                            <small id="emailHelp" class="form-text text-muted">Only needed if you already have account numbers assigned to tenants.</small>
                                        </div>

                                        <div class="form-group">
                                            <label for="hoa_amount">Monthly HOA Fees</label>
                                            <input type="text" class="form-control" name="hoa_amount" aria-describedby="hoa_amount" value="{{ $rent->hoa_amount }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="community_id">Community</label>
                                            <select id="community_id" name="community_id" class="form-control">
                                                <option value="">No Property</option>
                                                @foreach($communities as $community)
                                                <option {{ $property->community_id == $community->id ? 'selected':'' }} value='{{ $community->id }}'>
                                                    {{ $community->hoa_community }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        @endif

                                    </div>
                                </div>
                            </div>

                            @if( Auth::user()->product === 1 ||  Auth::user()->product === 2 || Auth::user()->product === 10 )
                            <div class="card">
                                <div class="card-header" id="headingThree">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                            Additional Property Information
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                                    <div class="card-body">
                                   
                                        <div class="form-group">
                                            <label for="bed_amount">Number of Bedrooms</label>
                                            <input type="text" class="form-control" name="bed_amount" aria-describedby="bed_amount" value="{{ $property->bed_amount }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="bath_amount">Number of Bathrooms</label>
                                            <input type="text" class="form-control" name="bath_amount" aria-describedby="bath_amount" value="{{ $property->bath_amount }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="square_footage">Square Footage</label>
                                            <input type="text" class="form-control" name="square_footage" aria-describedby="square_footage" value="{{ $property->square_footage }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="description">Property Description</label>
                                            <textarea class="form-control" name="description" rows="5">{{ $property->description }}</textarea>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>

                        <div class="p-0 mb-3"></div>

                        @csrf
                        
                        <input type="hidden" name="property_id" value="{{ $property_id }}">
                        <input type="hidden" name="rent_id" value="{{ $rent->id }}">

                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal">Delete Property</button>
                        <button type="submit" class="btn btn-success">Save</button>

                    </form>

                    <!-- Modal -->
                    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title text-danger" id="deleteModalLabel">DANGER!</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to delete this property? This can not be undone.
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <a class="btn btn-danger" href="{{ route('property.delete', ['id' => $property->id ]) }}">Yes, Delete Property</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
