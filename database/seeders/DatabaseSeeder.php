<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Akun Admin
        User::create([
            'username' => 'admin',
            'nama_lengkap' => 'Admin JeeSI',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // 2. Akun Perusahaan & Profil Perusahaan (tbl_perusahaan)
        $userPerusahaan = User::create([
            'username' => 'perusahaan',
            'nama_lengkap' => 'Perusahaan Dummy',
            'email' => 'perusahaan@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'perusahaan',
        ]);

        $idPerusahaan = DB::table('perusahaan')->insertGetId([
            'id_user' => $userPerusahaan->id_user,
            'nama_perusahaan' => 'PT Tech Innovate Indonesia',
            'alamat' => 'Jl. Soekarno Hatta No. 123, Bandung',
            'deskripsi' => 'Perusahaan pengembangan perangkat lunak dan solusi digital.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 3. Akun Alumni / Mahasiswa & Profil Alumni (tbl_alumni)
        $userAlumni = User::create([
            'username' => 'mahasiswa',
            'nama_lengkap' => 'Adelia Rifqi Dian Aprilia',
            'email' => 'mahasiswa@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'alumni',
        ]);

        $idAlumni = DB::table('alumni')->insertGetId([
            'id_user' => $userAlumni->id_user,
            'nama_lengkap' => 'Adelia Rifqi Dian Aprilia',
            'nim' => '10241234',
            'program_studi' => 'Sistem Informasi',
            'pendidikan' => 'S1 Sistem Informasi',
            'kompetensi' => 'Laravel, PHP, MySQL, React.js',
            'minat_studi' => 'Back-End Development, Web Engineering',
            'updated_at' => now(),
        ]);

        // 4. Portofolio Alumni (tbl_portofolio)
        $idPortofolio = DB::table('portofolio')->insertGetId([
            'id_alumni' => $idAlumni,
            'nama_portofolio' => 'Aplikasi JeeSI Group 1',
            'deskripsi' => 'Sistem informasi karir dan penelusuran alumni berbasis Laravel Breeze React.',
            'file_portofolio' => 'portofolio/10241234_jeesi.pdf',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 5. Lowongan Pekerjaan (tbl_lowongan)
        $idLowongan = DB::table('lowongan')->insertGetId([
            'id_perusahaan' => $idPerusahaan,
            'posisi' => 'Junior Back-End Developer',
            'deskripsi' => 'Bertanggung jawab mengelola API, logika backend, dan arsitektur database aplikasi.',
            'kriteria_kandidat' => 'Menguasai PHP, Laravel Framework, MySQL, dan pembuatan REST API.',
            'status_verifikasi' => 'approved',
            'catatan_admin' => 'Lowongan telah diverifikasi dan layak dipublikasikan.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 6. Lamaran Kerja Alumni (tbl_lamaran)
        DB::table('lamaran')->insert([
            'id_alumni' => $idAlumni,
            'id_lowongan' => $idLowongan,
            'id_portofolio' => $idPortofolio,
            'cover_letter' => 'Saya tertarik melamar sebagai Junior Back-End Developer sesuai dengan kompetensi yang saya miliki.',
            'status_lamaran' => 'terkirim',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}