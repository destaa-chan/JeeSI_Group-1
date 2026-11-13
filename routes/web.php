<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\Alumni;
use App\Http\Controllers\Perusahaan;
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

Route::middleware(['auth', 'role:alumni'])
    ->prefix('alumni')
    ->name('alumni.')
    ->group(function () {
        Route::get('/dashboard', [Alumni\DashboardController::class, 'index'])->name('dashboard');
        Route::get('/profil', [Alumni\ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profil', [Alumni\ProfileController::class, 'update'])->name('profile.update');
        Route::get('/portofolio', [Alumni\PortofolioController::class, 'index'])->name('portofolio.index');
        Route::post('/portofolio', [Alumni\PortofolioController::class, 'store'])->name('portofolio.store');
        Route::delete('/portofolio/{portofolio}', [Alumni\PortofolioController::class, 'destroy'])->name('portofolio.destroy');
        Route::get('/lowongan/{lowongan}', [Alumni\LowonganController::class, 'show'])->name('lowongan.show');
        Route::post('/lowongan/{lowongan}/lamar', [Alumni\LowonganController::class, 'apply'])->name('lowongan.apply');
        Route::get('/lamaran', [Alumni\LamaranController::class, 'index'])->name('lamaran.index');
    });

Route::middleware(['auth', 'role:perusahaan'])
    ->prefix('perusahaan')
    ->name('perusahaan.')
    ->group(function () {
        Route::get('/dashboard', [Perusahaan\DashboardController::class, 'index'])->name('dashboard');
        Route::get('/profil', [Perusahaan\ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profil', [Perusahaan\ProfileController::class, 'update'])->name('profile.update');
        Route::resource('lowongan', Perusahaan\LowonganController::class)->except(['show']);
        Route::get('/lamaran', [Perusahaan\LamaranController::class, 'index'])->name('lamaran.index');
        Route::get('/lamaran/{lamaran}', [Perusahaan\LamaranController::class, 'show'])->name('lamaran.show');
        Route::patch('/lamaran/{lamaran}/status', [Perusahaan\LamaranController::class, 'updateStatus'])->name('lamaran.status');
    });

require __DIR__.'/auth.php';