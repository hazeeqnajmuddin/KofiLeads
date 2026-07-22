<?php

namespace App\Models;

use Database\Factories\DokumenFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Dokumen extends Model
{
    /** @use HasFactory<DokumenFactory> */
    use HasFactory;

    protected $table = 'dokumen';

    public $timestamps = false;

    protected $fillable = [
        'lead_id',
        'jenis',
        'bulan',
        'path',
        'nama_fail',
        'saiz',
        'created_at',
    ];

    protected function casts(): array
    {
        return [
            'bulan' => 'integer',
            'saiz' => 'integer',
            'created_at' => 'datetime',
        ];
    }

    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }
}
