<div>
<div class="main-content">

    <div class="page-header">
        <div>
            <h1 class="page-title">Travel Rates</h1>
            <nav class="breadcrumb">
                <a href="{{ route('dashboard') }}" class="breadcrumb-item">Home</a>
                <span class="breadcrumb-item active">Travel Rates</span>
            </nav>
        </div>
        @if($canManage)
        <div class="page-header-actions">
            <button wire:click="openCreate" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg me-1"></i> Add Rate
            </button>
        </div>
        @endif
    </div>

    {{-- Filters --}}
    <div class="card mb-3">
        <div class="card-body py-2">
            <div class="row g-2 align-items-center">
                <div class="col-12 col-sm-5 col-md-4">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" wire:model.live.debounce.300ms="search"
                            class="form-control" placeholder="Search destination or category...">
                    </div>
                </div>
                <div class="col-auto">
                    <select wire:model.live="filterType" class="form-select form-select-sm">
                        <option value="">All Types</option>
                        <option value="per_diem">Per Diem</option>
                        <option value="accommodation">Accommodation</option>
                        <option value="transport">Transport</option>
                        <option value="incidental">Incidental</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    {{-- Rates table --}}
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Destination / Group</th>
                            <th class="d-none d-sm-table-cell">Category</th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th class="d-none d-md-table-cell">Description</th>
                            <th>Status</th>
                            @if($canManage)
                            <th></th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rates as $rate)
                        <tr wire:key="rate-{{ $rate->id }}">
                            <td>
                                <div class="fw-medium" style="font-size:.85rem;">{{ $rate->destination }}</div>
                            </td>
                            <td class="d-none d-sm-table-cell" style="font-size:.83rem;">
                                {{ $rate->category }}
                            </td>
                            <td>
                                @php
                                    $typeColor = match($rate->rate_type) {
                                        'per_diem'      => ['bg' => '#e8f0fb', 'text' => '#1a3a6b'],
                                        'accommodation' => ['bg' => '#e8f5ee', 'text' => '#006b3f'],
                                        'transport'     => ['bg' => '#fff8e1', 'text' => '#78620a'],
                                        'incidental'    => ['bg' => '#f3e8ff', 'text' => '#6b21a8'],
                                        default         => ['bg' => '#f0f0f0', 'text' => '#555'],
                                    };
                                @endphp
                                <span class="badge" style="font-size:.72rem;
                                    background:{{ $typeColor['bg'] }};color:{{ $typeColor['text'] }};">
                                    {{ ucfirst(str_replace('_', ' ', $rate->rate_type)) }}
                                </span>
                            </td>
                            <td>
                                <span class="fw-semibold" style="font-size:.88rem;color:#1a3a6b;">
                                    {{ $rate->currency }} {{ number_format($rate->amount, 2) }}
                                </span>
                                <span class="text-muted" style="font-size:.74rem;">/day</span>
                            </td>
                            <td class="d-none d-md-table-cell text-muted" style="font-size:.8rem;">
                                {{ $rate->description ?? '—' }}
                            </td>
                            <td>
                                @if($rate->is_active)
                                <span class="badge bg-success-subtle text-success border border-success-subtle"
                                    style="font-size:.72rem;">Active</span>
                                @else
                                <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle"
                                    style="font-size:.72rem;">Inactive</span>
                                @endif
                            </td>
                            @if($canManage)
                            <td>
                                <div class="d-flex gap-1 justify-content-end">
                                    <button wire:click="openEdit({{ $rate->id }})"
                                        class="btn btn-sm btn-outline-primary py-0 px-2"
                                        style="font-size:.74rem;">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button wire:click="toggleActive({{ $rate->id }})"
                                        class="btn btn-sm btn-outline-secondary py-0 px-2"
                                        style="font-size:.74rem;"
                                        title="{{ $rate->is_active ? 'Deactivate' : 'Activate' }}">
                                        <i class="bi bi-{{ $rate->is_active ? 'pause' : 'play' }}"></i>
                                    </button>
                                    <button wire:click="delete({{ $rate->id }})"
                                        wire:confirm="Delete this rate? This cannot be undone."
                                        class="btn btn-sm btn-outline-danger py-0 px-2"
                                        style="font-size:.74rem;">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                            @endif
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bi bi-currency-dollar fs-2 d-block mb-2"></i>
                                No travel rates configured yet.
                                @if($canManage)
                                <button wire:click="openCreate"
                                    class="btn btn-sm btn-primary d-block mx-auto mt-2">
                                    Add First Rate
                                </button>
                                @endif
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($rates->hasPages())
        <div class="card-footer d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div class="text-muted small">
                Showing {{ $rates->firstItem() }}–{{ $rates->lastItem() }} of {{ $rates->total() }}
            </div>
            {{ $rates->links() }}
        </div>
        @endif
    </div>

