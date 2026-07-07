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
        Schema::create('dokumen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')->constrained('leads')->cascadeOnDelete();
            $table->enum('jenis', ['slip_gaji', 'laporan_ctos', 'penyata_epf']);
            $table->unsignedTinyInteger('bulan')->nullable(); // 1..3, only for slip_gaji
            $table->string('path', 500);
            $table->string('nama_fail');
            $table->unsignedInteger('saiz'); // bytes
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen');
    }
};
