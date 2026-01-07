<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Travel Tacker</title>
    <link href="{{ asset ('images/cos.ico') }}" rel="icon" type="image/x-icon">
    <link href="{{ asset ('css/tabler.css') }}" rel="stylesheet"/>
    <link href="{{ asset ('css/tracker.css') }}" rel="stylesheet"/>
    <link href="{{ asset ('css/font-awesome/all.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset ('css/select2.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset ('css/datatable/dataTables.css') }}" rel="stylesheet"/>
    <link href="{{ asset ('css/datatable/buttons.dataTables.css') }}" rel="stylesheet"/>
    <link href="{{ asset ('css/notyf.min.css') }}" rel="stylesheet"/>
</head>
<body>
<!-- Page Loader -->
<div id="pageLoader">
    <div class="text-center">
        <div class="airplane">✈️</div>
        <h3 class="mt-3 text-primary fw-bold">Travel Tracker</h3>
        <div class="spinner-border text-primary mt-3" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
</div>
<div class="page" id="all-contents">


    <!-- Main Content -->
    <div id="content">
        <!-- Sidebar -->
        <nav id="sidebar">
            <div class="brand-section">
                <h4 class="mb-0">
                    <svg fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M21 16v-2l-8-5V3.5c0-.83-.67-1.5-1.5-1.5S10 2.67 10 3.5V9l-8 5v2l8-2.5V19l-2 1.5V22l3.5-1 3.5 1v-1.5L13 19v-5.5l8 2.5z"/>
                    </svg>
                    Travel Tracker
                </h4>
                <small>Employee Management</small>
            </div>

            <ul class="nav flex-column mt-3">
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('dashboard') }}" data-section="dashboard">
                        <svg fill="currentColor" viewBox="0 0 24 24">
                            <path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/>
                        </svg>
                        Dashboard
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#employeesMenu">
                        <svg fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>
                        </svg>
                        Employees
                        <svg class="ms-auto" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path
                                d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
                        </svg>
                    </a>
                    <ul class="nav flex-column collapse submenu" id="employeesMenu">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('employees') }}" data-section="all-employees">
                                <svg fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M3 13h2v-2H3v2zm0 4h2v-2H3v2zm0-8h2V7H3v2zm4 4h14v-2H7v2zm0 4h14v-2H7v2zM7 7v2h14V7H7z"/>
                                </svg>
                                All Employees
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('employee_add') }}" data-section="add-employee">
                                <svg fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M15 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm-9-2V7H4v3H1v2h3v3h2v-3h3v-2H6zm9 4c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                </svg>
                                Add Employee
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- Top Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4 rounded">
            <div class="container-fluid">
                <button class="btn btn-outline-primary d-md-none" type="button" id="sidebarToggle">
                    <i class="bi bi-list"></i>
                </button>
                <form class="d-flex mx-auto" style="max-width: 500px; width: 100%;">
                </form>
                <div class="dropdown">
                    @auth
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0d6efd&color=fff"
                                 class="rounded-circle me-2" width="35" height="35" alt="{{ Auth::user()->name }}">
                            <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                        </a>
                    @endauth
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-3 py-2">
                        <li>
                            <a class="dropdown-item d-flex align-items-center py-2" href="{{ route('profile.edit') }}">
                                <i class="fas fa-user-circle fa-lg text-primary me-3"></i>
                                <span>Profile</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center py-2" href="#">
                                <i class="fas fa-cog fa-lg text-secondary me-3"></i>
                                <span>Settings</span>
                            </a>
                        </li>
                        <li><hr class="dropdown-divider my-2"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST" class="m-0">
                                @csrf
                                <button class="dropdown-item d-flex align-items-center text-danger py-2" type="submit">
                                    <i class="fas fa-sign-out-alt fa-lg me-3"></i>
                                    <span>Logout</span>
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        @yield('main-content')
    </div>
</div>
<script>
    window.appConfig = {
        csrfToken: '{{ csrf_token() }}',
        logoutUrl: '{{ route('logout') }}',
        loginUrl: '{{ route('login') }}'
    };
</script>

<script src="{{ asset ('js/tabler.min.js') }}"></script>
<script src="{{ asset ('js/tabler-theme.min.js') }}"></script>
<script src="{{ asset ('js/font-awesome/all.min.js') }}"></script>
<script src="{{ asset ('js/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('js/select2.min.js') }}"></script>
<script src="{{ asset ('js/swal.js') }}"></script>
<script src="{{ asset ('js/notyf.min.js') }}"></script>
<script src="{{ asset ('js/extra/notfy_setting.js') }}"></script>
<script src="{{ asset ('js/external.js') }}"></script>
<script src="{{ asset ('js/sidebar/sidebar.js') }}"></script>
<script src="{{ asset ('js/datatable/dataTables.js') }}"></script>
<script src="{{ asset ('js/datatable/dataTables.buttons.js') }}"></script>
<script src="{{ asset ('js/datatable/buttons.dataTables.js') }}"></script>
<script src="{{ asset ('js/datatable/jszip.min.js')}}"></script>
<script src="{{ asset ('js/datatable/pdfmake.min.js') }}"></script>
<script src="{{ asset ('js/datatable/vfs_fonts.js') }}"></script>
<script src="{{ asset ('js/datatable/buttons.html5.min.js') }}"></script>
<script src="{{ asset ('js/datatable/buttons.print.min.js') }}"></script>
<script src="{{ asset ('js/table/datatables.js') }}"></script>
<script>
    // Hide loader when page is fully loaded
    window.addEventListener('load', function() {
        setTimeout(function() {
            const loader = document.getElementById('pageLoader');
            loader.classList.add('fade-out');
            setTimeout(function() {
                loader.style.display = 'none';
            }, 500);
        }, 1000); // Show loader for at least 1 second
    });
</script>
</body>
</html>
