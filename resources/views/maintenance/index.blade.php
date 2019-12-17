@extends('layouts.app', ['page_title' => "Maintenance Requests"])

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
                            <h3 class="mb-0">Maintenance Requests</h3>
                        </div>
                        <div class="col-4 text-right">
                            @if( Auth::user()->role === 0 )
                            <a href="{{ route('maintenance.create') }}" class="btn btn-success shadow"><i class="fas fa-plus-circle pr-2"></i> Create Ticket</a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">

                @if ( $requests->isEmpty() && Auth::user()->role != 0 )
                   
                <i class="fas fa-glass-cheers"></i> <span class="text-success font-weight-bold">Congratulations! You have no maintenance requests. Keep up the good work!</span>

                @elseif( $requests->isEmpty() && Auth::user()->role === 0 )

                    You do not currently have any open maintenance requests. <br>

                    <div class="pt-3 pb-3"></div>
               
                    <div class="text-center">
                        <a href="{{ route('maintenance.create') }}" class="btn btn-success"><i class="fas fa-plus-circle pr-2"></i> Create Ticket</a>
                    </div>

                @else
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>Subject</th>
                                    <th>Emergency</th>
                                    <th>Date Submitted</th>
                                    <th>Status</th>
                                    <th>View</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($requests as $request)
                                <tr>
                                    <td>{{ $request->subject }}</td>
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
                            </tbody>
                        </table>
                    </div>
                    @endif

                    {{ $requests->links() }}

                </div>
            </div>
        </div>
    </div>

    @include('layouts.footers.auth')
</div>
@endsection
