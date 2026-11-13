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

class LoginController extends Controller
{
    public function bukaHalamanLogin(): View
    {
        return view('auth.login');
    }

    public function prosesLogin(Request $request): RedirectResponse
    {
        $data = $this->validasiData($request);
        $user = Login::cekDatabase($data['username'], $data['password']);

        if (! $user) {
            $this->pesanError('Username atau password salah.');
        }

        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();
        $tujuan = $this->tentukanHakAkses($user);

        return $this->redirectHalamanUtama($tujuan);
    }

    /**
     * validasiData()
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

    private function pesanError(string $pesan): never
    {
        throw ValidationException::withMessages([
            'username' => $pesan,
        ]);
    }

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

    private function redirectHalamanUtama(string $namaRoute): RedirectResponse
    {
        return redirect()->intended(route($namaRoute, absolute: false));
    }
}
