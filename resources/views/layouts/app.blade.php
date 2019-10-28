<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SenRent | Dashboard</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://js.stripe.com/v3/"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    SenRent
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>
                                    

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">


                                @if(Auth::user()->role === 0)
                                <!-- TENANT -->
                                    <a class="dropdown-item" href="{{ route('maintenance.create') }}">Create Maintenance</a>
                                    <a class="dropdown-item" href="{{ route('maintenance.index') }}">My Maintenance Reqeusts</a>
                                    <a class="dropdown-item" href="{{ route('settings.billing.index') }}">Billing</a>
                                    <a class="dropdown-item" href="{{ route('feedback.create') }}">Send Feedback</a>

                                @elseif(Auth::user()->role === 1)
                                <!-- MAINTENANCE WORKER -->
                                    <a class="dropdown-item" href="{{ route('maintenance.index') }}">Maintenance</a>
                                    <a class="dropdown-item" href="{{ route('feedback.create') }}">Send Feedback</a>

                                @elseif(Auth::user()->role === 2)
                                <!-- OFFICE MANAGER -->
                                    @if( Auth::user()->product === 3 )
                                    <a class="dropdown-item" href="{{ route('community.index') }}">Communities</a>
                                    @endif
                                    <a class="dropdown-item" href="{{ route('property.index') }}">Properties</a>
                                    <a class="dropdown-item" href="{{ route('tenants.index') }}">Tenants</a>
                                    <a class="dropdown-item" href="{{ route('maintenance.index') }}">Maintenance</a>
                                    <a class="dropdown-item" href="{{ route('settings.billing.index') }}">Billing</a>
                                    <a class="dropdown-item" href="{{ route('feedback.create') }}">Send Feedback</a>

                                @elseif(Auth::user()->role === 3)
                                <!-- ADMIN -->
                                    @if( Auth::user()->product === 3 )
                                    <a class="dropdown-item" href="{{ route('community.index') }}">Communities</a>
                                    @endif
                                    <a class="dropdown-item" href="{{ route('property.index') }}">Properties</a>
                                    <a class="dropdown-item" href="{{ route('tenants.index') }}">Tenants</a>
                                    <a class="dropdown-item" href="{{ route('maintenance.index') }}">Maintenance</a>
                                    <a class="dropdown-item" href="{{ route('settings.billing.index') }}">Billing</a>
                                    <a class="dropdown-item" href="{{ route('users.index') }}">User Management</a>
                                    <a class="dropdown-item" href="{{ route('feedback.create') }}">Send Feedback</a>

                                @elseif(Auth::user()->role === 4)
                                <!-- SENRENT INTERNAL -->
                                    <a class="dropdown-item" href="{{ route('community.index') }}">Communities</a>
                                    <a class="dropdown-item" href="{{ route('property.index') }}">Properties</a>
                                    <a class="dropdown-item" href="{{ route('tenants.index') }}">Tenants</a>
                                    <a class="dropdown-item" href="{{ route('maintenance.index') }}">Maintenance</a>
                                    <a class="dropdown-item" href="{{ route('settings.billing.index') }}">Billing</a>
                                    <a class="dropdown-item" href="{{ route('users.index') }}">User Management</a>
                                    <a class="dropdown-item" href="{{ route('feedback.index') }}">Customer Feedback</a>

                                @elseif(Auth::user()->role === 10)
                                <!-- TRAVIS -->
                                    <a class="dropdown-item" href="{{ route('community.index') }}">Communities</a>
                                    <a class="dropdown-item" href="{{ route('property.index') }}">Properties</a>
                                    <a class="dropdown-item" href="{{ route('tenants.index') }}">Tenants</a>
                                    <a class="dropdown-item" href="{{ route('maintenance.index') }}">Maintenance</a>
                                    <a class="dropdown-item" href="{{ route('settings.billing.index') }}">Billing</a>
                                    <a class="dropdown-item" href="{{ route('users.index') }}">User Management</a>
                                    <a class="dropdown-item" href="{{ route('feedback.index') }}">Customer Feedback</a>
                                @endif                                   

                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
