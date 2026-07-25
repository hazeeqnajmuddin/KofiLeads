<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->timestamp('consent_pdpa_at')->nullable()->after('consent_pdpa');
            $table->timestamp('consent_contact_at')->nullable()->after('consent_contact');
            $table->timestamp('consent_marketing_at')->nullable()->after('consent_marketing');
        });
    }

    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropColumn(['consent_pdpa_at', 'consent_contact_at', 'consent_marketing_at']);
        });
    }
};
