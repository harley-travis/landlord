@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header">Add New User</div>

                <div class="card-body">

                    <div class="mb-3 text-right">
                        <a href="{{ route('users.index') }}" class="btn btn-info text-white">Go Back</a>
                    </div>
                    
                    <form action="{{ route('users.add') }}" method="post">

                        <div class="form-group">
                            <label for="name">Name <small class="text-danger pl-2">required</small></label>
                            <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" aria-describedby="name" placeholder="Enter name" value="{{ old('name') }}">
                            @error('name')
                            <span class='invalid-feedback'>{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Email <small class="text-danger pl-2">required</small></label>
                            <input type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" name="email" aria-describedby="email" placeholder="Enter email" value="{{ old('email') }}">
                            @error('email')
                            <span class='invalid-feedback'>{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password">Password <small class="text-danger pl-2">required</small></label>
                            <input type="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" name="password" aria-describedby="password" placeholder="Enter password">
                            <small id="passwordHelp" class="form-text text-muted">Password must be 8 characters long</small>
                            @error('password')
                            <span class='invalid-feedback'>{{ $message }} Password must be 8 characters long.</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="role">User Role <small class="text-danger pl-2">required</small></label>
                            <select id="role" name="role" class="form-control {{ $errors->has('role') ? 'is-invalid' : '' }}">
                                <option>Select User Role</option>
                                <option value="1">Maintenance Worker</option>
                                <option value="2">Office Manager</option>
                                <option value="3">Admin</option>
                            </select>
                            @error('role')
                            <span class='invalid-feedback'>{{ $message }}</span>
                            @enderror
                        </div> 
             
                        @csrf

                        <button type="submit" class="btn btn-success shadow">Save User</button>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
