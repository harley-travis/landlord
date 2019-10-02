@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit User</div>

                <div class="card-body">

                    <div class="mb-3 text-right">
                        <a href="{{ route('users.index') }}" class="btn btn-info text-white">Go Back</a>
                    </div>
                    
                    <form action="{{ route('users.update') }}" method="post">

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" name="name" aria-describedby="name" value="{{ $user->name }}">
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email" aria-describedby="email" value="{{ $user->email }}">
                        </div>

                        <div class="form-group">
                            <label for="role">User Role</label>
                            <select id="role" name="role" class="form-control">
                                <option {{ $user->role == $user->id ? 'selected':'' }} value='{{$user->role}}'> 
                                    @if($user->role == 1)
                                        Maintenance Worker
                                    @elseif($user->role == 2)
                                        Office Manager
                                    @elseif($user->role == 3)
                                        Admin
                                    @endif
                                
                                </option>
                                <option value="1">Maintenance Worker</option>
                                <option value="2">Office Manager</option>
                                <option value="3">Admin</option>
                            </select>
                        </div>

                        <input type="hidden" name="id" value="{{ $user->id }}">     

                        @csrf
              
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal">Archive User</button>
                        <button type="submit" class="btn btn-success">Save User</button>

                    </form>

                    <!-- Modal -->
                    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-info" id="deleteModalLabel">Archive User</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to archive this user? This does not delete the user or the user information. If archived, the user will no longer be able to sign in and use the software.
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <a class="btn btn-danger" href="{{ route('users.archive', ['id' => $user->id ]) }}">Yes, Archive User</a>
                            </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
