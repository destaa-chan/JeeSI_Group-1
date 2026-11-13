<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use App\Models\Lowongan;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('alumni.dashboard', [
            'alumni' => request()->user()->alumni,
            'lowongan' => Lowongan::with('perusahaan')
                ->where('status_verifikasi', 'approved')
                ->latest('created_at')
                ->paginate(10),
        ]);
    }
}
