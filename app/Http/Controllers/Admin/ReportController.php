<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class ReportController extends Controller
{
    private const TEMPOH_LABELS = [
        'year' => 'Tahun ini',
        'q' => '3 bulan lepas',
        'month' => 'Bulan ini',
    ];

    private const SEKTOR_LABELS = [
        'kerajaan' => 'Kerajaan',
        'glc' => 'GLC',
        'berkanun' => 'Badan Berkanun',
        'swasta' => 'Swasta',
    ];

    /**
     * Laporan page. The three filters (tempoh / sektor / status) combine with
     * OR logic: a lead is included if it matches ANY chosen filter. A filter
     * left on "Semua …" is inactive (not part of the OR); when none are chosen,
     * all leads are shown. Every panel recomputes off the filtered set.
     */
    public function index(Request $request): View
    {
        $filters = [
            'tempoh' => (string) $request->query('tempoh', 'all'),
            'sektor' => (string) $request->query('sektor', 'all'),
            'status' => (string) $request->query('status', 'all'),
        ];

        $tempohActive = array_key_exists($filters['tempoh'], self::TEMPOH_LABELS);
        $sektorActive = in_array($filters['sektor'], Lead::SEKTOR, true);
        $statusActive = in_array($filters['status'], Lead::PIPELINE_STATUSES, true);

        // Each active filter becomes one OR clause on the base query.
        $orClauses = [];
        if ($tempohActive) {
            $start = $this->tempohStart($filters['tempoh']);
            $orClauses[] = fn (Builder $q) => $q->where('submitted_at', '>=', $start);
        }
        if ($sektorActive) {
            $orClauses[] = fn (Builder $q) => $q->where('sektor', $filters['sektor']);
        }
        if ($statusActive) {
            $orClauses[] = fn (Builder $q) => $q->where('pipeline_status', $filters['status']);
        }

        $base = Lead::query();
        if ($orClauses !== []) {
            $base->where(function (Builder $outer) use ($orClauses) {
                foreach ($orClauses as $clause) {
                    $outer->orWhere($clause);
                }
            });
        }

        $report = $this->buildReport($base, $filters, $tempohActive, $sektorActive, $statusActive);

        return view('admin.laporan', compact('report', 'filters'));
    }

    /**
     * Aggregate the filtered query into the shape the laporan JS expects.
     */
    private function buildReport(Builder $base, array $filters, bool $tempohActive, bool $sektorActive, bool $statusActive): array
    {
        $sectorCounts = (clone $base)->selectRaw('sektor, COUNT(*) as c')->groupBy('sektor')->pluck('c', 'sektor');
        $pipelineCounts = (clone $base)->selectRaw('pipeline_status, COUNT(*) as c')->groupBy('pipeline_status')->pluck('c', 'pipeline_status');

        $sectors = [];
        foreach (Lead::SEKTOR as $key) {
            $sectors[$key] = (int) ($sectorCounts[$key] ?? 0);
        }

        $pipeline = [];
        foreach (Lead::PIPELINE_STATUSES as $key) {
            $pipeline[$key] = (int) ($pipelineCounts[$key] ?? 0);
        }

        $monthly = array_fill(0, 12, 0);
        (clone $base)
            ->whereYear('submitted_at', now()->year)
            ->pluck('submitted_at')
            ->each(function (Carbon $date) use (&$monthly) {
                $monthly[$date->month - 1]++;
            });

        $total = (int) (clone $base)->count();
        $processed = $pipeline['approved'] + $pipeline['rejected'];
        $rate = $processed ? (int) round($pipeline['approved'] / $processed * 100) : 0;

        return [
            'label' => $this->rangeLabel($filters, $tempohActive, $sektorActive, $statusActive),
            'total' => $total,
            'rate' => $rate,
            'sectors' => $sectors,
            'pipeline' => $pipeline,
            'monthly' => $monthly,
        ];
    }

    private function tempohStart(string $tempoh): Carbon
    {
        return match ($tempoh) {
            'year' => now()->startOfYear(),
            'q' => now()->subMonthsNoOverflow(2)->startOfMonth(),
            'month' => now()->startOfMonth(),
        };
    }

    /**
     * Human summary of the active filters (joined with "ATAU" since they OR).
     */
    private function rangeLabel(array $filters, bool $tempohActive, bool $sektorActive, bool $statusActive): string
    {
        $parts = [];
        if ($tempohActive) {
            $parts[] = self::TEMPOH_LABELS[$filters['tempoh']];
        }
        if ($sektorActive) {
            $parts[] = self::SEKTOR_LABELS[$filters['sektor']];
        }
        if ($statusActive) {
            $parts[] = ucwords(str_replace('_', ' ', $filters['status']));
        }

        return $parts === [] ? 'Semua masa' : implode(' ATAU ', $parts);
    }
}
