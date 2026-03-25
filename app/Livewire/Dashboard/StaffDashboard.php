<?php

namespace App\Livewire\Dashboard;

use App\Models\TravelApplication;
use Livewire\Component;

class StaffDashboard extends Component
{
    public function render()
    {
        $user = auth()->user();

        // Days docket
        $daysUsed      = $user->days_used_this_year;
        $daysMax       = $user->max_days_per_year;
        $daysRemaining = $user->days_remaining;
        $daysPercent   = $daysMax > 0 ? min(100, round(($daysUsed / $daysMax) * 100)) : 0;

        // Active application
        $activeApp = TravelApplication::where('user_id', $user->id)
            ->whereIn('status', ['submitted', 'pending_concurrence', 'returned', 'pending_uploads'])
            ->with(['country', 'county'])
            ->latest()
            ->first();

        // Can apply
        $canApply = ! $activeApp && ! $user->hasPendingPostTripUploads();

        // Recent applications
        $recentApps = TravelApplication::where('user_id', $user->id)
            ->with(['country', 'county'])
            ->latest()
            ->limit(5)
            ->get();

        // Countries visited
        $countriesVisited = TravelApplication::where('user_id', $user->id)
            ->where('status', 'closed')
            ->whereNotNull('country_id')
            ->with('country')
            ->get()
            ->groupBy('country_id')
            ->map(fn($apps) => [
                'name'  => $apps->first()->country->name,
                'count' => $apps->count(),
            ])
            ->sortByDesc('count')
            ->take(5)
            ->values();

        // Applications by type this year
        $appsByType = TravelApplication::where('user_id', $user->id)
            ->whereYear('created_at', now()->year)
            ->selectRaw('travel_type, count(*) as total')
            ->groupBy('travel_type')
            ->pluck('total', 'travel_type')
            ->toArray();

        return view('livewire.dashboard.staff', compact(
            'user', 'daysUsed', 'daysMax', 'daysRemaining', 'daysPercent',
            'activeApp', 'canApply', 'recentApps', 'countriesVisited', 'appsByType'
        ))->layout('components.layouts.app');
    }
}
