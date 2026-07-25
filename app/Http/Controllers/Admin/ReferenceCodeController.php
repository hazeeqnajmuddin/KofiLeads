<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReferenceCode;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ReferenceCodeController extends Controller
{
    /**
     * Create a reference code for a live session. If the admin leaves the code
     * blank, the next sequential one (RCMS01, RCMS02, …) is generated. New codes
     * start active; more than one code may be active at the same time.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'host_name' => ['required', 'string', 'max:255'],
            'code' => ['nullable', 'string', 'max:50', Rule::unique('reference_codes', 'code')],
        ], [
            'code.unique' => 'Kod ini telah wujud. Sila guna kod lain.',
        ]);

        $code = ! empty($data['code']) ? trim($data['code']) : ReferenceCode::generate();

        ReferenceCode::create([
            'host_name' => $data['host_name'],
            'code' => $code,
            'is_active' => true,
        ]);

        return back()->with('success', "Kod rujukan {$code} dijana dan diaktifkan.");
    }

    /**
     * Toggle whether this code is active. Multiple codes may be active at once,
     * so activating one does not deactivate the others.
     */
    public function activate(ReferenceCode $referenceCode): RedirectResponse
    {
        $referenceCode->update(['is_active' => ! $referenceCode->is_active]);

        $state = $referenceCode->is_active ? 'diaktifkan' : 'dinyahaktifkan';

        return back()->with('success', "Kod {$referenceCode->code} {$state}.");
    }

    public function destroy(ReferenceCode $referenceCode): RedirectResponse
    {
        $code = $referenceCode->code;
        $referenceCode->delete();

        return back()->with('success', "Kod {$code} telah dipadam.");
    }
}
