<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Civil Tacker</title>
    <link href="{{ asset ('images/cos.ico') }}" rel="icon" type="image/x-icon">
    <link href="{{ asset ('css/tabler.css') }}" rel="stylesheet"/>
    <link href="{{ asset ('css/tracker.css') }}" rel="stylesheet"/>
    <link href="{{ asset ('css/font-awesome/all.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset ('css/select2.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset ('css/datatable/dataTables.css') }}" rel="stylesheet"/>
    <link href="{{ asset ('css/datatable/buttons.dataTables.css') }}" rel="stylesheet"/>
</head>
<body>
<div class="loader-overlay" id="site-loader">
    <div class="loader"></div>
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
                    <a class="nav-link active" href="#" data-section="dashboard">
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
                            <a class="nav-link" href="#" data-section="all-employees">
                                <svg fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M3 13h2v-2H3v2zm0 4h2v-2H3v2zm0-8h2V7H3v2zm4 4h14v-2H7v2zm0 4h14v-2H7v2zM7 7v2h14V7H7z"/>
                                </svg>
                                All Employees
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-section="traveling">
                                <svg fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                                </svg>
                                Currently Traveling
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-section="add-employee">
                                <svg fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M15 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm-9-2V7H4v3H1v2h3v3h2v-3h3v-2H6zm9 4c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                </svg>
                                Add Employee
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#assignmentsMenu">
                        <svg fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M14 6V4h-4v2h4zM4 8v11h16V8H4zm16-2c1.11 0 2 .89 2 2v11c0 1.11-.89 2-2 2H4c-1.11 0-2-.89-2-2l.01-11c0-1.11.88-2 1.99-2h4V4c0-1.11.89-2 2-2h4c1.11 0 2 .89 2 2v2h4z"/>
                        </svg>
                        Assignments
                        <svg class="ms-auto" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path
                                d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
                        </svg>
                    </a>
                    <ul class="nav flex-column collapse submenu" id="assignmentsMenu">
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-section="active-assignments">
                                <svg fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                </svg>
                                Active Assignments
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-section="assignment-history">
                                <svg fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M13 3c-4.97 0-9 4.03-9 9H1l3.89 3.89.07.14L9 12H6c0-3.87 3.13-7 7-7s7 3.13 7 7-3.13 7-7 7c-1.93 0-3.68-.79-4.94-2.06l-1.42 1.42C8.27 19.99 10.51 21 13 21c4.97 0 9-4.03 9-9s-4.03-9-9-9zm-1 5v5l4.28 2.54.72-1.21-3.5-2.08V8H12z"/>
                                </svg>
                                Assignment History
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-section="create-assignment">
                                <svg fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm5 11h-4v4h-2v-4H7v-2h4V7h2v4h4v2z"/>
                                </svg>
                                Create Assignment
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#documentsMenu">
                        <svg fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/>
                        </svg>
                        Documents
                        <svg class="ms-auto" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path
                                d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
                        </svg>
                    </a>
                    <ul class="nav flex-column collapse submenu" id="documentsMenu">
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-section="appointment-letters">
                                <svg fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M9 11H7v2h2v-2zm4 0h-2v2h2v-2zm4 0h-2v2h2v-2zm2-7h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V9h14v11z"/>
                                </svg>
                                Appointment Letters
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-section="reports">
                                <svg fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/>
                                </svg>
                                Reports Uploaded
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-section="upload-document">
                                <svg fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M19.35 10.04C18.67 6.59 15.64 4 12 4 9.11 4 6.6 5.64 5.35 8.04 2.34 8.36 0 10.91 0 14c0 3.31 2.69 6 6 6h13c2.76 0 5-2.24 5-5 0-2.64-2.05-4.78-4.65-4.96zM14 13v4h-4v-4H7l5-5 5 5h-3z"/>
                                </svg>
                                Upload Document
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#" data-section="countries">
                        <svg fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/>
                        </svg>
                        Countries
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#reportsMenu">
                        <svg fill="currentColor" viewBox="0 0 24 24">
                            <path d="M5 9.2h3V19H5zM10.6 5h2.8v14h-2.8zm5.6 8H19v6h-2.8z"/>
                        </svg>
                        Analytics
                        <svg class="ms-auto" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path
                                d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
                        </svg>
                    </a>
                    <ul class="nav flex-column collapse submenu" id="reportsMenu">
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-section="travel-report">
                                <svg fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M16 6l2.29 2.29-4.88 4.88-4-4L2 16.59 3.41 18l6-6 4 4 6.3-6.29L22 12V6z"/>
                                </svg>
                                Travel Statistics
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-section="expense-report">
                                <svg fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z"/>
                                </svg>
                                Expense Reports
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item mt-3">
                    <a class="nav-link" href="#" data-section="settings">
                        <svg fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M19.14 12.94c.04-.3.06-.61.06-.94 0-.32-.02-.64-.07-.94l2.03-1.58c.18-.14.23-.41.12-.61l-1.92-3.32c-.12-.22-.37-.29-.59-.22l-2.39.96c-.5-.38-1.03-.7-1.62-.94l-.36-2.54c-.04-.24-.24-.41-.48-.41h-3.84c-.24 0-.43.17-.47.41l-.36 2.54c-.59.24-1.13.57-1.62.94l-2.39-.96c-.22-.08-.47 0-.59.22L2.74 8.87c-.12.21-.08.47.12.61l2.03 1.58c-.05.3-.09.63-.09.94s.02.64.07.94l-2.03 1.58c-.18.14-.23.41-.12.61l1.92 3.32c.12.22.37.29.59.22l2.39-.96c.5.38 1.03.7 1.62.94l.36 2.54c.05.24.24.41.48.41h3.84c.24 0 .44-.17.47-.41l.36-2.54c.59-.24 1.13-.56 1.62-.94l2.39.96c.22.08.47 0 .59-.22l1.92-3.32c.12-.22.07-.47-.12-.61l-2.01-1.58zM12 15.6c-1.98 0-3.6-1.62-3.6-3.6s1.62-3.6 3.6-3.6 3.6 1.62 3.6 3.6-1.62 3.6-3.6 3.6z"/>
                        </svg>
                        Settings
                    </a>
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
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button"
                       data-bs-toggle="dropdown">
                        <img src="https://ui-avatars.com/api/?name=Admin+User&background=0d6efd&color=fff"
                             class="rounded-circle me-2" width="35" height="35" alt="User">
                        <span class="d-none d-md-inline">Admin User</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i> Profile</a></li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i> Settings</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button class="dropdown-item" type="submit">Logout</button>
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
    window.addEventListener('load', () => {
        document.getElementById('site-loader').style.display = 'none';
        document.getElementById('all-contents').style.display = 'block';
    });
</script>
</body>
</html>
