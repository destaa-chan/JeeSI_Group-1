<?php

namespace App\Http\Controllers\Perusahaan;

use App\Http\Controllers\Controller;
use App\Http\Requests\Perusahaan\UpdateLamaranStatusRequest;
use App\Models\Lamaran;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class LamaranController extends Controller
{
    public function index(): View
    {
        $perusahaan = request()->user()->perusahaan;

        return view('perusahaan.lamaran.index', [
            'lamaran' => Lamaran::with(['alumni.user', 'lowongan'])
                ->whereHas('lowongan', fn ($query) => $query->where('id_perusahaan', $perusahaan?->id_perusahaan))
                ->latest('created_at')
                ->paginate(10),
        ]);
    }

    public function show(Lamaran $lamaran): View
    {
        $this->ensureOwner($lamaran);
        $lamaran->load(['alumni.user', 'alumni.portofolio', 'lowongan']);

        return view('perusahaan.lamaran.show', compact('lamaran'));
    }

    public function updateStatus(UpdateLamaranStatusRequest $request, Lamaran $lamaran): RedirectResponse
    {
        $this->ensureOwner($lamaran);
        $lamaran->update([
            'status_lamaran' => $request->validated('status_lamaran'),
            'updated_at' => now(),
        ]);

        return redirect()->route('perusahaan.lamaran.show', $lamaran)->with('success', 'Status lamaran berhasil diperbarui.');
    }

    private function ensureOwner(Lamaran $lamaran): void
    {
        abort_unless($lamaran->lowongan()->where('id_perusahaan', request()->user()->perusahaan?->id_perusahaan)->exists(), 403);
    }
}
