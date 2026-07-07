<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add free-text detail for the "lain_lain" (Others) masalah option — the
     * text the user types when they tick "Lain-lain" on the landing form.
     * Nullable: only rows with masalah = lain_lain carry a value.
     */
    public function up(): void
    {
        Schema::table('lead_masalah', function (Blueprint $table) {
            $table->string('keterangan', 100)->nullable()->after('masalah');
        });
    }

    public function down(): void
    {
        Schema::table('lead_masalah', function (Blueprint $table) {
            $table->dropColumn('keterangan');
        });
    }
};
