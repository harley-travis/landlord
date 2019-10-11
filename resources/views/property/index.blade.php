@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Property Management</div>

                <div class="card-body">

                @if(Session::has('info'))
                    <div class="alert alert-success" role="alert">
                        <h4 class="alert-heading">Success!</h4>
                        <p>{{ Session::get('info') }}</p>
                    </div>
                @endif

                @if($properties->isEmpty())

                    @if($company->product == 2)
                        <p>Before you create a property, be sure to add a community before so you can assign the community to the property</p>
                        <div class="pb-5 text-left">
                            <a href="{{ route('community.create') }}" class="btn btn-primary">Add Community</a>
                        </div>
                    @endif

                    <p>You don't have any properties added! Let's add one now!</p>

                    <div class="mb-3 text-left">
                        <a href="{{ route('property.create') }}" class="btn btn-success">Add Property</a>
                    </div>

                    
                @else

                    <div class="mb-3 text-right">
                        <a href="{{ route('property.create') }}" class="btn btn-success">Add Property</a>
                    </div>

                    <table class="table table-hover">
                        <tr>
                            <th>Address</th>
                            <th>Occupied</th>
                            <th>Rent Amount</th>
                            <th>Lease Length</th>
                            <th>Tenant</th>
                            <td>Edit</th>
                        </tr>
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
                            <td>${{ $property->rent_amount }}</td>
                            <td>{{ $property->lease_length }} months</td>
                            <td>TO DO</td>
                            <td><a href="{{ route('property.edit', ['id' => $property->id ]) }}" class="btn btn-info text-white">Edit Property</a></td>
                        </tr>
                        @endforeach
                    </table>
                    {{ $properties->links() }}

                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
