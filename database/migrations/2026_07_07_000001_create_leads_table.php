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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();

            // Applicant details
            $table->string('nama');
            $table->string('no_telefon', 20);
            $table->string('emel')->nullable();
            $table->string('daerah', 100);
            $table->string('poskod', 5);

            // Employment
            $table->enum('sektor', ['kerajaan', 'glc', 'berkanun', 'swasta']);
            $table->string('nama_majikan');
            $table->string('jawatan');
            $table->decimal('gaji_asas', 10, 2);
            $table->enum('status_pekerjaan', ['tetap', 'kontrak']);

            // Pipeline
            $table->enum('pipeline_status', [
                'new_lead',
                'dokumen_belum_lengkap',
                'dokumen_lengkap',
                'dalam_semakan',
                'layak',
                'tidak_layak',
                'submit_bank',
                'follow_up',
            ])->default('new_lead');

            // Consent (PDPA)
            $table->boolean('consent_pdpa')->default(false);
            $table->boolean('consent_contact')->default(false);
            $table->boolean('consent_marketing')->default(false);

            // Assignment
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamp('submitted_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
