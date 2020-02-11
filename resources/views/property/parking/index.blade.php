@extends('layouts.app', ['page_title' => "Parking Management"])

@section('content')
@include('layouts.headers.cards')

<div class="container-fluid mt--9">

    <div class="row">
        <div class="col">
            @if(Session::has('info'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <h4 class="alert-heading">Success!</h4>
                    <p>{{ Session::get('info') }}</p>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Available Parking</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('property.parking.create') }}" class="btn btn-success shadow"><i class="fas fa-plus-circle pr-2"></i> Add Parking Space</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">

                    @if( $avaliable->isEmpty() || $avaliable->count() === 0)

                    <p class="text-center">You currently do not have any parking spaces. Let's go ahead and add one!</p> 

                    <div class="pb-5 text-center">
                        <a href="{{ route('property.parking.create') }}" class="btn btn-primary shadow"><i class="fas fa-plus-circle pr-2"></i> Add Parking Space</a>
                    </div>

                    @else

                    <div class="table-responsive">
                        <table class="table align-items-center table-flush table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>Parking Location</th>
                                    <th>Parking Type</th>
                                    <th>Monthly Fee</th>
                                    <th>Deposit Fee</th>
                                    <th class="text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            @foreach($avaliable as $a) 

                                <tr>
                                    <td>{{ $a->location }}</td>
                                    <td>
                                        @if($a->type === 0)
                                            Carport
                                        @else
                                            Garage
                                        @endif
                                    </td>
                                    <td>${{ $a->monthly_fee }}</td>
                                    <td>${{ $a->parking_deposit_amount }}</td>
                                    <td class="text-right">
                                        <div class="dropdown">
                                            <a class="btn btn-link btn-icon-only text-purple" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                <a class="dropdown-item" data-toggle="modal" data-target="#assignModal-{{ $a->id }}">Assign to Property</a>
                                                <a class="dropdown-item" data-toggle="modal" data-target="#deleteModal-{{ $a->id }}">Delete Parking Space</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Assign Modal -->
                                <div class="modal fade" id="assignModal-{{ $a->id }}" tabindex="-1" role="dialog" aria-labelledby="assignModalLabel-{{ $a->id }}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title text-primary" id="assignModalLabel-{{ $a->id }}">Assign Parking Space to a Property</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                            
                                                <form action="{{ route('property.parking.assignProperty') }}" method="post">
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
                                                    
                                                <input type="hidden" name="parking_id" value="{{ $a->id }}">

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button class="btn btn-success shadow" type="submit">Assign Parking Space To Property</button>

                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                 <!-- Delete Modal -->
                                 <div class="modal fade" id="deleteModal-{{ $a->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel-{{ $a->id }}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title text-danger" id="deleteModalLabel-{{ $a->id }}">Delete Parking Space</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Are you sure you want to delete this parking space? This action cannot be undone.</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <a class="btn btn-danger shadow" href="{{ route('property.parking.delete', ['id' => $a->id ]) }}">Delete Parking Space</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            @endforeach

                            </tbody>
                        </table>
                    </div>

                    @endif

                </div><!-- card-body -->
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Occupied Parking Units</h3>
                        </div>
                        <div class="col-4 text-right">
                            
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    @if( $occupied->isEmpty() || $occupied->count() === 0)
                        <p class="text-center">There are no assigned parking spaces. Go ahead and assign a parking space to a property.</p>
                    @else

                    <div class="table-responsive">
                        <table class="table align-items-center table-flush table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>Parking Location</th>
                                    <th>Parking Type</th>
                                    <th>Monthly Fee</th>
                                    <th>Deposit Fee</th>
                                    <th>Assigned To</th>
                                    <th class="text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            @foreach($occupied as $o) 

                                <tr>
                                    <td>{{ $o->location }}</td>
                                    <td>
                                        @if($o->type === 0)
                                            Carport
                                        @else
                                            Garage
                                        @endif
                                    </td>
                                    <td>${{ $o->monthly_fee }}</td>
                                    <td>${{ $o->parking_deposit_amount }}</td>
                                    <td>{{ $o->address_1 }} {{ $o->address_2 }}</td>
                                    <td class="text-right">
                                        <div class="dropdown">
                                            <a class="btn btn-link btn-icon-only text-purple" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                <a class="dropdown-item" data-toggle="modal" data-target="#unassignModal-{{ $o->id }}">Unassign from Property</a>
                                                <a class="dropdown-item" href="{{ route('property.parking.edit', ['id' => $o->id ]) }}">Edit Parking Space</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Modal -->
                                <div class="modal fade" id="unassignModal-{{ $o->id }}" tabindex="-1" role="dialog" aria-labelledby="unassignModalLabel-{{ $o->id }}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title text-primary" id="unassignModalLabel-{{ $o->id }}">Unassign Parking Space to a Property</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                            
                                                <form action="{{ route('property.parking.unassignProperty') }}" method="post">

                                                    <p class="mb-5">Are you sure you want to unassign this parking space from {{ $o->address_1 }} {{ $o->address_2 }}</p>

                                                    @csrf

                                                    <input type="hidden" name="property_id" value="{{ $o->property_id }}">
                                                    <input type="hidden" name="parking_id" value="{{ $o->id }}">

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button class="btn btn-danger shadow" type="submit">Unassign Parking Space To Property</button>

                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            @endforeach

                            </tbody>
                        </table>
                    </div>

                    @endif

                </div><!-- card-body -->
            </div>
        </div>
    </div>

    @include('layouts.footers.auth')
</div>
@endsection
