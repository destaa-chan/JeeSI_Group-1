@extends('layouts.perusahaan')

@section('title', 'Dashboard Perusahaan')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Dashboard Perusahaan</h1>
            <p class="page-subtitle">
                Selamat datang, <strong>{{ $perusahaan?->nama_perusahaan ?? auth()->user()->nama_pengguna }}</strong>
            </p>
        </div>
        <div>
            <a href="{{ route('perusahaan.lowongan.create') }}" class="btn">
                + Posting Lowongan Baru
            </a>
        </div>
    </div>

    @if (!$perusahaan || empty($perusahaan->nama_perusahaan) || empty($perusahaan->alamat))
        <div class="notice notice--warning" role="alert">
            <strong>Perhatian:</strong> Profil perusahaan Anda belum lengkap. Silakan
            <a href="{{ route('perusahaan.profile.edit') }}">lengkapi profil perusahaan Anda</a>
            agar lowongan dapat diverifikasi oleh admin JeeSI.
        </div>
    @endif

    {{-- Ringkasan Statistik Lowongan --}}
    @php
        $totalLowongan = $lowongan->count();
        $pendingCount = $lowongan->where('status_verifikasi', 'pending')->count();
        $approvedCount = $lowongan->where('status_verifikasi', 'approved')->count();
        $rejectedCount = $lowongan->where('status_verifikasi', 'rejected')->count();
    @endphp

    <section class="stat-grid" aria-label="Statistik Lowongan">
        <div class="stat-card">
            <span class="stat-card__value">{{ $totalLowongan }}</span>
            <span class="stat-card__label">Total Lowongan</span>
        </div>
        <div class="stat-card">
            <span class="stat-card__value" style="color: var(--warning-text);">{{ $pendingCount }}</span>
            <span class="stat-card__label">Menunggu Verifikasi</span>
        </div>
        <div class="stat-card">
            <span class="stat-card__value" style="color: var(--success-text);">{{ $approvedCount }}</span>
            <span class="stat-card__label">Lowongan Published</span>
        </div>
        <div class="stat-card">
            <span class="stat-card__value" style="color: var(--danger-text);">{{ $rejectedCount }}</span>
            <span class="stat-card__label">Lowongan Ditolak</span>
        </div>
    </section>

    {{-- Panel Lowongan Terkini --}}
    <section class="panel">
        <div class="panel__head">
            <h2 class="panel__title">Lowongan Terbaru</h2>
            <a href="{{ route('perusahaan.lowongan.index') }}" class="panel__link">Kelola Semua Lowongan &rarr;</a>
        </div>

        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Posisi</th>
                        <th>Tanggal Posting</th>
                        <th>Status Verifikasi</th>
                        <th>Catatan Admin</th>
                        <th style="text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($lowongan->take(5) as $item)
                        <tr>
                            <td>
                                <strong>{{ $item->posisi }}</strong>
                            </td>
                            <td>{{ $item->created_at?->translatedFormat('d M Y') ?? '-' }}</td>
                            <td>
                                @if ($item->status_verifikasi === 'pending')
                                    <span class="badge-status badge-status--pending">Menunggu Verifikasi</span>
                                @elseif ($item->status_verifikasi === 'approved')
                                    <span class="badge-status badge-status--approved">Disetujui (Published)</span>
                                @elseif ($item->status_verifikasi === 'rejected')
                                    <span class="badge-status badge-status--rejected">Ditolak</span>
                                @else
                                    <span class="badge-status">{{ $item->status_verifikasi }}</span>
                                @endif
                            </td>
                            <td>
                                @if ($item->catatan_admin)
                                    <span style="color: var(--danger-text); font-size: 11px;">{{ $item->catatan_admin }}</span>
                                @else
                                    <span style="color: var(--text-muted); font-size: 11px;">-</span>
                                @endif
                            </td>
                            <td style="text-align: right;">
                                <a href="{{ route('perusahaan.lowongan.edit', $item) }}" class="btn btn--secondary btn--sm">
                                    Edit
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="table__empty">
                                Belum ada lowongan pekerjaan.
                                <div style="margin-top: 8px;">
                                    <a href="{{ route('perusahaan.lowongan.create') }}" class="btn btn--sm">
                                        Posting Lowongan Pertama Anda
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
