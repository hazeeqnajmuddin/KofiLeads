<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ReferenceCode extends Model
{
    protected $fillable = [
        'host_name',
        'code',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    /** Only the active reference code (the current live session). */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /** The currently active code string, or null. */
    public static function activeCode(): ?string
    {
        return static::query()->active()->value('code');
    }

    /**
     * Resolve a code the applicant typed against the ACTIVE codes, case-
     * insensitively. Returns the canonical stored code (correct casing) on a
     * match, or null when blank / unknown / inactive — so an unverified code is
     * silently treated as no referral (a house lead), never a payable one.
     */
    public static function resolveActive(?string $input): ?string
    {
        $input = trim((string) $input);

        if ($input === '') {
            return null;
        }

        return static::query()
            ->active()
            ->whereRaw('LOWER(code) = ?', [mb_strtolower($input)])
            ->value('code');
    }

    /**
     * The next sequential code suggestion (RCMS01, RCMS02, …), one higher than
     * the largest existing RCMS-prefixed code.
     */
    public static function nextCode(): string
    {
        $max = static::query()
            ->where('code', 'like', 'RCMS%')
            ->get()
            ->map(fn (self $rc) => (int) preg_replace('/\D/', '', $rc->code))
            ->max() ?? 0;

        return 'RCMS'.str_pad((string) ($max + 1), 2, '0', STR_PAD_LEFT);
    }

    /** A unique code to use when the admin doesn't type one (e.g. "RCMS03"). */
    public static function generate(): string
    {
        return static::nextCode();
    }
}
