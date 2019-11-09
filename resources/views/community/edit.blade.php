@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header">Edit Community</div>

                <div class="card-body">

                    <div class="mb-3 text-right">
                        <a href="{{ route('community.index') }}" class="btn btn-info text-white">Go Back</a>
                    </div>
                    
                    <form action="{{ route('community.update') }}" method="post">

                        <div class="form-group">
                            <label for="hoa_community">Community Name <small class="text-danger pl-2">required</small></label>
                            <input type="text" class="form-control {{ $errors->has('hoa_community') ? 'is-invalid' : '' }}" name="hoa_community" aria-describedby="hoa_community" value="{{ $community->hoa_community }}">
                            @error('hoa_community')
                            <span class='invalid-feedback'>{{ $message }}</span>
                            @enderror
                        </div>

                        @csrf

                        <input type="hidden" name="id" value="{{ $id }}">

                        <button type="submit" class="btn btn-success shadow">Save</button>

                    </form>
                   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
