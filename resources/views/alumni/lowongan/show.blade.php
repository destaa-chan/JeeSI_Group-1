@extends('layouts.alumni')

@section('title', $lowongan->posisi)

@section('content')

    {{-- UI-003: Halaman Detail Lowongan --}}
    <h1 class="page-title">Detail Lowongan</h1>

    {{-- Detail lowongan --}}
    <section class="panel" aria-labelledby="judul-lowongan">
        <h2 class="panel__title" id="judul-lowongan" style="font-size:15px;">
            {{ $lowongan->posisi }} di {{ $lowongan->perusahaan->nama_perusahaan }}
        </h2>

        <p class="detail-label">Deskripsi</p>
        <p class="detail-text">{{ $lowongan->deskripsi }}</p>

        <p class="detail-label">Kriteria Kandidat</p>
        <p class="detail-text">{{ $lowongan->kriteria_kandidat }}</p>

        <p class="detail-match">
            <span class="badge-match {{ $cocok >= 60 ? 'badge-match--high' : '' }}">Cocok {{ $cocok }}%</span>
            dengan profil Anda
        </p>
    </section>

    {{-- Daftar lowongan --}}
    @if ($sudahMelamar)
        <div class="notice notice--success" role="status">
            Anda sudah melamar lowongan ini. Pantau statusnya di
            <a href="{{ route('alumni.lamaran.index') }}">Lamaran Saya</a>.
        </div>

        <div class="form-actions">
            <a href="{{ route('alumni.dashboard') }}" class="btn btn--outline">Kembali</a>
        </div>
    @elseif (! $alumni)
        <div class="notice notice--danger" role="alert">
            Profil alumni belum lengkap. <a href="{{ route('alumni.profile.edit') }}">Lengkapi profil</a>
            sebelum melamar lowongan ini.
        </div>

        <div class="form-actions">
            <a href="{{ route('alumni.dashboard') }}" class="btn btn--outline">Kembali</a>
        </div>
    @else
        @if ($errors->any())
            <div class="notice notice--danger" role="alert">Pesan error: Data Tidak Lengkap</div>
        @endif

        <form method="POST" action="{{ route('alumni.lowongan.apply', $lowongan) }}" novalidate>
            @csrf

            <section class="panel" aria-labelledby="judul-daftar">
                <div class="panel__head">
                    <h2 class="panel__title" id="judul-daftar">Daftar Lowongan Ini</h2>
                </div>

                <fieldset class="choice-list">
                    <legend class="form-label">Pilih portofolio yang dilampirkan</legend>

                    <label class="choice">
                        <input type="radio" name="id_portofolio" value=""
                               {{ old('id_portofolio') ? '' : 'checked' }}>
                        Tanpa portofolio
                    </label>

                    @foreach ($portofolio as $item)
                        <label class="choice">
                            <input type="radio" name="id_portofolio" value="{{ $item->id_portofolio }}"
                                   {{ (string) old('id_portofolio') === (string) $item->id_portofolio ? 'checked' : '' }}>
                            {{ $item->nama_portofolio }}
                        </label>
                    @endforeach
                </fieldset>

                @error('id_portofolio') <p class="form-error">{{ $message }}</p> @enderror

                @if ($portofolio->isEmpty())
                    <p class="form-hint">
                        Anda belum punya portofolio. <a href="{{ route('alumni.portofolio.index') }}" style="text-decoration:underline;">Tambah portofolio</a>
                    </p>
                @endif

                <div class="form-group" style="margin-top:12px;">
                    <label for="cover_letter" class="form-label">Pesan singkat (cover letter)</label>
                    <textarea id="cover_letter" name="cover_letter" rows="4"
                              class="form-control @error('cover_letter') is-invalid @enderror"
                              placeholder="Perkenalan singkat" required>{{ old('cover_letter') }}</textarea>
                    @error('cover_letter') <p class="form-error">{{ $message }}</p> @enderror
                </div>
            </section>

            <div class="form-actions">
                <a href="{{ route('alumni.dashboard') }}" class="btn btn--outline">Kembali</a>
                <button type="submit" class="btn">Daftar Sekarang</button>
            </div>
        </form>

        <div class="notice notice--success" role="status">
            Setelah daftar: status Terkirim, notifikasi ke perusahaan, lowongan masuk ke Lamaran Saya.
            Jika profil belum lengkap, muncul peringatan.
        </div>
    @endif

@endsection