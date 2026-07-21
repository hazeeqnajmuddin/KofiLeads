<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Services\DocumentMergeService;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

class MergedDocumentController extends Controller
{
    /**
     * Admin view of a lead's merged PDF (auth-gated via route middleware).
     */
    public function show(Lead $lead, DocumentMergeService $merger): StreamedResponse
    {
        return $this->stream($lead, $merger);
    }

    /**
     * Public, signed view of the merged PDF — the link carried into WhatsApp.
     * Validated manually (instead of the `signed` middleware) so an expired or
     * tampered link shows a friendly page rather than a bare 403.
     */
    public function signed(Request $request, Lead $lead, DocumentMergeService $merger): StreamedResponse|Responsable|Response
    {
        if (! $request->hasValidSignature()) {
            return response()->view('errors.link-expired', [], 403);
        }

        return $this->stream($lead, $merger);
    }

    /**
     * Stream the merged PDF inline, generating it on demand if missing.
     */
    private function stream(Lead $lead, DocumentMergeService $merger): StreamedResponse
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
            $this->downloadName($lead),
            ['Content-Type' => 'application/pdf'],
            'inline',
        );
    }

    /**
     * User-facing PDF filename, built from the lead (sanitized).
     */
    private function downloadName(Lead $lead): string
    {
        return 'permohonan-'.Str::slug($lead->nama).'-'.$lead->id.'.pdf';
    }
}
