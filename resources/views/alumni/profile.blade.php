<!doctype html>
<html lang="id">
<body>
<h1>Profil Alumni</h1>
<p><a href="{{ route('alumni.dashboard') }}">Dashboard</a></p>
@if (session('success'))<p>{{ session('success') }}</p>@endif
@if ($errors->any())<ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>@endif
<form method="POST" action="{{ route('alumni.profile.update') }}">
@csrf @method('PUT')
<label>Nama Lengkap <input name="nama_lengkap" value="{{ old('nama_lengkap', $alumni?->nama_lengkap ?? auth()->user()->nama_lengkap) }}" required></label><br>
<label>NIM <input name="nim" value="{{ old('nim', $alumni?->nim) }}" required></label><br>
<label>Program Studi <input name="program_studi" value="{{ old('program_studi', $alumni?->program_studi) }}" required></label><br>
<label>Pendidikan <input name="pendidikan" value="{{ old('pendidikan', $alumni?->pendidikan) }}" required></label><br>
<label>Kompetensi <textarea name="kompetensi" required>{{ old('kompetensi', $alumni?->kompetensi) }}</textarea></label><br>
<label>Minat Studi <textarea name="minat_studi" required>{{ old('minat_studi', $alumni?->minat_studi) }}</textarea></label><br>
<button type="submit">Simpan</button>
</form>
</body>
</html>
