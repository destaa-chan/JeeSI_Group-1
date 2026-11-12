<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\View\View;

class TentangController extends Controller
{
    /**
     * Halaman Tentang: daftar anggota kelompok (nama, NIM, dan peran).
     * Dapat diakses tanpa login (tombol "i" di halaman login).
     *
     * Peran disusun dari Lampiran A (Tabel Kontribusi Anggota Tim) pada SDD.
     * Ubah isi array ini jika ingin menyesuaikan nama peran.
     */
    public function __invoke(): View
    {
        $anggota = collect([
            [
                'nama' => 'Adelia Isra Ekaputri',
                'nim'  => '10241004',
                'role' => 'Front-end Developer',
            ],
            [
                'nama' => 'Desta Rifqi Aunur Rahman',
                'nim'  => '10241020',
                'role' => 'Front-end Developer',
            ],
            [
                'nama' => 'Devina Dian Saputri',
                'nim'  => '10241022',
                'role' => 'Back-end Developer',
            ],
            [
                'nama' => 'Laudya Aprilia Khoirum',
                'nim'  => '10241038',
                'role' => 'Back-end Developer',
            ],
        ])->map(function (array $a) {
            // Inisial dari dua kata pertama nama, dipakai untuk avatar.
            $a['inisial'] = Str::of($a['nama'])
                ->explode(' ')
                ->take(2)
                ->map(fn ($kata) => mb_strtoupper(mb_substr($kata, 0, 1)))
                ->implode('');

            return $a;
        });

        return view('tentang', ['anggota' => $anggota]);
    }
}