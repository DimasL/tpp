<nav class="navbar navbar-default">
    <div class="container">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ url('/') }}">
                Home
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav">
                <li class="@yield('categories_active')"><a href="{{ url('categories') }}">Categories</a></li>
                <li class="@yield('products_active')"><a href="{{ url('products') }}">Products</a></li>
                @if(Auth::check())
                    <li class="@yield('users_active')"><a href="{{ url('users') }}">Users</a></li>
                    <li class="@yield('mysubscriptions_active')"><a href="{{ url('mysubscriptions') }}">My
                            Subscriptions</a></li>
                    <li class="@yield('subscriptions_active')"><a href="{{ url('subscriptions') }}">Subscriptions</a>
                    </li>
                    @if(in_array('admin', Auth::user()->roles()->lists('slug')->toArray()))
                        <li class="@yield('logs_active')"><a href="{{ url('logs') }}">Logs</a></li>
                    @endif
                @endif

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @if (Auth::guest())
                    <li><a href="{{ url('/login') }}">Login</a></li>
                    <li><a href="{{ url('/register') }}">Register</a></li>
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            <img class="img-responsive img-circle" src="{{Auth::user()->getImage()}}" alt="avatar">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ url('/profile') }}"><i class="fa fa-btn fa-user"></i> Profile</a></li>
                            <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i> Logout</a></li>
                        </ul>
                    </li>
                @endif
            </ul>

            <div class="col-sm-3 col-md-3 pull-right">
                <form class="navbar-form" role="search" action="{{url('search')}}">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search" name="srch" id="srch">
                        <div class="input-group-btn">
                            <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</nav>