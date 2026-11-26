@extends('layouts.perusahaan')

@section('title', 'Dashboard Perusahaan')

@section('content')

    @php
        $totalLowongan = $lowongan->count();
        $lowonganPublished = $lowongan->where('status_verifikasi', 'approved')->count();
        $lowonganDitolak = $lowongan->where('status_verifikasi', 'rejected')->count();

        $labelVerifikasi = [
            'pending'  => 'Menunggu Verifikasi',
            'approved' => 'Published',
            'rejected' => 'Ditolak',
        ];

        $labelLamaran = [
            'terkirim' => 'Terkirim',
            'dilihat'  => 'Dilihat',
            'diundang' => 'Diundang',
            'diterima' => 'Diterima',
            'ditolak'  => 'Ditolak',
        ];
    @endphp

    <h1 class="page-title">Dashboard Perusahaan</h1>

    {{-- Ringkasan statistik perusahaan --}}
    <section class="stat-grid" aria-label="Ringkasan perusahaan">
        <div class="stat-card">
            <span class="stat-card__value">{{ $totalLowongan }}</span>
            <span class="stat-card__label">Total lowongan</span>
        </div>

        <div class="stat-card">
            <span class="stat-card__value">{{ $lowonganPublished }}</span>
            <span class="stat-card__label">Lowongan published</span>
        </div>

        <div class="stat-card">
            <span class="stat-card__value">{{ $jumlahLamaran }}</span>
            <span class="stat-card__label">Lamaran masuk</span>
        </div>
    </section>

    {{-- Peringatan & notifikasi --}}
    @if (! $perusahaan)
        <div class="notice notice--danger" role="alert">
            Profil perusahaan belum lengkap. <a href="{{ route('perusahaan.profile.edit') }}">Lengkapi profil perusahaan</a>
            terlebih dahulu agar Anda dapat memposting lowongan pekerjaan.
        </div>
    @endif

    @if ($jumlahLamaranBaru > 0)
        <div class="notice notice--success" role="status">
            Notifikasi: ada {{ $jumlahLamaranBaru }} lamaran baru berstatus Terkirim.
            <a href="{{ route('perusahaan.lamaran.index') }}">Tinjau lamaran masuk</a>.
        </div>
    @endif

    @if ($lowonganDitolak > 0)
        <div class="notice notice--warning" role="status">
            Perhatian: terdapat {{ $lowonganDitolak }} lowongan yang ditolak oleh admin.
            <a href="{{ route('perusahaan.lowongan.index') }}">Periksa catatan admin</a> untuk memperbaiki lowongan.
        </div>
    @endif

    {{-- Lowongan Saya --}}
    <section class="panel" aria-labelledby="judul-lowongan">
        <div class="panel__head">
            <h2 class="panel__title" id="judul-lowongan">Lowongan Saya</h2>

            <div class="table__actions">
                <a href="{{ route('perusahaan.lowongan.index') }}" class="panel__link">Lihat semua</a>
                @if ($perusahaan)
                    <a href="{{ route('perusahaan.lowongan.create') }}" class="btn btn--sm">Posting Lowongan</a>
                @endif
            </div>
        </div>

        <ul class="job-list" style="margin-bottom: 0;">
            @forelse ($lowongan->take(5) as $item)
                <li class="job-item">
                    <div>
                        <h3 class="job-item__title">
                            {{ $item->posisi }}
                            <span class="job-item__meta">
                                &middot; diposting {{ optional($item->created_at)->translatedFormat('d M Y') ?? '-' }}
                                &middot; {{ $item->lamaran_count ?? 0 }} pelamar
                            </span>
                        </h3>
                        <p class="job-item__criteria">
                            Kriteria: {{ \Illuminate\Support\Str::limit($item->kriteria_kandidat, 90) }}
                        </p>
                        @if ($item->status_verifikasi === 'rejected' && $item->catatan_admin)
                            <p class="form-error">Catatan admin: {{ $item->catatan_admin }}</p>
                        @endif
                    </div>

                    <div class="job-item__action">
                        <span class="badge-status badge-status--{{ $item->status_verifikasi }}">
                            {{ $labelVerifikasi[$item->status_verifikasi] ?? ucfirst($item->status_verifikasi) }}
                        </span>
                        <a href="{{ route('perusahaan.lowongan.edit', $item) }}" class="btn btn--outline btn--sm">Edit</a>
                    </div>
                </li>
            @empty
                <li class="notice notice--muted" role="status" style="margin-bottom: 0;">
                    Belum ada lowongan yang diposting.
                </li>
            @endforelse
        </ul>
    </section>

    {{-- Ringkasan Profil Perusahaan --}}
    <section class="panel" aria-labelledby="judul-profil">
        <div class="panel__head">
            <h2 class="panel__title" id="judul-profil">Ringkasan Profil Perusahaan</h2>
            <a href="{{ route('perusahaan.profile.edit') }}" class="btn btn--outline btn--sm">Edit Profil</a>
        </div>

        @if ($perusahaan)
            <div class="profile-summary">
                <span><strong>Nama Perusahaan:</strong> {{ $perusahaan->nama_perusahaan }}</span>
                <span><strong>Alamat:</strong> {{ $perusahaan->alamat }}</span>
                <span><strong>Deskripsi:</strong> {{ \Illuminate\Support\Str::limit($perusahaan->deskripsi, 180) }}</span>
            </div>
        @else
            <p class="profile-summary">Belum ada data profil perusahaan.</p>
        @endif
    </section>

    {{-- Lamaran Masuk Terbaru --}}
    <section class="panel" aria-labelledby="judul-lamaran">
        <div class="panel__head">
            <h2 class="panel__title" id="judul-lamaran">Lamaran Masuk Terbaru</h2>
            <a href="{{ route('perusahaan.lamaran.index') }}" class="panel__link">Lihat semua</a>
        </div>

        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama Pelamar</th>
                        <th>Posisi</th>
                        <th>Tanggal Daftar</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($lamaranTerbaru as $item)
                        <tr>
                            <td>{{ $item->alumni->nama_lengkap ?? '-' }}</td>
                            <td>{{ $item->lowongan->posisi ?? '-' }}</td>
                            <td>{{ optional($item->created_at)->translatedFormat('d M Y') ?? '-' }}</td>
                            <td>
                                <span class="badge-status badge-status--{{ $item->status_lamaran }}">
                                    {{ $labelLamaran[$item->status_lamaran] ?? ucfirst($item->status_lamaran) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('perusahaan.lamaran.show', $item) }}">Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="table__empty">Belum ada lamaran masuk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

@endsection
