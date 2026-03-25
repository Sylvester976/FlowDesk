<?php use Carbon\Carbon; ?>
<div>
    <div class="main-content">

        <div class="page-header">
            <div>
                <h1 class="page-title">New Travel Application</h1>
                <nav class="breadcrumb">
                    <a href="<?php echo e(route('dashboard')); ?>" class="breadcrumb-item">Home</a>
                    <a href="<?php echo e(route('travel.index')); ?>" class="breadcrumb-item">My Applications</a>
                    <span class="breadcrumb-item active">New Application</span>
                </nav>
            </div>
        </div>

        
        <div class="card mb-4">
            <div class="card-body py-3 px-4">
                <div class="d-flex align-items-center justify-content-between position-relative">

                    
                    <div style="position:absolute;top:18px;left:calc(12.5% + 18px);right:calc(12.5% + 18px);
                    height:2px;background:var(--bs-border-color);z-index:0;"></div>

                    
                    <?php $pct = [1=>0, 2=>33, 3=>66, 4=>100][$step] ?? 0; ?>
                    <div style="position:absolute;top:18px;left:calc(12.5% + 18px);
                    height:2px;background:#1a3a6b;z-index:1;
                    width:<?php echo e($pct); ?>%;max-width:calc(100% - 25% - 36px);
                    transition:width .4s ease;"></div>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = [1 => 'Travel Type', 2 => 'Trip Details', 3 => 'Documents', 4 => 'Review']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                        <div class="d-flex flex-column align-items-center" style="z-index:2;flex:1;">
                            <div style="width:36px;height:36px;border-radius:50%;display:flex;align-items:center;
                        justify-content:center;font-size:.82rem;font-weight:600;border:2px solid;
                        transition:all .3s;
                        background:<?php echo e($step > $s ? '#1a3a6b' : '#fff'); ?>;
                        color:<?php echo e($step > $s ? '#fff' : ($step === $s ? '#1a3a6b' : '#adb5bd')); ?>;
                        border-color:<?php echo e($step >= $s ? '#1a3a6b' : '#dee2e6'); ?>;">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($step > $s): ?>
                                    <i class="bi bi-check-lg"></i>
                                <?php else: ?>
                                    <?php echo e($s); ?>

                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                            <span class="mt-1 d-none d-sm-block text-center"
                                  style="font-size:.72rem;
                        color:<?php echo e($step === $s ? '#1a3a6b' : 'var(--bs-secondary-color)'); ?>;
                        font-weight:<?php echo e($step === $s ? '600' : '400'); ?>;">
                        <?php echo e($label); ?>

                    </span>
                        </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </div>
            </div>
        </div>

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($step === 1): ?>
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-airplane me-2" style="color:#1a3a6b;"></i>Select Travel Type
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">

                        <div class="col-12 col-md-4">
                            <div wire:click="$set('travel_type', 'foreign_official')"
                                 class="p-4 rounded h-100 d-flex flex-column"
                                 style="cursor:pointer;border:2px solid <?php echo e($travel_type === 'foreign_official' ? '#1a3a6b' : 'var(--bs-border-color)'); ?>;
                            background:<?php echo e($travel_type === 'foreign_official' ? '#e8f0fb' : 'transparent'); ?>;
                            transition:all .2s;">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <div style="width:36px;height:36px;border-radius:50%;background:#1a3a6b;
                                display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                        <i class="bi bi-briefcase text-white" style="font-size:.9rem;"></i>
                                    </div>
                                    <span class="fw-semibold" style="color:#1a3a6b;">Foreign Official</span>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($travel_type === 'foreign_official'): ?>
                                        <i class="bi bi-check-circle-fill ms-auto" style="color:#1a3a6b;"></i>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                                <p class="text-muted mb-0" style="font-size:.82rem;line-height:1.6;">
                                    Official government travel abroad. Requires supervisor concurrence
                                    and counts against your annual travel days.
                                </p>
                            </div>
                        </div>

                        <div class="col-12 col-md-4">
                            <div wire:click="$set('travel_type', 'foreign_private')"
                                 class="p-4 rounded h-100 d-flex flex-column"
                                 style="cursor:pointer;border:2px solid <?php echo e($travel_type === 'foreign_private' ? '#006b3f' : 'var(--bs-border-color)'); ?>;
                            background:<?php echo e($travel_type === 'foreign_private' ? '#e8f5ee' : 'transparent'); ?>;
                            transition:all .2s;">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <div style="width:36px;height:36px;border-radius:50%;background:#006b3f;
                                display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                        <i class="bi bi-person text-white" style="font-size:.9rem;"></i>
                                    </div>
                                    <span class="fw-semibold" style="color:#006b3f;">Foreign Private</span>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($travel_type === 'foreign_private'): ?>
                                        <i class="bi bi-check-circle-fill ms-auto" style="color:#006b3f;"></i>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                                <p class="text-muted mb-0" style="font-size:.82rem;line-height:1.6;">
                                    Personal travel abroad during approved leave.
                                    PS is notified. Does not affect your travel days.
                                </p>
                            </div>
                        </div>

                        <div class="col-12 col-md-4">
                            <div wire:click="$set('travel_type', 'local')"
                                 class="p-4 rounded h-100 d-flex flex-column"
                                 style="cursor:pointer;border:2px solid <?php echo e($travel_type === 'local' ? '#c8a951' : 'var(--bs-border-color)'); ?>;
                            background:<?php echo e($travel_type === 'local' ? '#fff8e1' : 'transparent'); ?>;
                            transition:all .2s;">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <div style="width:36px;height:36px;border-radius:50%;background:#c8a951;
                                display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                        <i class="bi bi-geo-alt text-white" style="font-size:.9rem;"></i>
                                    </div>
                                    <span class="fw-semibold" style="color:#78620a;">Local</span>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($travel_type === 'local'): ?>
                                        <i class="bi bi-check-circle-fill ms-auto" style="color:#c8a951;"></i>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                                <p class="text-muted mb-0" style="font-size:.82rem;line-height:1.6;">
                                    Travel within Kenya. Supervisor is notified.
                                    No per diem for travel within Nairobi County.
                                </p>
                            </div>
                        </div>

                    </div>

                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($travel_type === 'foreign_official'): ?>
                        <div class="mt-3 p-3 rounded d-flex justify-content-between align-items-center flex-wrap gap-2"
                             style="background:#e8f5ee;border-left:4px solid #006b3f;">
                <span style="font-size:.83rem;color:#085041;">
                    <i class="bi bi-calendar-check me-1"></i>
                    Your foreign travel days this year:
                </span>
                            <span class="fw-semibold" style="color:#085041;">
                    <?php echo e($user->days_used_this_year); ?> used /
                    <?php echo e($user->max_days_per_year); ?> allowed
                    &mdash; <strong><?php echo e($user->days_remaining); ?> remaining</strong>
                </span>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                <div class="card-footer d-flex justify-content-end">
                    <button wire:click="nextStep" class="btn btn-primary"
                            <?php if(!$travel_type): ?> disabled <?php endif; ?>>
                        Next <i class="bi bi-arrow-right ms-1"></i>
                    </button>
                </div>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($step === 2): ?>
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-map me-2" style="color:#1a3a6b;"></i>Trip Details
                        <span class="badge ms-2" style="font-size:.72rem;color:#fff;
                    background:<?php echo e($travel_type === 'foreign_official' ? '#1a3a6b' : ($travel_type === 'foreign_private' ? '#006b3f' : '#c8a951')); ?>;">
                    <?php echo e($travel_type === 'foreign_official' ? 'Foreign Official' : ($travel_type === 'foreign_private' ? 'Foreign Private' : 'Local')); ?>

                </span>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">

                        
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(in_array($travel_type, ['foreign_official', 'foreign_private'])): ?>
                            <div class="col-12 col-sm-6">
                                <label class="form-label fw-medium">Destination Country <span
                                        class="text-danger">*</span></label>
                                <select wire:model="country_id"
                                        class="form-select <?php $__errorArgs = ['country_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                    <option value="">Select country...</option>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                        <option value="<?php echo e($c->id); ?>"><?php echo e($c->name); ?></option>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                </select>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['country_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                            <div class="col-12 col-sm-6">
                                <label class="form-label fw-medium">City / Specific Location</label>
                                <input type="text" wire:model="destination_details"
                                       class="form-control" placeholder="e.g. Nairobi, Westlands">
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($travel_type === 'local'): ?>
                            <div class="col-12 col-sm-6">
                                <label class="form-label fw-medium">Destination County <span
                                        class="text-danger">*</span></label>
                                <select wire:model.live="county_id"
                                        class="form-select <?php $__errorArgs = ['county_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                    <option value="">Select county...</option>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $counties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                        <option value="<?php echo e($c->id); ?>"><?php echo e($c->name); ?></option>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                </select>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['county_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                            <div class="col-12 col-sm-6">
                                <label class="form-label fw-medium">Specific Location</label>
                                <input type="text" wire:model="destination_details"
                                       class="form-control" placeholder="e.g. Nakuru Town, KICC">
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        
                        <div class="col-12 col-sm-6">
                            <label class="form-label fw-medium">Departure Date <span
                                    class="text-danger">*</span></label>
                            <input type="date" wire:model.live="departure_date"
                                   class="form-control <?php $__errorArgs = ['departure_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   min="<?php echo e(now()->format('Y-m-d')); ?>">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['departure_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <div class="col-12 col-sm-6">
                            <label class="form-label fw-medium">Return Date <span class="text-danger">*</span></label>
                            <input type="date" wire:model.live="return_date"
                                   class="form-control <?php $__errorArgs = ['return_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   min="<?php echo e($departure_date ?: now()->format('Y-m-d')); ?>">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['return_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($travel_type !== 'foreign_private'): ?>
                            <div class="col-12 col-sm-6">
                                <label class="form-label fw-medium">
                                    Per Diem Days <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$isNairobi): ?>
                                        <span class="text-danger">*</span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </label>
                                <input type="number" wire:model="per_diem_days"
                                       class="form-control <?php $__errorArgs = ['per_diem_days'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       min="0" max="365"
                                       <?php if($isNairobi): ?> disabled placeholder="Not applicable for Nairobi" <?php endif; ?>>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['per_diem_days'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <div class="form-text">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isNairobi): ?>
                                        <span class="text-warning"><i class="bi bi-info-circle me-1"></i>No per diem for Nairobi County.</span>
                                    <?php else: ?>
                                        Auto-calculated from dates. You can adjust.
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($travel_type === 'foreign_official'): ?>
                            <div class="col-12 col-sm-6">
                                <label class="form-label fw-medium">Funding Source <span
                                        class="text-danger">*</span></label>
                                <input type="text" wire:model="funding_source"
                                       class="form-control <?php $__errorArgs = ['funding_source'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       placeholder="e.g. GoK, World Bank, AfDB, Self-funded">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['funding_source'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        
                        <div class="col-12">
                            <label class="form-label fw-medium">
                                Purpose &amp; Activity Description <span class="text-danger">*</span>
                            </label>
                            <textarea wire:model="purpose" rows="4"
                                      class="form-control <?php $__errorArgs = ['purpose'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                      placeholder="Describe what you will be doing, which meetings or activities you will attend, and the expected outcomes..."></textarea>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['purpose'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php else: ?>
                                <div class="form-text">
                                    <?php echo e(strlen($purpose)); ?> characters &mdash; minimum 30 required.
                                </div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <button wire:click="prevStep" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Back
                    </button>
                    <button wire:click="nextStep" class="btn btn-primary">
                        Next <i class="bi bi-arrow-right ms-1"></i>
                    </button>
                </div>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($step === 3): ?>
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-paperclip me-2" style="color:#1a3a6b;"></i>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($travel_type === 'foreign_private'): ?>
                            Leave &amp;
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?> Documents
                    </h5>
                </div>
                <div class="card-body">

                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($travel_type === 'foreign_private'): ?>
                        <div class="p-4 rounded mb-4" style="background:#fff8e1;border:1px solid #f0c040;">
                            <h6 class="fw-semibold mb-2" style="color:#78620a;">
                                <i class="bi bi-calendar-check me-2"></i>Leave Confirmation Required
                            </h6>
                            <p style="font-size:.84rem;color:#78620a;margin-bottom:1rem;">
                                Foreign private travel requires approved annual leave. Has your leave been approved by
                                HR?
                            </p>
                            <div class="d-flex flex-wrap gap-3">
                                <label class="d-flex align-items-center gap-2" style="cursor:pointer;">
                                    <input type="radio" wire:model.live="leave_approved" value="1"
                                           class="form-check-input mt-0">
                                    <span class="fw-medium" style="color:#006b3f;">
                            <i class="bi bi-check-circle me-1"></i>Yes, my leave is approved
                        </span>
                                </label>
                                <label class="d-flex align-items-center gap-2" style="cursor:pointer;">
                                    <input type="radio" wire:model.live="leave_approved" value="0"
                                           class="form-check-input mt-0">
                                    <span class="fw-medium" style="color:#bb0000;">
                            <i class="bi bi-x-circle me-1"></i>No, I haven't applied yet
                        </span>
                                </label>
                            </div>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if((string)$leave_approved === '0'): ?>
                                <div class="mt-3 p-3 rounded" style="background:#ffebee;border-left:4px solid #bb0000;">
                                    <p class="mb-0 fw-medium" style="color:#bb0000;font-size:.84rem;">
                                        <i class="bi bi-exclamation-triangle me-1"></i>
                                        You cannot proceed without approved leave.
                                        Please apply for annual leave through HR first, then return here.
                                    </p>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($travel_type !== 'foreign_private' || (string)$leave_approved === '1'): ?>
                        <div class="row g-3">

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($travel_type === 'foreign_official'): ?>
                                <div class="col-12 col-sm-6">
                                    <label class="form-label fw-medium">
                                        Invitation / Request Letter <span class="text-danger">*</span>
                                    </label>
                                    <input type="file" wire:model="doc_invitation"
                                           class="form-control <?php $__errorArgs = ['doc_invitation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           accept=".pdf,.jpg,.jpeg,.png,.PDF,.JPG,.JPEG,.PNG">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['doc_invitation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <div class="form-text">PDF or image (JPG/PNG) &mdash; max 2MB</div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <label class="form-label fw-medium">
                                        Appointment Letter <span class="text-danger">*</span>
                                    </label>
                                    <input type="file" wire:model="doc_appointment"
                                           class="form-control <?php $__errorArgs = ['doc_appointment'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           accept=".pdf,.jpg,.jpeg,.png,.PDF,.JPG,.JPEG,.PNG">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['doc_appointment'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <div class="form-text">PDF or image (JPG/PNG) &mdash; max 2MB</div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <label class="form-label fw-medium">
                                        Passport Copy <span class="text-danger">*</span>
                                    </label>
                                    <input type="file" wire:model="doc_passport"
                                           class="form-control <?php $__errorArgs = ['doc_passport'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           accept=".pdf,.jpg,.jpeg,.png,.PDF,.JPG,.JPEG,.PNG">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['doc_passport'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <div class="form-text">Bio-data page &mdash; PDF or image (JPG/PNG) &mdash; max
                                        2MB
                                    </div>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($travel_type === 'foreign_private'): ?>
                                <div class="col-12 col-sm-6">
                                    <label class="form-label fw-medium">
                                        Passport Copy <span class="text-danger">*</span>
                                    </label>
                                    <input type="file" wire:model="doc_passport"
                                           class="form-control <?php $__errorArgs = ['doc_passport'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           accept=".pdf,.jpg,.jpeg,.png,.PDF,.JPG,.JPEG,.PNG">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['doc_passport'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <div class="form-text">PDF or image (JPG/PNG) &mdash; max 2MB</div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <label class="form-label fw-medium">
                                        Approved Leave Form <span class="text-danger">*</span>
                                    </label>
                                    <input type="file" wire:model="doc_leave_form"
                                           class="form-control <?php $__errorArgs = ['doc_leave_form'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           accept=".pdf,.jpg,.jpeg,.png,.PDF,.JPG,.JPEG,.PNG">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['doc_leave_form'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <div class="form-text">PDF or image (JPG/PNG) &mdash; max 2MB</div>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($travel_type === 'local'): ?>
                                <div class="col-12 col-sm-6">
                                    <label class="form-label fw-medium">
                                        Appointment Letter <span class="text-danger">*</span>
                                    </label>
                                    <input type="file" wire:model="doc_appointment"
                                           class="form-control <?php $__errorArgs = ['doc_appointment'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           accept=".pdf,.jpg,.jpeg,.png,.PDF,.JPG,.JPEG,.PNG">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['doc_appointment'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <div class="form-text">PDF or image (JPG/PNG) &mdash; max 2MB</div>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        </div>

                        
                        <div wire:loading wire:target="doc_invitation,doc_appointment,doc_passport,doc_leave_form"
                             class="mt-3 d-flex align-items-center gap-2 text-muted" style="font-size:.83rem;">
                            <span class="spinner-border spinner-border-sm"></span> Uploading...
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                </div>
                <div class="card-footer d-flex justify-content-between">
                    <button wire:click="prevStep" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Back
                    </button>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($travel_type !== 'foreign_private' || (string)$leave_approved === '1'): ?>
                        <button wire:click="nextStep" class="btn btn-primary">
                            Next <i class="bi bi-arrow-right ms-1"></i>
                        </button>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($step === 4): ?>
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-check-circle me-2" style="color:#006b3f;"></i>Review &amp; Submit
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">

                        <div class="col-12 col-md-6">
                            <div class="p-3 rounded" style="background:var(--bs-tertiary-bg);">
                                <h6 class="fw-semibold mb-3" style="font-size:.78rem;text-transform:uppercase;
                            letter-spacing:.05em;color:var(--bs-secondary-color);">Trip Summary</h6>
                                <table style="width:100%;font-size:.85rem;">
                                    <tr>
                                        <td class="text-muted pb-2" style="width:42%;">Type</td>
                                        <td class="fw-medium pb-2">
                                            <?php echo e($travel_type === 'foreign_official' ? 'Foreign Official' :
                                               ($travel_type === 'foreign_private' ? 'Foreign Private' : 'Local')); ?>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted pb-2">Destination</td>
                                        <td class="fw-medium pb-2">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($country_id): ?>
                                                <?php echo e($countries->firstWhere('id', $country_id)?->name); ?>

                                            <?php elseif($county_id): ?>
                                                <?php echo e($counties->firstWhere('id', $county_id)?->name); ?> County
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($destination_details): ?> &mdash; <?php echo e($destination_details); ?>

                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted pb-2">Dates</td>
                                        <td class="fw-medium pb-2">
                                            <?php echo e(Carbon::parse($departure_date)->format('d M Y')); ?>

                                            &rarr; <?php echo e(Carbon::parse($return_date)->format('d M Y')); ?>

                                        </td>
                                    </tr>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($per_diem_days && !$isNairobi && $travel_type !== 'foreign_private'): ?>
                                        <tr>
                                            <td class="text-muted pb-2">Per Diem Days</td>
                                            <td class="fw-medium pb-2"><?php echo e($per_diem_days); ?> day(s)</td>
                                        </tr>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($funding_source): ?>
                                        <tr>
                                            <td class="text-muted pb-2">Funding</td>
                                            <td class="fw-medium pb-2"><?php echo e($funding_source); ?></td>
                                        </tr>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </table>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="p-3 rounded" style="background:var(--bs-tertiary-bg);height:100%;">
                                <h6 class="fw-semibold mb-2" style="font-size:.78rem;text-transform:uppercase;
                            letter-spacing:.05em;color:var(--bs-secondary-color);">Purpose</h6>
                                <p style="font-size:.85rem;line-height:1.7;margin:0;"><?php echo e($purpose); ?></p>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="p-3 rounded" style="background:var(--bs-tertiary-bg);">
                                <h6 class="fw-semibold mb-2" style="font-size:.78rem;text-transform:uppercase;
                            letter-spacing:.05em;color:var(--bs-secondary-color);">Documents Attached</h6>
                                <div class="d-flex flex-wrap gap-2">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($doc_invitation): ?>
                                        <span class="badge bg-success-subtle text-success border border-success-subtle">
                                    <i class="bi bi-file-earmark-check me-1"></i>Invitation Letter ✓
                                </span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($doc_appointment): ?>
                                        <span class="badge bg-success-subtle text-success border border-success-subtle">
                                    <i class="bi bi-file-earmark-check me-1"></i>Appointment Letter ✓
                                </span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($doc_passport): ?>
                                        <span class="badge bg-success-subtle text-success border border-success-subtle">
                                    <i class="bi bi-file-earmark-check me-1"></i>Passport Copy ✓
                                </span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($doc_leave_form): ?>
                                        <span class="badge bg-success-subtle text-success border border-success-subtle">
                                    <i class="bi bi-file-earmark-check me-1"></i>Leave Form ✓
                                </span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="p-3 rounded" style="background:#e8f0fb;border-left:4px solid #1a3a6b;">
                                <h6 class="fw-semibold mb-1" style="color:#1a3a6b;font-size:.84rem;">
                                    What happens next?
                                </h6>
                                <p class="mb-0" style="font-size:.82rem;color:#374151;line-height:1.7;">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($travel_type === 'foreign_official'): ?>
                                        Your application goes to your supervisor for concurrence.
                                        A clearance letter is generated automatically once concurred.
                                        Your travel days are updated on concurrence.
                                    <?php elseif($travel_type === 'foreign_private'): ?>
                                        The Principal Secretary is notified for record purposes.
                                        No concurrence required. Travel days are not affected.
                                    <?php else: ?>
                                        Your supervisor is notified of your local travel.
                                        No concurrence required.
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    After returning, you must upload post-trip documents before your next application.
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <button wire:click="prevStep" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Back
                    </button>
                    <button wire:click="confirmSubmit" class="btn btn-primary px-4">
                        <i class="bi bi-send me-1"></i> Submit Application
                    </button>
                </div>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showSubmitConfirm): ?>
            <div class="modal fade show d-block" tabindex="-1" style="background:rgba(0,0,0,.5);">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header border-0 pb-0">
                            <h5 class="modal-title">
                                <i class="bi bi-send me-2" style="color:#1a3a6b;"></i>Confirm Submission
                            </h5>
                            <button wire:click="$set('showSubmitConfirm', false)" class="btn-close"></button>
                        </div>
                        <div class="modal-body">
                            <p class="mb-3" style="font-size:.88rem;">
                                You are about to submit a
                                <strong>
                                    <?php echo e($travel_type === 'foreign_official' ? 'Foreign Official' :
                                       ($travel_type === 'foreign_private' ? 'Foreign Private' : 'Local')); ?>

                                </strong>
                                travel application.
                            </p>
                            <div class="p-3 rounded" style="background:var(--bs-tertiary-bg);font-size:.84rem;">
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="text-muted">Destination</span>
                                    <span class="fw-medium">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($country_id): ?>
                                            <?php echo e($countries->firstWhere('id', $country_id)?->name); ?>

                                        <?php elseif($county_id): ?>
                                            <?php echo e($counties->firstWhere('id', $county_id)?->name); ?> County
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span class="text-muted">Dates</span>
                                    <span class="fw-medium">
                                <?php echo e(Carbon::parse($departure_date)->format('d M Y')); ?>

                                &rarr; <?php echo e(Carbon::parse($return_date)->format('d M Y')); ?>

                            </span>
                                </div>
                            </div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($travel_type === 'foreign_official'): ?>
                                <div class="mt-3 p-2 rounded d-flex align-items-start gap-2"
                                     style="background:#fff8e1;border-left:3px solid #c8a951;font-size:.82rem;color:#78620a;">
                                    <i class="bi bi-exclamation-triangle mt-1 flex-shrink-0"></i>
                                    <span>This will be sent to your supervisor for concurrence and
                        will count against your annual travel days once concurred.</span>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <p class="mt-3 mb-0 text-muted" style="font-size:.82rem;">
                                Once submitted, you cannot edit this application. Are you sure?
                            </p>
                        </div>
                        <div class="modal-footer">
                            <button wire:click="$set('showSubmitConfirm', false)"
                                    class="btn btn-outline-secondary btn-sm">
                                Go Back &amp; Review
                            </button>
                            <button wire:click="submit" class="btn btn-primary btn-sm px-4"
                                    wire:loading.attr="disabled">
                        <span wire:loading.remove>
                            <i class="bi bi-send me-1"></i> Yes, Submit
                        </span>
                                <span wire:loading>
                            <span class="spinner-border spinner-border-sm me-2"></span>Submitting...
                        </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    </div>
</div>
<?php /**PATH D:\Myprojects\FlowDesk\resources\views/livewire/travel/travel-wizard.blade.php ENDPATH**/ ?>