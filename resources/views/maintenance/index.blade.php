@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Maintenance Requests</div>

                <div class="card-body">

                @if(Session::has('info'))
                    <div class="alert alert-success" role="alert">
                        <h4 class="alert-heading">Success!</h4>
                        <p>{{ Session::get('info') }}</p>
                    </div>
                @endif

                    <div class="mb-3 text-right">
                        <a href="{{ route('maintenance.archived') }}" class="btn btn-link">View Archived Requests</a>
                        <a href="{{ route('maintenance.create') }}" class="btn btn-success">Add Maintenance Request</a>
                    </div>

                    <table class="table table-hover">
                        <tr>
                            <th>Subject</th>
                            <th>Description</th>
                            <th>Emergency</th>
                            <th>Status</th>
                            <td>Edit</th>
                        </tr>
                        @foreach($requests as $request)
                        <tr>
                            <td>{{ $request->subject }}</td>
                            <td>{{ $request->description }}</td>
                            <td>
                                @if($request->emergency === 0)
                                    No
                                @else 
                                    Yes
                                @endif
                            </td>
                            <td>
                                @if($request->status === 0)
                                    Pending
                                @elseif($request->status === 1) 
                                    Under Review
                                @elseif($request->status === 2) 
                                    In Progress
                                @elseif($request->status === 3) 
                                    Completed
                                @endif
                            </td>
                            <td><a href="{{ route('maintenance.show', ['id' => $request->id ]) }}" class="btn btn-info text-white">View</a></td>
                        </tr>
                        @endforeach

                    </table>


                </div>

            </div>
        </div>
    </div>
</div>
@endsection
