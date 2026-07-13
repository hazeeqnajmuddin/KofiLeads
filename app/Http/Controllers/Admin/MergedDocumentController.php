<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Services\DocumentMergeService;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class MergedDocumentController extends Controller
{
    /**
     * Show a lead's merged PDF inline (opens in a new tab; downloadable from there).
     *
     * If the merged file doesn't exist yet (e.g. seeded demo leads, or a merge
     * that failed at submission), it is generated on demand and cached on the
     * lead. Streams from the PRIVATE disk. Not auth-gated yet (no-auth phase,
     * same as the rest of /admin/*).
     */
    public function show(Lead $lead, DocumentMergeService $merger): StreamedResponse
    {
        $path = $lead->merged_path;

        if (! $path || ! Storage::disk('local')->exists($path)) {
            $path = $merger->merge($lead->load('dokumen'));

            if ($path) {
                $lead->update(['merged_path' => $path, 'merged_at' => now()]);
            }
        }

        abort_unless($path && Storage::disk('local')->exists($path), 404, 'Tiada dokumen untuk digabungkan.');

        return Storage::disk('local')->response(
            $path,
            "permohonan-{$lead->id}.pdf",
            ['Content-Type' => 'application/pdf'],
            'inline',
        );
    }
}
