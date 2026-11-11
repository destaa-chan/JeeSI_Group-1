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
<body class="bg-gray-100 font-sans text-gray-900 antialiased min-h-screen flex items-center justify-center p-4 sm:p-6">

    <!-- Card Wrapper (UI-001 Halaman Login) -->
    <div class="w-full max-w-md bg-white border border-gray-300 rounded-lg shadow-sm p-8 sm:p-10">

        <!-- Header / Logo Sesuai Mockup SDD -->
        <div class="text-center mb-6">
            <h1 class="text-3xl font-extrabold tracking-tight text-gray-900">JeeSI</h1>
            <p class="text-sm font-medium text-gray-500 mt-1">Job Seeker SI</p>
        </div>

        <!-- Judul Form -->
        <h2 class="text-lg font-semibold text-gray-900 mb-4 text-center">Masuk</h2>

        <!-- Pesan Status Session (jika ada) -->
        @if (session('status'))
            <div class="mb-4 p-3 rounded-md bg-emerald-50 border border-dashed border-emerald-400 text-emerald-700 text-xs text-center">
                {{ session('status') }}
            </div>
        @endif

        <!-- Kotak Pesan Peringatan (Hanya muncul jika ada kesalahan login / validasi) -->
        @if ($errors->any())
            <div class="mb-4 p-3 rounded-md bg-red-50 border border-dashed border-red-400 text-red-600 text-xs text-center">
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
            <div class="mb-4 p-3 rounded-md bg-red-50 border border-dashed border-red-400 text-red-600 text-xs text-center">
                <span class="font-semibold">Pesan peringatan:</span> {{ session('error') }}
            </div>
        @endif

        <!-- Form Login -->
        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <!-- Username atau Email -->
            <div>
                <label for="username" class="block text-sm font-medium text-gray-700 mb-1">
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
                    class="w-full px-3.5 py-2.5 text-sm bg-white border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-black focus:border-black transition duration-150"
                />
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                    Password
                </label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    placeholder="Masukkan password"
                    required
                    autocomplete="current-password"
                    class="w-full px-3.5 py-2.5 text-sm bg-white border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-black focus:border-black transition duration-150"
                />
            </div>

            <!-- Tombol Masuk -->
            <div class="pt-2">
                <button
                    type="submit"
                    class="w-full py-2.5 px-4 bg-black hover:bg-neutral-800 text-white font-medium text-sm rounded-md shadow-sm transition duration-150 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black cursor-pointer text-center"
                >
                    Masuk
                </button>
            </div>
        </form>

        <!-- Keterangan Alur Sesuai Mockup SDD -->
        <p class="mt-6 text-xs text-center text-gray-500 leading-relaxed">
            Setelah berhasil, pengguna diarahkan ke dashboard sesuai peran: Alumni, Perusahaan, atau Admin.
        </p>

    </div>

</body>
</html>
