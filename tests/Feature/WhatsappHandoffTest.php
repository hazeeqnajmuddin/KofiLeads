<?php

use App\Models\Lead;
use App\Models\LeadMasalah;
use App\Models\Setting;
use App\Services\WhatsappMessageBuilder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

uses(RefreshDatabase::class);

it('renders the template, substituting known tokens and leaving unknown ones', function () {
    $lead = Lead::factory()->create(['nama' => 'Ali bin Ahmad', 'sektor' => 'swasta']);
    LeadMasalah::create(['lead_id' => $lead->id, 'masalah' => 'ccris', 'created_at' => now()]);

    $builder = app(WhatsappMessageBuilder::class);
    $tokens = $builder->tokens($lead->load('masalah'), 'https://example.test/link');

    $out = $builder->render('Nama: {nama} | Sektor: {sektor} | Masalah: {masalah} | Link: {link} | Unknown: {foo}', $tokens);

    expect($out)->toContain('Nama: Ali bin Ahmad')
        ->toContain('Sektor: Swasta')          // label, not raw enum
        ->toContain('Masalah: CCRIS')
        ->toContain('Link: https://example.test/link')
        ->toContain('Unknown: {foo}');         // unknown token untouched
});

it('includes the lain_lain keterangan in the masalah token', function () {
    $lead = Lead::factory()->create();
    LeadMasalah::create(['lead_id' => $lead->id, 'masalah' => 'lain_lain', 'keterangan' => 'Kes khas', 'created_at' => now()]);

    $tokens = app(WhatsappMessageBuilder::class)->tokens($lead->load('masalah'), null);

    expect($tokens['masalah'])->toBe('Lain-lain: Kes khas');
});

it('builds a wa.me url with the configured number, or null when none is set', function () {
    $lead = Lead::factory()->create();

    // No number configured yet.
    expect(app(WhatsappMessageBuilder::class)->url($lead->load('masalah'), null))->toBeNull();

    Setting::set('whatsapp_number', '+60 12-345 6789');

    $url = app(WhatsappMessageBuilder::class)->url($lead->load('masalah'), 'https://example.test/doc');

    expect($url)->toStartWith('https://wa.me/60123456789?text=');
});

it('serves the merged pdf through a valid signed link and rejects a tampered one', function () {
    // Ghostscript-independent: seed a merged file directly.
    Storage::fake('local');
    $lead = Lead::factory()->create();
    Storage::disk('local')->put("merged/{$lead->id}.pdf", '%PDF-1.4 fake');
    $lead->update(['merged_path' => "merged/{$lead->id}.pdf", 'merged_at' => now()]);

    $signed = URL::temporarySignedRoute('merged.signed', now()->addDays(3), ['lead' => $lead->id]);

    $this->get($signed)->assertOk()->assertHeader('content-type', 'application/pdf');

    // Tampering with the query invalidates the signature → friendly expired page (403).
    $this->get($signed.'&x=1')->assertForbidden()->assertSee('Tamat Tempoh', false);
});

it('shows the thank-you page only after a submission', function () {
    // Direct visit without the flash marker → redirected home.
    $this->get(route('leads.thankyou'))->assertRedirect('/');

    // With the marker set (as the controller does on submit) → renders.
    $this->withSession(['lead_submitted' => true, 'wa_url' => 'https://wa.me/60123456789?text=hi'])
        ->get(route('leads.thankyou'))
        ->assertOk()
        ->assertSee('Teruskan ke WhatsApp');
});

it('saves the whatsapp template from the settings form', function () {
    $this->post(route('admin.landing.update'), ['whatsapp_template' => 'Hai {nama}, ini mesej baharu.'])
        ->assertRedirect()
        ->assertSessionHas('success');

    expect(Setting::get('whatsapp_template'))->toBe('Hai {nama}, ini mesej baharu.');
});
