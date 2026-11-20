@extends('layouts.alumni')

@section('title', 'Lamaran Saya')

@section('content')

    {{-- UI-006: Halaman Riwayat Lamaran Alumni --}}
    <h1 class="page-title">Lamaran Saya</h1>

    @php
        $adaPaginasi = $lamaran instanceof \Illuminate\Contracts\Pagination\Paginator;
        $labelStatus = [
            'terkirim' => 'Terkirim',
            'dilihat'  => 'Dilihat',
            'diundang' => 'Diundang',
            'diterima' => 'Diterima',
            'ditolak'  => 'Ditolak',
        ];
        // Notifikasi: perusahaan yang mengundang alumni untuk sebuah lowongan.
        $undangan = $lamaran->where('status_lamaran', 'diundang');
    @endphp

    {{-- Notifikasi undangan --}}
    @foreach ($undangan as $item)
        <div class="notice notice--success" role="status">
            Notifikasi: {{ $item->lowongan->perusahaan->nama_perusahaan }} mengundang Anda untuk lowongan
            {{ $item->lowongan->posisi }}.
        </div>
    @endforeach

    {{-- Riwayat Pendaftaran --}}
    <section class="panel" aria-labelledby="judul-riwayat">
        <div class="panel__head">
            <h2 class="panel__title" id="judul-riwayat">Riwayat Pendaftaran</h2>
        </div>

        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Posisi</th>
                        <th>Perusahaan</th>
                        <th>Tanggal Daftar</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($lamaran as $item)
                        <tr>
                            <td>{{ $item->lowongan->posisi }}</td>
                            <td>{{ $item->lowongan->perusahaan->nama_perusahaan }}</td>
                            <td>{{ optional($item->created_at)->translatedFormat('d M Y') }}</td>
                            <td>
                                <span class="badge-status badge-status--{{ $item->status_lamaran }}">
                                    {{ $labelStatus[$item->status_lamaran] ?? ucfirst($item->status_lamaran) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="table__empty">
                                Belum ada lamaran. Lihat <a href="{{ route('alumni.dashboard') }}">lowongan terbaru</a>
                                di dashboard.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($adaPaginasi && ($lamaran->previousPageUrl() || $lamaran->nextPageUrl()))
            <div class="pager" style="margin-top:10px;">
                @if ($lamaran->previousPageUrl())
                    <a href="{{ $lamaran->previousPageUrl() }}" class="btn btn--outline">&laquo; Sebelumnya</a>
                @endif
                @if ($lamaran->nextPageUrl())
                    <a href="{{ $lamaran->nextPageUrl() }}" class="btn btn--outline">Berikutnya &raquo;</a>
                @endif
            </div>
        @endif
    </section>

@endsection