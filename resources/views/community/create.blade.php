@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Add New Community</div>

                <div class="card-body">

                    <div class="mb-3 text-right">
                        <a href="{{ route('community.index') }}" class="btn btn-info text-white">Go Back</a>
                    </div>
                    
                    <form action="{{ route('community.add') }}" method="post">

                        <div class="form-group">
                            <label for="hoa_community">Community Name</label>
                            <input type="text" class="form-control" name="hoa_community" aria-describedby="hoa_community" placeholder="Enter community name">
                        </div>

                        @csrf

                        <button type="submit" class="btn btn-success">Save Community</button>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
