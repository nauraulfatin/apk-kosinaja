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
    <div
        class="fixed top-20 sm:top-5 left-4 right-4 sm:left-auto sm:right-5 bg-green-500 text-white px-5 py-3 rounded-lg shadow-lg z-[60]">
        {{ session('success') }}
    </div>
    @endif

    {{-- ERROR --}}
    @if(session('error'))
    <div
        class="fixed top-20 sm:top-5 left-4 right-4 sm:left-auto sm:right-5 bg-red-500 text-white px-5 py-3 rounded-lg shadow-lg z-[60]">
        {{ session('error') }}
    </div>
    @endif

    {{-- ERROR --}}
    @if($errors->any())
    <div
        class="fixed top-20 sm:top-5 left-4 right-4 sm:left-auto sm:right-5 bg-red-500 text-white px-5 py-3 rounded-lg shadow-lg z-[60]">
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
    <x-navbar />

    {{-- ========================================================= --}}
    {{-- LAYOUT --}}
    {{-- ========================================================= --}}
    <div class="flex min-h-screen pt-[72px] lg:pt-[84px]">

        {{-- OVERLAY (khusus mobile) --}}
        <div id="sidebarOverlay" onclick="closeSidebar()"
            class="hidden fixed inset-x-0 bottom-0 top-[72px] bg-black/40 z-30 lg:hidden"></div>

        {{-- ========================================================= --}}
        {{-- SIDEBAR --}}
        {{-- Mobile: tersembunyi, geser masuk saat tombol menu ditekan --}}
        {{-- Desktop (lg+): selalu tampil --}}
        {{-- ========================================================= --}}
        <aside id="sidebar" class="w-64 bg-white border-r border-gray-100
                      fixed top-[72px] lg:top-[84px] left-0
                      h-[calc(100vh-72px)] lg:h-[calc(100vh-84px)]
                      flex flex-col justify-between overflow-y-auto
                      z-40
                      -translate-x-full lg:translate-x-0
                      transition-transform duration-300 ease-in-out">

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
        <main class="lg:ml-64 flex-1 min-w-0">

            {{-- BAR TOMBOL MENU (khusus mobile, menempel di bawah navbar) --}}
            <div class="lg:hidden sticky top-[72px] z-20 bg-[#F8F5F0]/95 backdrop-blur
                        border-b border-gray-100 px-4 py-2.5">
                <button type="button" id="sidebarToggle" onclick="toggleSidebar()" class="inline-flex items-center gap-2 px-3 py-2 rounded-xl bg-white border border-gray-200
                           text-sm font-semibold text-[#3A5C3A] shadow-sm active:scale-95 transition"
                    aria-controls="sidebar" aria-expanded="false" aria-label="Buka menu">
                    <svg id="iconMenu" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg id="iconClose" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Menu
                </button>
            </div>

            <div class="p-4 sm:p-6 lg:p-8">
                @yield('content')
            </div>

        </main>

    </div>

    {{-- ========================================================= --}}
    {{-- SCRIPT SIDEBAR MOBILE --}}
    {{-- ========================================================= --}}
    <script>
    const sidebar = document.getElementById('sidebar');
    const sidebarOverlay = document.getElementById('sidebarOverlay');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const iconMenu = document.getElementById('iconMenu');
    const iconClose = document.getElementById('iconClose');

    function openSidebar() {
        sidebar.classList.remove('-translate-x-full');
        sidebarOverlay.classList.remove('hidden');
        iconMenu.classList.add('hidden');
        iconClose.classList.remove('hidden');
        sidebarToggle.setAttribute('aria-expanded', 'true');
        document.body.classList.add('overflow-hidden', 'lg:overflow-auto');
    }

    function closeSidebar() {
        sidebar.classList.add('-translate-x-full');
        sidebarOverlay.classList.add('hidden');
        iconMenu.classList.remove('hidden');
        iconClose.classList.add('hidden');
        sidebarToggle.setAttribute('aria-expanded', 'false');
        document.body.classList.remove('overflow-hidden', 'lg:overflow-auto');
    }

    function toggleSidebar() {
        sidebar.classList.contains('-translate-x-full') ? openSidebar() : closeSidebar();
    }

    // Tutup sidebar saat menu/link di dalamnya ditekan
    sidebar.querySelectorAll('a').forEach(function(link) {
        link.addEventListener('click', closeSidebar);
    });

    // Tutup dengan tombol Esc
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeSidebar();
    });

    // Reset state kalau layar diperbesar ke desktop
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 1024) closeSidebar();
    });
    </script>

</body>

</html>