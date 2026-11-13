<!doctype html>
<html lang="id">
<body>
<h1>Profil Perusahaan</h1>
<p><a href="{{ route('perusahaan.dashboard') }}">Dashboard</a></p>
@if (session('success'))<p>{{ session('success') }}</p>@endif
@if ($errors->any())<ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>@endif
<form method="POST" action="{{ route('perusahaan.profile.update') }}">
@csrf @method('PUT')
<label>Nama Perusahaan <input name="nama_perusahaan" value="{{ old('nama_perusahaan', $perusahaan?->nama_perusahaan) }}" required></label><br>
<label>Alamat <textarea name="alamat" required>{{ old('alamat', $perusahaan?->alamat) }}</textarea></label><br>
<label>Deskripsi <textarea name="deskripsi" required>{{ old('deskripsi', $perusahaan?->deskripsi) }}</textarea></label><br>
<button type="submit">Simpan</button>
</form>
</body>
</html>
