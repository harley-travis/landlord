@extends('layouts.app', ['page_title' => "Customer Feedback"])

@section('content')
@include('layouts.headers.cards')

<div class="container-fluid mt--9">

    <div class="row">
        <div class="col">
         @if(Auth::user()->role >= 4)
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">View Customer Feedback</h3>
                        </div>
                        <div class="col-4 text-right">
                            
                        </div>
                    </div>
                </div>
                <div class="card-body">   

                @if(Session::has('info'))
                    <div class="alert alert-success" role="alert">
                        <h4 class="alert-heading">Success!</h4>
                        <p>{{ Session::get('info') }}</p>
                    </div>
                @endif

                    <div class="table-responsive">
                        <table class="table align-items-center table-flush table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>Submitted By</th>
                                    <th>Subject</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>View Feedback</th>
                                </tr>
                            </thead>
                            <tbody>
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
                                    <td><a href="{{ route('feedback.show', ['id' => $feedback->id ]) }}" class="btn btn-info text-uppercase">View</a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

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

    @include('layouts.footers.auth')
</div>
@endsection
