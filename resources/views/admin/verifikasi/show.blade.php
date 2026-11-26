@extends('layouts.admin')

@section('title', 'Review Lowongan: ' . $lowongan->posisi)

@section('content')
    <div style="display: flex; align-items: center; justify-content: space-between; gap: 14px; margin-bottom: 14px; flex-wrap: wrap;">
        <div>
            <h1 class="page-title" style="margin: 0;">Review Verifikasi Lowongan</h1>
            <p style="margin: 4px 0 0; font-size: 12px; color: var(--text-muted);">
                Validasi kesesuaian lowongan kerja sebelum dipublikasikan kepada alumni JeeSI
            </p>
        </div>
        <div>
            <a href="{{ route('admin.verifikasi.index', ['status' => $lowongan->status_verifikasi]) }}" class="btn btn--outline btn--sm">
                &larr; Kembali ke Daftar
            </a>
        </div>
    </div>

    @if ($lowongan->status_verifikasi === 'approved')
        <div class="notice notice--success">
            <strong>Status: Disetujui (Published).</strong> Lowongan ini telah disetujui dan saat ini dapat dilihat dan dilamar oleh seluruh alumni.
            @if ($lowongan->catatan_admin)
                <div style="margin-top: 4px; font-size: 11px;">Catatan Admin: {{ $lowongan->catatan_admin }}</div>
            @endif
        </div>
    @elseif ($lowongan->status_verifikasi === 'rejected')
        <div class="notice notice--danger">
            <strong>Status: Ditolak.</strong> Lowongan ini telah ditolak oleh admin dan tidak dipublikasikan ke alumni.
            @if ($lowongan->catatan_admin)
                <div style="margin-top: 4px; font-size: 11px;">Alasan Penolakan: {{ $lowongan->catatan_admin }}</div>
            @endif
        </div>
    @else
        <div class="notice notice--warning">
            <strong>Status: Menunggu Verifikasi.</strong> Silakan periksa kriteria kelayakan lowongan di bawah ini sebelum menyetujui atau menolak.
        </div>
    @endif

    <div class="grid-2col">
        {{-- Kolom Kiri: Detail Lowongan & Profil Perusahaan --}}
        <div>
            {{-- Detail Lowongan --}}
            <div class="detail-card">
                <h2 class="detail-card__title">Informasi Lowongan Pekerjaan</h2>
                <div class="detail-list">
                    <div class="detail-item">
                        <span class="detail-label">Posisi Jabatan</span>
                        <span class="detail-value"><strong>{{ $lowongan->posisi }}</strong></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Tanggal Pengajuan</span>
                        <span class="detail-value">{{ $lowongan->created_at?->translatedFormat('d F Y H:i') ?? '-' }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Status Saat Ini</span>
                        <span class="detail-value">
                            @if ($lowongan->status_verifikasi === 'pending')
                                <span class="badge-status badge-status--pending">Menunggu Verifikasi</span>
                            @elseif ($lowongan->status_verifikasi === 'approved')
                                <span class="badge-status badge-status--approved">Published</span>
                            @elseif ($lowongan->status_verifikasi === 'rejected')
                                <span class="badge-status badge-status--rejected">Ditolak</span>
                            @else
                                <span class="badge-status">{{ $lowongan->status_verifikasi }}</span>
                            @endif
                        </span>
                    </div>
                </div>

                <div style="margin-top: 14px;">
                    <div class="detail-label" style="margin-bottom: 4px;">Deskripsi Pekerjaan:</div>
                    <div class="prose" style="background: var(--bg-surface); padding: 10px 12px; border-radius: var(--radius); border: 1px solid var(--border);">
                        {{ $lowongan->deskripsi }}
                    </div>
                </div>

                <div style="margin-top: 14px;">
                    <div class="detail-label" style="margin-bottom: 4px;">Kriteria & Kualifikasi Kandidat:</div>
                    <div class="prose" style="background: var(--bg-surface); padding: 10px 12px; border-radius: var(--radius); border: 1px solid var(--border);">
                        {{ $lowongan->kriteria_kandidat }}
                    </div>
                </div>
            </div>

            {{-- Profil Perusahaan Pengaju --}}
            <div class="detail-card">
                <h2 class="detail-card__title">Data Perusahaan Pengaju</h2>
                <div class="detail-list">
                    <div class="detail-item">
                        <span class="detail-label">Nama Perusahaan</span>
                        <span class="detail-value"><strong>{{ $lowongan->perusahaan?->nama_perusahaan ?? '-' }}</strong></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Email Akun</span>
                        <span class="detail-value">{{ $lowongan->perusahaan?->user?->email ?? '-' }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Alamat Kantor</span>
                        <span class="detail-value">{{ $lowongan->perusahaan?->alamat ?? '-' }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Profil Perusahaan</span>
                        <span class="detail-value prose">{{ $lowongan->perusahaan?->deskripsi ?? '-' }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Checklist Kelayakan & Form Aksi --}}
        <div>
            {{-- Checklist Kriteria Verifikasi (SDD UI-009) --}}
            <div class="checklist-box">
                <h3 class="checklist-title">Checklist Verifikasi Kelayakan (SDD UI-009)</h3>
                <p class="checklist-desc">
                    Pastikan hal-hal berikut telah terpenuhi sebelum memberikan persetujuan:
                </p>
                <div class="checklist-items">
                    <label class="checklist-label">
                        <input type="checkbox" id="check-sah" checked>
                        <span>
                            <strong>Informasi Perusahaan Sah</strong><br>
                            <span style="font-size: 11px; color: var(--text-muted);">Nama perusahaan, domisili kantor, dan identitas pengaju valid.</span>
                        </span>
                    </label>

                    <label class="checklist-label">
                        <input type="checkbox" id="check-aman" checked>
                        <span>
                            <strong>Deskripsi Pekerjaan Aman & Jelas</strong><br>
                            <span style="font-size: 11px; color: var(--text-muted);">Bukan penipuan, skema MLM, atau memungut biaya registrasi kerja.</span>
                        </span>
                    </label>

                    <label class="checklist-label">
                        <input type="checkbox" id="check-relevan" checked>
                        <span>
                            <strong>Relevan dengan Lulusan Sistem Informasi</strong><br>
                            <span style="font-size: 11px; color: var(--text-muted);">Sesuai profil kompetensi IT, analisis sistem, data, atau manajemen SI.</span>
                        </span>
                    </label>
                </div>
            </div>

            {{-- Form Keputusan Verifikasi --}}
            @if ($lowongan->status_verifikasi === 'pending')
                {{-- Opsi 1: Setujui Lowongan --}}
                <div class="detail-card" style="border: 2px solid var(--success-border);">
                    <h3 style="margin: 0 0 8px; font-size: 13px; font-weight: 700; color: var(--success-text);">
                        &check; Setujui Lowongan (Published)
                    </h3>
                    <p style="font-size: 11px; color: var(--text-muted); margin: 0 0 10px;">
                        Status lowongan akan diubah menjadi Published dan langsung tampil di halaman lowongan alumni.
                    </p>

                    <form method="POST" action="{{ route('admin.verifikasi.setujui', $lowongan) }}">
                        @csrf
                        @method('PATCH')

                        <div class="form-group">
                            <label for="catatan_setujui" class="form-label" style="font-size: 11px;">
                                Catatan Admin (Opsional):
                            </label>
                            <input
                                type="text"
                                id="catatan_setujui"
                                name="catatan_admin"
                                class="form-control"
                                placeholder="Contoh: Disetujui, sesuai standar SI"
                                value="{{ old('catatan_admin') }}"
                            >
                        </div>

                        <button type="submit" class="btn btn--success" style="width: 100%;">
                            &check; Setujui & Publikasikan Lowongan
                        </button>
                    </form>
                </div>

                {{-- Opsi 2: Tolak Lowongan --}}
                <div class="detail-card" style="border: 2px solid var(--danger-border); margin-top: 14px;">
                    <h3 style="margin: 0 0 8px; font-size: 13px; font-weight: 700; color: var(--cherry-red);">
                        &cross; Tolak Lowongan
                    </h3>
                    <p style="font-size: 11px; color: var(--text-muted); margin: 0 0 10px;">
                        Tolak lowongan jika tidak memenuhi kriteria. Perusahaan akan melihat alasan penolakan untuk diperbaiki.
                    </p>

                    <form method="POST" action="{{ route('admin.verifikasi.tolak', $lowongan) }}" onsubmit="return confirm('Apakah Anda yakin ingin menolak lowongan ini?');">
                        @csrf
                        @method('PATCH')

                        <div class="form-group">
                            <label for="catatan_admin" class="form-label" style="font-size: 11px;">
                                Alasan Penolakan <span style="color: var(--cherry-red);">*</span>
                            </label>
                            <textarea
                                id="catatan_admin"
                                name="catatan_admin"
                                class="form-control @error('catatan_admin') is-invalid @enderror"
                                rows="3"
                                placeholder="Tuliskan alasan penolakan secara jelas (contoh: kriteria tidak relevan dengan profil lulusan SI, alamat perusahaan kurang jelas)..."
                                required
                            >{{ old('catatan_admin') }}</textarea>
                            @error('catatan_admin')
                                <p class="form-error" style="color: var(--danger-text); font-size: 11px; margin-top: 4px;">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn--danger" style="width: 100%;">
                            &cross; Tolak Lowongan
                        </button>
                    </form>
                </div>
            @else
                <div class="detail-card" style="text-align: center; padding: 20px;">
                    <p style="margin: 0; font-size: 12px; color: var(--text-muted);">
                        Lowongan ini sudah diproses dan tidak dapat diverifikasi ulang.
                    </p>
                    <div style="margin-top: 10px;">
                        <a href="{{ route('admin.verifikasi.index') }}" class="btn btn--sm">
                            Kembali ke Daftar Verifikasi
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
