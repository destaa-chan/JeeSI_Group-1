@extends('layouts.perusahaan')

@section('title', $lowongan ? 'Edit Lowongan' : 'Posting Lowongan')

@section('content')

    <div class="page-head">
        <h1 class="page-title">{{ $lowongan ? 'Edit Lowongan' : 'Posting Lowongan' }}</h1>
        <a href="{{ route('perusahaan.lowongan.index') }}" class="btn btn--outline">Kembali</a>
    </div>

    @if (! auth()->user()->perusahaan && ! $lowongan)
        <div class="notice notice--danger" role="alert">
            Profil perusahaan belum lengkap. <a href="{{ route('perusahaan.profile.edit') }}">Lengkapi profil</a>
            terlebih dahulu sebelum memposting lowongan.
        </div>
    @endif

    @if ($errors->any())
        <div class="notice notice--danger" role="alert">
            Data tidak lengkap atau tidak valid. Silakan periksa kembali isian formulir di bawah ini.
        </div>
    @endif

    <form method="POST"
          action="{{ $lowongan ? route('perusahaan.lowongan.update', $lowongan) : route('perusahaan.lowongan.store') }}"
          novalidate>
        @csrf
        @if ($lowongan)
            @method('PUT')
        @endif

        <section class="panel" aria-labelledby="judul-form-lowongan">
            <div class="panel__head">
                <h2 class="panel__title" id="judul-form-lowongan">Detail Lowongan Pekerjaan</h2>
            </div>

            <div class="form-group">
                <label for="posisi" class="form-label">Posisi</label>
                <input type="text" id="posisi" name="posisi"
                       class="form-control @error('posisi') is-invalid @enderror"
                       placeholder="Contoh: Junior Back-End Developer"
                       value="{{ old('posisi', $lowongan?->posisi) }}" required>
                @error('posisi') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label for="deskripsi" class="form-label">Deskripsi Pekerjaan</label>
                <textarea id="deskripsi" name="deskripsi" rows="5"
                          class="form-control @error('deskripsi') is-invalid @enderror"
                          placeholder="Uraikan tanggung jawab dan cakupan pekerjaan" required>{{ old('deskripsi', $lowongan?->deskripsi) }}</textarea>
                @error('deskripsi') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div class="form-group" style="margin-bottom: 0;">
                <label for="kriteria_kandidat" class="form-label">Kriteria Kandidat</label>
                <textarea id="kriteria_kandidat" name="kriteria_kandidat" rows="4"
                          class="form-control @error('kriteria_kandidat') is-invalid @enderror"
                          placeholder="Tuliskan keahlian, kompetensi, atau minat yang dibutuhkan (dipisahkan koma atau kalimat)" required>{{ old('kriteria_kandidat', $lowongan?->kriteria_kandidat) }}</textarea>
                @error('kriteria_kandidat') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <p class="form-hint">
                Lowongan yang baru dikirim atau diperbarui akan berstatus Menunggu Verifikasi hingga disetujui oleh Admin.
            </p>
        </section>

        <div class="form-actions">
            <a href="{{ route('perusahaan.lowongan.index') }}" class="btn btn--outline">Batal</a>
            <button type="submit" class="btn">{{ $lowongan ? 'Simpan Perubahan' : 'Submit Lowongan' }}</button>
        </div>
    </form>

@endsection
