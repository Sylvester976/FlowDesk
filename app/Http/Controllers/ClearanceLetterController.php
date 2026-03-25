<?php

namespace App\Http\Controllers;

use App\Models\TravelApplication;
use Illuminate\Support\Facades\Storage;

class ClearanceLetterController extends Controller
{
    public function show(TravelApplication $application)
    {
        $user = auth()->user();

        // Only applicant, supervisor, HR, PS can download
        $allowed = $application->user_id === $user->id
            || $user->isSuperAdmin()
            || $user->isHR()
            || $user->isPS()
            || $application->user->supervisor_id === $user->id;

        if (! $allowed) abort(403);

        if (! $application->clearance_letter_path) abort(404, 'Clearance letter not yet generated.');

        if (! Storage::disk('local')->exists($application->clearance_letter_path)) {
            abort(404, 'Clearance letter file not found.');
        }

        return response()->file(
            Storage::disk('local')->path($application->clearance_letter_path),
            [
                'Content-Type'        => 'application/pdf',
                'Content-Disposition' => "inline; filename=\"Clearance_{$application->reference_number}.pdf\"",
            ]
        );
    }
}
