@extends('layouts.app', ['page_title' => "Maintenance Request"])

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
        <div class="col-xl-8 mb-5 mb-xl-0">
            <div class="card bg-gradient-default mb-3 shadow">
                <div class="card-header bg-transparent">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="text-uppercase text-light ls-1 mb-1">Maintenance Request</h6>
                            <h2 class="text-white mb-0">{{ $request->type }} | {{ $request->subject }}</h2>
                        </div>
                        <div class="col-4 text-right">

                            @if ( Auth::user()->role >= 1 )
                            
                                <!-- create the next progression button -->
                                @if($request->status === 0)
                                    <a href="{{ route('maintenance.progression', ['id' => $request->id ]) }}" class="btn btn-success">Mark as In Review</a>
                                @elseif($request->status === 1) 
                                    <a href="{{ route('maintenance.progression', ['id' => $request->id ]) }}" class="btn btn-success">Mark as In Progress</a>
                                @elseif($request->status === 2) 
                                    <a href="{{ route('maintenance.progression', ['id' => $request->id ]) }}" class="btn btn-success">Mark as Completed</a>
                                @endif

                            @endif

                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <p class="text-white">{{ $request->description }}</p>
                </div>
            </div>
            <div class="card shadow">

                <div class="card-body">

                    @if ( Auth::user()->role >= 1 )
                    <form action="{{ route('maintenance.update') }}" method="post">

                        <div class="form-group">
                            <label for="status">Update Status</label>
                            <select id="status" name="status" class="form-control">
                                                                    
                                @if( $request->status === 0 )
                                <option class="bg-success text-white" value="0">Pending</option>
                                @elseif( $request->status === 1 )
                                <option class="bg-success text-white" value="1">In Review</option>
                                @elseif( $request->status === 2 )
                                <option class="bg-success text-white" value="2">In Progress</option>
                                @elseif( $request->status === 3 )
                                <option class="bg-success text-white" value="3">Completed</option>
                                @endif

                                <option value="0">Pending</option>
                                <option value="1">In Review</option>
                                <option value="2">In Progress</option>
                                <option value="3">Completed</option>
                            </select>
                        </div>    

                        <div class="form-group">
                            <label for="notes">Add Notes</label><br>
                            <small>last updated: {{ $request->updated_at }}</small>
                            <textarea class="form-control" name="notes" rows="8">{{ $request->notes }}</textarea>
                        </div>

                        <div class="pt-3 pb-3"></div>

                        @csrf

                        <input type="hidden" name="id" value="{{ $request->id }}">
                        <button type="submit" class="btn btn-primary shadow">Update Maintenance Request</button>
                    </form>

                    @endif

                </div>

            </div>
                
        </div>
        <div class="col-xl-4">
            <div class="card shadow">
                <div class="card-header bg-transparent">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="text-uppercase text-muted ls-1 mb-1">Work Order Information</h6>
                            <h2 class="mb-0">Project Details</h2>
                            <h5><strong>Submitted:</strong> {{ $request->created_at }}</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    <div class="maintenance-info pb-3">
                        @if($request->status === 0)
                            <span class="text-danger">Pending</span>
                        @elseif($request->status === 1) 
                            <span class="text-primary">Under Review</span>
                        @elseif($request->status === 2) 
                            <span class="text-success">In Progress</span>
                        @elseif($request->status === 3) 
                            <span class="text-success"><strong>Completed</strong></span>
                        @endif
                    </div>

                    <div class="maintenance-info pb-3">
                        @if($request->emergency === 0)
                            Not an emergency
                        @else 
                            <span class="text-danger"><strong>Emergency</strong></span>
                        @endif 
                    </div>

                    <div class="maintenance-info pb-3">
                        @if($request->permission === 0)
                            <span class="text-danger"><strong>Do not enter the property if the tenant is not home</strong></span>
                        @else 
                            Allowed to enter if tenant is not home
                        @endif 
                    </div>

                    <div class="maintenance-info pb-3">
                        @if ( Auth::user()->role >= 1 )
                            <div class="pt-3 pb-3"></div>
                            <h4 class="text-primary">Tenant Contact Information</h4>

                            <span>{{ $request->name }}</span><br>
                            <span><a href="mailto:{{ $request->email }}">{{ $request->email }}</a></span>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>

    @include('layouts.footers.auth')
</div>
@endsection
