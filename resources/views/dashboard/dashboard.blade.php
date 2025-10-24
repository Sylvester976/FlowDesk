@extends('layouts.base')

@section('main-content')
    <!-- Dashboard Content -->
    <div id="dashboard-section">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-1">Dashboard Overview</h2>
                <p class="text-muted mb-0">Welcome back! Here's what's happening with your team.</p>
            </div>
            <button class="btn btn-primary">
                <i class="bi bi-download me-2"></i> Export Report
            </button>
        </div>

        <!-- Statistics Cards -->
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="card stat-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="text-muted mb-1">Total Employees</p>
                                <h3 class="mb-0">248</h3>
                                <small class="text-success"><i class="bi bi-arrow-up"></i> 12% from last month</small>
                            </div>
                            <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                                <i class="bi bi-people"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card stat-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="text-muted mb-1">Currently Traveling</p>
                                <h3 class="mb-0">42</h3>
                                <small class="text-info"><i class="bi bi-arrow-right"></i> 17% of total</small>
                            </div>
                            <div class="stat-icon bg-info bg-opacity-10 text-info">
                                <i class="bi bi-airplane"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card stat-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="text-muted mb-1">Active Assignments</p>
                                <h3 class="mb-0">68</h3>
                                <small class="text-warning"><i class="bi bi-clock"></i> 15 ending soon</small>
                            </div>
                            <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                                <i class="bi bi-briefcase"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card stat-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="text-muted mb-1">Countries Covered</p>
                                <h3 class="mb-0">23</h3>
                                <small class="text-success"><i class="bi bi-globe"></i> Across 5 continents</small>
                            </div>
                            <div class="stat-icon bg-success bg-opacity-10 text-success">
                                <i class="bi bi-pin-map"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Assignments & Reports -->
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0">Recent Travel Assignments</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                <tr>
                                    <th>Employee</th>
                                    <th>Country</th>
                                    <th>Assignment</th>
                                    <th>Start Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://ui-avatars.com/api/?name=John+Doe"
                                                 class="rounded-circle me-2" width="32" height="32" alt="Employee">
                                            <span>John Doe</span>
                                        </div>
                                    </td>
                                    <td><i class="bi bi-flag me-1"></i> United Kingdom</td>
                                    <td>Project Consultation</td>
                                    <td>Oct 15, 2025</td>
                                    <td><span class="badge badge-status bg-success">Active</span></td>
                                    <td class="table-actions">
                                        <button class="btn btn-sm btn-outline-primary me-1"><i class="bi bi-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://ui-avatars.com/api/?name=Sarah+Smith"
                                                 class="rounded-circle me-2" width="32" height="32" alt="Employee">
                                            <span>Sarah Smith</span>
                                        </div>
                                    </td>
                                    <td><i class="bi bi-flag me-1"></i> Germany</td>
                                    <td>Training Workshop</td>
                                    <td>Oct 10, 2025</td>
                                    <td><span class="badge badge-status bg-success">Active</span></td>
                                    <td class="table-actions">
                                        <button class="btn btn-sm btn-outline-primary me-1"><i class="bi bi-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://ui-avatars.com/api/?name=Michael+Brown"
                                                 class="rounded-circle me-2" width="32" height="32" alt="Employee">
                                            <span>Michael Brown</span>
                                        </div>
                                    </td>
                                    <td><i class="bi bi-flag me-1"></i> Singapore</td>
                                    <td>Client Meeting</td>
                                    <td>Oct 20, 2025</td>
                                    <td><span class="badge badge-status bg-warning text-dark">Pending</span></td>
                                    <td class="table-actions">
                                        <button class="btn btn-sm btn-outline-primary me-1"><i class="bi bi-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://ui-avatars.com/api/?name=Emily+Davis"
                                                 class="rounded-circle me-2" width="32" height="32" alt="Employee">
                                            <span>Emily Davis</span>
                                        </div>
                                    </td>
                                    <td><i class="bi bi-flag me-1"></i> Canada</td>
                                    <td>Research Collaboration</td>
                                    <td>Oct 5, 2025</td>
                                    <td><span class="badge badge-status bg-success">Active</span></td>
                                    <td class="table-actions">
                                        <button class="btn btn-sm btn-outline-primary me-1"><i class="bi bi-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://ui-avatars.com/api/?name=David+Wilson"
                                                 class="rounded-circle me-2" width="32" height="32" alt="Employee">
                                            <span>David Wilson</span>
                                        </div>
                                    </td>
                                    <td><i class="bi bi-flag me-1"></i> Australia</td>
                                    <td>Conference Attendance</td>
                                    <td>Sep 28, 2025</td>
                                    <td><span class="badge badge-status bg-secondary">Completed</span></td>
                                    <td class="table-actions">
                                        <button class="btn btn-sm btn-outline-primary me-1"><i class="bi bi-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i>
                                        </button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0">Recent Reports</h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <a href="#" class="list-group-item list-group-item-action border-0 px-0">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 text-primary rounded p-2 me-3">
                                        <i class="bi bi-file-pdf"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0">Monthly Travel Report</h6>
                                        <small class="text-muted">Uploaded 2 hours ago</small>
                                    </div>
                                </div>
                            </a>
                            <a href="#" class="list-group-item list-group-item-action border-0 px-0">
                                <div class="d-flex align-items-center">
                                    <div class="bg-success bg-opacity-10 text-success rounded p-2 me-3">
                                        <i class="bi bi-file-excel"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0">Expense Summary Q3</h6>
                                        <small class="text-muted">Uploaded 5 hours ago</small>
                                    </div>
                                </div>
                            </a>
                            <a href="#" class="list-group-item list-group-item-action border-0 px-0">
                                <div class="d-flex align-items-center">
                                    <div class="bg-info bg-opacity-10 text-info rounded p-2 me-3">
                                        <i class="bi bi-file-word"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0">Assignment Review</h6>
                                        <small class="text-muted">Uploaded 1 day ago</small>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0">Top Destinations</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span>United States</span>
                                <span class="text-muted">28 trips</span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 85%"></div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span>United Kingdom</span>
                                <span class="text-muted">22 trips</span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-info" role="progressbar" style="width: 70%"></div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span>Germany</span>
                                <span class="text-muted">18 trips</span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 55%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="d-flex justify-content-between mb-1">
                                <span>Singapore</span>
                                <span class="text-muted">15 trips</span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 45%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
