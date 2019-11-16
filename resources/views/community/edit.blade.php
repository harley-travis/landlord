@extends('layouts.app', ['page_title' => "Edit Community"])

@section('content')
@include('layouts.headers.cards')

<div class="container-fluid mt--9">
    <div class="row">
        <div class="col">
            <div class="card bg-secondary shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Edit Community</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('community.create') }}" class="btn btn-success shadow">Add Community</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">

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

    @include('layouts.footers.auth')
</div>
@endsection
