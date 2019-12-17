@extends('layouts.app', ['page_title' => "Storage Rentals"])

@section('content')
@include('layouts.headers.cards')

<div class="container-fluid mt--9">

    <div class="row">
        <div class="col">
            @if(Session::has('info'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <h4 class="alert-heading">Success!</h4>
                    <p>{{ Session::get('info') }}</p>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="card bg-secondary shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Storage Rentals</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('community.create') }}" class="btn btn-success shadow"><i class="fas fa-plus-circle pr-2"></i> Add Storage Rental</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">

                    <p>Coming Soon!</p>
                    
                </div>
            </div>
        </div>
    </div>

    @include('layouts.footers.auth')
</div>
@endsection
