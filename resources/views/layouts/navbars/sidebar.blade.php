<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">
        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Brand -->
        <a class="navbar-brand p-0 text-left" href="/">
            <img src="{{url('/img/logo.png')}}" class="navbar-brand-img" alt="senrent logo" style="max-width:75%">
        </a>
        <!-- User -->
        <!-- MOBILE NAV -->
        <ul class="nav align-items-center d-md-none">
            <li class="nav-item dropdown">
                <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="media align-items-center">
                        <span class="avatar avatar-sm rounded-circle font-weight-bold bg-primary">
                        {{ Auth::user()->name[0] }}
                        <!-- <img alt="Image placeholder" src="{{ asset('argon') }}/img/theme/team-1-800x800.jpg"> -->
                        </span>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                    <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0">{{ __('Welcome!') }}</h6>
                    </div>
                    <a href="{{ route('settings.billing.index') }}" class="dropdown-item">
                        <i class="ni ni-settings-gear-65"></i>
                        <span>Billing</span>
                    </a>
                    <a href="{{ route('feedback.create') }}" class="dropdown-item">
                        <i class="ni ni-calendar-grid-58"></i>
                        <span>Send Feedback</span>
                    </a>
                    <a href="{{ route('tickets.index') }}" class="dropdown-item">
                        <i class="ni ni-support-16"></i>
                        <span>Help</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                        <i class="ni ni-user-run"></i>
                        <span>{{ __('Logout') }}</span>
                    </a>
                </div>
            </li>
        </ul>
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
            <!-- Collapse header -->
            <div class="navbar-collapse-header d-md-none">
                <div class="row">
                    <div class="col-6 collapse-brand">
                        <a href="/">
                            <img src="{{url('/img/logo.png')}}" alt="senrent logo" style="width:100%;height:auto;" />
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
            <!-- SEARCH -->
            <!-- <form class="mt-4 mb-3 d-md-none">
                <div class="input-group input-group-rounded input-group-merge">
                    <input type="search" class="form-control form-control-rounded form-control-prepended" placeholder="{{ __('Search') }}" aria-label="Search">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="fa fa-search"></span>
                        </div>
                    </div>
                </div>
            </form> -->
            <!-- Navigation -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="/">
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
                    <a class="nav-link" href="{{ route('tenants.billing.index') }}">
                        <i class="ni ni-credit-card text-green"></i> Pay Rent
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('settings.billing.index') }}">
                        <i class="ni ni-archive-2 text-primary"></i> Billing History
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
                        <a class="nav-link" href="#tenants" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="tenants">
                            <i class="fas fa-users text-info"></i>
                            <span class="">Tenants</span>
                        </a>
                        <div class="collapse" id="tenants">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('tenants.index') }}">
                                        View All
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('tenants.archived') }}">
                                        View Archived
                                    </a>
                                </li>
                            </ul>
                        </div>
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
                        <a class="nav-link" href="#tenants" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="tenants">
                            <i class="fas fa-users text-info"></i>
                            <span class="">Tenants</span>
                        </a>
                        <div class="collapse" id="tenants">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('tenants.index') }}">
                                        View All
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('tenants.archived') }}">
                                        View Archived
                                    </a>
                                </li>
                            </ul>
                        </div>
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
                        <a class="nav-link" href="#tenants" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="tenants">
                            <i class="fas fa-users text-info"></i>
                            <span class="">Tenants</span>
                        </a>
                        <div class="collapse" id="tenants">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('tenants.index') }}">
                                        View All
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('tenants.archived') }}">
                                        View Archived
                                    </a>
                                </li>
                            </ul>
                        </div>
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
                    <a class="nav-link" href="{{ route('tenants.billing.index') }}">
                        <i class="ni ni-credit-card text-green"></i> Pay Rent
                    </a>
                </li>
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
                        <a class="nav-link" href="#tenants" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="tenants">
                            <i class="fas fa-users text-info"></i>
                            <span class="">Tenants</span>
                        </a>
                        <div class="collapse" id="tenants">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('tenants.index') }}">
                                        View All
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('tenants.archived') }}">
                                        View Archived
                                    </a>
                                </li>
                            </ul>
                        </div>
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

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('tickets.view') }}">
                            <i class="ni ni-support-16 text-green"></i> Customer Tickets
                        </a>
                    </li>

                @endif    

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('feedback.create') }}">
                        <i class="fas fa-comments text-default"></i> Send Feedback
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
                    <a class="nav-link" href="https://senrent.com/privacy-policy.php" target="_blank">
                        <i class="fas fa-user-secret"></i> Privacy Policy
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="https://senrent.com/terms-of-use.php" target="_blank">
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