@extends('layouts.app', ['page_title' => "Property Management"])

@section('content')
@include('layouts.headers.cards')

<div class="container-fluid mt--9">
    <div class="row">
        <div class="col">
            <div class="card bg-secondary shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Property Management</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('property.create') }}" class="btn btn-success shadow"><i class="fas fa-plus-circle pr-2"></i> Add Property</a>
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

                @if($properties->isEmpty())

                    @if($company->product == 3)
                        <p>Before you create a property, be sure to add a community before so you can assign the community to the property</p>
                        <div class="pb-5 text-left">
                            <a href="{{ route('community.create') }}" class="btn btn-primary shadow"><i class="fas fa-plus-circle pr-2"></i> Add Community</a>
                        </div>
                    @endif

                    <p>You don't have any properties added! Let's add one now!</p>

                    <div class="mb-3 text-left">
                        <a href="{{ route('property.create') }}" class="btn btn-success shadow"><i class="fas fa-plus-circle pr-2"></i> Add Property</a>
                    </div>

                    
                @else

                @if( Auth::user()->product === 1 || Auth::user()->product === 10 )

                    <div class="table-responsive">
                        <table class="table align-items-center table-flush table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>Address</th>
                                    <th>Occupied</th>
                                    <th>Rent Amount</th>
                                    <th>Lease Length</th>
                                    <th>Edit</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($properties as $property)
                                <tr>
                                    <td>{{ $property->address_1 }} {{ $property->address_2 }} {{ $property->address_3 }}</td>
                                    <td>
                                        @if($property->occupied == '1')
                                            Yes
                                        @elseif($property->occupied == '0')
                                            No
                                        @endif
                                    </td>
                                    <td>
                                        
                                        @if( $property->rent_amount === '' || $property->rent_amount === null || $property->rent_amount === 0 )
                                            No amount set
                                        @else
                                    
                                        ${{ $property->rent_amount }}
                                    
                                        @endif
                                    </td>
                                    <td>
                                    
                                        @if( $property->lease_length === '' || $property->lease_length === null || $property->lease_length === 0 )
                                            No lease date set
                                        @else

                                        {{ $property->lease_length }} months
                                    
                                        @endif
                                    
                                    </td>
                                    <td><a href="{{ route('property.edit', ['id' => $property->id ]) }}" class="btn btn-info">Edit Property</a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{ $properties->links() }}

                @endif

                </div><!-- card-body -->
                @endif
            </div>
        </div>
    </div>

    @include('layouts.footers.auth')
</div>
@endsection
