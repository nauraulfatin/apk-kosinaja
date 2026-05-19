<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KosinAja! - Admin Kost</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#F8F5F0] font-sans">

<div class="flex min-h-screen">

    {{-- SIDEBAR --}}
    <aside class="w-64 bg-white border-r border-gray-100 fixed h-full flex flex-col justify-between">

        <div>

            {{-- LOGO --}}
            <div class="flex items-center gap-3 px-6 py-6 border-b border-gray-100">

                <img
                    src="{{ asset('logo.png') }}"
                    alt="Logo"
                    class="h-11 w-11 object-contain"
                >

                <div>
                    <h1 class="text-xl font-bold text-[#0F0937]">
                        KosinAja!
                    </h1>

                    <p class="text-xs text-gray-400">
                        Admin Kost
                    </p>
                </div>

            </div>

            {{-- USER --}}
            <div class="px-6 py-5 border-b border-gray-100">

                <p class="text-sm font-semibold text-[#0F0937]">
                    {{ auth()->user()->nama }}
                </p>

                <p class="text-xs text-gray-400">
                    {{ auth()->user()->username }}
                </p>

            </div>

            {{-- MENU --}}
            <nav class="px-4 py-4 space-y-1">

                @php
                    $menuClass = 'flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition';

                    $activeClass = 'bg-[#D6E5D6] text-[#3A5C3A]';

                    $inactiveClass = 'text-gray-500 hover:bg-gray-100';
                @endphp

                <a href="{{ route('admin.dashboard') }}"
                   class="{{ $menuClass }} {{ request()->routeIs('admin.dashboard') ? $activeClass : $inactiveClass }}">
                   
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-5 w-5"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"
                        />

                    </svg> 

                    Dashboard
                </a>

                <a href="{{ route('admin.kamar.index') }}"
                   class="{{ $menuClass }} {{ request()->routeIs('admin.kamar.*') ? $activeClass : $inactiveClass }}">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-5 w-5"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M3 7h18M3 12h18M3 17h18"
                        />

                    </svg>

                    Daftar Kamar
                </a>

                {{-- ========================================================= --}}
{{-- PENGAJUAN PENGHUNI --}}
{{-- ========================================================= --}}
<a
    href="{{ route('admin.pengajuan.index') }}"
    class="flex items-center gap-3 px-4 py-3 rounded-xl
           hover:bg-[#F5F7F5]
           {{ request()->routeIs('admin.pengajuan.*')
                ? 'bg-[#E8F0E8] text-[#4F6B4F] font-semibold'
                : 'text-gray-600'
           }}"
>

    👥

    <span>

        Pengajuan Penghuni

    </span>

</a>

{{-- ========================================================= --}}
{{-- PENGHUNI AKTIF --}}
{{-- ========================================================= --}}
<a
    href="{{ route('admin.penghuni.index') }}"
    class="flex items-center gap-3 px-4 py-3 rounded-xl
           hover:bg-[#F5F7F5]
           {{ request()->routeIs('admin.penghuni.*')
                ? 'bg-[#E8F0E8] text-[#4F6B4F] font-semibold'
                : 'text-gray-600'
           }}"
>

    🏠

    <span>

        Penghuni Aktif

    </span>

</a>

                <a href="{{ route('admin.tagihan.index') }}"
                   class="{{ $menuClass }} {{ request()->routeIs('admin.pembayaran.*') ? $activeClass : $inactiveClass }}">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-5 w-5"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 1v22m5-18H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H7"
                        />

                    </svg>

                    Pembayaran
                </a>

                {{-- MENU ADUAN --}}
                <a href="{{ route('admin.aduan.index') }}"
                   class="{{ $menuClass }} {{ request()->routeIs('admin.aduan.*') ? $activeClass : $inactiveClass }}">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-5 w-5"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-4 4v-4z"
                        />

                    </svg>

                    Aduan
                </a>

                <a href="{{ route('admin.aturan.index') }}"
                   class="{{ $menuClass }} {{ request()->routeIs('admin.aturan.*') ? $activeClass : $inactiveClass }}">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-5 w-5"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"
                        />

                    </svg>

                    Aturan Kos
                </a>

                <a href="{{ route('admin.kost.index') }}"
                   class="{{ $menuClass }} {{ request()->routeIs('kost.*') ? $activeClass : $inactiveClass }}">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-5 w-5"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M12 20h.01M12 4a8 8 0 100 16 8 8 0 000-16z"
                        />

                    </svg>

                    Informasi Kos
                </a>

            </nav>

        </div>

        {{-- LOGOUT --}}
        <div class="p-4 border-t border-gray-100">

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button
                    type="submit"
                    class="w-full bg-red-50 hover:bg-red-100 text-red-500 py-3 rounded-xl text-sm font-semibold transition"
                >
                    Logout
                </button>

            </form>

        </div>

    </aside>

    {{-- CONTENT --}}
    <main class="ml-64 flex-1 p-8">

        @if(session('success'))
            <div class="mb-5 bg-green-100 border border-green-200 text-green-700 px-5 py-4 rounded-xl">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-5 bg-red-100 border border-red-200 text-red-700 px-5 py-4 rounded-xl">
                <ul class="list-disc list-inside text-sm">
                    @foreach($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')

    </main>

</div>

</body>
</html>