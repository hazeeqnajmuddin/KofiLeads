<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateLeadStatusRequest;
use App\Models\Lead;
use App\Models\PipelineLog;
use App\Models\ReferenceCode;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class LeadController extends Controller
{
    /**
     * Paginated, filterable list of real leads (replaces the old hardcoded array).
     */
    public function index(Request $request): View
    {
        $filters = [
            'q' => trim((string) $request->query('q', '')),
            'status' => (string) $request->query('status', ''),
            'sektor' => (string) $request->query('sektor', ''),
            'pinjaman' => (string) $request->query('pinjaman', ''),
            'kod_rujukan' => (string) $request->query('kod_rujukan', ''),
            'date_mode' => (string) $request->query('date_mode', ''),
            'date_from' => (string) $request->query('date_from', ''),
            'date_to' => (string) $request->query('date_to', ''),
        ];

        $dateRange = $this->resolveDateRange($filters);

        $leads = Lead::query()
            ->with(['masalah', 'platforms', 'dokumen'])
            // Single search box: match against name OR normalized phone number.
            ->when($filters['q'] !== '', function ($query) use ($filters) {
                $term = $filters['q'];
                $digits = preg_replace('/\D/', '', $term);
                $query->where(function ($sub) use ($term, $digits) {
                    $sub->where('nama', 'like', "%{$term}%");
                    if ($digits !== '') {
                        $sub->orWhereRaw("REPLACE(REPLACE(REPLACE(no_telefon, ' ', ''), '-', ''), '+', '') LIKE ?", ["%{$digits}%"]);
                    }
                });
            })
            ->when(in_array($filters['status'], Lead::PIPELINE_STATUSES, true), fn ($q) => $q->where('pipeline_status', $filters['status']))
            ->when(in_array($filters['sektor'], Lead::SEKTOR, true), fn ($q) => $q->where('sektor', $filters['sektor']))
            ->when(in_array($filters['pinjaman'], ['1', '0'], true), fn ($q) => $q->where('apply_pinjaman_3bulan', $filters['pinjaman'] === '1'))
            ->when($filters['kod_rujukan'] !== '', fn ($q) => $q->where('kod_rujukan', $filters['kod_rujukan']))
            ->when($dateRange, fn ($q) => $q->whereBetween('submitted_at', $dateRange))
            ->latest('submitted_at')
            ->paginate(15)
            ->withQueryString();

        $referenceCodes = ReferenceCode::query()->latest()->get();

        return view('admin.permohonan', compact('leads', 'filters', 'referenceCodes'));
    }

    /**
     * Resolve the submission-date filter into a [start, end] range, or null.
     */
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

    /**
     * Change a lead's pipeline status and record it in the audit log.
     */
    public function updateStatus(UpdateLeadStatusRequest $request, Lead $lead): RedirectResponse
    {
        $old = $lead->pipeline_status;
        $new = $request->validated('pipeline_status');

        if ($old === $new) {
            return back()->with('error', 'Status tidak berubah.');
        }

        DB::transaction(function () use ($lead, $old, $new, $request) {
            $statusUpdate = ['pipeline_status' => $new];
            if ($new !== 'new_lead') {
                $statusUpdate[$new.'_at'] = now();
            }
            $lead->update($statusUpdate);

            PipelineLog::create([
                'lead_id' => $lead->id,
                'status_lama' => $old,
                'status_baru' => $new,
                'catatan' => $request->validated('catatan'),
                'changed_by' => auth()->id(),
                'created_at' => now(),
            ]);
        });

        return back()->with('success', "Status permohonan {$lead->nama} dikemaskini.");
    }

    /**
     * Soft-delete a lead (PDPA — never hard-erase).
     */
    public function destroy(Lead $lead): RedirectResponse
    {
        $nama = $lead->nama;
        $lead->delete();

        return back()->with('success', "Rekod {$nama} telah dipadam.");
    }
}
