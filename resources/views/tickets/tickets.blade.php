@extends('layouts.app', ['page_title' => "Customer Tickets"])

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
         @if(Auth::user()->role >= 4)
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">View Customer Tickets</h3>
                        </div>
                        <div class="col-4 text-right">
                            
                        </div>
                    </div>
                </div>
                <div class="card-body">   
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>Submitted By</th>
                                    <th>Subject</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>View Ticket</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tickets as $ticket)

                                <tr>
                                    <td>{{ $ticket->name }}</td>
                                    <td>{{ $ticket->subject }}</td>
                                    <td>{{ $ticket->description }}</td>
                                    <td>
                                        @if($ticket->status === 0)
                                            Pending
                                        @elseif($ticket->status === 1) 
                                            Under Review
                                        @elseif($ticket->status === 2) 
                                            In Progress
                                        @elseif($ticket->status === 3) 
                                            Completed
                                        @endif
                                    </td>
                                    <td><a href="{{ route('tickets.show', ['id' => $ticket->id ]) }}" class="btn btn-primary btn-sm text-uppercase">View Ticket</a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{ $tickets->links() }}
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
