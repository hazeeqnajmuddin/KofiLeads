<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Services\WhatsappMessageBuilder;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Seed the editable site settings with the copy currently hardcoded
     * across the landing page and admin views. These become the defaults
     * the admin "Tetapan Laman" page will edit (Phase 5).
     */
    public function run(): void
    {
        $defaults = [
            'whatsapp_number' => '+60 12-345 6789',
            'whatsapp_template' => WhatsappMessageBuilder::DEFAULT_TEMPLATE,
            'social_platforms' => 'Facebook,TikTok,Instagram',
            'hero_title' => 'Semak Kelayakan Anda',
            'hero_subtitle' => 'Penyelesaian perkhidmatan perundingan kewangan yang telus dan profesional.',
            'hero_cta' => 'Buat Semakan Awal Sekarang',
            'contact_email' => 'sales@example.com',
            'facebook_url' => '',
            'instagram_url' => '',
            'tiktok_url' => '',

            // Biodata (owner profile) — generic template defaults for sales person
            'bio_jawatan' => 'Konsultan Kewangan',
            'bio_nama' => 'Nama Ejen / Sales',
            'bio_info' => 'Isikan maklumat profil dan latar belakang perkhidmatan anda di sini.',
            'stat_1_val' => '5+',
            'stat_1_label' => 'Tahun Pengalaman',
            'stat_2_val' => '1000+',
            'stat_2_label' => 'Pelanggan Dibantu',
            'stat_3_val' => '95%',
            'stat_3_label' => 'Kadar Kepuasan',
            'social_facebook' => '',
            'social_instagram' => '',
            'social_tiktok' => '',

            // Services — exact current landing-page copy
            'service_1_title' => 'Perancangan Kewangan',
            'service_1_desc' => 'Kami membantu anda merancang kewangan peribadi dengan strategi yang tersusun untuk mencapai kebebasan kewangan.',
            'service_2_title' => 'Semakan Kelayakan Pinjaman',
            'service_2_desc' => 'Semak kelayakan pinjaman anda dengan cepat dan mudah. Kami akan pandukan anda sepanjang proses permohonan.',
            'service_3_title' => 'Pengurusan & Penyatuan Hutang',
            'service_3_desc' => 'Penyelesaian komprehensif untuk membantu anda menguruskan dan merestrukturkan hutang dengan lebih efektif.',

            // Eligibility — minimum basic salary (RM), shown in the FAQ
            'min_gaji_kerajaan' => '1500',
            'min_gaji_glc' => '2500',
            'min_gaji_swasta' => '3000',
        ];

        foreach ($defaults as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value, 'updated_at' => now()],
            );
        }
    }
}
