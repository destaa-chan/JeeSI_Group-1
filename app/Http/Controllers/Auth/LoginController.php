<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Login;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

/**
 * LoginController - SEQ-001 Login (UI-001).
 */
class LoginController extends Controller
{
    /**
     * Langkah 1-2: bukaHalamanLogin() => tampilkanForm()
     */
    public function bukaHalamanLogin(): View
    {
        return view('auth.login');
    }

    /**
     * Langkah 4: prosesLogin(username, password)
     */
    public function prosesLogin(Request $request): RedirectResponse
    {
        // Langkah 5
        $data = $this->validasiData($request);

        // Langkah 6-7
        $user = Login::cekDatabase($data['username'], $data['password']);

        // Langkah 8-9 (alt: data tidak valid)
        if (! $user) {
            $this->pesanError('Username atau password salah.');
        }

        // alt: data valid
        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        // Langkah 10
        $tujuan = $this->tentukanHakAkses($user);

        // Langkah 11-12
        return $this->redirectHalamanUtama($tujuan);
    }

    /**
     * Langkah 5: validasiData()
     *
     * @return array{username: string, password: string}
     */
    private function validasiData(Request $request): array
    {
        return $request->validate(
            [
                'username' => ['required', 'string'],
                'password' => ['required', 'string'],
            ],
            [
                'username.required' => 'Username wajib diisi.',
                'password.required' => 'Password wajib diisi.',
            ]
        );
    }

    /**
     * Langkah 8: pesanError() => dikembalikan ke form dan ditampilkan view (langkah 9).
     */
    private function pesanError(string $pesan): never
    {
        throw ValidationException::withMessages([
            'username' => $pesan,
        ]);
    }

    /**
     * Langkah 10: tentukanHakAkses()
     * Menentukan halaman utama (dashboard) sesuai role.
     */
    private function tentukanHakAkses(User $user): string
    {
        $tujuan = match ($user->role) {
            'admin'      => 'admin.dashboard',
            'alumni'     => 'alumni.dashboard',
            'perusahaan' => 'perusahaan.dashboard',
            default      => 'dashboard',
        };

        // Dashboard role yang belum dibuat dialihkan ke /dashboard bawaan.
        return Route::has($tujuan) ? $tujuan : 'dashboard';
    }

    /**
     * Langkah 11-12: tampilkanHalamanUtama() => redirectHalamanUtama()
     */
    private function redirectHalamanUtama(string $namaRoute): RedirectResponse
    {
        return redirect()->intended(route($namaRoute, absolute: false));
    }
}
