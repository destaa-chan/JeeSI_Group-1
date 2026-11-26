@extends('layouts.admin')

@section('title', 'Detail Verifikasi Lowongan')

@section('content')

    @php
        $labelStatus = [
            'pending'  => 'Menunggu Verifikasi',
            'approved' => 'Published',
            'rejected' => 'Ditolak',
        ];
    @endphp

    <div class="page-head">
        <h1 class="page-title">Detail Verifikasi Lowongan</h1>
        <a href="{{ route('admin.verifikasi.index', ['status' => $lowongan->status_verifikasi]) }}" class="btn btn--outline">
            Kembali
        </a>
    </div>

    {{-- Informasi Lowongan & Perusahaan --}}
    <section class="panel" aria-labelledby="judul-detail-lowongan">
        <div class="panel__head">
            <h2 class="panel__title" id="judul-detail-lowongan" style="font-size:15px;">
                {{ $lowongan->posisi }}
            </h2>
            <span class="badge-status badge-status--{{ $lowongan->status_verifikasi }}">
                {{ $labelStatus[$lowongan->status_verifikasi] ?? ucfirst($lowongan->status_verifikasi) }}
            </span>
        </div>

        <div class="detail-grid">
            <div>
                <p class="detail-label">Nama Perusahaan</p>
                <p class="detail-text">{{ $lowongan->perusahaan->nama_perusahaan ?? '-' }}</p>

                <p class="detail-label">Email Akun Perusahaan</p>
                <p class="detail-text">{{ $lowongan->perusahaan->user->email ?? '-' }}</p>

                <p class="detail-label">Alamat Perusahaan</p>
                <p class="detail-text">{{ $lowongan->perusahaan->alamat ?? '-' }}</p>
            </div>

            <div>
                <p class="detail-label">Tanggal Diposting</p>
                <p class="detail-text">{{ optional($lowongan->created_at)->translatedFormat('d M Y H:i') ?? '-' }}</p>

                <p class="detail-label">Deskripsi Perusahaan</p>
                <p class="detail-text">{{ $lowongan->perusahaan->deskripsi ?? '-' }}</p>
            </div>
        </div>

        <p class="detail-label">Deskripsi Pekerjaan</p>
        <p class="detail-text">{{ $lowongan->deskripsi }}</p>

        <p class="detail-label">Kriteria Kandidat</p>
        <p class="detail-text">{{ $lowongan->kriteria_kandidat }}</p>

        @if ($lowongan->catatan_admin)
            <p class="detail-label">Catatan Admin</p>
            <p class="detail-text">{{ $lowongan->catatan_admin }}</p>
        @endif
    </section>

    {{-- Aksi Verifikasi Admin (SEQ-003 / UI-009) --}}
    @if ($lowongan->status_verifikasi === 'pending')
        @if ($errors->any())
            <div class="notice notice--danger" role="alert">
                {{ $errors->first('catatan_admin') }}
            </div>
        @endif

        <div class="verify-grid">
            {{-- Form Setujui --}}
            <section class="panel" aria-labelledby="judul-setujui">
                <div class="panel__head">
                    <h2 class="panel__title" id="judul-setujui">Setujui Lowongan</h2>
                </div>

                <form method="POST" action="{{ route('admin.verifikasi.setujui', $lowongan) }}">
                    @csrf
                    @method('PATCH')

                    <div class="form-group">
                        <label for="catatan_setujui" class="form-label">Catatan Admin (Opsional)</label>
                        <textarea id="catatan_setujui" name="catatan_admin" rows="3"
                                  class="form-control"
                                  placeholder="Catatan tambahan untuk perusahaan jika ada">{{ old('catatan_admin') }}</textarea>
                    </div>

                    <button type="submit" class="btn btn--success">Setujui &amp; Publikasikan</button>
                </form>
            </section>

            {{-- Form Tolak --}}
            <section class="panel" aria-labelledby="judul-tolak">
                <div class="panel__head">
                    <h2 class="panel__title" id="judul-tolak">Tolak Lowongan</h2>
                </div>

                <form method="POST" action="{{ route('admin.verifikasi.tolak', $lowongan) }}">
                    @csrf
                    @method('PATCH')

                    <div class="form-group">
                        <label for="catatan_tolak" class="form-label">Alasan Penolakan (Wajib)</label>
                        <textarea id="catatan_tolak" name="catatan_admin" rows="3"
                                  class="form-control @error('catatan_admin') is-invalid @enderror"
                                  placeholder="Jelaskan alasan penolakan agar perusahaan dapat memperbaikinya" required>{{ old('catatan_admin') }}</textarea>
                        @error('catatan_admin') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    <button type="submit" class="btn btn--danger">Tolak Lowongan</button>
                </form>
            </section>
        </div>
    @else
        <div class="notice notice--muted" role="status">
            Lowongan ini sudah diverifikasi dengan status
            <strong>{{ $labelStatus[$lowongan->status_verifikasi] ?? ucfirst($lowongan->status_verifikasi) }}</strong>.
        </div>
    @endif

@endsection
