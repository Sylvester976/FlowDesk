<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'FlowDesk') }} &mdash; @yield('title', 'Dashboard')</title>

    <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap"
          rel="stylesheet">

    {{-- Vendors --}}
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/flatpickr/flatpickr.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/choices.js/choices.min.css') }}" rel="stylesheet">

    {{-- Main CSS --}}
    <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">

    @livewireStyles
    @stack('styles')
</head>

<body>

{{-- ===== HEADER ===== --}}
<header class="header">
    <div class="header-left">
        <a href="{{ route('dashboard') }}" class="header-logo">
            <img src="{{ asset('assets/img/logo.webp') }}" alt="FlowDesk">
            <span>FlowDesk</span>
        </a>
        <button class="sidebar-toggle" title="Toggle Sidebar">
            <i class="bi bi-list"></i>
        </button>
    </div>

    <div class="header-right">
        {{-- Notifications --}}
        <div class="header-action dropdown notifications-dropdown">
            <button class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" title="Notifications">
                <i class="bi bi-bell"></i>
                {{-- Badge only shows if there are pending items --}}
                @if(auth()->user()->hasPendingPostTripUploads())
                    <span class="badge bg-danger badge-dot"></span>
                @endif
            </button>
            <div class="dropdown-menu dropdown-menu-end notifications-dropdown-menu">
                <div class="notifications-dropdown-header">
                    <h6>Notifications</h6>
                </div>
                <div class="notifications-dropdown-body">
                    @if(auth()->user()->hasPendingPostTripUploads())
                        <a href="{{ route('travel.post-trip') }}" class="notification-item">
                            <div class="notification-icon bg-warning-subtle text-warning">
                                <i class="bi bi-upload"></i>
                            </div>
                            <div class="notification-content">
                                <p class="notification-text">Post-trip documents pending</p>
                                <span class="notification-time">Action required before new application</span>
                            </div>
                        </a>
                    @else
                        <p class="text-muted text-center small py-3">No new notifications</p>
                    @endif
                </div>
            </div>
        </div>

        {{-- User menu --}}
        <div class="header-action dropdown user-dropdown">
            <button class="dropdown-toggle user-dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="user-avatar">
                    @if(auth()->user()->profile_photo)
                        <img src="{{ Storage::url(auth()->user()->profile_photo) }}"
                             alt="{{ auth()->user()->full_name }}">
                    @else
                        <span>{{ strtoupper(app-layout.blade.phpsubstr(auth()->user()->first_name, 0, 1) . substr(auth()->user()->last_name, 0, 1)) }}</span>
                    @endif
                </div>
                <div class="user-info d-none d-md-block">
                    <span class="user-name">{{ auth()->user()->full_name }}</span>
                    <span class="user-role">{{ auth()->user()->role?->label }}</span>
                </div>
            </button>
            <div class="dropdown-menu dropdown-menu-end user-dropdown-menu">
                <div class="user-dropdown-header">
                    <p class="user-dropdown-name">{{ auth()->user()->full_name }}</p>
                    <p class="user-dropdown-email">{{ auth()->user()->email }}</p>
                </div>
                <a href="{{ route('profile.edit') }}" class="dropdown-item">
                    <i class="bi bi-person"></i> My Profile
                </a>
                <a href="{{ route('travel.index') }}" class="dropdown-item">
                    <i class="bi bi-airplane"></i> My Applications
                </a>
                <div class="dropdown-divider"></div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item text-danger">
                        <i class="bi bi-box-arrow-right"></i> Sign Out
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>

