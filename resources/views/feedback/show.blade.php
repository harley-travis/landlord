@extends('layouts.app', ['page_title' => "Feedback Request"])

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
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Feedback Request</h3>
                        </div>
                        <div class="col-4 text-right">
                            
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    <h3>{{ $feedback->subject }}</h3>
                    <small>
                        @if($feedback->status === 0)
                            <span class="text-warning">Pending</span>
                        @elseif($feedback->status === 1) 
                            <span class="text-info">Under Review</span>
                        @elseif($feedback->status === 2) 
                            <span class="text-primary">In Progress</span>
                        @elseif($feedback->status === 3) 
                            <span class="text-success">Completed</span>
                        @endif
                    </small> 
                    <br>

                    <div class="pt-3 pb-3"></div>

                    <p>{{ $feedback->description }}</p>

                    <form action="{{ route('feedback.update') }}" method="post">
                        <div class="form-group">
                            <label for="status">Status Update</label>
                            <select id="status" name="status" class="form-control">
                                <option>Select Status Update</option>
                                <option value="0">Pending</option>
                                <option value="1">In Review</option>
                                <option value="2">In Progress</option>
                                <option value="3">Completed</option>
                            </select>
                        </div>    

                        @csrf

                        <input type="hidden" name="id" value="{{ $feedback->id }}">
                        <button type="submit" class="btn btn-primary shadow">Update Maintenance Request</button>
                    </form>

                </div>

            </div>
        </div>
    </div>

    @include('layouts.footers.auth')
</div>
@endsection
