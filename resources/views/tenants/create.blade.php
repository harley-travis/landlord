@extends('layouts.app', ['page_title' => "Add Tenant"])

@section('content')
@include('layouts.headers.cards')

<div class="container-fluid mt--9">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Add New Tenant</h3>
                        </div>
                        <div class="col-4 text-right">
                            
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    
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
                                <option value="">- Select Property -</option>
                                @foreach($properties as $property)
                                <option value="{{ $property->id }}">{{ $property->address_1 }} {{ $property->address_2 }}</option>
                                @endforeach
                            </select>
                            @error('property_id')
                            <span class='invalid-feedback'>{{ $message }}</span>
                            @enderror
                        </div>                      

                        @csrf

                        <button type="submit" class="btn btn-success shadow">Save Tenant</button>

                    </form>

                </div>
            </div>
        </div>
    </div>

    @include('layouts.footers.auth')
</div>
@endsection
