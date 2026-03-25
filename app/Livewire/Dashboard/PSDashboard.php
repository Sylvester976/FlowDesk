<?php

namespace App\Livewire\Dashboard;

use App\Models\TravelApplication;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class PSDashboard extends Component
{
    public function render()
    {
        $year = now()->year;

        // ── Summary stats ─────────────────────────────────────
        $totalAppsYear     = TravelApplication::whereYear('created_at', $year)->count();
        $totalForeignOff   = TravelApplication::whereYear('created_at', $year)
            ->where('travel_type', 'foreign_official')->count();
        $totalForeignPriv  = TravelApplication::whereYear('created_at', $year)
            ->where('travel_type', 'foreign_private')->count();
        $totalLocal        = TravelApplication::whereYear('created_at', $year)
            ->where('travel_type', 'local')->count();

        $pendingConcurrences = TravelApplication::where('status', 'pending_concurrence')->count();
        $pendingPostTrip     = TravelApplication::where('status', 'pending_uploads')->count();
        $totalStaff          = User::where('status', 'active')->count();

        // ── Currently out of office ───────────────────────────
        $outOfOffice = TravelApplication::whereIn('status', ['concurred', 'submitted'])
            ->where('departure_date', '<=', now())
            ->where('return_date', '>=', now())
            ->with(['user.role', 'user.department.directorate', 'country', 'county'])
            ->orderBy('return_date')
            ->get();

        // ── Applications by month (chart data) ───────────────
        $appsByMonth = TravelApplication::whereYear('created_at', $year)
            ->selectRaw("extract(month from created_at)::int as month_num, count(*) as total")
            ->groupBy('month_num')
            ->orderBy('month_num')
            ->pluck('total', 'month_num')
            ->toArray();

        // Fill all 12 months
        $chartMonths = collect(range(1, 12))->map(fn($m) => [
            'month' => date('M', mktime(0, 0, 0, $m, 1)),
            'total' => $appsByMonth[$m] ?? 0,
        ]);

        // ── Travel by type for chart ──────────────────────────
        $travelByType = [
            'Foreign Official' => $totalForeignOff,
            'Foreign Private'  => $totalForeignPriv,
            'Local'            => $totalLocal,
        ];

        // ── Most visited countries ────────────────────────────
        $topCountries = TravelApplication::whereYear('created_at', $year)
            ->whereNotNull('country_id')
            ->where('status', '!=', 'cancelled')
            ->with('country')
            ->get()
            ->groupBy('country_id')
            ->map(fn($apps) => [
                'name'  => $apps->first()->country?->name ?? 'Unknown',
                'count' => $apps->count(),
            ])
            ->sortByDesc('count')
            ->take(8)
            ->values();

        // ── Most travelled staff ──────────────────────────────
        $topTravellers = User::where('status', 'active')
            ->where('days_used_this_year', '>', 0)
            ->with(['role', 'department'])
            ->orderByDesc('days_used_this_year')
            ->limit(8)
            ->get();

        // ── Staff approaching annual limit (>= 80%) ───────────
        $approachingLimit = User::where('status', 'active')
            ->where('max_days_per_year', '>', 0)
            ->whereRaw('days_used_this_year::float / max_days_per_year >= 0.8')
            ->with(['role', 'department'])
            ->orderByDesc('days_used_this_year')
            ->get();

        // ── Travel by directorate ─────────────────────────────
        $byDirectorate = TravelApplication::whereYear('travel_applications.created_at', $year)
            ->join('users', 'travel_applications.user_id', '=', 'users.id')
            ->join('departments', 'users.department_id', '=', 'departments.id')
            ->join('directorates', 'departments.directorate_id', '=', 'directorates.id')
            ->selectRaw('directorates.name as directorate, count(*) as total')
            ->groupBy('directorates.name')
            ->orderByDesc('total')
            ->get();

        // ── Recent applications (last 10) ─────────────────────
        $recentApps = TravelApplication::with(['user.role', 'country', 'county'])
            ->latest()
            ->limit(10)
            ->get();

        return view('livewire.dashboard.ps', compact(
            'totalAppsYear', 'totalForeignOff', 'totalForeignPriv', 'totalLocal',
            'pendingConcurrences', 'pendingPostTrip', 'totalStaff',
            'outOfOffice', 'chartMonths', 'travelByType',
            'topCountries', 'topTravellers', 'approachingLimit',
            'byDirectorate', 'recentApps', 'year'
        ))->layout('components.layouts.app');
    }
}
