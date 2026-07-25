<?php

use App\Models\Lead;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->actingAs(User::factory()->create());
});

it('computes dashboard stats from real leads', function () {
    Lead::factory()->count(3)->create(['pipeline_status' => 'new_lead', 'submitted_at' => now()]);
    Lead::factory()->count(2)->create(['pipeline_status' => 'layak', 'submitted_at' => now()]);
    Lead::factory()->create(['pipeline_status' => 'tidak_layak', 'submitted_at' => now()]);

    $view = $this->get('/admin/dashboard')->assertOk()->viewData('stats');

    expect($view['jumlah'])->toBe(6)
        ->and($view['layak'])->toBe(2)
        ->and($view['tidak_layak'])->toBe(1)
        ->and($view['pending'])->toBe(3);
});

it('lists the most recent leads on the dashboard with the real pipeline status', function () {
    Lead::factory()->create(['nama' => 'Paling Lama', 'submitted_at' => now()->subDays(10), 'pipeline_status' => 'follow_up']);
    Lead::factory()->create(['nama' => 'Paling Baru', 'submitted_at' => now(), 'pipeline_status' => 'tidak_layak']);

    $recent = $this->get('/admin/dashboard')->assertOk()->viewData('recent');

    expect($recent[0]['nama'])->toBe('Paling Baru')
        ->and($recent[0]['status'])->toBe('tidak_layak')
        ->and($recent[1]['status'])->toBe('follow_up');
});

it('counts leads by period in the summary', function () {
    Lead::factory()->create(['submitted_at' => now(), 'pipeline_status' => 'layak']);
    Lead::factory()->create(['submitted_at' => now()->subMonths(3), 'pipeline_status' => 'dokumen_lengkap']);

    $summary = $this->get('/admin/dashboard')->assertOk()->viewData('summary');

    expect($summary['lead_hari_ini'])->toBe(1)
        ->and($summary['lead_bulan_ini'])->toBe(1)   // only today's lead is in this month
        ->and($summary['layak'])->toBe(1)
        ->and($summary['dokumen_lengkap'])->toBe(1);
});

it('builds the report from all leads with the 4 canonical sectors when unfiltered', function () {
    Lead::factory()->count(2)->create(['sektor' => 'kerajaan', 'submitted_at' => now()]);
    Lead::factory()->create(['sektor' => 'swasta', 'submitted_at' => now()]);
    Lead::factory()->create(['sektor' => 'glc', 'submitted_at' => now()]);

    $report = $this->get('/admin/laporan')->assertOk()->viewData('report');

    expect(array_keys($report['sectors']))->toBe(['kerajaan', 'glc', 'berkanun', 'swasta'])
        ->and($report['total'])->toBe(4)
        ->and($report['sectors']['kerajaan'])->toBe(2)
        ->and($report['sectors']['swasta'])->toBe(1)
        ->and($report['sectors']['berkanun'])->toBe(0)
        ->and($report['pipeline'])->toHaveKey('new_lead')
        ->and($report['monthly'])->toHaveCount(12)
        ->and($report['label'])->toBe('Semua masa');
});

it('combines the sektor and status filters with OR logic, not AND', function () {
    $b = Lead::factory()->create(['sektor' => 'kerajaan', 'pipeline_status' => 'new_lead']); // matches sektor
    $c = Lead::factory()->create(['sektor' => 'swasta', 'pipeline_status' => 'layak']);   // matches status
    $d = Lead::factory()->create(['sektor' => 'swasta', 'pipeline_status' => 'new_lead']);   // matches none

    $report = $this->get('/admin/laporan?sektor=kerajaan&status=layak')
        ->assertOk()->viewData('report');

    // OR union of B, C (not the empty AND intersection, and not D)
    expect($report['total'])->toBe(2)
        ->and($report['sectors']['kerajaan'])->toBe(1) // B
        ->and($report['sectors']['swasta'])->toBe(1)   // C
        ->and($report['pipeline']['layak'])->toBe(1) // C
        ->and($report['pipeline']['new_lead'])->toBe(1) // B
        ->and($report['label'])->toBe('Kerajaan ATAU Layak');
});

it('applies a single active filter on its own', function () {
    Lead::factory()->create(['sektor' => 'kerajaan', 'submitted_at' => now()->subYears(1)]);
    Lead::factory()->count(2)->create(['sektor' => 'swasta', 'submitted_at' => now()->subYears(1)]);

    $report = $this->get('/admin/laporan?sektor=kerajaan')->assertOk()->viewData('report');

    expect($report['total'])->toBe(1)
        ->and($report['sectors']['kerajaan'])->toBe(1)
        ->and($report['sectors']['swasta'])->toBe(0);
});
