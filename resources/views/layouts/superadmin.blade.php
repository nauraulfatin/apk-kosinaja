<!DOCTYPE html>
<html lang="id">
<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        KosinAja! - Super Admin
    </title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

</head>

<body class="bg-[#F8F5F0] font-sans">

<div class="flex min-h-screen">

    {{-- ===================================================== --}}
    {{-- SIDEBAR --}}
    {{-- ===================================================== --}}
    <aside
        class="w-64 bg-white border-r border-gray-100 fixed h-full flex flex-col justify-between"
    >

        <div>

            {{-- ===================================================== --}}
            {{-- LOGO --}}
            {{-- ===================================================== --}}
            <div
                class="flex items-center gap-3 px-6 py-6 border-b border-gray-100"
            >

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
                        Super Admin
                    </p>

                </div>

            </div>

            {{-- ===================================================== --}}
            {{-- USER --}}
            {{-- ===================================================== --}}
            <div
                class="px-6 py-5 border-b border-gray-100"
            >

                <p class="text-sm font-semibold text-[#0F0937]">

                    {{ auth()->user()->nama }}

                </p>

                <p class="text-xs text-gray-400">
                    Super Administrator
                </p>

            </div>

            {{-- ===================================================== --}}
{{-- MENU --}}
{{-- ===================================================== --}}
<nav class="px-4 py-4 space-y-1">

    @php

        $menuClass =
            'flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition';

        $activeClass =
            'bg-[#D6E5D6] text-[#3A5C3A]';

        $inactiveClass =
            'text-gray-500 hover:bg-gray-100';

    @endphp

    {{-- DASHBOARD --}}
    <a
        href="{{ route('superadmin.dashboard') }}"
        class="{{ $menuClass }}
        {{ request()->routeIs('superadmin.dashboard')
            ? $activeClass
            : $inactiveClass }}"
    >

        🏠 Dashboard

    </a>

    {{-- PENGAJUAN --}}
    <a
        href="{{ route('superadmin.pengajuan.index') }}"
        class="{{ $menuClass }}
        {{ request()->routeIs('superadmin.pengajuan.*')
            ? $activeClass
            : $inactiveClass }}"
    >

        📋 Pengajuan

    </a>

    {{-- RIWAYAT --}}
    <a
        href="{{ route('superadmin.riwayat.index') }}"
        class="{{ $menuClass }}
        {{ request()->routeIs('superadmin.riwayat.*')
            ? $activeClass
            : $inactiveClass }}"
    >

        🕘 Riwayat

    </a>

    {{-- MASTER FASILITAS --}}
    <a
        href="{{ route('superadmin.fasilitas.index') }}"
        class="{{ $menuClass }}
        {{ request()->routeIs('superadmin.fasilitas.*')
            ? $activeClass
            : $inactiveClass }}"
    >

        🛏️ Master Fasilitas

    </a>

</nav>

        {{-- ===================================================== --}}
        {{-- LOGOUT --}}
        {{-- ===================================================== --}}
        <div class="p-4 border-t border-gray-100">

            <form
                method="POST"
                action="{{ route('logout') }}"
            >

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

    {{-- ===================================================== --}}
    {{-- CONTENT --}}
    {{-- ===================================================== --}}
    <main class="ml-64 flex-1 p-8">

        {{-- SUCCESS --}}
        @if(session('success'))

        <div
            class="mb-5 bg-green-100 border border-green-200 text-green-700 px-5 py-4 rounded-xl"
        >

            {{ session('success') }}

        </div>

        @endif

        {{-- ERROR --}}
        @if($errors->any())

        <div
            class="mb-5 bg-red-100 border border-red-200 text-red-700 px-5 py-4 rounded-xl"
        >

            <ul class="list-disc list-inside text-sm">

                @foreach($errors->all() as $e)

                <li>
                    {{ $e }}
                </li>

                @endforeach

            </ul>

        </div>

        @endif

        {{-- PAGE CONTENT --}}
        @yield('content')

    </main>

</div>

</body>
</html>