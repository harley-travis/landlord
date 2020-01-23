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
                            <h3 class="mb-0">Reporting</h3>
                        </div>
                        <div class="col-4 text-right">

                        </div>
                    </div>
                </div>
                <div class="card-body">

                    <!-- might have to write a VUE page for this | could create a chart.js
                        heck we might even use this data for the dashboard. if we're create a vue 
                        component. then we could just call it there
                    -->

                    <!-- <report-component></report-component> -->

                    <form action="{{ route('reports.show') }}" method="post">

                        <div class="mb-5">
                            <select class="form-control" name="report">
                                <option value="0">Vacancies and Occupancies</option> <!-- pie chart. 100% properties and number of vacancies -->
                                <option value="1">Revenue</option><!-- show amount earned for the year v projected | line | give option to select the date in this view -->
                                <option value="2">Maintenance Requests</option>
                                <option>Expenditures (coming soon)</option>
                            </select>
                        </div>
                        
                        @csrf
                        
                        <button type="submit" class="btn btn-primary shadow">Run Report</button>

                    </form>

                </div>
            </div>
        </div>
    </div>

    @include('layouts.footers.auth')
</div>
@endsection

@section('otherJs')
    <!-- FOR SOME REASON THERE IS A BUG WHEN THIS IS ON. IT PREVENTS YOU FROM OPENING THE DROP DOWN MENU TOP RIGHT -->
    <!-- <script src="{{ asset('js/app.js') }}"></script> -->
@endsection