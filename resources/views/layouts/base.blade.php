<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1, viewport-fit=cover" name="viewport"/>
    <meta content="ie=edge" http-equiv="X-UA-Compatible"/>
    <title>NPMIS</title>
    <link href="{{ asset ('images/cos.ico') }}" rel="icon" type="image/x-icon">
    <link href="{{ asset ('css/tabler.css') }}" rel="stylesheet"/>
    <link href="{{ asset ('css/font-awesome/all.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset ('css/select2.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset ('css/datatable/dataTables.css') }}" rel="stylesheet"/>
    <link href="{{ asset ('css/datatable/buttons.dataTables.css') }}" rel="stylesheet"/>

    <style>
        .loader-overlay {
            position: fixed;
            inset: 0;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }


        /* HTML: <div class="loader"></div> */
        .loader {
            width: 28px;
            aspect-ratio: 1;
            border-radius: 50%;
            background: #0000ff;
            transform-origin: top;
            display: grid;
            animation: l3-0 1s infinite linear;
        }

        .loader::before,
        .loader::after {
            content: "";
            grid-area: 1/1;
            background: #00bfff;
            border-radius: 50%;
            transform-origin: top;
            animation: inherit;
            animation-name: l3-1;
        }

        .loader::after {
            background: #1e90ff;
            --s: 180deg;
        }

        @keyframes l3-0 {
            0%, 20% {
                transform: rotate(0)
            }
            100% {
                transform: rotate(360deg)
            }
        }

        @keyframes l3-1 {
            50% {
                transform: rotate(var(--s, 90deg))
            }
            100% {
                transform: rotate(0)
            }
        }

    </style>
</head>
<body>
<!-- Loader -->
<div class="loader-overlay" id="site-loader">
    <div class="loader"></div>
