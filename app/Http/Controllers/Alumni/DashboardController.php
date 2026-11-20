<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use App\Models\Lowongan;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    use HitungKecocokan;

    /** Kolom profil yang dihitung untuk "Kelengkapan profil" (tbl_alumni). */
    private const KOLOM_PROFIL = [
        'nama_lengkap', 'nim', 'program_studi', 'pendidikan', 'kompetensi', 'minat_studi',
    ];

    public function index(Request $request): View
    {
        $alumni = $request->user()->alumni;
        $tampilSemua = $request->boolean('semua');

        // Hanya lowongan Published (status_verifikasi = approved), urut terbaru.
        $query = Lowongan::with('perusahaan')
            ->where('status_verifikasi', 'approved')
            ->latest('created_at');

        // Default: 3 lowongan terbaru. "Lihat semua": seluruh lowongan (dipaginasi).
        $lowongan = $tampilSemua
            ? $query->simplePaginate(10)->withQueryString()
            : $query->limit(3)->get();

        // Label "Cocok xx%" per lowongan.
        $lowongan->each(fn (Lowongan $item) => $item->cocok = $this->hitungKecocokan($alumni, $item));

        return view('alumni.dashboard', [
            'alumni'            => $alumni,
            'lowongan'          => $lowongan,
            'tampilSemua'       => $tampilSemua,
            'kelengkapanProfil' => $this->hitungKelengkapan($alumni),
            'jumlahPortofolio'  => $alumni?->portofolio()->count() ?? 0,
            'jumlahLamaran'     => $alumni?->lamaran()->count() ?? 0,
            'portofolio'        => $alumni?->portofolio()->latest('created_at')->limit(5)->get() ?? collect(),
        ]);
    }

    /** Persentase kolom profil yang sudah terisi. */
    private function hitungKelengkapan(?Alumni $alumni): int
    {
        if (! $alumni) {
            return 0;
        }

        $terisi = collect(self::KOLOM_PROFIL)
            ->filter(fn (string $kolom) => filled($alumni->{$kolom}))
            ->count();

        return (int) round($terisi / count(self::KOLOM_PROFIL) * 100);
    }
}