<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SetujuiLowonganRequest;
use App\Http\Requests\Admin\TolakLowonganRequest;
use App\Models\Lowongan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminLowonganController extends Controller
{
    private const STATUS_VALID = ['pending', 'approved', 'rejected'];

    /**
     * Daftar lowongan; default menampilkan yang menunggu verifikasi.
     */
    public function index(Request $request): View
    {
        $status = $request->query('status', 'pending');

        if (! in_array($status, self::STATUS_VALID, true)) {
            $status = 'pending';
        }

        $lowongan = Lowongan::with('perusahaan')
            ->where('status_verifikasi', $status)
            ->orderBy('created_at')   // yang paling lama menunggu tampil dulu
            ->paginate(10)
            ->withQueryString();

        return view('admin.verifikasi.index', [
            'lowongan' => $lowongan,
            'status'   => $status,
        ]);
    }

    /**
     * Detail lowongan untuk cek kelayakan (sah, aman, relevan).
     */
    public function show(Lowongan $lowongan): View
    {
        $lowongan->load('perusahaan.user');

        return view('admin.verifikasi.show', [
            'lowongan' => $lowongan,
        ]);
    }

    /**
     * SEQ-003: setujuiLowongan() => status menjadi Published (approved).
     */
    public function setujuiLowongan(SetujuiLowonganRequest $request, Lowongan $lowongan): RedirectResponse
    {
        if ($lowongan->status_verifikasi !== 'pending') {
            return $this->sudahDiproses();
        }

        $lowongan->status_verifikasi = 'approved';
        // Kolom catatan_admin pada migration saat ini NOT NULL, jadi simpan string kosong jika tidak diisi.
        $lowongan->catatan_admin = $request->validated('catatan_admin') ?? '';
        $lowongan->updated_at = now();
        $lowongan->save();

        return redirect()
            ->route('admin.verifikasi.index')
            ->with('success', "Lowongan \"{$lowongan->posisi}\" disetujui dan berstatus Published.");
    }

    /**
     * SEQ-003: tolakLowongan() => status menjadi Ditolak (rejected), alasan wajib diisi.
     */
    public function tolakLowongan(TolakLowonganRequest $request, Lowongan $lowongan): RedirectResponse
    {
        if ($lowongan->status_verifikasi !== 'pending') {
            return $this->sudahDiproses();
        }

        $lowongan->status_verifikasi = 'rejected';
        $lowongan->catatan_admin = $request->validated('catatan_admin');
        $lowongan->updated_at = now();
        $lowongan->save();

        return redirect()
            ->route('admin.verifikasi.index')
            ->with('success', "Lowongan \"{$lowongan->posisi}\" ditolak.");
    }

    private function sudahDiproses(): RedirectResponse
    {
        return redirect()
            ->route('admin.verifikasi.index')
            ->with('error', 'Lowongan ini sudah diverifikasi sebelumnya.');
    }
}
