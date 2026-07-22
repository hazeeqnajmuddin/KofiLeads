<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Phase 10 (Slice B) — admin registry of reference codes announced during
     * live sessions. The applicant types the code on the form (stored on the
     * lead as `kod_rujukan`); this table lets admins generate/track codes per
     * live host and powers the Laporan filter. One code is `is_active` (the
     * current live).
     */
    public function up(): void
    {
        Schema::create('reference_codes', function (Blueprint $table) {
            $table->id();
            $table->string('host_name');
            $table->string('code', 50)->unique();
            $table->boolean('is_active')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reference_codes');
    }
};
