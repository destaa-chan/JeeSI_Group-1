@extends('layouts.perusahaan')

@section('title', 'Review Pelamar - ' . ($lamaran->alumni?->nama_lengkap ?? 'Alumni'))

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Review Pelamar</h1>
            <p class="page-subtitle">Detail berkas lamaran dan portofolio alumni pelamar</p>
        </div>
        <div>
            <a href="{{ route('perusahaan.lamaran.index') }}" class="btn btn--outline">
                &larr; Kembali ke Daftar Lamaran
            </a>
        </div>
    </div>

    <div class="grid-2col">
        {{-- Kolom Kiri: Profil & Portofolio Pelamar --}}
        <div>
            {{-- Data Diri Pelamar --}}
            <div class="detail-card">
                <h2 class="detail-card__title">Data Diri Pelamar</h2>
                <div class="detail-list">
                    <div class="detail-item">
                        <span class="detail-label">Nama Lengkap</span>
                        <span class="detail-value"><strong>{{ $lamaran->alumni?->nama_lengkap ?? '-' }}</strong></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">NIM</span>
                        <span class="detail-value">{{ $lamaran->alumni?->nim ?? '-' }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Program Studi</span>
                        <span class="detail-value">{{ $lamaran->alumni?->program_studi ?? 'Sistem Informasi' }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Email Kontak</span>
                        <span class="detail-value">{{ $lamaran->alumni?->user?->email ?? '-' }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Kompetensi / Skill</span>
                        <span class="detail-value">{{ $lamaran->alumni?->kompetensi ?? '-' }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Minat Studi</span>
                        <span class="detail-value">{{ $lamaran->alumni?->minat_studi ?? '-' }}</span>
                    </div>
                </div>
            </div>

            {{-- Cover Letter / Surat Lamaran --}}
            <div class="detail-card">
                <h2 class="detail-card__title">Surat Lamaran (Cover Letter)</h2>
                @if ($lamaran->cover_letter)
                    <div class="prose">{{ $lamaran->cover_letter }}</div>
                @else
                    <p style="color: var(--text-muted); font-size: 12px; margin: 0;">
                        Tidak ada surat lamaran yang dilampirkan.
                    </p>
                @endif
            </div>

            {{-- Berkas Portofolio --}}
            <div class="detail-card">
                <h2 class="detail-card__title">Portofolio & Riwayat Karya</h2>
                @if ($lamaran->alumni?->portofolio && $lamaran->alumni->portofolio->isNotEmpty())
                    <ul style="margin: 0; padding-left: 20px; font-size: 12px; display: grid; gap: 8px;">
                        @foreach ($lamaran->alumni->portofolio as $portofolio)
                            <li>
                                <strong>{{ $portofolio->nama_portofolio }}</strong>
                                @if ($portofolio->deskripsi)
                                    <div style="color: var(--text-muted); font-size: 11px;">
                                        {{ $portofolio->deskripsi }}
                                    </div>
                                @endif
                                @if ($portofolio->file_portofolio)
                                    <div style="margin-top: 2px;">
                                        <a href="{{ Storage::disk('public')->url($portofolio->file_portofolio) }}" target="_blank" rel="noopener noreferrer" style="color: var(--wine-cherry); font-size: 11px; text-decoration: underline;">
                                            &DownArrowBar; Buka / Unduh File Portofolio
                                        </a>
                                    </div>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p style="color: var(--text-muted); font-size: 12px; margin: 0;">
                        Alumni belum mengunggah portofolio tambahan.
                    </p>
                @endif
            </div>
        </div>

        {{-- Kolom Kanan: Lowongan & Form Update Status --}}
        <div>
            {{-- Info Lowongan --}}
            <div class="detail-card">
                <h2 class="detail-card__title">Lowongan yang Dilamar</h2>
                <div class="detail-list">
                    <div class="detail-item">
                        <span class="detail-label">Posisi</span>
                        <span class="detail-value"><strong>{{ $lamaran->lowongan?->posisi ?? '-' }}</strong></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Tanggal Lamar</span>
                        <span class="detail-value">{{ $lamaran->created_at?->translatedFormat('d F Y H:i') ?? '-' }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Status Saat Ini</span>
                        <span class="detail-value">
                            @if ($lamaran->status_lamaran === 'terkirim')
                                <span class="badge-status badge-status--terkirim">Terkirim</span>
                            @elseif ($lamaran->status_lamaran === 'dilihat')
                                <span class="badge-status badge-status--dilihat">Dilihat</span>
                            @elseif ($lamaran->status_lamaran === 'diundang')
                                <span class="badge-status badge-status--diundang">Diundang</span>
                            @elseif ($lamaran->status_lamaran === 'diterima')
                                <span class="badge-status badge-status--diterima">Diterima</span>
                            @elseif ($lamaran->status_lamaran === 'ditolak')
                                <span class="badge-status badge-status--ditolak">Ditolak</span>
                            @else
                                <span class="badge-status">{{ $lamaran->status_lamaran }}</span>
                            @endif
                        </span>
                    </div>
                </div>
            </div>

            {{-- Form Perbarui Status Lamaran (UI-007) --}}
            <div class="detail-card" style="border: 2px solid var(--border-strong);">
                <h2 class="detail-card__title">Tindakan Rekrutmen</h2>
                <p style="font-size: 11px; color: var(--text-muted); margin: 0 0 12px;">
                    Perbarui tahapan status lamaran untuk memberikan respons resmi kepada alumni pelamar.
                </p>

                <form method="POST" action="{{ route('perusahaan.lamaran.status', $lamaran) }}">
                    @csrf
                    @method('PATCH')

                    <div class="form-group">
                        <label for="status_lamaran" class="form-label">
                            Pilih Status Baru <span class="required">*</span>
                        </label>
                        <select name="status_lamaran" id="status_lamaran" class="form-control" required>
                            <option value="dilihat" @selected($lamaran->status_lamaran === 'dilihat')>
                                Dilihat (Berkas sedang ditinjau)
                            </option>
                            <option value="diundang" @selected($lamaran->status_lamaran === 'diundang')>
                                Diundang (Undang untuk tes / wawancara)
                            </option>
                            <option value="diterima" @selected($lamaran->status_lamaran === 'diterima')>
                                Diterima (Lolos seleksi pekerjaan)
                            </option>
                            <option value="ditolak" @selected($lamaran->status_lamaran === 'ditolak')>
                                Ditolak (Belum memenuhi kualifikasi)
                            </option>
                        </select>
                    </div>

                    <button type="submit" class="btn" style="width: 100%;">
                        Simpan Perubahan Status
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
