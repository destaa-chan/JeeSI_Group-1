@extends('layouts.perusahaan')

@section('title', 'Profil Perusahaan')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Profil Perusahaan</h1>
            <p class="page-subtitle">Informasi profil instansi atau perusahaan mitra JeeSI</p>
        </div>
    </div>

    <div class="form-card">
        <form method="POST" action="{{ route('perusahaan.profile.update') }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="form-label">Email Akun Pengguna</label>
                <input
                    type="email"
                    class="form-control"
                    value="{{ auth()->user()->email }}"
                    disabled
                    style="background-color: var(--bg-surface); cursor: not-allowed;"
                >
                <p class="form-hint">Email akun terhubung dengan sistem autentikasi.</p>
            </div>

            <div class="form-group">
                <label for="nama_perusahaan" class="form-label">
                    Nama Perusahaan / Instansi <span class="required">*</span>
                </label>
                <input
                    type="text"
                    id="nama_perusahaan"
                    name="nama_perusahaan"
                    class="form-control @error('nama_perusahaan') is-invalid @enderror"
                    value="{{ old('nama_perusahaan', $perusahaan?->nama_perusahaan) }}"
                    placeholder="Contoh: PT Inovasi Solusi Informatika"
                    required
                >
                @error('nama_perusahaan')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="alamat" class="form-label">
                    Alamat Kantor <span class="required">*</span>
                </label>
                <textarea
                    id="alamat"
                    name="alamat"
                    rows="3"
                    class="form-control @error('alamat') is-invalid @enderror"
                    placeholder="Contoh: Gedung Cyber 2 Lantai 15, Jl. H.R. Rasuna Said, Jakarta Selatan"
                    required
                >{{ old('alamat', $perusahaan?->alamat) }}</textarea>
                @error('alamat')
                    <p class="form-error">{{ $message }}</p>
                @enderror
                <p class="form-hint">Admin akan memverifikasi keabsahan domisili kantor perusahaan.</p>
            </div>

            <div class="form-group">
                <label for="deskripsi" class="form-label">
                    Profil Singkat & Bidang Usaha <span class="required">*</span>
                </label>
                <textarea
                    id="deskripsi"
                    name="deskripsi"
                    rows="5"
                    class="form-control @error('deskripsi') is-invalid @enderror"
                    placeholder="Deskripsikan profil bisnis perusahaan, produk/layanan teknologi, budaya kerja, serta visi perusahaan..."
                    required
                >{{ old('deskripsi', $perusahaan?->deskripsi) }}</textarea>
                @error('deskripsi')
                    <p class="form-error">{{ $message }}</p>
                @enderror
                <p class="form-hint">Informasi ini akan ditampilkan kepada alumni ketika melihat lowongan pekerjaan Anda.</p>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn">
                    Simpan Profil Perusahaan
                </button>
            </div>
        </form>
    </div>
@endsection
