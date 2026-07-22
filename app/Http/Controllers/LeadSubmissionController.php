<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLeadRequest;
use App\Models\Dokumen;
use App\Models\Lead;
use App\Models\LeadMasalah;
use App\Models\LeadPlatform;
use App\Models\ReferenceCode;
use App\Services\DocumentMergeService;
use App\Services\WhatsappMessageBuilder;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class LeadSubmissionController extends Controller
{
    public function __construct(
        private DocumentMergeService $merger,
        private WhatsappMessageBuilder $whatsapp,
    ) {}

    /**
     * Store a public lead submission from the landing-page form:
     * the lead + its selected issues + uploaded documents, all in one
     * transaction. Files go to the private disk (never public).
     */
    public function store(StoreLeadRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $lead = DB::transaction(function () use ($request, $data) {
            $lead = Lead::create([
                'nama' => $data['nama'],
                'no_telefon' => $data['no_telefon'],
                'emel' => $data['emel'] ?? null,
                'daerah' => $data['daerah'],
                'poskod' => $data['poskod'],
                'sektor' => $data['sektor'],
                'nama_majikan' => $data['nama_majikan'],
                'jawatan' => $data['jawatan'],
                'gaji_asas' => $data['gaji_asas'],
                'status_pekerjaan' => $data['status_pekerjaan'],
                // Verified attribution: only an ACTIVE code (any casing) is kept;
                // blank/unknown/inactive → null (house lead), silently.
                'kod_rujukan' => ReferenceCode::resolveActive($data['kod_rujukan'] ?? null),
                'apply_pinjaman_3bulan' => $request->boolean('apply_pinjaman_3bulan'),
                'bank_koperasi_nama' => $request->boolean('apply_pinjaman_3bulan') ? ($data['bank_koperasi_nama'] ?? null) : null,
                'pipeline_status' => 'new_lead',
                'consent_pdpa' => $request->boolean('consent_pdpa'),
                'consent_pdpa_at' => $request->boolean('consent_pdpa') ? now() : null,
                'consent_contact' => $request->boolean('consent_contact'),
                'consent_contact_at' => $request->boolean('consent_contact') ? now() : null,
                'consent_marketing' => $request->boolean('consent_marketing'),
                'consent_marketing_at' => $request->boolean('consent_marketing') ? now() : null,
                'submitted_at' => now(),
            ]);

            // Issues (checkbox multi-select) → one row each. The "lain_lain"
            // row carries the free-text detail the user typed.
            foreach ($data['masalah'] as $masalah) {
                LeadMasalah::create([
                    'lead_id' => $lead->id,
                    'masalah' => $masalah,
                    'keterangan' => $masalah === 'lain_lain' ? ($data['masalah_lain'] ?? null) : null,
                    'created_at' => now(),
                ]);
            }

            // Social-media platforms (checkbox multi-select) → one row each.
            // The "lain_lain" row carries the free-text detail.
            foreach ($data['platform'] as $platform) {
                LeadPlatform::create([
                    'lead_id' => $lead->id,
                    'platform' => $platform,
                    'keterangan' => $platform === 'lain_lain' ? ($data['platform_lain'] ?? null) : null,
                    'created_at' => now(),
                ]);
            }

            // Slip gaji: 3 monthly files (bulan 1..3)
            foreach (array_values($request->file('slip_gaji', [])) as $index => $file) {
                $this->storeDokumen($lead, $file, 'slip_gaji', $index + 1);
            }

            // Laporan CTOS (single, required)
            $this->storeDokumen($lead, $request->file('ctos_report'), 'laporan_ctos');

            // Penyata EPF (single, only for swasta)
            if ($request->hasFile('penyata_epf')) {
                $this->storeDokumen($lead, $request->file('penyata_epf'), 'penyata_epf');
            }

            return $lead;
        });

        // Merge the uploaded documents into one PDF (Phase 9, Slice 1). Runs
        // AFTER commit so a merge failure can never roll back a valid lead —
        // it's logged and left re-mergeable on demand from the admin panel.
        try {
            if ($path = $this->merger->merge($lead->load('dokumen'))) {
                $lead->update([
                    'merged_path' => $path,
                    'merged_at' => now(),
                    'merged_token' => $lead->merged_token ?: Str::random(40),
                ]);
            }
        } catch (\Throwable $e) {
            Log::warning("Merge failed for lead {$lead->id}: {$e->getMessage()}");
        }

        // Build the WhatsApp hand-off (Phase 9, Slice 2): a clean path-token link
        // to the merged PDF (no query string — WhatsApp mangles URLs with "&") +
        // the lead's details, from the editable template.
        $link = $lead->merged_token
            ? route('merged.token', ['token' => $lead->merged_token])
            : null;

        $waUrl = $this->whatsapp->url($lead->load(['masalah', 'platforms']), $link);

        // Show the "Terima Kasih" page, which offers the "Teruskan ke WhatsApp" button.
        return redirect()->route('leads.thankyou')
            ->with('lead_submitted', true)
            ->with('wa_url', $waUrl);
    }

    /**
     * Post-submission interstitial: confirms receipt and offers the WhatsApp
     * hand-off button. Only reachable right after a submission (flash marker);
     * a direct visit falls back to the landing page.
     */
    public function thankYou(): View|RedirectResponse
    {
        if (! session('lead_submitted')) {
            return redirect('/');
        }

        return view('terima-kasih', ['waUrl' => session('wa_url')]);
    }

    /**
     * Persist one uploaded file to the private disk and record it in `dokumen`.
     */
    private function storeDokumen(Lead $lead, UploadedFile $file, string $jenis, ?int $bulan = null): void
    {
        $path = $file->store("dokumen/{$lead->id}", 'local');

        Dokumen::create([
            'lead_id' => $lead->id,
            'jenis' => $jenis,
            'bulan' => $bulan,
            'path' => $path,
            'nama_fail' => $file->getClientOriginalName(),
            'saiz' => $file->getSize(),
            'created_at' => now(),
        ]);
    }
}
