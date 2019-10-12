@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Community Management</div>

                <div class="card-body">

                @if(Session::has('info'))
                    <div class="alert alert-success" role="alert">
                        <h4 class="alert-heading">Success!</h4>
                        <p>{{ Session::get('info') }}</p>
                    </div>
                @endif

                @if($communities->isEmpty())
                    
                    <p>You don't have any properties added! Let's add one now!</p>
                    <div class="pb-5 text-left">
                        <a href="{{ route('community.create') }}" class="btn btn-primary">Add Community</a>
                    </div>
                           
                @else

                    <div class="mb-3 text-right">
                        <a href="{{ route('community.create') }}" class="btn btn-success">Add Community</a>
                    </div>

                    <table class="table table-hover">
                        <tr>
                            <th>Name</th>
                            <td>Edit</th>
                        </tr>
                        @foreach($communities as $community)
                        <tr>
                            <td>{{ $community->hoa_community }} </td>
                            <td><a href="{{ route('community.edit', ['id' => $community->id ]) }}" class="btn btn-info text-white">Edit Community</a></td>
                        </tr>
                        @endforeach
                    </table>
                    {{ $communities->links() }}

                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
