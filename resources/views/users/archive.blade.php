@extends('layouts.app', ['page_title' => "Archived Users"])

@section('content')
@include('layouts.headers.cards')

<div class="container-fluid mt--9">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Archived Users</h3>
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

                    @if($users->isEmpty())
                        You have no archived users

                    @else

                    <div class="table-responsive">
                        <table class="table align-items-center table-flush table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <td>Edit</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                            
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                        
                                            @if($user->role == 1)
                                                Maintenance Worker
                                            @elseif($user->role == 2)
                                                Office Manager
                                            @elseif($user->role == 3)
                                                Admin
                                            @endif
                                        
                                        </td>
                                        <td><a href="{{ route('users.edit', ['id' => $user->id ]) }}" class="btn btn-info shadow">Edit Tenant</a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                    
                    {{ $users->links() }}

                </div>
            </div>
        </div>
        
    </div>

    @include('layouts.footers.auth')
</div>
@endsection
