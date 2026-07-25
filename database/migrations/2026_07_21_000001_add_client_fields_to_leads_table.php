<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Phase 10 (Slice A) — client change request. All additive/nullable, so it
     * runs safely on an existing DB with no data loss.
     *
     * - kod_rujukan: reference code the applicant types (announced by the live host).
     * - apply_pinjaman_3bulan: has the applicant applied for a bank/koperasi loan
     *   in the last 3 months (Ya/Tidak).
     * - bank_koperasi_nama: which institution (only when the answer is Ya).
     */
    public function up(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->string('kod_rujukan', 50)->nullable()->after('poskod');
            $table->boolean('apply_pinjaman_3bulan')->nullable()->after('status_pekerjaan');
            $table->string('bank_koperasi_nama')->nullable()->after('apply_pinjaman_3bulan');
        });
    }

    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropColumn(['kod_rujukan', 'apply_pinjaman_3bulan', 'bank_koperasi_nama']);
        });
    }
};
