@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')

    {{-- UI-002: Dashboard Admin --}}
    <h1 class="page-title">Dashboard Admin</h1>

    {{-- Ringkasan status verifikasi lowongan --}}
    <section class="stat-grid" aria-label="Ringkasan verifikasi lowongan">
        <div class="stat-card">
            <span class="stat-card__value">{{ $menungguVerifikasi }}</span>
            <span class="stat-card__label">Menunggu verifikasi</span>
        </div>

        <div class="stat-card">
            <span class="stat-card__value">{{ $published }}</span>
            <span class="stat-card__label">Published</span>
        </div>

        <div class="stat-card">
            <span class="stat-card__value">{{ $ditolak }}</span>
            <span class="stat-card__label">Ditolak</span>
        </div>
    </section>

    {{-- Notifikasi lowongan baru (ACT-003: sistem mengirim notifikasi ke Admin) --}}
    @if ($adaLowonganBaru)
        <div class="notice notice--success" role="status">
            Notifikasi: ada lowongan baru yang menunggu verifikasi.
        </div>
    @else
        <div class="notice notice--muted" role="status">
            Tidak ada lowongan yang menunggu verifikasi.
        </div>
    @endif

    <a href="{{ route('admin.verifikasi.index') }}" class="btn">Review Lowongan</a>

@endsection