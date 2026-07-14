<?php

namespace App\Services;

use App\Models\Dokumen;
use App\Models\Lead;
use FPDF;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use RuntimeException;
use Symfony\Component\Process\Process;

/**
 * Phase 9 (Slice 1) — combine a lead's uploaded documents into a single PDF.
 *
 * PDFs are used as-is; image uploads (jpg/png) are wrapped into a one-page PDF
 * via FPDF (pure PHP, no system binary). All parts are then concatenated with
 * Ghostscript, which handles any PDF version. Output lands on the PRIVATE disk
 * (never public) — served only through an admin route.
 */
class DocumentMergeService
{
    /** Merge order for a lead's documents. */
    private const ORDER = ['slip_gaji', 'laporan_ctos', 'penyata_epf'];

    /**
     * Build (or rebuild) the merged PDF for a lead.
     *
     * @return string|null Path on the `local` disk, or null if the lead has no documents.
     */
    public function merge(Lead $lead): ?string
    {
        $docs = $this->orderedDocuments($lead);

        if ($docs->isEmpty()) {
            return null;
        }

        $disk = Storage::disk('local');
        $tmpDir = storage_path('app/private/tmp/merge_'.$lead->id.'_'.uniqid());
        @mkdir($tmpDir, 0755, true);

        $pdfParts = [];

        try {
            foreach ($docs as $doc) {
                $source = $disk->path($doc->path);
                if (! is_file($source)) {
                    continue; // skip a missing source rather than fail the whole merge
                }

                $ext = strtolower(pathinfo($doc->path, PATHINFO_EXTENSION));
                $pdfParts[] = $ext === 'pdf'
                    ? $source
                    : $this->imageToPdf($source, $tmpDir.'/'.count($pdfParts).'.pdf');
            }

            if ($pdfParts === []) {
                return null;
            }

            $relative = "merged/{$lead->id}.pdf";
            $disk->makeDirectory('merged');
            $output = $disk->path($relative);

            $this->concatenate($pdfParts, $output);

            return $relative;
        } finally {
            $this->cleanup($tmpDir);
        }
    }

    /**
     * A lead's documents in canonical merge order (slip gaji 1-3, CTOS, EPF).
     *
     * @return Collection<int, Dokumen>
     */
    private function orderedDocuments(Lead $lead): Collection
    {
        return $lead->dokumen
            ->sortBy([
                fn (Dokumen $d) => array_search($d->jenis, self::ORDER, true),
                fn (Dokumen $d) => $d->bulan ?? 0,
            ])
            ->values();
    }

    /**
     * Wrap a single image (jpg/png) into a one-page PDF sized to the image.
     */
    private function imageToPdf(string $imagePath, string $outputPath): string
    {
        $size = @getimagesize($imagePath);
        if ($size === false) {
            throw new RuntimeException("Cannot read image: {$imagePath}");
        }

        [$width, $height] = $size;
        $orientation = $width > $height ? 'L' : 'P';

        $pdf = new FPDF($orientation, 'pt', [$width, $height]);
        $pdf->AddPage($orientation, [$width, $height]);
        $pdf->Image($imagePath, 0, 0, $width, $height);
        $pdf->Output('F', $outputPath);

        return $outputPath;
    }

    /**
     * Concatenate PDFs into one file using Ghostscript.
     */
    private function concatenate(array $pdfPaths, string $outputPath): void
    {
        $process = new Process(array_merge([
            $this->ghostscript(),
            '-q', '-dNOPAUSE', '-dBATCH', '-dSAFER',
            '-sDEVICE=pdfwrite',
            '-sOutputFile='.$outputPath,
        ], $pdfPaths));

        $process->setTimeout(120);
        $process->run();

        if (! $process->isSuccessful() || ! is_file($outputPath)) {
            throw new RuntimeException('Ghostscript merge failed: '.$process->getErrorOutput());
        }
    }

    /**
     * Resolve the Ghostscript binary. Overridable via GHOSTSCRIPT_PATH; otherwise
     * probes the usual locations, falling back to `gs` on PATH.
     */
    private function ghostscript(): string
    {
        if ($env = env('GHOSTSCRIPT_PATH')) {
            return $env;
        }

        $candidates = [
            '/opt/homebrew/bin/gs',
            '/usr/local/bin/gs',
            '/usr/bin/gs',
        ];

        // Windows: scan common Ghostscript install dirs for gswin64c.exe / gswin32c.exe
        if (PHP_OS_FAMILY === 'Windows') {
            foreach (['C:/Program Files/gs', 'C:/Program Files (x86)/gs'] as $base) {
                if (is_dir($base)) {
                    foreach (array_reverse(glob($base . '/gs*/bin/gswin64c.exe') ?: []) as $w) {
                        $candidates[] = $w;
                    }
                    foreach (array_reverse(glob($base . '/gs*/bin/gswin32c.exe') ?: []) as $w) {
                        $candidates[] = $w;
                    }
                }
            }
        }

        foreach ($candidates as $candidate) {
            if (is_executable($candidate)) {
                return $candidate;
            }
        }

        return PHP_OS_FAMILY === 'Windows' ? 'gswin64c' : 'gs';
    }

    /**
     * Is Ghostscript available? Used by tests to skip when the binary is absent.
     */
    public function ghostscriptAvailable(): bool
    {
        $process = new Process([$this->ghostscript(), '--version']);
        $process->run();

        return $process->isSuccessful();
    }

    private function cleanup(string $dir): void
    {
        if (! is_dir($dir)) {
            return;
        }
        foreach (glob($dir.'/*') ?: [] as $file) {
            @unlink($file);
        }
        @rmdir($dir);
    }
}
