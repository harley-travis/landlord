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

                @if($requests->isEmpty())
                    You have no archived maintenance requests
                @else

                    <div class="mb-3 text-right">
                        <a href="{{ route('maintenance.index') }}" class="btn btn-info text-white">Go Back</a>
                    </div>

                    <table class="table table-hover">
                        <tr>
                            <th>Subject</th>
                            <th>Description</th>
                            <th>Emergency</th>
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
                            <td><a href="{{ route('maintenance.show', ['id' => $request->id ]) }}" class="btn btn-info text-white">View</a></td>
                        </tr>
                        @endforeach

                    </table>


                </div>
            @endif
            </div>
        </div>
    </div>
</div>
@endsection
