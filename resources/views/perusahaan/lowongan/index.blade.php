<!doctype html>
<html lang="id">
<body>
<h1>Lowongan Perusahaan</h1>
<p><a href="{{ route('perusahaan.dashboard') }}">Dashboard</a> | <a href="{{ route('perusahaan.lowongan.create') }}">Posting Lowongan</a></p>
@if (session('success'))<p>{{ session('success') }}</p>@endif
@forelse ($lowongan as $item)
<article>
<h2>{{ $item->posisi }}</h2><p>Status: {{ $item->status_verifikasi }}</p>
@if ($item->catatan_admin)<p>Catatan admin: {{ $item->catatan_admin }}</p>@endif
<a href="{{ route('perusahaan.lowongan.edit', $item) }}">Edit</a>
<form method="POST" action="{{ route('perusahaan.lowongan.destroy', $item) }}">@csrf @method('DELETE')<button type="submit">Hapus</button></form>
</article>
@empty <p>Belum ada lowongan.</p> @endforelse
{{ $lowongan->links() }}
</body>
</html>
