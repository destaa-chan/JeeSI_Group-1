@extends('layouts.perusahaan')

@section('title', 'Detail Pelamar')

@section('content')

    @php
        $labelStatus = [
            'terkirim' => 'Terkirim',
            'dilihat'  => 'Dilihat',
            'diundang' => 'Diundang',
            'diterima' => 'Diterima',
            'ditolak'  => 'Ditolak',
        ];
    @endphp

    <div class="page-head">
        <h1 class="page-title">Detail Pelamar</h1>
        <a href="{{ route('perusahaan.lamaran.index') }}" class="btn btn--outline">Kembali</a>
    </div>

    {{-- Profil Pelamar & Cover Letter --}}
    <section class="panel" aria-labelledby="judul-profil-pelamar">
        <div class="panel__head">
            <h2 class="panel__title" id="judul-profil-pelamar">
                {{ $lamaran->alumni->nama_lengkap }} &mdash; {{ $lamaran->lowongan->posisi }}
            </h2>
            <span class="badge-status badge-status--{{ $lamaran->status_lamaran }}">
                {{ $labelStatus[$lamaran->status_lamaran] ?? ucfirst($lamaran->status_lamaran) }}
            </span>
        </div>

        <div class="detail-grid">
            <div>
                <p class="detail-label">NIM</p>
                <p class="detail-text">{{ $lamaran->alumni->nim ?: '-' }}</p>

                <p class="detail-label">Program Studi</p>
                <p class="detail-text">{{ $lamaran->alumni->program_studi ?: '-' }}</p>

                <p class="detail-label">Pendidikan</p>
                <p class="detail-text">{{ $lamaran->alumni->pendidikan ?: '-' }}</p>
            </div>

            <div>
                <p class="detail-label">Email</p>
                <p class="detail-text">{{ $lamaran->alumni->user->email ?? '-' }}</p>

                <p class="detail-label">Kompetensi</p>
                <p class="detail-text">{{ $lamaran->alumni->kompetensi ?: '-' }}</p>

                <p class="detail-label">Minat Studi</p>
                <p class="detail-text">{{ $lamaran->alumni->minat_studi ?: '-' }}</p>
            </div>
        </div>

        <p class="detail-label">Cover Letter</p>
        <p class="detail-text">{{ $lamaran->cover_letter ?: '-' }}</p>
    </section>

    {{-- Portofolio Pelamar --}}
    <section class="panel" aria-labelledby="judul-portofolio-pelamar">
        <div class="panel__head">
            <h2 class="panel__title" id="judul-portofolio-pelamar">Portofolio Pelamar</h2>
        </div>

        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama Portofolio</th>
                        <th>Deskripsi</th>
                        <th>File</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($lamaran->alumni->portofolio as $item)
                        <tr>
                            <td><strong>{{ $item->nama_portofolio }}</strong></td>
                            <td>{{ $item->deskripsi ?: '-' }}</td>
                            <td>
                                <a href="{{ Storage::disk('public')->url($item->file_portofolio) }}" target="_blank" rel="noopener">
                                    {{ basename($item->file_portofolio) }}
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="table__empty">Tidak ada portofolio terlampir.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    {{-- Ubah Status Lamaran --}}
    <section class="panel" aria-labelledby="judul-ubah-status">
        <div class="panel__head">
            <h2 class="panel__title" id="judul-ubah-status">Perbarui Status Lamaran</h2>
        </div>

        <form method="POST" action="{{ route('perusahaan.lamaran.status', $lamaran) }}" class="inline-form">
            @csrf
            @method('PATCH')

            <div class="form-group">
                <label for="status_lamaran" class="form-label">Status Lamaran</label>
                <select id="status_lamaran" name="status_lamaran"
                        class="form-control @error('status_lamaran') is-invalid @enderror">
                    @foreach (['dilihat', 'diundang', 'diterima', 'ditolak'] as $status)
                        <option value="{{ $status }}" @selected(old('status_lamaran', $lamaran->status_lamaran) === $status)>
                            {{ $labelStatus[$status] ?? ucfirst($status) }}
                        </option>
                    @endforeach
                </select>
                @error('status_lamaran') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="btn">Simpan Status</button>
        </form>
    </section>

@endsection
