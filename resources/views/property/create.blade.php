@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Add New Property</div>

                <div class="card-body">

                    <div class="mb-3 text-right">
                        <a href="{{ route('property.index') }}" class="btn btn-info text-white">Go Back</a>
                    </div>
                    
                    <form action="{{ route('property.add') }}" method="post">

                        <div class="form-group">
                            <label for="address_1">Address 1</label>
                            <input type="text" class="form-control" name="address_1" aria-describedby="address_1" placeholder="Enter address 1">
                        </div>

                        <div class="form-group">
                            <label for="address_2">Address 2</label>
                            <input type="text" class="form-control" name="address_2" aria-describedby="address_2" placeholder="Enter address 2">
                        </div>

                        <div class="form-group">
                            <label for="address_3">Address 3</label>
                            <input type="text" class="form-control" name="address_3" aria-describedby="address_3" placeholder="Enter address 3">
                        </div>

                        <div class="form-group">
                            <label for="city">City</label>
                            <input type="text" class="form-control" name="city" aria-describedby="city" placeholder="Enter city">
                        </div>

                        <div class="form-group">
                            <label for="state">State</label>
                            <input type="text" class="form-control" name="state" aria-describedby="state" placeholder="Enter state">
                        </div>

                        <div class="form-group">
                            <label for="zip">Zip</label>
                            <input type="text" class="form-control" name="zip" aria-describedby="zip" placeholder="Enter zip">
                        </div>

                        <div class="form-group">
                            <label for="country">Country</label>
                            <input type="text" class="form-control" name="country" aria-describedby="country" placeholder="Enter country">
                        </div>

                        <div class="form-group">
                            <label for="lease_length">Lease Length</label>
                            <input type="text" class="form-control" name="lease_length" aria-describedby="lease_length" placeholder="Enter length of lease">
                        </div>

                        <div class="form-group">
                            <label for="rent_amount">Lease Amount</label>
                            <input type="text" class="form-control" name="rent_amount" aria-describedby="rent_amount" placeholder="Enter amount of lease">
                        </div>

                        <div class="form-group">
                            <label for="deposit_amount">Deposit Amount</label>
                            <input type="text" class="form-control" name="deposit_amount" aria-describedby="deposit_amount" placeholder="Enter deposit amount">
                        </div>

                        <div class="form-group">
                            <label for="amount_refundable">Refundable Amount</label>
                            <input type="text" class="form-control" name="amount_refundable" aria-describedby="amount_refundable" placeholder="Enter amount refundable">
                        </div>

                        <div class="form-group">
                            <label for="occupied">Vacancy</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="occupied" id="occupied_yes" value="0" checked>
                                <label class="form-check-label" for="occupied_yes">No</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="occupied" id="occupied_no" value="1">
                                <label class="form-check-label" for="occupied_no">Yes</label>
                            </div>
                        </div> 

                        <div class="form-group">
                            <label for="pet">Pets Allowed</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="pet" id="pet_yes" value="0" checked>
                                <label class="form-check-label" for="pet_no">No</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="pet" id="pet_no" value="1">
                                <label class="form-check-label" for="pet_yes">Yes</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="pet_deposit_amount">Pet Deposit Amount</label>
                            <input type="text" class="form-control" name="pet_deposit_amount" aria-describedby="pet_deposit_amount" placeholder="Enter pet deposit amount">
                        </div>

                        <div class="p-0 mb-3">
                        
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#moreOptions" aria-expanded="false" aria-controls="moreOptions">
                                Additional Property Information
                            </button>

                            <div class="collapse" id="moreOptions">
                                <div class="card card-body">

                                    <div class="form-group">
                                        <label for="bed_amount">Number of Bedrooms</label>
                                        <input type="text" class="form-control" name="bed_amount" aria-describedby="bed_amount" placeholder="Enter number of bedrooms">
                                    </div>

                                    <div class="form-group">
                                        <label for="bath_amount">Number of Bathrooms</label>
                                        <input type="text" class="form-control" name="bath_amount" aria-describedby="bath_amount" placeholder="Enter number of bathrooms">
                                    </div>

                                    <div class="form-group">
                                        <label for="square_footage">Square Footage</label>
                                        <input type="text" class="form-control" name="square_footage" aria-describedby="square_footage" placeholder="Enter deposit amount">
                                    </div>

                                    <div class="form-group">
                                        <label for="description">Property Description</label>
                                        <textarea class="form-control" name="description" rows="5"></textarea>
                                    </div>

                                </div>
                            </div>

                        </div>


                        @csrf

                        <button type="submit" class="btn btn-success">Save Property</button>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
