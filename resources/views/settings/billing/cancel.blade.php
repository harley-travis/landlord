@extends('layouts.app', ['page_title' => "Billing Settings"])

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

            @if (session('danger'))
                <div class="alert alert-danger shadow-sm alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle pr-2"></i>{{ session('danger') }}
                </div>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            @endif
        </div>
    </div>

    <div class="row mt-3">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Cancellation</h3>
                        </div>
                        <div class="col-4 text-right">

                        </div>
                    </div>
                </div>

                <div class="card-body">

                    <p>Since we a new company, we would like to seek your guidence in improving our software and company. With your feedback, we will be able to grow and support our customers based on their needs.</p>
                    <p>In order to cancel your account, please contact us at 801.901.3683 or email us at support@senrent.com</p>

                </div><!-- card-body -->
            </div><!-- card -->
        </div><!-- col -->
    </div> <!-- row -->

    @include('layouts.footers.auth')

</div>

@endsection
