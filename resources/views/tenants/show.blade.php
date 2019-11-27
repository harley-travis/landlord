@extends('layouts.app', ['page_title' => 'Tenant Profile'])

@section('content')
@include('layouts.headers.cards')

<div class="container-fluid mt--9">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">{{ $tenant->name }}</h3>
                        </div>
                        <div class="col-4 text-right">
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
                            <td>
                                {{ $property->address_1 }} {{ $property->address_2 }} {{ $property->address_3 }}
                            </td>
                        </tr>
                    </table>

                    @if($tenant->active === 1)
                    <a href="{{ route('tenants.archive', ['id' => $tenant->user_id ]) }}" class="btn btn-danger">Archive Tenanat</a>
                    <a href="{{ route('tenants.edit', ['id' => $tenant->user_id ]) }}" class="btn btn-primary shadow">Edit Tenanat</a>
                    @endif

                </div>
            </div>
        </div>
    </div>

    @include('layouts.footers.auth')
</div>
@endsection
