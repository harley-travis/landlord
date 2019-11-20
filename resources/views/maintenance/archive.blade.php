@extends('layouts.app', ['page_title' => "Archived Maintenance Requests"])

@section('content')
@include('layouts.headers.cards')

<div class="container-fluid mt--9">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Archived Maintenance Requests</h3>
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

                    @if($requests->isEmpty())
                        You have no archived maintenance requests
                    @else

                    <div class="table-responsive">
                        <table class="table align-items-center table-flush table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>Subject</th>
                                    <th>Description</th>
                                    <th>Emergency</th>
                                    <td>Edit</th>
                                </tr>
                            </thead>
                            <tbody>
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
