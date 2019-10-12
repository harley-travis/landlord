@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Community</div>

                <div class="card-body">

                    <div class="mb-3 text-right">
                        <a href="{{ route('community.index') }}" class="btn btn-info text-white">Go Back</a>
                    </div>
                    
                    <form action="{{ route('community.update') }}" method="post">

                        <div class="form-group">
                            <label for="hoa_community">Community Name</label>
                            <input type="text" class="form-control" name="hoa_community" aria-describedby="hoa_community" value="{{ $community->hoa_community }}">
                        </div>

                        @csrf

                        <input type="hidden" name="id" value="{{ $id }}">

                        <button type="submit" class="btn btn-success">Save</button>

                    </form>
                   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
