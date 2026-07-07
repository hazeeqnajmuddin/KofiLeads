<?php

namespace Database\Seeders;

use App\Models\Dokumen;
use App\Models\Lead;
use App\Models\LeadMasalah;
use App\Models\PipelineLog;
use App\Models\User;
use Illuminate\Database\Seeder;

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
                'pipeline_status' => 'approved',
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
                'pipeline_status' => 'rejected',
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
                'consent_contact' => true,
                'consent_marketing' => false,
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

            // slip_gaji: N monthly documents
            for ($bulan = 1; $bulan <= $row['dokumen']['slip_gaji']; $bulan++) {
                Dokumen::factory()->for($lead)->create([
                    'jenis' => 'slip_gaji',
                    'bulan' => $bulan,
                ]);
            }
            if ($row['dokumen']['laporan_ctos']) {
                Dokumen::factory()->for($lead)->create(['jenis' => 'laporan_ctos', 'bulan' => null]);
            }
            if ($row['dokumen']['penyata_epf']) {
                Dokumen::factory()->for($lead)->create(['jenis' => 'penyata_epf', 'bulan' => null]);
            }

            // Initial pipeline log entry (status_lama null = first entry)
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
    }
}
