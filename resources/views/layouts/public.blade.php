<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'KosinAja!')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;700&display=swap"
        rel="stylesheet">

    <style>
    body {
        font-family: 'DM Sans', sans-serif;
        background: #FDFBF7;
        color: #1B2B1D;
    }

    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
        font-family: 'Plus Jakarta Sans', sans-serif;
    }
    </style>

    @yield('styles')
</head>

<body class="overflow-x-hidden">

    {{-- NAVBAR --}}
    <nav class="fixed top-0 left-0 right-0 z-50
                bg-white/85 backdrop-blur-xl
                border-b border-[#edf1ed]">

        <div class="max-w-7xl mx-auto
                    px-6 lg:px-8
                    h-[84px]
                    flex items-center justify-between">

            {{-- LOGO --}}
            <a href="{{ route('home') }}" class="flex items-center gap-3">

                <img src="{{ asset('logo.png') }}" alt="KosinAja" class="w-11 h-11 object-contain">

                <span class="text-[30px] font-extrabold text-[#102313]">
                    KosinAja!
                </span>

            </a>

            {{-- MENU --}}
            <ul class="hidden lg:flex items-center gap-12">

                <li>
                    <a href="{{ route('home') }}" class="relative text-[15px] font-semibold transition-all duration-300 pb-2
                              {{ request()->is('/') ? 'text-[#6C8B6B]' : 'text-[#314233] hover:text-[#6C8B6B]' }}">
                        Beranda
                        @if(request()->is('/'))
                        <span class="absolute left-0 bottom-0 w-full h-[3px] rounded-full bg-[#6C8B6B]"></span>
                        @endif
                    </a>
                </li>

                <li>
                    <a href="{{ route('tentang') }}"
                        class="relative text-[15px] font-semibold transition-all duration-300 pb-2
                              {{ request()->is('tentang') ? 'text-[#6C8B6B]' : 'text-[#314233] hover:text-[#6C8B6B]' }}">
                        Tentang
                        @if(request()->is('tentang'))
                        <span class="absolute left-0 bottom-0 w-full h-[3px] rounded-full bg-[#6C8B6B]"></span>
                        @endif
                    </a>
                </li>

                <li>
                    <a href="{{ route('hubungi') }}"
                        class="relative text-[15px] font-semibold transition-all duration-300 pb-2
                              {{ request()->is('hubungi') ? 'text-[#6C8B6B]' : 'text-[#314233] hover:text-[#6C8B6B]' }}">
                        Hubungi
                        @if(request()->is('hubungi'))
                        <span class="absolute left-0 bottom-0 w-full h-[3px] rounded-full bg-[#6C8B6B]"></span>
                        @endif
                    </a>
                </li>

            </ul>

       {{-- ACTION --}}
<div class="flex items-center gap-4">

    @auth

        {{-- PROFILE DROPDOWN --}}
        <div class="relative group">

            <button
                class="flex items-center gap-3"
            >

                {{-- FOTO --}}
                <div class="w-11 h-11 rounded-full
                            overflow-hidden border-2
                            border-[#6C8B6B]">

                    <img
                        src="https://ui-avatars.com/api/?name={{ auth()->user()->nama }}"
                        class="w-full h-full object-cover"
                    >

                </div>

                {{-- NAMA --}}
                <div class="hidden md:block text-left">

                    <p class="text-sm text-gray-400">

                        Halo,

                    </p>

                    <h4 class="font-semibold text-[#1B2B1D]">

                        {{ auth()->user()->nama }}

                    </h4>

                </div>

                {{-- ICON --}}
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="w-4 h-4 text-gray-500"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M19 9l-7 7-7-7" />

                </svg>

            </button>

            {{-- DROPDOWN --}}
            <div class="absolute right-0 mt-4
                        w-64 bg-white rounded-2xl
                        shadow-xl border border-gray-100
                        opacity-0 invisible
                        group-hover:opacity-100
                        group-hover:visible
                        transition-all duration-200
                        overflow-hidden z-50">

                {{-- PROFILE --}}
                <a
                    href="{{ route('profil.index') }}"
                    class="flex items-center gap-3
                           px-5 py-4 hover:bg-gray-50
                           transition"
                >

                    👤

                    <span class="font-medium">

                        Profil Saya

                    </span>

                </a>

                {{-- DASHBOARD ADMIN --}}
                @if(auth()->user()->role == 'admin kost')

                    <a
                        href="{{ route('admin.dashboard') }}"
                        class="flex items-center gap-3
                               px-5 py-4 hover:bg-gray-50
                               transition"
                    >

                        🏠

                        <span class="font-medium">

                            Dashboard Admin

                        </span>

                    </a>

                @endif

                {{-- DASHBOARD PENGHUNI --}}
                @if(
                    auth()->user()->role == 'penghuni kost'
                )

                    <a
                        href="{{ route('profil.index') }}"
                        class="flex items-center gap-3
                               px-5 py-4 hover:bg-gray-50
                               transition"
                    >

                        🏡

                        <span class="font-medium">

                            Kost Saya

                        </span>

                    </a>

                @endif

                {{-- LOGOUT --}}
                <form
                    method="POST"
                    action="{{ route('logout') }}"
                >

                    @csrf

                    <button
                        type="submit"
                        class="w-full text-left
                               flex items-center gap-3
                               px-5 py-4 hover:bg-red-50
                               text-red-500 transition"
                    >

                        🚪

                        <span class="font-medium">

                            Logout

                        </span>

                    </button>

                </form>

            </div>

        </div>

    @else

        {{-- MASUK --}}
        <a
            href="{{ route('login') }}"
            class="px-6 py-3 rounded-2xl
                   border border-[#6C8B6B]
                   text-[#6C8B6B]
                   font-semibold
                   hover:bg-[#6C8B6B]
                   hover:text-white
                   transition-all duration-200"
        >

            Masuk

        </a>

        {{-- DAFTAR --}}
        <button
            onclick="bukaModal()"
            class="px-6 py-3 rounded-2xl
                   bg-[#6C8B6B]
                   hover:bg-[#587357]
                   text-white font-semibold
                   transition-all duration-200"
        >

            Daftar

        </button>

    @endauth

</div>

        </div>

    </nav>

    {{-- CONTENT --}}
    <main class="pt-[84px]">
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer class="bg-[#162818] mt-24 overflow-hidden relative">

        {{-- BACKGROUND — opacity dinaikkan supaya terlihat jelas --}}
        <div class="absolute inset-0 opacity-30">
            <img src="{{ asset('footer.png') }}" class="w-full h-full object-cover" alt="">
        </div>

        {{-- overlay gelap tipis agar teks tetap terbaca --}}
        <div class="absolute inset-0 bg-[#162818]/60"></div>

        <div class="relative z-10
                    max-w-7xl mx-auto
                    px-6 lg:px-8
                    py-20">

            <div class="grid lg:grid-cols-4 gap-14">

                {{-- BRAND --}}
                <div class="lg:col-span-2">

                    <div class="flex items-center gap-3 mb-6">
                        <img src="{{ asset('logo.png') }}" class="w-12 h-12 object-contain">
                        <h2 class="text-3xl font-extrabold text-white">
                            KosinAja!
                        </h2>
                    </div>

                    <p class="text-[#c7d5c8] leading-8 max-w-md">
                        Platform pencarian dan pengelolaan kos modern yang membantu pencari kos menemukan hunian nyaman
                        dengan cepat, aman, dan terpercaya.
                    </p>

                </div>

                {{-- MENU --}}
                <div>
                    <h3 class="text-white font-bold text-lg mb-6">Navigasi</h3>
                    <div class="flex flex-col gap-4">
                        <a href="{{ route('home') }}" class="text-[#c7d5c8] hover:text-white transition">Beranda</a>
                        <a href="{{ route('hubungi') }}" class="text-[#c7d5c8] hover:text-white transition">Hubungi
                            Kami</a>
                        <a href="{{ route('tentang') }}" class="text-[#c7d5c8] hover:text-white transition">Tentang
                            Kami</a>
                    </div>
                </div>

                {{-- CONTACT --}}
                <div>
                    <h3 class="text-white font-bold text-lg mb-6">Kontak</h3>
                    <div class="space-y-5">

                        {{-- Lokasi --}}
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-xl bg-[#223725]
                                        flex items-center justify-center shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-[#6C8B6B]" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 2C8.686 2 6 4.686 6 8c0 4.418 6 12 6 12s6-7.582 6-12c0-3.314-2.686-6-6-6z" />
                                    <circle cx="12" cy="8" r="2" fill="currentColor" stroke="none" />
                                </svg>
                            </div>
                            <p class="text-[#c7d5c8] leading-7 pt-1">
                                Banyuwangi, Indonesia
                            </p>
                        </div>

                        {{-- Email --}}
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-xl bg-[#223725]
                                        flex items-center justify-center shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-[#6C8B6B]" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <rect x="2" y="5" width="20" height="14" rx="2" stroke="currentColor"
                                        stroke-width="1.8" fill="none" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2 7l10 7 10-7" />
                                </svg>
                            </div>
                            <a href="mailto:twoorbital@gmail.com"
                                class="text-[#c7d5c8] hover:text-white transition pt-1">
                                twoorbital@gmail.com
                            </a>
                        </div>

                        {{-- Telepon --}}
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-xl bg-[#223725]
                                        flex items-center justify-center shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-[#6C8B6B]" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.6 10.8c1.4 2.8 3.8 5.1 6.6 6.6l2.2-2.2c.3-.3.7-.4 1-.2
                                             1.1.4 2.3.6 3.6.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1
                                             C9.6 21 3 14.4 3 6.4c0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1
                                             0 1.3.2 2.5.6 3.6.1.3 0 .7-.2 1L6.6 10.8z" />
                                </svg>
                            </div>
                            <a href="https://wa.me/6282264676843" target="_blank"
                                class="text-[#c7d5c8] hover:text-white transition pt-1">
                                (+62) 82264676843
                            </a>
                        </div>

                    </div>
                </div>

            </div>

            {{-- COPYRIGHT --}}
            <div class="border-t border-[#2b412d] mt-16 pt-8 text-center">
                <p class="text-[#91A392] text-sm">
                    © {{ date('Y') }} KosinAja! — Orbit
                </p>
            </div>

        </div>

    </footer>

    @include('auth.pilih-role')
    </div>

</body>

</html>