<!doctype html>
<html lang="id">
<body>
<h1>{{ $lowongan->posisi }}</h1>
<p><a href="{{ route('alumni.dashboard') }}">Kembali ke dashboard</a></p>
<p>Perusahaan: {{ $lowongan->perusahaan->nama_perusahaan }}</p>
<h2>Deskripsi</h2><p>{{ $lowongan->deskripsi }}</p>
<h2>Kriteria Kandidat</h2><p>{{ $lowongan->kriteria_kandidat }}</p>
@if ($sudahMelamar)
<p>Anda sudah melamar lowongan ini.</p>
@elseif (!$portofolio->count() && !auth()->user()->alumni)
<p>Lengkapi profil alumni sebelum melamar.</p>
@else
@if ($errors->any())<ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>@endif
<form method="POST" action="{{ route('alumni.lowongan.apply', $lowongan) }}">
@csrf
<label>Portofolio (opsional)
<select name="id_portofolio"><option value="">Tanpa portofolio</option>@foreach ($portofolio as $item)<option value="{{ $item->id_portofolio }}">{{ $item->nama_portofolio }}</option>@endforeach</select></label><br>
<label>Cover Letter <textarea name="cover_letter" required></textarea></label><br>
<button type="submit">Daftar Sekarang</button>
</form>
@endif
</body>
</html>
