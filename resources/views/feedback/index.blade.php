@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-12">
         @if(Auth::user()->role >= 4)
            <div class="card shadow">
                <div class="card-header">Customer Feedback</div>
                <div class="card-body">   

                @if(Session::has('info'))
                    <div class="alert alert-success" role="alert">
                        <h4 class="alert-heading">Success!</h4>
                        <p>{{ Session::get('info') }}</p>
                    </div>
                @endif

                    <div class="mb-3 text-right">
                        <a href="{{ route('feedback.archived') }}" class="btn btn-link">View Archived Feedback</a>
                    </div>

                    <table class="table table-hover">
                        <tr>
                            <th>Submitted By</th>
                            <th>Subject</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>View Feedback</th>
                        </tr>
                        @foreach($feedbacks as $feedback)

                        <tr>
                            <td>{{ $feedback->name }}</td>
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

            </div>
            @else
            
                <div class="alert alert-warning text-center" role="alert">
                    <strong>ATTENTION!</strong> The page you are looking for does not exisit
                </div>
                
            @endif

        </div>
    </div>
</div>


@endsection
