@extends('layouts.admin')

@section('content')

<div class="p-6 space-y-6">

    {{-- =========================================================
        HEADER
    ========================================================== --}}
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5">

        <div class="flex items-center gap-4">

            <div class="w-12 h-12 rounded-2xl bg-[#EAF1EC]
                        flex items-center justify-center shrink-0">

                <svg class="w-6 h-6 text-[#6C8B6B]" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-2m4-6h-6a2 2 0 00-2 2v2a2 2 0 002 2h6a1 1 0 001-1v-4a1 1 0 00-1-1z" />

                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 12h.01" />

                </svg>

            </div>

            <div>

                <h1 class="text-2xl font-bold text-[#0F0937]">
                    Pembayaran
                </h1>

                <p class="text-sm text-gray-500 mt-1">
                    Monitor tagihan dan pembayaran penghuni kost.
                </p>

            </div>

        </div>

    </div>


    {{-- =========================================================
        TAB NAVIGATION
    ========================================================== --}}
    <div class="flex items-center gap-8 border-b border-gray-200">

        <a href="{{ route('admin.tagihan.index') }}" class="relative pb-3 text-sm font-semibold transition
            {{ request()->routeIs('admin.tagihan.index')
                ? 'text-[#6C8B6B]'
                : 'text-gray-400 hover:text-[#6C8B6B]' }}">

            Tagihan

            @if(request()->routeIs('admin.tagihan.index'))
            <span class="absolute left-0 right-0 bottom-0 h-0.5
                         bg-[#6C8B6B] rounded-full"></span>
            @endif

        </a>


        <a href="{{ route('admin.tagihan.riwayat') }}" class="relative pb-3 text-sm font-semibold transition
            {{ request()->routeIs('admin.tagihan.riwayat')
                ? 'text-[#6C8B6B]'
                : 'text-gray-400 hover:text-[#6C8B6B]' }}">

            Riwayat Pembayaran

            @if(request()->routeIs('admin.tagihan.riwayat'))
            <span class="absolute left-0 right-0 bottom-0 h-0.5
                         bg-[#6C8B6B] rounded-full"></span>
            @endif

        </a>

    </div>


    {{-- =========================================================
        SUMMARY
    ========================================================== --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

        {{-- MENUNGGU --}}
        <div class="bg-white rounded-3xl border border-gray-100
                    shadow-sm p-6">

            <div class="flex items-start justify-between">

                <div>

                    <p class="text-sm text-gray-500">
                        Menunggu Verifikasi
                    </p>

                    <h2 class="text-3xl font-bold text-[#0F0937] mt-2">
                        {{ $totalMenunggu }}
                    </h2>

                    <p class="text-xs text-yellow-600 mt-2">
                        Pembayaran perlu diperiksa
                    </p>

                </div>

                <div class="w-11 h-11 rounded-2xl bg-yellow-50
                            flex items-center justify-center">

                    <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 2m6-2a9 9 0 11-18 0 9 9 0 0118 0z" />

                    </svg>

                </div>

            </div>

        </div>


        {{-- LUNAS --}}
        <div class="bg-white rounded-3xl border border-gray-100
                    shadow-sm p-6">

            <div class="flex items-start justify-between">

                <div>

                    <p class="text-sm text-gray-500">
                        Sudah Lunas
                    </p>

                    <h2 class="text-3xl font-bold text-[#0F0937] mt-2">
                        {{ $totalLunas }}
                    </h2>

                    <p class="text-xs text-green-600 mt-2">
                        Tagihan telah diselesaikan
                    </p>

                </div>

                <div class="w-11 h-11 rounded-2xl bg-green-50
                            flex items-center justify-center">

                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />

                    </svg>

                </div>

            </div>

        </div>


        {{-- TELAT --}}
        <div class="bg-white rounded-3xl border border-gray-100
                    shadow-sm p-6">

            <div class="flex items-start justify-between">

                <div>

                    <p class="text-sm text-gray-500">
                        Telat Bayar
                    </p>

                    <h2 class="text-3xl font-bold text-[#0F0937] mt-2">
                        {{ $totalTelat }}
                    </h2>

                    <p class="text-xs text-red-500 mt-2">
                        Tagihan melewati jatuh tempo
                    </p>

                </div>

                <div class="w-11 h-11 rounded-2xl bg-red-50
                            flex items-center justify-center">

                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01M5.07 19h13.86a2 2 0 001.73-3L13.73 4a2 2 0 00-3.46 0L3.34 16a2 2 0 001.73 3z" />

                    </svg>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
        TABLE
    ========================================================== --}}
    <div class="bg-white rounded-3xl border border-gray-100
                shadow-sm overflow-hidden">

        {{-- TABLE HEADER --}}
        <div class="px-6 py-5 border-b border-gray-100">

            <div>

                <h2 class="text-lg font-bold text-[#0F0937]">
                    Data Tagihan Penghuni
                </h2>

                <p class="text-sm text-gray-400 mt-1">
                    Ringkasan tagihan dan status pembayaran setiap penghuni.
                </p>

            </div>

        </div>


        <div class="overflow-x-auto">

            <table class="w-full min-w-[850px]">

                <thead class="bg-[#F8FAF8]">

                    <tr>

                        <th class="px-6 py-4 text-left text-xs
                                   font-semibold text-gray-500 uppercase tracking-wide">
                            Penghuni
                        </th>

                        <th class="px-6 py-4 text-left text-xs
                                   font-semibold text-gray-500 uppercase tracking-wide">
                            Total Tagihan
                        </th>

                        <th class="px-6 py-4 text-left text-xs
                                   font-semibold text-gray-500 uppercase tracking-wide">
                            Status
                        </th>

                        <th class="px-6 py-4 text-left text-xs
                                   font-semibold text-gray-500 uppercase tracking-wide">
                            Detail
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-gray-100">

                    @forelse($items as $userId => $tagihans)

                    @php

                    $user = $tagihans->first()->user;

                    $jumlahTagihan = $tagihans->count();

                    $menunggu = $tagihans
                    ->filter(function($t){
                    return $t->status_label === 'menunggu_verifikasi';
                    })
                    ->count();

                    $telat = $tagihans
                    ->filter(function($t){
                    return $t->status_label === 'telat';
                    })
                    ->count();

                    $belumLunas = $tagihans
                    ->filter(function($t){
                    return $t->status_label !== 'lunas';
                    })
                    ->count();

                    $lunas = $tagihans
                    ->filter(function($t){
                    return $t->status_label === 'lunas';
                    })
                    ->count();

                    $totalBelumLunas = $tagihans
                    ->sum(function($t){
                    return $t->sisa_tagihan;
                    });

                    @endphp


                    <tr class="group hover:bg-[#FAFCFA] transition">


                        {{-- =================================================
                            USER
                        ================================================== --}}
                        <td class="px-6 py-5">

                            <div class="flex items-center gap-3">

                                {{-- AVATAR --}}
                                <div class="w-11 h-11 rounded-xl
                                            bg-[#EAF1EC]
                                            flex items-center justify-center
                                            shrink-0">

                                    <span class="text-sm font-bold text-[#6C8B6B]">

                                        {{ strtoupper(substr($user?->nama ?? '-', 0, 1)) }}

                                    </span>

                                </div>


                                <div>

                                    <div class="font-semibold text-[#0F0937]">

                                        {{ $user?->nama ?? '-' }}

                                    </div>

                                    <div class="text-xs text-gray-400 mt-1">

                                        {{ $user?->username ?? '-' }}

                                    </div>

                                </div>

                            </div>

                        </td>


                        {{-- =================================================
                            TOTAL TAGIHAN
                        ================================================== --}}
                        <td class="px-6 py-5">

                            <div class="flex items-center gap-3">

                                <div class="w-10 h-10 rounded-xl
                                            bg-gray-50
                                            flex items-center justify-center">

                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">

                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 14h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h7l5 5v13a2 2 0 01-2 2z" />

                                    </svg>

                                </div>

                                <div>

                                    <div class="text-2xl font-bold text-[#0F0937]">
                                        {{ $jumlahTagihan }}
                                    </div>

                                    <div class="text-xs text-gray-400">
                                        Periode tagihan
                                    </div>

                                </div>

                            </div>

                        </td>


                        {{-- =================================================
                            STATUS
                        ================================================== --}}
                        <td class="px-6 py-5">

                            <div class="flex flex-wrap gap-2">

                                {{-- LUNAS --}}
                                @if($lunas > 0)

                                <span class="inline-flex items-center gap-1.5
                                             px-3 py-1.5 rounded-full
                                             bg-green-50 text-green-700
                                             text-xs font-semibold">

                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>

                                    {{ $lunas }} lunas

                                </span>

                                @endif


                                {{-- BELUM LUNAS --}}
                                @if($belumLunas > 0)

                                <span class="inline-flex items-center gap-1.5
                                             px-3 py-1.5 rounded-full
                                             bg-gray-100 text-gray-600
                                             text-xs font-semibold">

                                    <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>

                                    {{ $belumLunas }} belum lunas

                                </span>

                                @endif


                                {{-- MENUNGGU --}}
                                @if($menunggu > 0)

                                <span class="inline-flex items-center gap-1.5
                                             px-3 py-1.5 rounded-full
                                             bg-yellow-50 text-yellow-700
                                             text-xs font-semibold">

                                    <span class="w-1.5 h-1.5 rounded-full bg-yellow-500"></span>

                                    {{ $menunggu }} menunggu

                                </span>

                                @endif


                                {{-- TELAT --}}
                                @if($telat > 0)

                                <span class="inline-flex items-center gap-1.5
                                             px-3 py-1.5 rounded-full
                                             bg-red-50 text-red-700
                                             text-xs font-semibold">

                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>

                                    {{ $telat }} telat

                                </span>

                                @endif


                                {{-- SEMUA LUNAS --}}
                                @if(
                                $lunas === $jumlahTagihan &&
                                $jumlahTagihan > 0
                                )

                                <span class="inline-flex items-center gap-1.5
                                             px-3 py-1.5 rounded-full
                                             bg-emerald-50 text-emerald-700
                                             text-xs font-semibold">

                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />

                                    </svg>

                                    Semua lunas

                                </span>

                                @endif

                            </div>

                        </td>


                        {{-- =================================================
                            BUTTON
                        ================================================== --}}
                        <td class="px-6 py-5">

                            <a href="{{ route('admin.tagihan.detail', $userId) }}" class="inline-flex items-center justify-center gap-2
                                       bg-[#6C8B6B]
                                       hover:bg-[#5B765A]
                                       text-white px-4 py-2.5
                                       rounded-xl text-sm
                                       font-semibold transition
                                       group-hover:shadow-sm">

                                Lihat Detail

                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />

                                </svg>

                            </a>

                        </td>

                    </tr>


                    @empty

                    <tr>

                        <td colspan="4" class="px-6 py-14 text-center">

                            <div class="w-14 h-14 mx-auto rounded-2xl
                                        bg-gray-50 border border-gray-100
                                        flex items-center justify-center mb-4">

                                <svg class="w-7 h-7 text-gray-300" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">

                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 14h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h7l5 5v13a2 2 0 01-2 2z" />

                                </svg>

                            </div>

                            <h3 class="text-sm font-semibold text-gray-600">
                                Belum ada data pembayaran
                            </h3>

                            <p class="text-xs text-gray-400 mt-1">
                                Belum terdapat data tagihan atau pembayaran penghuni.
                            </p>

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection