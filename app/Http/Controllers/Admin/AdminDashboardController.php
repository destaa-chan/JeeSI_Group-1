<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lowongan;
use Illuminate\View\View;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        $menungguVerifikasi = Lowongan::where('status_verifikasi', 'pending')->count();

        return view('admin.dashboard', [
            'menungguVerifikasi' => $menungguVerifikasi,
            'published'          => Lowongan::where('status_verifikasi', 'approved')->count(),
            'ditolak'            => Lowongan::where('status_verifikasi', 'rejected')->count(),
            // Notifikasi "ada lowongan baru yang menunggu verifikasi"
            'adaLowonganBaru'    => $menungguVerifikasi > 0,
        ]);
    }
}
