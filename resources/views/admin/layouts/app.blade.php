<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel')</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Nunito', sans-serif; }
        #wrapper { display: flex; }
        #content-wrapper { background-color: #f8f9fc; width: 100%; overflow-x: hidden; }
        #content { flex: 1; }
        .sidebar { min-height: 100vh; width: 250px; background: linear-gradient(180deg, #4e73df 10%, #224abe 100%); }
        .sidebar .nav-link { color: rgba(255,255,255,.8); padding: 1rem; }
        .sidebar .nav-link:hover { color: #fff; }
        .sidebar .nav-link.active { color: #fff; font-weight: 700; }
    </style>
    @stack('styles')
</head>
<body id="page-top">
    <div id="wrapper">
        <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
                <div class="sidebar-brand-text mx-3">Admin Panel</div>
            </a>
            <hr class="sidebar-divider my-0">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <hr class="sidebar-divider">
            <div class="sidebar-heading">Catalog</div>
            <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-fw fa-folder"></i> <span>Categories</span></a></li>
            <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-fw fa-sitemap"></i> <span>Subcategories</span></a></li>
            <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-fw fa-box"></i> <span>Products</span></a></li>
            <hr class="sidebar-divider">
            <div class="sidebar-heading">Sales</div>
            <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-fw fa-shopping-cart"></i> <span>Orders</span></a></li>
            <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-fw fa-users"></i> <span>Customers</span></a></li>
            <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-fw fa-tag"></i> <span>Coupons</span></a></li>
        </ul>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Admin User</span>
                                <i class="fas fa-user-circle fa-lg"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in">
                                <a class="dropdown-item" href="#"><i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i> Profile</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> Logout
                                </a>
                                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    </ul>
                </nav>

                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>

            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; E-commerce Admin {{ date('Y') }}</span>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    @stack('scripts')
</body>
</html>
