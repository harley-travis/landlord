<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">
        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Brand -->
        <a class="navbar-brand p-0 text-left" href="{{ route('home') }}">
            <img src="{{url('/img/logo.png')}}" class="navbar-brand-img" alt="senrent logo" style="max-width:75%">
        </a>
        <!-- User -->
        <!-- not sure what this is -->
        <ul class="nav align-items-center d-md-none">
            <li class="nav-item dropdown">
                <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="media align-items-center">
                        <span class="avatar avatar-sm rounded-circle">
                        <img alt="Image placeholder" src="{{ asset('argon') }}/img/theme/team-1-800x800.jpg">
                        </span>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                    <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0">{{ __('Welcome!') }}</h6>
                    </div>
                    <a href="#" class="dropdown-item">
                        <i class="ni ni-settings-gear-65"></i>
                        <span>{{ __('Settings') }}</span>
                    </a>
                    <a href="#" class="dropdown-item">
                        <i class="ni ni-calendar-grid-58"></i>
                        <span>{{ __('Activity') }}</span>
                    </a>
                    <a href="#" class="dropdown-item">
                        <i class="ni ni-support-16"></i>
                        <span>{{ __('Support') }}</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                        <i class="ni ni-user-run"></i>
                        <span>{{ __('Logout') }}</span>
                    </a>
                </div>
            </li>
        </ul>A
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
            <!-- Collapse header -->
            <div class="navbar-collapse-header d-md-none">
                <div class="row">
                    <div class="col-6 collapse-brand">
                        <a href="{{ route('home') }}">
                            <img src="{{url('/img/logo-white.png')}}" alt="senrent logo" />
                        </a>
                    </div>
                    <div class="col-6 collapse-close">
                        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>
            <!-- Form -->
            <form class="mt-4 mb-3 d-md-none">
                <div class="input-group input-group-rounded input-group-merge">
                    <input type="search" class="form-control form-control-rounded form-control-prepended" placeholder="{{ __('Search') }}" aria-label="Search">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="fa fa-search"></span>
                        </div>
                    </div>
                </div>
            </form>
            <!-- Navigation -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">
                        <i class="fas fa-desktop text-gray-dark"></i> Dashboard
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#navbar-examples" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-examples">
                        <i class="fas fa-wrench text-info"></i>
                        <span class="">Maintenance</span>
                    </a>
                    <div class="collapse" id="navbar-examples">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('maintenance.index') }}">
                                    View All
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('maintenance.archived') }}">
                                    View Archived
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- TENANT -->
                @if(Auth::user()->role === 0)

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('settings.billing.index') }}">
                        <i class="ni ni-planet text-blue"></i> Billing History
                    </a>
                </li>
                
                <!-- OFFICE MANAGER -->
                @elseif(Auth::user()->role === 2)

                    <!-- HOA -->
                    @if( Auth::user()->product === 3 )
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('community.index') }}">
                            <i class="fas fa-city text-teal"></i> Communities
                        </a>
                    </li>   
                    @endif

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('property.index') }}">
                        <i class="ni ni-pin-3 text-orange"></i> Properties
                        </a>
                    </li>   
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('tenants.index') }}">
                            <i class="fas fa-user-friends text-blue"></i> Tenants
                        </a>
                    </li> 

                <!-- ADMIN -->
                @elseif(Auth::user()->role === 3)

                    <!-- HOA -->
                    @if( Auth::user()->product === 3 )
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('community.index') }}">
                            <i class="fas fa-city text-teal"></i> Communities
                        </a>
                    </li>   
                    @endif

                    <!-- STORAGE RENTALS -->
                    @if( Auth::user()->product === 4 )
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('storage-rentals.index') }}">
                            <i class="fas fa-box-open text-purple"></i> Storage Rentals
                        </a>
                    </li> 
                    @endif

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('property.index') }}">
                        <i class="ni ni-pin-3 text-orange"></i> Properties
                        </a>
                    </li>   
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('tenants.index') }}">
                            <i class="fas fa-user-friends text-blue"></i> Tenants
                        </a>
                    </li> 
                    <li class="nav-item">
                        <a class="nav-link" href="#users" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="users">
                            <i class="far fa-user-circle text-pink"></i>
                            <span>Users</span>
                        </a>
                        <div class="collapse" id="users">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('users.index') }}">
                                        View All
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('users.archived') }}">
                                        View Archived
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                <!-- SENRENT INTERNAL -->
                @elseif(Auth::user()->role === 4)

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('property.index') }}">
                        <i class="ni ni-pin-3 text-orange"></i> Properties
                        </a>
                    </li>   
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('community.index') }}">
                            <i class="fas fa-city text-teal"></i> Communites
                        </a>
                    </li> 
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('storage-rentals.index') }}">
                            <i class="fas fa-box-open text-purple"></i> Storage Rentals
                        </a>
                    </li> 
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('tenants.index') }}">
                            <i class="fas fa-user-friends text-blue"></i> Tenants
                        </a>
                    </li> 
                    <li class="nav-item">
                        <a class="nav-link" href="#users" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="users">
                            <i class="far fa-user-circle text-pink"></i>
                            <span>Users</span>
                        </a>
                        <div class="collapse" id="users">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('users.index') }}">
                                        View All
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('users.archived') }}">
                                        View Archived
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>


                <!-- TRAVIS -->
                @elseif(Auth::user()->role === 10)

                <li class="nav-item">
                        <a class="nav-link" href="{{ route('property.index') }}">
                        <i class="ni ni-pin-3 text-orange"></i> Properties
                        </a>
                    </li>   
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('community.index') }}">
                            <i class="fas fa-city text-teal"></i> Communites
                        </a>
                    </li> 
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('storage-rentals.index') }}">
                            <i class="fas fa-box-open text-purple"></i> Storage Rentals
                        </a>
                    </li> 
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('tenants.index') }}">
                            <i class="fas fa-user-friends text-blue"></i> Tenants
                        </a>
                    </li> 

                    <li class="nav-item">
                        <a class="nav-link" href="#users" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="users">
                            <i class="far fa-user-circle text-pink"></i>
                            <span>Users</span>
                        </a>
                        <div class="collapse" id="users">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('users.index') }}">
                                        View All
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('users.archived') }}">
                                        View Archived
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link" href="#customer-feedback" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="customer-feedback">
                            <i class="far fa-comment-dots text-teal"></i>
                            <span>Customer Feedback</span>
                        </a>
                        <div class="collapse" id="customer-feedback">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('feedback.index') }}">
                                        View All
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('feedback.archived') }}">
                                        View Archived
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                @endif    

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('feedback.create') }}">
                        <i class="fas fa-comments text-green"></i> Send Feedback
                    </a>
                </li>   
                            
            </ul>
            <!-- Divider -->
            <hr class="my-3">
            <!-- Heading -->
            <h6 class="navbar-heading text-muted">Legal</h6>
            <!-- Navigation -->
            <ul class="navbar-nav mb-md-3">
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="fas fa-user-secret"></i> Privacy Policy
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="fas fa-file-signature"></i> Terms of Service
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="fas fa-id-badge"></i> Licenses
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>