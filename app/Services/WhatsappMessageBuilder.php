<?php

namespace App\Services;

use App\Models\Lead;
use App\Models\Setting;

/**
 * Phase 9 (Slice 2) — build the pre-filled WhatsApp message + wa.me URL from an
 * admin-editable template. The template lives in settings (`whatsapp_template`)
 * and uses {token} placeholders; only whitelisted tokens are substituted, so a
 * typo in the template can never break the redirect (unknown {foo} is left as-is).
 */
class WhatsappMessageBuilder
{
    /** Default template — also seeded into settings. */
    public const DEFAULT_TEMPLATE = "Assalamualaikum, saya {nama} ingin membuat semakan kelayakan.\n"
        ."No. Telefon: {no_telefon}\n"
        ."Sektor: {sektor}\n"
        ."Majikan: {nama_majikan} ({jawatan})\n"
        ."Gaji Asas: RM{gaji_asas}\n"
        ."Masalah: {masalah}\n"
        .'Dokumen (gabungan): {link}';

    private const SEKTOR_LABELS = [
        'kerajaan' => 'Kerajaan',
        'glc' => 'GLC',
        'berkanun' => 'Badan Berkanun',
        'swasta' => 'Swasta',
    ];

    private const MASALAH_LABELS = [
        'komitmen_tinggi' => 'Komitmen Tinggi',
        'ccris' => 'CCRIS',
        'ctos' => 'CTOS',
        'akpk' => 'AKPK',
        'saa' => 'SAA',
        'legal_action' => 'Legal Action',
        'lain_lain' => 'Lain-lain',
    ];

    /**
     * Build the full wa.me URL, or null when no WhatsApp number is configured.
     */
    public function url(Lead $lead, ?string $link): ?string
    {
        $number = preg_replace('/\D/', '', (string) Setting::get('whatsapp_number'));

        if ($number === '') {
            return null;
        }

        $template = Setting::get('whatsapp_template', self::DEFAULT_TEMPLATE) ?: self::DEFAULT_TEMPLATE;
        $message = $this->render($template, $this->tokens($lead, $link));

        return 'https://wa.me/'.$number.'?text='.rawurlencode($message);
    }

    /**
     * Replace only known {tokens}; unknown placeholders are left untouched.
     */
    public function render(string $template, array $tokens): string
    {
        foreach ($tokens as $key => $value) {
            $template = str_replace('{'.$key.'}', (string) $value, $template);
        }

        return $template;
    }

    /**
     * The whitelisted token → value map for a lead.
     *
     * @return array<string, string>
     */
    public function tokens(Lead $lead, ?string $link): array
    {
        return [
            'nama' => $lead->nama,
            'no_telefon' => $lead->no_telefon,
            'emel' => $lead->emel ?? '-',
            'daerah' => $lead->daerah,
            'poskod' => $lead->poskod,
            'sektor' => self::SEKTOR_LABELS[$lead->sektor] ?? $lead->sektor,
            'nama_majikan' => $lead->nama_majikan,
            'jawatan' => $lead->jawatan,
            'gaji_asas' => number_format((float) $lead->gaji_asas, 2),
            'status_pekerjaan' => ucfirst($lead->status_pekerjaan),
            'masalah' => $this->masalahText($lead),
            'link' => $link ?? '(akan dihantar kemudian)',
        ];
    }

    private function masalahText(Lead $lead): string
    {
        return $lead->masalah->map(function ($m) {
            $label = self::MASALAH_LABELS[$m->masalah] ?? $m->masalah;

            return $m->masalah === 'lain_lain' && $m->keterangan ? "{$label}: {$m->keterangan}" : $label;
        })->implode(', ');
    }
}
