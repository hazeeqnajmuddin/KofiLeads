<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class LeadPlatform extends Model
{
    protected $table = 'lead_platform';

    public $timestamps = false;

    protected $fillable = [
        'lead_id',
        'platform',
        'keterangan',
        'created_at',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
        ];
    }

    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }

    /**
     * Admin-editable platform options → [slug => label], from the
     * `social_platforms` setting (comma-separated labels). "Lain-lain" is
     * appended by the form/validation, not stored in the setting.
     */
    public static function options(): array
    {
        $raw = Setting::get('social_platforms', 'Facebook,TikTok,Instagram');

        $options = [];
        foreach (explode(',', (string) $raw) as $label) {
            $label = trim($label);
            if ($label === '') {
                continue;
            }
            $options[Str::slug($label, '_')] = $label;
        }

        return $options;
    }

    /**
     * Accepted platform values for validation: the configured options + lain_lain.
     *
     * @return array<int, string>
     */
    public static function allowedValues(): array
    {
        return array_merge(array_keys(self::options()), ['lain_lain']);
    }
}
