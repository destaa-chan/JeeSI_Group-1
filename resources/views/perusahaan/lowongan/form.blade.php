<!doctype html>
<html lang="id">
<body>
<h1>{{ $lowongan ? 'Edit Lowongan' : 'Posting Lowongan' }}</h1>
<p><a href="{{ route('perusahaan.lowongan.index') }}">Kembali</a></p>
@if ($errors->any())<ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>@endif
<form method="POST" action="{{ $lowongan ? route('perusahaan.lowongan.update', $lowongan) : route('perusahaan.lowongan.store') }}">
@csrf @if ($lowongan) @method('PUT') @endif
<label>Posisi <input name="posisi" value="{{ old('posisi', $lowongan?->posisi) }}" required></label><br>
<label>Deskripsi <textarea name="deskripsi" required>{{ old('deskripsi', $lowongan?->deskripsi) }}</textarea></label><br>
<label>Kriteria Kandidat <textarea name="kriteria_kandidat" required>{{ old('kriteria_kandidat', $lowongan?->kriteria_kandidat) }}</textarea></label><br>
<button type="submit">Submit Lowongan</button>
</form>
</body>
</html>
