@extends('layouts.perusahaan')

@section('title', 'Profil Perusahaan')

@section('content')

    <h1 class="page-title">Profil Perusahaan</h1>

    @if ($errors->any())
        <div class="notice notice--danger" role="alert">
            Terdapat data yang belum valid. Silakan periksa kembali isian formulir di bawah ini.
        </div>
    @endif

    <form method="POST" action="{{ route('perusahaan.profile.update') }}" novalidate>
        @csrf
        @method('PUT')

        <section class="panel" aria-labelledby="judul-identitas">
            <div class="panel__head">
                <h2 class="panel__title" id="judul-identitas">Informasi Perusahaan</h2>
            </div>

            <div class="form-group">
                <label for="nama_perusahaan" class="form-label">Nama Perusahaan</label>
                <input type="text" id="nama_perusahaan" name="nama_perusahaan"
                       class="form-control @error('nama_perusahaan') is-invalid @enderror"
                       placeholder="Contoh: PT Tech Innovate Indonesia"
                       value="{{ old('nama_perusahaan', $perusahaan?->nama_perusahaan) }}" required>
                @error('nama_perusahaan') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label for="alamat" class="form-label">Alamat</label>
                <textarea id="alamat" name="alamat" rows="3"
                          class="form-control @error('alamat') is-invalid @enderror"
                          placeholder="Alamat lengkap kantor perusahaan" required>{{ old('alamat', $perusahaan?->alamat) }}</textarea>
                @error('alamat') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div class="form-group" style="margin-bottom: 0;">
                <label for="deskripsi" class="form-label">Deskripsi Perusahaan</label>
                <textarea id="deskripsi" name="deskripsi" rows="5"
                          class="form-control @error('deskripsi') is-invalid @enderror"
                          placeholder="Gambaran singkat bidang usaha dan profil perusahaan" required>{{ old('deskripsi', $perusahaan?->deskripsi) }}</textarea>
                @error('deskripsi') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <p class="form-hint">Profil perusahaan yang lengkap diperlukan sebelum memposting lowongan pekerjaan.</p>
        </section>

        <div class="form-actions">
            <a href="{{ route('perusahaan.dashboard') }}" class="btn btn--outline">Batal</a>
            <button type="submit" class="btn">Simpan</button>
        </div>
    </form>

@endsection
