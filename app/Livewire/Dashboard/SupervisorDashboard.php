<?php

namespace App\Livewire\Dashboard;

use App\Models\TravelApplication;
use App\Models\User;
use Livewire\Component;

class SupervisorDashboard extends Component
{
    public function render()
    {
        $user = auth()->user();

        // Pending concurrences
        $pendingConcurrences = TravelApplication::whereHas('concurrenceSteps', fn($q) =>
            $q->where('approver_id', $user->id)->where('action', 'pending')
        )->count();

        // Pending post-trip reviews
        $pendingPostTrip = TravelApplication::whereHas('concurrenceSteps', fn($q) =>
            $q->where('approver_id', $user->id)->where('action', 'concurred')
        )->where('status', 'pending_uploads')->count();

        // Get all visible staff based on hierarchy level
        $visibleUsers = $this->getVisibleUsers($user);
        $visibleIds   = $visibleUsers->pluck('id');

        // Currently out of office (travelling)
        $outOfOffice = TravelApplication::whereIn('user_id', $visibleIds)
            ->whereIn('status', ['concurred', 'submitted'])
            ->where('departure_date', '<=', now())
            ->where('return_date', '>=', now())
            ->with(['user.role', 'country', 'county'])
            ->get();

        // Team travel history
        $teamApps = TravelApplication::whereIn('user_id', $visibleIds)
            ->with(['user.role', 'country', 'county'])
            ->latest()
            ->limit(10)
            ->get();

        // Most travelled staff in my chain
        $topTravellers = User::whereIn('id', $visibleIds)
            ->where('days_used_this_year', '>', 0)
            ->orderByDesc('days_used_this_year')
            ->limit(5)
            ->get();

        // Most visited countries
        $topCountries = TravelApplication::whereIn('user_id', $visibleIds)
            ->whereNotNull('country_id')
            ->whereYear('created_at', now()->year)
            ->with('country')
            ->get()
            ->groupBy('country_id')
            ->map(fn($apps) => [
                'name'  => $apps->first()->country?->name ?? 'Unknown',
                'count' => $apps->count(),
            ])
            ->sortByDesc('count')
            ->take(5)
            ->values();

        // Team stats
        $totalTeamApps  = TravelApplication::whereIn('user_id', $visibleIds)
            ->whereYear('created_at', now()->year)->count();
        $totalTeamStaff = $visibleUsers->count();

        return view('livewire.dashboard.supervisor', compact(
            'user', 'pendingConcurrences', 'pendingPostTrip',
            'outOfOffice', 'teamApps', 'topTravellers', 'topCountries',
            'totalTeamApps', 'totalTeamStaff'
        ))->layout('components.layouts.app');
    }

    private function getVisibleUsers($user): \Illuminate\Support\Collection
    {
        $level = $user->hierarchyLevel();

        // Officers/Senior/Principal (7-9) — direct reports only
        if ($level >= 7) {
            return User::where('supervisor_id', $user->id)
                ->where('status', 'active')->get();
        }

        // Assistant Director (6) — direct reports
        if ($level === 6) {
            return User::where('supervisor_id', $user->id)
                ->where('status', 'active')->get();
        }

        // Deputy Director (5) — division staff at levels 6-9
        if ($level === 5 && $user->department_id) {
            return User::where('department_id', $user->department_id)
                ->whereHas('role', fn($q) => $q->where('hierarchy_level', '>', $level))
                ->where('status', 'active')->get();
        }

        // Director (4) — full division
        if ($level === 4 && $user->department_id) {
            return User::where('department_id', $user->department_id)
                ->where('id', '!=', $user->id)
                ->where('status', 'active')->get();
        }

        // Assistant Secretary (3) — full administration directorate below them
        if ($level === 3 && $user->department?->directorate_id) {
            return User::whereHas('department', fn($q) =>
                $q->where('directorate_id', $user->department->directorate_id)
            )->where('id', '!=', $user->id)->where('status', 'active')->get();
        }

        // Secretary (2) — full directorate
        if ($level === 2 && $user->department?->directorate_id) {
            return User::whereHas('department', fn($q) =>
                $q->where('directorate_id', $user->department->directorate_id)
            )->where('id', '!=', $user->id)->where('status', 'active')->get();
        }

        return collect();
    }
}
