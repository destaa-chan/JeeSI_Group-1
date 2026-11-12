<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>JeeSI - Masuk</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts and Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-cocoa-icing font-sans text-cocoa-bitter antialiased min-h-screen flex items-center justify-center p-4 sm:p-6">

    <!-- Card Wrapper (UI-001 Halaman Login) -->
    <div class="relative w-full max-w-md bg-cocoa-mist border border-cocoa-truffle/30 rounded-lg shadow-sm p-8 sm:p-10">

        <!-- Tombol Tentang (ikon i) -> halaman Tentang -->
        <a
            href="{{ route('tentang') }}"
            title="Tentang JeeSI"
            aria-label="Tentang JeeSI"
            class="absolute top-3 right-3 inline-flex items-center justify-center h-9 w-9 rounded-full text-cocoa-truffle hover:text-cocoa-wine hover:bg-cocoa-icing/60 focus:outline-none focus-visible:ring-2 focus-visible:ring-cocoa-wine transition duration-150"
        >
            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
            </svg>
        </a>

        <!-- Header / Logo Sesuai Mockup SDD -->
        <div class="text-center mb-6">
            <h1 class="text-3xl font-extrabold tracking-tight text-cocoa-bitter">JeeSI</h1>
            <p class="text-sm font-medium text-cocoa-truffle mt-1">Job Seeker SI</p>
        </div>

        <!-- Judul Form -->
        <h2 class="text-lg font-semibold text-cocoa-bitter mb-4 text-center">Masuk</h2>

        <!-- Pesan Status Session (jika ada) -->
        @if (session('status'))
            <div class="mb-4 p-3 rounded-md bg-emerald-50 border border-dashed border-emerald-400 text-emerald-700 text-xs text-center">
                {{ session('status') }}
            </div>
        @endif

        <!-- Kotak Pesan Peringatan (Hanya muncul jika ada kesalahan login / validasi) -->
        @if ($errors->any())
            <div class="mb-4 p-3 rounded-md bg-cocoa-cherry/10 border border-dashed border-cocoa-cherry text-cocoa-cherry text-xs text-center">
                <span class="font-semibold">Pesan peringatan:</span>
                @if ($errors->count() == 1)
                    <span>{{ $errors->first() }}</span>
                @else
                    <ul class="mt-1 list-disc list-inside space-y-0.5 text-left inline-block">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
        @elseif (session('error'))
            <div class="mb-4 p-3 rounded-md bg-cocoa-cherry/10 border border-dashed border-cocoa-cherry text-cocoa-cherry text-xs text-center">
                <span class="font-semibold">Pesan peringatan:</span> {{ session('error') }}
            </div>
        @endif

        <!-- Form Login -->
        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <!-- Username atau Email -->
            <div>
                <label for="username" class="block text-sm font-medium text-cocoa-bitter mb-1">
                    Username atau Email
                </label>
                <input
                    id="username"
                    name="username"
                    type="text"
                    value="{{ old('username', old('email')) }}"
                    placeholder="Masukkan username atau email"
                    required
                    autofocus
                    autocomplete="username"
                    class="w-full px-3.5 py-2.5 text-sm bg-white border border-cocoa-truffle/40 rounded-md shadow-sm placeholder-cocoa-truffle/70 focus:outline-none focus:ring-1 focus:ring-cocoa-wine focus:border-cocoa-wine transition duration-150"
                />
            </div>

            <!-- Password (dengan tombol lihat/sembunyikan) -->
            <div x-data="{ show: false }">
                <label for="password" class="block text-sm font-medium text-cocoa-bitter mb-1">
                    Password
                </label>
                <div class="relative">
                    <input
                        id="password"
                        name="password"
                        type="password"
                        x-bind:type="show ? 'text' : 'password'"
                        placeholder="Masukkan password"
                        required
                        autocomplete="current-password"
                        class="w-full pl-3.5 pr-11 py-2.5 text-sm bg-white border border-cocoa-truffle/40 rounded-md shadow-sm placeholder-cocoa-truffle/70 focus:outline-none focus:ring-1 focus:ring-cocoa-wine focus:border-cocoa-wine transition duration-150"
                    />

                    <button
                        type="button"
                        x-on:click="show = ! show"
                        x-bind:aria-pressed="show.toString()"
                        x-bind:aria-label="show ? 'Sembunyikan password' : 'Tampilkan password'"
                        aria-label="Tampilkan password"
                        class="absolute inset-y-0 right-0 flex items-center px-3 text-cocoa-truffle hover:text-cocoa-wine focus:outline-none focus-visible:text-cocoa-wine cursor-pointer"
                    >
                        <!-- Ikon mata (password tersembunyi) -->
                        <svg x-show="! show" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>

                        <!-- Ikon mata dicoret (password terlihat) -->
                        <svg x-show="show" x-cloak style="display: none;" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Tombol Masuk -->
            <div class="pt-2">
                <button
                    type="submit"
                    class="w-full py-2.5 px-4 bg-cocoa-wine hover:bg-cocoa-cherry text-white font-medium text-sm rounded-md shadow-sm transition duration-150 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cocoa-wine cursor-pointer text-center"
                >
                    Masuk
                </button>
            </div>
        </form>

        <!-- Keterangan Alur Sesuai Mockup SDD -->
        <p class="mt-6 text-xs text-center text-cocoa-truffle leading-relaxed">
            Setelah berhasil, pengguna diarahkan ke dashboard sesuai peran: Alumni, Perusahaan, atau Admin.
        </p>

    </div>

</body>
</html>