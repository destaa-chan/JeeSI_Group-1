@extends('layouts.alumni')

@section('title', 'Portofolio')

@section('content')

    {{-- UI-005: Form Portofolio --}}
    <h1 class="page-title">Form Portofolio</h1>

    @if ($errors->any())
        <div class="notice notice--danger" role="alert">Pesan error: Data Tidak Lengkap</div>
    @endif

    @if (! $alumni)
        <div class="notice notice--danger" role="alert">
            Profil alumni belum lengkap. <a href="{{ route('alumni.profile.edit') }}">Lengkapi profil</a>
            terlebih dahulu sebelum menambahkan portofolio.
        </div>
    @endif

    {{-- Daftar Portofolio --}}
    <section class="panel" aria-labelledby="judul-daftar">
        <div class="panel__head">
            <h2 class="panel__title" id="judul-daftar">Daftar Portofolio</h2>
        </div>

        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama Portofolio</th>
                        <th>Deskripsi</th>
                        <th>File</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($portofolio as $item)
                        <tr>
                            <td>{{ $item->nama_portofolio }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($item->deskripsi, 80) }}</td>
                            <td>
                                <a href="{{ Storage::disk('public')->url($item->file_portofolio) }}" target="_blank" rel="noopener">
                                    {{ basename($item->file_portofolio) }}
                                </a>
                            </td>
                            <td>
                                <form method="POST" action="{{ route('alumni.portofolio.destroy', $item) }}"
                                      onsubmit="return confirm('Hapus portofolio ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="link-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="table__empty">Belum ada portofolio.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    {{-- Tambah Portofolio --}}
    <form method="POST" action="{{ route('alumni.portofolio.store') }}" enctype="multipart/form-data" novalidate>
        @csrf

        <section class="panel" aria-labelledby="judul-tambah">
            <div class="panel__head">
                <h2 class="panel__title" id="judul-tambah">Tambah Portofolio</h2>
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label for="nama_portofolio" class="form-label">Nama Portofolio</label>
                    <input type="text" id="nama_portofolio" name="nama_portofolio"
                           class="form-control @error('nama_portofolio') is-invalid @enderror"
                           placeholder="Judul portofolio" value="{{ old('nama_portofolio') }}" required>
                    @error('nama_portofolio') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div class="form-group">
                    <label for="file_portofolio" class="form-label">Unggah File</label>
                    <input type="file" id="file_portofolio" name="file_portofolio"
                           class="form-control form-control--file @error('file_portofolio') is-invalid @enderror"
                           accept=".pdf,.doc,.docx" required>
                    @error('file_portofolio') <p class="form-error">{{ $message }}</p> @enderror
                    <p class="form-hint">Format PDF, DOC, atau DOCX. Maksimal 5 MB.</p>
                </div>
            </div>

            <div class="form-group" style="margin-top:12px;">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi" rows="4"
                          class="form-control @error('deskripsi') is-invalid @enderror"
                          placeholder="Penjelasan singkat portofolio" required>{{ old('deskripsi') }}</textarea>
                @error('deskripsi') <p class="form-error">{{ $message }}</p> @enderror
            </div>
        </section>

        <div class="form-actions">
            <a href="{{ route('alumni.dashboard') }}" class="btn btn--outline">Batal</a>
            <button type="submit" class="btn">Simpan Portofolio</button>
        </div>
    </form>

@endsection