</div>

{{-- ── Add / Edit Modal ─────────────────────────────────── --}}
@if($showForm)
<div class="modal fade show d-block" tabindex="-1" style="background:rgba(0,0,0,.5);">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-currency-dollar me-2" style="color:#1a3a6b;"></i>
                    {{ $editId ? 'Edit Rate' : 'Add Travel Rate' }}
                </h5>
                <button wire:click="$set('showForm', false)" class="btn-close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-12 col-sm-6">
                        <label class="form-label fw-medium">Destination / Country Group <span class="text-danger">*</span></label>
                        <input type="text" wire:model="destination"
                            class="form-control form-control-sm @error('destination') is-invalid @enderror"
                            placeholder="e.g. East Africa, USA, Europe, Kenya">
                        @error('destination')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12 col-sm-6">
                        <label class="form-label fw-medium">Category <span class="text-danger">*</span></label>
                        <input type="text" wire:model="category"
                            class="form-control form-control-sm @error('category') is-invalid @enderror"
                            placeholder="e.g. Grade A, Secretary Level, All Staff">
                        @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12 col-sm-6">
                        <label class="form-label fw-medium">Rate Type <span class="text-danger">*</span></label>
                        <select wire:model="rate_type"
                            class="form-select form-select-sm @error('rate_type') is-invalid @enderror">
                            <option value="per_diem">Per Diem</option>
                            <option value="accommodation">Accommodation</option>
                            <option value="transport">Transport</option>
                            <option value="incidental">Incidental</option>
                        </select>
                    </div>
                    <div class="col-6 col-sm-3">
                        <label class="form-label fw-medium">Currency <span class="text-danger">*</span></label>
                        <input type="text" wire:model="currency"
                            class="form-control form-control-sm @error('currency') is-invalid @enderror"
                            placeholder="USD" maxlength="3"
                            style="text-transform:uppercase;">
                        @error('currency')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-6 col-sm-3">
                        <label class="form-label fw-medium">Amount <span class="text-danger">*</span></label>
                        <input type="number" wire:model="amount"
                            class="form-control form-control-sm @error('amount') is-invalid @enderror"
                            placeholder="0.00" min="0" step="0.01">
                        @error('amount')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-medium">Description</label>
                        <input type="text" wire:model="description"
                            class="form-control form-control-sm"
                            placeholder="Optional notes about this rate...">
                    </div>
                    <div class="col-12">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox"
                                wire:model="is_active" id="rateActive">
                            <label class="form-check-label" for="rateActive"
                                style="font-size:.84rem;">Active</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button wire:click="$set('showForm', false)"
                    class="btn btn-outline-secondary btn-sm">Cancel</button>
                <button wire:click="save" class="btn btn-primary btn-sm px-4"
                    wire:loading.attr="disabled">
                    <span wire:loading.remove>
                        <i class="bi bi-check-lg me-1"></i>
                        {{ $editId ? 'Update Rate' : 'Add Rate' }}
                    </span>
                    <span wire:loading>
                        <span class="spinner-border spinner-border-sm me-1"></span>Saving...
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>
@endif

</div>
