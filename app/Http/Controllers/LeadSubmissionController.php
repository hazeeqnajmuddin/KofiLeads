<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLeadRequest;
use App\Models\Dokumen;
use App\Models\Lead;
use App\Models\LeadMasalah;
use App\Models\Setting;
use App\Services\DocumentMergeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;

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

        $lead->loadMissing('masalah');

        $masalahLabels = [
            'komitmen_tinggi' => 'Komitmen Tinggi',
            'ccris'           => 'CCRIS',
            'ctos'            => 'CTOS',
            'akpk'            => 'AKPK',
            'saa'             => 'SAA',
            'legal_action'    => 'Tindakan Undang-undang',
            'lain_lain'       => 'Lain-lain',
        ];

        $sektorLabels = [
            'kerajaan' => 'Kerajaan',
            'glc'      => 'GLC',
            'berkanun' => 'Badan Berkanun',
            'swasta'   => 'Swasta',
        ];

        $masalahList = $lead->masalah
            ->map(fn ($m) => $masalahLabels[$m->masalah] ?? $m->masalah)
            ->implode(', ') ?: '—';

        $pdfUrl = URL::temporarySignedRoute('admin.leads.pdf', now()->addDays(7), ['lead' => $lead->id]);

        $message = "Assalamualaikum, saya {$lead->nama} ingin membuat semakan kelayakan.\n"
            . 'No. Telefon: ' . preg_replace('/\D/', '', $lead->no_telefon) . "\n"
            . 'Sektor: ' . ($sektorLabels[$lead->sektor] ?? $lead->sektor) . "\n"
            . "Majikan: {$lead->nama_majikan}\n"
            . 'Gaji Asas: RM' . number_format((float) $lead->gaji_asas, 2) . "\n"
            . "Masalah: {$masalahList}\n"
            . "Dokumen (gabungan): {$pdfUrl}";

        $whatsappNumber = preg_replace('/\D/', '', Setting::get('whatsapp_number', '60123456789'));

        return redirect()->away('https://wa.me/' . $whatsappNumber . '?text=' . urlencode($message));
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
