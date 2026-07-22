<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingsRequest extends FormRequest
{
    /**
     * Editable text-based setting keys for the Tetapan Laman page. Each form
     * posts only its own subset, so rules use `sometimes`. File inputs
     * (bio_image, video_iklan) are handled separately by the controller.
     */
    public const EDITABLE_KEYS = [
        // WhatsApp + Contact + Hero
        'whatsapp_number', 'whatsapp_template', 'social_platforms', 'contact_email', 'facebook_url', 'instagram_url', 'tiktok_url',
        'hero_title', 'hero_cta', 'hero_subtitle',
        // Biodata
        'bio_jawatan', 'bio_nama', 'bio_info',
        'stat_1_val', 'stat_1_label', 'stat_2_val', 'stat_2_label', 'stat_3_val', 'stat_3_label',
        'social_facebook', 'social_instagram', 'social_tiktok',
        // Services
        'service_1_title', 'service_1_desc',
        'service_2_title', 'service_2_desc',
        'service_3_title', 'service_3_desc',
        // Eligibility (minimum salary)
        'min_gaji_kerajaan', 'min_gaji_glc', 'min_gaji_swasta',
    ];

    /** Uploaded-file setting keys (stored on the public disk, path saved as the value). */
    public const FILE_KEYS = ['bio_image', 'video_iklan'];

    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $str = ['sometimes', 'nullable', 'string', 'max:255'];
        $url = ['sometimes', 'nullable', 'url', 'max:255'];
        $gaji = ['sometimes', 'nullable', 'integer', 'min:0'];

        return [
            // WhatsApp + Contact + Hero
            'whatsapp_number' => ['sometimes', 'nullable', 'string', 'max:20'],
            'whatsapp_template' => ['sometimes', 'nullable', 'string', 'max:2000'],
            'social_platforms' => ['sometimes', 'nullable', 'string', 'max:500'],
            'contact_email' => ['sometimes', 'nullable', 'email', 'max:255'],
            'facebook_url' => $url,
            'instagram_url' => $url,
            'tiktok_url' => $url,
            'hero_title' => $str,
            'hero_cta' => ['sometimes', 'nullable', 'string', 'max:100'],
            'hero_subtitle' => ['sometimes', 'nullable', 'string', 'max:500'],

            // Biodata
            'bio_jawatan' => $str,
            'bio_nama' => $str,
            'bio_info' => ['sometimes', 'nullable', 'string', 'max:2000'],
            'stat_1_val' => ['sometimes', 'nullable', 'string', 'max:20'],
            'stat_1_label' => $str,
            'stat_2_val' => ['sometimes', 'nullable', 'string', 'max:20'],
            'stat_2_label' => $str,
            'stat_3_val' => ['sometimes', 'nullable', 'string', 'max:20'],
            'stat_3_label' => $str,
            'social_facebook' => $url,
            'social_instagram' => $url,
            'social_tiktok' => $url,
            'bio_image' => ['sometimes', 'nullable', 'image', 'max:4096'],

            // Services
            'service_1_title' => $str,
            'service_1_desc' => ['sometimes', 'nullable', 'string', 'max:1000'],
            'service_2_title' => $str,
            'service_2_desc' => ['sometimes', 'nullable', 'string', 'max:1000'],
            'service_3_title' => $str,
            'service_3_desc' => ['sometimes', 'nullable', 'string', 'max:1000'],

            // Eligibility
            'min_gaji_kerajaan' => $gaji,
            'min_gaji_glc' => $gaji,
            'min_gaji_swasta' => $gaji,

            // Video (promo)
            'video_iklan' => ['sometimes', 'nullable', 'mimes:mp4,mov,webm', 'max:102400'],
        ];
    }
}
