<!doctype html>
<html lang="id">
<body>
<h1>Dashboard Perusahaan</h1>
<p><a href="{{ route('perusahaan.profile.edit') }}">Profil Perusahaan</a> | <a href="{{ route('perusahaan.lowongan.index') }}">Kelola Lowongan</a> | <a href="{{ route('perusahaan.lamaran.index') }}">Lamaran Masuk</a></p>
@if (!$perusahaan)<p>Profil perusahaan belum lengkap. <a href="{{ route('perusahaan.profile.edit') }}">Lengkapi profil</a>.</p>@endif
<h2>Lowongan Saya</h2>
@forelse ($lowongan as $item)<p>{{ $item->posisi }} - {{ $item->status_verifikasi }}</p>@empty<p>Belum ada lowongan.</p>@endforelse
</body>
</html>
