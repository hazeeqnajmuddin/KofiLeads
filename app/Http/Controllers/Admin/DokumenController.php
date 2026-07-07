<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dokumen;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DokumenController extends Controller
{
    /**
     * Stream an uploaded document from the private disk.
     *
     * NOTE: not auth-gated yet — the whole /admin/* area is open during the
     * no-auth phase (Phase 3 deferred). Files still live on the private disk
     * and are only reachable through this controller, never a public URL.
     */
    public function download(Dokumen $dokumen): StreamedResponse
    {
        abort_unless(Storage::disk('local')->exists($dokumen->path), 404);

        return Storage::disk('local')->download($dokumen->path, $dokumen->nama_fail);
    }
}
