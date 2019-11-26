@extends('layouts.app', ['page_title' => "Tenants Management"])

@section('content')
@include('layouts.headers.cards')

<div class="container-fluid mt--9">

    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Newly Created Tenants</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('tenants.create') }}" class="btn btn-success shadow"><i class="fas fa-plus-circle pr-2"></i> Add Tenant</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">

                @if(Session::has('info'))
                    <div class="alert alert-success" role="alert">
                        <h4 class="alert-heading">Success!</h4>
                        <p>{{ Session::get('info') }}</p>
                    </div>
                @endif

                @if ( $tenants->isEmpty() || $unassigned->count() === 0 )

                <p class="text-center">You have no tenants. Let's add one now!</p>

                <div class="pb-5 text-center">
                    <a href="{{ route('tenants.create') }}" class="btn btn-primary shadow"><i class="fas fa-plus-circle pr-2"></i> Add Tenant</a>
                </div> 
            
                @else           

                <div class="table-responsive">

                        <table class="table align-items-center table-flush table-hover">
                            <thead class="thead-light">
                                <tr>   
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tenants as $tenant)
                                @if( $tenant->assigned === 0 )
                                <tr>
                                    <td><a href="{{ route('tenants.show', ['id' => $tenant->user_id]) }}">{{ $tenant->name }}</a></td>
                                    <td>{{ $tenant->phone }}</td>
                                    <td>{{ $tenant->email }}</td>
                                    <td class="text-right">
                                        <div class="dropdown">
                                            <a class="btn btn-link btn-icon-only text-purple" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                <a class="dropdown-item" data-toggle="modal" data-target="#assignModal-{{ $tenant->user_id }}">Assign to Property</a>
                                                <a class="dropdown-item" href="{{ route('tenants.edit', ['id' => $tenant->user_id ]) }}" class="btn btn-info text-white">Edit Tenant</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>  

                                <!-- Modal -->
                                <div class="modal fade" id="assignModal-{{ $tenant->user_id }}" tabindex="-1" role="dialog" aria-labelledby="assignModalLabel-{{ $tenant->user_id }}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title text-primary" id="assignModalLabel-{{ $tenant->user_id }}">Assign {{ $tenant->name }} to a Property</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                            
                                                <form action="{{ route('tenants.assignProperty') }}" method="post">
                                                    @csrf

                                                    <div class="form-group">
                                                        <label for="property">Select Property</label>
                                                        <select id="property_id" name="property_id" class="form-control">
                                                            @foreach($properties as $property)
                                                            <option value="{{ $property->id }}">{{ $property->address_1 }} {{ $property->address_2 }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('property_id')
                                                        <span class='invalid-feedback'>{{ $message }}</span>
                                                        @enderror
                                                    </div> 
                                                    
                                                <input type="hidden" name="tenant_id" value="{{ $tenant->user_id }}">

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button class="btn btn-success shadow" type="submit">Assign Property to Tenant</button>

                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                

                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{ $tenants->links() }}

                @endif

                    
                    
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Tenants Assigned to Properties</h3>
                        </div>
                        <div class="col-4 text-right">

                        </div>
                        
                    </div>
                </div>

                <div class="card-body">

                @if ( $tenants->isEmpty() || $assigned->count() === 0 )

                <p>No tenants are assigned to properties. Once you assign a tenant to one of your properties, then they will appear here.</p>

                @else           

                <div class="table-responsive">

                        <table class="table align-items-center table-flush table-hover">
                            <thead class="thead-light">
                                <tr>   
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Property</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach( $assigned as $tenant )
                                @if( $tenant->assigned === 1 )
                                <tr>
                                    <td><a href="{{ route('tenants.show', ['id' => $tenant->user_id]) }}">{{ $tenant->name }}</a></td>
                                    <td>{{ $tenant->phone }}</td>
                                    <td>{{ $tenant->email }}</td>
                                    <td>{{ $tenant->address_1 }} {{ $tenant->address_2 }}</td>
                                    <td class="text-right">
                                        <div class="dropdown">
                                            <a class="btn btn-link btn-icon-only text-purple" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                <a class="dropdown-item" data-toggle="modal" data-target="#unassignModal-{{ $tenant->user_id }}">Unassign from Property</a>
                                                <a class="dropdown-item" href="{{ route('tenants.edit', ['id' => $tenant->user_id ]) }}" class="btn btn-info text-white">Edit Tenant</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>  


                                <!-- Modal -->
                                <div class="modal fade" id="unassignModal-{{ $tenant->user_id }}" tabindex="-1" role="dialog" aria-labelledby="unassignModalLabel-{{ $tenant->user_id }}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title text-primary" id="unassignModalLabel-{{ $tenant->user_id }}">Assign {{ $tenant->name }} to a Property</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">

                                                <p class="mb-5">Are you sure you want to unnassign {{ $tenant->address_1 }} {{ $tenant->address_2 }} from this {{ $tenant->name }}</p>
                                            
                                                <form action="{{ route('tenants.unassignProperty') }}" method="post">
                                                    @csrf

                                                    <input type="hidden" name="property_id" value="{{ $tenant->property_id }}">

                                                    <!-- <div class="form-group">
                                                        <label for="property">Select Property</label>
                                                        <select id="property_id" name="property_id" class="form-control">
                                                            @foreach($properties as $property)
                                                            <option value="{{ $property->id }}">{{ $property->address_1 }} {{ $property->address_2 }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('property_id')
                                                        <span class='invalid-feedback'>{{ $message }}</span>
                                                        @enderror
                                                    </div>  -->
                                                    
                                                <input type="hidden" name="tenant_id" value="{{ $tenant->user_id }}">

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button class="btn btn-danger shadow" type="submit">Unassign Property to Tenant</button>

                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{ $tenants->links() }}

                @endif

                    
                    
                </div>
            </div>
        </div>
    </div>

    @include('layouts.footers.auth')
</div>
@endsection
