@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header">Archived Customer Feedback</div>

                <div class="card-body">

                @if(Session::has('info'))
                    <div class="alert alert-success" role="alert">
                        <h4 class="alert-heading">Success!</h4>
                        <p>{{ Session::get('info') }}</p>
                    </div>
                @endif

                @if($feedbacks->isEmpty())
                    You have no archived maintenance requests
                @else

                    <div class="mb-3 text-right">
                        <a href="{{ route('feedback.index') }}" class="btn btn-info text-white">Go Back</a>
                    </div>

                    <table class="table table-hover">
                        <tr>
                            <th>Subject</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>View Feedback</th>
                        </tr>
                        @foreach($feedbacks as $feedback)
                        <tr>
                            <td>{{ $feedback->subject }}</td>
                            <td>{{ $feedback->description }}</td>
                            <td>
                                @if($feedback->status === 0)
                                    Pending
                                @elseif($feedback->status === 1) 
                                    Under Review
                                @elseif($feedback->status === 2) 
                                    In Progress
                                @elseif($feedback->status === 3) 
                                    Completed
                                @endif
                            </td>
                            <td><a href="{{ route('feedback.show', ['id' => $feedback->id ]) }}" class="btn btn-info text-white">View</a></td>
                        </tr>
                        @endforeach

                    </table>
                    {{ $feedbacks->links() }}

                </div>
            @endif
            </div>
        </div>
    </div>
</div>
@endsection
