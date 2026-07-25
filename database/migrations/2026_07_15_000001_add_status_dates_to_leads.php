<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            // One timestamp per pipeline status; new_lead uses created_at.
            $table->timestamp('dokumen_belum_lengkap_at')->nullable()->after('submitted_at');
            $table->timestamp('dokumen_lengkap_at')->nullable()->after('dokumen_belum_lengkap_at');
            $table->timestamp('dalam_semakan_at')->nullable()->after('dokumen_lengkap_at');
            $table->timestamp('layak_at')->nullable()->after('dalam_semakan_at');
            $table->timestamp('tidak_layak_at')->nullable()->after('layak_at');
            $table->timestamp('submit_bank_at')->nullable()->after('tidak_layak_at');
            $table->timestamp('follow_up_at')->nullable()->after('submit_bank_at');
        });
    }

    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropColumn([
                'dokumen_belum_lengkap_at', 'dokumen_lengkap_at', 'dalam_semakan_at',
                'layak_at', 'tidak_layak_at', 'submit_bank_at', 'follow_up_at',
            ]);
        });
    }
};
