<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>@yield('title')</title>

    @stack('prepend-style')
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
    <link href="/style/main.css" rel="stylesheet" />
    @stack('addon-style')

</head>

<body>
    <div class="page-dashboard">
        <div class="d-flex" id="wrapper" data-aos="fade-right">
            <!-- Sidebar -->
            <div class="border-right" id="sidebar-wrapper">
                <div class="sidebar-heading text-center">
                    <a href="{{ route('home') }}">
                        <img src="/images/dashboard-store-logo.svg" alt="" class="my-4" />
                    </a>
                </div>
                <div class="list-group list-group-flush">
                    <a href="{{ route('dashboard') }}"
                        class="list-group-item list-group-item-action {{ request()->is('dashboard') ? 'active' : '' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('dashboard-product') }}"
                        class="list-group-item list-group-item-action {{ request()->is('dashboard/products*') ? 'active' : '' }}">
                        My Products
                    </a>
                    <a href="{{ route('dashboard-transaction') }}"
                        class="list-group-item list-group-item-action {{ request()->is('dashboard/transactions*') ? 'active' : '' }}">
                        Transactions
                    </a>
                    <a href="{{ route('dashboard-setting-store') }}"
                        class="list-group-item list-group-item-action {{ request()->is('dashboard/store/setting*') ? 'active' : '' }}">
                        Store Setting
                    </a>
                    <a href="{{ route('dashboard-setting-account') }}"
                        class="list-group-item list-group-item-action {{ request()->is('dashboard/account*') ? 'active' : '' }}">
                        My Account
                    </a>
                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                        class="list-group-item list-group-item-action">
                        Sign Out
                    </a>
                </div>
            </div>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
            <!-- Page Content -->
            <div id="page-content-wrapper">
                <!-- navbar -->
                <nav class="navbar navbar-expand-lg navbar-light navbar-store fixed-top" data-aos="fade-down"
                    aria-label="navbar">
                    <div class="container-fluid">
                        <button class="btn btn-secondary d-md-none mr-auto mr-2" id="menu-toggle">
                            &laquo; Menu
                        </button>
                        <button class="navbar-toggler" type="button" data-toggle="collapse"
                            data-target="#navbarSupportedContent">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <!-- Desktop menu -->
                            <ul class="navbar-nav d-none d-lg-flex ml-auto">
                                <li class="nav-item dropdown">
                                    <a href="#" class="nav-link mt-2" id="navbarDropdown" role="button"
                                        data-toggle="dropdown">
                                        <strong>
                                            Hi, {{ Auth::user()->name }}
                                        </strong>
                                    </a>
                                    <div class="dropdown-menu">
                                        <a href="{{ route('home') }}" class="dropdown-item">Home</a>
                                        {{-- <a href="{{ route('dashboard-setting-account') }}"
                                                class="dropdown-item">Setting</a>
                                            <div class="dropdown-divider"></div>
                                            <a href="{{ route('logout') }}"
                                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                                class="dropdown-item">Logout</a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                class="d-none">
                                                @csrf
                                            </form> --}}
                                    </div>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('cart') }}" class="nav-link d-inline-block mt-2">
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
                            </ul>

                            <!-- Mobile Menu -->
                            <ul class="navbar-nav d-block d-lg-none">
                                <li class="nav-item">
                                    <a class="nav-link" href="#"> Hi, {{ Auth::user()->name }} </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('home') }}"> Home </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link d-inline-block" href="{{ route('cart') }}"> Cart </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>

                {{-- Content --}}
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript -->
    @stack('prepend-script')
    <script src="/vendor/jquery/jquery.slim.min.js"></script>
    <script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
    <script>
        $("#menu-toggle").click(function(e) {
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");
        });
    </script>
    <script src="/script/navbar-scroll.js"></script>
    @stack('addon-script')
</body>

</html>
