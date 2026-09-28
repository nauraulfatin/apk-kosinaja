<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KosinAja! - Penghuni</title>

    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

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
</head>

<body class="bg-[#FDFBF7] min-h-screen">

    {{-- Alert Success --}}
    @if(session('success'))
    <div class="fixed top-5 right-5 bg-green-500 text-white px-5 py-3 rounded-lg shadow-lg z-50">
        {{ session('success') }}
    </div>
    @endif

    {{-- Alert Error --}}
    @if($errors->any())
    <div class="fixed top-5 right-5 bg-red-500 text-white px-5 py-3 rounded-lg shadow-lg z-50">
        <ul class="text-sm">
            @foreach($errors->all() as $e)
            <li>{{ $e }}</li>
            @endforeach
        </ul>
    </div>
    @endif

<x-navbar />

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
                    <p class="text-xs text-gray-400">Penghuni Kost</p>
                </div>

                {{-- MENU --}}
                <nav class="px-4 py-4 space-y-1">

                    @php
                    $menuClass = 'flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition';
                    $activeClass = 'bg-[#D6E5D6] text-[#3A5C3A]';
                    $inactiveClass = 'text-gray-500 hover:bg-gray-100';
                    @endphp

                    {{-- DASHBOARD --}}
                    <a href="{{ route('penghuni.dashboard') }}"
                        class="{{ $menuClass }} {{ request()->routeIs('penghuni.dashboard') ? $activeClass : $inactiveClass }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Dashboard
                    </a>

                    {{-- TAGIHAN --}}
                    <a href="{{ route('penghuni.pembayaran.index') }}"
                        class="{{ $menuClass }} {{ request()->routeIs('penghuni.pembayaran.*') ? $activeClass : $inactiveClass }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 1v22m5-18H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H7" />
                        </svg>
                        Tagihan
                    </a>

                    {{-- ATURAN --}}
                    <a href="{{ route('penghuni.aturan.index') }}"
                        class="{{ $menuClass }} {{ request()->routeIs('penghuni.aturan.*') ? $activeClass : $inactiveClass }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        Aturan Kos
                    </a>

                    {{-- ADUAN --}}
                    <a href="{{ route('penghuni.aduan.index') }}"
                        class="{{ $menuClass }} {{ request()->routeIs('penghuni.aduan.*') ? $activeClass : $inactiveClass }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-4 4v-4z" />
                        </svg>
                        Aduan
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