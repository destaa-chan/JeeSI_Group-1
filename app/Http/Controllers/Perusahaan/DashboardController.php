<?php

namespace App\Http\Controllers\Perusahaan;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $perusahaan = request()->user()->perusahaan;

        return view('perusahaan.dashboard', [
            'perusahaan' => $perusahaan,
            'lowongan' => $perusahaan?->lowongan()->latest('created_at')->get() ?? collect(),
        ]);
    }
}
