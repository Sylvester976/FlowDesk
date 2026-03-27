<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e(config('app.name', 'FlowDesk')); ?> &mdash; <?php echo $__env->yieldContent('title', 'Dashboard'); ?></title>

    <link href="<?php echo e(asset('assets/img/cos.ico')); ?>" rel="icon">
    <link href="<?php echo e(asset('assets/img/apple-touch-icon.png')); ?>" rel="apple-touch-icon">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

    <link href="<?php echo e(asset('assets/vendor/bootstrap/css/bootstrap.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('assets/vendor/bootstrap-icons/bootstrap-icons.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('assets/vendor/remixicon/remixicon.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('assets/vendor/phosphor-icons/phosphor-icons.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('assets/vendor/simple-datatables/style.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('assets/vendor/flatpickr/flatpickr.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('assets/vendor/choices.js/choices.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('assets/vendor/notie/notie.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('assets/css/main.css')); ?>" rel="stylesheet">

    <style>
        :root {
            --ke-navy:      #1a3a6b;
            --ke-navy-dark: #122850;
            --ke-green:     #006b3f;
            --ke-red:       #bb0000;
            --ke-gold:      #c8a951;
        }

        /* ── Page loader ── */
        #page-loader {
            position: fixed;
            inset: 0;
            background: #fff;
            z-index: 99999;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 18px;
            transition: opacity .4s ease, visibility .4s ease;
        }
        #page-loader.hide { opacity: 0; visibility: hidden; }
        .loader-runway {
            position: relative;
            width: 260px;
            height: 4px;
            background: #e9ecef;
            border-radius: 4px;
            overflow: visible;
        }
        .loader-runway-fill {
            height: 100%;
            border-radius: 4px;
            background: linear-gradient(to right, #1a3a6b, #006b3f);
            animation: runway-fill 1.8s ease-in-out forwards;
        }
        @keyframes runway-fill {
            0%   { width: 0%; }
            100% { width: 100%; }
        }
        .loader-plane {
            position: absolute;
            top: -14px;
            font-size: 1.4rem;
            animation: plane-takeoff 1.8s ease-in-out forwards;
        }
        @keyframes plane-takeoff {
            0%   { left: -5%;  transform: rotate(0deg)   translateY(0); }
            70%  { left: 85%;  transform: rotate(0deg)   translateY(0); }
            100% { left: 105%; transform: rotate(-20deg) translateY(-18px); }
        }
        .loader-logo img { height: 48px; }
        .loader-text { font-size: .82rem; color: #6c757d; letter-spacing: .04em; }

        /* ── Sidebar strip — ALWAYS dark, beat every theme variant ── */
        .sidebar-strip,
        html .sidebar-strip,
        body .sidebar-strip,
        [data-theme] .sidebar-strip,
        [data-theme="light"] .sidebar-strip,
        [data-theme="dark"] .sidebar-strip,
        html[data-bs-theme] .sidebar-strip,
        html[data-bs-theme="light"] .sidebar-strip,
        html[data-bs-theme="dark"] .sidebar-strip,
        body.light-mode .sidebar-strip,
        body.dark-mode .sidebar-strip {
            background: #122850 !important;
            background-color: #122850 !important;
            /* Override the PowerAdmin CSS variables that strip-item uses */
            --sidebar-bg: #122850;
            --muted-color: rgba(255,255,255,0.65);
            --accent-color: rgba(255,255,255,0.9);
            --contrast-color: #ffffff;
        }

        /* Strip buttons and links — always white-ish */
        .sidebar-strip .strip-item {
            background-color: transparent !important;
            color: rgba(255,255,255,.65) !important;
        }
        .sidebar-strip .strip-item i,
        .sidebar-strip .strip-item .ph,
        .sidebar-strip .strip-item [class^="ph-"],
        .sidebar-strip .strip-item [class*=" ph-"],
        .sidebar-strip .strip-item .bi {
            color: rgba(255,255,255,.65) !important;
        }
        .sidebar-strip .strip-item.active,
        .sidebar-strip .strip-item:hover,
        .sidebar-strip button.active,
        .sidebar-strip button:hover {
            background-color: rgba(255,255,255,.14) !important;
            color: #fff !important;
        }
        .sidebar-strip .strip-item.active i,
        .sidebar-strip .strip-item.active .ph,
        .sidebar-strip .strip-item:hover i,
        .sidebar-strip .strip-item:hover .ph {
            color: #fff !important;
        }
        .sidebar-strip-bottom a,
        .sidebar-strip-bottom .strip-item {
            color: rgba(255,255,255,.65) !important;
            background-color: transparent !important;
        }

        /* Kenya flag stripe at top of strip */
        .sidebar-strip::before {
            content: '';
            display: block;
            height: 3px;
            flex-shrink: 0;
            background: linear-gradient(to right,
                #bb0000 0 33.3%,
                #111    33.3% 66.6%,
                #006b3f 66.6% 100%);
        }

        /* Logos — never filtered/greyed */
        .header-logo img,
        .sidebar-strip-logo img,
        .loader-logo img {
            filter: none !important;
            -webkit-filter: none !important;
        }

        /* Panel nav active/hover */
        .panel-link.active { color: #1a3a6b !important; font-weight: 600; }
        .panel-link:hover  { color: #006b3f !important; }

        /* User initials avatar */
        .user-initials-avatar {
            width: 36px; height: 36px;
            border-radius: 50%;
            background: #1a3a6b;
            color: #fff;
            font-size: .75rem;
            font-weight: 700;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }

        /* Notie compact toast */
        .notie-container {
            width: 320px !important;
            position: fixed !important;

            top: 15% !important;
            left: 50% !important;

            transform: translate(-50%, -50%) !important;

            border-radius: 8px !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, .15) !important;
            font-size: .88rem !important;
        }
    </style>

    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>

    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>


<div id="page-loader">
    <div class="loader-logo">
        <img src="<?php echo e(asset('assets/img/logo.png')); ?>" alt="FlowDesk">
    </div>
    <div class="loader-runway">
        <div class="loader-runway-fill"></div>
        <span class="loader-plane">✈</span>
    </div>
    <div class="loader-text">Loading FlowDesk&hellip;</div>
</div>


<header class="header">
    <div class="header-left">
        <a href="<?php echo e(route('dashboard')); ?>" class="header-logo">
            <img src="<?php echo e(asset('assets/img/cos.ico')); ?>" alt="FlowDesk" style="height:34px;width:auto;">
        </a>
        <button class="sidebar-toggle" title="Toggle Sidebar">
            <i class="bi bi-list"></i>
        </button>
    </div>

    <div class="header-search">
        <form class="search-form">
            <i class="bi bi-search search-icon"></i>
            <input type="search" placeholder="Search staff, applications..." autocomplete="off">
            <kbd class="search-shortcut">/</kbd>
        </form>
    </div>

    <div class="header-right">
        <div class="header-actions-desktop">

            
            <button class="header-action theme-toggle" title="Toggle Theme">
                <i class="ph ph-moon theme-icon-dark"></i>
                <i class="ph ph-sun theme-icon-light"></i>
            </button>

            <div class="header-divider"></div>

            
            <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('notification-bell');

$__keyOuter = $__key ?? null;

$__key = null;
$__componentSlots = [];

$__key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-3238548952-0', $__key);

$__html = app('livewire')->mount($__name, $__params, $__key, $__componentSlots);

echo $__html;

unset($__html);
unset($__key);
$__key = $__keyOuter;
unset($__keyOuter);
unset($__name);
unset($__params);
unset($__componentSlots);
unset($__split);
?>

            
            <div class="header-action dropdown user-dropdown">
                <button class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()->profile_photo): ?>
                        <img src="<?php echo e(Storage::url(auth()->user()->profile_photo)); ?>" alt="<?php echo e(auth()->user()->full_name); ?>" class="avatar">
                    <?php else: ?>
                        <div class="user-initials-avatar">
                            <?php echo e(strtoupper(substr(auth()->user()->first_name,0,1).substr(auth()->user()->last_name,0,1))); ?>

                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <div class="user-info">
                        <span class="user-name"><?php echo e(auth()->user()->full_name); ?></span>
                        <span class="user-role"><?php echo e(auth()->user()->role?->label); ?></span>
                    </div>
                    <i class="bi bi-chevron-down user-arrow"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <div class="user-dropdown-header">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()->profile_photo): ?>
                            <img src="<?php echo e(Storage::url(auth()->user()->profile_photo)); ?>" alt="" class="user-dropdown-avatar">
                        <?php else: ?>
                            <div class="user-initials-avatar me-2" style="width:44px;height:44px;font-size:.9rem;">
                                <?php echo e(strtoupper(substr(auth()->user()->first_name,0,1).substr(auth()->user()->last_name,0,1))); ?>

                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <div class="user-dropdown-info">
                            <div class="user-dropdown-name"><?php echo e(auth()->user()->full_name); ?></div>
                            <div class="user-dropdown-email"><?php echo e(auth()->user()->email); ?></div>
                        </div>
                    </div>
                    <div class="user-dropdown-body">
                        <a class="user-dropdown-item" href="<?php echo e(route('profile.edit')); ?>">
                            <i class="bi bi-person"></i><span>My Profile</span>
                        </a>
                        <a class="user-dropdown-item" href="<?php echo e(route('travel.index')); ?>">
                            <i class="bi bi-airplane"></i><span>My Applications</span>
                        </a>
                    </div>
                    <div class="user-dropdown-footer">
                        <form method="POST" action="<?php echo e(route('logout')); ?>">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="user-dropdown-item user-dropdown-logout w-100 border-0 bg-transparent text-start">
                                <i class="bi bi-box-arrow-right"></i><span>Sign Out</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="header-actions-mobile">
            <button class="header-action search-toggle" title="Search">
                <i class="bi bi-search"></i>
            </button>
            <button class="header-action mobile-menu-toggle" title="More">
                <i class="bi bi-three-dots-vertical"></i>
            </button>
        </div>
    </div>
</header>


<div class="mobile-search">
    <form class="search-form">
        <input type="search" placeholder="Search..." autocomplete="off">
        <button type="submit"><i class="bi bi-search"></i></button>
    </form>
</div>


<div class="mobile-header-menu">
    <div class="mobile-header-menu-content">

        
        <button class="mobile-menu-item theme-toggle">
            <i class="ph ph-moon theme-icon-dark"></i>
            <i class="ph ph-sun theme-icon-light"></i>
            <span class="mobile-menu-label">Theme</span>
        </button>

        
        <a href="<?php echo e(route('notifications.index')); ?>" class="mobile-menu-item">
            <i class="bi bi-bell"></i>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()->unreadNotifications()->count() > 0): ?>
                <span class="badge"><?php echo e(auth()->user()->unreadNotifications()->count()); ?></span>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <span class="mobile-menu-label">Notifications</span>
        </a>

        
        <a href="<?php echo e(route('profile.edit')); ?>" class="mobile-menu-item">
            <i class="bi bi-person"></i>
            <span class="mobile-menu-label">Profile</span>
        </a>

        
        <a href="<?php echo e(route('travel.index')); ?>" class="mobile-menu-item">
            <i class="bi bi-airplane"></i>
            <span class="mobile-menu-label">My Applications</span>
        </a>

        
        <form method="POST" action="<?php echo e(route('logout')); ?>" style="display:contents;">
            <?php echo csrf_field(); ?>
            <button type="submit" class="mobile-menu-item mobile-menu-item-danger">
                <i class="bi bi-box-arrow-right"></i>
                <span class="mobile-menu-label">Sign Out</span>
            </button>
        </form>

    </div>
</div>


<aside class="sidebar">

    
    <div class="sidebar-strip">
        <div class="sidebar-strip-logo">
            <a href="<?php echo e(route('dashboard')); ?>">
                <img src="<?php echo e(asset('assets/img/cos.ico')); ?>" alt="FlowDesk" style="height:28px;width:auto;">
            </a>
        </div>

        <nav class="sidebar-strip-nav">
            <ul class="strip-menu">
                <li>
                    <button class="strip-item <?php echo e(request()->routeIs('dashboard*') ? 'active' : ''); ?>"
                        data-panel="main"
                        data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Main">
                        <i class="ph ph-squares-four"></i>
                    </button>
                </li>
                <li>
                    <button class="strip-item <?php echo e(request()->routeIs('travel*') ? 'active' : ''); ?>"
                        data-panel="travel"
                        data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Travel">
                        <i class="ph ph-airplane"></i>
                    </button>
                </li>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()->canViewAllApplications() || auth()->user()->canViewOutOfOffice()): ?>
                <li>
                    <button class="strip-item <?php echo e(request()->routeIs('oversight*') ? 'active' : ''); ?>"
                        data-panel="oversight"
                        data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Oversight">
                        <i class="ph ph-binoculars"></i>
                    </button>
                </li>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()->canManageUsers()): ?>
                <li>
                    <button class="strip-item <?php echo e(request()->routeIs('admin*') ? 'active' : ''); ?>"
                        data-panel="admin"
                        data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Administration">
                        <i class="ph ph-users-three"></i>
                    </button>
                </li>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </ul>
        </nav>

        <div class="sidebar-strip-bottom">
            <a href="<?php echo e(route('travel.rates')); ?>" class="strip-item"
                data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Travel Rates">
                <i class="bi bi-currency-dollar"></i>
            </a>
            <a href="<?php echo e(route('profile.edit')); ?>" class="sidebar-strip-avatar"
                data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="<?php echo e(auth()->user()->full_name); ?>">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()->profile_photo): ?>
                    <img src="<?php echo e(Storage::url(auth()->user()->profile_photo)); ?>" alt="">
                <?php else: ?>
                    <div class="user-initials-avatar" style="width:32px;height:32px;font-size:.7rem;">
                        <?php echo e(strtoupper(substr(auth()->user()->first_name,0,1).substr(auth()->user()->last_name,0,1))); ?>

                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </a>
        </div>
    </div>

    
    <div class="sidebar-panel">

        
        <div class="sidebar-panel-section <?php echo e(request()->routeIs('dashboard*') ? 'active' : ''); ?>" data-section="main">
            <div class="sidebar-panel-header">
                <h6>Main</h6>
                <button class="sidebar-panel-close"><i class="bi bi-x-lg"></i></button>
            </div>
            <ul class="panel-nav">
                <li><a class="panel-link <?php echo e(request()->routeIs('dashboard*') ? 'active' : ''); ?>" href="<?php echo e(route('dashboard')); ?>">Dashboard</a></li>
            </ul>
        </div>

        
        <div class="sidebar-panel-section <?php echo e(request()->routeIs('travel*') ? 'active' : ''); ?>" data-section="travel">
            <div class="sidebar-panel-header">
                <h6>Travel</h6>
                <button class="sidebar-panel-close"><i class="bi bi-x-lg"></i></button>
            </div>
            <ul class="panel-nav">
                <li><a class="panel-link <?php echo e(request()->routeIs('travel.index') ? 'active' : ''); ?>" href="<?php echo e(route('travel.index')); ?>">My Applications</a></li>
                <li><a class="panel-link <?php echo e(request()->routeIs('travel.create') ? 'active' : ''); ?>" href="<?php echo e(route('travel.create')); ?>">New Application</a></li>
                <li><a class="panel-link <?php echo e(request()->routeIs('travel.post-trip') ? 'active' : ''); ?>" href="<?php echo e(route('travel.post-trip')); ?>">
                    Post-Trip Upload
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()->hasPendingPostTripUploads()): ?>
                        <span class="badge bg-danger ms-1" style="font-size:.65rem;">!</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </a></li>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()->isSupervisor()): ?>
                <li><a class="panel-link <?php echo e(request()->routeIs('travel.concurrence') ? 'active' : ''); ?>" href="<?php echo e(route('travel.concurrence')); ?>">Concurrence Queue</a></li>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <li><a class="panel-link <?php echo e(request()->routeIs('travel.rates') ? 'active' : ''); ?>" href="<?php echo e(route('travel.rates')); ?>">Travel Rates</a></li>
            </ul>
        </div>

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()->canViewAllApplications() || auth()->user()->canViewOutOfOffice()): ?>
        <div class="sidebar-panel-section <?php echo e(request()->routeIs('oversight*') ? 'active' : ''); ?>" data-section="oversight">
            <div class="sidebar-panel-header">
                <h6>Oversight</h6>
                <button class="sidebar-panel-close"><i class="bi bi-x-lg"></i></button>
            </div>
            <ul class="panel-nav">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()->canViewAllApplications()): ?>
                <li><a class="panel-link <?php echo e(request()->routeIs('oversight.all-applications') ? 'active' : ''); ?>" href="<?php echo e(route('oversight.all-applications')); ?>">All Applications</a></li>
                <li><a class="panel-link <?php echo e(request()->routeIs('oversight.docket') ? 'active' : ''); ?>" href="<?php echo e(route('oversight.docket')); ?>">Days Docket</a></li>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <li><a class="panel-link <?php echo e(request()->routeIs('oversight.out-of-office') ? 'active' : ''); ?>" href="<?php echo e(route('oversight.out-of-office')); ?>">Out of Office</a></li>
            </ul>
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()->canManageUsers()): ?>
        <div class="sidebar-panel-section <?php echo e(request()->routeIs('admin*') ? 'active' : ''); ?>" data-section="admin">
            <div class="sidebar-panel-header">
                <h6>Administration</h6>
                <button class="sidebar-panel-close"><i class="bi bi-x-lg"></i></button>
            </div>
            <ul class="panel-nav">
                <li><a class="panel-link <?php echo e(request()->routeIs('admin.staff*') ? 'active' : ''); ?>"
                       href="<?php echo e(route('admin.staff.index')); ?>">Staff Management</a></li>
                <li><a class="panel-link <?php echo e(request()->routeIs('admin.org*') ? 'active' : ''); ?>"
                       href="<?php echo e(route('admin.org.index')); ?>">Org Structure</a></li>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()->canAssignRoles()): ?>
                <li><a class="panel-link <?php echo e(request()->routeIs('admin.roles*') ? 'active' : ''); ?>"
                       href="<?php echo e(route('admin.roles.index')); ?>">Roles &amp; Hierarchy</a></li>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()->isSuperAdmin()): ?>
                <li>
                    <a class="panel-link <?php echo e(request()->routeIs('admin.sync') ? 'active' : ''); ?>"
                       href="<?php echo e(route('admin.sync')); ?>">
                        User Service Sync
                        <?php
                            $unsynced = \App\Models\User::whereIn('sync_status', ['pending', 'unlinked'])
                                ->whereNull('deleted_at')->count();
                        ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($unsynced > 0): ?>
                            <span class="badge bg-warning text-dark ms-1"
                                style="font-size:.62rem;"><?php echo e($unsynced); ?></span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </a>
                </li>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </ul>
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    </div>
</aside>

