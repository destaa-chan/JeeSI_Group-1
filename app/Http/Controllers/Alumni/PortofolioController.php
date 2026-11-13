<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use App\Http\Requests\Alumni\StorePortofolioRequest;
use App\Models\Portofolio;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PortofolioController extends Controller
{
    public function index(): View
    {
        $alumni = request()->user()->alumni;

        return view('alumni.portofolio', [
            'alumni' => $alumni,
            'portofolio' => $alumni?->portofolio()->latest('created_at')->get() ?? collect(),
        ]);
    }

    public function store(StorePortofolioRequest $request): RedirectResponse
    {
        $alumni = $request->user()->alumni;

        abort_unless($alumni, 422, 'Lengkapi profil alumni terlebih dahulu.');

        $path = $request->file('file_portofolio')->store('portofolio', 'public');
        $alumni->portofolio()->create([
            ...$request->safe()->except('file_portofolio'),
            'file_portofolio' => $path,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('alumni.portofolio.index')->with('success', 'Portofolio berhasil ditambahkan.');
    }

    public function destroy(Portofolio $portofolio): RedirectResponse
    {
        abort_unless($portofolio->id_alumni === request()->user()->alumni?->id_alumni, 403);

        Storage::disk('public')->delete($portofolio->file_portofolio);
        $portofolio->delete();

        return redirect()->route('alumni.portofolio.index')->with('success', 'Portofolio berhasil dihapus.');
    }
}