</div>
<div class="page" id="main-content">
    <!--  BEGIN SIDEBAR  -->
    <aside class="navbar navbar-vertical navbar-expand-lg" data-bs-theme="light">
        <div class="container-fluid">
            <!-- BEGIN NAVBAR TOGGLER -->
            <button
                aria-controls="sidebar-menu"
                aria-expanded="true"
                aria-label="Toggle navigation"
                class="navbar-toggler"
                data-bs-target="#sidebar-menu"
                data-bs-toggle="collapse"
                type="button"
            >
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- END NAVBAR TOGGLER -->
            <!-- BEGIN NAVBAR LOGO -->
            <div class="navbar-brand navbar-brand">
                <a aria-label="Tabler" href="">
                    <img alt="Ministry Logo" class="navbar-brand-image" height="32"
                         src="{{ asset ('images/logo.png') }}">
                </a>
            </div>
            <!-- END NAVBAR LOGO -->
            <div class="navbar-nav flex-row d-lg-none">
                <div class="nav-item d-none d-lg-flex me-3">
                    <div class="btn-list">
                        <a class="btn btn-5" href="https://github.com/tabler/tabler" rel="noreferrer" target="_blank">
                            <!-- Download SVG icon from http://tabler.io/icons/icon/brand-github -->
                            <svg
                                class="icon icon-2"
                                fill="none"
                                height="24"
                                stroke="currentColor"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                                width="24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M9 19c-4.3 1.4 -4.3 -2.5 -6 -3m12 5v-3.5c0 -1 .1 -1.4 -.5 -2c2.8 -.3 5.5 -1.4 5.5 -6a4.6 4.6 0 0 0 -1.3 -3.2a4.2 4.2 0 0 0 -.1 -3.2s-1.1 -.3 -3.5 1.3a12.3 12.3 0 0 0 -6.2 0c-2.4 -1.6 -3.5 -1.3 -3.5 -1.3a4.2 4.2 0 0 0 -.1 3.2a4.6 4.6 0 0 0 -1.3 3.2c0 4.6 2.7 5.7 5.5 6c-.6 .6 -.6 1.2 -.5 2v3.5"
                                />
                            </svg>
                            Source code
                        </a>
                        <a class="btn btn-6" href="https://github.com/sponsors/codecalm" rel="noreferrer"
                           target="_blank">
                            <!-- Download SVG icon from http://tabler.io/icons/icon/heart -->
                            <svg
                                class="icon text-pink icon-2"
                                fill="none"
                                height="24"
                                stroke="currentColor"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                                width="24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M19.5 12.572l-7.5 7.428l-7.5 -7.428a5 5 0 1 1 7.5 -6.566a5 5 0 1 1 7.5 6.572"/>
                            </svg>
                            Sponsor
                        </a>
                    </div>
                </div>
                <div class="d-none d-lg-flex">
                    <div class="nav-item">
                        <a class="nav-link px-0 hide-theme-dark" data-bs-placement="bottom" data-bs-toggle="tooltip"
                           href="?theme=dark" title="Enable dark mode">
                            <!-- Download SVG icon from http://tabler.io/icons/icon/moon -->
                            <svg
                                class="icon icon-1"
                                fill="none"
                                height="24"
                                stroke="currentColor"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                                width="24"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454z"/>
                            </svg>
                        </a>
                        <a class="nav-link px-0 hide-theme-light" data-bs-placement="bottom" data-bs-toggle="tooltip"
                           href="?theme=light" title="Enable light mode">
                            <!-- Download SVG icon from http://tabler.io/icons/icon/sun -->
                            <svg
                                class="icon icon-1"
                                fill="none"
                                height="24"
                                stroke="currentColor"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                                width="24"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"/>
                                <path
                                    d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7"/>
                            </svg>
                        </a>
                    </div>
                    <div class="nav-item dropdown d-none d-md-flex">
                        <a
                            aria-expanded="false"
                            aria-label="Show notifications"
                            class="nav-link px-0"
                            data-bs-auto-close="outside"
                            data-bs-toggle="dropdown"
                            href="#"
                            tabindex="-1"
                        >
                            <!-- Download SVG icon from http://tabler.io/icons/icon/bell -->
                            <svg
                                class="icon icon-1"
                                fill="none"
                                height="24"
                                stroke="currentColor"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                                width="24"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    d="M10 5a2 2 0 1 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6"/>
                                <path d="M9 17v1a3 3 0 0 0 6 0v-1"/>
                            </svg>
                            <span class="badge bg-red"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-end dropdown-menu-card">
                            <div class="card">
                                <div class="card-header d-flex">
                                    <h3 class="card-title">Notifications</h3>
                                    <div class="btn-close ms-auto" data-bs-dismiss="dropdown"></div>
                                </div>
                                <div class="list-group list-group-flush list-group-hoverable">
                                    <div class="list-group-item">
                                        <div class="row align-items-center">
                                            <div class="col-auto"><span
                                                class="status-dot status-dot-animated bg-red d-block"></span></div>
                                            <div class="col text-truncate">
                                                <a class="text-body d-block" href="#">Example 1</a>
                                                <div class="d-block text-secondary text-truncate mt-n1">Change
                                                    deprecated html tags to text decoration classes (#29604)
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <a class="list-group-item-actions" href="#">
                                                    <!-- Download SVG icon from http://tabler.io/icons/icon/star -->
                                                    <svg
                                                        class="icon text-muted icon-2"
                                                        fill="none"
                                                        height="24"
                                                        stroke="currentColor"
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        viewBox="0 0 24 24"
                                                        width="24"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                    >
                                                        <path
                                                            d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z"/>
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="list-group-item">
                                        <div class="row align-items-center">
                                            <div class="col-auto"><span class="status-dot d-block"></span></div>
                                            <div class="col text-truncate">
                                                <a class="text-body d-block" href="#">Example 2</a>
                                                <div class="d-block text-secondary text-truncate mt-n1">
                                                    justify-content:between ⇒ justify-content:space-between (#29734)
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <a class="list-group-item-actions show" href="#">
                                                    <!-- Download SVG icon from http://tabler.io/icons/icon/star -->
                                                    <svg
                                                        class="icon text-yellow icon-2"
                                                        fill="none"
                                                        height="24"
                                                        stroke="currentColor"
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        viewBox="0 0 24 24"
                                                        width="24"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                    >
                                                        <path
                                                            d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z"/>
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="list-group-item">
                                        <div class="row align-items-center">
                                            <div class="col-auto"><span class="status-dot d-block"></span></div>
                                            <div class="col text-truncate">
                                                <a class="text-body d-block" href="#">Example 3</a>
                                                <div class="d-block text-secondary text-truncate mt-n1">Update
                                                    change-version.js (#29736)
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <a class="list-group-item-actions" href="#">
                                                    <!-- Download SVG icon from http://tabler.io/icons/icon/star -->
                                                    <svg
                                                        class="icon text-muted icon-2"
                                                        fill="none"
                                                        height="24"
                                                        stroke="currentColor"
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        viewBox="0 0 24 24"
                                                        width="24"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                    >
                                                        <path
                                                            d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z"/>
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="list-group-item">
                                        <div class="row align-items-center">
                                            <div class="col-auto"><span
                                                class="status-dot status-dot-animated bg-green d-block"></span>
                                            </div>
                                            <div class="col text-truncate">
                                                <a class="text-body d-block" href="#">Example 4</a>
                                                <div class="d-block text-secondary text-truncate mt-n1">Regenerate
                                                    package-lock.json (#29730)
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <a class="list-group-item-actions" href="#">
                                                    <!-- Download SVG icon from http://tabler.io/icons/icon/star -->
                                                    <svg
                                                        class="icon text-muted icon-2"
                                                        fill="none"
                                                        height="24"
                                                        stroke="currentColor"
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        viewBox="0 0 24 24"
                                                        width="24"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                    >
                                                        <path
                                                            d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z"/>
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <a class="btn btn-2 w-100" href="#"> Archive all </a>
                                        </div>
                                        <div class="col">
                                            <a class="btn btn-2 w-100" href="#"> Mark all as read </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="nav-item dropdown d-none d-md-flex me-3">
                        <a
                            aria-expanded="false"
                            aria-label="Show app menu"
                            class="nav-link px-0"
                            data-bs-auto-close="outside"
                            data-bs-toggle="dropdown"
                            href="#"
                            tabindex="-1"
                        >
                            <!-- Download SVG icon from http://tabler.io/icons/icon/apps -->
                            <svg
                                class="icon icon-1"
                                fill="none"
                                height="24"
                                stroke="currentColor"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                                width="24"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path d="M4 4m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z"/>
                                <path
                                    d="M4 14m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z"/>
                                <path
                                    d="M14 14m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z"/>
                                <path d="M14 7l6 0"/>
                                <path d="M17 4l0 6"/>
                            </svg>
                        </a>
                        <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-end dropdown-menu-card">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title">My Apps</div>
                                    <div class="card-actions btn-actions">
                                        <a class="btn-action" href="#">
                                            <!-- Download SVG icon from http://tabler.io/icons/icon/settings -->
                                            <svg
                                                class="icon icon-1"
                                                fill="none"
                                                height="24"
                                                stroke="currentColor"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                viewBox="0 0 24 24"
                                                width="24"
                                                xmlns="http://www.w3.org/2000/svg"
                                            >
                                                <path
                                                    d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z"
                                                />
                                                <path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0"/>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="collapse navbar-collapse" id="sidebar-menu">
                <!-- BEGIN NAVBAR MENU -->
                <br>
                <ul class="navbar-nav pt-lg-3">
                    <!-- Dashboard -->
                    <li class="nav-item">
                        <a class="nav-link" href="./">
                <span class="nav-link-icon d-md-none d-lg-inline-block">
                    <svg class="icon icon-1" fill="none" height="24" stroke="currentColor" stroke-linecap="round"
                         stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24"
                         xmlns="http://www.w3.org/2000/svg">
                        <path d="M5 12l-2 0l9 -9l9 9l-2 0"/>
                        <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7"/>
                        <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6"/>
                    </svg>
                </span>
                            <span class="nav-link-title">Dashboard</span>
                        </a>
                    </li>

                    <!-- Data Submission -->
                    <li class="nav-item dropdown">
                        <a aria-expanded="false" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#"
                           id="dataSubmissionDropdown" role="button">
                <span class="nav-link-icon d-md-none d-lg-inline-block">
                    <svg class="icon icon-tabler" fill="none" height="24" stroke="currentColor"
                         stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24"
                         xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 0h24v24H0z" fill="none" stroke="none"/>
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14,2 14,8 20,8"/>
                        <line x1="16" x2="8" y1="13" y2="13"/>
                        <line x1="16" x2="8" y1="17" y2="17"/>
                        <polyline points="10,9 9,9 8,9"/>
                    </svg>
                </span>
                            <span class="nav-link-title">Data Submission</span>
                        </a>
                        <ul aria-labelledby="dataSubmissionDropdown" class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="/submission/new">
                                    <i class="fa fa-plus-circle me-2"></i>
                                    New Quarterly Submission
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="/submission/drafts">
                                    <i class="fa fa-edit me-2"></i>
                                    Draft Submissions
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="/submission/submitted">
                                    <i class="fa fa-paper-plane me-2"></i>
                                    Submitted Reports
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="/submission/approved">
                                    <i class="fa fa-check-double me-2"></i>
                                    Approved Reports
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center"
                                   href="/submission/provisional-results">
                                    <i class="fa fa-chart-line me-2"></i>
                                    Provisional Results
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Review & Validation -->
                    <li class="nav-item dropdown">
                        <a aria-expanded="false" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#"
                           id="reviewDropdown" role="button">
                <span class="nav-link-icon d-md-none d-lg-inline-block">
                    <svg class="icon icon-tabler" fill="none" height="24" stroke="currentColor"
                         stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24"
                         xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 0h24v24H0z" fill="none" stroke="none"/>
                        <polyline points="9,11 12,14 22,4"/>
                        <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
                    </svg>
                </span>
                            <span class="nav-link-title">Review & Validation</span>
                        </a>
                        <ul aria-labelledby="reviewDropdown" class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="/review/pending">
                                    <i class="fa fa-clock me-2"></i>
                                    Pending Reviews
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="/review/returned">
                                    <i class="fa fa-undo me-2"></i>
                                    Returned for Correction
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="/review/approved">
                                    <i class="fa fa-thumbs-up me-2"></i>
                                    Approved Submissions
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Institutional Profiles -->
                    <li class="nav-item dropdown">
                        <a aria-expanded="false" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#"
                           id="profilesDropdown" role="button">
                <span class="nav-link-icon d-md-none d-lg-inline-block">
                    <svg class="icon icon-tabler icon-tabler-building" fill="none" height="24"
                         stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24"
                         width="24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 0h24v24H0z" fill="none" stroke="none"/>
                        <path d="M3 21v-13l9 -4l9 4v13"/>
                        <path d="M13 13h4v8h-10v-6h6"/>
                        <path d="M13 21v-4a1 1 0 0 1 1 -1h3"/>
                    </svg>
                </span>
                            <span class="nav-link-title">Institutional Profiles</span>
                        </a>
                        <ul aria-labelledby="profilesDropdown" class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="/profiles/my-profile">
                                    <i class="fa fa-building me-2"></i>
                                    My Institution Profile
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="/profiles/all-profiles">
                                    <i class="fa fa-list me-2"></i>
                                    All MDA Profiles
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="/profiles/pending-approval">
                                    <i class="fa fa-hourglass-half me-2"></i>
                                    Pending Approvals
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center"
                                   href="/profiles/statistical-dashboard">
                                    <i class="fa fa-chart-bar me-2"></i>
                                    Statistical Dashboard
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Productivity Analytics -->
                    <li class="nav-item dropdown">
                        <a aria-expanded="false" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#"
                           id="analyticsDropdown" role="button">
                <span class="nav-link-icon d-md-none d-lg-inline-block">
                    <svg class="icon icon-tabler" fill="none" height="24" stroke="currentColor"
                         stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24"
                         xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 0h24v24H0z" fill="none" stroke="none"/>
                        <line x1="18" x2="18" y1="20" y2="10"/>
                        <line x1="12" x2="12" y1="20" y2="4"/>
                        <line x1="6" x2="6" y1="20" y2="14"/>
                    </svg>
                </span>
                            <span class="nav-link-title">Productivity Analytics</span>
                        </a>
                        <ul aria-labelledby="analyticsDropdown" class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="/analytics/omax-analysis">
                                    <i class="fa fa-calculator me-2"></i>
                                    OMAX Analysis
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center"
                                   href="/analytics/productivity-indices">
                                    <i class="fa fa-chart-pie me-2"></i>
                                    Productivity Indices
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="/analytics/data-visualization">
                                    <i class="fa fa-chart-area me-2"></i>
                                    Data Visualization
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="/analytics/export-data">
                                    <i class="fa fa-download me-2"></i>
                                    Export Analytics Data
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Training Management -->
                    <li class="nav-item dropdown">
                        <a aria-expanded="false" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#"
                           id="trainingDropdown" role="button">
                <span class="nav-link-icon d-md-none d-lg-inline-block">
                    <svg class="icon icon-tabler" fill="none" height="24" stroke="currentColor"
                         stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24"
                         xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 0h24v24H0z" fill="none" stroke="none"/>
                        <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/>
                        <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
                    </svg>
                </span>
                            <span class="nav-link-title">Training Management</span>
                        </a>
                        <ul aria-labelledby="trainingDropdown" class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="/training/request">
                                    <i class="fa fa-hand-paper me-2"></i>
                                    Request Training
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="/training/my-requests">
                                    <i class="fa fa-list-alt me-2"></i>
                                    My Training Requests
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="/training/all-requests">
                                    <i class="fa fa-inbox me-2"></i>
                                    All Training Requests
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="/training/nominations">
                                    <i class="fa fa-user-graduate me-2"></i>
                                    Trainer Nominations
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Document & Resources -->
                    <li class="nav-item dropdown">
                        <a aria-expanded="false" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#"
                           id="documentsDropdown" role="button">
                <span class="nav-link-icon d-md-none d-lg-inline-block">
                    <svg class="icon icon-tabler" fill="none" height="24" stroke="currentColor"
                         stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24"
                         xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 0h24v24H0z" fill="none" stroke="none"/>
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14,2 14,8 20,8"/>
                    </svg>
                </span>
                            <span class="nav-link-title">Document & Resources</span>
                        </a>
                        <ul aria-labelledby="documentsDropdown" class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="/documents/guidelines">
                                    <i class="fa fa-book me-2"></i>
                                    Guidelines & Manuals
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="/documents/templates">
                                    <i class="fa fa-file-excel me-2"></i>
                                    Excel Templates & Tools
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="/documents/training-materials">
                                    <i class="fa fa-graduation-cap me-2"></i>
                                    Training Materials
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center"
                                   href="/documents/evidence-repository">
                                    <i class="fa fa-folder-open me-2"></i>
                                    Evidence Repository
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Communication -->
                    <li class="nav-item">
                        <a class="nav-link" href="/communications">
                <span class="nav-link-icon d-md-none d-lg-inline-block">
                    <svg class="icon icon-tabler" fill="none" height="24" stroke="currentColor"
                         stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24"
                         xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 0h24v24H0z" fill="none" stroke="none"/>
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                    </svg>
                </span>
                            <span class="nav-link-title">Communications</span>
                        </a>
                    </li>

                    <!-- System Setup -->
                    <li class="nav-item dropdown">
                        <a aria-expanded="false" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#"
                           id="system_setup_dropdown" role="button">
                <span class="nav-link-icon d-md-none d-lg-inline-block">
                    <svg class="icon icon-tabler icon-tabler-settings" fill="none" height="24"
                         stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24"
                         width="24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 0h24v24H0z" fill="none" stroke="none"/>
                        <path d="M12 9m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"/>
                        <path d="M12 3v2"/>
                        <path d="M12 19v2"/>
                        <path d="M5.636 5.636l1.414 1.414"/>
                        <path d="M16.95 16.95l1.414 1.414"/>
                        <path d="M3 12h2"/>
                        <path d="M19 12h2"/>
                        <path d="M5.636 18.364l1.414 -1.414"/>
                        <path d="M16.95 7.05l1.414 -1.414"/>
                    </svg>
                </span>
                            <span class="nav-link-title">System Setup</span>
                        </a>
                        <ul aria-labelledby="system_setup_dropdown" class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="/setup/user-management">
                                    <i class="fa fa-users me-2"></i>
                                    User Management
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="/setup/roles-permissions">
                                    <i class="fa-solid fa-business-time me-2"></i>
                                    Roles & Permissions
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="/setup/system-configuration">
                                    <i class="fa fa-cog me-2"></i>
                                    System Configuration
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="/setup/audit-logs">
                                    <i class="fa fa-history me-2"></i>
                                    Audit Logs
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Report -->
                    <li class="nav-item">
                        <a class="nav-link" data-bs-target="#modal-report" data-bs-toggle="modal" href="#"
                           role="button">
                <span class="nav-link-icon d-md-none d-lg-inline-block">
                    <svg class="icon icon-1" fill="none" height="24" stroke="currentColor" stroke-linecap="round"
                         stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24"
                         xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 0h24v24H0z" fill="none" stroke="none"/>
                        <path d="M8 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h5.697"/>
                        <path d="M18 14v4h4"/>
                        <path d="M18 11v-4a2 2 0 0 0 -2 -2h-2"/>
                        <path d="M8 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z"/>
                        <path d="M18 18m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"/>
                        <path d="M8 11h4"/>
                        <path d="M8 15h3"/>
                    </svg>
                </span>
                            <span class="nav-link-title">Reports</span>
                        </a>
                    </li>

                    <!-- Profile -->
                    <li class="nav-item">
                        <a class="nav-link" href="/profile" role="button">
                <span class="nav-link-icon d-md-none d-lg-inline-block">
                    <svg class="icon icon-1" fill="none" height="24" stroke="currentColor" stroke-linecap="round"
                         stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24"
                         xmlns="http://www.w3.org/2000/svg">
                        <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"/>
                        <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"/>
                    </svg>
                </span>
                            <span class="nav-link-title">Profile</span>
                        </a>
                    </li>
                </ul>
                <!-- END NAVBAR MENU -->
            </div>
        </div>
    </aside>
    <!--  END SIDEBAR  -->
    <!-- BEGIN NAVBAR  -->
    <header class="navbar navbar-expand-md d-none d-lg-flex d-print-none">
        <div class="container-xl">
            <!-- BEGIN NAVBAR TOGGLER -->
            <button
                aria-controls="navbar-menu"
                aria-expanded="false"
                aria-label="Toggle navigation"
                class="navbar-toggler"
                data-bs-target="#navbar-menu"
                data-bs-toggle="collapse"
                type="button"
            >
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- END NAVBAR TOGGLER -->
            <div class="navbar-nav flex-row order-md-last">
                <div class="d-none d-md-flex">
                    <div class="nav-item">
                        <a class="nav-link px-0 hide-theme-dark" data-bs-placement="bottom" data-bs-toggle="tooltip"
                           href="?theme=dark" title="Enable dark mode">
                            <!-- Download SVG icon from http://tabler.io/icons/icon/moon -->
                            <svg
                                class="icon icon-1"
                                fill="none"
                                height="24"
                                stroke="currentColor"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                                width="24"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454z"/>
                            </svg>
                        </a>
                        <a class="nav-link px-0 hide-theme-light" data-bs-placement="bottom" data-bs-toggle="tooltip"
                           href="?theme=light" title="Enable light mode">
                            <!-- Download SVG icon from http://tabler.io/icons/icon/sun -->
                            <svg
                                class="icon icon-1"
                                fill="none"
                                height="24"
                                stroke="currentColor"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                                width="24"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"/>
                                <path
                                    d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7"/>
                            </svg>
                        </a>
                    </div>
                    <div class="nav-item dropdown d-none d-md-flex">
                        <a
                            aria-expanded="false"
                            aria-label="Show notifications"
                            class="nav-link px-0"
                            data-bs-auto-close="outside"
                            data-bs-toggle="dropdown"
                            href="#"
                            tabindex="-1"
                        >
                            <!-- Download SVG icon from http://tabler.io/icons/icon/bell -->
                            <svg
                                class="icon icon-1"
                                fill="none"
                                height="24"
                                stroke="currentColor"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                                width="24"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    d="M10 5a2 2 0 1 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6"/>
                                <path d="M9 17v1a3 3 0 0 0 6 0v-1"/>
                            </svg>
                            <span class="badge bg-red"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-end dropdown-menu-card">
                            <div class="card">
                                <div class="card-header d-flex">
                                    <h3 class="card-title">Notifications</h3>
                                    <div class="btn-close ms-auto" data-bs-dismiss="dropdown"></div>
                                </div>
                                <div class="list-group list-group-flush list-group-hoverable">
                                    <div class="list-group-item">
                                        <div class="row align-items-center">
                                            <div class="col-auto"><span
                                                class="status-dot status-dot-animated bg-red d-block"></span></div>
                                            <div class="col text-truncate">
                                                <a class="text-body d-block" href="#">Example 1</a>
                                                <div class="d-block text-secondary text-truncate mt-n1">Change
                                                    deprecated html tags to text decoration classes (#29604)
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <a class="list-group-item-actions" href="#">
                                                    <!-- Download SVG icon from http://tabler.io/icons/icon/star -->
                                                    <svg
                                                        class="icon text-muted icon-2"
                                                        fill="none"
                                                        height="24"
                                                        stroke="currentColor"
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        viewBox="0 0 24 24"
                                                        width="24"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                    >
                                                        <path
                                                            d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z"/>
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="list-group-item">
                                        <div class="row align-items-center">
                                            <div class="col-auto"><span class="status-dot d-block"></span></div>
                                            <div class="col text-truncate">
                                                <a class="text-body d-block" href="#">Example 2</a>
                                                <div class="d-block text-secondary text-truncate mt-n1">
                                                    justify-content:between ⇒ justify-content:space-between (#29734)
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <a class="list-group-item-actions show" href="#">
                                                    <!-- Download SVG icon from http://tabler.io/icons/icon/star -->
                                                    <svg
                                                        class="icon text-yellow icon-2"
                                                        fill="none"
                                                        height="24"
                                                        stroke="currentColor"
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        viewBox="0 0 24 24"
                                                        width="24"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                    >
                                                        <path
                                                            d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z"/>
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="list-group-item">
                                        <div class="row align-items-center">
                                            <div class="col-auto"><span class="status-dot d-block"></span></div>
                                            <div class="col text-truncate">
                                                <a class="text-body d-block" href="#">Example 3</a>
                                                <div class="d-block text-secondary text-truncate mt-n1">Update
                                                    change-version.js (#29736)
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <a class="list-group-item-actions" href="#">
                                                    <!-- Download SVG icon from http://tabler.io/icons/icon/star -->
                                                    <svg
                                                        class="icon text-muted icon-2"
                                                        fill="none"
                                                        height="24"
                                                        stroke="currentColor"
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        viewBox="0 0 24 24"
                                                        width="24"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                    >
                                                        <path
                                                            d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z"/>
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="list-group-item">
                                        <div class="row align-items-center">
                                            <div class="col-auto"><span
                                                class="status-dot status-dot-animated bg-green d-block"></span>
                                            </div>
                                            <div class="col text-truncate">
                                                <a class="text-body d-block" href="#">Example 4</a>
                                                <div class="d-block text-secondary text-truncate mt-n1">Regenerate
                                                    package-lock.json (#29730)
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <a class="list-group-item-actions" href="#">
                                                    <!-- Download SVG icon from http://tabler.io/icons/icon/star -->
                                                    <svg
                                                        class="icon text-muted icon-2"
                                                        fill="none"
                                                        height="24"
                                                        stroke="currentColor"
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        viewBox="0 0 24 24"
                                                        width="24"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                    >
                                                        <path
                                                            d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z"/>
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <a class="btn btn-2 w-100" href="#"> Archive all </a>
                                        </div>
                                        <div class="col">
                                            <a class="btn btn-2 w-100" href="#"> Mark all as read </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="nav-item dropdown">
                    <a aria-label="Open user menu" class="nav-link d-flex lh-1 p-0 px-2" data-bs-toggle="dropdown"
                       href="#">
                        <span class="avatar avatar-sm"

                        </span>
                        <div class="d-none d-xl-block ps-2">
                            <div id="user-name"></div>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                        <a class="dropdown-item" href="./profile.html">Profile</a>
                        <a class="dropdown-item" href="/modules/">Module Selector</a>
                        <div class="dropdown-divider"></div>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="dropdown-item" type="submit">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="collapse navbar-collapse" id="navbar-menu">
                <!-- BEGIN NAVBAR MENU -->
                <ul class="navbar-nav">

                </ul>
                <!-- END NAVBAR MENU -->
            </div>
        </div>
    </header>
    <div class="page-wrapper">
        @yield('content')
    </div>
    <footer class="footer footer-transparent d-print-none">
        <div class="container-xl">
            <div class="footer-bottom">
                <div class="row align-items-center">
                    <div class="col-md-12 text-center">
                        <div class="ministry-links mb-3">
                            <span class="copyright-text">
                                &copy;
                                <span id="year"></span> Developed by
                            </span>
                            <a class="ministry-link" href="https://ict.go.ke">
                                Ministry of ICT & Digital Economy
                            </a>
                            <span class="divider">for</span>
                            <a class="ministry-link" href="https://www.labour.go.ke/">
                                Ministry of Labour & Social Protection
                            </a>
                        </div>
                        <p class="copyright-text">
                            All rights reserved.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
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
    document.getElementById("year").textContent = new Date().getFullYear();
</script>

<script>
    window.addEventListener('load', () => {
        document.getElementById('site-loader').style.display = 'none';
        document.getElementById('main-content').style.display = 'block';
    });
</script>
<div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1100">
    <div aria-atomic="true" aria-live="assertive" class="toast align-items-center text-bg-warning border-0" id="logoutToast"
         role="alert">
        <div class="d-flex">
            <div class="toast-body">
                You have been logged out due to inactivity.
            </div>
            <button aria-label="Close" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    type="button"></button>
        </div>
    </div>
</div>
</body>
</html>
