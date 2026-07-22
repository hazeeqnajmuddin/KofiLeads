<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Phase 9 fix — the merged-PDF link shared via WhatsApp now uses an
     * unguessable token in the URL *path* (…/dokumen/gabungan/{token}) instead
     * of Laravel's query-string signed URL. A query string (…?expires=…&signature=…)
     * breaks inside WhatsApp's text= parameter: WhatsApp decodes the text once
     * during its wa.me→app redirect and then splits on the "&", tearing the
     * signature off and mangling the message. A path token has no "&".
     */
    public function up(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->string('merged_token', 64)->nullable()->unique()->after('merged_at');
        });
    }

    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropColumn('merged_token');
        });
    }
};
