@extends('layouts.app', ['page_title' => "Add User"])

@section('content')
@include('layouts.headers.cards')

<div class="container-fluid mt--9">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Add User</h3>
                        </div>
                        <div class="col-4 text-right">
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    
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

    @include('layouts.footers.auth')
</div>
@endsection
