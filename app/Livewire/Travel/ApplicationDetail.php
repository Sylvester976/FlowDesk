<?php

namespace App\Livewire\Travel;

use App\Models\TravelApplication;
use Livewire\Component;

class ApplicationDetail extends Component
{
    public TravelApplication $application;

    public function mount(TravelApplication $application): void
    {
        // Ensure user can only view their own — unless supervisor/admin
        $user = auth()->user();

        if (
            $application->user_id !== $user->id &&
            ! $user->isSuperAdmin() &&
            ! $user->isHR() &&
            ! $user->isPS()
        ) {
            // Supervisor can see their subordinates' applications
            $isSubordinate = $application->user->supervisor_id === $user->id;
            if (! $isSubordinate) {
                abort(403, 'You are not authorised to view this application.');
            }
        }

        $this->application = $application->load([
            'user.role',
            'user.department.directorate',
            'user.supervisor',
            'country',
            'county',
            'documents',
            'concurrenceSteps.approver',
            'logs.user',
            'postTripUpload',
        ]);
    }

    public function render()
    {
        return view('livewire.travel.application-detail')
            ->layout('components.layouts.app');
    }
}
