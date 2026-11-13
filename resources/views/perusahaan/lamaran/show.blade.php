<!doctype html>
<html lang="id">
<body>
<h1>Profil Pelamar</h1>
<p><a href="{{ route('perusahaan.lamaran.index') }}">Kembali</a></p>
@if (session('success'))<p>{{ session('success') }}</p>@endif
<p>Nama: {{ $lamaran->alumni->nama_lengkap }}</p>
<p>NIM: {{ $lamaran->alumni->nim }}</p>
<p>Program Studi: {{ $lamaran->alumni->program_studi }}</p>
<p>Kompetensi: {{ $lamaran->alumni->kompetensi }}</p>
<p>Minat Studi: {{ $lamaran->alumni->minat_studi }}</p>
<p>Cover Letter: {{ $lamaran->cover_letter }}</p>
<h2>Portofolio</h2>
@forelse ($lamaran->alumni->portofolio as $item)<p><a href="{{ Storage::disk('public')->url($item->file_portofolio) }}">{{ $item->nama_portofolio }}</a></p>@empty<p>Tidak ada portofolio terlampir.</p>@endforelse
<form method="POST" action="{{ route('perusahaan.lamaran.status', $lamaran) }}">
@csrf @method('PATCH')
<label>Ubah Status <select name="status_lamaran">@foreach (['dilihat', 'diundang', 'diterima', 'ditolak'] as $status)<option value="{{ $status }}" @selected($lamaran->status_lamaran === $status)>{{ $status }}</option>@endforeach</select></label>
<button type="submit">Simpan Status</button>
</form>
</body>
</html>
