<?php

namespace App\Http\Requests;

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
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $file = ['file', 'mimes:pdf,jpg,jpeg,png', 'max:5120']; // 5 MB

        return [
            // Personal
            'nama' => ['required', 'string', 'max:255'],
            'no_telefon' => ['required', 'string', 'max:20'],
            'emel' => ['nullable', 'email', 'max:255'],
            'daerah' => ['required', 'string', 'max:100'],
            'poskod' => ['required', 'string', 'max:5'],

            // Employment
            'sektor' => ['required', Rule::in(['kerajaan', 'glc', 'berkanun', 'swasta'])],
            'nama_majikan' => ['required', 'string', 'max:255'],
            'jawatan' => ['required', 'string', 'max:255'],
            'gaji_asas' => ['required', 'numeric', 'min:0'],
            'status_pekerjaan' => ['required', Rule::in(['tetap', 'kontrak'])],

            // Issues (multi-select)
            'masalah' => ['required', 'array', 'min:1'],
            'masalah.*' => [Rule::in([
                'komitmen_tinggi', 'ccris', 'ctos', 'akpk', 'saa', 'legal_action', 'lain_lain',
            ])],

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
            'consent_pdpa.accepted' => 'Persetujuan Notis Perlindungan Data Peribadi diperlukan.',
            'consent_contact.accepted' => 'Persetujuan untuk dihubungi diperlukan.',
            'slip_gaji.size' => 'Sila muat naik slip gaji untuk 3 bulan.',
            'penyata_epf.required' => 'Penyata EPF diperlukan untuk sektor swasta.',
        ];
    }
}
