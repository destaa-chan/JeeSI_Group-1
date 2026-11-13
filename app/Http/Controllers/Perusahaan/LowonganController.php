<?php

namespace App\Http\Controllers\Perusahaan;

use App\Http\Controllers\Controller;
use App\Http\Requests\Perusahaan\StoreLowonganRequest;
use App\Models\Lowongan;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class LowonganController extends Controller
{
    public function index(): View
    {
        return view('perusahaan.lowongan.index', [
            'lowongan' => request()->user()->perusahaan?->lowongan()->latest('created_at')->paginate(10) ?? collect(),
        ]);
    }

    public function create(): View
    {
        return view('perusahaan.lowongan.form', ['lowongan' => null]);
    }

    public function store(StoreLowonganRequest $request): RedirectResponse
    {
        $perusahaan = $request->user()->perusahaan;
        abort_unless($perusahaan, 422, 'Lengkapi profil perusahaan terlebih dahulu.');

        $perusahaan->lowongan()->create([
            ...$request->validated(),
            'status_verifikasi' => 'pending',
            'catatan_admin' => '',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('perusahaan.lowongan.index')->with('success', 'Lowongan dikirim dan menunggu verifikasi admin.');
    }

    public function edit(Lowongan $lowongan): View
    {
        $this->ensureOwner($lowongan);

        return view('perusahaan.lowongan.form', compact('lowongan'));
    }

    public function update(StoreLowonganRequest $request, Lowongan $lowongan): RedirectResponse
    {
        $this->ensureOwner($lowongan);

        $lowongan->update([
            ...$request->validated(),
            'status_verifikasi' => 'pending',
            'catatan_admin' => '',
            'updated_at' => now(),
        ]);

        return redirect()->route('perusahaan.lowongan.index')->with('success', 'Lowongan diperbarui dan dikirim ulang untuk verifikasi.');
    }

    public function destroy(Lowongan $lowongan): RedirectResponse
    {
        $this->ensureOwner($lowongan);
        $lowongan->delete();

        return redirect()->route('perusahaan.lowongan.index')->with('success', 'Lowongan berhasil dihapus.');
    }

    private function ensureOwner(Lowongan $lowongan): void
    {
        abort_unless($lowongan->id_perusahaan === request()->user()->perusahaan?->id_perusahaan, 403);
    }
}
