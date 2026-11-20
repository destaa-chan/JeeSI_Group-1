<?php

namespace App\Http\Controllers\Alumni;

use App\Models\Alumni;
use App\Models\Lowongan;
use Illuminate\Support\Str;

/**
 * Menghitung label "Cocok xx%" (UI-002 & UI-003):
 * kesesuaian Kompetensi + Minat Studi alumni dengan Kriteria Kandidat lowongan.
 */
trait HitungKecocokan
{
    private function hitungKecocokan(?Alumni $alumni, Lowongan $lowongan): int
    {
        if (! $alumni) {
            return 0;
        }

        $istilah = collect(preg_split('/[,;\n]+/', $alumni->kompetensi.','.$alumni->minat_studi))
            ->map(fn ($teks) => Str::lower(trim($teks)))
            ->filter()
            ->unique()
            ->values();

        if ($istilah->isEmpty()) {
            return 0;
        }

        $kriteria = Str::lower($lowongan->kriteria_kandidat);
        $cocok = $istilah->filter(fn (string $kata) => str_contains($kriteria, $kata))->count();

        return (int) round($cocok / $istilah->count() * 100);
    }
}