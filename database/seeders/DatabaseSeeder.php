<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Preset admin account — credentials visible here for initial setup only.
        User::create([
            'name' => 'Admin',
            'email' => 'rahmahconsultant@gmail.com',
            'password' => 'Admin@1234',
        ]);

        $this->call([
            SettingsSeeder::class,
            DemoLeadsSeeder::class,
        ]);
    }
}
