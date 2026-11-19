<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Alumni') - JeeSI</title>

    <!-- Fonts (sama dengan halaman login & admin) -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Styles (di-build lewat Vite) -->
    @vite(['resources/css/alumni/alumni.css'])
</head>
<body>

    <!-- Navbar Alumni: JeeSI | Dashboard | Profil Saya | Portofolio | Lamaran Saya ........ Alumni | Keluar -->
    <header class="alumni-nav">
        <div class="alumni-nav__inner">
            <nav class="alumni-nav__left" aria-label="Navigasi alumni">
                <a href="{{ route('alumni.dashboard') }}" class="alumni-nav__brand">JeeSI</a>

                <a href="{{ route('alumni.dashboard') }}"
                   class="alumni-nav__link {{ request()->routeIs('alumni.dashboard') ? 'is-active' : '' }}">
                    Dashboard
                </a>

                <a href="{{ route('alumni.profile.edit') }}"
                   class="alumni-nav__link {{ request()->routeIs('alumni.profile.*') ? 'is-active' : '' }}">
                    Profil Saya
                </a>

                <a href="{{ route('alumni.portofolio.index') }}"
                   class="alumni-nav__link {{ request()->routeIs('alumni.portofolio.*') ? 'is-active' : '' }}">
                    Portofolio
                </a>

                <a href="{{ route('alumni.lamaran.index') }}"
                   class="alumni-nav__link {{ request()->routeIs('alumni.lamaran.*') ? 'is-active' : '' }}">
                    Lamaran Saya
                </a>
            </nav>

            <div class="alumni-nav__right">
                <span class="alumni-nav__role">Alumni</span>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="alumni-nav__logout">Keluar</button>
                </form>
            </div>
        </div>
    </header>

    <main class="alumni-main">
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