<?php

use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->actingAs(User::factory()->create());
});

it('shows the settings page with current values', function () {
    Setting::set('hero_title', 'Tajuk Ujian');

    $this->get('/admin/landing')
        ->assertOk()
        ->assertSee('Tajuk Ujian');
});

it('saves the hero content form', function () {
    $this->post('/admin/landing', [
        'hero_title' => 'Tajuk Baru',
        'hero_cta' => 'Klik Sini',
        'hero_subtitle' => 'Sub-tajuk baru.',
    ])->assertRedirect()->assertSessionHas('success');

    expect(Setting::get('hero_title'))->toBe('Tajuk Baru')
        ->and(Setting::get('hero_cta'))->toBe('Klik Sini')
        ->and(Setting::get('hero_subtitle'))->toBe('Sub-tajuk baru.');
});

it('saves the whatsapp form without touching other settings', function () {
    Setting::set('contact_email', 'kekal@email.com');

    $this->post('/admin/landing', ['whatsapp_number' => '+60 19-000 1122'])
        ->assertRedirect()->assertSessionHas('success');

    expect(Setting::get('whatsapp_number'))->toBe('+60 19-000 1122')
        // untouched because it was not in this form's payload
        ->and(Setting::get('contact_email'))->toBe('kekal@email.com');
});

it('saves the biodata, services and eligibility forms', function () {
    $this->post('/admin/landing', [
        'bio_nama' => 'Nama Baru',
        'bio_jawatan' => 'Ketua Pegawai',
        'stat_1_val' => '12+',
    ])->assertSessionHas('success');

    $this->post('/admin/landing', [
        'service_1_title' => 'Servis Baharu',
        'service_1_desc' => 'Penerangan servis baharu.',
    ])->assertSessionHas('success');

    $this->post('/admin/landing', ['min_gaji_kerajaan' => '2000'])->assertSessionHas('success');

    expect(Setting::get('bio_nama'))->toBe('Nama Baru')
        ->and(Setting::get('stat_1_val'))->toBe('12+')
        ->and(Setting::get('service_1_title'))->toBe('Servis Baharu')
        ->and(Setting::get('min_gaji_kerajaan'))->toBe('2000');
});

it('stores an uploaded profile image on the public disk', function () {
    Storage::fake('public');

    $this->post('/admin/landing', [
        'bio_image' => UploadedFile::fake()->image('profile.jpg'),
    ])->assertSessionHas('success');

    $path = Setting::get('bio_image');
    expect($path)->not->toBeNull()
        ->and($path)->toStartWith('settings/');
    Storage::disk('public')->assertExists($path);
});

it('rejects an oversized / wrong-type profile image', function () {
    Storage::fake('public');

    $this->post('/admin/landing', [
        'bio_image' => UploadedFile::fake()->create('doc.pdf', 100, 'application/pdf'),
    ])->assertSessionHasErrors('bio_image');

    expect(Setting::where('key', 'bio_image')->exists())->toBeFalse();
});

it('renders the eligibility salaries on the public landing from settings', function () {
    Setting::set('min_gaji_kerajaan', '1800');

    $this->get('/')->assertOk()->assertSee('RM1,800');
});

it('does not flash a false success when no editable field is submitted', function () {
    // A payload with no recognised setting key (and no file) must not report success.
    $response = $this->post('/admin/landing', [
        'unknown_field' => 'x',
    ]);

    $response->assertSessionMissing('success');
    $response->assertSessionHas('error');
    expect(Setting::count())->toBe(0);
});

it('validates the contact email and social urls', function () {
    $this->post('/admin/landing', [
        'contact_email' => 'bukan-email',
        'facebook_url' => 'not a url',
    ])->assertSessionHasErrors(['contact_email', 'facebook_url']);

    expect(Setting::where('key', 'contact_email')->exists())->toBeFalse();
});

it('renders the public landing hero and footer from settings', function () {
    Setting::set('hero_title', 'Hero Dari Tetapan');
    Setting::set('hero_cta', 'CTA Dari Tetapan');
    Setting::set('contact_email', 'footer@tetapan.com');
    Setting::set('facebook_url', 'https://facebook.com/ujianrcms');

    $html = $this->get('/')->assertOk()->getContent();

    expect($html)->toContain('Hero Dari Tetapan')
        ->and($html)->toContain('CTA Dari Tetapan')
        ->and($html)->toContain('footer@tetapan.com')
        ->and($html)->toContain('https://facebook.com/ujianrcms');
});
