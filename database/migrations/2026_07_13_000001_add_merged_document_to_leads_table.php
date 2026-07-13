<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Phase 9 (Slice 1): the single merged PDF built from a lead's uploaded
     * documents. Stored on the private disk (path relative to that disk);
     * `merged_at` records when it was last (re)generated.
     */
    public function up(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->string('merged_path')->nullable()->after('submitted_at');
            $table->timestamp('merged_at')->nullable()->after('merged_path');
        });
    }

    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropColumn(['merged_path', 'merged_at']);
        });
    }
};
