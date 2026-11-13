<!doctype html>
<html lang="id">
<body>
<h1>Riwayat Lamaran</h1>
<p><a href="{{ route('alumni.dashboard') }}">Dashboard</a></p>
@if (session('success'))<p>{{ session('success') }}</p>@endif
@forelse ($lamaran as $item)
<article>
<h2>{{ $item->lowongan->posisi }}</h2>
<p>Perusahaan: {{ $item->lowongan->perusahaan->nama_perusahaan }}</p>
<p>Status: {{ $item->status_lamaran }}</p>
<p>Dikirim: {{ $item->created_at }}</p>
</article>
@empty <p>Belum ada lamaran.</p> @endforelse
{{ $lamaran instanceof \Illuminate\Contracts\Pagination\Paginator ? $lamaran->links() : '' }}
</body>
</html>
