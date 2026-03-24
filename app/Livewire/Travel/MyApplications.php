<?php

namespace App\Livewire\Travel;

use App\Models\TravelApplication;
use Livewire\Component;
use Livewire\WithPagination;

class MyApplications extends Component
{
    use WithPagination;

    public string $filterStatus = '';
    public string $filterType   = '';

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $user = auth()->user();

        $hasPendingUploads = $user->hasPendingPostTripUploads();

        $applications = TravelApplication::where('user_id', $user->id)
            ->with(['country', 'county', 'concurrenceSteps.approver'])
            ->when($this->filterStatus, fn($q) => $q->where('status', $this->filterStatus))
            ->when($this->filterType,   fn($q) => $q->where('travel_type', $this->filterType))
            ->latest()
            ->paginate(10);

        return view('livewire.travel.my-applications',
            compact('applications', 'hasPendingUploads'))
            ->layout('components.layouts.app');
    }
}
