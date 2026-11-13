<!doctype html>
<html lang="id">
<body>
<h1>Portofolio Alumni</h1>
<p><a href="{{ route('alumni.dashboard') }}">Dashboard</a></p>
@if (session('success'))<p>{{ session('success') }}</p>@endif
@if ($errors->any())<ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>@endif
<h2>Tambah Portofolio</h2>
<form method="POST" action="{{ route('alumni.portofolio.store') }}" enctype="multipart/form-data">
@csrf
<label>Nama Portofolio <input name="nama_portofolio" required></label><br>
<label>Deskripsi <textarea name="deskripsi" required></textarea></label><br>
<label>File (PDF/DOC/DOCX) <input type="file" name="file_portofolio" required></label><br>
<button type="submit">Simpan</button>
</form>
<h2>Daftar Portofolio</h2>
@forelse ($portofolio as $item)
<article>
<h3>{{ $item->nama_portofolio }}</h3><p>{{ $item->deskripsi }}</p>
<a href="{{ Storage::disk('public')->url($item->file_portofolio) }}">Lihat file</a>
<form method="POST" action="{{ route('alumni.portofolio.destroy', $item) }}">@csrf @method('DELETE')<button type="submit">Hapus</button></form>
</article>
@empty <p>Belum ada portofolio.</p> @endforelse
</body>
</html>
