@php use Carbon\Carbon; @endphp
@extends('layouts.base_hr')

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
            <div class="col-md-12">
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
        </div>

        <!-- Recent Assignments & Reports -->
        <div class="row g-4">
            <div class="col-lg-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0">Recent Employees</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                <tr>
                                    <th>Names</th>
                                    <th>PF Number </th>
                                    <th>date of appointment</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($recent_staffs as $recent_staff)
                                    <tr>
                                        @php
                                            $fullname = getUsernames($recent_staff->id);
                                            $avatar = 'https://ui-avatars.com/api/?name=' . urlencode($fullname) . '&background=0D8ABC&color=fff';
                                        @endphp
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $avatar }}"
                                                     class="rounded-circle me-2"
                                                     width="32"
                                                     height="32"
                                                     alt="{{ $fullname }}">
                                                <span>{{ $fullname }}</span>
                                            </div>
                                        </td>

                                        <td>
                                            {{ $recent_staff->pfNumber }}
                                        </td>

                                        <td>{{ Carbon::parse($recent_staff->date_of_appointment)->format('M d, Y') }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
