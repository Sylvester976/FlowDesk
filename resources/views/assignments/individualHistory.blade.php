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
                                        @php
                                            $fullName = trim($user->name.' '.$user->surname.' '.$user->other_names);
                                            $avatarUrl = "https://ui-avatars.com/api/?name=".urlencode($fullName)."&background=0D8ABC&color=fff&size=128";
                                        @endphp
                                        <span class="avatar avatar-xl mb-3" style="background-image: url({{$avatarUrl}})"></span>
                                        <h3 class="m-0 mb-1">{{ $fullName }}</h3>
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
                                    @if($current_assignments)
                                        <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label text-muted">Assignment Name</label>
                                                <div class="fw-bold">{{ $current_assignments->assignment_name }}</div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label text-muted">Country of Visit</label>
                                                <div class="fw-bold">{{ getCountryName($current_assignments->country_of_visit) }}</div>
                                            </div>
                                            @if ($current_assignments->country_of_visit == 87)
                                                <div class="mb-3">
                                                    <label class="form-label text-muted">County</label>
                                                    <div>
                                                        <span class="badge bg-blue-lt">{{ getCountyName($current_assignments->county) }}</span>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label text-muted">Subcounty</label>
                                                    <div>
                                                        <span class="badge bg-blue-lt">{{ getSubcountyName($current_assignments->subcounty) }}</span>
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="mb-3">
                                                <label class="form-label text-muted">City/town</label>
                                                <div>
                                                    <span class="badge bg-blue-lt">{{ $current_assignments->city }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label text-muted">Start Date</label>
                                                <div class="fw-bold">{{ Carbon::parse($current_assignments->start_date)->format('M d, Y') }}</div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label text-muted">Expected End Date</label>
                                                <div class="fw-bold">{{ Carbon::parse($current_assignments->end_date)->format('M d, Y') }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    @else
                                        <div class="text-center py-4 text-muted">
                                            <i class="fas fa-info-circle me-1"></i> No pending assignment
                                        </div>
                                    @endif
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
                                </div>
                                <div class="table-responsive">
                                    <table id="assignmentsTable" class="table table-vcenter card-table table-striped">
                                        <thead>
                                        <tr>
                                            <th>Assignment Name</th>
                                            <th>Country of Visit</th>
                                            <th>City/town</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Duration</th>
                                            <th>Status</th>
                                            <th class="w-1">Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($my_assignments as $my_assignment)
                                            <tr>
                                                <td>{{ $my_assignment->assignment_name }}</td>
                                                <td>{{ getCountryName($my_assignment->country_of_visit) }}</td>
                                                <td>{{ $my_assignment->city }}</td>
                                                <td>{{ \Carbon\Carbon::parse($my_assignment->start_date)->format('d M Y') }}</td>
                                                <td>{{ \Carbon\Carbon::parse($my_assignment->end_date)->format('d M Y') }}</td>
                                                <td>{{ durationBetween($my_assignment->start_date,$my_assignment->end_date) }}</td>

                                                @php
                                                    $today = \Carbon\Carbon::today();
                                                    $endDate = \Carbon\Carbon::parse($my_assignment->end_date);
                                                    if($endDate < $today) {
                                                        $badgeClass = 'bg-success';
                                                        $statusText = 'Complete';
                                                    } else {
                                                        switch(strtolower($my_assignment->status)) {
                                                            case 'pending':
                                                                $badgeClass = 'bg-warning';
                                                                break;
                                                            case 'cancelled':
                                                                $badgeClass = 'bg-danger';
                                                                break;
                                                            default:
                                                                $badgeClass = 'bg-info';
                                                        }
                                                        $statusText = ucfirst($my_assignment->status);
                                                    }
                                                @endphp

                                                <td><span class="badge {{ $badgeClass }}">{{ $statusText }}</span></td>
                                                <td><button class="btn btn-sm btn-ghost-primary">View Attachments</button></td>
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
        </div>
    </div>
    <script src="{{ asset ('js/jquery-3.7.1.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#assignmentsTable').DataTable({
                "pageLength": 10,
                "lengthChange": false,
                "language": {
                    search: "_INPUT_",
                    searchPlaceholder: "Search assignments..."
                }
            });
        });
    </script>
@endsection
