<div>
<div class="main-content">

    <div class="page-header">
        <div>
            <h1 class="page-title">Reports &amp; Exports</h1>
            <nav class="breadcrumb">
                <a href="{{ route('dashboard') }}" class="breadcrumb-item">Home</a>
                <span class="breadcrumb-item active">Reports</span>
            </nav>
        </div>
    </div>

    <div class="row g-3">

        {{-- Applications export --}}
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-airplane me-2" style="color:#1a3a6b;"></i>
                        Applications Report
                    </h5>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-3" style="font-size:.83rem;">
                        Export all travel applications with full details —
                        staff, destination, dates, status, funding source and clearance info.
                    </p>
                    <div class="mb-2">
                        <label class="form-label fw-medium" style="font-size:.82rem;">Year</label>
                        <select wire:model="appYear" class="form-select form-select-sm">
                            @foreach($years as $yr)
                            <option value="{{ $yr }}">{{ $yr }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-2">
                        <label class="form-label fw-medium" style="font-size:.82rem;">Status (optional)</label>
                        <select wire:model="appStatus" class="form-select form-select-sm">
                            <option value="">All Statuses</option>
                            <option value="submitted">Submitted</option>
                            <option value="pending_concurrence">Pending Concurrence</option>
                            <option value="concurred">Concurred</option>
                            <option value="returned">Returned</option>
                            <option value="not_concurred">Not Concurred</option>
                            <option value="pending_uploads">Pending Uploads</option>
                            <option value="closed">Closed</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium" style="font-size:.82rem;">Type (optional)</label>
                        <select wire:model="appType" class="form-select form-select-sm">
                            <option value="">All Types</option>
                            <option value="foreign_official">Foreign Official</option>
                            <option value="foreign_private">Foreign Private</option>
                            <option value="local">Local</option>
                        </select>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('reports.applications', ['year' => $appYear, 'status' => $appStatus, 'type' => $appType]) }}"
                        class="btn btn-primary btn-sm w-100">
                        <i class="bi bi-download me-1"></i> Download CSV
                    </a>
                </div>
            </div>
        </div>

        {{-- Travel summary --}}
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-file-earmark-text me-2" style="color:#006b3f;"></i>
                        Travel Summary Report
                    </h5>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-3" style="font-size:.83rem;">
                        Export all completed (closed) trips with post-trip details —
                        actual costs, destinations, report submission dates.
                    </p>
                    <div class="mb-3">
                        <label class="form-label fw-medium" style="font-size:.82rem;">Year</label>
                        <select wire:model="summaryYear" class="form-select form-select-sm">
                            @foreach($years as $yr)
                            <option value="{{ $yr }}">{{ $yr }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="p-2 rounded" style="background:#e8f5ee;font-size:.78rem;color:#085041;">
                        <i class="bi bi-info-circle me-1"></i>
                        Only includes applications with status <strong>Closed</strong>.
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('reports.summary', ['year' => $summaryYear]) }}"
                        class="btn btn-success btn-sm w-100">
                        <i class="bi bi-download me-1"></i> Download CSV
                    </a>
                </div>
            </div>
        </div>

        {{-- Days docket --}}
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-calendar-check me-2" style="color:#c8a951;"></i>
                        Days Docket Report
                    </h5>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-3" style="font-size:.83rem;">
                        Export all active staff with their foreign travel days —
                        days used, remaining, and percentage of annual limit.
                    </p>
                    <div class="p-3 rounded mb-3" style="background:var(--bs-tertiary-bg);font-size:.82rem;">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted">Includes:</span>
                            <span>All active staff</span>
                        </div>
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted">Columns:</span>
                            <span>PF, Name, Role, Days</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Status flags:</span>
                            <span>OK / Warning / Exceeded</span>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('reports.docket') }}"
                        class="btn btn-warning btn-sm w-100">
                        <i class="bi bi-download me-1"></i> Download CSV
                    </a>
                </div>
            </div>
        </div>

    </div>

    {{-- Quick stats --}}
    <div class="card mt-3">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="bi bi-bar-chart me-2" style="color:#1a3a6b;"></i>
                Quick Stats — {{ now()->year }}
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Report</th>
                            <th>Count</th>
                            <th class="d-none d-sm-table-cell">Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            use App\Models\TravelApplication;
                            use App\Models\User;
                            $statsRows = [
                                ['Total Applications', \App\Models\TravelApplication::whereYear('created_at', now()->year)->count(), 'All submitted this year'],
                                ['Foreign Official', \App\Models\TravelApplication::whereYear('created_at', now()->year)->where('travel_type','foreign_official')->count(), 'Official travel abroad'],
                                ['Foreign Private', \App\Models\TravelApplication::whereYear('created_at', now()->year)->where('travel_type','foreign_private')->count(), 'Personal travel abroad'],
                                ['Local', \App\Models\TravelApplication::whereYear('created_at', now()->year)->where('travel_type','local')->count(), 'Travel within Kenya'],
                                ['Closed / Completed', \App\Models\TravelApplication::whereYear('created_at', now()->year)->where('status','closed')->count(), 'Full cycle completed'],
                                ['Staff at Limit', \App\Models\User::where('status','active')->whereRaw('days_used_this_year >= max_days_per_year')->count(), 'Days docket exhausted'],
                            ];
                        @endphp
                        @foreach($statsRows as [$label, $count, $desc])
                        <tr>
                            <td class="fw-medium" style="font-size:.85rem;">{{ $label }}</td>
                            <td>
                                <span class="badge bg-primary-subtle text-primary border border-primary-subtle"
                                    style="font-size:.8rem;">{{ $count }}</span>
                            </td>
                            <td class="d-none d-sm-table-cell text-muted" style="font-size:.8rem;">
                                {{ $desc }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
</div>
