<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin') - JeeSI</title>

    <!-- Fonts (sama dengan halaman login) -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Styles (di-build lewat Vite) -->
    @vite(['resources/css/admin/admin.css'])
</head>
<body>

    <!-- Navbar Admin: JeeSI | Dashboard | Verifikasi Lowongan ........ Admin | Keluar -->
    <header class="admin-nav">
        <div class="admin-nav__inner">
            <nav class="admin-nav__left" aria-label="Navigasi admin">
                <a href="{{ route('admin.dashboard') }}" class="admin-nav__brand">JeeSI</a>

                <a href="{{ route('admin.dashboard') }}"
                   class="admin-nav__link {{ request()->routeIs('admin.dashboard') ? 'is-active' : '' }}">
                    Dashboard
                </a>

                <a href="{{ route('admin.verifikasi.index') }}"
                   class="admin-nav__link {{ request()->routeIs('admin.verifikasi.*') ? 'is-active' : '' }}">
                    Verifikasi Lowongan
                </a>
            </nav>

            <div class="admin-nav__right">
                <span class="admin-nav__role">Admin</span>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="admin-nav__logout">Keluar</button>
                </form>
            </div>
        </div>
    </header>

    <main class="admin-main">
        {{-- Pesan flash dari AdminLowonganController (success / error) --}}
        @if (session('success'))
            <div class="notice notice--success" role="status">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="notice notice--danger" role="alert">{{ session('error') }}</div>
        @endif

        @yield('content')
    </main>

</body>
</html>