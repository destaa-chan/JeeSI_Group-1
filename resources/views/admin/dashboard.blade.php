@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
    {{-- UI-002: Dashboard Admin --}}
    <div style="display: flex; align-items: center; justify-content: space-between; gap: 14px; margin-bottom: 14px; flex-wrap: wrap;">
        <div>
            <h1 class="page-title" style="margin: 0;">Dashboard Admin</h1>
            <p style="margin: 4px 0 0; font-size: 12px; color: var(--text-muted);">
                Panel Pengawasan & Verifikasi Platform JeeSI (Job Seeker Sistem Informasi)
            </p>
        </div>
        <div>
            <a href="{{ route('admin.verifikasi.index') }}" class="btn">
                Verifikasi Lowongan &rarr;
            </a>
        </div>
    </div>

    {{-- Ringkasan status verifikasi lowongan --}}
    <section class="stat-grid" aria-label="Ringkasan verifikasi lowongan">
        <div class="stat-card">
            <span class="stat-card__value" style="color: var(--warning-text);">{{ $menungguVerifikasi }}</span>
            <span class="stat-card__label">Menunggu Verifikasi</span>
        </div>

        <div class="stat-card">
            <span class="stat-card__value" style="color: var(--success-text);">{{ $published }}</span>
            <span class="stat-card__label">Lowongan Published</span>
        </div>

        <div class="stat-card">
            <span class="stat-card__value" style="color: var(--danger-text);">{{ $ditolak }}</span>
            <span class="stat-card__label">Lowongan Ditolak</span>
        </div>
    </section>

    {{-- Notifikasi lowongan baru (ACT-003: sistem mengirim notifikasi ke Admin) --}}
    @if ($adaLowonganBaru)
        <div class="notice notice--warning" role="status" style="display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap;">
            <div>
                <strong>Notifikasi Perhatian:</strong> Ada <strong>{{ $menungguVerifikasi }}</strong> lowongan baru dari perusahaan yang menunggu verifikasi admin sebelum dapat dipublikasikan.
            </div>
            <div>
                <a href="{{ route('admin.verifikasi.index', ['status' => 'pending']) }}" class="btn btn--sm">
                    Tinjau Sekarang &rarr;
                </a>
            </div>
        </div>
    @else
        <div class="notice notice--success" role="status">
            Semua lowongan telah ditinjau. Tidak ada antrean lowongan yang menunggu verifikasi saat ini.
        </div>
    @endif

    {{-- Panduan Kriteria Verifikasi SDD JeeSI --}}
    <section class="panel">
        <div class="panel__head">
            <h2 class="panel__title">Pedoman Verifikasi Kelayakan Lowongan (SDD JeeSI UI-009)</h2>
            <a href="{{ route('admin.verifikasi.index') }}" class="panel__link">Buka Halaman Verifikasi &rarr;</a>
        </div>
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px; font-size: 12px;">
            <div style="background: #fff; padding: 12px; border: 1px solid var(--border); border-radius: var(--radius);">
                <strong style="color: var(--bitter-cocoa); display: block; margin-bottom: 4px;">1. Informasi Perusahaan Sah</strong>
                <p style="margin: 0; color: var(--text-muted); font-size: 11px;">
                    Verifikasi nama perusahaan, alamat domisili kantor, dan keaslian profil instansi yang mengajukan lowongan.
                </p>
            </div>
            <div style="background: #fff; padding: 12px; border: 1px solid var(--border); border-radius: var(--radius);">
                <strong style="color: var(--bitter-cocoa); display: block; margin-bottom: 4px;">2. Deskripsi Aman & Jelas</strong>
                <p style="margin: 0; color: var(--text-muted); font-size: 11px;">
                    Pastikan deskripsi pekerjaan terperinci, bebas dari unsur penipuan, skema piramida, atau pungutan biaya pendaftaran.
                </p>
            </div>
            <div style="background: #fff; padding: 12px; border: 1px solid var(--border); border-radius: var(--radius);">
                <strong style="color: var(--bitter-cocoa); display: block; margin-bottom: 4px;">3. Relevan Lulusan SI</strong>
                <p style="margin: 0; color: var(--text-muted); font-size: 11px;">
                    Posisi pekerjaan harus relevan dengan profil lulusan S1 Sistem Informasi (IT developer, analyst, data, consultant).
                </p>
            </div>
        </div>
    </section>
@endsection
