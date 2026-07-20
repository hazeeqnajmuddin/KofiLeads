<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Phase 10 (Slice A) — social-media platforms the applicant found us on.
     * Many-to-one per lead (multi-select), mirroring `lead_masalah`. The
     * "lain_lain" row carries the free-text detail in `keterangan`.
     */
    public function up(): void
    {
        Schema::create('lead_platform', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')->constrained('leads')->cascadeOnDelete();
            $table->string('platform', 50);
            $table->string('keterangan', 100)->nullable();
            $table->timestamp('created_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lead_platform');
    }
};
