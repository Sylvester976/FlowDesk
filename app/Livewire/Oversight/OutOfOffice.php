<?php

namespace App\Livewire\Oversight;

use App\Models\TravelApplication;
use App\Models\Directorate;
use Livewire\Component;

class OutOfOffice extends Component
{
    public string $filterDirectorate = '';
    public string $filterType        = '';

    public function render()
    {
        // Currently travelling — departure <= today <= return
        $current = TravelApplication::whereIn('status', ['concurred', 'submitted'])
            ->where('departure_date', '<=', now())
            ->where('return_date',    '>=', now())
            ->with(['user.role', 'user.department.directorate', 'country', 'county'])
            ->when($this->filterType, fn($q) => $q->where('travel_type', $this->filterType))
            ->when($this->filterDirectorate, fn($q) =>
                $q->whereHas('user.department', fn($d) =>
                    $d->where('directorate_id', $this->filterDirectorate)
                )
            )
            ->orderBy('return_date')
            ->get();

        // Departing soon — next 7 days
        $departingSoon = TravelApplication::whereIn('status', ['concurred', 'submitted'])
            ->where('departure_date', '>', now())
            ->where('departure_date', '<=', now()->addDays(7))
            ->with(['user.role', 'user.department.directorate', 'country', 'county'])
            ->orderBy('departure_date')
            ->get();

        // Overdue returns — return date past but no post-trip uploaded
        $overdue = TravelApplication::where('status', 'concurred')
            ->where('return_date', '<', now())
            ->whereDoesntHave('postTripUpload')
            ->with(['user.role', 'user.department.directorate', 'country', 'county'])
            ->orderBy('return_date')
            ->get();

        $directorates = Directorate::orderBy('name')->get(['id', 'name']);

        return view('livewire.oversight.out-of-office',
            compact('current', 'departingSoon', 'overdue', 'directorates'))
            ->layout('components.layouts.app');
    }
}
