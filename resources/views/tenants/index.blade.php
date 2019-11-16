@extends('layouts.app', ['page_title' => "Tenants Management"])

@section('content')
@include('layouts.headers.cards')

<div class="container-fluid mt--9">
    <div class="row">
        <div class="col">
            <div class="card bg-secondary shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Tenants Management</h3>
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

                    <div class="table-responsive">
                        <table class="table align-items-center table-flush table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Property</th>
                                    <td>Edit</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tenants as $tenant)
                                <tr>
                                    <td><a href="{{ route('tenants.show', ['id' => $tenant->id ]) }}">{{ $tenant->name }}</a></td>
                                    <td>{{ $tenant->phone }}</td>
                                    <td>{{ $tenant->email }}</td>
                                    <td>{{ $tenant->address_1 }}</td>
                                    <td><a href="{{ route('tenants.edit', ['id' => $tenant->id ]) }}" class="btn btn-info text-white">Edit Tenant</a></td>
                                </tr>  
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{ $tenants->links() }}
                    
                </div>
            </div>
        </div>
    </div>

    @include('layouts.footers.auth')
</div>
@endsection
