@extends('layouts.app', ['page_title' => "Edit Tenant"])

@section('content')
@include('layouts.headers.cards')

<div class="container-fluid mt--9">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Edit Tenant</h3>
                        </div>
                        <div class="col-4 text-right">
                            
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    
                    <form action="{{ route('tenants.update') }}" method="post">

                        <div class="form-group">
                            <label for="name">Name <small class="text-danger pl-2">required</small></label>
                            <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" aria-describedby="name" value="{{ $tenant->name }}">
                            @error('name')
                            <span class='invalid-feedback'>{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Email <small class="text-danger pl-2">required</small></label>
                            <input type="email" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="email" aria-describedby="email" value="{{ $tenant->email }}">
                            @error('name')
                            <span class='invalid-feedback'>{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="phone">Phone <small class="text-danger pl-2">required</small></label>
                            <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="phone" aria-describedby="phone" value="{{ $tenant->phone }}">
                            @error('name')
                            <span class='invalid-feedback'>{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="work_phone">Work Phone</label>
                            <input type="text" class="form-control" name="work_phone" aria-describedby="work_phone" value="{{ $tenant->work_phone }}">
                        </div>

                        <div class="form-group">
                            <label for="secondary_name">Secondary Name</label>
                            <input type="text" class="form-control" name="secondary_name" aria-describedby="secondary_name" value="{{ $tenant->secondary_name }}">
                        </div>

                        <div class="form-group">
                            <label for="secondary_phone">Secondary Phone</label>
                            <input type="text" class="form-control" name="secondary_phone" aria-describedby="secondary_phone" value="{{ $tenant->secondary_phone }}">
                        </div>

                        <div class="form-group">
                            <label for="secondary_work_phone">Secondary Work Phone</label>
                            <input type="text" class="form-control" name="secondary_work_phone" aria-describedby="secondary_work_phone" value="{{ $tenant->secondary_work_phone }}">
                        </div>

                        <div class="form-group">
                            <label for="secondary_email">Secondary Email</label>
                            <input type="email" class="form-control" name="secondary_email" aria-describedby="secondary_email" value="{{ $tenant->secondary_email }}">
                        </div>

                        <div class="form-group">
                            <label for="number_occupants">Number of Occupants</label>
                            <input type="text" class="form-control" name="number_occupants" aria-describedby="number_occupants" value="{{ $tenant->number_occupants }}">
                        </div>

                        <div class="form-group">
                            <label for="property">Property</label>
                            <select id="property_id" name="property_id" class="form-control">
                            <option value="">No Property</option>
                            @foreach($properties as $property)
                            <option {{ $tenant->property_id == $property->id ? 'selected':'' }}  value='{{$property->id}}'> 
                                {{ $property->address_1 }} {{ $property->address_2 }}
                            </option>
                            @endforeach
                            </select>
                        </div>                       

                        @csrf

                        <input type="hidden" name="id" value="{{ $tenant->id }}">
                        <input type="hidden" name="user_id" value="{{ $tenant->user_id }}">
                        <input type="hidden" name="property_id" value="{{ $tenant->property_id }}">
              
                        @if($tenant->active === 1)
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal">Archive Tenant</button>
                        <button type="submit" class="btn btn-success shadow">Save Tenant</button>
                        @endif

                    </form>

                    <!-- Modal -->
                    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-info" id="deleteModalLabel">Archive Tenant</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to archive this property? This does not delete the tenant or the tenants information. This will be stored under the archived tenant section.
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <a class="btn btn-danger shadow" href="{{ route('tenants.archive', ['id' => $tenant->user_id ]) }}">Yes, Archive Tenant</a>
                            </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    @include('layouts.footers.auth')
</div>
@endsection
