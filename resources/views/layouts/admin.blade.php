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
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.12.1/datatables.min.css" />
    @stack('addon-style')
</head>

<body>
    <div class="page-dashboard">
        <div class="d-flex" id="wrapper" data-aos="fade-right">
            <!-- Sidebar -->
            <div class="border-right" id="sidebar-wrapper">
                <div class="sidebar-heading text-center">
                    <img src="/images/admin.png" alt="" class="my-4" style="max-width: 150px" />
                </div>
                <div class="list-group list-group-flush">
                    <a href="{{ route('superadmin-dashboard') }}"
                        class="list-group-item list-group-item-action {{ request()->is('superadmin') ? 'active' : '' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('product.index') }}"
                        class="list-group-item list-group-item-action {{ request()->is('superadmin/product*') ? 'active' : '' }}">
                        Products
                    </a>
                    <a href="{{ route('gallery-products.index') }}"
                        class="list-group-item list-group-item-action {{ request()->is('superadmin/gallery-products*') ? 'active' : '' }}">
                        Galleries
                    </a>
                    <a href="{{ route('category.index') }}"
                        class="list-group-item list-group-item-action {{ request()->is('superadmin/category*') ? 'active' : '' }}">
                        Categories
                    </a>
                    <a href="{{ route('transaction.index') }}"
                        class="list-group-item list-group-item-action {{ request()->is('superadmin/transaction*') ? 'active' : '' }}">
                        Transaction
                    </a>
                    <a href="{{ route('user.index') }}"
                        class="list-group-item list-group-item-action {{ request()->is('superadmin/user*') ? 'active' : '' }}">
                        Users
                    </a>
                    <a href="{{ route('store.index') }}"
                        class="list-group-item list-group-item-action {{ request()->is('superadmin/store*') ? 'active' : '' }}">
                        Stores
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
                        <button class="btn btn-secondary d-md-none ml-auto" id="menu-toggle">
                            &laquo; Menu
                        </button>

                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <!-- Desktop menu -->
                            <ul class="navbar-nav d-none d-lg-flex ml-auto">
                                <li>
                                    <a href="#" class="nav-link mt-2">
                                        <strong>Hi, {{ Auth::user()->name }}</strong>
                                    </a>
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
    <script src="/vendor/jquery/jquery.min.js"></script>
    <script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.12.1/datatables.min.js"></script>
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
