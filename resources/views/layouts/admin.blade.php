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
                    🏠 Dashboard
                </a>

                <a href="{{ route('admin.kamar.index') }}"
                   class="{{ $menuClass }} {{ request()->routeIs('admin.kamar.*') ? $activeClass : $inactiveClass }}">
                    🛏 Daftar Kamar
                </a>

                <a href="{{ route('admin.penghuni.index') }}"
                   class="{{ $menuClass }} {{ request()->routeIs('admin.penghuni.*') ? $activeClass : $inactiveClass }}">
                    👥 Penghuni
                </a>

                <a href="{{ route('admin.tagihan.index') }}"
                   class="{{ $menuClass }} {{ request()->routeIs('admin.pembayaran.*') ? $activeClass : $inactiveClass }}">
                    💳 Pembayaran
                </a>

                <a href="#"
                   class="{{ $menuClass }} {{ request()->routeIs('admin.aduan.*') ? $activeClass : $inactiveClass }}">
                    📢 Aduan
                </a>

                <a href="#"
                   class="{{ $menuClass }} {{ request()->routeIs('admin.aturan.*') ? $activeClass : $inactiveClass }}">
                    📄 Aturan Kos
                </a>

                <a href="{{ route('admin.kost.edit') }}"
   class="{{ $menuClass }} {{ request()->routeIs('kost.*') ? $activeClass : $inactiveClass }}">
    ℹ Informasi Kos
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