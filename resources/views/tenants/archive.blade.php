@extends('layouts.app', ['page_title' => "Tenants Management"])

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
                            <h3 class="mb-0">Archived Tenants</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('tenants.create') }}" class="btn btn-success shadow"><i class="fas fa-plus-circle pr-2"></i> Add Tenant</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">

                    @if($tenants->isEmpty())
                        <p class="text-center">You have no archived tenants</p>
                    @else

                    <table class="table table-hover">
                        <tr>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                        </tr>
                        @foreach($tenants as $tenant)
                        <tr>
                            <td><a href="{{ route('tenants.show', ['id' => $tenant->user_id ]) }}">{{ $tenant->name }}</a></td>
                            <td>{{ $tenant->phone }}</td>
                            <td>{{ $tenant->email }}</td>
                        </tr>
                        @endforeach
                    </table>

                    @endif
                    {{ $tenants->links() }}
                </div>

            </div>
        </div>
    </div>

    @include('layouts.footers.auth')
</div>
@endsection
