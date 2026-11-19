@extends('layouts.alumni')

@section('title', 'Dashboard Alumni')

@section('content')

    {{-- UI-002: Dashboard Alumni --}}
    <h1 class="page-title">Dashboard Alumni</h1>

    {{-- Ringkasan: kelengkapan profil, jumlah portofolio, lamaran terkirim --}}
    <section class="stat-grid" aria-label="Ringkasan alumni">
        <div class="stat-card">
            <span class="stat-card__value">{{ $kelengkapanProfil }}%</span>
            <span class="stat-card__label">Kelengkapan profil</span>
        </div>

        <div class="stat-card">
            <span class="stat-card__value">{{ $jumlahPortofolio }}</span>
            <span class="stat-card__label">Jumlah portofolio</span>
        </div>

        <div class="stat-card">
            <span class="stat-card__value">{{ $jumlahLamaran }}</span>
            <span class="stat-card__label">Lamaran terkirim</span>
        </div>
    </section>

    {{-- Peringatan bila profil belum ada / belum lengkap (ACT-002) --}}
    @if (! $alumni)
        <div class="notice notice--danger" role="alert">
            Profil alumni belum lengkap. <a href="{{ route('alumni.profile.edit') }}">Lengkapi profil</a>
            agar persentase kecocokan dengan lowongan dapat dihitung.
        </div>
    @elseif ($kelengkapanProfil < 100)
        <div class="notice notice--muted" role="status">
            Profil Anda belum lengkap. <a href="{{ route('alumni.profile.edit') }}">Lengkapi profil</a>
            untuk meningkatkan persentase kecocokan dengan lowongan.
        </div>
    @endif

    {{-- Lowongan Terbaru --}}
    <section class="panel" aria-labelledby="judul-lowongan">
        <div class="panel__head">
            <h2 class="panel__title" id="judul-lowongan">Lowongan Terbaru</h2>

            @if ($tampilSemua)
                <a href="{{ route('alumni.dashboard') }}" class="panel__link">Lihat terbaru saja</a>
            @else
                <a href="{{ route('alumni.dashboard', ['semua' => 1]) }}" class="panel__link">Lihat semua</a>
            @endif
        </div>

        <ul class="job-list">
            @forelse ($lowongan as $item)
                <li class="job-item">
                    <div>
                        <h3 class="job-item__title">
                            {{ $item->posisi }}
                            <span class="job-item__meta">
                                {{ $item->perusahaan->nama_perusahaan }} &middot; diposting
                                {{ optional($item->created_at)->translatedFormat('d M Y') }}
                            </span>
                        </h3>
                        <p class="job-item__criteria">
                            Kriteria: {{ \Illuminate\Support\Str::limit($item->kriteria_kandidat, 90) }}
                        </p>
                    </div>

                    <div class="job-item__action">
                        <span class="badge-match {{ $item->cocok >= 60 ? 'badge-match--high' : '' }}">
                            Cocok {{ $item->cocok }}%
                        </span>
                        <a href="{{ route('alumni.lowongan.show', $item) }}" class="btn btn--outline">Lihat Detail</a>
                    </div>
                </li>
            @empty
                <li class="notice notice--muted" role="status">Belum ada lowongan published.</li>
            @endforelse
        </ul>

        @if ($tampilSemua && ($lowongan->previousPageUrl() || $lowongan->nextPageUrl()))
            <div class="pager">
                @if ($lowongan->previousPageUrl())
                    <a href="{{ $lowongan->previousPageUrl() }}" class="btn btn--outline">&laquo; Sebelumnya</a>
                @endif
                @if ($lowongan->nextPageUrl())
                    <a href="{{ $lowongan->nextPageUrl() }}" class="btn btn--outline">Berikutnya &raquo;</a>
                @endif
            </div>
        @endif

        <div class="notice notice--success" style="margin-bottom:0;">
            Hanya lowongan berstatus Published. Urut terbaru; label Cocok = kesesuaian Kompetensi dan
            Minat Studi alumni dengan Kriteria Kandidat.
        </div>
    </section>

    {{-- Ringkasan Profil --}}
    <section class="panel" aria-labelledby="judul-profil">
        <div class="panel__head">
            <h2 class="panel__title" id="judul-profil">Ringkasan Profil</h2>
            <a href="{{ route('alumni.profile.edit') }}" class="btn btn--outline">Edit Profil</a>
        </div>

        @if ($alumni)
            <p class="profile-summary">
                <span>
                    Nama: {{ $alumni->nama_lengkap }} | NIM: {{ $alumni->nim }} |
                    Program Studi: {{ $alumni->program_studi }}
                </span>
                <span>
                    Kompetensi: {{ $alumni->kompetensi ?: '-' }} |
                    Minat Studi: {{ $alumni->minat_studi ?: '-' }}
                </span>
            </p>
        @else
            <p class="profile-summary">Belum ada data profil.</p>
        @endif
    </section>

    {{-- Portofolio Saya --}}
    <section class="panel" aria-labelledby="judul-portofolio">
        <div class="panel__head">
            <h2 class="panel__title" id="judul-portofolio">Portofolio Saya</h2>
            <a href="{{ route('alumni.portofolio.index') }}" class="btn">Tambah Portofolio</a>
        </div>

        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama Portofolio</th>
                        <th>Deskripsi</th>
                        <th>File</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($portofolio as $item)
                        <tr>
                            <td>{{ $item->nama_portofolio }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($item->deskripsi, 60) }}</td>
                            <td>
                                <a href="{{ Storage::disk('public')->url($item->file_portofolio) }}" target="_blank" rel="noopener">
                                    {{ basename($item->file_portofolio) }}
                                </a>
                            </td>
                            <td><a href="{{ route('alumni.portofolio.index') }}">Edit</a></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="table__empty">Belum ada portofolio.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

@endsection