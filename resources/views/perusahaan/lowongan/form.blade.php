@extends('layouts.perusahaan')

@section('title', $lowongan ? 'Edit Lowongan' : 'Posting Lowongan Baru')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">{{ $lowongan ? 'Edit Lowongan' : 'Posting Lowongan Baru' }}</h1>
            <p class="page-subtitle">
                {{ $lowongan ? 'Perbarui informasi lowongan kerja. Perubahan akan dikirim ulang untuk diverifikasi oleh admin.' : 'Publikasikan lowongan kerja untuk alumni Program Studi Sistem Informasi.' }}
            </p>
        </div>
        <div>
            <a href="{{ route('perusahaan.lowongan.index') }}" class="btn btn--outline">
                &larr; Kembali ke Kelola Lowongan
            </a>
        </div>
    </div>

    @if ($lowongan && $lowongan->status_verifikasi === 'rejected' && $lowongan->catatan_admin)
        <div class="notice notice--danger">
            <strong>Catatan Penolakan Sebelumnya dari Admin:</strong> {{ $lowongan->catatan_admin }}
            <div style="font-size: 11px; margin-top: 4px;">
                Silakan perbaiki data lowongan di bawah ini agar memenuhi kriteria verifikasi admin.
            </div>
        </div>
    @endif

    <div class="form-card">
        <form method="POST" action="{{ $lowongan ? route('perusahaan.lowongan.update', $lowongan) : route('perusahaan.lowongan.store') }}">
            @csrf
            @if ($lowongan)
                @method('PUT')
            @endif

            <div class="form-group">
                <label for="posisi" class="form-label">
                    Posisi Pekerjaan <span class="required">*</span>
                </label>
                <input
                    type="text"
                    id="posisi"
                    name="posisi"
                    class="form-control @error('posisi') is-invalid @enderror"
                    placeholder="Contoh: Junior System Analyst, Web Developer, Database Administrator"
                    value="{{ old('posisi', $lowongan?->posisi) }}"
                    required
                >
                @error('posisi')
                    <p class="form-error">{{ $message }}</p>
                @enderror
                <p class="form-hint">Tuliskan nama jabatan posisi secara jelas.</p>
            </div>

            <div class="form-group">
                <label for="deskripsi" class="form-label">
                    Deskripsi Pekerjaan <span class="required">*</span>
                </label>
                <textarea
                    id="deskripsi"
                    name="deskripsi"
                    rows="6"
                    class="form-control @error('deskripsi') is-invalid @enderror"
                    placeholder="Tuliskan tugas dan tanggung jawab utama, lingkup kerja, benefit, serta lokasi kerja..."
                    required
                >{{ old('deskripsi', $lowongan?->deskripsi) }}</textarea>
                @error('deskripsi')
                    <p class="form-error">{{ $message }}</p>
                @enderror
                <p class="form-hint">Jelaskan rincian pekerjaan secara transparan dan detail.</p>
            </div>

            <div class="form-group">
                <label for="kriteria_kandidat" class="form-label">
                    Kriteria & Kualifikasi Kandidat <span class="required">*</span>
                </label>
                <textarea
                    id="kriteria_kandidat"
                    name="kriteria_kandidat"
                    rows="6"
                    class="form-control @error('kriteria_kandidat') is-invalid @enderror"
                    placeholder="Contoh:&#10;- Lulusan S1 Sistem Informasi atau Informatika&#10;- Menguasai PHP Laravel & MySQL&#10;- Mampu menganalisis kebutuhan sistem bisnis&#10;- Memiliki komunikasi dan kerja sama tim yang baik"
                    required
                >{{ old('kriteria_kandidat', $lowongan?->kriteria_kandidat) }}</textarea>
                @error('kriteria_kandidat')
                    <p class="form-error">{{ $message }}</p>
                @enderror
                <p class="form-hint">Sistem akan mencocokkan kompetensi profil alumni dengan kriteria yang Anda tuliskan.</p>
            </div>

            <div class="notice notice--muted" style="margin-top: 20px;">
                <strong>Kebijakan Verifikasi SDD JeeSI (UI-009):</strong>
                Admin akan memverifikasi lowongan ini berdasarkan:
                (1) Keabsahan profil perusahaan,
                (2) Kejelasan deskripsi pekerjaan bebas dari penipuan,
                (3) Relevansi dengan bidang lulusan Sistem Informasi.
            </div>

            <div class="form-actions">
                <a href="{{ route('perusahaan.lowongan.index') }}" class="btn btn--outline">
                    Batal
                </a>
                <button type="submit" class="btn">
                    {{ $lowongan ? 'Simpan & Ajukan Ulang Verifikasi' : 'Kirim Lowongan untuk Verifikasi' }}
                </button>
            </div>
        </form>
    </div>
@endsection
