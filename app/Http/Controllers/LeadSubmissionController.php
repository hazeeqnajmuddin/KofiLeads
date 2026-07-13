<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLeadRequest;
use App\Models\Dokumen;
use App\Models\Lead;
use App\Models\LeadMasalah;
use App\Services\DocumentMergeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LeadSubmissionController extends Controller
{
    public function __construct(private DocumentMergeService $merger) {}

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
                'pipeline_status' => 'new_lead',
                'consent_pdpa' => $request->boolean('consent_pdpa'),
                'consent_contact' => $request->boolean('consent_contact'),
                'consent_marketing' => $request->boolean('consent_marketing'),
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
                $lead->update(['merged_path' => $path, 'merged_at' => now()]);
            }
        } catch (\Throwable $e) {
            Log::warning("Merge failed for lead {$lead->id}: {$e->getMessage()}");
        }

        // Production hand-off (deferred — see RCMS_Architecture.md §2d & §10h):
        //   $whatsapp = preg_replace('/\D/', '', Setting::get('whatsapp_number'));
        //   return redirect()->away("https://wa.me/{$whatsapp}");

        return redirect('/')
            ->with('success', 'Permohonan anda berjaya dihantar. Maklumat dan dokumen telah diterima — pihak kami akan menghubungi anda tidak lama lagi.');
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
