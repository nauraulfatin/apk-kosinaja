{{-- ========================================================= --}}
{{-- resources/views/superadmin/riwayat/index.blade.php --}}
{{-- ========================================================= --}}

@extends('layouts.superadmin')

@section('content')

@php
$totalRiwayat = $items->count();
$totalDisetujui = $items->where('status', 'aktif')->count();
$totalDitolak = $items->where('status', 'ditolak')->count();

$persentaseDisetujui = $totalRiwayat > 0
? round(($totalDisetujui / $totalRiwayat) * 100)
: 0;
@endphp


<div class="p-6 space-y-7 bg-[#FCFAF6] min-h-full">

    {{-- =========================================================
        HEADER
    ========================================================== --}}
    <div>

        <h1 class="text-3xl font-bold text-[#0F0937]">
            Riwayat Pengajuan
        </h1>

        <p class="text-sm text-gray-500 mt-2">
            Daftar seluruh pengajuan admin kost yang sudah diverifikasi.
        </p>

    </div>


    {{-- =========================================================
        HERO SUMMARY
    ========================================================== --}}
    <div class="relative
               overflow-hidden
               rounded-[28px]
               bg-[#1F3A2C]
               min-h-[190px]
               px-8 py-7
               text-white">

        {{-- DEKORASI --}}
        <div class="absolute
                   -right-16
                   -top-24
                   w-56 h-56
                   rounded-full
                   bg-white/10"></div>

        <div class="absolute
                   -right-5
                   -bottom-24
                   w-44 h-44
                   rounded-full
                   border-[20px]
                   border-white/5"></div>


        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-7">

            {{-- KIRI --}}
            <div>

                <div class="flex items-center gap-2 mb-4">

                    <span class="w-2 h-2
                               rounded-full
                               bg-[#B9D1BA]"></span>

                    <span class="text-sm
                               text-[#D7E5D7]
                               font-medium">
                        Ringkasan Pengajuan
                    </span>

                </div>


                <p class="text-sm text-[#B9D1BA]">
                    Total pengajuan yang telah diproses
                </p>

                <h2 class="text-4xl font-bold mt-1">
                    {{ $totalRiwayat }}
                </h2>

                <p class="text-sm text-[#C9D9C9] mt-2">
                    {{ $totalDisetujui }} pengajuan disetujui dan
                    {{ $totalDitolak }} pengajuan ditolak.
                </p>

            </div>


            {{-- KANAN --}}
            <div class="relative
                       w-full
                       lg:w-[330px]">

                <div class="flex items-center justify-between mb-2">

                    <span class="text-xs text-[#C9D9C9]">
                        Tingkat persetujuan
                    </span>

                    <span class="text-xs font-semibold">
                        {{ $persentaseDisetujui }}%
                    </span>

                </div>

                <div class="h-2
                           w-full
                           rounded-full
                           bg-white/15
                           overflow-hidden">

                    <div class="h-full
                               rounded-full
                               bg-[#B9D1BA]" style="width: {{ $persentaseDisetujui }}%"></div>

                </div>

                <p class="text-[11px] text-[#AFC5B0] mt-2">
                    Berdasarkan seluruh riwayat pengajuan.
                </p>

            </div>

        </div>

    </div>


    {{-- =========================================================
        SUMMARY CARDS
    ========================================================== --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

        {{-- TOTAL --}}
        <div class="bg-white
                   rounded-3xl
                   border border-[#E9E7E1]
                   shadow-sm
                   px-6 py-5">

            <p class="text-sm text-gray-500">
                Total Pengajuan
            </p>

            <h2 class="text-2xl font-bold text-[#0F0937] mt-2">
                {{ $totalRiwayat }}
            </h2>

            <p class="text-xs text-gray-400 mt-1">
                Seluruh pengajuan yang diproses
            </p>

        </div>


        {{-- DISETUJUI --}}
        <div class="bg-[#F3F8F3]
                   rounded-3xl
                   border border-[#DCE9DC]
                   px-6 py-5">

            <p class="text-sm text-[#66806A]">
                Disetujui
            </p>

            <h2 class="text-2xl font-bold text-[#1F3A2C] mt-2">
                {{ $totalDisetujui }}
            </h2>

            <p class="text-xs text-[#7C9580] mt-1">
                Admin kost yang diterima
            </p>

        </div>


        {{-- DITOLAK --}}
        <div class="bg-[#FFF7F4]
                   rounded-3xl
                   border border-[#F2E2DC]
                   px-6 py-5">

            <p class="text-sm text-[#B96F5D]">
                Ditolak
            </p>

            <h2 class="text-2xl font-bold text-[#A95343] mt-2">
                {{ $totalDitolak }}
            </h2>

            <p class="text-xs text-[#C18A7D] mt-1">
                Pengajuan tidak disetujui
            </p>

        </div>

    </div>


    {{-- =========================================================
        SECTION TITLE
    ========================================================== --}}
    <div>

        <h2 class="text-xl font-bold text-[#0F0937]">
            Daftar Riwayat
        </h2>

        <p class="text-sm text-gray-400 mt-1">
            Riwayat hasil verifikasi admin kost.
        </p>

    </div>


    {{-- =========================================================
        RIWAYAT LIST
    ========================================================== --}}
    <div class="bg-white
               rounded-3xl
               border border-[#E9E7E1]
               shadow-sm
               overflow-hidden">

        {{-- HEADER LIST --}}
        <div class="px-6 py-5
                   border-b border-gray-100
                   bg-[#FBFAF7]
                   flex items-center justify-between">

            <div>

                <h3 class="text-base font-bold text-[#0F0937]">
                    Pengajuan Terverifikasi
                </h3>

                <p class="text-xs text-gray-400 mt-1">
                    Daftar admin kost yang sudah mendapatkan hasil verifikasi.
                </p>

            </div>

            @if($totalRiwayat > 0)

            <span class="px-3 py-1.5
                           rounded-full
                           bg-[#EAF1EA]
                           text-[#1F3A2C]
                           text-xs
                           font-semibold">
                {{ $totalRiwayat }} Data
            </span>

            @endif

        </div>


        {{-- =====================================================
            DESKTOP TABLE
        ====================================================== --}}
        <div class="overflow-x-auto">

            <table class="w-full min-w-[1000px]">

                <thead>

                    <tr class="border-b border-gray-100">

                        <th class="px-6 py-4
                                   text-left
                                   text-xs
                                   font-semibold
                                   text-gray-400
                                   uppercase
                                   tracking-wide">
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
                                   hover:bg-[#FCFBF8]
                                   transition">

                        {{-- NO --}}
                        <td class="px-6 py-5">

                            <span class="inline-flex
                                           w-8 h-8
                                           rounded-xl
                                           bg-[#F3F0E9]
                                           text-[#777C6D]
                                           items-center
                                           justify-center
                                           text-xs
                                           font-bold">
                                {{ $loop->iteration }}
                            </span>

                        </td>


                        {{-- NAMA --}}
                        <td class="px-4 py-5">

                            <div class="flex items-center gap-3">

                                <div class="w-10 h-10
                                               rounded-full
                                               bg-[#EAF1EA]
                                               text-[#1F3A2C]
                                               flex items-center
                                               justify-center
                                               text-sm
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

                            @if($u->status === 'aktif')

                            <span class="inline-flex
                                               items-center
                                               gap-2
                                               px-3 py-1.5
                                               rounded-full
                                               bg-[#E4EFE4]
                                               text-[#1F3A2C]
                                               text-xs
                                               font-semibold
                                               whitespace-nowrap">

                                <span class="w-1.5 h-1.5
                                                   rounded-full
                                                   bg-[#1F3A2C]"></span>

                                Disetujui

                            </span>

                            @elseif($u->status === 'ditolak')

                            <span class="inline-flex
                                               items-center
                                               gap-2
                                               px-3 py-1.5
                                               rounded-full
                                               bg-[#FDEDED]
                                               text-[#B65D5D]
                                               text-xs
                                               font-semibold
                                               whitespace-nowrap">

                                <span class="w-1.5 h-1.5
                                                   rounded-full
                                                   bg-[#C56B6B]"></span>

                                Ditolak

                            </span>

                            @endif

                        </td>


                        {{-- AKSI --}}
                        <td class="px-6 py-5">

                            <a href="{{ route('superadmin.riwayat.edit', $u) }}" class="inline-flex
                                           items-center
                                           gap-2
                                           px-4 py-2
                                           rounded-xl
                                           bg-[#F3F5F1]
                                           text-[#1F3A2C]
                                           text-xs
                                           font-semibold
                                           hover:bg-[#E5EBE3]
                                           transition">

                                Edit

                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
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
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M12 8v4l3 2m6-2a9 9 0 11-18 0
                                                   9 9 0 0118 0z" />
                                    </svg>

                                </div>

                                <h3 class="mt-4
                                               text-base
                                               font-semibold
                                               text-[#0F0937]">
                                    Belum Ada Riwayat
                                </h3>

                                <p class="mt-1
                                               text-sm
                                               text-gray-400">
                                    Belum ada pengajuan admin kost yang telah diproses.
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