<?php

use App\Models\Dokumen;
use App\Models\Lead;
use App\Models\User;
use App\Services\DocumentMergeService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

/** Skip the whole file if Ghostscript isn't installed (CI without gs). */
beforeEach(function () {
    if (! app(DocumentMergeService::class)->ghostscriptAvailable()) {
        $this->markTestSkipped('Ghostscript (gs) not available.');
    }
    Storage::fake('local');
    $this->actingAs(User::factory()->create());
});

/** Write a real one-page PDF onto the fake local disk and record a dokumen row. */
function fakePdfDoc(Lead $lead, string $jenis, ?int $bulan = null): Dokumen
{
    $relative = "dokumen/{$lead->id}/".uniqid().'.pdf';
    Storage::disk('local')->makeDirectory("dokumen/{$lead->id}");

    $pdf = new FPDF;
    $pdf->AddPage();
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(40, 10, ucfirst($jenis).' '.($bulan ?? ''));
    $pdf->Output('F', Storage::disk('local')->path($relative));

    return Dokumen::create([
        'lead_id' => $lead->id, 'jenis' => $jenis, 'bulan' => $bulan,
        'path' => $relative, 'nama_fail' => basename($relative), 'saiz' => 100,
        'created_at' => now(),
    ]);
}

/** Write a real PNG onto the fake local disk and record a dokumen row. */
function fakeImageDoc(Lead $lead, string $jenis): Dokumen
{
    $relative = "dokumen/{$lead->id}/".uniqid().'.png';
    Storage::disk('local')->makeDirectory("dokumen/{$lead->id}");

    $img = imagecreatetruecolor(200, 300);
    imagefill($img, 0, 0, imagecolorallocate($img, 220, 220, 220));
    imagepng($img, Storage::disk('local')->path($relative));
    imagedestroy($img);

    return Dokumen::create([
        'lead_id' => $lead->id, 'jenis' => $jenis, 'bulan' => null,
        'path' => $relative, 'nama_fail' => basename($relative), 'saiz' => 100,
        'created_at' => now(),
    ]);
}

it('merges a leads pdf and image documents into one valid pdf', function () {
    $lead = Lead::factory()->create();
    fakePdfDoc($lead, 'slip_gaji', 1);
    fakePdfDoc($lead, 'laporan_ctos');
    fakeImageDoc($lead, 'penyata_epf'); // image → gets wrapped to PDF

    $path = app(DocumentMergeService::class)->merge($lead->load('dokumen'));

    expect($path)->toBe("merged/{$lead->id}.pdf");
    Storage::disk('local')->assertExists($path);
    expect(Storage::disk('local')->get($path))->toStartWith('%PDF');
});

it('returns null when the lead has no documents', function () {
    $lead = Lead::factory()->create();

    expect(app(DocumentMergeService::class)->merge($lead->load('dokumen')))->toBeNull();
});

it('serves the merged pdf inline from the admin route, generating on demand', function () {
    $lead = Lead::factory()->create(); // no merged_path yet
    fakePdfDoc($lead, 'slip_gaji', 1);
    fakePdfDoc($lead, 'laporan_ctos');

    $response = $this->get("/admin/permohonan/{$lead->id}/pdf");

    $response->assertOk();
    expect($response->headers->get('content-type'))->toContain('application/pdf');
    expect($response->headers->get('content-disposition'))->toContain('inline');

    // The generated file is cached back onto the lead.
    expect($lead->fresh()->merged_path)->toBe("merged/{$lead->id}.pdf");
});

it('404s the pdf route for a lead with no documents', function () {
    $lead = Lead::factory()->create();

    $this->get("/admin/permohonan/{$lead->id}/pdf")->assertNotFound();
});
