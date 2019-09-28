@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Add Maintenance Request</div>

                <div class="card-body">

                    <div class="mb-3 text-right">
                        <a href="{{ route('maintenance.index') }}" class="btn btn-info text-white">Go Back</a>
                    </div>
                    
                    <form action="{{ route('maintenance.add') }}" method="post">

                        <div class="form-group">
                            <label for="subject">Subject</label>
                            <input type="text" class="form-control" name="subject" aria-describedby="subject" placeholder="Enter subject line">
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
							<label for="description">Description</label>
							<textarea class="form-control" name="description" rows="8"></textarea>
						</div>

                        <div class="form-group">
                            <label for="permission">Permission To Enter If You Are Not Home</label><br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="permission" value="0" checked>
                                <label class="form-check-label" for="permission">No</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="permission" value="1">
                                <label class="form-check-label" for="permission">Yes</label>
                            </div>
                        </div>

						<div class="form-group">
                            <label for="permission">Emergency</label><br/>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="emergency" value="0" checked>
                                <label class="form-check-label" for="emergency">No</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="emergency" value="1">
                                <label class="form-check-label" for="emergency">Yes</label>
                            </div>
                        </div>
                   
                        <!-- to do add file attachments -->
                        <!-- <div class="form-group">
							<label for="attachment">Attach Files</label>
							<input type="file" class="form-control-file" id="attachment" name="attachment">
						</div> -->
                        
                        <input type="hidden" name="user_id" value="" />


                        @csrf

                        <button type="submit" class="btn btn-success">Send Request</button>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
