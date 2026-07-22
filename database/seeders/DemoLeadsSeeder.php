<?php

namespace Database\Seeders;

use App\Models\Dokumen;
use App\Models\Lead;
use App\Models\LeadMasalah;
use App\Models\LeadPlatform;
use App\Models\PipelineLog;
use App\Models\ReferenceCode;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DemoLeadsSeeder extends Seeder
{
    /**
     * Recreate the previously hardcoded admin mock rows as real records,
     * so the admin pages have browsable data once wired to the DB (Phase 4).
     */
    public function run(): void
    {
        $admin = User::query()->first();

        $rows = [
            [
                'nama' => 'Ahmad Albab',
                'no_telefon' => '+60 12-345 6789',
                'emel' => 'ahmad.albab@email.com',
                'daerah' => 'Petaling Jaya',
                'poskod' => '47810',
                'sektor' => 'swasta',
                'nama_majikan' => 'Syarikat ABC Sdn Bhd',
                'jawatan' => 'Pengurus',
                'gaji_asas' => 4500,
                'status_pekerjaan' => 'tetap',
                'pipeline_status' => 'new_lead',
                'masalah' => ['komitmen_tinggi', 'ccris'],
                'dokumen' => ['slip_gaji' => 3, 'laporan_ctos' => true, 'penyata_epf' => true],
            ],
            [
                'nama' => 'Siti Nurdiana',
                'no_telefon' => '+60 17-987 6543',
                'emel' => 'siti.nurdiana@edu.gov.my',
                'daerah' => 'Kuala Lumpur',
                'poskod' => '50480',
                'sektor' => 'kerajaan',
                'nama_majikan' => 'Kementerian Pendidikan Malaysia',
                'jawatan' => 'Pensyarah',
                'gaji_asas' => 5200,
                'status_pekerjaan' => 'tetap',
                'pipeline_status' => 'layak',
                'masalah' => ['ctos'],
                'dokumen' => ['slip_gaji' => 3, 'laporan_ctos' => true, 'penyata_epf' => false],
            ],
            [
                'nama' => 'Mohd Faizal bin Hamid',
                'no_telefon' => '+60 11-2233 4455',
                'emel' => null,
                'daerah' => 'Shah Alam',
                'poskod' => '40150',
                'sektor' => 'swasta',
                'nama_majikan' => 'Logistik Jaya Sdn Bhd',
                'jawatan' => 'Pemandu',
                'gaji_asas' => 2800,
                'status_pekerjaan' => 'kontrak',
                'pipeline_status' => 'tidak_layak',
                'masalah' => ['komitmen_tinggi', 'akpk', 'legal_action'],
                'dokumen' => ['slip_gaji' => 2, 'laporan_ctos' => false, 'penyata_epf' => false],
            ],
            [
                'nama' => 'Nurul Ain Zainudin',
                'no_telefon' => '+60 13-456 7890',
                'emel' => 'nurul.ain@hkl.gov.my',
                'daerah' => 'Kuala Lumpur',
                'poskod' => '50586',
                'sektor' => 'berkanun',
                'nama_majikan' => 'Hospital Kuala Lumpur',
                'jawatan' => 'Jururawat',
                'gaji_asas' => 3800,
                'status_pekerjaan' => 'tetap',
                'pipeline_status' => 'dalam_semakan',
                'masalah' => ['saa'],
                'dokumen' => ['slip_gaji' => 3, 'laporan_ctos' => true, 'penyata_epf' => true],
            ],
            [
                'nama' => 'Khairul Anwar Othman',
                'no_telefon' => '+60 19-234 5678',
                'emel' => 'khairul.anwar@rmp.gov.my',
                'daerah' => 'Kajang',
                'poskod' => '43000',
                'sektor' => 'kerajaan',
                'nama_majikan' => 'Polis DiRaja Malaysia',
                'jawatan' => 'Inspektor',
                'gaji_asas' => 4200,
                'status_pekerjaan' => 'tetap',
                'pipeline_status' => 'layak',
                'masalah' => ['lain_lain'],
                'dokumen' => ['slip_gaji' => 3, 'laporan_ctos' => true, 'penyata_epf' => false],
            ],
        ];

        foreach ($rows as $row) {
            $lead = Lead::create([
                'nama' => $row['nama'],
                'no_telefon' => $row['no_telefon'],
                'emel' => $row['emel'],
                'daerah' => $row['daerah'],
                'poskod' => $row['poskod'],
                'sektor' => $row['sektor'],
                'nama_majikan' => $row['nama_majikan'],
                'jawatan' => $row['jawatan'],
                'gaji_asas' => $row['gaji_asas'],
                'status_pekerjaan' => $row['status_pekerjaan'],
                'pipeline_status' => $row['pipeline_status'],
                'consent_pdpa' => true,
                'consent_pdpa_at' => now(),
                'consent_contact' => true,
                'consent_contact_at' => now(),
                'consent_marketing' => false,
                'consent_marketing_at' => null,
                'assigned_to' => $admin?->id,
                'submitted_at' => now()->subDays(rand(1, 30)),
            ]);

            foreach ($row['masalah'] as $masalah) {
                LeadMasalah::create([
                    'lead_id' => $lead->id,
                    'masalah' => $masalah,
                    'created_at' => now(),
                ]);
            }

            for ($bulan = 1; $bulan <= $row['dokumen']['slip_gaji']; $bulan++) {
                $this->createDokumen($lead, 'slip_gaji', $bulan);
            }
            if ($row['dokumen']['laporan_ctos']) {
                $this->createDokumen($lead, 'laporan_ctos', null);
            }
            if ($row['dokumen']['penyata_epf']) {
                $this->createDokumen($lead, 'penyata_epf', null);
            }

            if ($admin) {
                PipelineLog::create([
                    'lead_id' => $lead->id,
                    'status_lama' => null,
                    'status_baru' => $row['pipeline_status'],
                    'catatan' => 'Data demo (seeder)',
                    'changed_by' => $admin->id,
                    'created_at' => now(),
                ]);
            }
        }

        // ── Historic leads: Jan / Feb / March 2026 ──────────────────────────
        // These are used to test the date filter in Laporan (which filters by
        // the latest pipeline_log.created_at — i.e. when the status last changed).

        if (! $admin) {
            return;
        }

        $this->seedHistoric($admin, [
            // Jan leads — latest log in Jan → appear in Jan filter
            [
                'lead' => [
                    'nama' => 'Radin Hakim Roslan', 'no_telefon' => '+60 12-111 2233',
                    'emel' => 'radin@email.com', 'daerah' => 'Petaling Jaya', 'poskod' => '47500',
                    'sektor' => 'swasta', 'nama_majikan' => 'Teknologi Maju Sdn Bhd',
                    'jawatan' => 'Jurutera', 'gaji_asas' => 5500, 'status_pekerjaan' => 'tetap',
                    'pipeline_status' => 'new_lead',
                    'masalah' => ['komitmen_tinggi'],
                ],
                'created_at' => '2026-01-05',
                'logs' => [
                    ['status_baru' => 'new_lead', 'date' => '2026-01-05'],
                ],
            ],
            [
                'lead' => [
                    'nama' => 'Norsyazwani Bakar', 'no_telefon' => '+60 17-333 4455',
                    'emel' => 'syazwani@gov.my', 'daerah' => 'Putrajaya', 'poskod' => '62000',
                    'sektor' => 'kerajaan', 'nama_majikan' => 'Jabatan Perdana Menteri',
                    'jawatan' => 'Pegawai Tadbir', 'gaji_asas' => 4800, 'status_pekerjaan' => 'tetap',
                    'pipeline_status' => 'dokumen_belum_lengkap',
                    'masalah' => ['ccris'],
                ],
                'created_at' => '2026-01-12',
                'logs' => [
                    ['status_baru' => 'new_lead',              'date' => '2026-01-12'],
                    ['status_baru' => 'dokumen_belum_lengkap', 'date' => '2026-01-20'],
                ],
            ],

            // Feb leads — latest log in Feb → appear in Feb filter
            [
                'lead' => [
                    'nama' => 'Farah Adibah Zulkifli', 'no_telefon' => '+60 11-5566 7788',
                    'emel' => 'farah.adibah@hkl.gov.my', 'daerah' => 'Kuala Lumpur', 'poskod' => '50586',
                    'sektor' => 'berkanun', 'nama_majikan' => 'Hospital Kuala Lumpur',
                    'jawatan' => 'Doktor', 'gaji_asas' => 7200, 'status_pekerjaan' => 'tetap',
                    'pipeline_status' => 'dokumen_belum_lengkap',
                    'masalah' => [],
                ],
                'created_at' => '2026-01-18',
                'logs' => [
                    ['status_baru' => 'new_lead',              'date' => '2026-01-18'],
                    ['status_baru' => 'dokumen_lengkap',       'date' => '2026-01-28'],
                    ['status_baru' => 'dalam_semakan',         'date' => '2026-02-10'],
                    ['status_baru' => 'layak',                 'date' => '2026-03-05'],
                    ['status_baru' => 'dokumen_belum_lengkap', 'date' => '2026-04-02'],
                ],
            ],
            [
                'lead' => [
                    'nama' => 'Azri Hafizudin Mansor', 'no_telefon' => '+60 19-888 9900',
                    'emel' => null, 'daerah' => 'Shah Alam', 'poskod' => '40150',
                    'sektor' => 'glc', 'nama_majikan' => 'Petronas',
                    'jawatan' => 'Juruteknik', 'gaji_asas' => 3900, 'status_pekerjaan' => 'tetap',
                    'pipeline_status' => 'new_lead',
                    'masalah' => ['ctos', 'komitmen_tinggi'],
                ],
                'created_at' => '2026-02-07',
                'logs' => [
                    ['status_baru' => 'new_lead', 'date' => '2026-02-07'],
                ],
            ],

            // March leads — latest log in March → appear in March filter
            [
                'lead' => [
                    'nama' => 'Mazlina Tahir', 'no_telefon' => '+60 13-221 3344',
                    'emel' => 'mazlina@pdrm.gov.my', 'daerah' => 'Ipoh', 'poskod' => '31400',
                    'sektor' => 'kerajaan', 'nama_majikan' => 'Polis DiRaja Malaysia',
                    'jawatan' => 'Konstabel', 'gaji_asas' => 2900, 'status_pekerjaan' => 'tetap',
                    'pipeline_status' => 'layak',
                    'masalah' => ['lain_lain'],
                ],
                'created_at' => '2026-02-20',
                'logs' => [
                    ['status_baru' => 'new_lead',      'date' => '2026-02-20'],
                    ['status_baru' => 'dalam_semakan', 'date' => '2026-03-02'],
                    ['status_baru' => 'layak',         'date' => '2026-03-15'],
                ],
            ],
            [
                'lead' => [
                    'nama' => 'Hairul Nizam Abdullah', 'no_telefon' => '+60 16-445 6677',
                    'emel' => 'hairul@email.com', 'daerah' => 'Johor Bahru', 'poskod' => '80300',
                    'sektor' => 'swasta', 'nama_majikan' => 'Syarikat XYZ Bhd',
                    'jawatan' => 'Pengurus Kanan', 'gaji_asas' => 6800, 'status_pekerjaan' => 'tetap',
                    'pipeline_status' => 'submit_bank',
                    'masalah' => [],
                ],
                'created_at' => '2026-03-03',
                'logs' => [
                    ['status_baru' => 'new_lead',      'date' => '2026-03-03'],
                    ['status_baru' => 'dokumen_lengkap', 'date' => '2026-03-10'],
                    ['status_baru' => 'dalam_semakan', 'date' => '2026-03-18'],
                    ['status_baru' => 'layak',         'date' => '2026-03-25'],
                    ['status_baru' => 'submit_bank',   'date' => '2026-03-28'],
                ],
            ],
        ]);
    }

    private function createDokumen(Lead $lead, string $jenis, ?int $bulan, ?string $date = null): void
    {
        $suffix = $bulan ? "_bulan_{$bulan}" : '';
        $filename = "{$jenis}{$suffix}.pdf";
        $path = "dokumen/{$lead->id}/{$filename}";

        Storage::disk('local')->put($path, $this->dummyPdf());

        Dokumen::create([
            'lead_id' => $lead->id,
            'jenis' => $jenis,
            'bulan' => $bulan,
            'path' => $path,
            'nama_fail' => $filename,
            'saiz' => strlen($this->dummyPdf()),
            'created_at' => $date ? Carbon::parse($date) : now(),
        ]);
    }

    private function dummyPdf(): string
    {
        $body = "%PDF-1.4\n"
            ."1 0 obj\n<</Type/Catalog/Pages 2 0 R>>\nendobj\n"
            ."2 0 obj\n<</Type/Pages/Kids[3 0 R]/Count 1>>\nendobj\n"
            ."3 0 obj\n<</Type/Page/Parent 2 0 R/MediaBox[0 0 612 792]>>\nendobj\n";

        $xref = strlen($body);

        return $body
            ."xref\n0 4\n"
            ."0000000000 65535 f \n"
            ."0000000009 00000 n \n"
            ."0000000054 00000 n \n"
            ."0000000105 00000 n \n"
            ."trailer\n<</Size 4/Root 1 0 R>>\n"
            ."startxref\n{$xref}\n%%EOF";
    }

    private function seedHistoric(mixed $admin, array $cases): void
    {
        foreach ($cases as $case) {
            $row = $case['lead'];

            $lead = Lead::create([
                'nama' => $row['nama'],
                'no_telefon' => $row['no_telefon'],
                'emel' => $row['emel'] ?? null,
                'daerah' => $row['daerah'],
                'poskod' => $row['poskod'],
                'sektor' => $row['sektor'],
                'nama_majikan' => $row['nama_majikan'],
                'jawatan' => $row['jawatan'],
                'gaji_asas' => $row['gaji_asas'],
                'status_pekerjaan' => $row['status_pekerjaan'],
                'pipeline_status' => $row['pipeline_status'],
                'consent_pdpa' => true,
                'consent_pdpa_at' => Carbon::parse($case['created_at']),
                'consent_contact' => true,
                'consent_contact_at' => Carbon::parse($case['created_at']),
                'consent_marketing' => false,
                'consent_marketing_at' => null,
                'assigned_to' => $admin->id,
                'submitted_at' => Carbon::parse($case['created_at']),
            ]);

            // Force created_at to the historic date.
            DB::table('leads')->where('id', $lead->id)->update([
                'created_at' => $case['created_at'].' 10:00:00',
                'updated_at' => $case['created_at'].' 10:00:00',
            ]);

            foreach ($row['masalah'] as $masalah) {
                LeadMasalah::create([
                    'lead_id' => $lead->id,
                    'masalah' => $masalah,
                    'created_at' => Carbon::parse($case['created_at']),
                ]);
            }

            // Pipeline log entries + status _at columns with specific historic dates.
            $statusLama = null;
            $statusDates = [];
            foreach ($case['logs'] as $log) {
                PipelineLog::create([
                    'lead_id' => $lead->id,
                    'status_lama' => $statusLama,
                    'status_baru' => $log['status_baru'],
                    'catatan' => 'Data demo (seeder)',
                    'changed_by' => $admin->id,
                    'created_at' => $log['date'].' 10:00:00',
                ]);
                $statusLama = $log['status_baru'];
                if ($log['status_baru'] !== 'new_lead') {
                    $statusDates[$log['status_baru'].'_at'] = $log['date'].' 10:00:00';
                }
            }
            if ($statusDates) {
                DB::table('leads')->where('id', $lead->id)->update($statusDates);
            }
        }

        $this->seedClientFields();
    }

    /**
     * Phase 10 demo data: reference codes + backfill the new client fields
     * (kod_rujukan, platforms, bank/koperasi answer) onto existing leads.
     */
    private function seedClientFields(): void
    {
        $codes = [
            ['host_name' => 'Live TikTok Julai', 'code' => 'LIVE-JUL', 'is_active' => true],
            ['host_name' => 'Live Facebook Jun', 'code' => 'LIVE-JUN', 'is_active' => false],
        ];
        foreach ($codes as $c) {
            ReferenceCode::create($c);
        }

        $platforms = ['facebook', 'tiktok', 'instagram'];

        Lead::query()->get()->each(function (Lead $lead) use ($platforms) {
            // ~half the leads came from a live session.
            $lead->update([
                'kod_rujukan' => fake()->boolean(50) ? fake()->randomElement(['LIVE-JUL', 'LIVE-JUN']) : null,
                'apply_pinjaman_3bulan' => $applied = fake()->boolean(40),
                'bank_koperasi_nama' => $applied ? fake()->randomElement(['Bank Rakyat', 'Koperasi ANGKASA', 'BSN']) : null,
            ]);

            foreach ((array) fake()->randomElements($platforms, fake()->numberBetween(1, 2)) as $p) {
                LeadPlatform::create(['lead_id' => $lead->id, 'platform' => $p, 'created_at' => now()]);
            }
        });
    }
}
