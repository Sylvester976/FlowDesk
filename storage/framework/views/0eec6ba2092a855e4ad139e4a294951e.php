<div>
    <div class="main-content">

        <?php
            $app  = $application;
            $user = $app->user;
        ?>

        <div class="page-header">
            <div>
                <h1 class="page-title">Application — <?php echo e($app->reference_number); ?></h1>
                <nav class="breadcrumb">
                    <a href="<?php echo e(route('dashboard')); ?>" class="breadcrumb-item">Home</a>
                    <a href="<?php echo e(route('travel.index')); ?>" class="breadcrumb-item">My Applications</a>
                    <span class="breadcrumb-item active"><?php echo e($app->reference_number); ?></span>
                </nav>
            </div>
            <div class="page-header-actions d-flex gap-2">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($app->status === 'returned' && $app->user_id === auth()->id()): ?>
                    <a href="<?php echo e(route('travel.edit', $app->id)); ?>" class="btn btn-sm btn-warning">
                        <i class="bi bi-pencil me-1"></i>
                        <span class="d-none d-sm-inline">Revise &amp; Resubmit</span>
                    </a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <a href="<?php echo e(route('travel.index')); ?>" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Back
                </a>
            </div>
        </div>

        
        <?php
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
        ?>

        <div class="card mb-3 border-0"
             style="background:<?php echo e($bannerBg); ?>;border-left:4px solid <?php echo e($bannerBorder); ?> !important;">
            <div class="card-body py-2 d-flex align-items-center justify-content-between flex-wrap gap-2">
                <div class="d-flex align-items-center gap-2">
                <span class="badge bg-<?php echo e($app->getStatusColor()); ?>-subtle
                    text-<?php echo e($app->getStatusColor()); ?>

                    border border-<?php echo e($app->getStatusColor()); ?>-subtle"
                      style="font-size:.8rem;">
                    <?php echo e($app->getStatusLabel()); ?>

                </span>
                    <span class="text-muted" style="font-size:.82rem;">
                    Submitted <?php echo e($app->created_at->format('d M Y, H:i')); ?>

                </span>
                </div>
                <span class="badge fw-medium"
                      style="background:<?php echo e($typeColor); ?>1a;color:<?php echo e($typeColor); ?>;font-size:.78rem;">
                <?php echo e($app->getTravelTypeLabel()); ?>

            </span>
            </div>
        </div>

        <div class="row g-3">

            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($app->status === 'returned' && $app->user_id === auth()->id()): ?>
                <?php $returnStep = $app->concurrenceSteps->where('action', 'returned')->sortByDesc('acted_at')->first(); ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($returnStep): ?>
                    <div class="col-12">
                        <div class="card border-0" style="background:#fff8e1;border-left:4px solid #c8a951 !important;">
                            <div class="card-body py-3">
                                <div class="d-flex align-items-start gap-3 flex-wrap">
                                    <div class="flex-grow-1">
                                        <div class="fw-semibold mb-1" style="color:#78620a;font-size:.88rem;">
                                            <i class="bi bi-arrow-return-left me-1"></i>
                                            Returned by <?php echo e($returnStep->approver->full_name); ?>

                                            (<?php echo e($returnStep->approver->role?->label); ?>)
                                            on <?php echo e($returnStep->acted_at?->format('d M Y, H:i')); ?>

                                        </div>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($returnStep->comments): ?>
                                            <div style="font-size:.84rem;color:#78620a;">
                                                <strong>Comments:</strong> <?php echo e($returnStep->comments); ?>

                                            </div>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                    <a href="<?php echo e(route('travel.edit', $app->id)); ?>"
                                       class="btn btn-sm btn-warning flex-shrink-0">
                                        <i class="bi bi-pencil me-1"></i> Revise &amp; Resubmit
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            
            <div class="col-12 col-lg-8">

                
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-map me-2" style="color:#1a3a6b;"></i>Trip Details
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-12 col-sm-6">
                                <div class="text-muted mb-1"
                                     style="font-size:.75rem;text-transform:uppercase;letter-spacing:.04em;">Destination
                                </div>
                                <div class="fw-medium">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($app->country): ?>
                                        <?php echo e($app->country->name); ?>

                                    <?php elseif($app->county): ?>
                                        <?php echo e($app->county->name); ?> County
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($app->destination_details): ?>
                                        <span
                                            class="text-muted fw-normal"> &mdash; <?php echo e($app->destination_details); ?></span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="text-muted mb-1"
                                     style="font-size:.75rem;text-transform:uppercase;letter-spacing:.04em;">Travel
                                    Dates
                                </div>
                                <div class="fw-medium">
                                    <?php echo e($app->departure_date->format('d M Y')); ?>

                                    &rarr; <?php echo e($app->return_date->format('d M Y')); ?>

                                    <span class="text-muted fw-normal" style="font-size:.82rem;">
                                    (<?php echo e($app->getDurationDays()); ?> day(s))
                                </span>
                                </div>
                            </div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($app->per_diem_days): ?>
                                <div class="col-12 col-sm-6">
                                    <div class="text-muted mb-1"
                                         style="font-size:.75rem;text-transform:uppercase;letter-spacing:.04em;">Per
                                        Diem Days
                                    </div>
                                    <div class="fw-medium"><?php echo e($app->per_diem_days); ?> day(s)</div>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($app->funding_source): ?>
                                <div class="col-12 col-sm-6">
                                    <div class="text-muted mb-1"
                                         style="font-size:.75rem;text-transform:uppercase;letter-spacing:.04em;">Funding
                                        Source
                                    </div>
                                    <div class="fw-medium"><?php echo e($app->funding_source); ?></div>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <div class="col-12">
                                <div class="text-muted mb-1"
                                     style="font-size:.75rem;text-transform:uppercase;letter-spacing:.04em;">Purpose
                                    &amp; Activities
                                </div>
                                <div
                                    style="font-size:.88rem;line-height:1.8;white-space:pre-line;"><?php echo e($app->purpose); ?></div>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-paperclip me-2" style="color:#1a3a6b;"></i>
                            Documents
                            <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle ms-1"
                                  style="font-size:.72rem;"><?php echo e($app->documents->count()); ?></span>
                        </h5>
                    </div>
                    <div class="card-body">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($app->documents->count()): ?>
                            <div class="row g-2">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $app->documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                    <?php
                                        $isPdf = $doc->mime_type === 'application/pdf'
                                            || strtolower(pathinfo($doc->original_name, PATHINFO_EXTENSION)) === 'pdf';
                                        $sizeLabel = $doc->file_size
                                            ? ($doc->file_size >= 1024 * 1024
                                                ? round($doc->file_size / 1024 / 1024, 1) . 'MB'
                                                : round($doc->file_size / 1024) . 'KB')
                                            : null;
                                    ?>
                                    <div class="col-12 col-sm-6">
                                        <a href="<?php echo e(route('travel.document', $doc->id)); ?>"
                                           target="_blank"
                                           rel="noopener"
                                           class="d-flex align-items-center gap-2 p-2 rounded border text-decoration-none
                                    <?php echo e($isPdf ? '' : ''); ?>"
                                           style="transition:background .15s;"
                                           onmouseover="this.style.background='var(--bs-tertiary-bg)'"
                                           onmouseout="this.style.background='transparent'">

                                            <div style="width:38px;height:38px;border-radius:8px;flex-shrink:0;
                                    display:flex;align-items:center;justify-content:center;
                                    background:<?php echo e($isPdf ? '#fff0f0' : '#e8f0fb'); ?>;">
                                                <i class="bi <?php echo e($isPdf ? 'bi-file-earmark-pdf' : 'bi-file-earmark-image'); ?>"
                                                   style="font-size:1.1rem;color:<?php echo e($isPdf ? '#dc3545' : '#1a3a6b'); ?>;"></i>
                                            </div>

                                            <div class="flex-grow-1 min-width-0">
                                                <div class="fw-medium"
                                                     style="font-size:.83rem;color:var(--bs-body-color);">
                                                    <?php echo e($doc->getTypeLabel()); ?>

                                                </div>
                                                <div class="text-muted text-truncate" style="font-size:.74rem;">
                                                    <?php echo e($doc->original_name); ?>

                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($sizeLabel): ?> &mdash; <?php echo e($sizeLabel); ?> <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                </div>
                                            </div>

                                            <i class="bi bi-box-arrow-up-right text-muted flex-shrink-0"
                                               style="font-size:.78rem;" title="Open in new tab"></i>
                                        </a>
                                    </div>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </div>
                        <?php else: ?>
                            <p class="text-muted mb-0" style="font-size:.85rem;">No documents attached.</p>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>

                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($app->isForeignOfficial() && $app->concurrenceSteps->count()): ?>
                    <div class="card mb-3">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="bi bi-person-check me-2" style="color:#1a3a6b;"></i>Concurrence
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $app->concurrenceSteps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cs): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                <div
                                    class="p-3 d-flex align-items-start gap-3 <?php echo e(!$loop->last ? 'border-bottom' : ''); ?>">
                                    <div class="user-initials-avatar"
                                         style="width:34px;height:34px;font-size:.7rem;flex-shrink:0;">
                                        <?php echo e(strtoupper(substr($cs->approver->first_name,0,1).substr($cs->approver->last_name,0,1))); ?>

                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex align-items-center gap-2 flex-wrap">
                                            <span class="fw-medium"
                                                  style="font-size:.88rem;"><?php echo e($cs->approver->full_name); ?></span>
                                            <span class="text-muted"
                                                  style="font-size:.78rem;"><?php echo e($cs->approver->role?->label); ?></span>
                                            <?php
                                                $ac = match($cs->action) {
                                                    'concurred'     => 'success',
                                                    'not_concurred' => 'danger',
                                                    'returned'      => 'warning',
                                                    default         => 'secondary',
                                                };
                                            ?>
                                            <span
                                                class="badge bg-<?php echo e($ac); ?>-subtle text-<?php echo e($ac); ?> border border-<?php echo e($ac); ?>-subtle"
                                                style="font-size:.72rem;">
                                    <?php echo e($cs->action === 'pending' ? 'Awaiting action' : ucfirst(str_replace('_', ' ', $cs->action))); ?>

                                </span>
                                        </div>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($cs->comments): ?>
                                            <div class="mt-1 p-2 rounded"
                                                 style="background:var(--bs-tertiary-bg);font-size:.82rem;">
                                                <?php echo e($cs->comments); ?>

                                            </div>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($cs->acted_at): ?>
                                            <div class="text-muted mt-1" style="font-size:.74rem;">
                                                <?php echo e($cs->acted_at->format('d M Y, H:i')); ?>

                                            </div>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                </div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-clock-history me-2" style="color:#1a3a6b;"></i>Activity Log
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $app->logs->sortByDesc('created_at'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                            <div class="d-flex gap-3 p-3 <?php echo e(!$loop->last ? 'border-bottom' : ''); ?>">
                                <div style="width:8px;height:8px;border-radius:50%;background:#1a3a6b;
                            flex-shrink:0;margin-top:7px;"></div>
                                <div>
                                    <div class="fw-medium" style="font-size:.84rem;">
                                        <?php echo e(ucfirst(str_replace('_', ' ', $log->action))); ?>

                                    </div>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($log->description): ?>
                                        <div class="text-muted" style="font-size:.8rem;"><?php echo e($log->description); ?></div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <div class="text-muted" style="font-size:.74rem;">
                                        <?php echo e($log->user?->full_name); ?> &mdash;
                                        <?php echo e($log->created_at?->format('d M Y, H:i') ?? '—'); ?>

                                    </div>
                                </div>
                            </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <div class="p-3 text-muted" style="font-size:.85rem;">No activity recorded.</div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>

            </div>

            
            <div class="col-12 col-lg-4">

                
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-person me-2" style="color:#1a3a6b;"></i>Applicant
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div class="user-initials-avatar" style="width:40px;height:40px;font-size:.82rem;">
                                <?php echo e(strtoupper(substr($user->first_name,0,1).substr($user->last_name,0,1))); ?>

                            </div>
                            <div>
                                <div class="fw-semibold" style="font-size:.88rem;"><?php echo e($user->full_name); ?></div>
                                <div class="text-muted" style="font-size:.78rem;"><?php echo e($user->email); ?></div>
                            </div>
                        </div>
                        <table style="width:100%;font-size:.82rem;">
                            <tr>
                                <td class="text-muted pb-1" style="width:45%;">Role</td>
                                <td class="pb-1"><?php echo e($user->role?->label ?? '—'); ?></td>
                            </tr>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($user->jobTitle): ?>
                                <tr>
                                    <td class="text-muted pb-1">Job Title</td>
                                    <td class="pb-1"><?php echo e($user->jobTitle->name); ?></td>
                                </tr>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($user->department): ?>
                                <tr>
                                    <td class="text-muted pb-1">Division</td>
                                    <td class="pb-1"><?php echo e($user->department->name); ?></td>
                                </tr>
                                <tr>
                                    <td class="text-muted pb-1">Directorate</td>
                                    <td class="pb-1"><?php echo e($user->department->directorate?->name ?? '—'); ?></td>
                                </tr>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($user->supervisor): ?>
                                <tr>
                                    <td class="text-muted pb-1">Supervisor</td>
                                    <td class="pb-1"><?php echo e($user->supervisor->full_name); ?></td>
                                </tr>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </table>
                    </div>
                </div>

                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($app->clearance_letter_path): ?>
                    <div class="card mb-3" style="border-color:#006b3f;">
                        <div class="card-body text-center py-4">
                            <i class="bi bi-file-earmark-check fs-2 mb-2" style="color:#006b3f;"></i>
                            <div class="fw-semibold mb-1" style="color:#006b3f;">Clearance Letter</div>
                            <div class="text-muted mb-3" style="font-size:.78rem;">
                                Generated <?php echo e($app->clearance_letter_generated_at?->format('d M Y')); ?>

                            </div>
                            <a href="<?php echo e(route('travel.clearance', $app->id)); ?>" target="_blank"
                               class="btn btn-sm btn-success">
                                <i class="bi bi-download me-1"></i> Download
                            </a>
                        </div>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(in_array($app->status, ['concurred', 'submitted', 'pending_uploads'])): ?>
                    <div class="card mb-3">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="bi bi-upload me-2" style="color:#1a3a6b;"></i>Post-Trip
                            </h5>
                        </div>
                        <div class="card-body">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($app->postTripUpload): ?>
                                <span class="badge bg-success-subtle text-success border border-success-subtle">
                            <i class="bi bi-check-circle me-1"></i>Uploaded
                        </span>
                            <?php elseif($app->return_date->isPast()): ?>
                                <p class="text-muted mb-2" style="font-size:.82rem;">
                                    Your trip has ended. Please upload post-trip documents.
                                </p>
                                <a href="<?php echo e(route('travel.post-trip')); ?>" class="btn btn-sm btn-warning">
                                    <i class="bi bi-upload me-1"></i> Upload Now
                                </a>
                            <?php else: ?>
                                <p class="text-muted mb-0" style="font-size:.82rem;">
                                    Post-trip uploads required after
                                    <?php echo e($app->return_date->format('d M Y')); ?>.
                                </p>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            </div>
        </div>

    </div>
</div>
<?php /**PATH D:\Myprojects\FlowDesk\resources\views/livewire/travel/application-detail.blade.php ENDPATH**/ ?>