<!doctype html>
<html lang="id">
<body>
<h1>Dashboard Alumni</h1>
<p><a href="{{ route('alumni.profile.edit') }}">Profil Saya</a> | <a href="{{ route('alumni.portofolio.index') }}">Portofolio</a> | <a href="{{ route('alumni.lamaran.index') }}">Riwayat Lamaran</a></p>
@if ($alumni)
<p>Selamat datang, {{ $alumni->nama_lengkap }}.</p>
@else
<p>Profil alumni belum lengkap. <a href="{{ route('alumni.profile.edit') }}">Lengkapi profil</a>.</p>
@endif
<h2>Lowongan Published</h2>
@forelse ($lowongan as $item)
<article>
    <h3><a href="{{ route('alumni.lowongan.show', $item) }}">{{ $item->posisi }}</a></h3>
    <p>{{ $item->perusahaan->nama_perusahaan }}</p>
    <p>{{ $item->deskripsi }}</p>
</article>
@empty
<p>Belum ada lowongan published.</p>
@endforelse
{{ $lowongan->links() }}
</body>
</html>
