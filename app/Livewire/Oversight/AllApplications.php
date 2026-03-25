<?php

namespace App\Livewire\Oversight;

use App\Models\TravelApplication;
use App\Models\User;
use App\Models\Country;
use App\Models\Directorate;
use Livewire\Component;
use Livewire\WithPagination;

class AllApplications extends Component
{
    use WithPagination;

    public string $search         = '';
    public string $filterStatus   = '';
    public string $filterType     = '';
    public string $filterDirectorate = '';
    public string $filterYear     = '';
    public string $sortBy         = 'created_at';
    public string $sortDir        = 'desc';

    protected $paginationTheme = 'bootstrap';

    public function updatingSearch(): void      { $this->resetPage(); }
    public function updatingFilterStatus(): void { $this->resetPage(); }
    public function updatingFilterType(): void   { $this->resetPage(); }

    public function sort(string $col): void
    {
        if ($this->sortBy === $col) {
            $this->sortDir = $this->sortDir === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy  = $col;
            $this->sortDir = 'desc';
        }
    }

    public function render()
    {
        $applications = TravelApplication::query()
            ->with(['user.role', 'user.department.directorate', 'country', 'county'])
            ->when($this->search, fn($q) =>
                $q->whereHas('user', fn($u) =>
                    $u->where('first_name', 'ilike', "%{$this->search}%")
                      ->orWhere('last_name',  'ilike', "%{$this->search}%")
                      ->orWhere('pf_number',  'ilike', "%{$this->search}%")
                )->orWhere('reference_number', 'ilike', "%{$this->search}%")
            )
            ->when($this->filterStatus,      fn($q) => $q->where('status', $this->filterStatus))
            ->when($this->filterType,        fn($q) => $q->where('travel_type', $this->filterType))
            ->when($this->filterYear,        fn($q) => $q->whereYear('travel_applications.created_at', $this->filterYear))
            ->when($this->filterDirectorate, fn($q) =>
                $q->whereHas('user.department', fn($d) =>
                    $d->where('directorate_id', $this->filterDirectorate)
                )
            )
            ->orderBy($this->sortBy === 'staff' ? 'user_id' : $this->sortBy, $this->sortDir)
            ->paginate(15);

        $directorates  = \App\Models\Directorate::orderBy('name')->get(['id', 'name']);
        $years         = TravelApplication::selectRaw('extract(year from created_at)::int as yr')
            ->groupBy('yr')->orderByDesc('yr')->pluck('yr');

        // Summary counts
        $counts = [
            'total'               => TravelApplication::whereYear('travel_applications.created_at', now()->year)->count(),
            'pending_concurrence' => TravelApplication::where('status', 'pending_concurrence')->count(),
            'concurred'           => TravelApplication::where('status', 'concurred')->count(),
            'closed'              => TravelApplication::where('status', 'closed')->count(),
        ];

        return view('livewire.oversight.all-applications',
            compact('applications', 'directorates', 'years', 'counts'))
            ->layout('components.layouts.app');
    }
}
