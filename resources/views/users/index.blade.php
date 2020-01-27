@extends('layouts.app', ['page_title' => "Users Management"])

@section('content')
@include('layouts.headers.cards')

<div class="container-fluid mt--9">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Users Management</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('users.create') }}" class="btn btn-success shadow"><i class="fas fa-plus-circle pr-2"></i> Add User</a>
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
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Edit</th>
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
                                            @elseif($user->role == 4)
                                                Super Admin
                                            @elseif($user->role == 10)
                                                The Master
                                            @endif
                                        
                                        </td>
                                        <td><a href="{{ route('users.edit', ['id' => $user->id ]) }}" class="btn btn-info shadow">Edit User</a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{ $users->links() }}
                
                </div>
            </div>
        </div>
    </div>

    @include('layouts.footers.auth')
</div>
@endsection
