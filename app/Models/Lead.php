<?php

namespace App\Models;

use Database\Factories\LeadFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lead extends Model
{
    /** @use HasFactory<LeadFactory> */
    use HasFactory, SoftDeletes;

    /** Canonical pipeline statuses, in workflow order (must match the migration enum). */
    public const PIPELINE_STATUSES = [
        'new_lead',
        'dokumen_belum_lengkap',
        'dokumen_lengkap',
        'dalam_semakan',
        'layak',
        'tidak_layak',
        'submit_bank',
        'follow_up',
    ];

    /** The 4 canonical sectors (RCMS_Architecture.md §2a). */
    public const SEKTOR = ['kerajaan', 'glc', 'berkanun', 'swasta'];

    protected $fillable = [
        'nama',
        'no_telefon',
        'emel',
        'daerah',
        'poskod',
        'sektor',
        'nama_majikan',
        'jawatan',
        'gaji_asas',
        'status_pekerjaan',
        'kod_rujukan',
        'apply_pinjaman_3bulan',
        'bank_koperasi_nama',
        'pipeline_status',
        'consent_pdpa',
        'consent_pdpa_at',
        'consent_contact',
        'consent_contact_at',
        'consent_marketing',
        'consent_marketing_at',
        'assigned_to',
        'submitted_at',
        'dokumen_belum_lengkap_at',
        'dokumen_lengkap_at',
        'dalam_semakan_at',
        'layak_at',
        'tidak_layak_at',
        'submit_bank_at',
        'follow_up_at',
        'merged_path',
        'merged_at',
        'merged_token',
    ];

    protected function casts(): array
    {
        return [
            'gaji_asas' => 'decimal:2',
            'apply_pinjaman_3bulan' => 'boolean',
            'consent_pdpa' => 'boolean',
            'consent_pdpa_at' => 'datetime',
            'consent_contact' => 'boolean',
            'consent_contact_at' => 'datetime',
            'consent_marketing' => 'boolean',
            'consent_marketing_at' => 'datetime',
            'submitted_at' => 'datetime',
            'dokumen_belum_lengkap_at' => 'datetime',
            'dokumen_lengkap_at' => 'datetime',
            'dalam_semakan_at' => 'datetime',
            'layak_at' => 'datetime',
            'tidak_layak_at' => 'datetime',
            'submit_bank_at' => 'datetime',
            'follow_up_at' => 'datetime',
            'merged_at' => 'datetime',
        ];
    }

    /**
     * Issues flagged on the application (checkbox multi-select).
     */
    public function masalah(): HasMany
    {
        return $this->hasMany(LeadMasalah::class);
    }

    /**
     * Social-media platforms the applicant found us on (checkbox multi-select).
     */
    public function platforms(): HasMany
    {
        return $this->hasMany(LeadPlatform::class);
    }

    /**
     * Uploaded documents (slip gaji, laporan CTOS, penyata EPF).
     */
    public function dokumen(): HasMany
    {
        return $this->hasMany(Dokumen::class);
    }

    /**
     * Audit trail of pipeline status changes.
     */
    public function pipelineLog(): HasMany
    {
        return $this->hasMany(PipelineLog::class);
    }

    /**
     * Admin the lead is assigned to.
     */
    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
