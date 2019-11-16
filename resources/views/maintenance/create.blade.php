@extends('layouts.app', ['page_title' => "Create Maintenance Ticket"])

@section('content')
@include('layouts.headers.cards')

<div class="container-fluid mt--9">
    <div class="row">
        <div class="col">
            <div class="card bg-secondary shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Create Maintenance Ticket</h3>
                        </div>
                        <div class="col-4 text-right">
                        </div>
                    </div>
                </div>
                <div class="card-body">                    
                    <form action="{{ route('maintenance.add') }}" method="post">

                        <div class="form-group">
                            <label for="subject">Subject <small class="text-danger pl-2">required</small></label>
                            <input type="text" class="form-control {{ $errors->has('subject') ? 'is-invalid' : '' }}" name="subject" aria-describedby="subject" placeholder="Enter subject line" value="{{ old('subject') }}">
                            @error('subject')
                            <span class='invalid-feedback'>{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="type">Type of Issue</label>
                            <select name="type" class="form-control">
                                <option>- Select Type</option>
                                <option value="Alarm System">Alarm System</option>
                                <option value="Appliances">Appliances</option>
                                <option value="Balcony/Patio">Balcony/Patio</option>
                                <option value="Blinds">Blinds</option>
                                <option value="Cabinets">Cabinets</option>
                                <option value="Carbon Monoxide Detectors">Carbon Monoxide Detectors</option>
								<option value="Counter Top">Counter Top</option>
								<option value="Doors">Doors</option>
								<option value="Electrical">Electrical</option>
								<option value="Fire Alarm/Fire Sprinklers/Extinguishers">Fire Alarm/Fire Sprinklers/Extinguishers</option>
								<option value="Flood">Flood</option>
								<option value="Floors/Carpet">Floors/Carpet</option>
								<option value="Garage/Carport">Garage/Carport</option>
								<option value="Garbage Disposal">Garbage Disposal</option>
								<option value="Gas Leak">Gas Leak</option>
								<option value="Glass/Windows/Screens">Glass/Windows/Screens</option>
								<option value="Hardware">Hardware</option>
								<option value="Heating/Ventilation/AC">Heating/Ventilation/AC</option>
								<option value="Landscaping/Grounds">Landscaping/Grounds</option>
								<option value="Lighting">Lighting</option>
								<option value="Locks/Keys">Locks/Keys</option>
								<option value="Paint">Paint</option>
								<option value="Pest Control">Pest Control</option>
								<option value="Plumbing">Plumbing</option>
								<option value="Roof">Roof</option>
								<option value="Smoke Detectors">Smoke Detectors</option>
								<option value="Storage Unit">Storage Unit</option>
								<option value="Toilet Problems">Toilet Problems</option>
								<option value="Tub/Shower">Tub/Shower</option>
								<option value="Other">Other</option>
                            </select>
                        </div>
                   
                        <div class="form-group">
							<label for="description">Description <small class="text-danger pl-2">required</small></label>
							<textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" rows="8">{{ old('description') }}</textarea>
                            @error('description')
                            <span class='invalid-feedback'>{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                        <label for="permission">Permission To Enter If You Are Not Home</label><br>
                            <div class="custom-control custom-radio mb-3">
                                <input name="permission" class="custom-control-input" id="permissionNo" type="radio" value="0" >
                                <label class="custom-control-label" for="permissionNo">No</label>
                            </div>
                            <div class="custom-control custom-radio mb-3">
                                <input name="permission" class="custom-control-input" id="permissionYes" checked="" type="radio" value="1">
                                <label class="custom-control-label" for="permissionYes">Yes</label>
                            </div>
                        </div>

                        <!-- <div class="form-group">
                            <label for="permission">Permission To Enter If You Are Not Home</label><br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="permission" value="0" checked>
                                <label class="form-check-label" for="permission">No</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="permission" value="1">
                                <label class="form-check-label" for="permission">Yes</label>
                            </div>
                        </div> -->

                        <div class="form-group">
                            <label for="emergency">Emergency</label><br/>
                            <div class="custom-control custom-radio mb-3">
                                <input name="emergency" class="custom-control-input" id="emergencyNo" type="radio" value="0" >
                                <label class="custom-control-label" for="emergencyNo">No</label>
                            </div>
                            <div class="custom-control custom-radio mb-3">
                                <input name="emergency" class="custom-control-input" id="emergencyYes" checked="" type="radio" value="1">
                                <label class="custom-control-label" for="emergencyYes">Yes</label>
                            </div>
                        </div>

						<!-- <div class="form-group">
                            <label for="permission">Emergency</label><br/>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="emergency" value="0" checked>
                                <label class="form-check-label" for="emergency">No</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="emergency" value="1">
                                <label class="form-check-label" for="emergency">Yes</label>
                            </div>
                        </div> -->

                   
                        <!-- to do add file attachments -->
                        <!-- <div class="form-group">
							<label for="attachment">Attach Files</label>
							<input type="file" class="form-control-file" id="attachment" name="attachment">
						</div> -->
                        
                        <input type="hidden" name="user_id" value="" />


                        @csrf

                        <button type="submit" class="btn btn-success shadow">Send Request</button>

                    </form>

                </div>
            </div>
        </div>
    </div>

    @include('layouts.footers.auth')
</div>
@endsection
