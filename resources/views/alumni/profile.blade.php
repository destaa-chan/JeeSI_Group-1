@extends('layouts.alumni')

@section('title', 'Profil Saya')

@section('content')

    {{-- UI-004: Form Profil Alumni (ACT-002 / SEQ-002) --}}
    <h1 class="page-title">Form Profil Alumni</h1>

    {{-- Pesan error saat validasi gagal (ACT-002: "Data Tidak Lengkap") --}}
    @if ($errors->any())
        <div class="notice notice--danger" role="alert">Pesan error: Data Tidak Lengkap</div>
    @endif

    <form method="POST" action="{{ route('alumni.profile.update') }}" novalidate>
        @csrf
        @method('PUT')

        {{-- Data Diri dan Pendidikan --}}
        <section class="panel" aria-labelledby="judul-data-diri">
            <div class="panel__head">
                <h2 class="panel__title" id="judul-data-diri">Data Diri dan Pendidikan</h2>
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                    <input type="text" id="nama_lengkap" name="nama_lengkap"
                           class="form-control @error('nama_lengkap') is-invalid @enderror"
                           placeholder="Nama lengkap"
                           value="{{ old('nama_lengkap', $alumni?->nama_lengkap ?? auth()->user()->nama_lengkap) }}" required>
                    @error('nama_lengkap') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div class="form-group">
                    <label for="nim" class="form-label">NIM</label>
                    <input type="text" id="nim" name="nim"
                           class="form-control @error('nim') is-invalid @enderror"
                           placeholder="Nomor induk mahasiswa"
                           value="{{ old('nim', $alumni?->nim) }}" required>
                    @error('nim') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div class="form-group">
                    <label for="program_studi" class="form-label">Program Studi</label>
                    <input type="text" id="program_studi" name="program_studi"
                           class="form-control @error('program_studi') is-invalid @enderror"
                           placeholder="Program studi"
                           value="{{ old('program_studi', $alumni?->program_studi) }}" required>
                    @error('program_studi') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div class="form-group">
                    <label for="pendidikan" class="form-label">Pendidikan</label>
                    <input type="text" id="pendidikan" name="pendidikan"
                           class="form-control @error('pendidikan') is-invalid @enderror"
                           placeholder="Jenjang atau riwayat pendidikan"
                           value="{{ old('pendidikan', $alumni?->pendidikan) }}" required>
                    @error('pendidikan') <p class="form-error">{{ $message }}</p> @enderror
                </div>
            </div>
        </section>

        {{-- Kompetensi dan Minat --}}
        <section class="panel" aria-labelledby="judul-kompetensi">
            <div class="panel__head">
                <h2 class="panel__title" id="judul-kompetensi">Kompetensi dan Minat</h2>
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label for="kompetensi" class="form-label">Kompetensi</label>
                    <textarea id="kompetensi" name="kompetensi" rows="5"
                              class="form-control @error('kompetensi') is-invalid @enderror"
                              placeholder="Kompetensi atau keahlian" required>{{ old('kompetensi', $alumni?->kompetensi) }}</textarea>
                    @error('kompetensi') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div class="form-group">
                    <label for="minat_studi" class="form-label">Minat Studi</label>
                    <textarea id="minat_studi" name="minat_studi" rows="5"
                              class="form-control @error('minat_studi') is-invalid @enderror"
                              placeholder="Minat bidang atau studi" required>{{ old('minat_studi', $alumni?->minat_studi) }}</textarea>
                    @error('minat_studi') <p class="form-error">{{ $message }}</p> @enderror
                </div>
            </div>

            <p class="form-hint">Pisahkan tiap kompetensi atau minat dengan koma agar kecocokan dengan lowongan dapat dihitung.</p>
        </section>

        <div class="form-actions">
            <a href="{{ route('alumni.dashboard') }}" class="btn btn--outline">Batal</a>
            <button type="submit" class="btn">Simpan</button>
        </div>
    </form>

@endsection