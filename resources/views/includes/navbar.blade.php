<nav class="navbar navbar-expand-lg navbar-light navbar-store fixed-top navbar-fixed-top" data-aos="fade-down">
    <div class="container">
        <a href="{{ route('home') }}" class="navbar-brand">
            <img src="/images/logo.svg" alt="" />
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a href="{{ route('home') }}" class="nav-link {{ request()->is('/') ? 'active' : '' }}">Home</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('categories') }}"
                        class="nav-link {{ request()->is('categories*') ? 'active' : '' }}">Categories</a>
                </li>
                <li class="nav-item mr-3">
                    <form action="{{ route('search') }}" method="GET"enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-9 col-md-9">
                                <input type="text" name="search" class="form-control" placeholder="Search dong..">
                            </div>
                            <div>
                                <button class="btn btn-success">Search</button>
                            </div>
                        </div>
                    </form>
                </li>
                @guest
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="nav-link"><strong>Login</strong></a>
                    </li>
                @endguest

                @auth
                    <!-- Desktop menu -->
                    <li class="nav-item dropdown d-none d-lg-flex">
                        <div class="nav-link" id="navbarDropdown" role="button" data-toggle="dropdown">
                            Hi, {{ Auth::user()->name }}
                        </div>
                        <div class="dropdown-menu">
                            <a href="{{ route('dashboard') }}" class="dropdown-item">Dashboard</a>
                            <a href="{{ route('dashboard-setting-account') }}" class="dropdown-item">Setting</a>
                            <div class="dropdown-divider"></div>
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();"
                                class="dropdown-item">Logout</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>

                        </div>
                    </li>
                    <li class="nav-item d-none d-lg-flex">
                        <a href="{{ route('cart') }}" class="nav-link d-inline-block">
                            @php
                                $carts = App\Models\Cart::where('users_id', Auth::user()->id)
                                    ->select(DB::raw('sum(qty) as qty'), DB::raw('products_id '), DB::raw('stores_id'))
                                    ->groupBy(['products_id', 'stores_id'])
                                    ->get()
                                    ->count();
                            @endphp
                            @if ($carts > 0)
                                <img src="/images/icon-cart-filled.svg" alt="" />
                                <div class="card-badge">{{ $carts }}</div>
                            @else
                                <img src="/images/icon-cart-empty.svg" alt="" />
                            @endif
                        </a>
                    </li>

                    <!-- Mobile Menu -->
                    <li class="nav-item dropdown d-block d-lg-none">
                        <a href="#" class="nav-link dropdown-toggle" id="navbarDropdown" role="button"
                            data-toggle="dropdown"> Hi,
                            {{ Auth::user()->name }} </a>
                        <div class="dropdown-menu" style="border: 0px;outline: 0px;">
                            <a class="dropdown-item " href="{{ route('dashboard') }}"> Dashboard </a>
                            <a class="dropdown-item" href="{{ route('cart') }}"> Cart </a>
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();"
                                class="dropdown-item">Logout</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
