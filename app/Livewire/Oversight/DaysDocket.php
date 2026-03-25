<?php

namespace App\Livewire\Oversight;

use App\Models\User;
use App\Models\Directorate;
use Livewire\Component;
use Livewire\WithPagination;

class DaysDocket extends Component
{
    use WithPagination;

    public string $search            = '';
    public string $filterDirectorate = '';
    public string $filterWarning     = '';
    public string $sortBy            = 'days_used_this_year';
    public string $sortDir           = 'desc';

    protected $paginationTheme = 'bootstrap';

    public function updatingSearch(): void         { $this->resetPage(); }
    public function updatingFilterWarning(): void  { $this->resetPage(); }

    public function sort(string $col): void
    {
        $this->sortBy  = $col;
        $this->sortDir = $this->sortDir === 'desc' ? 'asc' : 'desc';
    }

    public function resetDocket(int $userId): void
    {
        if (! auth()->user()->isSuperAdmin()) {
            $this->dispatch('notify', type: 'error', message: 'Unauthorised.');
            return;
        }

        User::findOrFail($userId)->update([
            'days_used_this_year' => 0,
            'docket_year'         => now()->year,
        ]);

        $this->dispatch('notify', type: 'success', message: 'Days docket reset for this staff member.');
    }

    public function render()
    {
        $staff = User::query()
            ->where('status', 'active')
            ->with(['role', 'department.directorate'])
            ->when($this->search, fn($q) =>
                $q->where('first_name', 'ilike', "%{$this->search}%")
                  ->orWhere('last_name',  'ilike', "%{$this->search}%")
                  ->orWhere('pf_number',  'ilike', "%{$this->search}%")
            )
            ->when($this->filterDirectorate, fn($q) =>
                $q->whereHas('department', fn($d) =>
                    $d->where('directorate_id', $this->filterDirectorate)
                )
            )
            ->when($this->filterWarning === 'exceeded', fn($q) =>
                $q->whereRaw('days_used_this_year >= max_days_per_year')
            )
            ->when($this->filterWarning === 'warning', fn($q) =>
                $q->whereRaw('days_used_this_year::float / NULLIF(max_days_per_year,0) >= 0.8')
                  ->whereRaw('days_used_this_year < max_days_per_year')
            )
            ->when($this->filterWarning === 'ok', fn($q) =>
                $q->whereRaw('days_used_this_year::float / NULLIF(max_days_per_year,0) < 0.8')
            )
            ->orderBy($this->sortBy, $this->sortDir)
            ->paginate(20);

        $directorates = Directorate::orderBy('name')->get(['id', 'name']);

        // Summary
        $summary = [
            'total'    => User::where('status', 'active')->count(),
            'exceeded' => User::where('status', 'active')
                ->whereRaw('days_used_this_year >= max_days_per_year')->count(),
            'warning'  => User::where('status', 'active')
                ->whereRaw('days_used_this_year::float / NULLIF(max_days_per_year,0) >= 0.8')
                ->whereRaw('days_used_this_year < max_days_per_year')->count(),
            'ok'       => User::where('status', 'active')
                ->whereRaw('days_used_this_year::float / NULLIF(max_days_per_year,0) < 0.8')->count(),
        ];

        return view('livewire.oversight.days-docket',
            compact('staff', 'directorates', 'summary'))
            ->layout('components.layouts.app');
    }
}
