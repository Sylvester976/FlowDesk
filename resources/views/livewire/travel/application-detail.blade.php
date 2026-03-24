<div>
<div class="main-content">

    @php
        $app  = $application;
        $user = $app->user;
    @endphp

    <div class="page-header">
        <div>
            <h1 class="page-title">Application — {{ $app->reference_number }}</h1>
            <nav class="breadcrumb">
                <a href="{{ route('dashboard') }}" class="breadcrumb-item">Home</a>
                <a href="{{ route('travel.index') }}" class="breadcrumb-item">My Applications</a>
                <span class="breadcrumb-item active">{{ $app->reference_number }}</span>
            </nav>
        </div>
        <div class="page-header-actions">
            <a href="{{ route('travel.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Back
            </a>
        </div>
    </div>

    {{-- Status banner --}}
    @php
        $bannerBg = match($app->status) {
            'concurred'                       => '#e8f5ee',
            'not_concurred'                   => '#ffebee',
            'returned'                        => '#fff8e1',
            'pending_concurrence','submitted' => '#e8f0fb',
            default                           => 'var(--bs-tertiary-bg)',
        };
        $bannerBorder = match($app->status) {
            'concurred'                       => '#006b3f',
            'not_concurred'                   => '#bb0000',
            'returned'                        => '#c8a951',
            'pending_concurrence','submitted' => '#1a3a6b',
            default                           => 'var(--bs-border-color)',
        };
        $typeColor = match($app->travel_type) {
            'foreign_official' => '#1a3a6b',
            'foreign_private'  => '#006b3f',
            'local'            => '#78620a',
        };
    @endphp

    <div class="card mb-3 border-0"
        style="background:{{ $bannerBg }};border-left:4px solid {{ $bannerBorder }} !important;">
        <div class="card-body py-2 d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-{{ $app->getStatusColor() }}-subtle
                    text-{{ $app->getStatusColor() }}
                    border border-{{ $app->getStatusColor() }}-subtle"
                    style="font-size:.8rem;">
                    {{ $app->getStatusLabel() }}
                </span>
                <span class="text-muted" style="font-size:.82rem;">
                    Submitted {{ $app->created_at->format('d M Y, H:i') }}
                </span>
            </div>
            <span class="badge fw-medium"
                style="background:{{ $typeColor }}1a;color:{{ $typeColor }};font-size:.78rem;">
                {{ $app->getTravelTypeLabel() }}
            </span>
        </div>
    </div>

    <div class="row g-3">

        {{-- ── LEFT COLUMN ────────────────────────────────── --}}
        <div class="col-12 col-lg-8">

            {{-- Trip details --}}
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-map me-2" style="color:#1a3a6b;"></i>Trip Details
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12 col-sm-6">
                            <div class="text-muted mb-1" style="font-size:.75rem;text-transform:uppercase;letter-spacing:.04em;">Destination</div>
                            <div class="fw-medium">
                                @if($app->country) {{ $app->country->name }}
                                @elseif($app->county) {{ $app->county->name }} County
                                @endif
                                @if($app->destination_details)
                                    <span class="text-muted fw-normal"> &mdash; {{ $app->destination_details }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="text-muted mb-1" style="font-size:.75rem;text-transform:uppercase;letter-spacing:.04em;">Travel Dates</div>
                            <div class="fw-medium">
                                {{ $app->departure_date->format('d M Y') }}
                                &rarr; {{ $app->return_date->format('d M Y') }}
                                <span class="text-muted fw-normal" style="font-size:.82rem;">
                                    ({{ $app->getDurationDays() }} day(s))
                                </span>
                            </div>
                        </div>
                        @if($app->per_diem_days)
                        <div class="col-12 col-sm-6">
                            <div class="text-muted mb-1" style="font-size:.75rem;text-transform:uppercase;letter-spacing:.04em;">Per Diem Days</div>
                            <div class="fw-medium">{{ $app->per_diem_days }} day(s)</div>
                        </div>
                        @endif
                        @if($app->funding_source)
                        <div class="col-12 col-sm-6">
                            <div class="text-muted mb-1" style="font-size:.75rem;text-transform:uppercase;letter-spacing:.04em;">Funding Source</div>
                            <div class="fw-medium">{{ $app->funding_source }}</div>
                        </div>
                        @endif
                        <div class="col-12">
                            <div class="text-muted mb-1" style="font-size:.75rem;text-transform:uppercase;letter-spacing:.04em;">Purpose &amp; Activities</div>
                            <div style="font-size:.88rem;line-height:1.8;white-space:pre-line;">{{ $app->purpose }}</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Documents --}}
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-paperclip me-2" style="color:#1a3a6b;"></i>
                        Documents
                        <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle ms-1"
                            style="font-size:.72rem;">{{ $app->documents->count() }}</span>
                    </h5>
                </div>
                <div class="card-body">
                    @if($app->documents->count())
                    <div class="row g-2">
                        @foreach($app->documents as $doc)
                        @php
                            $isPdf = $doc->mime_type === 'application/pdf'
                                || strtolower(pathinfo($doc->original_name, PATHINFO_EXTENSION)) === 'pdf';
                            $sizeLabel = $doc->file_size
                                ? ($doc->file_size >= 1024 * 1024
                                    ? round($doc->file_size / 1024 / 1024, 1) . 'MB'
                                    : round($doc->file_size / 1024) . 'KB')
                                : null;
                        @endphp
                        <div class="col-12 col-sm-6">
                            <a href="{{ route('travel.document', $doc->id) }}"
                                target="_blank"
                                rel="noopener"
                                class="d-flex align-items-center gap-2 p-2 rounded border text-decoration-none
                                    {{ $isPdf ? '' : '' }}"
                                style="transition:background .15s;"
                                onmouseover="this.style.background='var(--bs-tertiary-bg)'"
                                onmouseout="this.style.background='transparent'">

                                <div style="width:38px;height:38px;border-radius:8px;flex-shrink:0;
                                    display:flex;align-items:center;justify-content:center;
                                    background:{{ $isPdf ? '#fff0f0' : '#e8f0fb' }};">
                                    <i class="bi {{ $isPdf ? 'bi-file-earmark-pdf' : 'bi-file-earmark-image' }}"
                                        style="font-size:1.1rem;color:{{ $isPdf ? '#dc3545' : '#1a3a6b' }};"></i>
                                </div>

                                <div class="flex-grow-1 min-width-0">
                                    <div class="fw-medium" style="font-size:.83rem;color:var(--bs-body-color);">
                                        {{ $doc->getTypeLabel() }}
                                    </div>
                                    <div class="text-muted text-truncate" style="font-size:.74rem;">
                                        {{ $doc->original_name }}
                                        @if($sizeLabel) &mdash; {{ $sizeLabel }} @endif
                                    </div>
                                </div>

                                <i class="bi bi-box-arrow-up-right text-muted flex-shrink-0"
                                    style="font-size:.78rem;" title="Open in new tab"></i>
                            </a>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <p class="text-muted mb-0" style="font-size:.85rem;">No documents attached.</p>
                    @endif
                </div>
            </div>

            {{-- Concurrence (foreign official only) --}}
            @if($app->isForeignOfficial() && $app->concurrenceSteps->count())
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-person-check me-2" style="color:#1a3a6b;"></i>Concurrence
                    </h5>
                </div>
                <div class="card-body p-0">
                    @foreach($app->concurrenceSteps as $cs)
                    <div class="p-3 d-flex align-items-start gap-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                        <div class="user-initials-avatar" style="width:34px;height:34px;font-size:.7rem;flex-shrink:0;">
                            {{ strtoupper(substr($cs->approver->first_name,0,1).substr($cs->approver->last_name,0,1)) }}
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex align-items-center gap-2 flex-wrap">
                                <span class="fw-medium" style="font-size:.88rem;">{{ $cs->approver->full_name }}</span>
                                <span class="text-muted" style="font-size:.78rem;">{{ $cs->approver->role?->label }}</span>
                                @php
                                    $ac = match($cs->action) {
                                        'concurred'     => 'success',
                                        'not_concurred' => 'danger',
                                        'returned'      => 'warning',
                                        default         => 'secondary',
                                    };
                                @endphp
                                <span class="badge bg-{{ $ac }}-subtle text-{{ $ac }} border border-{{ $ac }}-subtle"
                                    style="font-size:.72rem;">
                                    {{ $cs->action === 'pending' ? 'Awaiting action' : ucfirst(str_replace('_', ' ', $cs->action)) }}
                                </span>
                            </div>
                            @if($cs->comments)
                            <div class="mt-1 p-2 rounded" style="background:var(--bs-tertiary-bg);font-size:.82rem;">
                                {{ $cs->comments }}
                            </div>
                            @endif
                            @if($cs->acted_at)
                            <div class="text-muted mt-1" style="font-size:.74rem;">
                                {{ $cs->acted_at->format('d M Y, H:i') }}
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Audit trail --}}
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-clock-history me-2" style="color:#1a3a6b;"></i>Activity Log
                    </h5>
                </div>
                <div class="card-body p-0">
                    @forelse($app->logs->sortByDesc('created_at') as $log)
                    <div class="d-flex gap-3 p-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                        <div style="width:8px;height:8px;border-radius:50%;background:#1a3a6b;
                            flex-shrink:0;margin-top:7px;"></div>
                        <div>
                            <div class="fw-medium" style="font-size:.84rem;">
                                {{ ucfirst(str_replace('_', ' ', $log->action)) }}
                            </div>
                            @if($log->description)
                            <div class="text-muted" style="font-size:.8rem;">{{ $log->description }}</div>
                            @endif
                            <div class="text-muted" style="font-size:.74rem;">
                                {{ $log->user?->full_name }} &mdash;
                                {{ $log->created_at->format('d M Y, H:i') }}
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="p-3 text-muted" style="font-size:.85rem;">No activity recorded.</div>
                    @endforelse
                </div>
            </div>

        </div>

        {{-- ── RIGHT COLUMN ────────────────────────────────── --}}
        <div class="col-12 col-lg-4">

            {{-- Applicant info --}}
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-person me-2" style="color:#1a3a6b;"></i>Applicant
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div class="user-initials-avatar" style="width:40px;height:40px;font-size:.82rem;">
                            {{ strtoupper(substr($user->first_name,0,1).substr($user->last_name,0,1)) }}
                        </div>
                        <div>
                            <div class="fw-semibold" style="font-size:.88rem;">{{ $user->full_name }}</div>
                            <div class="text-muted" style="font-size:.78rem;">{{ $user->email }}</div>
                        </div>
                    </div>
                    <table style="width:100%;font-size:.82rem;">
                        <tr>
                            <td class="text-muted pb-1" style="width:45%;">Role</td>
                            <td class="pb-1">{{ $user->role?->label ?? '—' }}</td>
                        </tr>
                        @if($user->jobTitle)
                        <tr>
                            <td class="text-muted pb-1">Job Title</td>
                            <td class="pb-1">{{ $user->jobTitle->name }}</td>
                        </tr>
                        @endif
                        @if($user->department)
                        <tr>
                            <td class="text-muted pb-1">Division</td>
                            <td class="pb-1">{{ $user->department->name }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted pb-1">Directorate</td>
                            <td class="pb-1">{{ $user->department->directorate?->name ?? '—' }}</td>
                        </tr>
                        @endif
                        @if($user->supervisor)
                        <tr>
                            <td class="text-muted pb-1">Supervisor</td>
                            <td class="pb-1">{{ $user->supervisor->full_name }}</td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>

            {{-- Clearance letter --}}
            @if($app->clearance_letter_path)
            <div class="card mb-3" style="border-color:#006b3f;">
                <div class="card-body text-center py-4">
                    <i class="bi bi-file-earmark-check fs-2 mb-2" style="color:#006b3f;"></i>
                    <div class="fw-semibold mb-1" style="color:#006b3f;">Clearance Letter</div>
                    <div class="text-muted mb-3" style="font-size:.78rem;">
                        Generated {{ $app->clearance_letter_generated_at?->format('d M Y') }}
                    </div>
                    <a href="{{ route('travel.clearance', $app->id) }}" target="_blank"
                        class="btn btn-sm btn-success">
                        <i class="bi bi-download me-1"></i> Download
                    </a>
                </div>
            </div>
            @endif

            {{-- Post-trip uploads --}}
            @if(in_array($app->status, ['concurred', 'submitted', 'pending_uploads']))
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-upload me-2" style="color:#1a3a6b;"></i>Post-Trip
                    </h5>
                </div>
                <div class="card-body">
                    @if($app->postTripUpload)
                        <span class="badge bg-success-subtle text-success border border-success-subtle">
                            <i class="bi bi-check-circle me-1"></i>Uploaded
                        </span>
                    @elseif($app->return_date->isPast())
                        <p class="text-muted mb-2" style="font-size:.82rem;">
                            Your trip has ended. Please upload post-trip documents.
                        </p>
                        <a href="{{ route('travel.post-trip') }}" class="btn btn-sm btn-warning">
                            <i class="bi bi-upload me-1"></i> Upload Now
                        </a>
                    @else
                        <p class="text-muted mb-0" style="font-size:.82rem;">
                            Post-trip uploads required after
                            {{ $app->return_date->format('d M Y') }}.
                        </p>
                    @endif
                </div>
            </div>
            @endif

        </div>
    </div>

</div>
</div>
