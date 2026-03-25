<?php

namespace App\Livewire\Dashboard;

use App\Models\TravelApplication;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class HRDashboard extends Component
{
    public function render()
    {
        // Currently out of office
        $outOfOffice = TravelApplication::whereIn('status', ['concurred', 'submitted'])
            ->where('departure_date', '<=', now())
            ->where('return_date', '>=', now())
            ->with(['user.role', 'user.department', 'country', 'county'])
            ->get();

        // Pending post-trip uploads (overdue)
        $pendingPostTrip = TravelApplication::where('status', 'pending_uploads')
            ->with(['user.role', 'user.department'])
            ->latest()
            ->limit(10)
            ->get();

        // Staff with pending post-trip (returned but not yet uploaded)
        $overdueUploads = TravelApplication::where('status', 'concurred')
            ->whereDate('return_date', '<', now())
            ->whereDoesntHave('postTripUpload')
            ->with(['user.role', 'user.department'])
            ->get();

        // Total staff
        $totalStaff  = User::where('status', 'active')->count();
        $totalActive = TravelApplication::whereIn('status',
            ['submitted', 'pending_concurrence'])->count();

        // Applications this month by type
        $appsThisMonth = TravelApplication::whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->selectRaw('travel_type, count(*) as total')
            ->groupBy('travel_type')
            ->pluck('total', 'travel_type')
            ->toArray();

        // Applications this year by month (for chart)
        $appsByMonth = TravelApplication::whereYear('created_at', now()->year)
            ->selectRaw("to_char(created_at, 'Mon') as month,
                         extract(month from created_at) as month_num,
                         count(*) as total")
            ->groupBy('month', 'month_num')
            ->orderBy('month_num')
            ->get()
            ->map(fn($r) => ['month' => $r->month, 'total' => $r->total]);

        // Most travelled staff this year
        $topTravellers = User::where('status', 'active')
            ->where('days_used_this_year', '>', 0)
            ->with('role')
            ->orderByDesc('days_used_this_year')
            ->limit(8)
            ->get();

        // Staff approaching limit (>= 80% used)
        $approachingLimit = User::where('status', 'active')
            ->where('max_days_per_year', '>', 0)
            ->whereRaw('days_used_this_year::float / max_days_per_year >= 0.8')
            ->with(['role', 'department'])
            ->orderByDesc('days_used_this_year')
            ->get();

        // Most visited countries this year
        $topCountries = TravelApplication::whereYear('created_at', now()->year)
            ->whereNotNull('country_id')
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

        // Applications by directorate
        $appsByDirectorate = TravelApplication::whereYear('travel_applications.created_at', now()->year)
            ->join('users', 'travel_applications.user_id', '=', 'users.id')
            ->join('departments', 'users.department_id', '=', 'departments.id')
            ->join('directorates', 'departments.directorate_id', '=', 'directorates.id')
            ->selectRaw('directorates.name as directorate, count(*) as total')
            ->groupBy('directorates.name')
            ->orderByDesc('total')
            ->get();

        return view('livewire.dashboard.hr', compact(
            'outOfOffice', 'pendingPostTrip', 'overdueUploads',
            'totalStaff', 'totalActive', 'appsThisMonth', 'appsByMonth',
            'topTravellers', 'approachingLimit', 'topCountries', 'appsByDirectorate'
        ))->layout('components.layouts.app');
    }
}
