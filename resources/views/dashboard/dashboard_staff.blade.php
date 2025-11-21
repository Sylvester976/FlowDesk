@extends('layouts.base_staff')

@section('main-content')
    <!-- User Dashboard Content -->
    <div id="user-dashboard-section">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-1">Welcome back, {{ Auth::user()->name }}!</h2>
                <p class="text-muted mb-0">Manage your travel assignments and expenses</p>
            </div>
            <a href="{{ route('assignment_add') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle me-2"></i> New Travel Request
            </a>
        </div>

        <!-- User Statistics Cards -->
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="card stat-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="text-muted mb-1">My Trips</p>
                                <h3 class="mb-0">{{$mytrips}}</h3>
                                <small class="text-muted">This year</small>
                            </div>
                            <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                                <i class="fas fa-plane-arrival"></i>
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
                                <h3 class="mb-0">{{ $active_assignments }}</h3>
                                <small class="text-success">Currently traveling</small>
                            </div>
                            <div class="stat-icon bg-success bg-opacity-10 text-success">
                                <i class="fas fa-briefcase"></i>
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
                                <p class="text-muted mb-1">Assignments in Kenya</p>
                                <h3 class="mb-0">{{$kenya_places}}</h3>
                                <small class="text-warning">local trips</small>
                            </div>
                            <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                                <i class="fas fa-receipt"></i>
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
                                <h3 class="mb-0">{{$countries_visited}}</h3>
                                <small class="text-success">Trips in Kenya: {{$kenya_places}}</small>
                            </div>
                            <div class="stat-icon bg-info bg-opacity-10 text-info">
                                <i class="fas fa-globe"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Current Assignment Alert -->
        <div class="alert alert-info d-flex align-items-center mb-4" role="alert">

            @if($current_assignment)
                <i class="fas fa-info-circle me-3 fs-4"></i>
                <div class="flex-grow-1">
                    <strong>Current Assignment:</strong>
                    You are currently on assignment in
                    <strong>{{ $current_assignment_country }}</strong>
                    until
                    <strong>{{ $current_assignment_end_date }}</strong>
                </div>

                <a href="{{ route('assignHistory') }}"
                   class="btn btn-sm btn-outline-info">
                    View Details
                </a>
            @else
                <i class="fas fa-info-circle-fill me-3 fs-4"></i>
                <div class="flex-grow-1">
                    <strong>No active assignment.</strong>
                </div>
            @endif

        </div>


        <!-- Main Content Row -->
        <div class="row g-8">
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
                                    <td><i class="fas fa-flag me-1"></i> United Kingdom</td>
                                    <td>Project Consultation</td>
                                    <td>Oct 15 - Oct 25, 2025</td>
                                    <td><span class="badge badge-status bg-warning">Active</span></td>
                                    <td class="table-actions">
                                        <button class="btn btn-sm btn-outline-primary me-1" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-success" title="Submit Report">
                                            <i class="fas fa-file-text"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td><i class="fas fa-flag me-1"></i> Germany</td>
                                    <td>Training Workshop</td>
                                    <td>Nov 5 - Nov 12, 2025</td>
                                    <td><span class="badge badge-status bg-primary">Upcoming</span></td>
                                    <td class="table-actions">
                                        <button class="btn btn-sm btn-outline-primary me-1">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-secondary">
                                            <i class="fas fa-pencil"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td><i class="fas fa-flag me-1"></i> Singapore</td>
                                    <td>Client Meeting</td>
                                    <td>Sep 20 - Sep 25, 2025</td>
                                    <td><span class="badge badge-status bg-success">Completed</span></td>
                                    <td class="table-actions">
                                        <button class="btn btn-sm btn-outline-primary me-1">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-info">
                                            <i class="fas fa-download"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td><i class="fas fa-flag me-1"></i> Canada</td>
                                    <td>Conference</td>
                                    <td>Aug 10 - Aug 15, 2025</td>
                                    <td><span class="badge badge-status bg-success">Completed</span></td>
                                    <td class="table-actions">
                                        <button class="btn btn-sm btn-outline-primary me-1">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-info">
                                            <i class="fas fa-download"></i>
                                        </button>
                                    </td>
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
                                <i class="fas fa-file-alt me-2"></i>Submit Travel Report
                            </button>
                            <button class="btn btn-outline-info text-start">
                                <i class="fas fa-calendar-check me-2"></i> Request Time Off
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
