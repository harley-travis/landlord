@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Add New Tenant</div>

                <div class="card-body">

                    <div class="mb-3 text-right">
                        <a href="{{ route('users.index') }}" class="btn btn-info text-white">Go Back</a>
                    </div>
                    
                    <form action="{{ route('users.add') }}" method="post">

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" name="name" aria-describedby="name" placeholder="Enter name">
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email" aria-describedby="email" placeholder="Enter email">
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" name="password" aria-describedby="password" placeholder="Enter password">
                        </div>

                        <div class="form-group">
                            <label for="role">User Role</label>
                            <select id="role" name="role" class="form-control">
                                <option>Select User Role</option>
                                <option value="1">Maintenance Worker</option>
                                <option value="2">Office Manager</option>
                                <option value="3">Admin</option>
                            </select>
                        </div> 
             
                        @csrf

                        <button type="submit" class="btn btn-success">Save User</button>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
