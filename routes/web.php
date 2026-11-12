<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TentangController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

// Halaman Tentang (anggota kelompok), dapat diakses tanpa login.
Route::get('/tentang', TentangController::class)->name('tentang');

// Pintu dashboard: mengarahkan user ke dashboard sesuai role (UI-002).
Route::get('/dashboard', function () {
    /** @var \App\Models\User $user */
    $user = request()->user();

    $tujuan = match ($user->role) {
        'admin'      => 'admin.dashboard',
        'alumni'     => 'alumni.dashboard',
        'perusahaan' => 'perusahaan.dashboard',
        default      => null,
    };

    // Route role lain yang belum dibuat dilewati dulu, supaya tidak error.
    if ($tujuan && Route::has($tujuan)) {
        return redirect()->route($tujuan);
    }

    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Area Admin (SKPL-F-003: verifikasi lowongan)
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [Admin\AdminDashboardController::class, 'index'])->name('dashboard');

        Route::prefix('verifikasi-lowongan')->name('verifikasi.')->group(function () {
            Route::get('/', [Admin\AdminLowonganController::class, 'index'])->name('index');
            Route::get('/{lowongan}', [Admin\AdminLowonganController::class, 'show'])->name('show');
            Route::patch('/{lowongan}/setujui', [Admin\AdminLowonganController::class, 'setujuiLowongan'])->name('setujui');
            Route::patch('/{lowongan}/tolak', [Admin\AdminLowonganController::class, 'tolakLowongan'])->name('tolak');
        });
    });

require __DIR__.'/auth.php';