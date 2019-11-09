@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header">Maintenance Requests</div>

                <div class="card-body">

                @if(Session::has('info'))
                    <div class="alert alert-success" role="alert">
                        <h4 class="alert-heading">Success!</h4>
                        <p>{{ Session::get('info') }}</p>
                    </div>
                @endif

                @if ( $requests->isEmpty() && Auth::user()->role === 3 )
                    You have no archived maintenance requests

                @elseif( $requests->isEmpty() && Auth::user()->role === 0 )

                    You do not currently have any open maintenance requests. <br>

                    <div class="pt-3 pb-3"></div>

                    <div class="text-center">
                        <a href="{{ route('maintenance.create') }}" class="btn btn-success">Add Maintenance Request</a>
                    </div>

                @else

                    <div class="mb-3 text-right">
                        <a href="{{ route('maintenance.archived') }}" class="btn btn-link">View Archived Requests</a>
                        <a href="{{ route('maintenance.create') }}" class="btn btn-success">Add Maintenance Request</a>
                    </div>

                    <table class="table table-hover">
                        <tr>
                            <th>Subject</th>
                            <th>Description</th>
                            <th>Emergency</th>
                            <th>Date Submitted</th>
                            <th>Status</th>
                            <th>View</th>
                        </tr>
                        @foreach($requests as $request)
                        <tr>
                            <td>{{ $request->subject }}</td>
                            <td>{{ $request->description }}</td>
                            <td>
                                @if($request->emergency === 0)
                                    No
                                @else 
                                    <span class="text-danger"><strong>Yes</strong></span>
                                @endif
                            </td>
                            <td>{{ $request->created_at }}</td>
                            <td>
                                @if($request->status === 0)
                                    <span class="text-danger">Pending</span>
                                @elseif($request->status === 1) 
                                    <span class="text-primary">Under Review</span>
                                @elseif($request->status === 2) 
                                    <span class="text-success">In Progress</span>
                                @elseif($request->status === 3) 
                                    <span class="text-success"><strong>Completed</strong></span>
                                @endif
                            </td>
                            <td><a href="{{ route('maintenance.show', ['id' => $request->id ]) }}" class="btn btn-info text-white">View</a></td>
                        </tr>
                        @endforeach

                    </table>

                    {{ $requests->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
