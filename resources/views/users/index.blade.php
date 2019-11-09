@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Users Management</div>

                <div class="card-body">

                @if(Session::has('info'))
                    <div class="alert alert-success" role="alert">
                        <h4 class="alert-heading">Success!</h4>
                        <p>{{ Session::get('info') }}</p>
                    </div>
                @endif

                    <div class="mb-3 text-right">
                        <a href="{{ route('users.archived') }}" class="btn btn-link">View Archived Users</a>
                        <a href="{{ route('users.create') }}" class="btn btn-success">Add User</a>
                    </div>

                    <table class="table table-hover">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <td>Edit</th>
                        </tr>

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
                                    @elseif($user->role == 4)
                                        Super Admin
                                    @elseif($user->role == 10)
                                        The Master
                                    @endif
                                
                                </td>
                                <td><a href="{{ route('users.edit', ['id' => $user->id ]) }}" class="btn btn-info text-white">Edit Tenant</a></td>
                            </tr>
                         
                        @endforeach
                      
                    </table>
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
