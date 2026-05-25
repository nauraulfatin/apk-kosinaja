@extends('layouts.public')

@section('title', 'Profil Super Admin')

@section('content')

<div class="max-w-8xl mx-auto px-6 lg:px-8 py-10">

    {{-- ========================================================= --}}
    {{-- BREADCRUMB --}}
    {{-- ========================================================= --}}
    <div class="flex items-center gap-3 text-sm text-gray-400 mb-8">

        <a href="{{ route('home') }}" class="hover:text-[#6C8B6B]">
            Beranda
        </a>

        <span>›</span>

        <span class="text-[#1B2B1D] font-medium">
            Profil Super Admin
        </span>

    </div>

    {{-- ========================================================= --}}
    {{-- MAIN CONTENT --}}
    {{-- ========================================================= --}}
    <div class="flex flex-col lg:flex-row gap-8 items-start">

        {{-- ========================================================= --}}
        {{-- LEFT : DATA DIRI --}}
        {{-- ========================================================= --}}
        <div class="w-full lg:w-[340px] shrink-0">

            <div class="bg-white rounded-[28px]
                        border border-[#EEF2EE]
                        shadow-sm p-8">

                {{-- TITLE --}}
                <h2 class="text-[22px] font-bold text-[#1B2B1D] mb-6">
                    Data Diri
                </h2>

                {{-- FOTO --}}
                <div class="flex flex-col items-center mb-8">

                    <div class="w-[100px] h-[100px]
                                rounded-full overflow-hidden
                                border-[4px] border-[#F4F7F4]
                                bg-[#EEF4EF] flex items-center justify-center">
                        <img src="https://ui-avatars.com/api/?name={{ $user->nama }}&background=EEF4EF&color=4B8A4B&size=100"
                            class="w-full h-full object-cover">
                    </div>

                    {{-- UBAH FOTO BUTTON --}}
                    <button class="mt-3 flex items-center gap-1.5
                               text-[13px] text-[#6C8B6B]
                               font-medium hover:text-[#4B7A4A]
                               transition-colors duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Ubah Foto
                    </button>

                </div>

                {{-- INFO --}}
                <div class="space-y-5">

                    {{-- NAMA --}}
                    <div class="flex gap-3 items-start">
                        <div class="text-[#6C8B6B] mt-[2px] shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-[11px] text-gray-400">Nama Lengkap</p>
                            <p class="text-[13px] font-semibold text-[#1B2B1D] mt-0.5">{{ $user->nama }}</p>
                        </div>
                    </div>

                    {{-- USERNAME --}}
                    <div class="flex gap-3 items-start">
                        <div class="text-[#6C8B6B] mt-[2px] shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-[11px] text-gray-400">Username</p>
                            <p class="text-[13px] font-semibold text-[#1B2B1D] mt-0.5">{{ $user->username }}</p>
                        </div>
                    </div>

                    {{-- NO HP --}}
                    <div class="flex gap-3 items-start">
                        <div class="text-[#6C8B6B] mt-[2px] shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-[11px] text-gray-400">No. Handphone</p>
                            <p class="text-[13px] font-semibold text-[#1B2B1D] mt-0.5">{{ $user->no_hp ?? '-' }}</p>
                        </div>
                    </div>

                    {{-- EMAIL (jika ada) --}}
                    @if($user->email ?? false)
                    <div class="flex gap-3 items-start">
                        <div class="text-[#6C8B6B] mt-[2px] shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-[11px] text-gray-400">Email</p>
                            <p class="text-[13px] font-semibold text-[#1B2B1D] mt-0.5 break-all">{{ $user->email }}</p>
                        </div>
                    </div>
                    @endif

                    {{-- NIK --}}
                    <div class="flex gap-3 items-start">
                        <div class="text-[#6C8B6B] mt-[2px] shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-[11px] text-gray-400">NIK</p>
                            <p class="text-[13px] font-semibold text-[#1B2B1D] mt-0.5">{{ $user->nik ?? '-' }}</p>
                        </div>
                    </div>



                    {{-- STATUS --}}
                    <div class="flex gap-3 items-start">
                        <div class="text-[#6C8B6B] mt-[2px] shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-[11px] text-gray-400">Status Akun</p>
                            <div class="inline-flex items-center gap-1.5
                                        px-2.5 py-1 rounded-lg
                                        bg-[#EAF7EA] text-[#4B8A4B]
                                        text-[12px] font-semibold mt-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                Aktif
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>

        {{-- ========================================================= --}}
        {{-- RIGHT : PROFIL SUPER ADMIN --}}
        {{-- ========================================================= --}}
        <div class="flex-1 w-full">

            <div class="bg-white rounded-[28px]
                        border border-[#EEF2EE]
                        shadow-sm p-8">

                {{-- TITLE --}}
                <h2 class="text-[22px] font-bold text-[#1B2B1D] mb-6">
                    Profil Super Admin
                </h2>

                {{-- BANNER AKUN SUPER ADMIN --}}
                <div class="flex items-start gap-4
                            bg-[#F0FAF0] border border-[#C2E0C2]
                            rounded-[18px] px-6 py-5 mb-8">
                    <div class="shrink-0 mt-0.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-[#4B8A4B]" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-[15px] font-bold text-[#2E6B2E]">Akun Super Admin</p>
                        <p class="text-[13px] text-[#4B7A4A] mt-0.5 leading-6">
                            Anda memiliki akses penuh untuk mengelola sistem KosinAja. Gunakan akses ini dengan bijak.
                        </p>
                    </div>
                </div>

                {{-- INFORMASI AKUN --}}
                <h3 class="text-[16px] font-bold text-[#1B2B1D] mb-4">
                    Informasi Akun
                </h3>

                <div class="space-y-0 border border-[#EEF2EE] rounded-2xl overflow-hidden">

                    {{-- USERNAME --}}
                    <div class="flex items-center justify-between
                                px-6 py-4 border-b border-[#F0F4F0]">
                        <span class="text-[14px] text-gray-500">Username</span>
                        <span class="text-[14px] font-semibold text-[#1B2B1D]">
                            {{ $user->username }}
                        </span>
                    </div>

                    {{-- NAMA LENGKAP --}}
                    <div class="flex items-center justify-between
                                px-6 py-4 border-b border-[#F0F4F0]">
                        <span class="text-[14px] text-gray-500">Nama Lengkap</span>
                        <span class="text-[14px] font-semibold text-[#1B2B1D]">
                            {{ $user->nama }}
                        </span>
                    </div>

                    {{-- ROLE --}}
                    <div class="flex items-center justify-between
                                px-6 py-4 border-b border-[#F0F4F0]">
                        <span class="text-[14px] text-gray-500">Role</span>
                        <span class="inline-flex items-center gap-1.5
                                     px-3 py-1.5 rounded-xl
                                     bg-[#EAF7EA] text-[#4B8A4B]
                                     text-[13px] font-semibold">
                            Super Admin
                        </span>
                    </div>

                    {{-- STATUS --}}
                    <div class="flex items-center justify-between
                                px-6 py-4 border-b border-[#F0F4F0]">
                        <span class="text-[14px] text-gray-500">Status</span>
                        <span class="inline-flex items-center gap-1.5
                                     px-3 py-1.5 rounded-xl
                                     bg-[#EAF7EA] text-[#4B8A4B]
                                     text-[13px] font-semibold">
                            Aktif
                        </span>
                    </div>

                    {{-- BERGABUNG SEJAK --}}
                    <div class="flex items-center justify-between
                                px-6 py-4 border-b border-[#F0F4F0]">
                        <span class="text-[14px] text-gray-500">Bergabung Sejak</span>
                        <span class="text-[14px] font-semibold text-[#1B2B1D]">
                            {{ \Carbon\Carbon::parse($user->created_at)->translatedFormat('d M Y, H:i') }} WIB
                        </span>
                    </div>



                </div>

                {{-- TOMBOL DASHBOARD --}}
                <a href="{{ route('superadmin.dashboard') }}" class="mt-8 w-full py-4 rounded-2xl
           bg-[#4B8A4B] hover:bg-[#3A703A]
           text-white font-semibold text-[15px]
           transition-all duration-300
           flex items-center justify-center gap-2">

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>

                    Lihat Dashboard

                </a>

            </div>

        </div>

    </div>

</div>

@endsection