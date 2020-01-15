@extends('layouts.app', ['page_title' => "Dashboard"])

@section('content')
    @include('layouts.headers.cards')
    
    <div class="container-fluid mt--9">
        <div class="row">
            <div class="col-xl-8 mb-5 mb-xl-0">
                <div class="card bg-gradient-default shadow">
                    <div class="card-header bg-transparent">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="text-uppercase text-light ls-1 mb-1">Overview</h6>
                                <h2 class="text-white mb-0">Welcome to SenRent</h2>
                            </div>
                            <div class="col">
                                
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                       
                        <!-- getting started for the first roll out. display video here -->
                        <div class="mb-5 embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/b4PQTSmRN0A"></iframe>
                        </div>


                       <!-- this will be the future view after phase 1 -->
                       <!-- <div class="mb-4 bg-white p-4">
                            <h3 class="mb-0">Add a Property</h3>
                            <p>You can no add a property. Assign each property to a tenant and you can start accepting rent through SenRent. You can keep additional information about your property for future updates. Make sure that you update each property with all the information to participate in new updates coming soon.</p>
                       </div>

                       <div class="mb-4 bg-white p-4">
                            <h3 class="mb-0">Add a Property</h3>
                            <p>You can no add a property. Assign each property to a tenant and you can start accepting rent through SenRent. You can keep additional information about your property for future updates. Make sure that you update each property with all the information to participate in new updates coming soon.</p>
                       </div>

                       <div class="mb-4 bg-white p-4">
                            <h3 class="mb-0">Add a Property</h3>
                            <p>You can no add a property. Assign each property to a tenant and you can start accepting rent through SenRent. You can keep additional information about your property for future updates. Make sure that you update each property with all the information to participate in new updates coming soon.</p>
                       </div>

                       <div class="mb-4 bg-white p-4">
                            <h3 class="mb-0">Add a Property</h3>
                            <p>You can no add a property. Assign each property to a tenant and you can start accepting rent through SenRent. You can keep additional information about your property for future updates. Make sure that you update each property with all the information to participate in new updates coming soon.</p>
                       </div> -->


                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card shadow">
                    <div class="card-header bg-transparent">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="text-uppercase text-muted ls-1 mb-1">Help and Documentation</h6>
                                <h2 class="mb-0">Getting Started</h2>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">

                       <ul class="getting-started-ul">
                            <!-- tenants -->
                            @if( Auth::user()->role === 0 )
                            <li><a href="#">Add your ACH account to pay rent.</a></li>
                            @endif

                            <!-- maintenance -->
                            @if( Auth::user()->role === 0 )
                            <li><a href="#">View maintenance requests</a></li>
                            @endif

                            <!-- account owners and office managers -->
                            @if( Auth::user()->role >= 2 )
                            <li><a href="#">Account onboarding. Start accepting payments.</a></li>
                            <li><a href="#">Add your first property</a></li>
                            <li><a href="#">Add your first tenant</a></li>
                            <li><a href="#">Assign your tenant to your property</a></li>
                            <li><a href="#">Create users and permissions</a></li>
                            @endif
                       </ul>

                    </div>
                </div>
            </div>
        </div>


        @include('layouts.footers.auth')
    </div>
@endsection

@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
@endpush