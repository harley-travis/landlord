@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Property</div>

                <div class="card-body">

                    <div class="mb-3 text-right">
                        <a href="{{ route('property.index') }}" class="btn btn-info text-white">Go Back</a>
                    </div>
                    
                    <form action="{{ route('property.update') }}" method="post">

                        <div class="form-group">
                            <label for="address_1">Address 1</label>
                            <input type="text" class="form-control" name="address_1" aria-describedby="address_1" value="{{ $property->address_1 }}">
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
                            <label for="city">City</label>
                            <input type="text" class="form-control" name="city" aria-describedby="city" value="{{ $property->city }}">
                        </div>

                        <div class="form-group">
                            <label for="state">State</label>
                            <input type="text" class="form-control" name="state" aria-describedby="state" value="{{ $property->state }}">
                        </div>

                        <div class="form-group">
                            <label for="zip">Zip</label>
                            <input type="text" class="form-control" name="zip" aria-describedby="zip" value="{{ $property->zip }}">
                        </div>

                        <div class="form-group">
                            <label for="country">Country</label>
                            <input type="text" class="form-control" name="country" aria-describedby="country" value="{{ $property->country }}">
                        </div>

                        <div class="form-group">
                            <label for="lease_length">Lease Length</label>
                            <input type="text" class="form-control" name="lease_length" aria-describedby="lease_length" value="{{ $property->lease_length }}">
                        </div>

                        <div class="form-group">
                            <label for="rent_amount">Lease Amount</label>
                            <input type="text" class="form-control" name="rent_amount" aria-describedby="rent_amount" value="{{ $property->rent_amount }}">
                        </div>

                        <div class="form-group">
                            <label for="deposit_amount">Deposit Amount</label>
                            <input type="text" class="form-control" name="deposit_amount" aria-describedby="deposit_amount" value="{{ $property->deposit_amount }}">
                        </div>

                        <div class="form-group">
                            <label for="amount_refundable">Refundable Amount</label>
                            <input type="text" class="form-control" name="amount_refundable" aria-describedby="amount_refundable" value="{{ $property->amount_refundable }}">
                        </div>

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
                                <input class="form-check-input" type="radio" name="occupied" id="occupied_yes" value="0" >
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
                                <input class="form-check-input" type="radio" name="pet" id="pet_yes" value="0" >
                                <label class="form-check-label" for="pet_no">No</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="pet" id="pet_no" value="{{$property->pet}}" checked>
                                <label class="form-check-label" for="pet_yes">Yes</label>
                            </div>
                        </div>

                        @endif

                        <div class="form-group">
                            <label for="pet_deposit_amount">Pet Deposit Amount</label>
                            <input type="text" class="form-control" name="pet_deposit_amount" aria-describedby="pet_deposit_amount" value="{{ $property->pet_deposit_amount }}">
                        </div>


                        <div class="p-0 mb-3">
                        
                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#moreOptions" aria-expanded="false" aria-controls="moreOptions">
                            Additional Property Information
                        </button>

                        <div class="collapse" id="moreOptions">
                            <div class="card card-body">

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




                        @csrf
                        <input type="hidden" name="id" value="{{ $property_id }}">

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
