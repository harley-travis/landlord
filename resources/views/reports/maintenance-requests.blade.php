@extends('layouts.app', ['page_title' => "Reports"])

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
                            <a href="{{ route('reports.index') }}" class="btn btn-primary shadow">Run another report</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    @if( $data->isEmpty() || $data->count() === 0 )
                        There is no data to report at this time. 
                    
                    @else

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Tenant</th>
                                    <th scope="col">Number of maintenance requests</th>
                                    <th scope="col">Amount Earned</th>
                                    <th scope="col">Amount Owed</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach($data as $d)

                                <tr>
                                    <td>{{ $d->address_1 }} {{ $d->address_2 }}</td>
                                    <td>{{ $d->tenant_id }}</td>
                                    <td>{{ $d->amount_paid }}</td>
                                    <td>{{ $d->balance }}</td>
                                </tr>

                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @endif

                </div>
            </div>
        </div>
    </div>

    @include('layouts.footers.auth')
</div>
@endsection
