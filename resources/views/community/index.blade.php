@extends('layouts.app', ['page_title' => "Community Management"])

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
                            <h3 class="mb-0">Community Management</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('community.create') }}" class="btn btn-success shadow"><i class="fas fa-plus-circle pr-2"></i> Add Community</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">

                    @if($communities->isEmpty())
                        <p>You don't have any communities added! Let's add one now!</p>
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
                                    <td>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($communities as $community)
                                <tr>
                                    <td>{{ $community->hoa_community }} </td>
                                    <td><a href="{{ route('community.edit', ['id' => $community->id ]) }}" class="btn btn-info shadow">Edit Community</a></td>
                                    <td><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal">Delete Community</button></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-info" id="deleteModalLabel">Delete Community</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to delete this community? This action is permanent and can not be undone. 
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <a class="btn btn-danger shadow" href="{{ route('community.delete', ['id' => $community->id ]) }}">Yes, Delete Community</a>
                            </div>
                            </div>
                        </div>
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
