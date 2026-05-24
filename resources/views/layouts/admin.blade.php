<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>

        KosinAja! - Admin Kost

    </title>

    @vite([

        'resources/css/app.css',
        'resources/js/app.js'

    ])

</head>

<body class="bg-[#F8F5F0] font-sans">

<div class="flex min-h-screen">

    {{-- ========================================================= --}}
    {{-- SIDEBAR --}}
    {{-- ========================================================= --}}
    <aside class="w-64 bg-white border-r border-gray-100
                  fixed h-full flex flex-col justify-between">

        <div>

            {{-- ========================================================= --}}
            {{-- LOGO --}}
            {{-- ========================================================= --}}
            <div class="flex items-center gap-3
                        px-6 py-6 border-b border-gray-100">

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

            {{-- ========================================================= --}}
            {{-- USER --}}
            {{-- ========================================================= --}}
            <div class="px-6 py-5 border-b border-gray-100">

                <p class="text-sm font-semibold text-[#0F0937]">

                    {{ auth()->user()->nama }}

                </p>

                <p class="text-xs text-gray-400">

                    {{ auth()->user()->username }}

                </p>

            </div>

            {{-- ========================================================= --}}
            {{-- MENU --}}
            {{-- ========================================================= --}}
            <nav class="px-4 py-4 space-y-1">

                @php

                    $menuClass = '

                        flex items-center gap-3
                        px-4 py-3 rounded-xl
                        text-sm font-medium
                        transition

                    ';

                    $activeClass = '

                        bg-[#D6E5D6]
                        text-[#3A5C3A]

                    ';

                    $inactiveClass = '

                        text-gray-500
                        hover:bg-gray-100

                    ';

                @endphp

              {{-- ========================================================= --}}
{{-- DASHBOARD --}}
{{-- ========================================================= --}}
<a
    href="{{ route('admin.dashboard') }}"
    class="{{ $menuClass }}
           {{ request()->routeIs('admin.dashboard')
                ? $activeClass
                : $inactiveClass }}"
>

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

{{-- ========================================================= --}}
{{-- PENGAJUAN --}}
{{-- ========================================================= --}}
<a
    href="{{ route('admin.pengajuan.index') }}"
    class="{{ $menuClass }}
           {{ request()->routeIs('admin.pengajuan.*')
                ? $activeClass
                : $inactiveClass }}"
>

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

    Pengajuan Penghuni

</a>

{{-- ========================================================= --}}
{{-- PENGHUNI --}}
{{-- ========================================================= --}}
<a
    href="{{ route('admin.penghuni.aktif') }}"
    class="{{ $menuClass }}
           {{ request()->routeIs('admin.penghuni.*')
                ? $activeClass
                : $inactiveClass }}"
>

    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-5 w-5"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                        />

                    </svg>

    Penghuni

</a>

{{-- ========================================================= --}}
{{-- KAMAR --}}
{{-- ========================================================= --}}
<a
    href="{{ route('admin.kamar.index') }}"
    class="{{ $menuClass }}
           {{ request()->routeIs('admin.kamar.*')
                ? $activeClass
                : $inactiveClass }}"
>

   <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"fill="none" viewBox="0 0 24 24" stroke="currentColor">

    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"
    />

</svg>
    Daftar Kamar
</a>

{{-- ========================================================= --}}
{{-- PEMBAYARAN --}}
{{-- ========================================================= --}}
<a
    href="{{ route('admin.tagihan.index') }}"
    class="{{ $menuClass }}
           {{ request()->routeIs('admin.tagihan.*')
                ? $activeClass
                : $inactiveClass }}"
>

    <svg xmlns="http://www.w3.org/2000/svg"
         class="w-5 h-5"
         fill="none"
         viewBox="0 0 24 24"
         stroke="currentColor">

        <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M17 9V7a5 5 0 00-10 0v2M5 9h14l1 10H4L5 9z"
        />

    </svg>

   Tagihan

</a>

{{-- ========================================================= --}}
{{-- ADUAN --}}
{{-- ========================================================= --}}
<a
    href="{{ route('admin.aduan.index') }}"
    class="{{ $menuClass }}
           {{ request()->routeIs('admin.aduan.*')
                ? $activeClass
                : $inactiveClass }}"
>

    <svg xmlns="http://www.w3.org/2000/svg"
         class="w-5 h-5"
         fill="none"
         viewBox="0 0 24 24"
         stroke="currentColor">

        <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-4l-4 4v-4z"
        />

    </svg>

    Aduan

</a>

{{-- ========================================================= --}}
{{-- ATURAN --}}
{{-- ========================================================= --}}
<a
    href="{{ route('admin.aturan.index') }}"
    class="{{ $menuClass }}
           {{ request()->routeIs('admin.aturan.*')
                ? $activeClass
                : $inactiveClass }}"
>

    <svg xmlns="http://www.w3.org/2000/svg"
         class="w-5 h-5"
         fill="none"
         viewBox="0 0 24 24"
         stroke="currentColor">

        <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M9 12h6m-6 4h6M7 4h10a2 2 0 012 2v12a2 2 0 01-2 2H7a2 2 0 01-2-2V6a2 2 0 012-2z"
        />

    </svg>

    Aturan Kos

</a>

{{-- ========================================================= --}}
{{-- INFORMASI KOS --}}
{{-- ========================================================= --}}
<a
    href="{{ route('admin.kost.index') }}"
    class="{{ $menuClass }}
           {{ request()->routeIs('admin.kost.*')
                ? $activeClass
                : $inactiveClass }}"
>

    <svg xmlns="http://www.w3.org/2000/svg"
         class="w-5 h-5"
         fill="none"
         viewBox="0 0 24 24"
         stroke="currentColor">

        <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M13 16h-1v-4h-1m1-4h.01M12 18h.01"
        />

    </svg>

    Informasi Kos

</a>
            </nav>

        </div>

        {{-- ========================================================= --}}
        {{-- LOGOUT --}}
        {{-- ========================================================= --}}
        <div class="p-4 border-t border-gray-100">

            <form
                method="POST"
                action="{{ route('logout') }}"
            >

                @csrf

                <button
                    type="submit"
                    class="w-full bg-red-50 hover:bg-red-100
                           text-red-500 py-3 rounded-xl
                           text-sm font-semibold transition"
                >

                    Logout

                </button>

            </form>

        </div>

    </aside>

    {{-- ========================================================= --}}
    {{-- CONTENT --}}
    {{-- ========================================================= --}}
    <main class="ml-64 flex-1 p-8">

        {{-- SUCCESS --}}
        @if(session('success'))

            <div class="mb-5 bg-green-100 border border-green-200
                        text-green-700 px-5 py-4 rounded-xl">

                {{ session('success') }}

            </div>

        @endif

        {{-- ERROR --}}
        @if($errors->any())

            <div class="mb-5 bg-red-100 border border-red-200
                        text-red-700 px-5 py-4 rounded-xl">

                <ul class="list-disc list-inside text-sm">

                    @foreach($errors->all() as $e)

                        <li>

                            {{ $e }}

                        </li>

                    @endforeach

                </ul>

            </div>

        @endif

        @yield('content')

    </main>

</div>

</body>

</html>