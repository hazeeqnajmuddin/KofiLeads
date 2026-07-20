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
            // Editable social-media platform options for the landing form (Phase 10)
            'social_platforms' => 'Facebook,TikTok,Instagram',
            'hero_title' => 'Semak Kelayakan Anda',
            'hero_subtitle' => 'Rahmah Consultancy Services menyediakan penyelesaian kewangan yang inovatif. Sertai lebih 10,000 pelanggan yang telah mempercayai kami.',
            'hero_cta' => 'Buat Semakan Awal Sekarang',
            'contact_email' => 'rahmahconsultant@gmail.com',
            'facebook_url' => 'https://facebook.com/rahmahconsultancy',
            'instagram_url' => 'https://instagram.com/rahmahconsultancy',
            'tiktok_url' => 'https://www.tiktok.com/@khairulconsultant3',

            // Biodata (owner profile) — exact current landing-page copy
            'bio_jawatan' => 'Pengarah Urusan',
            'bio_nama' => 'Khairul Amri Chamili',
            'bio_info' => 'Dengan lebih 8 tahun pengalaman dalam industri kewangan Malaysia, beliau telah membantu ribuan pelanggan mencapai kebebasan kewangan melalui penyelesaian yang inovatif dan terancang. Pakar dalam perancangan kewangan, semakan pinjaman, dan penyatuan hutang dikenali kerana pendekatan yang telus dan berorientasikan hasil.',
            'stat_1_val' => '8+',
            'stat_1_label' => 'Tahun Pengalaman',
            'stat_2_val' => '10k+',
            'stat_2_label' => 'Pelanggan Dibantu',
            'stat_3_val' => '91%',
            'stat_3_label' => 'Kadar Kelulusan',
            'social_facebook' => 'https://facebook.com/YOUR_USERNAME',
            'social_instagram' => 'https://instagram.com/YOUR_USERNAME',
            'social_tiktok' => 'https://www.tiktok.com/@khairulconsultant3',

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
