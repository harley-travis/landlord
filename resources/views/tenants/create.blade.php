@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Add New Tenant</div>

                <div class="card-body">

                    <div class="mb-3 text-right">
                        <a href="{{ route('tenants.index') }}" class="btn btn-info text-white">Go Back</a>
                    </div>
                    
                    <p>When you create a tenant, they will get an email with their login credentials</p>

                    <form action="{{ route('tenants.add') }}" method="post">

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" name="name" aria-describedby="name" placeholder="Enter name">
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email" aria-describedby="email" placeholder="Enter email">
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" name="password" aria-describedby="password" placeholder="Enter password">
                        </div>

                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control" name="phone" aria-describedby="phone" placeholder="Enter phone">
                        </div>

                        <div class="form-group">
                            <label for="work_phone">Work Phone</label>
                            <input type="text" class="form-control" name="work_phone" aria-describedby="work_phone" placeholder="Enter work phone">
                        </div>

                        <div class="form-group">
                            <label for="secondary_name">Secondary Name</label>
                            <input type="text" class="form-control" name="secondary_name" aria-describedby="secondary_name" placeholder="Enter secondary name">
                        </div>

                        <div class="form-group">
                            <label for="secondary_phone">Secondary Phone</label>
                            <input type="text" class="form-control" name="secondary_phone" aria-describedby="secondary_phone" placeholder="Enter secondary phone">
                        </div>

                        <div class="form-group">
                            <label for="secondary_work_phone">Secondary Work Phone</label>
                            <input type="text" class="form-control" name="secondary_work_phone" aria-describedby="secondary_work_phone" placeholder="Enter secondary work phone">
                        </div>

                        <div class="form-group">
                            <label for="secondary_email">Secondary Email</label>
                            <input type="email" class="form-control" name="secondary_email" aria-describedby="secondary_email" placeholder="Enter secondary email">
                        </div>

                        <div class="form-group">
                            <label for="number_occupants">Number of Occupants</label>
                            <input type="text" class="form-control" name="number_occupants" aria-describedby="number_occupants" placeholder="Enter number of occupants">
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
