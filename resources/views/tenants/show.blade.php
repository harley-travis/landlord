@extends('layouts.app')

@section('content')
<div class="container">
    @if(Session::has('info'))
        <div class="alert alert-success" role="alert">
            <h4 class="alert-heading">Success!</h4>
            <p>{{ Session::get('info') }}</p>
        </div>
    @endif
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header">{{ $tenant->name }}</div>

                <div class="card-body">

                    <div class="mb-3 text-right">
                        <a href="{{ route('tenants.index') }}" class="btn btn-info text-white shadow">Go Back</a>
                    </div>

                    <table class="table">
                        <tr>
                            <td>Phone Number</td>
                            <td>{{ $tenant->phone }}</td>
                        </tr>
                        <tr>
                            <td>Work Phone</td>
                            <td>{{ $tenant->work_phone }}</td>
                        </tr>
                        <tr>
                            <td>Email Address</td>
                            <td>{{ $tenant->email }}</td>
                        </tr>
                        <tr>
                            <td>Tenant Partner</td>
                            <td>{{ $tenant->secondary_name }}</td>
                        </tr>
                        <tr>
                            <td>Partner Phone</td>
                            <td>{{ $tenant->secondary_phone }}</td>
                        </tr>
                        <tr>
                            <td>Partner Work Phone</td>
                            <td>{{ $tenant->secondary_work_phone }}</td>
                        </tr>
                        <tr>
                            <td>Partner Email</td>
                            <td>{{ $tenant->secondary_email }}</td>
                        </tr>
                        <tr>
                            <td>Number of Occupants</td>
                            <td>{{ $tenant->number_occupants }}</td>
                        </tr>
                        <tr>
                            <td>Resident</td>
                            <td>
                                @if($tenant->active === 0)
                                    Not a current resident
                                @else
                                    Current Resident
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>Property</td>
                            <td>{{ $property->address_1 }} {{ $property->address_2 }} {{ $property->address_3 }}</td>
                        </tr>
                    </table>

                    @if($tenant->active === 1)
                    <a href="{{ route('tenants.archive', ['id' => $tenant->id ]) }}" class="btn btn-danger">Archive Tenanat</a>
                    <a href="{{ route('tenants.edit', ['id' => $tenant->id ]) }}" class="btn btn-primary shadow">Edit Tenanat</a>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
