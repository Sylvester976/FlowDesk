@extends('layouts.base_staff')

@section('main-content')
    <!-- User Dashboard Content -->
    <div id="user-dashboard-section">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-1">Welcome back, {{ Auth::user()->name }}!</h2>
                <p class="text-muted mb-0">Manage your travel assignments and expenses</p>
            </div>
            <button class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i> New Travel Request
            </button>
        </div>

        <!-- User Statistics Cards -->
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="card stat-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="text-muted mb-1">My Trips</p>
                                <h3 class="mb-0">12</h3>
                                <small class="text-muted">This year</small>
                            </div>
                            <div class="stat-icon bg-primary bg-opacity-10 text-primary">
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
                                <p class="text-muted mb-1">Active Assignment</p>
                                <h3 class="mb-0">1</h3>
                                <small class="text-success">Currently traveling</small>
                            </div>
                            <div class="stat-icon bg-success bg-opacity-10 text-success">
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
                                <p class="text-muted mb-1">Pending Expenses</p>
                                <h3 class="mb-0">$2,450</h3>
                                <small class="text-warning">Awaiting approval</small>
                            </div>
                            <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                                <i class="bi bi-receipt"></i>
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
                                <p class="text-muted mb-1">Countries Visited</p>
                                <h3 class="mb-0">8</h3>
                                <small class="text-info">Across 3 continents</small>
                            </div>
                            <div class="stat-icon bg-info bg-opacity-10 text-info">
                                <i class="bi bi-globe"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Current Assignment Alert -->
        <div class="alert alert-info d-flex align-items-center mb-4" role="alert">
            <i class="bi bi-info-circle-fill me-3 fs-4"></i>
            <div class="flex-grow-1">
                <strong>Current Assignment:</strong> You are currently on assignment in <strong>United Kingdom</strong> until <strong>Oct 25, 2025</strong>
            </div>
            <button class="btn btn-sm btn-outline-info">View Details</button>
        </div>

        <!-- Main Content Row -->
        <div class="row g-4">
            <!-- My Travel Assignments -->
            <div class="col-lg-8">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">My Travel Assignments</h5>
                        <div class="btn-group btn-group-sm" role="group">
                            <button type="button" class="btn btn-outline-secondary active">All</button>
                            <button type="button" class="btn btn-outline-secondary">Active</button>
                            <button type="button" class="btn btn-outline-secondary">Upcoming</button>
                            <button type="button" class="btn btn-outline-secondary">Past</button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                <tr>
                                    <th>Country</th>
                                    <th>Purpose</th>
                                    <th>Duration</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td><i class="bi bi-flag me-1"></i> United Kingdom</td>
                                    <td>Project Consultation</td>
                                    <td>Oct 15 - Oct 25, 2025</td>
                                    <td><span class="badge badge-status bg-success">Active</span></td>
                                    <td class="table-actions">
                                        <button class="btn btn-sm btn-outline-primary me-1" title="View Details">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-success" title="Submit Report">
                                            <i class="bi bi-file-text"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-flag me-1"></i> Germany</td>
                                    <td>Training Workshop</td>
                                    <td>Nov 5 - Nov 12, 2025</td>
                                    <td><span class="badge badge-status bg-primary">Upcoming</span></td>
                                    <td class="table-actions">
                                        <button class="btn btn-sm btn-outline-primary me-1">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-secondary">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-flag me-1"></i> Singapore</td>
                                    <td>Client Meeting</td>
                                    <td>Sep 20 - Sep 25, 2025</td>
                                    <td><span class="badge badge-status bg-secondary">Completed</span></td>
                                    <td class="table-actions">
                                        <button class="btn btn-sm btn-outline-primary me-1">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-info">
                                            <i class="bi bi-download"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-flag me-1"></i> Canada</td>
                                    <td>Conference</td>
                                    <td>Aug 10 - Aug 15, 2025</td>
                                    <td><span class="badge badge-status bg-secondary">Completed</span></td>
                                    <td class="table-actions">
                                        <button class="btn btn-sm btn-outline-primary me-1">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-info">
                                            <i class="bi bi-download"></i>
                                        </button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Recent Expenses -->
                <div class="card shadow-sm">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Recent Expenses</h5>
                        <button class="btn btn-sm btn-primary">
                            <i class="bi bi-plus-circle me-1"></i> Add Expense
                        </button>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                <tr>
                                    <th>Date</th>
                                    <th>Category</th>
                                    <th>Description</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>Oct 18, 2025</td>
                                    <td><i class="bi bi-building me-1"></i> Accommodation</td>
                                    <td>Hotel - 3 nights</td>
                                    <td>$450.00</td>
                                    <td><span class="badge bg-warning text-dark">Pending</span></td>
                                </tr>
                                <tr>
                                    <td>Oct 17, 2025</td>
                                    <td><i class="bi bi-train-front me-1"></i> Transport</td>
                                    <td>Train tickets</td>
                                    <td>$85.50</td>
                                    <td><span class="badge bg-warning text-dark">Pending</span></td>
                                </tr>
                                <tr>
                                    <td>Oct 16, 2025</td>
                                    <td><i class="bi bi-cup-hot me-1"></i> Meals</td>
                                    <td>Business lunch</td>
                                    <td>$65.00</td>
                                    <td><span class="badge bg-success">Approved</span></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Quick Actions -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0">Quick Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button class="btn btn-outline-primary text-start">
                                <i class="bi bi-file-earmark-text me-2"></i> Submit Travel Report
                            </button>
                            <button class="btn btn-outline-success text-start">
                                <i class="bi bi-receipt me-2"></i> Submit Expense
                            </button>
                            <button class="btn btn-outline-info text-start">
                                <i class="bi bi-calendar-check me-2"></i> Request Time Off
                            </button>
                            <button class="btn btn-outline-warning text-start">
                                <i class="bi bi-geo-alt me-2"></i> Update Location
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Travel Documents -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0">My Documents</h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <a href="#" class="list-group-item list-group-item-action border-0 px-0">
                                <div class="d-flex align-items-center">
                                    <div class="bg-danger bg-opacity-10 text-danger rounded p-2 me-3">
                                        <i class="bi bi-file-pdf"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0">Passport Copy</h6>
                                        <small class="text-muted">Expires: Jan 2028</small>
                                    </div>
                                </div>
                            </a>
                            <a href="#" class="list-group-item list-group-item-action border-0 px-0">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 text-primary rounded p-2 me-3">
                                        <i class="bi bi-file-earmark"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0">UK Visa</h6>
                                        <small class="text-success">Valid</small>
                                    </div>
                                </div>
                            </a>
                            <a href="#" class="list-group-item list-group-item-action border-0 px-0">
                                <div class="d-flex align-items-center">
                                    <div class="bg-info bg-opacity-10 text-info rounded p-2 me-3">
                                        <i class="bi bi-shield-check"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0">Travel Insurance</h6>
                                        <small class="text-muted">Valid until Dec 2025</small>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <button class="btn btn-sm btn-outline-primary w-100 mt-3">
                            <i class="bi bi-upload me-1"></i> Upload Document
                        </button>
                    </div>
                </div>

                <!-- Upcoming Events -->
                <div class="card shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0">Upcoming Events</h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item border-0 px-0">
                                <div class="d-flex">
                                    <div class="text-center me-3" style="min-width: 50px;">
                                        <div class="fs-4 fw-bold text-primary">25</div>
                                        <div class="text-muted small">OCT</div>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Return from UK</h6>
                                        <small class="text-muted">Assignment completion</small>
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item border-0 px-0">
                                <div class="d-flex">
                                    <div class="text-center me-3" style="min-width: 50px;">
                                        <div class="fs-4 fw-bold text-success">05</div>
                                        <div class="text-muted small">NOV</div>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Depart to Germany</h6>
                                        <small class="text-muted">Training workshop</small>
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item border-0 px-0">
                                <div class="d-flex">
                                    <div class="text-center me-3" style="min-width: 50px;">
                                        <div class="fs-4 fw-bold text-warning">30</div>
                                        <div class="text-muted small">OCT</div>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Report Deadline</h6>
                                        <small class="text-muted">UK assignment report</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
