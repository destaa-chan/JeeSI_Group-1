<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Perusahaan') - JeeSI</title>

    <!-- Fonts (sama dengan halaman login & admin) -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Styles (di-build lewat Vite) -->
    @vite(['resources/css/perusahaan/perusahaan.css'])
</head>
<body>

    <!-- Navbar Perusahaan: JeeSI | Dashboard | Kelola Lowongan | Lamaran Masuk | Profil Perusahaan ........ Perusahaan | Keluar -->
    <header class="perusahaan-nav">
        <div class="perusahaan-nav__inner">
            <nav class="perusahaan-nav__left" aria-label="Navigasi perusahaan">
                <a href="{{ route('perusahaan.dashboard') }}" class="perusahaan-nav__brand">JeeSI</a>

                <a href="{{ route('perusahaan.dashboard') }}"
                   class="perusahaan-nav__link {{ request()->routeIs('perusahaan.dashboard') ? 'is-active' : '' }}">
                    Dashboard
                </a>

                <a href="{{ route('perusahaan.lowongan.index') }}"
                   class="perusahaan-nav__link {{ request()->routeIs('perusahaan.lowongan.*') ? 'is-active' : '' }}">
                    Kelola Lowongan
                </a>

                <a href="{{ route('perusahaan.lamaran.index') }}"
                   class="perusahaan-nav__link {{ request()->routeIs('perusahaan.lamaran.*') ? 'is-active' : '' }}">
                    Lamaran Masuk
                </a>

                <a href="{{ route('perusahaan.profile.edit') }}"
                   class="perusahaan-nav__link {{ request()->routeIs('perusahaan.profile.*') ? 'is-active' : '' }}">
                    Profil Perusahaan
                </a>
            </nav>

            <div class="perusahaan-nav__right">
                <span class="perusahaan-nav__role">Perusahaan</span>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="perusahaan-nav__logout">Keluar</button>
                </form>
            </div>
        </div>
    </header>

    <main class="perusahaan-main">
        @if (session('success'))
            <div class="notice notice--success" role="status">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="notice notice--danger" role="alert">{{ session('error') }}</div>
        @endif

        @if ($errors->any())
            <div class="notice notice--danger" role="alert">
                <strong>Terjadi kesalahan:</strong>
                <ul style="margin: 4px 0 0; padding-left: 18px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

</body>
</html>
