<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'KosinAja!')</title>

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

        #mobileMenu {
            position: fixed;
            top: 72px;
            left: 0;
            right: 0;
            z-index: 40;
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
            transform: translateY(-12px);
            transition:
                opacity 0.25s ease,
                transform 0.25s ease,
                visibility 0.25s ease;
        }

        #mobileMenu.is-open {
            opacity: 1;
            visibility: visible;
            pointer-events: auto;
            transform: translateY(0);
        }

        #mobileMenuPanel {
            transform: translateY(-8px);
            transition: transform 0.25s ease;
        }

        #mobileMenu.is-open #mobileMenuPanel {
            transform: translateY(0);
        }

        .mobile-link {
            transition:
                background-color 0.2s ease,
                color 0.2s ease,
                transform 0.2s ease,
                border-color 0.2s ease;
        }

        .mobile-link:active {
            transform: scale(0.98);
        }

        #mobileMenuButton {
            transition:
                background-color 0.2s ease,
                transform 0.2s ease,
                border-color 0.2s ease,
                color 0.2s ease;
        }

        #mobileMenuButton:active {
            transform: scale(0.95);
        }

        #mobileMenuButton.is-active {
            background: #EEF5EE;
            border-color: #6C8B6B;
            color: #6C8B6B;
        }

        #mobileUserSubmenu {
            max-height: 0;
            overflow: hidden;
            opacity: 0;
            transform: translateY(-6px);
            transition:
                max-height 0.28s ease,
                opacity 0.22s ease,
                transform 0.22s ease,
                margin-top 0.22s ease;
            margin-top: 0;
        }

        #mobileUserSubmenu.is-open {
            max-height: 260px;
            opacity: 1;
            transform: translateY(0);
            margin-top: 12px;
        }

        #mobileUserArrow {
            transition: transform 0.22s ease;
        }

        #mobileUserArrow.is-open {
            transform: rotate(180deg);
        }

        @media (min-width: 1024px) {
            #mobileMenu {
                display: none !important;
            }
        }

        @media (max-width: 768px) {

            footer {
                margin-top: 40px !important;
            }

            footer .relative.z-10 {
                padding-top: 38px !important;
                padding-bottom: 22px !important;
            }

            footer .grid {
                gap: 28px !important;
            }

            footer img {
                width: 36px !important;
                height: 36px !important;
            }

            footer h2 {
                font-size: 1.45rem !important;
            }

            footer h3 {
                font-size: 0.95rem !important;
                margin-bottom: 12px !important;
            }

            footer p,
            footer a {
                font-size: 0.8rem !important;
                line-height: 1.6 !important;
            }

            footer .flex.flex-col.gap-4 {
                gap: 10px !important;
            }

            footer .space-y-5 {
                gap: 14px !important;
            }

            footer .w-10.h-10 {
                width: 34px !important;
                height: 34px !important;
                border-radius: 10px !important;
            }

            footer svg {
                width: 17px !important;
                height: 17px !important;
            }

            footer .border-t {
                margin-top: 24px !important;
                padding-top: 16px !important;
            }

            footer .border-t p {
                font-size: 0.72rem !important;
            }
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
                    h-[72px] lg:h-[84px]
                    flex items-center justify-between">

            {{-- LOGO --}}
            <a href="{{ route('home') }}" class="flex items-center gap-3">

                <img
                    src="{{ asset('logo.png') }}"
                    alt="KosinAja"
                    class="w-9 h-9 lg:w-11 lg:h-11 object-contain">

                <span class="text-[20px] lg:text-[30px] font-extrabold text-[#102313]">
                    KosinAja!
                </span>

            </a>

            {{-- DESKTOP MENU --}}
            <ul class="hidden lg:flex items-center gap-12">

                <li>
                    <a
                        href="{{ route('home') }}"
                        class="relative text-[15px] font-semibold transition-all duration-300 pb-2
                        {{ request()->is('/') ? 'text-[#6C8B6B]' : 'text-[#314233] hover:text-[#6C8B6B]' }}">

                        Beranda

                        @if(request()->is('/'))
                            <span class="absolute left-0 bottom-0 w-full h-[3px] rounded-full bg-[#6C8B6B]"></span>
                        @endif

                    </a>
                </li>

                <li>
                    <a
                        href="{{ route('tentang') }}"
                        class="relative text-[15px] font-semibold transition-all duration-300 pb-2
                        {{ request()->is('tentang') ? 'text-[#6C8B6B]' : 'text-[#314233] hover:text-[#6C8B6B]' }}">

                        Tentang

                        @if(request()->is('tentang'))
                            <span class="absolute left-0 bottom-0 w-full h-[3px] rounded-full bg-[#6C8B6B]"></span>
                        @endif

                    </a>
                </li>

                <li>
                    <a
                        href="{{ route('hubungi') }}"
                        class="relative text-[15px] font-semibold transition-all duration-300 pb-2
                        {{ request()->is('hubungi') ? 'text-[#6C8B6B]' : 'text-[#314233] hover:text-[#6C8B6B]' }}">

                        Hubungi

                        @if(request()->is('hubungi'))
                            <span class="absolute left-0 bottom-0 w-full h-[3px] rounded-full bg-[#6C8B6B]"></span>
                        @endif

                    </a>
                </li>

            </ul>

            {{-- MOBILE MENU BUTTON --}}
            <button
                id="mobileMenuButton"
                type="button"
                onclick="toggleMobileMenu()"
                aria-expanded="false"
                class="lg:hidden
                       w-10 h-10
                       rounded-xl
                       border border-gray-200
                       flex items-center justify-center
                       text-[#314233]">

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-5 h-5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor">

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h16" />

                </svg>

            </button>

            {{-- DESKTOP ACTION --}}
            <div class="hidden lg:flex items-center gap-4">

                @auth

                    {{-- PROFILE DROPDOWN --}}
                    <div class="relative group">

                        <button
                            type="button"
                            class="flex items-center gap-3">

                            <div class="w-11 h-11 rounded-full
                                        overflow-hidden border-2
                                        border-[#6C8B6B]">

                                <img
                                    src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->nama) }}"
                                    class="w-full h-full object-cover"
                                    alt="Profil">

                            </div>

                            <div class="hidden md:block text-left">

                                <p class="text-sm text-gray-400">
                                    Halo,
                                </p>

                                <h4 class="font-semibold text-[#1B2B1D]">
                                    {{ auth()->user()->nama }}
                                </h4>

                            </div>

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="w-4 h-4 text-gray-500"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor">

                                <path
                                    stroke-linecap="round"
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
                                    translate-y-2
                                    group-hover:opacity-100
                                    group-hover:visible
                                    group-hover:translate-y-0
                                    transition-all duration-200
                                    overflow-hidden z-50">

                            @if(auth()->user()->role === 'super admin')

                                <a
                                    href="{{ route('superadmin.profil') }}"
                                    class="flex items-center gap-3 px-5 py-4 hover:bg-gray-50 transition">

                                    <span class="font-medium">
                                        Profil Saya
                                    </span>

                                </a>

                                <a
                                    href="{{ route('superadmin.dashboard') }}"
                                    class="flex items-center gap-3 px-5 py-4 hover:bg-gray-50 transition">

                                    <span class="font-medium">
                                        Dashboard Super Admin
                                    </span>

                                </a>

                            @elseif(auth()->user()->role === 'admin kost')

                                <a
                                    href="{{ route('admin.profil.index') }}"
                                    class="flex items-center gap-3 px-5 py-4 hover:bg-gray-50 transition">

                                    <span class="font-medium">
                                        Profil Saya
                                    </span>

                                </a>

                                @if(auth()->user()->status === 'aktif')

                                    <a
                                        href="{{ route('admin.dashboard') }}"
                                        class="flex items-center gap-3 px-5 py-4 hover:bg-gray-50 transition">

                                        <span class="font-medium">
                                            Dashboard Saya
                                        </span>

                                    </a>

                                @endif

                            @elseif(auth()->user()->role === 'penghuni kost')

                                <a
                                    href="{{ route('penghuni.profil.index') }}"
                                    class="flex items-center gap-3 px-5 py-4 hover:bg-gray-50 transition">

                                    <span class="font-medium">
                                        Profil Saya
                                    </span>

                                </a>

                                @if(auth()->user()->riwayatHunian()->where('status', 'aktif')->exists())

                                    <a
                                        href="{{ route('penghuni.dashboard') }}"
                                        class="flex items-center gap-3 px-5 py-4 hover:bg-gray-50 transition">

                                        <span class="font-medium">
                                            Dashboard Saya
                                        </span>

                                    </a>

                                @endif

                            @endif

                            {{-- LOGOUT --}}
                            <form
                                method="POST"
                                action="{{ route('logout') }}">

                                @csrf

                                <button
                                    type="submit"
                                    class="w-full text-left
                                           flex items-center gap-3
                                           px-5 py-4 hover:bg-red-50
                                           text-red-500 transition">

                                    <span class="font-medium">
                                        Logout
                                    </span>

                                </button>

                            </form>

                        </div>

                    </div>

                @else

                    <a
                        href="{{ route('login') }}"
                        class="px-4 py-2.5 lg:px-6 lg:py-3
                               text-sm lg:text-base rounded-2xl
                               border border-[#6C8B6B]
                               text-[#6C8B6B]
                               font-semibold
                               hover:bg-[#6C8B6B]
                               hover:text-white
                               transition-all duration-200">

                        Masuk

                    </a>

                    <button
                        type="button"
                        onclick="bukaModal()"
                        class="px-4 py-2.5 lg:px-6 lg:py-3
                               text-sm lg:text-base rounded-2xl
                               bg-[#6C8B6B]
                               hover:bg-[#587357]
                               text-white font-semibold
                               transition-all duration-200">

                        Daftar

                    </button>

                @endauth

            </div>

        </div>

    </nav>

    {{-- MOBILE MENU --}}
    <div id="mobileMenu" class="lg:hidden">

        <div
            id="mobileMenuPanel"
            class="bg-white
                   border-b border-gray-100
                   shadow-lg">

            <div class="px-5 py-5 flex flex-col gap-3">

                {{-- BERANDA --}}
                <a
                    href="{{ route('home') }}"
                    onclick="closeMobileMenu()"
                    class="mobile-link font-semibold text-sm
                           px-4 py-3 rounded-2xl
                           hover:bg-[#F4F7F4]
                           {{ request()->is('/') ? 'bg-[#EEF5EE] text-[#6C8B6B]' : 'text-[#314233]' }}">

                    Beranda

                </a>

                {{-- TENTANG --}}
                <a
                    href="{{ route('tentang') }}"
                    onclick="closeMobileMenu()"
                    class="mobile-link font-semibold text-sm
                           px-4 py-3 rounded-2xl
                           hover:bg-[#F4F7F4]
                           {{ request()->is('tentang') ? 'bg-[#EEF5EE] text-[#6C8B6B]' : 'text-[#314233]' }}">

                    Tentang

                </a>

                {{-- HUBUNGI --}}
                <a
                    href="{{ route('hubungi') }}"
                    onclick="closeMobileMenu()"
                    class="mobile-link font-semibold text-sm
                           px-4 py-3 rounded-2xl
                           hover:bg-[#F4F7F4]
                           {{ request()->is('hubungi') ? 'bg-[#EEF5EE] text-[#6C8B6B]' : 'text-[#314233]' }}">

                    Hubungi

                </a>

                {{-- USER CARD --}}
                @auth

                    <div class="mt-2 pt-4 border-t border-gray-100">

                        <div class="bg-[#F8F5F0]
                                    rounded-[22px]
                                    p-3">

                            {{-- USER HEADER / TOGGLE --}}
                            <button
                                type="button"
                                onclick="toggleMobileUserMenu()"
                                class="w-full flex items-center justify-between gap-3
                                       text-left
                                       rounded-[18px]
                                       transition">

                                <div class="flex items-center gap-3 min-w-0">

                                    <div class="w-10 h-10 rounded-full
                                                overflow-hidden
                                                border border-[#6C8B6B]
                                                shrink-0">

                                        <img
                                            src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->nama) }}"
                                            class="w-full h-full object-cover"
                                            alt="Profil">

                                    </div>

                                    <div class="min-w-0">

                                        <p class="text-[10px] text-gray-400 leading-none mb-1">
                                            Halo,
                                        </p>

                                        <h4 class="font-bold text-[#1B2B1D] text-sm truncate">
                                            {{ auth()->user()->nama }}
                                        </h4>

                                        <p class="text-[11px] text-gray-500 capitalize mt-0.5">
                                            {{ auth()->user()->role }}
                                        </p>

                                    </div>

                                </div>

                                <div
                                    id="mobileUserArrow"
                                    class="w-8 h-8 rounded-full
                                           bg-white
                                           border border-gray-100
                                           flex items-center justify-center
                                           text-[#6C8B6B]
                                           shrink-0">

                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="w-4 h-4"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor">

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M19 9l-7 7-7-7" />

                                    </svg>

                                </div>

                            </button>

                            {{-- CHILD MENU --}}
                            <div id="mobileUserSubmenu">

                                <div class="bg-white rounded-[18px] overflow-hidden border border-gray-100">

                                    @if(auth()->user()->role === 'super admin')

                                        <a
                                            href="{{ route('superadmin.profil') }}"
                                            onclick="closeMobileMenu()"
                                            class="mobile-link flex items-center justify-between
                                                   px-4 py-3
                                                   text-sm font-semibold
                                                   hover:bg-[#F4F7F4]
                                                   {{ request()->routeIs('superadmin.profil') ? 'text-[#6C8B6B] bg-[#EEF5EE]' : 'text-[#314233]' }}">

                                            <span>Profil Saya</span>
                                            <span class="text-gray-400">›</span>

                                        </a>

                                        <a
                                            href="{{ route('superadmin.dashboard') }}"
                                            onclick="closeMobileMenu()"
                                            class="mobile-link flex items-center justify-between
                                                   px-4 py-3
                                                   text-sm font-semibold text-[#314233]
                                                   hover:bg-[#F4F7F4]
                                                   border-t border-gray-100">

                                            <span>Dashboard Saya</span>
                                            <span class="text-gray-400">›</span>

                                        </a>

                                    @elseif(auth()->user()->role === 'admin kost')

                                        <a
                                            href="{{ route('admin.profil.index') }}"
                                            onclick="closeMobileMenu()"
                                            class="mobile-link flex items-center justify-between
                                                   px-4 py-3
                                                   text-sm font-semibold
                                                   hover:bg-[#F4F7F4]
                                                   {{ request()->routeIs('admin.profil.*') ? 'text-[#6C8B6B] bg-[#EEF5EE]' : 'text-[#314233]' }}">

                                            <span>Profil Saya</span>
                                            <span class="text-gray-400">›</span>

                                        </a>

                                        @if(auth()->user()->status === 'aktif')

                                            <a
                                                href="{{ route('admin.dashboard') }}"
                                                onclick="closeMobileMenu()"
                                                class="mobile-link flex items-center justify-between
                                                       px-4 py-3
                                                       text-sm font-semibold text-[#314233]
                                                       hover:bg-[#F4F7F4]
                                                       border-t border-gray-100">

                                                <span>Dashboard Saya</span>
                                                <span class="text-gray-400">›</span>

                                            </a>

                                        @endif

                                    @elseif(auth()->user()->role === 'penghuni kost')

                                        <a
                                            href="{{ route('penghuni.profil.index') }}"
                                            onclick="closeMobileMenu()"
                                            class="mobile-link flex items-center justify-between
                                                   px-4 py-3
                                                   text-sm font-semibold
                                                   hover:bg-[#F4F7F4]
                                                   {{ request()->routeIs('penghuni.profil.*') ? 'text-[#6C8B6B] bg-[#EEF5EE]' : 'text-[#314233]' }}">

                                            <span>Profil Saya</span>
                                            <span class="text-gray-400">›</span>

                                        </a>

                                        @if(auth()->user()->riwayatHunian()->where('status', 'aktif')->exists())

                                            <a
                                                href="{{ route('penghuni.dashboard') }}"
                                                onclick="closeMobileMenu()"
                                                class="mobile-link flex items-center justify-between
                                                       px-4 py-3
                                                       text-sm font-semibold text-[#314233]
                                                       hover:bg-[#F4F7F4]
                                                       border-t border-gray-100">

                                                <span>Dashboard Saya</span>
                                                <span class="text-gray-400">›</span>

                                            </a>

                                        @endif

                                    @endif

                                    {{-- LOGOUT --}}
                                    <form
                                        method="POST"
                                        action="{{ route('logout') }}"
                                        class="border-t border-gray-100">

                                        @csrf

                                        <button
                                            type="submit"
                                            class="mobile-link w-full flex items-center justify-between
                                                   px-4 py-3
                                                   text-sm font-semibold
                                                   text-red-500
                                                   hover:bg-red-50">

                                            <span>Logout</span>
                                            <span class="text-red-300">›</span>

                                        </button>

                                    </form>

                                </div>

                            </div>

                        </div>

                    </div>

                @else

                    {{-- GUEST --}}
                    <div class="flex flex-col gap-3 pt-4 mt-2 border-t border-gray-100">

                        <a
                            href="{{ route('login') }}"
                            onclick="closeMobileMenu()"
                            class="mobile-link w-full text-center
                                   px-4 py-3 rounded-2xl
                                   border border-[#6C8B6B]
                                   text-[#6C8B6B]
                                   font-semibold
                                   text-sm
                                   hover:bg-[#EEF5EE]">

                            Masuk

                        </a>

                        <button
                            type="button"
                            onclick="bukaModal(); closeMobileMenu();"
                            class="mobile-link w-full
                                   px-4 py-3 rounded-2xl
                                   bg-[#6C8B6B]
                                   hover:bg-[#587357]
                                   text-white
                                   text-sm
                                   font-semibold">

                            Daftar

                        </button>

                    </div>

                @endauth

            </div>

        </div>

    </div>

    {{-- CONTENT --}}
    <main class="pt-[84px]">
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer class="bg-[#162818] mt-14 lg:mt-24 overflow-hidden relative pb-0">

        <div class="absolute inset-0 opacity-30">
            <img src="{{ asset('footer.png') }}" class="w-full h-full object-cover" alt="">
        </div>

        <div class="absolute inset-0 bg-[#162818]/60"></div>

        <div class="relative z-10
                    max-w-7xl mx-auto
                    px-4 lg:px-8
                    py-10 lg:py-20">

            <div class="grid lg:grid-cols-4 gap-10 lg:gap-14">

                {{-- BRAND --}}
                <div class="lg:col-span-2">

                    <div class="flex items-center gap-3 mb-6">

                        <img
                            src="{{ asset('logo.png') }}"
                            class="w-10 h-10 lg:w-12 lg:h-12 object-contain"
                            alt="Logo">

                        <h2 class="text-2xl lg:text-3xl font-extrabold text-white">
                            KosinAja!
                        </h2>

                    </div>

                    <p class="text-[#c7d5c8] leading-7 text-sm lg:text-base max-w-md">
                        Platform pencarian dan pengelolaan kos modern yang membantu pencari kos menemukan hunian nyaman
                        dengan cepat, aman, dan terpercaya.
                    </p>

                </div>

                {{-- MENU --}}
                <div>

                    <h3 class="text-white font-bold text-lg mb-6">
                        Navigasi
                    </h3>

                    <div class="flex flex-col gap-4">

                        <a
                            href="{{ route('home') }}"
                            class="text-[#c7d5c8] hover:text-white transition">
                            Beranda
                        </a>

                        <a
                            href="{{ route('hubungi') }}"
                            class="text-[#c7d5c8] hover:text-white transition">
                            Hubungi Kami
                        </a>

                        <a
                            href="{{ route('tentang') }}"
                            class="text-[#c7d5c8] hover:text-white transition">
                            Tentang Kami
                        </a>

                    </div>

                </div>

                {{-- CONTACT --}}
                <div>

                    <h3 class="text-white font-bold text-lg mb-6">
                        Kontak
                    </h3>

                    <div class="space-y-5">

                        <div class="flex items-start gap-3">

                            <div class="w-10 h-10 rounded-xl bg-[#223725] flex items-center justify-center shrink-0">

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="w-5 h-5 text-[#6C8B6B]"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="1.8">

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M12 2C8.686 2 6 4.686 6 8c0 4.418 6 12 6 12s6-7.582 6-12c0-3.314-2.686-6-6-6z" />

                                    <circle
                                        cx="12"
                                        cy="8"
                                        r="2"
                                        fill="currentColor"
                                        stroke="none" />

                                </svg>

                            </div>

                            <p class="text-[#c7d5c8] leading-7 pt-1">
                                Banyuwangi, Indonesia
                            </p>

                        </div>

                        <div class="flex items-start gap-3">

                            <div class="w-10 h-10 rounded-xl bg-[#223725] flex items-center justify-center shrink-0">

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="w-5 h-5 text-[#6C8B6B]"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="1.8">

                                    <rect
                                        x="2"
                                        y="5"
                                        width="20"
                                        height="14"
                                        rx="2"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                        fill="none" />

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M2 7l10 7 10-7" />

                                </svg>

                            </div>

                            <a
                                href="mailto:twoorbital@gmail.com"
                                class="text-[#c7d5c8] hover:text-white transition pt-1">
                                twoorbital@gmail.com
                            </a>

                        </div>

                        <div class="flex items-start gap-3">

                            <div class="w-10 h-10 rounded-xl bg-[#223725] flex items-center justify-center shrink-0">

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="w-5 h-5 text-[#6C8B6B]"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="1.8">

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M6.6 10.8c1.4 2.8 3.8 5.1 6.6 6.6l2.2-2.2c.3-.3.7-.4 1-.2
                                           1.1.4 2.3.6 3.6.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1
                                           C9.6 21 3 14.4 3 6.4c0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1
                                           0 1.3.2 2.5.6 3.6.1.3 0 .7-.2 1L6.6 10.8z" />

                                </svg>

                            </div>

                            <a
                                href="https://wa.me/6282264676843"
                                target="_blank"
                                class="text-[#c7d5c8] hover:text-white transition pt-1">
                                (+62) 82264676843
                            </a>

                        </div>

                    </div>

                </div>

            </div>

            {{-- COPYRIGHT --}}
            <div class="border-t border-[#2b412d] mt-10 pt-6 text-center">

                <p class="text-[#91A392] text-sm">
                    © {{ date('Y') }} KosinAja! — Orbit
                </p>

            </div>

        </div>

    </footer>

    @include('auth.pilih-role')

    @stack('scripts')

    <script>
        function toggleMobileMenu() {

            const menu =
                document.getElementById('mobileMenu');

            const button =
                document.getElementById('mobileMenuButton');

            const isOpen =
                menu.classList.toggle('is-open');

            if (button) {

                button.classList.toggle('is-active', isOpen);

                button.setAttribute(
                    'aria-expanded',
                    isOpen ? 'true' : 'false'
                );

            }

        }

        function closeMobileMenu() {

            const menu =
                document.getElementById('mobileMenu');

            const button =
                document.getElementById('mobileMenuButton');

            if (menu) {
                menu.classList.remove('is-open');
            }

            if (button) {

                button.classList.remove('is-active');

                button.setAttribute(
                    'aria-expanded',
                    'false'
                );

            }

            closeMobileUserMenu();

        }

        function toggleMobileUserMenu() {

            const submenu =
                document.getElementById('mobileUserSubmenu');

            const arrow =
                document.getElementById('mobileUserArrow');

            if (!submenu) {
                return;
            }

            const isOpen =
                submenu.classList.toggle('is-open');

            if (arrow) {
                arrow.classList.toggle('is-open', isOpen);
            }

        }

        function closeMobileUserMenu() {

            const submenu =
                document.getElementById('mobileUserSubmenu');

            const arrow =
                document.getElementById('mobileUserArrow');

            if (submenu) {
                submenu.classList.remove('is-open');
            }

            if (arrow) {
                arrow.classList.remove('is-open');
            }

        }

        document.addEventListener('click', function(event) {

            const menu =
                document.getElementById('mobileMenu');

            const button =
                document.getElementById('mobileMenuButton');

            if (!menu || !button) {
                return;
            }

            const clickInsideMenu =
                menu.contains(event.target);

            const clickButton =
                button.contains(event.target);

            if (
                menu.classList.contains('is-open') &&
                !clickInsideMenu &&
                !clickButton
            ) {
                closeMobileMenu();
            }

        });

        document.addEventListener('keydown', function(event) {

            if (event.key === 'Escape') {
                closeMobileMenu();
            }

        });
    </script>

</body>

</html>