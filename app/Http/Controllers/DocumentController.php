<?php

namespace App\Http\Controllers;

use App\Models\ApplicationDocument;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function show(ApplicationDocument $document)
    {
        $user = auth()->user();
        $app  = $document->application;

        // Access check — own app, supervisor, HR, PS, superadmin
        $allowed = $app->user_id === $user->id
            || $user->isSuperAdmin()
            || $user->isHR()
            || $user->isPS()
            || $app->user->supervisor_id === $user->id;

        if (! $allowed) {
            abort(403, 'You are not authorised to view this document.');
        }

        if (! Storage::disk('local')->exists($document->file_path)) {
            abort(404, 'Document not found.');
        }

        $mime = $document->mime_type ?? match(
            strtolower(pathinfo($document->original_name, PATHINFO_EXTENSION))
        ) {
            'pdf'         => 'application/pdf',
            'jpg', 'jpeg' => 'image/jpeg',
            'png'         => 'image/png',
            default       => 'application/octet-stream',
        };

        // Stream inline (opens in browser tab) for PDF/images
        // Force download for anything else
        $disposition = in_array($mime, ['application/pdf', 'image/jpeg', 'image/png', 'image/jpg'])
            ? 'inline'
            : 'attachment';

        return response()->file(
            Storage::disk('local')->path($document->file_path),
            [
                'Content-Type'        => $mime,
                'Content-Disposition' => "{$disposition}; filename=\"{$document->original_name}\"",
            ]
        );
    }
}
