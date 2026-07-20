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
    private const SEKTOR_LABELS = [
        'kerajaan' => 'Kerajaan',
        'glc' => 'GLC',
        'berkanun' => 'Badan Berkanun',
        'swasta' => 'Swasta',
    ];

    /**
     * Laporan page.
     *
     * Sektor + status combine with OR logic. Date filter behaviour:
     *   - With a status selected: filters by the status-specific date column
     *     (e.g. dalam_semakan_at for "dalam_semakan"), so filtering Feb +
     *     Dalam Semakan shows every lead that ENTERED Dalam Semakan in Feb,
     *     even if they have since moved to a different status.
     *   - Without a status selected: filters by leads.created_at (submission
     *     date), answering "how many leads came in during this period".
     *   - new_lead always uses created_at (no dedicated _at column).
     *
     * Trend Bulanan is always submission-date based and has its own year
     * selector, independent of the date filter.
     */
    public function index(Request $request): View
    {
        $currentYear = now()->year;

        $filters = [
            'sektor' => (string) $request->query('sektor', 'all'),
            'status' => (string) $request->query('status', 'all'),
            'date_mode' => (string) $request->query('date_mode', 'all'),
            'date_from' => (string) $request->query('date_from', ''),
            'date_to' => (string) $request->query('date_to', ''),
            'tahun' => (int) $request->query('tahun', $currentYear),
        ];

        $sektorActive = in_array($filters['sektor'], Lead::SEKTOR, true);
        $statusActive = in_array($filters['status'], Lead::PIPELINE_STATUSES, true);
        $dateRange = $this->resolveDateRange($filters);

        // Main query: OR filters on sektor + status (current pipeline_status).
        $main = Lead::query();
        if ($sektorActive || $statusActive) {
            $main->where(function (Builder $outer) use ($sektorActive, $statusActive, $filters) {
                if ($sektorActive) {
                    $outer->orWhere('sektor', $filters['sektor']);
                }
                if ($statusActive) {
                    $outer->orWhere('pipeline_status', $filters['status']);
                }
            });
        }

        // Date scope (AND on top of OR filters).
        if ($dateRange) {
            $dateCol = ($statusActive && $filters['status'] !== 'new_lead')
                ? $filters['status'].'_at'
                : 'created_at';
            $main->whereBetween($dateCol, $dateRange);
        }

        // Trend query: same OR filters but NO date scope — uses created_at + tahun.
        $trend = Lead::query();
        if ($sektorActive || $statusActive) {
            $trend->where(function (Builder $outer) use ($sektorActive, $statusActive, $filters) {
                if ($sektorActive) {
                    $outer->orWhere('sektor', $filters['sektor']);
                }
                if ($statusActive) {
                    $outer->orWhere('pipeline_status', $filters['status']);
                }
            });
        }

        // Available years for the Trend Bulanan year selector.
        $availableYears = Lead::query()
            ->pluck('created_at')
            ->map(fn ($d) => (int) Carbon::parse($d)->year)
            ->unique()
            ->sortDesc()
            ->values()
            ->all();
        if (empty($availableYears)) {
            $availableYears = [$currentYear];
        }
        if (! in_array($filters['tahun'], $availableYears, true)) {
            $filters['tahun'] = $availableYears[0];
        }

        $report = $this->buildReport($main, $trend, $filters, $sektorActive, $statusActive);

        return view('admin.laporan', compact('report', 'filters', 'availableYears'));
    }

    private function resolveDateRange(array $filters): ?array
    {
        return match ($filters['date_mode']) {
            'today' => [now()->startOfDay(), now()->endOfDay()],
            'minggu' => [now()->startOfWeek(), now()->endOfWeek()],
            'bulan' => [now()->startOfMonth(), now()->endOfMonth()],
            'custom' => ($filters['date_from'] && $filters['date_to'])
                ? [Carbon::parse($filters['date_from'])->startOfDay(), Carbon::parse($filters['date_to'])->endOfDay()]
                : null,
            default => null,
        };
    }

    private function buildReport(Builder $main, Builder $trend, array $filters, bool $sektorActive, bool $statusActive): array
    {
        $sectorCounts = (clone $main)->selectRaw('sektor, COUNT(*) as c')->groupBy('sektor')->pluck('c', 'sektor');
        $pipelineCounts = (clone $main)->selectRaw('pipeline_status, COUNT(*) as c')->groupBy('pipeline_status')->pluck('c', 'pipeline_status');

        $sectors = [];
        foreach (Lead::SEKTOR as $key) {
            $sectors[$key] = (int) ($sectorCounts[$key] ?? 0);
        }

        $pipeline = [];
        foreach (Lead::PIPELINE_STATUSES as $key) {
            $pipeline[$key] = (int) ($pipelineCounts[$key] ?? 0);
        }

        $monthly = array_fill(0, 12, 0);
        (clone $trend)
            ->whereYear('created_at', $filters['tahun'])
            ->pluck('created_at')
            ->each(function (Carbon $date) use (&$monthly) {
                $monthly[$date->month - 1]++;
            });

        $total = (int) (clone $main)->count();
        $processed = $pipeline['layak'] + $pipeline['tidak_layak'];
        $rate = $processed ? (int) round($pipeline['layak'] / $processed * 100) : 0;

        return [
            'label' => $this->rangeLabel($filters, $sektorActive, $statusActive),
            'total' => $total,
            'rate' => $rate,
            'sectors' => $sectors,
            'pipeline' => $pipeline,
            'monthly' => $monthly,
        ];
    }

    private function rangeLabel(array $filters, bool $sektorActive, bool $statusActive): string
    {
        $orParts = [];
        if ($sektorActive) {
            $orParts[] = self::SEKTOR_LABELS[$filters['sektor']];
        }
        if ($statusActive) {
            $orParts[] = ucwords(str_replace('_', ' ', $filters['status']));
        }

        $dateLabel = match ($filters['date_mode']) {
            'today' => 'Hari Ini',
            'minggu' => 'Minggu Ini',
            'bulan' => 'Bulan Ini',
            'custom' => $filters['date_from'] && $filters['date_to']
                ? $filters['date_from'].' – '.$filters['date_to']
                : '',
            default => '',
        };

        $base = $orParts === [] ? '' : implode(' ATAU ', $orParts);

        if ($dateLabel) {
            return $base ? "$base · $dateLabel" : $dateLabel;
        }

        return $base ?: 'Semua masa';
    }
}
