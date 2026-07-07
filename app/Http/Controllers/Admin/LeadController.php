<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateLeadStatusRequest;
use App\Models\Lead;
use App\Models\PipelineLog;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
        ];

        $leads = Lead::query()
            ->with(['masalah', 'dokumen'])
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
            ->latest('submitted_at')
            ->paginate(15)
            ->withQueryString();

        return view('admin.permohonan', compact('leads', 'filters'));
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
            $lead->update(['pipeline_status' => $new]);

            PipelineLog::create([
                'lead_id' => $lead->id,
                'status_lama' => $old,
                'status_baru' => $new,
                'catatan' => $request->validated('catatan'),
                // temp until Phase 3 auth: attribute to the seeded admin (first user)
                'changed_by' => User::query()->value('id'),
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
