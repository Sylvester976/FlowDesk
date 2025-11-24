@php use Carbon\Carbon; @endphp
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
                                <h3 class="mb-0">{{ $employee_no }}</h3>
                                <small class="text-success"><i class="fas fa-arrow-up"></i> 12% from last month</small>
                            </div>
                            <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                                <i class="fas fa-users"></i>
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
                                <h3 class="mb-0">{{ $currently_travelling }}</h3>
                                <small class="text-info"><i class="bi bi-arrow-right"></i> 17% of total</small>
                            </div>
                            <div class="stat-icon bg-info bg-opacity-10 text-info">
                                <i class="fas fa-plane"></i>
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
                                <h3 class="mb-0">{{ $active_assignments }}</h3>
                                <small class="text-warning"><i class="fas fa-clock"></i> 15 ending soon</small>
                            </div>
                            <div class="stat-icon bg-warning bg-opacity-10 text-warning">
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
                                <p class="text-muted mb-1">Countries Covered</p>
                                <h3 class="mb-0">{{$countries_covered}}</h3>
                                <small class="text-success"><i class="fas fa-globe-africa"></i> Across 5
                                    continents</small>
                            </div>
                            <div class="stat-icon bg-success bg-opacity-10 text-success">
                                <i class="fas fa-map-marked"></i>
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
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($recent_assignments as $recent_assignment)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="https://ui-avatars.com/api/?name=John+Doe"
                                                     class="rounded-circle me-2" width="32" height="32" alt="Employee">
                                                <span>{{ getUsernames($recent_assignment->user_id) }}</span>
                                            </div>
                                        </td>

                                        <td>
                                            {{ getCountryName($recent_assignment->country_of_visit) }}
                                        </td>

                                        <td>{{ $recent_assignment->assignment_name }}</td>

                                        <td>
                                            {{ Carbon::parse($recent_assignment->start_date)->format('M d, Y') }}
                                        </td>

                                        <td>
                                            <span class="badge bg-success">
                                                {{ $recent_assignment->status }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0">Top Destinations</h5>
                    </div>
                    <div class="card-body">

                        @php
                            $colors = ['bg-primary', 'bg-info', 'bg-success', 'bg-warning', 'bg-danger'];
                        @endphp

                        @foreach($top_countries as $index => $item)
                            @php
                                $percentage = ($item['total'] / $maxTrips) * 100;
                                $colorClass = $colors[$index % count($colors)];
                            @endphp

                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <span>{{ $item['country_name'] }}</span>
                                    <span class="text-muted">{{ $item['total'] }} trips</span>
                                </div>

                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar {{ $colorClass }}"
                                         role="progressbar"
                                         style="width: {{ $percentage }}%">
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>


                </div>
            </div>
        </div>
    </div>
@endsection
