<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Vyuga Admin Panel')</title>

    <!-- Offline CSS -->
    <link href="{{ asset('admin/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('admin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <style>
        body { font-family: 'Nunito', sans-serif; }
        #wrapper { display: flex; }
        #content-wrapper { background-color: #f8f9fc; width: 100%; overflow-x: hidden; }
        #content { flex: 1; }
        .sidebar { min-height: 100vh; width: 250px; background: linear-gradient(180deg, #4e73df 10%, #224abe 100%); transition: all 0.3s; }
        .sidebar.toggled { width: 70px; }
        .sidebar .nav-link { color: rgba(255,255,255,.8); padding: 1rem; display: flex; align-items: center; }
        .sidebar .nav-link:hover { color: #fff; }
        .sidebar .nav-link.active { color: #fff; font-weight: 700; }
        .sidebar.toggled .nav-link span { display: none; }
        .sidebar.toggled .nav-link i { display: block !important; margin-right: 0; }
        @media (max-width: 768px) {
            .sidebar { width: 70px; }
            .sidebar .nav-link span { display: none; }
            .sidebar .nav-link i { display: block !important; margin-right: 0; }
        }
    </style>
    @stack('styles')
</head>
<body id="page-top">
    <div id="wrapper">
        @include('admin.layouts.partials.sidebar')

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                @include('admin.layouts.partials.topbar')

                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>

            @include('admin.layouts.partials.footer')
        </div>
    </div>

    <!-- Scroll to Top Button -->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ready to Leave?</h5>
                    <button class="close" type="button" data-bs-dismiss="modal">
                        <span>×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <a class="btn btn-primary" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Offline JavaScript -->
    <script src="{{ asset('admin/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('admin/js/sb-admin-2.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/chart.js/chart.min.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Bootstrap dropdowns
            var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'));
            dropdownElementList.forEach(function(dropdownToggleEl) {
                new bootstrap.Dropdown(dropdownToggleEl);
            });

            // Sidebar toggle functionality
            document.getElementById('sidebarToggleTop').addEventListener('click', function() {
                document.getElementById('accordionSidebar').classList.toggle('toggled');
                const navLinks = document.querySelectorAll('.nav-link');
                navLinks.forEach(link => {
                    link.style.display = 'flex';
                    link.querySelector('i').style.display = 'block';
                });
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
