<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>KosinAja! - Super Admin</title>

    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">

    @vite([
    'resources/css/app.css',
    'resources/js/app.js'
    ])

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;700&display=swap"
        rel="stylesheet">

    <style>
    html {
        scroll-behavior: smooth;
    }

    body {
        font-family: 'DM Sans', sans-serif;
        background: #F8F5F0;
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

</head>

<body class="bg-[#F8F5F0] min-h-screen">

    {{-- SUCCESS --}}
    @if(session('success'))
    <div class="fixed top-5 right-5 bg-green-500 text-white px-5 py-3 rounded-lg shadow-lg z-50">
        {{ session('success') }}
    </div>
    @endif

    {{-- ERROR --}}
    @if(session('error'))
    <div class="fixed top-5 right-5 bg-red-500 text-white px-5 py-3 rounded-lg shadow-lg z-50">
        {{ session('error') }}
    </div>
    @endif

    {{-- ERROR --}}
    @if($errors->any())
    <div class="fixed top-5 right-5 bg-red-500 text-white px-5 py-3 rounded-lg shadow-lg z-50">
        <ul class="text-sm">
            @foreach($errors->all() as $e)
            <li>{{ $e }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- ========================================================= --}}
    {{-- NAVBAR ATAS --}}
    {{-- ========================================================= --}}
    <nav class="fixed top-0 left-0 right-0 z-50
                bg-white/85 backdrop-blur-xl
                border-b border-[#edf1ed]">

        <div class="max-w-full px-6 lg:px-8
                    h-[72px] lg:h-[84px]
                    flex items-center justify-between">

            {{-- LOGO --}}
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <img src="{{ asset('logo.png') }}" alt="KosinAja" class="w-9 h-9 lg:w-11 lg:h-11 object-contain">
                <span class="text-[20px] lg:text-[24px] font-extrabold text-[#102313]">KosinAja!</span>
            </a>

            {{-- MENU NAVIGASI --}}
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

            {{-- PROFILE DROPDOWN --}}
            <div class="relative group">

                <button type="button" class="flex items-center gap-3">

                    <div class="w-11 h-11 rounded-full overflow-hidden border-2 border-[#6C8B6B]">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->nama) }}"
                            class="w-full h-full object-cover" alt="Profil">
                    </div>

                    <div class="hidden md:block text-left">
                        <p class="text-sm text-gray-400">Halo,</p>
                        <h4 class="font-semibold text-[#1B2B1D]">{{ auth()->user()->nama }}</h4>
                    </div>

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>

                </button>

                {{-- DROPDOWN --}}
                <div class="absolute right-0 mt-4
                            w-64 bg-white rounded-2xl
                            shadow-xl border border-gray-100
                            opacity-0 invisible translate-y-2
                            group-hover:opacity-100
                            group-hover:visible
                            group-hover:translate-y-0
                            transition-all duration-200
                            overflow-hidden z-50">

                    <a href="{{ route('superadmin.profil') }}"
                        class="flex items-center gap-3 px-5 py-4 hover:bg-gray-50 transition">
                        <span class="font-medium">Profil Saya</span>
                    </a>

                    <a href="{{ route('superadmin.dashboard') }}"
                        class="flex items-center gap-3 px-5 py-4 hover:bg-gray-50 transition border-t border-gray-100">
                        <span class="font-medium">Dashboard Super Admin</span>
                    </a>

                    <form method="POST" action="{{ route('logout') }}" class="border-t border-gray-100">
                        @csrf
                        <button type="submit"
                            class="w-full text-left flex items-center gap-3 px-5 py-4 hover:bg-red-50 text-red-500 transition">
                            <span class="font-medium">Logout</span>
                        </button>
                    </form>

                </div>

            </div>

        </div>

    </nav>

    {{-- ========================================================= --}}
    {{-- LAYOUT --}}
    {{-- ========================================================= --}}
    <div class="flex min-h-screen pt-[72px] lg:pt-[84px]">

        {{-- ========================================================= --}}
        {{-- SIDEBAR --}}
        {{-- ========================================================= --}}
        <aside class="w-64 bg-white border-r border-gray-100
                      fixed top-[72px] lg:top-[84px]
                      h-[calc(100vh-72px)] lg:h-[calc(100vh-84px)]
                      flex flex-col justify-between">

            <div>

                {{-- USER --}}
                <div class="px-6 py-5 border-b border-gray-100">
                    <p class="text-sm font-semibold text-[#0F0937]">{{ auth()->user()->nama }}</p>
                    <p class="text-xs text-gray-400">Super Administrator</p>
                </div>

                {{-- MENU --}}
                <nav class="px-4 py-4 space-y-1">

                    @php
                    $menuClass = 'flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition';
                    $activeClass = 'bg-[#D6E5D6] text-[#3A5C3A]';
                    $inactiveClass = 'text-gray-500 hover:bg-gray-100';
                    @endphp

                    {{-- DASHBOARD --}}
                    <a href="{{ route('superadmin.dashboard') }}"
                        class="{{ $menuClass }} {{ request()->routeIs('superadmin.dashboard') ? $activeClass : $inactiveClass }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Dashboard
                    </a>

                    {{-- PENGAJUAN --}}
                    <a href="{{ route('superadmin.pengajuan.index') }}"
                        class="{{ $menuClass }} {{ request()->routeIs('superadmin.pengajuan.*') ? $activeClass : $inactiveClass }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        Pengajuan
                    </a>

                    {{-- RIWAYAT --}}
                    <a href="{{ route('superadmin.riwayat.index') }}"
                        class="{{ $menuClass }} {{ request()->routeIs('superadmin.riwayat.*') ? $activeClass : $inactiveClass }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Riwayat
                    </a>

                    {{-- FASILITAS --}}
                    <a href="{{ route('superadmin.fasilitas.index') }}"
                        class="{{ $menuClass }} {{ request()->routeIs('superadmin.fasilitas.*') ? $activeClass : $inactiveClass }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 7h18M3 12h18M3 17h18" />
                        </svg>
                        Daftar Fasilitas Kos
                    </a>

                    {{-- MASTER PERIODE PENAGIHAN --}}
                    <a href="{{ route('superadmin.periode.index') }}"
                        class="{{ $menuClass }} {{ request()->routeIs('superadmin.periode.*') ? $activeClass : $inactiveClass }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3M5 11h14M5 5h14a2 2 0 012 2v12a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2z" />
                        </svg>
                        Periode Penagihan
                    </a>

                </nav>

            </div>

            {{-- LOGOUT --}}
            <div class="p-4 border-t border-gray-100">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full bg-red-50 hover:bg-red-100 text-red-500 py-3 rounded-xl text-sm font-semibold transition">
                        Logout
                    </button>
                </form>
            </div>

        </aside>

        {{-- ========================================================= --}}
        {{-- CONTENT --}}
        {{-- ========================================================= --}}
        <main class="ml-64 flex-1 p-8">
            @yield('content')
        </main>

    </div>

</body>

</html>