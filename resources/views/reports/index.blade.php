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

        <!-- might have to write a VUE page for this | could create a chart.js
            heck we might even use this data for the dashboard. if we're create a vue 
            component. then we could just call it there
         -->

        <h3>Select a report</h3>

        <select>
            <option>Vacancies and Occupancies</option>
            <option>Revenue</option><!-- show all tenants and amount paid | give option to select the date in this view -->
            <option></option>
        </select>

    </div>

    @include('layouts.footers.auth')
</div>
@endsection
