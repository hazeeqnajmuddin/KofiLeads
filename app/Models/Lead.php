<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lead extends Model
{
    /** @use HasFactory<\Database\Factories\LeadFactory> */
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
        'approved',
        'rejected',
        'disbursed',
        'closed',
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
        'pipeline_status',
        'consent_pdpa',
        'consent_contact',
        'consent_marketing',
        'assigned_to',
        'submitted_at',
    ];

    protected function casts(): array
    {
        return [
            'gaji_asas' => 'decimal:2',
            'consent_pdpa' => 'boolean',
            'consent_contact' => 'boolean',
            'consent_marketing' => 'boolean',
            'submitted_at' => 'datetime',
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
