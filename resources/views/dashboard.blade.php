@extends('layouts.base')

@section('content')
    <!-- BEGIN PAGE HEADER -->
    <div class="page-header d-print-none" aria-label="Page header">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <div class="page-pretitle">National Productivity Management Information System</div>
                    <h2 class="page-title">Productivity Dashboard</h2>
                </div>
                <div class="col-12 col-md-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <span class="d-none d-sm-inline">
                            <a href="#" class="btn btn-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M12 5l0 14" />
                                    <path d="M5 12l14 0" />
                                </svg>
                                New Submission
                            </a>
                        </span>
                        <a href="#" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" />
                                <path d="M16 3v4" />
                                <path d="M8 3v4" />
                                <path d="M4 11h16" />
                                <path d="M11 15h1" />
                                <path d="M12 15v3" />
                            </svg>
                            Q4 2025 Due in 5 days
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE HEADER -->

    <!-- BEGIN PAGE BODY -->
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-deck row-cards">

                <!-- Welcome Card -->
                <div class="col-sm-12 col-lg-8">
                    <div class="card">
                        <div class="card bg-primary-lt">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h2 class="card-title">Welcome back, Ministry of Health</h2>
                                        <p class="text-secondary">
                                            Track your productivity metrics, submit quarterly reports, and access training resources.
                                            Your last submission was approved on March 15, 2025.
                                        </p>
                                    </div>
                                    <div class="col-auto">
                                        <div class="badge bg-success badge-pill">Active Profile</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="col-sm-12 col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Quick Actions</h3>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="#" class="btn btn-outline-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                        <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                                    </svg>
                                    Submit Report
                                </a>
                                <a href="#" class="btn btn-outline-success">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" />
                                        <path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                        <path d="M14 4l0 4l-6 0l0 -4" />
                                    </svg>
                                    Request Training
                                </a>
                                <a href="#" class="btn btn-outline-info">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                                        <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                        <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
                                    </svg>
                                    Update Profile
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- OMAX Productivity Index -->
                <div class="col-sm-12 col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <div>
                                <h3 class="card-title">OMAX Productivity Index - Q3 2025</h3>
                                <p class="card-subtitle">Current Quarter Performance Analysis</p>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6 col-lg-3">
                                    <div class="card card-sm">
                                        <div class="card-body">
                                            <div class="row align-items-center">
                                                <div class="col-auto">
                                                    <span class="bg-primary text-white avatar">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                            <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                                                            <path d="M12 7v5l3 3" />
                                                        </svg>
                                                    </span>
                                                </div>
                                                <div class="col">
                                                    <div class="font-weight-medium">Service Efficiency</div>
                                                    <div class="text-secondary">Score: 7.2/10</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="card card-sm">
                                        <div class="card-body">
                                            <div class="row align-items-center">
                                                <div class="col-auto">
                                                    <span class="bg-success text-white avatar">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                            <path d="M7 10l5 -6l5 6" />
                                                            <path d="M21 10l-2 8a2 2.5 0 0 1 -2 2h-10a2 2.5 0 0 1 -2 -2l-2 -8z" />
                                                            <path d="M12 15m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                                        </svg>
                                                    </span>
                                                </div>
                                                <div class="col">
                                                    <div class="font-weight-medium">Quality Metrics</div>
                                                    <div class="text-secondary">Score: 8.5/10</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="card card-sm">
                                        <div class="card-body">
                                            <div class="row align-items-center">
                                                <div class="col-auto">
                                                    <span class="bg-info text-white avatar">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                            <path d="M16.7 8a3 3 0 0 0 -2.7 -5h-4a3 3 0 0 0 0 6h4a3 3 0 0 1 0 6h-4a3 3 0 0 1 -2.7 -5" />
                                                            <path d="M12 3v3m0 12v3" />
                                                        </svg>
                                                    </span>
                                                </div>
                                                <div class="col">
                                                    <div class="font-weight-medium">Cost Effectiveness</div>
                                                    <div class="text-secondary">Score: 6.8/10</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="card card-sm">
                                        <div class="card-body">
                                            <div class="row align-items-center">
                                                <div class="col-auto">
                                                    <span class="bg-warning text-white avatar">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                            <path d="M3 3l18 18" />
                                                            <path d="M9 5a3 3 0 0 1 6 0c0 2 -3 3 -3 3s3 1 3 3a3 3 0 0 1 -6 0" />
                                                            <path d="M12 14h.01" />
                                                            <path d="M12 3c7.2 0 9 1.8 9 9s-1.8 9 -9 9s-9 -1.8 -9 -9s1.8 -9 9 -9z" />
                                                        </svg>
                                                    </span>
                                                </div>
                                                <div class="col">
                                                    <div class="font-weight-medium">Overall OMAX</div>
                                                    <div class="text-secondary">Index: 7.4/10</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Performance Chart -->
                            <div class="mt-4">
                                <canvas id="omaxChart" width="400" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submission Status -->
                <div class="col-sm-12 col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Quarterly Submissions</h3>
                        </div>
                        <div class="card-body">
                            <div class="list-group list-group-flush list-group-hoverable">
                                <div class="list-group-item">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <span class="status-dot status-dot-animated bg-success d-block"></span>
                                        </div>
                                        <div class="col text-truncate">
                                            <a href="#" class="text-body d-block">Q3 2025</a>
                                            <div class="d-block text-secondary text-truncate mt-n1">
                                                Approved - March 20, 2025
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <span class="badge bg-success">Approved</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="list-group-item">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <span class="status-dot status-dot-animated bg-warning d-block"></span>
                                        </div>
                                        <div class="col text-truncate">
                                            <a href="#" class="text-body d-block">Q4 2025</a>
                                            <div class="d-block text-secondary text-truncate mt-n1">
                                                Under Review - Due Aug 20
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <span class="badge bg-warning">Pending</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="list-group-item">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <span class="status-dot bg-secondary d-block"></span>
                                        </div>
                                        <div class="col text-truncate">
                                            <a href="#" class="text-body d-block">Q2 2025</a>
                                            <div class="d-block text-secondary text-truncate mt-n1">
                                                Approved - December 15, 2024
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <span class="badge bg-success">Approved</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Training Requests Status -->
                <div class="col-sm-12 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Training Requests</h3>
                            <div class="card-actions">
                                <a href="#" class="btn btn-primary btn-sm">Request Training</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="text-center">
                                        <div class="h1 m-0">3</div>
                                        <div class="text-secondary">Completed</div>
                                    </div>
                                </div>
                                <div class="col-6 border-start">
                                    <div class="text-center">
                                        <div class="h1 m-0">1</div>
                                        <div class="text-secondary">Pending</div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <div class="list-group list-group-flush">
                                    <div class="list-group-item px-0">
                                        <div class="row align-items-center">
                                            <div class="col text-truncate">
                                                <div class="text-body">Productivity Mainstreaming</div>
                                                <div class="text-secondary text-truncate mt-n1">
                                                    Scheduled: August 25-26, 2025
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <span class="badge bg-info">Scheduled</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Institutional Profile Summary -->
                <div class="col-sm-12 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Institution Profile</h3>
                            <div class="card-actions">
                                <a href="#" class="btn btn-outline-primary btn-sm">Edit Profile</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <dl class="row">
                                <dt class="col-5">Institution:</dt>
                                <dd class="col-7">Ministry of Health</dd>
                                <dt class="col-5">Focal Person:</dt>
                                <dd class="col-7">Dr. Sarah Johnson</dd>
                                <dt class="col-5">Committee Members:</dt>
                                <dd class="col-7">12 Active</dd>
                                <dt class="col-5">Productivity Champions:</dt>
                                <dd class="col-7">4 Assigned</dd>
                                <dt class="col-5">Last Updated:</dt>
                                <dd class="col-7">March 10, 2025</dd>
                                <dt class="col-5">Profile Status:</dt>
                                <dd class="col-7"><span class="badge bg-success">Approved</span></dd>
                            </dl>
                        </div>
                    </div>
                </div>

                <!-- Document Repository -->
                <div class="col-sm-12 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Recent Documents</h3>
                        </div>
                        <div class="card-body">
                            <div class="list-group list-group-flush">
                                <div class="list-group-item px-0">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon text-success" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                                <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                                            </svg>
                                        </div>
                                        <div class="col text-truncate">
                                            <div class="text-body">Q3 2025 Submission Template</div>
                                            <div class="text-secondary text-truncate mt-n1">
                                                Updated: March 1, 2025
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <a href="#" class="btn btn-sm btn-outline-primary">Download</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="list-group-item px-0">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon text-info" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                                <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                                            </svg>
                                        </div>
                                        <div class="col text-truncate">
                                            <div class="text-body">OMAX Guidelines 2025</div>
                                            <div class="text-secondary text-truncate mt-n1">
                                                Updated: February 15, 2025
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <a href="#" class="btn btn-sm btn-outline-primary">Download</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="list-group-item px-0">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon text-warning" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                                <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                                            </svg>
                                        </div>
                                        <div class="col text-truncate">
                                            <div class="text-body">Training Manual v2.1</div>
                                            <div class="text-secondary text-truncate mt-n1">
                                                Updated: January 30, 2025
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <a href="#" class="btn btn-sm btn-outline-primary">Download</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Notifications & Reminders -->
                <div class="col-sm-12 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Notifications & Reminders</h3>
                        </div>
                        <div class="card-body">
                            <div class="list-group list-group-flush">
                                <div class="list-group-item px-0">
                                    <div class="row align-items-start">
                                        <div class="col-auto">
                                            <span class="avatar avatar-sm bg-danger text-white">!</span>
                                        </div>
                                        <div class="col text-truncate">
                                            <div class="text-body">Q4 2025 Submission Due</div>
                                            <div class="text-secondary text-truncate mt-n1">
                                                Reminder: Submit your quarterly report by August 20, 2025
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <span class="text-secondary">5 days</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="list-group-item px-0">
                                    <div class="row align-items-start">
                                        <div class="col-auto">
                                            <span class="avatar avatar-sm bg-info text-white">i</span>
                                        </div>
                                        <div class="col text-truncate">
                                            <div class="text-body">Profile Update Required</div>
                                            <div class="text-secondary text-truncate mt-n1">
                                                Please update your institutional productivity committee details
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <span class="text-secondary">2 days</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="list-group-item px-0">
                                    <div class="row align-items-start">
                                        <div class="col-auto">
                                            <span class="avatar avatar-sm bg-success text-white">✓</span>
                                        </div>
                                        <div class="col text-truncate">
                                            <div class="text-body">Training Approved</div>
                                            <div class="text-secondary text-truncate mt-n1">
                                                Your productivity mainstreaming training request has been approved
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <span class="text-secondary">1 week</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Chart.js Script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <script>
        // OMAX Productivity Chart
        const ctx = document.getElementById('omaxChart').getContext('2d');
        const omaxChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Q1 2024', 'Q2 2024', 'Q3 2024', 'Q4 2024', 'Q1 2025', 'Q2 2025', 'Q3 2025'],
                datasets: [{
                    label: 'OMAX Productivity Index',
                    data: [4.2, 5.1, 6.3, 6.8, 7.1, 7.3, 7.4],
                    borderColor: 'rgb(75, 192, 192)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    tension: 0.4,
                    fill: true
                }, {
                    label: 'Target Index',
                    data: [5.0, 5.5, 6.0, 6.5, 7.0, 7.5, 8.0],
                    borderColor: 'rgb(255, 99, 132)',
                    backgroundColor: 'rgba(255, 99, 132, 0.1)',
                    borderDash: [5, 5],
                    tension: 0.1,
                    fill: false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Quarterly OMAX Performance Trend'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 10,
                        title: {
                            display: true,
                            text: 'OMAX Score (0-10)'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Quarter'
                        }
                    }
                },
                elements: {
                    point: {
                        radius: 6,
                        hoverRadius: 8
                    }
                }
            }
        });
    </script>
@endsection
