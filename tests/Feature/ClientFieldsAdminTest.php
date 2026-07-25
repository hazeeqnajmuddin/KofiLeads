<?php

use App\Models\Lead;
use App\Models\LeadPlatform;
use App\Models\ReferenceCode;
use App\Models\Setting;
use App\Models\User;
use App\Services\WhatsappMessageBuilder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

// Admin routes are auth-gated (Phase 3), so act as a logged-in user.
beforeEach(fn () => $this->actingAs(User::factory()->create()));

/** Attach platform rows to a lead. */
function attachPlatforms(Lead $lead, array $platforms): void
{
    foreach ($platforms as $p) {
        LeadPlatform::create(['lead_id' => $lead->id, 'platform' => $p, 'created_at' => now()]);
    }
}

it('allows multiple active reference codes and toggles them independently', function () {
    $this->post(route('admin.kod-rujukan.store'), ['host_name' => 'Live A', 'code' => 'RCMS01'])
        ->assertRedirect()->assertSessionHas('success');
    $this->post(route('admin.kod-rujukan.store'), ['host_name' => 'Live B', 'code' => 'RCMS02'])
        ->assertRedirect();

    // Both stay active — more than one may be active at once.
    expect(ReferenceCode::where('is_active', true)->count())->toBe(2);

    // Toggle the first off, then back on.
    $a = ReferenceCode::where('code', 'RCMS01')->first();
    $this->patch(route('admin.kod-rujukan.activate', $a))->assertRedirect();
    expect($a->fresh()->is_active)->toBeFalse()
        ->and(ReferenceCode::where('is_active', true)->count())->toBe(1);

    $this->patch(route('admin.kod-rujukan.activate', $a))->assertRedirect();
    expect($a->fresh()->is_active)->toBeTrue()
        ->and(ReferenceCode::where('is_active', true)->count())->toBe(2);
});

it('auto-generates sequential RCMS codes when left blank', function () {
    $this->post(route('admin.kod-rujukan.store'), ['host_name' => 'Live 1'])->assertRedirect();
    expect(ReferenceCode::latest('id')->first()->code)->toBe('RCMS01');

    $this->post(route('admin.kod-rujukan.store'), ['host_name' => 'Live 2'])->assertRedirect();
    expect(ReferenceCode::latest('id')->first()->code)->toBe('RCMS02');
});

it('saves the editable social-platform options and derives values', function () {
    $this->post(route('admin.landing.update'), ['social_platforms' => 'Facebook, YouTube'])
        ->assertRedirect()->assertSessionHas('success');

    expect(Setting::get('social_platforms'))->toBe('Facebook, YouTube')
        ->and(LeadPlatform::allowedValues())->toEqualCanonicalizing(['facebook', 'youtube', 'lain_lain']);
});

it('filters permohonan by bank/koperasi, reference code and submission date', function () {
    Lead::factory()->create(['apply_pinjaman_3bulan' => true, 'kod_rujukan' => 'LIVEX', 'submitted_at' => now()]);
    Lead::factory()->count(2)->create(['apply_pinjaman_3bulan' => false, 'submitted_at' => now()]);
    Lead::factory()->create(['kod_rujukan' => 'LIVEX', 'submitted_at' => now()->subMonths(2)]);

    expect($this->get('/admin/permohonan?pinjaman=1')->viewData('leads')->total())->toBe(1)
        ->and($this->get('/admin/permohonan?pinjaman=0')->viewData('leads')->total())->toBe(2)
        ->and($this->get('/admin/permohonan?kod_rujukan=LIVEX')->viewData('leads')->total())->toBe(2)
        // Kod + "bulan ini" → only the recent LIVEX lead.
        ->and($this->get('/admin/permohonan?kod_rujukan=LIVEX&date_mode=bulan')->viewData('leads')->total())->toBe(1);
});

it('builds the laporan reference-code and platform performance panels for the period', function () {
    ReferenceCode::create(['host_name' => 'Live X', 'code' => 'LIVEX', 'is_active' => true]);

    $a = Lead::factory()->create(['kod_rujukan' => 'LIVEX', 'created_at' => now()]);
    attachPlatforms($a, ['facebook', 'instagram']);
    $b = Lead::factory()->create(['kod_rujukan' => 'LIVEX', 'created_at' => now()]);
    attachPlatforms($b, ['facebook']);
    $old = Lead::factory()->create(['kod_rujukan' => 'LIVEX', 'created_at' => now()->subMonths(2)]);
    attachPlatforms($old, ['facebook']);

    // No period → all 3 LIVEX leads.
    $ref = $this->get('/admin/laporan')->viewData('refPerformance');
    expect($ref->firstWhere('code', 'LIVEX')['count'])->toBe(3);

    // "Bulan ini" → only the 2 recent leads (by submission date).
    $refMonth = $this->get('/admin/laporan?date_mode=bulan')->viewData('refPerformance');
    expect($refMonth->firstWhere('code', 'LIVEX')['count'])->toBe(2);

    // Platform panel: facebook on all 3, instagram on 1 (distinct leads).
    $plat = $this->get('/admin/laporan')->viewData('platformPerformance');
    expect($plat->firstWhere('value', 'facebook')['count'])->toBe(3)
        ->and($plat->firstWhere('value', 'instagram')['count'])->toBe(1);
});

it('exposes platform and bank tokens in the whatsapp message', function () {
    $lead = Lead::factory()->create(['apply_pinjaman_3bulan' => true, 'bank_koperasi_nama' => 'Bank Rakyat']);
    attachPlatforms($lead, ['facebook', 'lain_lain']);
    $lead->platforms()->where('platform', 'lain_lain')->update(['keterangan' => 'YouTube']);

    $tokens = app(WhatsappMessageBuilder::class)->tokens($lead->load('platforms'), null);

    expect($tokens['platform_sosial'])->toContain('Facebook')->toContain('Lain-lain: YouTube')
        ->and($tokens['bank_koperasi'])->toBe('Ya (Bank Rakyat)');
});
