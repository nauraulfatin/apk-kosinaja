@extends('layouts.public')

@section('title', 'Profil Admin Kost')

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
            Profil Admin Kost
        </span>

    </div>

    {{-- ========================================================= --}}
    {{-- MAIN CONTENT --}}
    {{-- ========================================================= --}}
    <div class="flex flex-col lg:flex-row gap-8 items-start">

        {{-- ========================================================= --}}
        {{-- LEFT : DATA DIRI --}}
        {{-- ========================================================= --}}
        <div class="w-full lg:w-[400px] shrink-0">

            <div class="bg-white rounded-[28px]
                        border border-[#EEF2EE]
                        shadow-sm p-8">

                {{-- TITLE --}}
                <h2 class="text-[24px] font-bold text-[#1B2B1D]">
                    Data Diri
                </h2>

                {{-- FOTO --}}
                <div class="flex flex-col items-center mt-8">

                    <div class="w-[110px] h-[110px]
                                rounded-full overflow-hidden
                                border-[4px] border-[#F4F7F4]">
                        <img src="https://ui-avatars.com/api/?name={{ $user->nama }}"
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
                <div class="mt-8 space-y-6">

                    {{-- NAMA --}}
                    <div class="flex gap-4 items-start">
                        <div class="text-[#6C8B6B] mt-[2px] shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-[12px] text-gray-400">Nama Lengkap</p>
                            <h4 class="text-[14px] font-semibold text-[#1B2B1D] mt-0.5 leading-6">
                                {{ $user->nama }}
                            </h4>
                        </div>
                    </div>

                    {{-- EMAIL --}}
                    <div class="flex gap-4 items-start">
                        <div class="text-[#6C8B6B] mt-[2px] shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-[12px] text-gray-400">Email</p>
                            <h4 class="text-[14px] font-semibold text-[#1B2B1D] mt-0.5 leading-6 break-all">
                                {{ $user->username }}
                            </h4>
                        </div>
                    </div>

                    {{-- HP --}}
                    <div class="flex gap-4 items-start">
                        <div class="text-[#6C8B6B] mt-[2px] shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-[12px] text-gray-400">No. Handphone</p>
                            <h4 class="text-[14px] font-semibold text-[#1B2B1D] mt-0.5 leading-6">
                                {{ $user->no_hp ?? '-' }}
                            </h4>
                        </div>
                    </div>

                    {{-- NIK --}}
                    <div class="flex gap-4 items-start">
                        <div class="text-[#6C8B6B] mt-[2px] shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-[12px] text-gray-400">NIK</p>
                            <h4 class="text-[14px] font-semibold text-[#1B2B1D] mt-0.5 leading-6">
                                {{ $user->nik ?? '-' }}
                            </h4>
                        </div>
                    </div>

                    {{-- STATUS AKUN --}}
                    <div class="flex gap-4 items-start">
                        <div class="text-[#6C8B6B] mt-[2px] shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-[12px] text-gray-400">Status Akun</p>

                            @if($user->status === 'aktif')
                            <div class="inline-flex items-center gap-1.5
                                           px-3 py-1.5 rounded-xl
                                           bg-[#EAF7EA] text-[#4B8A4B]
                                           text-[13px] font-semibold mt-1.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                Terverifikasi
                            </div>

                            @elseif($user->status === 'ditolak')
                            <div class="inline-flex items-center gap-1.5
                                           px-3 py-1.5 rounded-xl
                                           bg-[#FEE2E2] text-[#B91C1C]
                                           text-[13px] font-semibold mt-1.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                                Ditolak
                            </div>

                            @else
                            {{-- status === 'pending' --}}
                            <div class="inline-flex items-center gap-1.5
                                           px-3 py-1.5 rounded-xl
                                           bg-[#FFF4D6] text-[#B07D10]
                                           text-[13px] font-semibold mt-1.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                        clip-rule="evenodd" />
                                </svg>
                                Menunggu Verifikasi
                            </div>
                            @endif

                        </div>
                    </div>

                </div>

            </div>

        </div>

        {{-- ========================================================= --}}
        {{-- RIGHT : KOST SAYA --}}
        {{-- ========================================================= --}}
        <div class="flex-1 w-full">

            <div class="bg-white rounded-[28px]
                        border border-[#EEF2EE]
                        shadow-sm p-10">

                {{-- TITLE --}}
                <h2 class="text-[24px] font-bold text-[#1B2B1D] mb-6">
                    Kost Saya
                </h2>

                @php $kost = $user->kost; @endphp

                {{-- ============================================
                     STATE 1 : PENDING
                     Condition: status = 'pending'
                     ============================================ --}}
                @if($user->status === 'pending')

                {{-- BANNER MENUNGGU --}}
                <div class="flex items-start gap-4 bg-[#FFFBF0] border border-[#F5E6BB] rounded-[18px] px-6 py-5 mb-8">
                    <div class="shrink-0 mt-0.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-[#D4A017]" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-[15px] font-bold text-[#B07D10]">Menunggu Verifikasi Superadmin</p>
                        <p class="text-[13px] text-[#C89A2A] mt-0.5 leading-6">
                            Data kost kamu sedang ditinjau oleh superadmin.
                            Kamu akan bisa mengakses dashboard setelah disetujui.
                        </p>
                    </div>
                </div>

                {{-- DETAIL KOST --}}
                @if($kost)
                <div class="space-y-5">

                    <div class="flex items-center justify-between py-4 border-b border-[#F0F4F0]">
                        <span class="text-[14px] text-gray-500">Nama Kost</span>
                        <span class="text-[14px] font-semibold text-[#1B2B1D]">
                            {{ $kost->nama_kost }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between py-4 border-b border-[#F0F4F0]">
                        <span class="text-[14px] text-gray-500">Alamat</span>
                        <span class="text-[14px] font-semibold text-[#1B2B1D] text-right max-w-[260px]">
                            {{ $kost->alamat ?? '-' }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between py-4 border-b border-[#F0F4F0]">
                        <span class="text-[14px] text-gray-500">Tanggal Pendaftaran</span>
                        <span class="text-[14px] font-semibold text-[#1B2B1D]">
                            {{ \Carbon\Carbon::parse($user->created_at)->translatedFormat('d M Y, H:i') }} WIB
                        </span>
                    </div>

                    <div class="flex items-center justify-between py-4">
                        <span class="text-[14px] text-gray-500">Status</span>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5
                                     rounded-xl bg-[#FFF4D6] text-[#B07D10]
                                     text-[13px] font-semibold">
                            Menunggu Verifikasi
                        </span>
                    </div>

                </div>
                @endif

                {{-- TOMBOL DISABLED --}}
                <button disabled class="mt-8 w-full py-4 rounded-2xl
                               bg-[#D1DDD1] text-white
                               font-semibold text-[15px] cursor-not-allowed">
                    Menunggu Persetujuan Superadmin
                </button>

                {{-- ============================================
                     STATE 2 : DITOLAK
                     Condition: status = 'ditolak'
                     ============================================ --}}
                @elseif($user->status === 'ditolak')

                {{-- BANNER DITOLAK --}}
                <div class="flex items-start gap-4 bg-[#FEF2F2] border border-[#FECACA] rounded-[18px] px-6 py-5 mb-8">
                    <div class="shrink-0 mt-0.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-[#DC2626]" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-[15px] font-bold text-[#B91C1C]">Pendaftaran Ditolak</p>
                        <p class="text-[13px] text-[#DC2626] mt-0.5 leading-6">
                            Maaf, pendaftaran kost kamu tidak disetujui oleh superadmin.
                            Silakan hubungi superadmin untuk informasi lebih lanjut.
                        </p>
                    </div>
                </div>

                @if($kost)
                <div class="space-y-5">

                    <div class="flex items-center justify-between py-4 border-b border-[#F0F4F0]">
                        <span class="text-[14px] text-gray-500">Nama Kost</span>
                        <span class="text-[14px] font-semibold text-[#1B2B1D]">
                            {{ $kost->nama_kost }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between py-4 border-b border-[#F0F4F0]">
                        <span class="text-[14px] text-gray-500">Alamat</span>
                        <span class="text-[14px] font-semibold text-[#1B2B1D] text-right max-w-[260px]">
                            {{ $kost->alamat ?? '-' }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between py-4 border-b border-[#F0F4F0]">
                        <span class="text-[14px] text-gray-500">Tanggal Pendaftaran</span>
                        <span class="text-[14px] font-semibold text-[#1B2B1D]">
                            {{ \Carbon\Carbon::parse($user->created_at)->translatedFormat('d M Y, H:i') }} WIB
                        </span>
                    </div>

                    <div class="flex items-center justify-between py-4">
                        <span class="text-[14px] text-gray-500">Status</span>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5
                                     rounded-xl bg-[#FEE2E2] text-[#B91C1C]
                                     text-[13px] font-semibold">
                            Ditolak
                        </span>
                    </div>

                </div>
                @endif

                {{-- TOMBOL DISABLED --}}
                <button disabled class="mt-8 w-full py-4 rounded-2xl
                               bg-[#F5C6C6] text-white
                               font-semibold text-[15px] cursor-not-allowed">
                    Pendaftaran Tidak Disetujui
                </button>

                {{-- ============================================
                     STATE 3 : AKTIF
                     Condition: status = 'aktif'
                     ============================================ --}}
                @elseif($user->status === 'aktif')

                {{-- BANNER AKTIF --}}
                <div class="flex items-start gap-4 bg-[#F0FAF0] border border-[#C2E0C2] rounded-[18px] px-6 py-5 mb-8">
                    <div class="shrink-0 mt-0.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-[#4B8A4B]" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-[15px] font-bold text-[#2E6B2E]">Disetujui!</p>
                        <p class="text-[13px] text-[#4B7A4A] mt-0.5 leading-6">
                            Selamat! Kost kamu sudah diverifikasi oleh superadmin.
                            Kamu bisa mulai mengelola kost melalui dashboard admin.
                        </p>
                    </div>
                </div>

                @if($kost)
                <div class="space-y-5">

                    <div class="flex items-center justify-between py-4 border-b border-[#F0F4F0]">
                        <span class="text-[14px] text-gray-500">Nama Kost</span>
                        <span class="text-[14px] font-semibold text-[#1B2B1D]">
                            {{ $kost->nama_kost }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between py-4 border-b border-[#F0F4F0]">
                        <span class="text-[14px] text-gray-500">Alamat</span>
                        <span class="text-[14px] font-semibold text-[#1B2B1D] text-right max-w-[260px]">
                            {{ $kost->alamat ?? '-' }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between py-4 border-b border-[#F0F4F0]">
                        <span class="text-[14px] text-gray-500">Tanggal Pendaftaran</span>
                        <span class="text-[14px] font-semibold text-[#1B2B1D]">
                            {{ \Carbon\Carbon::parse($user->created_at)->translatedFormat('d M Y, H:i') }} WIB
                        </span>
                    </div>

                    <div class="flex items-center justify-between py-4">
                        <span class="text-[14px] text-gray-500">Status</span>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5
                                     rounded-xl bg-[#EAF7EA] text-[#4B8A4B]
                                     text-[13px] font-semibold">
                            Terverifikasi
                        </span>
                    </div>

                </div>
                @endif

                {{-- TOMBOL DASHBOARD --}}
                <a href="{{ route('admin.dashboard') }}" class="mt-8 w-full py-4 rounded-2xl
                          bg-[#4B8A4B] hover:bg-[#3A703A]
                          text-white font-semibold text-[15px]
                          transition-all duration-300
                          flex items-center justify-center gap-2">

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>

                    Buka Dashboard Admin

                </a>

                @endif

            </div>

        </div>

    </div>

</div>

@endsection