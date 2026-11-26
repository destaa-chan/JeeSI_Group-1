@extends('layouts.perusahaan')

@section('title', 'Lamaran Masuk')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Lamaran Masuk</h1>
            <p class="page-subtitle">Kelola dan review berkas lamaran dari alumni yang mendaftar</p>
        </div>
    </div>

    <div class="table-wrap">
        <table class="table">
            <thead>
                <tr>
                    <th>Nama Pelamar</th>
                    <th>Program Studi</th>
                    <th>Posisi yang Dilamar</th>
                    <th>Tanggal Melamar</th>
                    <th>Status Lamaran</th>
                    <th style="text-align: right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($lamaran as $item)
                    <tr>
                        <td>
                            <strong>{{ $item->alumni?->nama_lengkap ?? '-' }}</strong>
                            <div style="font-size: 11px; color: var(--text-muted);">
                                NIM: {{ $item->alumni?->nim ?? '-' }}
                            </div>
                        </td>
                        <td>{{ $item->alumni?->program_studi ?? 'Sistem Informasi' }}</td>
                        <td>
                            <span style="font-weight: 600; color: var(--bitter-cocoa);">
                                {{ $item->lowongan?->posisi ?? '-' }}
                            </span>
                        </td>
                        <td>{{ $item->created_at?->translatedFormat('d M Y') ?? '-' }}</td>
                        <td>
                            @if ($item->status_lamaran === 'terkirim')
                                <span class="badge-status badge-status--terkirim">Terkirim</span>
                            @elseif ($item->status_lamaran === 'dilihat')
                                <span class="badge-status badge-status--dilihat">Dilihat</span>
                            @elseif ($item->status_lamaran === 'diundang')
                                <span class="badge-status badge-status--diundang">Diundang</span>
                            @elseif ($item->status_lamaran === 'diterima')
                                <span class="badge-status badge-status--diterima">Diterima</span>
                            @elseif ($item->status_lamaran === 'ditolak')
                                <span class="badge-status badge-status--ditolak">Ditolak</span>
                            @else
                                <span class="badge-status">{{ $item->status_lamaran }}</span>
                            @endif
                        </td>
                        <td style="text-align: right;">
                            <a href="{{ route('perusahaan.lamaran.show', $item) }}" class="btn btn--sm">
                                Review Pelamar &rarr;
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="table__empty">
                            Belum ada lamaran masuk dari alumni saat ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if (method_exists($lamaran, 'links'))
        <div style="margin-top: 14px;">
            {{ $lamaran->links() }}
        </div>
    @endif
@endsection
