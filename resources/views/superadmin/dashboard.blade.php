{{-- ========================================================= --}}
{{-- resources/views/superadmin/dashboard.blade.php --}}
{{-- ========================================================= --}}

@extends('layouts.superadmin')

@section('content')

<div class="p-6 space-y-7">

    {{-- =========================================================
        HEADER
    ========================================================== --}}
    <div class="flex items-center gap-3">

        <div class="w-11 h-11 rounded-2xl
                   bg-[#F3F0E9]
                   flex items-center justify-center">
            <svg class="w-5 h-5 text-[#7A806F]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                    d="M3 13h4v8H3zM10 3h4v18h-4zM17 8h4v13h-4z" />
            </svg>
        </div>

        <div>
            <h1 class="text-2xl font-bold text-[#0F0937]">
                Dashboard Super Admin
            </h1>

            <p class="text-sm text-gray-500 mt-1">
                Kelola pengajuan admin kost dan master fasilitas.
            </p>
        </div>

    </div>


    {{-- =========================================================
        STATISTIC CARDS
    ========================================================== --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

        {{-- TOTAL MITRA --}}
        <div class="bg-white
                   rounded-3xl
                   border border-gray-100
                   shadow-sm
                   p-6
                   hover:shadow-md
                   transition">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-gray-500 mb-2">
                        Total Mitra
                    </p>

                    <h2 class="text-4xl font-bold text-[#0F0937]">
                        {{ $admins->where('status', 'aktif')->count() }}
                    </h2>

                    <p class="text-xs text-gray-400 mt-2">
                        Admin kost aktif.
                    </p>

                </div>

                <div class="w-14 h-14 rounded-2xl
                           bg-[#D6E5D6]
                           flex items-center
                           justify-center">

                    <svg class="w-5 h-5 text-[#607A62]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>

                </div>

            </div>

        </div>


        {{-- MENUNGGU VERIFIKASI --}}
        <div class="bg-white
                   rounded-3xl
                   border border-gray-100
                   shadow-sm
                   p-6
                   hover:shadow-md
                   transition">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-gray-500 mb-2">
                        Menunggu Verifikasi
                    </p>

                    <h2 class="text-4xl font-bold text-[#0F0937]">
                        {{ $admins->where('status', 'pending')->count() }}
                    </h2>

                    <p class="text-xs text-gray-400 mt-2">
                        Pengajuan admin kost baru.
                    </p>

                </div>

                <div class="w-14 h-14 rounded-2xl
                           bg-[#FFF4D9]
                           flex items-center
                           justify-center">

                    <svg class="w-5 h-5 text-[#B28A3B]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M12 8v4l2.5 2.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>

                </div>

            </div>

        </div>


        {{-- DITOLAK --}}
        <div class="bg-white
                   rounded-3xl
                   border border-gray-100
                   shadow-sm
                   p-6
                   hover:shadow-md
                   transition">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-gray-500 mb-2">
                        Pengajuan Ditolak
                    </p>

                    <h2 class="text-4xl font-bold text-[#0F0937]">
                        {{ $admins->where('status', 'ditolak')->count() }}
                    </h2>

                    <p class="text-xs text-gray-400 mt-2">
                        Pengajuan tidak disetujui.
                    </p>

                </div>

                <div class="w-14 h-14 rounded-2xl
                           bg-[#FDECEC]
                           flex items-center
                           justify-center">

                    <svg class="w-5 h-5 text-[#C56B6B]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M6 6l12 12M18 6L6 18" />
                    </svg>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
        PENGAJUAN TERBARU
    ========================================================== --}}
    <div class="bg-white
               rounded-3xl
               border border-gray-100
               shadow-sm
               overflow-hidden">

        {{-- HEADER --}}
        <div class="px-6 py-5
                   border-b border-gray-100
                   bg-[#FBFAF7]
                   flex flex-col sm:flex-row
                   sm:items-center
                   sm:justify-between
                   gap-3">

            <div>

                <h2 class="text-base font-bold text-[#0F0937]">
                    Pengajuan Terbaru
                </h2>

                <p class="text-xs text-gray-400 mt-1">
                    Daftar admin kost yang belum diverifikasi.
                </p>

            </div>


            @php
            $pendingAdmins = $admins
            ->where('status', 'pending')
            ->sortByDesc('created_at')
            ->take(5);
            @endphp

            @if($pendingAdmins->count())

            <span class="w-fit
                           px-3 py-1.5
                           rounded-full
                           bg-[#F3F0E9]
                           text-[#777C6D]
                           text-xs
                           font-semibold">
                {{ $pendingAdmins->count() }} Pengajuan
            </span>

            @endif

        </div>


        {{-- =====================================================
            TABLE
        ====================================================== --}}
        <div class="overflow-x-auto">

            <table class="w-full min-w-[950px]">

                <thead>

                    <tr class="border-b border-gray-100">

                        <th class="px-6 py-4
                                   text-left
                                   text-xs
                                   font-semibold
                                   text-gray-400
                                   uppercase
                                   tracking-wide
                                   w-16">
                            No
                        </th>

                        <th class="px-4 py-4
                                   text-left
                                   text-xs
                                   font-semibold
                                   text-gray-400
                                   uppercase
                                   tracking-wide">
                            Nama
                        </th>

                        <th class="px-4 py-4
                                   text-left
                                   text-xs
                                   font-semibold
                                   text-gray-400
                                   uppercase
                                   tracking-wide">
                            Username
                        </th>

                        <th class="px-4 py-4
                                   text-left
                                   text-xs
                                   font-semibold
                                   text-gray-400
                                   uppercase
                                   tracking-wide">
                            No HP
                        </th>

                        <th class="px-4 py-4
                                   text-left
                                   text-xs
                                   font-semibold
                                   text-gray-400
                                   uppercase
                                   tracking-wide">
                            Nama Kost
                        </th>

                        <th class="px-6 py-4
                                   text-left
                                   text-xs
                                   font-semibold
                                   text-gray-400
                                   uppercase
                                   tracking-wide">
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($pendingAdmins as $u)

                    <tr class="border-b border-gray-100
                                   last:border-0
                                   hover:bg-[#FAFAF7]
                                   transition">

                        {{-- NO --}}
                        <td class="px-6 py-5">

                            <span class="w-8 h-8
                                           rounded-xl
                                           bg-[#F3F0E9]
                                           text-[#777C6D]
                                           flex items-center
                                           justify-center
                                           text-xs
                                           font-bold">
                                {{ $loop->iteration }}
                            </span>

                        </td>


                        {{-- NAMA --}}
                        <td class="px-4 py-5">

                            <div class="flex items-center gap-3">

                                <div class="w-9 h-9
                                               rounded-full
                                               bg-[#F3F0E9]
                                               text-[#777C6D]
                                               flex items-center
                                               justify-center
                                               text-xs
                                               font-bold
                                               shrink-0">
                                    {{ strtoupper(substr($u->nama ?? '-', 0, 1)) }}
                                </div>

                                <div>

                                    <p class="font-semibold
                                                   text-[#0F0937]
                                                   text-sm">
                                        {{ $u->nama }}
                                    </p>

                                </div>

                            </div>

                        </td>


                        {{-- USERNAME --}}
                        <td class="px-4 py-5
                                       text-sm
                                       text-gray-600">
                            {{ $u->username }}
                        </td>


                        {{-- HP --}}
                        <td class="px-4 py-5
                                       text-sm
                                       text-gray-600">
                            {{ $u->no_hp }}
                        </td>


                        {{-- KOST --}}
                        <td class="px-4 py-5">

                            <p class="text-sm
                                           font-medium
                                           text-[#0F0937]">
                                {{ $u->kost?->nama_kost ?? '-' }}
                            </p>

                        </td>


                        {{-- AKSI --}}
                        <td class="px-6 py-5">

                            <a href="{{ route('superadmin.admin.detail', $u) }}" class="inline-flex
                                           items-center
                                           gap-2
                                           text-sm
                                           font-semibold
                                           text-[#7A806F]
                                           hover:text-[#686D60]
                                           transition">
                                Lihat Detail

                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M9 5l7 7-7 7" />
                                </svg>

                            </a>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="6" class="px-6 py-16">

                            <div class="text-center">

                                <div class="w-16 h-16
                                               mx-auto
                                               rounded-2xl
                                               bg-[#F3F0E9]
                                               flex items-center
                                               justify-center">

                                    <svg class="w-7 h-7 text-[#858979]" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2
                                                   M9 11a4 4 0 100-8 4 4 0 000 8z
                                                   M22 21v-2a4 4 0 00-3-3.87
                                                   M16 3.13a4 4 0 010 7.75" />
                                    </svg>

                                </div>

                                <h3 class="mt-4
                                               text-base
                                               font-semibold
                                               text-[#0F0937]">
                                    Belum Ada Pengajuan
                                </h3>

                                <p class="mt-1
                                               text-sm
                                               text-gray-400">
                                    Belum ada admin kost yang menunggu verifikasi.
                                </p>

                            </div>

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- =====================================================
            FOOTER
        ====================================================== --}}
        @if($pendingAdmins->count())

        <div class="px-6 py-4
                       border-t border-gray-100
                       bg-[#FBFAF7]">

            <a href="{{ route('superadmin.pengajuan.index') }}" class="inline-flex
                           items-center
                           gap-2
                           text-sm
                           font-semibold
                           text-[#7A806F]
                           hover:text-[#686D60]
                           transition">

                Lihat Semua Pengajuan

                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 5l7 7-7 7" />
                </svg>

            </a>

        </div>

        @endif

    </div>

</div>

@endsection