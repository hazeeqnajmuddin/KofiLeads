<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Services\DocumentMergeService;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

class MergedDocumentController extends Controller
{
    /**
     * Admin view of a lead's merged PDF (inside the open /admin/* area).
     */
    public function show(Lead $lead, DocumentMergeService $merger): StreamedResponse
    {
        return $this->stream($lead, $merger);
    }

    /**
     * Public view of the merged PDF via its unguessable path token — the link
     * carried into WhatsApp. The token in the URL path is the secret (no query
     * string, so WhatsApp can't split the link on "&"). An unknown token shows a
     * friendly page rather than a bare 404.
     */
    public function token(string $token, DocumentMergeService $merger): StreamedResponse|Responsable|Response
    {
        $lead = Lead::query()->where('merged_token', $token)->first();

        if (! $lead) {
            return response()->view('errors.link-expired', [], 404);
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
