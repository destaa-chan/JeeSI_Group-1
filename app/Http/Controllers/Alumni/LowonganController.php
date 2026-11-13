<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use App\Http\Requests\Alumni\StoreLamaranRequest;
use App\Models\Lowongan;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class LowonganController extends Controller
{
    public function show(Lowongan $lowongan): View
    {
        abort_unless($lowongan->status_verifikasi === 'approved', 404);

        $lowongan->load('perusahaan');
        $alumni = request()->user()->alumni;

        return view('alumni.lowongan.show', [
            'lowongan' => $lowongan,
            'portofolio' => $alumni?->portofolio()->latest('created_at')->get() ?? collect(),
            'sudahMelamar' => $alumni?->lamaran()->where('id_lowongan', $lowongan->id_lowongan)->exists() ?? false,
        ]);
    }

    public function apply(StoreLamaranRequest $request, Lowongan $lowongan): RedirectResponse
    {
        abort_unless($lowongan->status_verifikasi === 'approved', 404);

        $alumni = $request->user()->alumni;
        abort_unless($alumni, 422, 'Lengkapi profil alumni terlebih dahulu.');
        abort_if($alumni->lamaran()->where('id_lowongan', $lowongan->id_lowongan)->exists(), 422, 'Anda sudah melamar lowongan ini.');

        $alumni->lamaran()->create([
            'id_lowongan' => $lowongan->id_lowongan,
            'id_portofolio' => $request->validated('id_portofolio'),
            'cover_letter' => $request->validated('cover_letter'),
            'status_lamaran' => 'terkirim',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('alumni.lamaran.index')->with('success', 'Lamaran berhasil dikirim.');
    }
}
