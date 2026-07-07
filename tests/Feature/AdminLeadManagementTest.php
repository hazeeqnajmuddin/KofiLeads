<?php

use App\Models\Dokumen;
use App\Models\Lead;
use App\Models\PipelineLog;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Seeded admin the no-auth phase attributes pipeline changes to.
    User::factory()->create(['name' => 'Admin Satu']);
});

it('lists real leads on the permohonan page', function () {
    $lead = Lead::factory()->create(['nama' => 'Pemohon Nyata', 'pipeline_status' => 'new_lead']);

    $this->get('/admin/permohonan')
        ->assertOk()
        ->assertSee('Pemohon Nyata')
        ->assertSee('1 rekod');
});

it('filters leads by sektor and status', function () {
    Lead::factory()->create(['nama' => 'Kakitangan Kerajaan', 'sektor' => 'kerajaan', 'pipeline_status' => 'approved']);
    Lead::factory()->create(['nama' => 'Pekerja Swasta', 'sektor' => 'swasta', 'pipeline_status' => 'new_lead']);

    $this->get('/admin/permohonan?sektor=kerajaan')
        ->assertSee('Kakitangan Kerajaan')
        ->assertDontSee('Pekerja Swasta');

    $this->get('/admin/permohonan?status=new_lead')
        ->assertSee('Pekerja Swasta')
        ->assertDontSee('Kakitangan Kerajaan');
});

it('updates pipeline status and writes an audit log row', function () {
    $lead = Lead::factory()->create(['pipeline_status' => 'new_lead']);

    $response = $this->patch("/admin/permohonan/{$lead->id}", [
        'pipeline_status' => 'dalam_semakan',
    ]);

    $response->assertRedirect();
    $response->assertSessionHas('success');

    expect($lead->fresh()->pipeline_status)->toBe('dalam_semakan');

    $log = PipelineLog::where('lead_id', $lead->id)->latest('id')->first();
    expect($log)->not->toBeNull()
        ->and($log->status_lama)->toBe('new_lead')
        ->and($log->status_baru)->toBe('dalam_semakan')
        ->and($log->changed_by)->toBe(User::first()->id);
});

it('does not log when the status is unchanged', function () {
    $lead = Lead::factory()->create(['pipeline_status' => 'layak']);

    $this->patch("/admin/permohonan/{$lead->id}", ['pipeline_status' => 'layak'])
        ->assertSessionHas('error');

    expect(PipelineLog::where('lead_id', $lead->id)->count())->toBe(0);
});

it('rejects an invalid pipeline status', function () {
    $lead = Lead::factory()->create(['pipeline_status' => 'new_lead']);

    $this->patch("/admin/permohonan/{$lead->id}", ['pipeline_status' => 'bukan_status'])
        ->assertSessionHasErrors('pipeline_status');

    expect($lead->fresh()->pipeline_status)->toBe('new_lead');
});

it('soft-deletes a lead', function () {
    $lead = Lead::factory()->create();

    $this->delete("/admin/permohonan/{$lead->id}")
        ->assertRedirect()
        ->assertSessionHas('success');

    expect(Lead::count())->toBe(0);
    expect(Lead::withTrashed()->count())->toBe(1);
    expect($lead->fresh()->trashed())->toBeTrue();
});

it('streams a document download from the private disk', function () {
    Storage::fake('local');

    $lead = Lead::factory()->create();
    $path = UploadedFile::fake()->create('slip.pdf', 100, 'application/pdf')->store("dokumen/{$lead->id}", 'local');
    $doc = Dokumen::create([
        'lead_id' => $lead->id,
        'jenis' => 'slip_gaji',
        'bulan' => 1,
        'path' => $path,
        'nama_fail' => 'slip-asal.pdf',
        'saiz' => 1000,
        'created_at' => now(),
    ]);

    $response = $this->get("/admin/dokumen/{$doc->id}/download");

    $response->assertOk();
    $response->assertHeader('content-disposition', 'attachment; filename=slip-asal.pdf');
});

it('returns 404 when the document file is missing on disk', function () {
    Storage::fake('local');

    $lead = Lead::factory()->create();
    $doc = Dokumen::create([
        'lead_id' => $lead->id,
        'jenis' => 'laporan_ctos',
        'bulan' => null,
        'path' => 'dokumen/999/ghost.pdf',
        'nama_fail' => 'ghost.pdf',
        'saiz' => 1,
        'created_at' => now(),
    ]);

    $this->get("/admin/dokumen/{$doc->id}/download")->assertNotFound();
});
