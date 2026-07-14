<?php

namespace Database\Factories;

use App\Models\Lead;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Lead>
 */
class LeadFactory extends Factory
{
    protected $model = Lead::class;

    public function definition(): array
    {
        $sektor = fake()->randomElement(['kerajaan', 'glc', 'berkanun', 'swasta']);

        return [
            'nama' => fake()->name(),
            'no_telefon' => '+60' . fake()->numerify('1#-### ####'),
            'emel' => fake()->optional()->safeEmail(),
            'daerah' => fake()->randomElement(['Petaling Jaya', 'Kuala Lumpur', 'Shah Alam', 'Klang', 'Kajang']),
            'poskod' => fake()->numerify('#####'),
            'sektor' => $sektor,
            'nama_majikan' => fake()->company(),
            'jawatan' => fake()->jobTitle(),
            'gaji_asas' => fake()->numberBetween(2000, 9000),
            'status_pekerjaan' => fake()->randomElement(['tetap', 'kontrak']),
            'pipeline_status' => fake()->randomElement([
                'new_lead', 'dokumen_belum_lengkap', 'dokumen_lengkap',
                'dalam_semakan', 'layak', 'tidak_layak', 'submit_bank', 'follow_up',
            ]),
            'consent_pdpa' => true,
            'consent_contact' => true,
            'consent_marketing' => fake()->boolean(),
            'assigned_to' => null,
            'submitted_at' => fake()->dateTimeBetween('-2 months', 'now'),
        ];
    }
}
