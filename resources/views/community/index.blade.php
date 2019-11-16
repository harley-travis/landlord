@extends('layouts.app', ['page_title' => "Community Management"])

@section('content')
@include('layouts.headers.cards')

<div class="container-fluid mt--9">
    <div class="row">
        <div class="col">
            <div class="card bg-secondary shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Community Management</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('community.create') }}" class="btn btn-success shadow"><i class="fas fa-plus-circle pr-2"></i> Add Community</a>
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

                    @if($communities->isEmpty())
                        <p>You don't have any properties added! Let's add one now!</p>
                        <div class="pb-5 text-left">
                            <a href="{{ route('community.create') }}" class="btn btn-primary shadow">Add Community</a>
                        </div>       
                    @else
                
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>Name</th>
                                    <td>Edit</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($communities as $community)
                                <tr>
                                    <td>{{ $community->hoa_community }} </td>
                                    <td><a href="{{ route('community.edit', ['id' => $community->id ]) }}" class="btn btn-info shadow">Edit Community</a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                        {{ $communities->links() }}

                </div>
                @endif
            </div>
        </div>
    </div>

    
</div>
@include('layouts.footers.auth')
@endsection
