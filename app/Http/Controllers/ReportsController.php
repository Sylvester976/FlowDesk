<?php

namespace App\Http\Controllers;

use App\Models\TravelApplication;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ReportsController extends Controller
{
    /**
     * All applications export — CSV
     */
    public function applications(Request $request)
    {
        abort_unless(auth()->user()->canViewAllApplications(), 403);

        $year   = $request->get('year', now()->year);
        $status = $request->get('status', '');
        $type   = $request->get('type', '');

        $apps = TravelApplication::with(['user.role', 'user.department.directorate', 'country', 'county'])
            ->whereYear('travel_applications.created_at', $year)
            ->when($status, fn($q) => $q->where('status', $status))
            ->when($type,   fn($q) => $q->where('travel_type', $type))
            ->orderBy('created_at', 'desc')
            ->get();

        $filename = "applications_{$year}" . ($status ? "_{$status}" : '') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($apps) {
            $handle = fopen('php://output', 'w');

            // Header row
            fputcsv($handle, [
                'Reference Number',
                'Staff Name',
                'PF Number',
                'Role',
                'Directorate',
                'Division',
                'Travel Type',
                'Destination',
                'Departure Date',
                'Return Date',
                'Duration (Days)',
                'Per Diem Days',
                'Funding Source',
                'Status',
                'Submitted At',
                'Clearance Generated',
            ]);

            foreach ($apps as $app) {
                fputcsv($handle, [
                    $app->reference_number,
                    $app->user->full_name,
                    $app->user->pf_number,
                    $app->user->role?->label,
                    $app->user->department?->directorate?->name,
                    $app->user->department?->name,
                    $app->getTravelTypeLabel(),
                    $app->country?->name ?? ($app->county?->name . ' County') ?? '',
                    $app->departure_date->format('d/m/Y'),
                    $app->return_date->format('d/m/Y'),
                    $app->getDurationDays(),
                    $app->per_diem_days ?? '',
                    $app->funding_source ?? '',
                    $app->getStatusLabel(),
                    $app->created_at->format('d/m/Y H:i'),
                    $app->clearance_letter_generated_at?->format('d/m/Y H:i') ?? '',
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Days docket report — CSV
     */
    public function docket(Request $request)
    {
        abort_unless(auth()->user()->canViewAllApplications(), 403);

        $staff = User::with(['role', 'department.directorate'])
            ->where('status', 'active')
            ->orderBy('last_name')
            ->get();

        $filename = 'days_docket_' . now()->year . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($staff) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'PF Number',
                'Staff Name',
                'Role',
                'Directorate',
                'Division',
                'Max Days Per Year',
                'Days Used',
                'Days Remaining',
                'Usage %',
                'Status',
            ]);

            foreach ($staff as $s) {
                $pct = $s->max_days_per_year > 0
                    ? round(($s->days_used_this_year / $s->max_days_per_year) * 100, 1)
                    : 0;

                $status = $pct >= 100 ? 'Exceeded' : ($pct >= 80 ? 'Warning' : 'OK');

                fputcsv($handle, [
                    $s->pf_number,
                    $s->full_name,
                    $s->role?->label,
                    $s->department?->directorate?->name,
                    $s->department?->name,
                    $s->max_days_per_year,
                    $s->days_used_this_year,
                    $s->days_remaining,
                    $pct . '%',
                    $status,
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Travel summary report — CSV
     */
    public function summary(Request $request)
    {
        abort_unless(auth()->user()->canViewAllApplications(), 403);

        $year = $request->get('year', now()->year);

        $apps = TravelApplication::with(['user.role', 'user.department.directorate', 'country', 'county', 'postTripUpload'])
            ->whereYear('travel_applications.created_at', $year)
            ->where('status', 'closed')
            ->orderBy('created_at', 'desc')
            ->get();

        $filename = "travel_summary_{$year}.csv";

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($apps) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'Reference Number',
                'Staff Name',
                'PF Number',
                'Directorate',
                'Division',
                'Travel Type',
                'Destination',
                'Departure Date',
                'Return Date',
                'Duration (Days)',
                'Per Diem Days',
                'Funding Source',
                'Actual Cost (KES)',
                'Post-Trip Submitted',
            ]);

            foreach ($apps as $app) {
                fputcsv($handle, [
                    $app->reference_number,
                    $app->user->full_name,
                    $app->user->pf_number,
                    $app->user->department?->directorate?->name,
                    $app->user->department?->name,
                    $app->getTravelTypeLabel(),
                    $app->country?->name ?? ($app->county?->name . ' County') ?? '',
                    $app->departure_date->format('d/m/Y'),
                    $app->return_date->format('d/m/Y'),
                    $app->getDurationDays(),
                    $app->per_diem_days ?? '',
                    $app->funding_source ?? '',
                    $app->postTripUpload?->actual_cost ?? '',
                    $app->postTripUpload?->submitted_at?->format('d/m/Y') ?? '',
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
