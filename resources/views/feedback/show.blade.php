@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Feedback Request</div>

                <div class="card-body">

                @if(Session::has('info'))
                    <div class="alert alert-success" role="alert">
                        <h4 class="alert-heading">Success!</h4>
                        <p>{{ Session::get('info') }}</p>
                    </div>
                @endif

                    <div class="mb-3 text-right">
                        <a href="{{ route('feedback.index') }}" class="btn btn-info text-white">Go Back</a>
                    </div>

                    <h3>{{ $feedback->subject }}</h3>
                    <small>
                        @if($feedback->status === 0)
                            Pending
                        @elseif($feedback->status === 1) 
                            Under Review
                        @elseif($feedback->status === 2) 
                            In Progress
                        @elseif($feedback->status === 3) 
                            Completed
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
                        <button type="submit" class="btn btn-primary">Update Maintenance Request</button>
                    </form>


                </div>

            </div>
        </div>
    </div>
</div>
@endsection
