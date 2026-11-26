@extends('layouts.perusahaan')

@section('title', 'Kelola Lowongan')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Kelola Lowongan</h1>
            <p class="page-subtitle">Daftar semua lowongan kerja yang Anda posting di platform JeeSI</p>
        </div>
        <div>
            <a href="{{ route('perusahaan.lowongan.create') }}" class="btn">
                + Posting Lowongan Baru
            </a>
        </div>
    </div>

    <div class="notice notice--muted">
        <strong>Alur Verifikasi:</strong> Setiap lowongan kerja yang diajukan akan ditinjau oleh Admin JeeSI untuk memastikan keabsahan dan relevansinya bagi alumni Sistem Informasi.
    </div>

    <div class="table-wrap">
        <table class="table">
            <thead>
                <tr>
                    <th>Posisi Pekerjaan</th>
                    <th>Tanggal Posting</th>
                    <th>Status Verifikasi</th>
                    <th>Catatan Admin</th>
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
                            @if ($item->status_verifikasi === 'rejected' && $item->catatan_admin)
                                <div style="color: var(--danger-text); font-size: 11px; font-weight: 600;">
                                    Alasan: {{ $item->catatan_admin }}
                                </div>
                            @elseif ($item->catatan_admin)
                                <span style="font-size: 11px; color: var(--text-muted);">{{ $item->catatan_admin }}</span>
                            @else
                                <span style="font-size: 11px; color: var(--text-muted);">-</span>
                            @endif
                        </td>
                        <td style="text-align: right;">
                            <div class="btn-group" style="justify-content: flex-end;">
                                <a href="{{ route('perusahaan.lowongan.edit', $item) }}" class="btn btn--secondary btn--sm">
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('perusahaan.lowongan.destroy', $item) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus lowongan ini? Tindakan ini tidak dapat dibatalkan.');" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn--danger btn--sm">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="table__empty">
                            Belum ada lowongan pekerjaan yang diposting.
                            <div style="margin-top: 10px;">
                                <a href="{{ route('perusahaan.lowongan.create') }}" class="btn">
                                    + Posting Lowongan Baru Sekarang
                                </a>
                            </div>
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
