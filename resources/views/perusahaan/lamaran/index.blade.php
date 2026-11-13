<!doctype html>
<html lang="id">
<body>
<h1>Lamaran Masuk</h1>
<p><a href="{{ route('perusahaan.dashboard') }}">Dashboard</a></p>
@forelse ($lamaran as $item)
<article>
<h2><a href="{{ route('perusahaan.lamaran.show', $item) }}">{{ $item->alumni->nama_lengkap }}</a></h2>
<p>Lowongan: {{ $item->lowongan->posisi }}</p><p>Status: {{ $item->status_lamaran }}</p>
</article>
@empty <p>Belum ada lamaran.</p> @endforelse
{{ $lamaran->links() }}
</body>
</html>
