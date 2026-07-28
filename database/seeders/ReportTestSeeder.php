<?php

namespace Database\Seeders;

use App\Models\Lead;
use App\Models\LeadMasalah;
use App\Models\LeadPlatform;
use App\Models\PipelineLog;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * 10 leads seeded with realistic timestamps to exercise the Laporan
 * date filter across "Semua Status" and specific statuses.
 *
 * All submitted in June 2026 (last month). Status changes happen in
 * July 2026 (this month), so toggling between "Bulan Lalu" and "Bulan
 * Ini" + "Semua Status" should show clearly different sets.
 *
 * Run standalone:  php artisan db:seed --class=ReportTestSeeder
 */
class ReportTestSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::query()->first();

        // Each entry: lead data + log chain (status_baru + date).
        // The final log entry determines current pipeline_status.
        // Dates in June = last month; July = this month.
        $cases = [
            // ── Still new_lead (no July activity) ─────────────────────────
            [
                'lead' => $this->stub('Aminah Binti Zain', '+6012-101 0001', 'kerajaan', 'Guru Besar', 3800),
                'created_at' => '2026-06-03',
                'logs' => [
                    ['status_baru' => 'new_lead', 'date' => '2026-06-03'],
                ],
            ],
            [
                'lead' => $this->stub('Razif Harun', '+6011-202 0002', 'swasta', 'Pengurus IT', 5200),
                'created_at' => '2026-06-21',
                'logs' => [
                    ['status_baru' => 'new_lead', 'date' => '2026-06-21'],
                ],
            ],

            // ── Stuck at dokumen_belum_lengkap ────────────────────────────
            [
                'lead' => $this->stub('Norhaida Shaari', '+6013-303 0003', 'kerajaan', 'Jururawat', 3200),
                'created_at' => '2026-06-07',
                'logs' => [
                    ['status_baru' => 'new_lead',              'date' => '2026-06-07'],
                    ['status_baru' => 'dokumen_belum_lengkap', 'date' => '2026-06-15'],
                ],
            ],
            [
                'lead' => $this->stub('Khairul Fahmi', '+6014-404 0004', 'glc', 'Jurutera', 4900),
                'created_at' => '2026-06-25',
                'logs' => [
                    ['status_baru' => 'new_lead',              'date' => '2026-06-25'],
                    ['status_baru' => 'dokumen_belum_lengkap', 'date' => '2026-07-01'],
                ],
            ],

            // ── Reached dokumen_lengkap in July ───────────────────────────
            [
                'lead' => $this->stub('Salmah Osman', '+6016-505 0005', 'berkanun', 'Pegawai Tadbir', 4100),
                'created_at' => '2026-06-10',
                'logs' => [
                    ['status_baru' => 'new_lead',              'date' => '2026-06-10'],
                    ['status_baru' => 'dokumen_belum_lengkap', 'date' => '2026-06-18'],
                    ['status_baru' => 'dokumen_lengkap',       'date' => '2026-07-04'],
                ],
            ],

            // ── Reached dalam_semakan in July ─────────────────────────────
            [
                'lead' => $this->stub('Zulkifli Ariff', '+6017-606 0006', 'kerajaan', 'Inspektor Polis', 4600),
                'created_at' => '2026-06-14',
                'logs' => [
                    ['status_baru' => 'new_lead',        'date' => '2026-06-14'],
                    ['status_baru' => 'dokumen_lengkap', 'date' => '2026-06-28'],
                    ['status_baru' => 'dalam_semakan',   'date' => '2026-07-09'],
                ],
            ],

            // ── Layak in July (3-step journey) ────────────────────────────
            [
                'lead' => $this->stub('Faridah Mansur', '+6019-707 0007', 'berkanun', 'Doktor', 8500),
                'created_at' => '2026-06-06',
                'logs' => [
                    ['status_baru' => 'new_lead',              'date' => '2026-06-06'],
                    ['status_baru' => 'dokumen_belum_lengkap', 'date' => '2026-06-12'],
                    ['status_baru' => 'dokumen_lengkap',       'date' => '2026-06-30'],
                    ['status_baru' => 'dalam_semakan',         'date' => '2026-07-07'],
                    ['status_baru' => 'layak',                 'date' => '2026-07-17'],
                ],
            ],
            [
                'lead' => $this->stub('Hafizuddin Rosli', '+6011-808 0008', 'swasta', 'Pengurus Kanan', 7200),
                'created_at' => '2026-06-18',
                'logs' => [
                    ['status_baru' => 'new_lead',        'date' => '2026-06-18'],
                    ['status_baru' => 'dokumen_lengkap', 'date' => '2026-07-02'],
                    ['status_baru' => 'dalam_semakan',   'date' => '2026-07-11'],
                    ['status_baru' => 'layak',           'date' => '2026-07-21'],
                ],
            ],

            // ── Tidak layak in July ───────────────────────────────────────
            [
                'lead' => $this->stub('Nurul Syazwani Idris', '+6012-909 0009', 'swasta', 'Pembantu Am', 2400),
                'created_at' => '2026-06-11',
                'logs' => [
                    ['status_baru' => 'new_lead',              'date' => '2026-06-11'],
                    ['status_baru' => 'dokumen_belum_lengkap', 'date' => '2026-06-20'],
                    ['status_baru' => 'dokumen_lengkap',       'date' => '2026-07-05'],
                    ['status_baru' => 'dalam_semakan',         'date' => '2026-07-13'],
                    ['status_baru' => 'tidak_layak',           'date' => '2026-07-24'],
                ],
            ],
            [
                'lead' => $this->stub('Roslan Hamdan', '+6013-010 0010', 'kerajaan', 'Juruteknik', 3100),
                'created_at' => '2026-06-16',
                'logs' => [
                    ['status_baru' => 'new_lead',        'date' => '2026-06-16'],
                    ['status_baru' => 'dokumen_lengkap', 'date' => '2026-07-03'],
                    ['status_baru' => 'dalam_semakan',   'date' => '2026-07-14'],
                    ['status_baru' => 'tidak_layak',     'date' => '2026-07-25'],
                ],
            ],
        ];

        foreach ($cases as $case) {
            $row = $case['lead'];
            $finalStatus = end($case['logs'])['status_baru'];

            $lead = Lead::create([
                'nama'              => $row['nama'],
                'no_telefon'        => $row['no_telefon'],
                'emel'              => $row['emel'],
                'daerah'            => $row['daerah'],
                'poskod'            => $row['poskod'],
                'sektor'            => $row['sektor'],
                'nama_majikan'      => $row['nama_majikan'],
                'jawatan'           => $row['jawatan'],
                'gaji_asas'         => $row['gaji_asas'],
                'status_pekerjaan'  => 'tetap',
                'pipeline_status'   => $finalStatus,
                'consent_pdpa'      => true,
                'consent_pdpa_at'   => Carbon::parse($case['created_at']),
                'consent_contact'   => true,
                'consent_contact_at'=> Carbon::parse($case['created_at']),
                'assigned_to'       => $admin?->id,
                'submitted_at'      => Carbon::parse($case['created_at']),
            ]);

            // Backdate created_at / updated_at.
            DB::table('leads')->where('id', $lead->id)->update([
                'created_at' => $case['created_at'].' 09:00:00',
                'updated_at' => $case['created_at'].' 09:00:00',
            ]);

            // Pipeline log + fill _at columns.
            $statusLama = null;
            $statusDates = [];
            foreach ($case['logs'] as $log) {
                if ($admin) {
                    PipelineLog::create([
                        'lead_id'    => $lead->id,
                        'status_lama'=> $statusLama,
                        'status_baru'=> $log['status_baru'],
                        'catatan'    => 'Data uji laporan (ReportTestSeeder)',
                        'changed_by' => $admin->id,
                        'created_at' => $log['date'].' 09:00:00',
                    ]);
                }
                $statusLama = $log['status_baru'];
                if ($log['status_baru'] !== 'new_lead') {
                    $statusDates[$log['status_baru'].'_at'] = $log['date'].' 09:00:00';
                }
            }
            if ($statusDates) {
                DB::table('leads')->where('id', $lead->id)->update($statusDates);
            }

            // Random masalah for a few leads.
            if (in_array($finalStatus, ['tidak_layak', 'dokumen_belum_lengkap'], true)) {
                LeadMasalah::create([
                    'lead_id'    => $lead->id,
                    'masalah'    => fake()->randomElement(['komitmen_tinggi', 'ccris', 'ctos']),
                    'created_at' => Carbon::parse($case['created_at']),
                ]);
            }

            // Assign a platform to every lead.
            LeadPlatform::create([
                'lead_id'    => $lead->id,
                'platform'   => fake()->randomElement(['facebook', 'tiktok', 'instagram']),
                'created_at' => Carbon::parse($case['created_at']),
            ]);
        }

        $this->command->info('ReportTestSeeder: 10 leads seeded (June submitted, July activity).');
    }

    private function stub(string $nama, string $tel, string $sektor, string $jawatan, int $gaji): array
    {
        return [
            'nama'         => $nama,
            'no_telefon'   => $tel,
            'emel'         => strtolower(str_replace(' ', '.', $nama)).'@test.my',
            'daerah'       => fake()->randomElement(['Kuala Lumpur', 'Petaling Jaya', 'Shah Alam', 'Subang Jaya']),
            'poskod'       => fake()->numerify('#####'),
            'sektor'       => $sektor,
            'nama_majikan' => fake()->company(),
            'jawatan'      => $jawatan,
            'gaji_asas'    => $gaji,
        ];
    }
}
