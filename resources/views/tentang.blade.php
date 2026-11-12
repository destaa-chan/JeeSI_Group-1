<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>JeeSI - Tentang</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts and Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-cocoa-icing font-sans text-cocoa-bitter antialiased min-h-screen p-4 sm:p-6">

    <div class="relative w-full max-w-3xl mx-auto bg-cocoa-mist border border-cocoa-truffle/30 rounded-lg shadow-sm p-6 sm:p-10 my-4 sm:my-8">

        <!-- Kembali -->
        <a
            href="{{ auth()->check() ? route('dashboard') : route('login') }}"
            class="inline-flex items-center gap-1.5 text-sm font-medium text-cocoa-truffle hover:text-cocoa-wine focus:outline-none focus-visible:ring-2 focus-visible:ring-cocoa-wine rounded transition duration-150"
        >
            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
            </svg>
            {{ auth()->check() ? 'Kembali ke dashboard' : 'Kembali ke halaman masuk' }}
        </a>

        <!-- Header -->
        <div class="text-center mt-4 mb-8">
            <h1 class="text-3xl font-extrabold tracking-tight text-cocoa-bitter">JeeSI</h1>
            <p class="text-sm font-medium text-cocoa-truffle mt-1">Job Seeker SI</p>
            <p class="text-sm text-cocoa-truffle mt-4 max-w-xl mx-auto leading-relaxed">
                Aplikasi berbasis web yang membantu perusahaan mencari calon pekerja berdasarkan data alumni,
                mencakup profil, kompetensi, minat studi, dan portofolio.
            </p>
        </div>

        <!-- Anggota Kelompok -->
        <h2 class="text-lg font-semibold text-cocoa-bitter mb-4 text-center">Anggota Kelompok 1</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            @foreach ($anggota as $a)
                <div class="flex items-center gap-4 bg-white border border-cocoa-truffle/30 rounded-lg p-4">
                    <!-- Avatar inisial -->
                    <div class="shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-cocoa-wine text-white text-sm font-bold tracking-wide" aria-hidden="true">
                        {{ $a['inisial'] }}
                    </div>

                    <div class="min-w-0">
                        <p class="text-sm font-semibold text-cocoa-bitter leading-snug">{{ $a['nama'] }}</p>
                        <p class="text-xs text-cocoa-truffle mt-0.5">NIM {{ $a['nim'] }}</p>
                        <span class="inline-block mt-2 px-2 py-0.5 rounded-full text-[11px] font-medium bg-cocoa-icing text-cocoa-bitter">
                            {{ $a['role'] }}
                        </span>
                    </div>
                </div>
            @endforeach
        </div>

    </div>

</body>
</html>