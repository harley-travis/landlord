@extends('layouts.app', ['page_title' => "Archived Customer Feedback"])

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
                            <h3 class="mb-0">Archived Customer Feedback</h3>
                        </div>
                        <div class="col-4 text-right">
                        </div>
                    </div>
                </div>
                <div class="card-body">

                @if($feedbacks->isEmpty())
                    You have no archived maintenance requests
                @else

                    <div class="table-responsive">
                        <table class="table align-items-center table-flush table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>Subject</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>View Feedback</th>
                                </tr>
                            </thead>
                            <tbody>
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
                                    <td><a href="{{ route('feedback.show', ['id' => $feedback->id ]) }}" class="btn btn-info">View</a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                    
                    {{ $feedbacks->links() }}

                </div>
            </div>
        </div>
    </div>

    @include('layouts.footers.auth')
</div>
@endsection
