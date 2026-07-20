<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pipeline_log', function (Blueprint $table) {
            $pipelineStatuses = [
                'new_lead',
                'dokumen_belum_lengkap',
                'dokumen_lengkap',
                'dalam_semakan',
                'layak',
                'tidak_layak',
                'submit_bank',
                'follow_up',
            ];

            $table->id();
            $table->foreignId('lead_id')->constrained('leads')->cascadeOnDelete();
            $table->enum('status_lama', $pipelineStatuses)->nullable();
            $table->enum('status_baru', $pipelineStatuses);
            $table->text('catatan')->nullable();
            $table->foreignId('changed_by')->constrained('users')->cascadeOnDelete();
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pipeline_log');
    }
};
