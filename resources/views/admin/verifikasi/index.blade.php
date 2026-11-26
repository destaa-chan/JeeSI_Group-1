@extends('layouts.admin')

@section('title', 'Verifikasi Lowongan')

@section('content')
    <div style="display: flex; align-items: center; justify-content: space-between; gap: 14px; margin-bottom: 14px; flex-wrap: wrap;">
        <div>
            <h1 class="page-title" style="margin: 0;">Verifikasi Lowongan Kerja</h1>
            <p style="margin: 4px 0 0; font-size: 12px; color: var(--text-muted);">
                Tinjau dan validasi keabsahan lowongan pekerjaan dari perusahaan mitra sesuai standar kurikulum Sistem Informasi.
            </p>
        </div>
        <div>
            <a href="{{ route('admin.dashboard') }}" class="btn btn--outline btn--sm">
                &larr; Kembali ke Dashboard
            </a>
        </div>
    </div>

    {{-- Tabs Status Verifikasi --}}
    <nav class="admin-tabs" aria-label="Filter status verifikasi">
        <a href="{{ route('admin.verifikasi.index', ['status' => 'pending']) }}"
           class="admin-tab {{ $status === 'pending' ? 'is-active' : '' }}">
            Menunggu Verifikasi
        </a>
        <a href="{{ route('admin.verifikasi.index', ['status' => 'approved']) }}"
           class="admin-tab {{ $status === 'approved' ? 'is-active' : '' }}">
            Disetujui (Published)
        </a>
        <a href="{{ route('admin.verifikasi.index', ['status' => 'rejected']) }}"
           class="admin-tab {{ $status === 'rejected' ? 'is-active' : '' }}">
            Ditolak
        </a>
    </nav>

    <div class="table-wrap">
        <table class="table">
            <thead>
                <tr>
                    <th>Posisi Lowongan</th>
                    <th>Nama Perusahaan</th>
                    <th>Tanggal Pengajuan</th>
                    <th>Status</th>
                    @if ($status === 'rejected')
                        <th>Alasan Penolakan</th>
                    @endif
                    <th style="text-align: right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($lowongan as $item)
                    <tr>
                        <td>
                            <strong>{{ $item->posisi }}</strong>
                            <div style="font-size: 11px; color: var(--text-muted); margin-top: 2px;">
                                {{ Str::limit($item->deskripsi, 60) }}
                            </div>
                        </td>
                        <td>
                            <strong>{{ $item->perusahaan?->nama_perusahaan ?? 'Perusahaan #' . $item->id_perusahaan }}</strong>
                        </td>
                        <td>{{ $item->created_at?->translatedFormat('d M Y H:i') ?? '-' }}</td>
                        <td>
                            @if ($item->status_verifikasi === 'pending')
                                <span class="badge-status badge-status--pending">Menunggu Verifikasi</span>
                            @elseif ($item->status_verifikasi === 'approved')
                                <span class="badge-status badge-status--approved">Published</span>
                            @elseif ($item->status_verifikasi === 'rejected')
                                <span class="badge-status badge-status--rejected">Ditolak</span>
                            @else
                                <span class="badge-status">{{ $item->status_verifikasi }}</span>
                            @endif
                        </td>
                        @if ($status === 'rejected')
                            <td>
                                <span style="font-size: 11px; color: var(--danger-text);">
                                    {{ $item->catatan_admin ?: '-' }}
                                </span>
                            </td>
                        @endif
                        <td style="text-align: right;">
                            <a href="{{ route('admin.verifikasi.show', $item) }}" class="btn btn--sm">
                                Review & Verifikasi &rarr;
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ $status === 'rejected' ? 6 : 5 }}" class="table__empty">
                            @if ($status === 'pending')
                                Tidak ada lowongan pekerjaan yang menunggu verifikasi saat ini.
                            @elseif ($status === 'approved')
                                Belum ada lowongan pekerjaan yang disetujui.
                            @else
                                Tidak ada data lowongan yang ditolak.
                            @endif
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if (method_exists($lowongan, 'links'))
        <div style="margin-top: 14px;">
            {{ $lowongan->links() }}
        </div>
    @endif
@endsection
