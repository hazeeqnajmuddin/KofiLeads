<?php

namespace Database\Factories;

use App\Models\Dokumen;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Dokumen>
 */
class DokumenFactory extends Factory
{
    protected $model = Dokumen::class;

    public function definition(): array
    {
        $jenis = fake()->randomElement(['slip_gaji', 'laporan_ctos', 'penyata_epf']);

        return [
            'jenis' => $jenis,
            'bulan' => $jenis === 'slip_gaji' ? fake()->numberBetween(1, 3) : null,
            'path' => 'dokumen/demo/' . fake()->uuid() . '.pdf',
            'nama_fail' => fake()->word() . '.pdf',
            'saiz' => fake()->numberBetween(50_000, 2_000_000),
            'created_at' => now(),
        ];
    }
}
