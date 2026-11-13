@extends('layouts.admin')

@section('title', 'Verifikasi Lowongan')

@section('content')
    <h1 class="page-title">Verifikasi Lowongan</h1>

    <p>
        <a href="{{ route('admin.verifikasi.index', ['status' => 'pending']) }}">Menunggu</a> |
        <a href="{{ route('admin.verifikasi.index', ['status' => 'approved']) }}">Disetujui</a> |
        <a href="{{ route('admin.verifikasi.index', ['status' => 'rejected']) }}">Ditolak</a>
    </p>
@endsection 