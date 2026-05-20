@extends('layouts.admin')

@section('content')

<div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5 mb-8">

    <div>

        <h1 class="text-3xl font-bold text-[#0F0937]">

            Pembayaran

        </h1>

        <p class="text-gray-500 mt-2">

            Monitor tagihan dan pembayaran penghuni kost.

        </p>

    </div>

</div>

{{-- ========================================================= --}}
{{-- SUMMARY --}}
{{-- ========================================================= --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">

    {{-- MENUNGGU --}}
    <div class="bg-yellow-50 rounded-3xl p-6 border border-yellow-100 shadow-sm">

        <p class="text-sm text-yellow-700 mb-2">

            Menunggu Verifikasi

        </p>

        <h2 class="text-3xl font-bold text-yellow-800">

            {{ $totalMenunggu }}

        </h2>

    </div>

    {{-- LUNAS --}}
    <div class="bg-green-50 rounded-3xl p-6 border border-green-100 shadow-sm">

        <p class="text-sm text-green-700 mb-2">

            Sudah Lunas

        </p>

        <h2 class="text-3xl font-bold text-green-800">

            {{ $totalLunas }}

        </h2>

    </div>

    {{-- TELAT --}}
    <div class="bg-red-50 rounded-3xl p-6 border border-red-100 shadow-sm">

        <p class="text-sm text-red-700 mb-2">

            Telat Bayar

        </p>

        <h2 class="text-3xl font-bold text-red-800">

            {{ $totalTelat }}

        </h2>

    </div>

</div>

{{-- ========================================================= --}}
{{-- TABLE --}}
{{-- ========================================================= --}}
<div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">

    <div class="overflow-x-auto">

        <table class="w-full">

            <thead class="bg-[#F8F5F0]">

                <tr>

                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">

                        Penghuni

                    </th>

                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">

                        Total Tagihan

                    </th>

                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">

                        Status

                    </th>

                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">

                        Detail

                    </th>

                </tr>

            </thead>

            <tbody class="divide-y divide-gray-100">

                @forelse($items as $userId => $tagihans)

                @php

                    $user =
                        $tagihans->first()->user;

                    /*
                    |--------------------------------------------------------------------------
                    | TOTAL TAGIHAN
                    |--------------------------------------------------------------------------
                    */

                    $jumlahTagihan =
                        $tagihans->count();

                    /*
                    |--------------------------------------------------------------------------
                    | MENUNGGU
                    |--------------------------------------------------------------------------
                    */

                    $menunggu =
                        $tagihans
                            ->filter(function($t){

                                return
                                    $t->status_label
                                    === 'menunggu_verifikasi';

                            })
                            ->count();

                    /*
                    |--------------------------------------------------------------------------
                    | TELAT
                    |--------------------------------------------------------------------------
                    */

                    $telat =
                        $tagihans
                            ->filter(function($t){

                                return
                                    $t->status_label
                                    === 'telat';

                            })
                            ->count();

                    /*
                    |--------------------------------------------------------------------------
                    | BELUM LUNAS
                    |--------------------------------------------------------------------------
                    */

                    $belumLunas =
                        $tagihans
                            ->filter(function($t){

                                return
                                    $t->status_label
                                    !== 'lunas';

                            })
                            ->count();

                    /*
                    |--------------------------------------------------------------------------
                    | TOTAL NOMINAL BELUM LUNAS
                    |--------------------------------------------------------------------------
                    */

                    $totalBelumLunas =
                        $tagihans
                            ->sum(function($t){

                                return
                                    $t->sisa_tagihan;

                            });

                @endphp

                <tr class="hover:bg-gray-50">

                    {{-- ========================================================= --}}
                    {{-- USER --}}
                    {{-- ========================================================= --}}
                    <td class="px-6 py-5">

                        <div class="font-semibold text-[#0F0937]">

                            {{ $user?->nama }}

                        </div>

                        <div class="text-sm text-gray-500 mt-1">

                            {{ $user?->username }}

                        </div>

                    </td>

                    {{-- ========================================================= --}}
                    {{-- TOTAL TAGIHAN --}}
                    {{-- ========================================================= --}}
                    <td class="px-6 py-5">

                        <div class="text-3xl font-bold text-[#0F0937]">

                            {{ $jumlahTagihan }}

                        </div>

                        <div class="text-sm text-gray-500 mt-1">

                            Periode tagihan

                        </div>

                    </td>

                    {{-- ========================================================= --}}
                    {{-- STATUS --}}
                    {{-- ========================================================= --}}
                    <td class="px-6 py-5">

                        <div class="flex flex-wrap gap-2">

                            @if($belumLunas > 0)

                            <div
                                class="px-3 py-1 rounded-full
                                       bg-gray-100 text-gray-700
                                       text-xs font-semibold"
                            >

                                {{ $belumLunas }}
                                belum lunas

                            </div>

                            @endif

                            @if($menunggu > 0)

                            <div
                                class="px-3 py-1 rounded-full
                                       bg-yellow-100 text-yellow-700
                                       text-xs font-semibold"
                            >

                                {{ $menunggu }}
                                menunggu

                            </div>

                            @endif

                            @if($telat > 0)

                            <div
                                class="px-3 py-1 rounded-full
                                       bg-red-100 text-red-700
                                       text-xs font-semibold"
                            >

                                {{ $telat }}
                                telat

                            </div>

                            @endif

                            @if(
                                $belumLunas === 0
                                &&
                                $jumlahTagihan > 0
                            )

                            <div
                                class="px-3 py-1 rounded-full
                                       bg-green-100 text-green-700
                                       text-xs font-semibold"
                            >

                                Semua lunas

                            </div>

                            @endif

                        </div>

                    </td>

                    {{-- ========================================================= --}}
                    {{-- BUTTON --}}
                    {{-- ========================================================= --}}
                    <td class="px-6 py-5">

                        <a
                            href="{{ route('admin.tagihan.detail', $userId) }}"
                            class="inline-flex items-center
                                   bg-[#6C8B6B]
                                   hover:bg-[#5B765A]
                                   text-white px-5 py-3
                                   rounded-2xl text-sm
                                   font-semibold transition"
                        >

                            Lihat Detail

                        </a>

                    </td>

                </tr>

                @empty

                <tr>

                    <td
                        colspan="4"
                        class="px-6 py-12 text-center text-gray-500"
                    >

                        Belum ada data pembayaran.

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection