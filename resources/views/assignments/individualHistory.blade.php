@php use Carbon\Carbon; @endphp
@extends('layouts.base')

@section('main-content')
    <div class="page">
        <div class="page-wrapper">
            <div class="page-header d-print-none">
                <div class="container-xl">
                    <div class="row g-2 align-items-center">
                        <div class="col">
                            <h2 class="page-title">User Details</h2>
                            <div class="text-muted mt-1">View user information and assignment history</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="page-body">
                <div class="container-xl">
                    <!-- User Information Card -->
                    <div class="row mb-3">
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="text-center mb-3">
                                        <span class="avatar avatar-xl mb-3" style="background-image: url(https://ui-avatars.com/api/?name=John+Doe&background=0D8ABC&color=fff&size=128)"></span>
                                        <h3 class="m-0 mb-1">{{ $user->name.' '.$user->surname.' '.$user->other_names }}</h3>
                                        <div class="text-muted">{{ $user->designation }}</div>
                                        <div class="mt-3">
                                            <span class="badge bg-success-lt">Active</span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="mb-2">
                                                <i class="ti ti-mail me-2 text-muted"></i>
                                                <span class="text-muted">Email:</span>
                                                <div class="ms-4">{{ $user->email }}</div>
                                            </div>
                                            <div class="mb-2">
                                                <i class="ti ti-id me-2 text-muted"></i>
                                                <span class="text-muted">Personal Number</span>
                                                <div class="ms-4">{{ $user->pfNumber }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Current Assignment Card -->
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="ti ti-briefcase me-2"></i>
                                        Current Assignment
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label text-muted">Project Name</label>
                                                <div class="fw-bold">E-Commerce Platform Redesign</div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label text-muted">Client</label>
                                                <div class="fw-bold">TechCorp Solutions</div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label text-muted">Role</label>
                                                <div>
                                                    <span class="badge bg-blue-lt">Frontend Developer</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label text-muted">Start Date</label>
                                                <div class="fw-bold">October 1, 2024</div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label text-muted">Expected End Date</label>
                                                <div class="fw-bold">March 31, 2025</div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label text-muted">Allocation</label>
                                                <div class="fw-bold">100%</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <label class="form-label text-muted">Project Description</label>
                                        <p class="text-muted mb-0">Leading the frontend development team to redesign and modernize the e-commerce platform with focus on user experience and performance optimization.</p>
                                    </div>
                                    <div class="mt-3">
                                        <label class="form-label text-muted">Progress</label>
                                        <div class="progress">
                                            <div class="progress-bar" style="width: 65%" role="progressbar" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100">
                                                <span>65%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Assignment History Table -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="ti ti-history me-2"></i>
                                        Assignment History
                                    </h3>
                                    <div class="card-actions">
                                        <input type="text" class="form-control form-control-sm" placeholder="Search..." id="searchInput">
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-vcenter card-table table-striped">
                                        <thead>
                                        <tr>
                                            <th>Project Name</th>
                                            <th>Client</th>
                                            <th>Role</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Duration</th>
                                            <th>Status</th>
                                            <th class="w-1"></th>
                                        </tr>
                                        </thead>
                                        <tbody id="assignmentTableBody">
                                        <tr>
                                            <td>E-Commerce Platform Redesign</td>
                                            <td>TechCorp Solutions</td>
                                            <td><span class="badge bg-blue-lt">Frontend Developer</span></td>
                                            <td>Oct 1, 2024</td>
                                            <td>Mar 31, 2025</td>
                                            <td>6 months</td>
                                            <td><span class="badge bg-success">Active</span></td>
                                            <td><button class="btn btn-sm btn-ghost-primary">View</button></td>
                                        </tr>
                                        <tr>
                                            <td>Mobile Banking App</td>
                                            <td>FinanceOne Bank</td>
                                            <td><span class="badge bg-purple-lt">Full Stack Developer</span></td>
                                            <td>Apr 15, 2024</td>
                                            <td>Sep 30, 2024</td>
                                            <td>5.5 months</td>
                                            <td><span class="badge bg-info">Completed</span></td>
                                            <td><button class="btn btn-sm btn-ghost-primary">View</button></td>
                                        </tr>
                                        <tr>
                                            <td>Cloud Migration Project</td>
                                            <td>DataSystems Inc</td>
                                            <td><span class="badge bg-green-lt">DevOps Engineer</span></td>
                                            <td>Jan 10, 2024</td>
                                            <td>Apr 10, 2024</td>
                                            <td>3 months</td>
                                            <td><span class="badge bg-info">Completed</span></td>
                                            <td><button class="btn btn-sm btn-ghost-primary">View</button></td>
                                        </tr>
                                        <tr>
                                            <td>Customer Portal Development</td>
                                            <td>RetailMax Corp</td>
                                            <td><span class="badge bg-blue-lt">Frontend Developer</span></td>
                                            <td>Sep 1, 2023</td>
                                            <td>Dec 31, 2023</td>
                                            <td>4 months</td>
                                            <td><span class="badge bg-info">Completed</span></td>
                                            <td><button class="btn btn-sm btn-ghost-primary">View</button></td>
                                        </tr>
                                        <tr>
                                            <td>Inventory Management System</td>
                                            <td>LogiTech Solutions</td>
                                            <td><span class="badge bg-purple-lt">Full Stack Developer</span></td>
                                            <td>Apr 1, 2023</td>
                                            <td>Aug 31, 2023</td>
                                            <td>5 months</td>
                                            <td><span class="badge bg-info">Completed</span></td>
                                            <td><button class="btn btn-sm btn-ghost-primary">View</button></td>
                                        </tr>
                                        <tr>
                                            <td>AI Chatbot Integration</td>
                                            <td>ServiceHub Ltd</td>
                                            <td><span class="badge bg-orange-lt">Backend Developer</span></td>
                                            <td>Jan 15, 2023</td>
                                            <td>Mar 31, 2023</td>
                                            <td>2.5 months</td>
                                            <td><span class="badge bg-info">Completed</span></td>
                                            <td><button class="btn btn-sm btn-ghost-primary">View</button></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="card-footer d-flex align-items-center">
                                    <p class="m-0 text-muted">Showing <span>1</span> to <span>6</span> of <span>6</span> entries</p>
                                    <ul class="pagination m-0 ms-auto">
                                        <li class="page-item disabled">
                                            <a class="page-link" href="#" tabindex="-1">
                                                <i class="ti ti-chevron-left"></i> Prev
                                            </a>
                                        </li>
                                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                        <li class="page-item disabled">
                                            <a class="page-link" href="#">
                                                Next <i class="ti ti-chevron-right"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Simple search functionality
        document.getElementById('searchInput').addEventListener('keyup', function() {
            const searchValue = this.value.toLowerCase();
            const tableRows = document.querySelectorAll('#assignmentTableBody tr');

            tableRows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchValue) ? '' : 'none';
            });
        });

        // Add click handlers for view buttons
        document.querySelectorAll('.btn-ghost-primary').forEach(btn => {
            btn.addEventListener('click', function() {
                alert('View assignment details functionality would go here');
            });
        });
    </script>
@endsection
