@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Archived Users</div>

                <div class="card-body">

                @if(Session::has('info'))
                    <div class="alert alert-success" role="alert">
                        <h4 class="alert-heading">Success!</h4>
                        <p>{{ Session::get('info') }}</p>
                    </div>
                @endif

                    @if($users->isEmpty())
                        You have no archived users

                        <div class="mb-3 text-right">
                            <a href="{{ route('users.index') }}" class="btn btn-primary">Go Back</a>
                        </div>
                    @else

                    <div class="mb-3 text-right">
                        <a href="{{ route('users.index') }}" class="btn btn-primary">Go Back</a>
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
        @endif
    </div>
</div>
@endsection
