@extends('layouts.admin')

@section('title', 'Verifikasi Lowongan')

@section('content')

    @php
        $adaPaginasi = $lowongan instanceof \Illuminate\Contracts\Pagination\Paginator;
        $labelStatus = [
            'pending'  => 'Menunggu Verifikasi',
            'approved' => 'Published',
            'rejected' => 'Ditolak',
        ];
    @endphp

    <div class="page-head">
        <h1 class="page-title">Verifikasi Lowongan</h1>
        <a href="{{ route('admin.dashboard') }}" class="btn btn--outline">Kembali ke Dashboard</a>
    </div>

    {{-- Tab filter status verifikasi --}}
    <nav class="tabs" aria-label="Filter status verifikasi">
        <a href="{{ route('admin.verifikasi.index', ['status' => 'pending']) }}"
           class="tab {{ $status === 'pending' ? 'is-active' : '' }}">
            Menunggu
        </a>
        <a href="{{ route('admin.verifikasi.index', ['status' => 'approved']) }}"
           class="tab {{ $status === 'approved' ? 'is-active' : '' }}">
            Disetujui (Published)
        </a>
        <a href="{{ route('admin.verifikasi.index', ['status' => 'rejected']) }}"
           class="tab {{ $status === 'rejected' ? 'is-active' : '' }}">
            Ditolak
        </a>
    </nav>

    <section class="panel" aria-labelledby="judul-daftar-verifikasi">
        <div class="panel__head">
            <h2 class="panel__title" id="judul-daftar-verifikasi">
                Daftar Lowongan &mdash; {{ $labelStatus[$status] ?? ucfirst($status) }}
            </h2>
        </div>

        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Posisi</th>
                        <th>Perusahaan</th>
                        <th>Kriteria Kandidat</th>
                        <th>Tanggal Posting</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($lowongan as $item)
                        <tr>
                            <td><strong>{{ $item->posisi }}</strong></td>
                            <td>{{ $item->perusahaan->nama_perusahaan ?? '-' }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($item->kriteria_kandidat, 80) }}</td>
                            <td>{{ optional($item->created_at)->translatedFormat('d M Y') ?? '-' }}</td>
                            <td>
                                <span class="badge-status badge-status--{{ $item->status_verifikasi }}">
                                    {{ $labelStatus[$item->status_verifikasi] ?? ucfirst($item->status_verifikasi) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.verifikasi.show', $item) }}" class="btn btn--sm {{ $item->status_verifikasi === 'pending' ? '' : 'btn--outline' }}" style="{{ $item->status_verifikasi === 'pending' ? 'color:#fff;' : '' }}">
                                    {{ $item->status_verifikasi === 'pending' ? 'Tinjau' : 'Detail' }}
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="table__empty">
                                Tidak ada lowongan dengan status {{ strtolower($labelStatus[$status] ?? $status) }}.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($adaPaginasi && ($lowongan->previousPageUrl() || $lowongan->nextPageUrl()))
            <div class="pager">
                @if ($lowongan->previousPageUrl())
                    <a href="{{ $lowongan->previousPageUrl() }}" class="btn btn--outline">&laquo; Sebelumnya</a>
                @endif
                @if ($lowongan->nextPageUrl())
                    <a href="{{ $lowongan->nextPageUrl() }}" class="btn btn--outline">Berikutnya &raquo;</a>
                @endif
            </div>
        @endif
    </section>

@endsection
