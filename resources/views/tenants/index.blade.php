@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Tenants Management</div>

                <div class="card-body">

                @if(Session::has('info'))
                    <div class="alert alert-success" role="alert">
                        <h4 class="alert-heading">Success!</h4>
                        <p>{{ Session::get('info') }}</p>
                    </div>
                @endif

                    <div class="mb-3 text-right">
                        <a href="{{ route('tenants.archived') }}" class="btn btn-link">View Archived Tenants</a>
                        <a href="{{ route('tenants.create') }}" class="btn btn-success">Add Tenant</a>
                    </div>

                    <table class="table table-hover">
                        <tr>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Number of Occupants</th>
                            <th>Property</th>
                            <td>Edit</th>
                        </tr>

                     
                            @foreach($tenants as $tenant)
                       
                            <tr>
                                <td><a href="{{ route('tenants.show', ['id' => $tenant->id ]) }}">{{ $tenant->name }}</a></td>
                                <td>{{ $tenant->phone }}</td>
                                <td>{{ $tenant->email }}</td>
                                <td>{{ $tenant->number_occupants }}</td>
                                <td>{{ $tenant->property_id }}</td>
                                <td><a href="{{ route('tenants.edit', ['id' => $tenant->id ]) }}" class="btn btn-info text-white">Edit Tenant</a></td>
                            </tr>
                         
                            @endforeach
                   
                      
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
