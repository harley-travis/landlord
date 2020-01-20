@extends('layouts.app', ['page_title' => "Software Licenses"])

@section('content')
@include('layouts.headers.cards')

<div class="container-fluid mt--9">

    <div class="row mb-3">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Licenses Used</h3>
                        </div>
                        <div class="col-4 text-right">
                           
                        </div>
                    </div>
                </div>
                <div class="card-body pb-5 pt-5">


                    <p>The following are free to use frameworks and libraries that we have used to build our platform. If you have any questions regarding our licenses, please contact us at support@senrent.com</p>
                    
                    <ul>
                        <li><a href="https://laravel-guide.readthedocs.io/en/latest/license/" target="_blank">Laravel</a></li>
                        <li><a href="https://github.com/twbs/bootstrap/blob/v4.0.0/LICENSE" target="_blank">Bootstrap</a></li>
                        <li><a href="https://www.creative-tim.com/license" target="_blank">Creative Tim</a></li>
                    </ul>
                   
           
                </div>
            </div>
        </div>
    </div>

    @include('layouts.footers.auth')
</div>
@endsection

