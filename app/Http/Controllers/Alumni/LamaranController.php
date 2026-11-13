<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class LamaranController extends Controller
{
    public function index(): View
    {
        return view('alumni.lamaran.index', [
            'lamaran' => request()->user()->alumni?->lamaran()
                ->with('lowongan.perusahaan')
                ->latest('created_at')
                ->paginate(10) ?? collect(),
        ]);
    }
}
