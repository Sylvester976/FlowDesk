<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $user = auth()->user();

        // PS or Superadmin — full analytics dashboard
        if ($user->isSuperAdmin() || $user->isPS()) {
            return app(PSDashboard::class)->render();
        }

        // HR Admin
        if ($user->isHR()) {
            return app(HRDashboard::class)->render();
        }

        // Any supervisor level (Secretary down to AD)
        if ($user->isSupervisor()) {
            return app(SupervisorDashboard::class)->render();
        }

        // Staff (Officer, Senior Officer, Principal Officer)
        return app(StaffDashboard::class)->render();
    }
}
