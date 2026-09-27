{{-- ========================================================= --}}
{{-- resources/views/superadmin/pengajuan/index.blade.php --}}
{{-- ========================================================= --}}

@extends('layouts.superadmin')

@section('content')

<div class="p-6 space-y-7">

    {{-- =========================================================
        HEADER
    ========================================================== --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

        <div class="flex items-center gap-3">

            <div class="w-11 h-11 rounded-2xl
                       bg-[#F3F0E9]
                       flex items-center justify-center">
                <svg class="w-5 h-5 text-[#7A806F]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5
                           a2 2 0 012-2h5.5L18 8.5V19a2 2 0 01-2 2z" />

                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M14 3v6h6" />
                </svg>
            </div>

            <div>

                <h1 class="text-2xl font-bold text-[#0F0937]">
                    Pengajuan Admin Kost
                </h1>

                <p class="text-sm text-gray-500 mt-1">
                    Daftar admin kost yang menunggu verifikasi.
                </p>

            </div>

        </div>


        {{-- KEMBALI --}}
        <a href="{{ route('superadmin.dashboard') }}" class="inline-flex items-center justify-center
                   px-5 py-3
                   rounded-xl
                   bg-gray-100
                   hover:bg-gray-200
                   text-gray-700
                   text-sm
                   font-semibold
                   transition">
            Kembali
        </a>

    </div>


    {{-- =========================================================
        SUMMARY
    ========================================================== --}}
    <div class="bg-white
               rounded-3xl
               border border-gray-100
               shadow-sm
               p-5
               flex items-center justify-between">

        <div>

            <p class="text-sm text-gray-500">
                Total Pengajuan
            </p>

            <h2 class="text-3xl font-bold text-[#0F0937] mt-1">
                {{ $items->count() }}
            </h2>

        </div>


        <span class="px-3 py-1.5
                   rounded-full
                   bg-[#FFF4D9]
                   text-[#A27D35]
                   text-xs
                   font-semibold">
            Menunggu Verifikasi
        </span>

    </div>


    {{-- =========================================================
        TABLE CARD
    ========================================================== --}}
    <div class="bg-white
               rounded-3xl
               border border-gray-100
               shadow-sm
               overflow-hidden">

        {{-- CARD HEADER --}}
        <div class="px-6 py-5
                   border-b border-gray-100
                   bg-[#FBFAF7]
                   flex items-center justify-between">

            <div>

                <h2 class="text-base font-bold text-[#0F0937]">
                    Daftar Pengajuan
                </h2>

                <p class="text-xs text-gray-400 mt-1">
                    Periksa informasi admin sebelum melakukan verifikasi.
                </p>

            </div>

            @if($items->count())

            <span class="hidden sm:inline-flex
                           px-3 py-1.5
                           rounded-full
                           bg-[#F3F0E9]
                           text-[#777C6D]
                           text-xs
                           font-semibold">
                {{ $items->count() }} Data
            </span>

            @endif

        </div>


        {{-- =====================================================
            TABLE
        ====================================================== --}}
        <div class="overflow-x-auto">

            <table class="w-full min-w-[1050px]">

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

                        <th class="px-4 py-4
                                   text-left
                                   text-xs
                                   font-semibold
                                   text-gray-400
                                   uppercase
                                   tracking-wide">
                            Status
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

                    @forelse($items as $u)

                    <tr class="border-b
                                   border-gray-100
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

                                <p class="text-sm
                                               font-semibold
                                               text-[#0F0937]">
                                    {{ $u->nama }}
                                </p>

                            </div>

                        </td>


                        {{-- USERNAME --}}
                        <td class="px-4 py-5
                                       text-sm
                                       text-gray-600">
                            {{ $u->username }}
                        </td>


                        {{-- NO HP --}}
                        <td class="px-4 py-5
                                       text-sm
                                       text-gray-600">
                            {{ $u->no_hp }}
                        </td>


                        {{-- NAMA KOST --}}
                        <td class="px-4 py-5">

                            <p class="text-sm
                                           font-medium
                                           text-[#0F0937]">
                                {{ $u->kost?->nama_kost ?? '-' }}
                            </p>

                        </td>


                        {{-- STATUS --}}
                        <td class="px-4 py-5">

                            <span class="inline-flex
                                           items-center
                                           gap-2
                                           px-3 py-1.5
                                           rounded-full
                                           bg-[#FFF4D9]
                                           text-[#A27D35]
                                           border border-[#F5E6BD]
                                           text-xs
                                           font-semibold
                                           whitespace-nowrap">
                                <span class="w-1.5 h-1.5
                                               rounded-full
                                               bg-[#C69A43]"></span>

                                Menunggu Verifikasi
                            </span>

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

                        <td colspan="7" class="px-6 py-16">

                            <div class="text-center">

                                <div class="w-16 h-16
                                               mx-auto
                                               rounded-2xl
                                               bg-[#F3F0E9]
                                               flex items-center
                                               justify-center">

                                    <svg class="w-7 h-7 text-[#858979]" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M9 12h6m-6 4h6m2 5H7
                                                   a2 2 0 01-2-2V5
                                                   a2 2 0 012-2h5.5L18 8.5V19
                                                   a2 2 0 01-2 2z" />
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

    </div>

</div>

@endsection