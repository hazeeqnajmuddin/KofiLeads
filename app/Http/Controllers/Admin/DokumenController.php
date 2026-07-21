<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dokumen;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DokumenController extends Controller
{
    /**
     * Stream an uploaded document from the private disk (auth-gated via route middleware).
     */
    public function download(Dokumen $dokumen): StreamedResponse
    {
        abort_unless(Storage::disk('local')->exists($dokumen->path), 404);

        return Storage::disk('local')->download($dokumen->path, $dokumen->nama_fail);
    }
}
