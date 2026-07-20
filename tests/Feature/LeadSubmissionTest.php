<?php

use App\Models\Dokumen;
use App\Models\Lead;
use App\Models\LeadMasalah;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

function validLeadPayload(array $overrides = []): array
{
    return array_merge([
        'nama' => 'Ujian Pemohon',
        'no_telefon' => '+60 12-345 6789',
        'emel' => 'ujian@email.com',
        'daerah' => 'Petaling Jaya',
        'poskod' => '47810',
        'sektor' => 'swasta',
        'nama_majikan' => 'Syarikat Ujian Sdn Bhd',
        'jawatan' => 'Pengurus',
        'gaji_asas' => 4500,
        'status_pekerjaan' => 'tetap',
        'masalah' => ['komitmen_tinggi', 'ccris'],
        'slip_gaji' => [
            UploadedFile::fake()->create('slip1.pdf', 100, 'application/pdf'),
            UploadedFile::fake()->create('slip2.pdf', 100, 'application/pdf'),
            UploadedFile::fake()->create('slip3.pdf', 100, 'application/pdf'),
        ],
        'ctos_report' => UploadedFile::fake()->create('ctos.pdf', 200, 'application/pdf'),
        'penyata_epf' => UploadedFile::fake()->create('epf.pdf', 300, 'application/pdf'),
        'consent_pdpa' => '1',
        'consent_contact' => '1',
        'consent_marketing' => '1',
    ], $overrides);
}

it('stores a lead with issues and documents, then redirects to the thank-you page', function () {
    Storage::fake('local');

    $response = $this->post('/leads', validLeadPayload());

    $response->assertRedirect(route('leads.thankyou'));
    $response->assertSessionHas('lead_submitted', true);

    // Lead row
    expect(Lead::count())->toBe(1);
    $lead = Lead::first();
    expect($lead->nama)->toBe('Ujian Pemohon')
        ->and($lead->no_telefon)->toBe('+60123456789') // normalized by StoreLeadRequest (+60 prefix, digits only)
        ->and($lead->emel)->toBe('ujian@email.com')
        ->and($lead->sektor)->toBe('swasta')
        ->and($lead->pipeline_status)->toBe('new_lead')
        ->and($lead->consent_pdpa)->toBeTrue()
        ->and($lead->consent_contact)->toBeTrue()
        ->and($lead->consent_marketing)->toBeTrue()
        ->and($lead->submitted_at)->not->toBeNull();

    // Issues
    expect(LeadMasalah::where('lead_id', $lead->id)->pluck('masalah')->all())
        ->toEqualCanonicalizing(['komitmen_tinggi', 'ccris']);

    // Documents: 3 slip gaji (bulan 1-3) + 1 ctos + 1 epf = 5
    expect(Dokumen::where('lead_id', $lead->id)->count())->toBe(5);
    expect(Dokumen::where('lead_id', $lead->id)->where('jenis', 'slip_gaji')->pluck('bulan')->sort()->values()->all())
        ->toBe([1, 2, 3]);

    // Files actually written to the private disk
    Dokumen::where('lead_id', $lead->id)->each(function ($doc) {
        Storage::disk('local')->assertExists($doc->path);
        expect($doc->path)->toStartWith("dokumen/{$doc->lead_id}/");
    });
});

it('does not require EPF for non-swasta sectors', function () {
    Storage::fake('local');

    $payload = validLeadPayload(['sektor' => 'kerajaan']);
    unset($payload['penyata_epf']);

    $this->post('/leads', $payload)->assertRedirect(route('leads.thankyou'));

    expect(Lead::count())->toBe(1);
    expect(Dokumen::where('jenis', 'penyata_epf')->count())->toBe(0);
});

it('rejects a submission without the mandatory PDPA consents', function () {
    Storage::fake('local');

    $payload = validLeadPayload(['consent_pdpa' => '0', 'consent_contact' => '0']);

    $response = $this->post('/leads', $payload);

    $response->assertSessionHasErrors(['consent_pdpa', 'consent_contact']);
    expect(Lead::count())->toBe(0);
});

it('stores the free-text detail on the lain_lain issue row', function () {
    Storage::fake('local');

    $payload = validLeadPayload([
        'masalah' => ['ccris', 'lain_lain'],
        'masalah_lain' => 'Sedang dalam proses penjadualan semula',
    ]);

    $this->post('/leads', $payload)->assertRedirect(route('leads.thankyou'));

    $lain = LeadMasalah::where('masalah', 'lain_lain')->first();
    expect($lain->keterangan)->toBe('Sedang dalam proses penjadualan semula');
    // Non-lain_lain rows carry no keterangan.
    expect(LeadMasalah::where('masalah', 'ccris')->first()->keterangan)->toBeNull();
});

it('requires the free-text detail when lain_lain is ticked', function () {
    Storage::fake('local');

    $payload = validLeadPayload(['masalah' => ['lain_lain']]);
    unset($payload['masalah_lain']);

    $this->post('/leads', $payload)->assertSessionHasErrors('masalah_lain');
    expect(Lead::count())->toBe(0);
});

it('requires exactly three slip gaji files', function () {
    Storage::fake('local');

    $payload = validLeadPayload([
        'slip_gaji' => [UploadedFile::fake()->create('slip1.pdf', 100, 'application/pdf')],
    ]);

    $this->post('/leads', $payload)->assertSessionHasErrors('slip_gaji');
    expect(Lead::count())->toBe(0);
});