<div class="sidebar-overlay"></div>


<main class="main">
    <div class="main-content">
        <?php echo e($slot); ?>

    </div>

    <footer class="footer">
        <div class="footer-content">
            <div class="footer-links">
                <a href="#">Privacy</a>
                <a href="#">Terms</a>
                <a href="#">Help</a>
            </div>
            <div class="footer-copyright">
                &copy; <?php echo e(date('Y')); ?> Government of Kenya &mdash; State Department of ICT
            </div>
        </div>
    </footer>
</main>

<a href="#" class="back-to-top"><i class="bi bi-arrow-up"></i></a>


<script src="<?php echo e(asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/vendor/simple-datatables/simple-datatables.js')); ?>"></script>
<script src="<?php echo e(asset('assets/vendor/flatpickr/flatpickr.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/vendor/choices.js/choices.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/theme.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/main.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/apps-sidebar-toggle.js')); ?>"></script>

<?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>


<script src="<?php echo e(asset('assets/vendor/notie/notie.min.js')); ?>"></script>
<script>
    // Hide loader when page is ready
    window.addEventListener('load', () => {
        setTimeout(() => {
            const loader = document.getElementById('page-loader');
            if (loader) loader.classList.add('hide');
        }, 1800);
    });

    // Notie bridge
    window.addEventListener('notify', e => {
        const map = { success: 1, warning: 2, error: 3, info: 4 };
        notie.alert({ type: map[e.detail.type] ?? 4, text: e.detail.message, stay: false, time: 4 });
    });

    // Session flash toast (post-redirect)
    <?php if(session('notify_type')): ?>
    document.addEventListener('DOMContentLoaded', () => {
        const map = { success: 1, warning: 2, error: 3, info: 4 };
        notie.alert({ type: map['<?php echo e(session('notify_type')); ?>'] ?? 4, text: '<?php echo e(session('notify_message')); ?>', stay: false, time: 5 });
    });
    <?php endif; ?>

    // Re-init vendor libs after Livewire updates
    document.addEventListener('livewire:navigated', () => {
        if (typeof initChoices === 'function') initChoices();
        if (typeof flatpickr === 'function') {
            document.querySelectorAll('.flatpickr').forEach(el => flatpickr(el));
        }
    });
</script>

<?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH D:\Myprojects\FlowDesk\resources\views/components/layouts/app.blade.php ENDPATH**/ ?>