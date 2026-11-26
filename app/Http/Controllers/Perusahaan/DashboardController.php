<?php

namespace App\Http\Controllers\Perusahaan;

use App\Http\Controllers\Controller;
use App\Models\Lamaran;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $perusahaan = request()->user()->perusahaan;
        $lowongan = $perusahaan
            ? $perusahaan->lowongan()->withCount('lamaran')->latest('created_at')->get()
            : collect();

        $lamaranQuery = Lamaran::with(['alumni', 'lowongan'])
            ->whereHas('lowongan', fn ($query) => $query->where('id_perusahaan', $perusahaan?->id_perusahaan));

        $jumlahLamaran = $perusahaan ? (clone $lamaranQuery)->count() : 0;
        $jumlahLamaranBaru = $perusahaan ? (clone $lamaranQuery)->where('status_lamaran', 'terkirim')->count() : 0;
        $lamaranTerbaru = $perusahaan
            ? $lamaranQuery->latest('created_at')->take(5)->get()
            : collect();

        return view('perusahaan.dashboard', [
            'perusahaan' => $perusahaan,
            'lowongan' => $lowongan,
            'lamaranTerbaru' => $lamaranTerbaru,
            'jumlahLamaran' => $jumlahLamaran,
            'jumlahLamaranBaru' => $jumlahLamaranBaru,
        ]);
    }
}
