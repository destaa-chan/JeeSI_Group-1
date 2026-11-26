@extends('layouts.perusahaan')

@section('title', 'Kelola Lowongan')

@section('content')

    @php
        $adaPaginasi = $lowongan instanceof \Illuminate\Contracts\Pagination\Paginator;
        $labelVerifikasi = [
            'pending'  => 'Menunggu Verifikasi',
            'approved' => 'Published',
            'rejected' => 'Ditolak',
        ];
    @endphp

    <div class="page-head">
        <h1 class="page-title">Kelola Lowongan</h1>
        <a href="{{ route('perusahaan.lowongan.create') }}" class="btn">+ Posting Lowongan</a>
    </div>

    @if (! auth()->user()->perusahaan)
        <div class="notice notice--danger" role="alert">
            Profil perusahaan belum lengkap. <a href="{{ route('perusahaan.profile.edit') }}">Lengkapi profil</a>
            terlebih dahulu sebelum memposting lowongan.
        </div>
    @endif

    <section class="panel" aria-labelledby="judul-daftar-lowongan">
        <div class="panel__head">
            <h2 class="panel__title" id="judul-daftar-lowongan">Daftar Lowongan Perusahaan</h2>
        </div>

        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Posisi</th>
                        <th>Kriteria Kandidat</th>
                        <th>Status Verifikasi</th>
                        <th>Catatan Admin</th>
                        <th>Tanggal Posting</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($lowongan as $item)
                        <tr>
                            <td><strong>{{ $item->posisi }}</strong></td>
                            <td>{{ \Illuminate\Support\Str::limit($item->kriteria_kandidat, 80) }}</td>
                            <td>
                                <span class="badge-status badge-status--{{ $item->status_verifikasi }}">
                                    {{ $labelVerifikasi[$item->status_verifikasi] ?? ucfirst($item->status_verifikasi) }}
                                </span>
                            </td>
                            <td>{{ $item->catatan_admin ?: '-' }}</td>
                            <td>{{ optional($item->created_at)->translatedFormat('d M Y') ?? '-' }}</td>
                            <td>
                                <div class="table__actions">
                                    <a href="{{ route('perusahaan.lowongan.edit', $item) }}">Edit</a>

                                    <form method="POST" action="{{ route('perusahaan.lowongan.destroy', $item) }}"
                                          onsubmit="return confirm('Yakin ingin menghapus lowongan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="link-danger">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="table__empty">
                                Belum ada lowongan. <a href="{{ route('perusahaan.lowongan.create') }}">Posting lowongan pertama Anda</a>.
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
