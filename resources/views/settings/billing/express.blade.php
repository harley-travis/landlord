@extends('layouts.app', ['page_title' => "Onboarding Confirmation"])

@section('content')
@include('layouts.headers.cards')

<div class="container-fluid mt--9">

    <div class="row mb-3">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Onboarding Confirmation</h3>
                        </div>
                        <div class="col-4 text-right">
                           
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p>Thank you for completing your onboarding. Please click the button below to confirm and you will complete the onboarding process. If you fail to click the button below, your account will not be ready to accept payment from your tenants.</p>                            
                    
                    <form action="{{ route('settings.billing.expressConnection') }}" method="post">

                        @csrf

                        <input type="hidden" name="code" id="code">
                        <button type="submit" class="btn btn-success">Activate Account</button>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>

<script>

    $( document ).ready(function() {

        // grab the auth code from the redirect url and submit it as a post 
        
        var vars = {};
        var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
            vars[key] = value;
        });
        
        $code = vars["code"];
        $('#code').val($code);

    });

</script>