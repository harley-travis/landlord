@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Add New Tenant</div>

                <div class="card-body">

                    <div class="mb-3 text-right">
                        <a href="{{ route('tenants.index') }}" class="btn btn-info text-white">Go Back</a>
                    </div>
                    
                    <p>When you create a tenant, they will get an email with their login credentials</p>

                    <form action="{{ route('tenants.add') }}" method="post">

                        <div class="form-group">
                            <label for="name">Name <small class="text-danger pl-2">required</small></label>
                            <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" aria-describedby="name" placeholder="Enter name" value="{{ old('name') }}">
                            @error('name')
                            <span class='invalid-feedback'>{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Email <small class="text-danger pl-2">required</small></label>
                            <input type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" name="email" aria-describedby="email" placeholder="Enter email" value="{{ old('email') }}">
                            @error('email')
                            <span class='invalid-feedback'>{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password">Password <small class="text-danger pl-2">required</small></label>
                            <input type="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" name="password" aria-describedby="password" placeholder="Enter password">
                            @error('password')
                            <span class='invalid-feedback'>{{ $message }} Password must be 8 characters long.</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="phone">Phone <small class="text-danger pl-2">required</small></label>
                            <input type="text" class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" name="phone" aria-describedby="phone" placeholder="Enter phone (555) 555-5555" value="{{ old('phone') }}">
                            @error('phone')
                            <span class='invalid-feedback'>{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="work_phone">Work Phone</label>
                            <input type="text" class="form-control" name="work_phone" aria-describedby="work_phone" placeholder="Enter work phone (555) 555-5555" value="{{ old('work_phone') }}">
                        </div>

                        <div class="form-group">
                            <label for="secondary_name">Secondary Name</label>
                            <input type="text" class="form-control" name="secondary_name" aria-describedby="secondary_name" placeholder="Enter secondary name" value="{{ old('secondary_name') }}">
                        </div>

                        <div class="form-group">
                            <label for="secondary_phone">Secondary Phone</label>
                            <input type="text" class="form-control" name="secondary_phone" aria-describedby="secondary_phone" placeholder="Enter secondary phone (555) 555-5555" value="{{ old('secondary_phone') }}">
                        </div>

                        <div class="form-group">
                            <label for="secondary_work_phone">Secondary Work Phone</label>
                            <input type="text" class="form-control" name="secondary_work_phone" aria-describedby="secondary_work_phone" placeholder="Enter secondary work phone (555) 555-5555" value="{{ old('secondary_work_phone') }}">
                        </div>

                        <div class="form-group">
                            <label for="secondary_email">Secondary Email</label>
                            <input type="email" class="form-control" name="secondary_email" aria-describedby="secondary_email" placeholder="Enter secondary email" value="{{ old('secondary_email') }}">
                        </div>

                        <div class="form-group">
                            <label for="number_occupants">Number of Occupants</label>
                            <input type="text" class="form-control" name="number_occupants" aria-describedby="number_occupants" placeholder="Enter number of occupants" value="{{ old('number_occupants') }}">
                        </div>

                        <div class="form-group">
                            <label for="property">Property</label>
                            <select id="property_id" name="property_id" class="form-control">
                                <option>Select Property</option>
                                <option value="">No Property</option>
                                @foreach($properties as $property)
                                <option value="{{ $property->id }}">{{ $property->address_1 }} {{ $property->address_2 }}</option>
                                @endforeach
                            </select>
                        </div>                      

                        @csrf

                        <button type="submit" class="btn btn-success">Save Tenant</button>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
