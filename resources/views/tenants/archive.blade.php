@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header">Archived Tenants</div>

                <div class="card-body">

                @if(Session::has('info'))
                    <div class="alert alert-success" role="alert">
                        <h4 class="alert-heading">Success!</h4>
                        <p>{{ Session::get('info') }}</p>
                    </div>
                @endif


                    @if($tenants->isEmpty())
                        You have no archived tenants

                        <div class="mb-3 text-right">
                            <a href="{{ route('tenants.index') }}" class="btn btn-primary">Go Back</a>
                        </div>
                    @else

                    <div class="mb-3 text-right">
                        <a href="{{ route('tenants.index') }}" class="btn btn-primary">Go Back</a>
                    </div>

                    <table class="table table-hover">
                        <tr>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                  
                        </tr>
                        @foreach($tenants as $tenant)
                        <tr>
                            <td><a href="{{ route('tenants.show', ['id' => $tenant->id ]) }}">{{ $tenant->name }}</a></td>
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
