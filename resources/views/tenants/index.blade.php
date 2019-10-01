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

                        @foreach($data as $tenant)
                            @foreach($tenant->tenants as $t)
                       
                            <tr>
                                <td><a href="{{ route('tenants.show', ['id' => $t->id ]) }}">{{ $t->user->name }}</a></td>
                                <td>{{ $t->phone }}</td>
                                <td>{{ $t->email }}</td>
                                <td>{{ $t->number_occupants }}</td>
                                <td>{{ $t->property_id }}</td>
                                <td><a href="{{ route('tenants.edit', ['id' => $t->id ]) }}" class="btn btn-info text-white">Edit Tenant</a></td>
                            </tr>
                         
                            @endforeach
                        @endforeach
                      
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
