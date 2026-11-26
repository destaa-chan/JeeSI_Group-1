@extends('layouts.perusahaan')

@section('title', 'Lamaran Masuk')

@section('content')

    @php
        $adaPaginasi = $lamaran instanceof \Illuminate\Contracts\Pagination\Paginator;
        $labelStatus = [
            'terkirim' => 'Terkirim',
            'dilihat'  => 'Dilihat',
            'diundang' => 'Diundang',
            'diterima' => 'Diterima',
            'ditolak'  => 'Ditolak',
        ];
    @endphp

    <h1 class="page-title">Lamaran Masuk</h1>

    <section class="panel" aria-labelledby="judul-lamaran-masuk">
        <div class="panel__head">
            <h2 class="panel__title" id="judul-lamaran-masuk">Daftar Pelamar</h2>
        </div>

        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama Pelamar</th>
                        <th>Program Studi</th>
                        <th>Lowongan</th>
                        <th>Tanggal Daftar</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($lamaran as $item)
                        <tr>
                            <td><strong>{{ $item->alumni->nama_lengkap ?? '-' }}</strong></td>
                            <td>{{ $item->alumni->program_studi ?? '-' }}</td>
                            <td>{{ $item->lowongan->posisi ?? '-' }}</td>
                            <td>{{ optional($item->created_at)->translatedFormat('d M Y') ?? '-' }}</td>
                            <td>
                                <span class="badge-status badge-status--{{ $item->status_lamaran }}">
                                    {{ $labelStatus[$item->status_lamaran] ?? ucfirst($item->status_lamaran) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('perusahaan.lamaran.show', $item) }}">Lihat Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="table__empty">Belum ada lamaran masuk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($adaPaginasi && ($lamaran->previousPageUrl() || $lamaran->nextPageUrl()))
            <div class="pager">
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
