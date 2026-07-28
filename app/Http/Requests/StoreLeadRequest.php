<?php

namespace App\Http\Requests;

use App\Models\LeadPlatform;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreLeadRequest extends FormRequest
{
    /**
     * Public endpoint — anyone may submit the landing-page form.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Normalise the phone number into +60 international format:
     * strip non-digits, drop a leading 60 country code and/or a leading 0
     * trunk prefix the user may have typed, then prepend +60.
     */
    protected function prepareForValidation(): void
    {
        $digits = preg_replace('/\D/', '', $this->no_telefon ?? '');
        // Drop leading 60 if user typed the country code themselves
        $digits = preg_replace('/^60/', '', $digits);
        // Drop a leading 0 (local trunk prefix) — it must not appear after +60
        $digits = preg_replace('/^0+/', '', $digits);
        $this->merge(['no_telefon' => '+60'.$digits]);
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $file = ['file', 'mimes:pdf,jpg,jpeg,png', 'max:5120']; // 5 MB

        return [
            // Personal
            'nama' => ['required', 'string', 'max:100'],
            'no_telefon' => ['required', 'string', 'regex:/^\+60\d{9,10}$/'],
            'emel' => ['nullable', 'email', 'max:255'],
            'daerah' => ['required', 'string', 'max:100'],
            'poskod' => ['required', 'string', 'regex:/^\d{5}$/'],

            // Reference code (optional — typed by the applicant, announced by the live host)
            'kod_rujukan' => ['nullable', 'string', 'max:50'],

            // Social-media platform(s) — required multi-select from admin-editable options
            'platform' => ['required', 'array', 'min:1'],
            'platform.*' => [Rule::in(LeadPlatform::allowedValues())],
            'platform_lain' => [
                Rule::requiredIf(fn () => in_array('lain_lain', (array) $this->input('platform', []), true)),
                'nullable', 'string', 'max:100',
            ],

            // Employment
            'sektor' => ['required', Rule::in(['kerajaan', 'glc', 'berkanun', 'swasta'])],
            'nama_majikan' => ['required', 'string', 'max:255'],
            'jawatan' => ['required', 'string', 'max:255'],
            'gaji_asas' => ['required', 'numeric', 'min:1'],
            'status_pekerjaan' => ['required', Rule::in(['tetap', 'kontrak'])],

            // Applied for a bank/koperasi loan in the last 3 months (Ya/Tidak + name if Ya)
            'apply_pinjaman_3bulan' => ['required', 'boolean'],
            'bank_koperasi_nama' => [
                Rule::requiredIf(fn () => $this->boolean('apply_pinjaman_3bulan')),
                'nullable', 'string', 'max:255',
            ],

            // Issues (multi-select)
            'masalah' => ['required', 'array', 'min:1'],
            'masalah.*' => [Rule::in([
                'komitmen_tinggi', 'ccris', 'ctos', 'akpk', 'saa', 'legal_action', 'lain_lain',
            ])],
            // Free-text detail for "Lain-lain" — required only when that box is ticked.
            'masalah_lain' => [
                Rule::requiredIf(fn () => in_array('lain_lain', (array) $this->input('masalah', []), true)),
                'nullable', 'string', 'max:100',
            ],

            // Documents
            'slip_gaji' => ['required', 'array', 'size:3'],
            'slip_gaji.*' => $file,
            'ctos_report' => array_merge(['required'], $file),
            // EPF is only shown/required for the private sector (swasta)
            'penyata_epf' => array_merge(
                [Rule::requiredIf($this->input('sektor') === 'swasta'), 'nullable'],
                $file,
            ),

            // Consent (PDPA) — the two mandatory ones must be accepted
            'consent_pdpa' => ['accepted'],
            'consent_contact' => ['accepted'],
            'consent_marketing' => ['nullable', 'boolean'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'no_telefon.regex' => 'Nombor telefon tidak sah. Masukkan 9–10 digit selepas +60, tanpa 0 di hadapan (cth: 123456789).',
            'poskod.regex' => 'Poskod tidak sah. Sila masukkan 5 digit sahaja (cth: 47810).',
            'gaji_asas.min' => 'Gaji asas mestilah lebih daripada 0.',
            'nama.max' => 'Nama tidak boleh melebihi 100 aksara.',
            'platform.required' => 'Sila pilih sekurang-kurangnya satu platform media sosial.',
            'platform.min' => 'Sila pilih sekurang-kurangnya satu platform media sosial.',
            'platform_lain.required' => 'Sila nyatakan platform apabila memilih "Lain-lain".',
            'apply_pinjaman_3bulan.required' => 'Sila pilih Ya atau Tidak untuk permohonan pinjaman.',
            'bank_koperasi_nama.required' => 'Sila nyatakan nama bank atau koperasi.',
            'consent_pdpa.accepted' => 'Persetujuan Notis Perlindungan Data Peribadi diperlukan.',
            'consent_contact.accepted' => 'Persetujuan untuk dihubungi diperlukan.',
            'slip_gaji.size' => 'Sila muat naik slip gaji untuk 3 bulan.',
            'penyata_epf.required' => 'Penyata EPF diperlukan untuk sektor swasta.',
            'masalah_lain.required' => 'Sila nyatakan masalah anda apabila memilih "Lain-lain".',
            'masalah_lain.max' => 'Keterangan masalah tidak boleh melebihi 100 aksara.',
        ];
    }
}
