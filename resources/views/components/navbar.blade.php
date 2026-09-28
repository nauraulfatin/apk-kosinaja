    {{-- NAVBAR --}}
    <nav class="fixed top-0 left-0 right-0 z-50
                bg-white/85 backdrop-blur-xl
                border-b border-[#edf1ed]">

        <div class="max-w-full px-6 lg:px-8
                    px-6 lg:px-8
                    h-[72px] lg:h-[84px]
                    flex items-center justify-between">

            {{-- LOGO --}}
            <a href="{{ route('home') }}" 
   class="flex items-center gap-3 shrink-0">

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

                     {{-- NOTIFICATION --}}
                    <x-notification-bell />

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