{{-- ===== SIDEBAR ===== --}}
<aside class="sidebar" id="sidebar">
    <nav class="sidebar-nav">
        <ul class="sidebar-nav-list">

            {{-- Dashboard --}}
            <li class="sidebar-nav-item">
                <a href="{{ route('dashboard') }}"
                   class="sidebar-nav-link {{ request()->routeIs('dashboard*') ? 'active' : '' }}">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            {{-- Travel --}}
            <li class="sidebar-nav-item sidebar-nav-group">
                <span class="sidebar-nav-group-label">Travel</span>
            </li>

            <li class="sidebar-nav-item">
                <a href="{{ route('travel.index') }}"
                   class="sidebar-nav-link {{ request()->routeIs('travel.index') ? 'active' : '' }}">
                    <i class="bi bi-airplane-engines"></i>
                    <span>My Applications</span>
                </a>
            </li>

            <li class="sidebar-nav-item">
                <a href="{{ route('travel.create') }}"
                   class="sidebar-nav-link {{ request()->routeIs('travel.create') ? 'active' : '' }}">
                    <i class="bi bi-plus-circle"></i>
                    <span>New Application</span>
                </a>
            </li>

            @if(auth()->user()->isSupervisor())
                <li class="sidebar-nav-item">
                    <a href="{{ route('travel.concurrence') }}"
                       class="sidebar-nav-link {{ request()->routeIs('travel.concurrence') ? 'active' : '' }}">
                        <i class="bi bi-check2-square"></i>
                        <span>Concurrence Queue</span>
                    </a>
                </li>
            @endif

            @if(auth()->user()->canViewAllApplications())
                {{-- PS / Admin oversight --}}
                <li class="sidebar-nav-item sidebar-nav-group">
                    <span class="sidebar-nav-group-label">Oversight</span>
                </li>

                <li class="sidebar-nav-item">
                    <a href="{{ route('oversight.all-applications') }}"
                       class="sidebar-nav-link {{ request()->routeIs('oversight.all-applications') ? 'active' : '' }}">
                        <i class="bi bi-journal-text"></i>
                        <span>All Applications</span>
                    </a>
                </li>

                <li class="sidebar-nav-item">
                    <a href="{{ route('oversight.out-of-office') }}"
                       class="sidebar-nav-link {{ request()->routeIs('oversight.out-of-office') ? 'active' : '' }}">
                        <i class="bi bi-person-walking"></i>
                        <span>Out of Office</span>
                    </a>
                </li>

                <li class="sidebar-nav-item">
                    <a href="{{ route('oversight.docket') }}"
                       class="sidebar-nav-link {{ request()->routeIs('oversight.docket') ? 'active' : '' }}">
                        <i class="bi bi-calendar2-range"></i>
                        <span>Days Docket</span>
                    </a>
                </li>
            @endif

            @if(auth()->user()->canViewOutOfOffice() && ! auth()->user()->canViewAllApplications())
                {{-- HR can see out of office but not everything --}}
                <li class="sidebar-nav-item sidebar-nav-group">
                    <span class="sidebar-nav-group-label">HR Oversight</span>
                </li>
                <li class="sidebar-nav-item">
                    <a href="{{ route('oversight.out-of-office') }}"
                       class="sidebar-nav-link {{ request()->routeIs('oversight.out-of-office') ? 'active' : '' }}">
                        <i class="bi bi-person-walking"></i>
                        <span>Out of Office</span>
                    </a>
                </li>
            @endif

            @if(auth()->user()->canManageUsers())
                {{-- Admin / HR --}}
                <li class="sidebar-nav-item sidebar-nav-group">
                    <span class="sidebar-nav-group-label">Administration</span>
                </li>

                <li class="sidebar-nav-item">
                    <a href="{{ route('admin.staff.index') }}"
                       class="sidebar-nav-link {{ request()->routeIs('admin.staff*') ? 'active' : '' }}">
                        <i class="bi bi-people"></i>
                        <span>Staff Management</span>
                    </a>
                </li>

                <li class="sidebar-nav-item">
                    <a href="{{ route('admin.org.index') }}"
                       class="sidebar-nav-link {{ request()->routeIs('admin.org*') ? 'active' : '' }}">
                        <i class="bi bi-diagram-3"></i>
                        <span>Org Structure</span>
                    </a>
                </li>

                @if(auth()->user()->canAssignRoles())
                    <li class="sidebar-nav-item">
                        <a href="{{ route('admin.roles.index') }}"
                           class="sidebar-nav-link {{ request()->routeIs('admin.roles*') ? 'active' : '' }}">
                            <i class="bi bi-shield-check"></i>
                            <span>Roles & Hierarchy</span>
                        </a>
                    </li>
                @endif
            @endif

            {{-- Reference --}}
            <li class="sidebar-nav-item sidebar-nav-group">
                <span class="sidebar-nav-group-label">Reference</span>
            </li>

            <li class="sidebar-nav-item">
                <a href="{{ route('travel.rates') }}"
                   class="sidebar-nav-link {{ request()->routeIs('travel.rates') ? 'active' : '' }}">
                    <i class="bi bi-currency-dollar"></i>
                    <span>Travel Rates</span>
                </a>
            </li>

        </ul>
    </nav>
</aside>

{{-- ===== MAIN CONTENT ===== --}}
<main class="main">
    {{ $slot }}
</main>

{{-- ===== SCRIPTS ===== --}}
<script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
<script src="{{ asset('assets/vendor/flatpickr/flatpickr.min.js') }}"></script>
<script src="{{ asset('assets/vendor/choices.js/choices.min.js') }}"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>

@livewireScripts

{{-- Re-init template JS after Livewire navigations --}}
<script>
    document.addEventListener('livewire:navigated', () => {
        if (typeof initChoices === 'function') initChoices();
        if (typeof initFlatpickr === 'function') initFlatpickr();
    });
</script>

@stack('scripts')

</body>
</html>
