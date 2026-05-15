@extends('layouts.admin')

@section('content')

{{-- ========================================================= --}}
{{-- HEADER --}}
{{-- ========================================================= --}}
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
{{-- MONITORING --}}
{{-- ========================================================= --}}
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5 mb-8">

    {{-- TOTAL --}}
    <a
        href="?filter=tagihan"
        class="bg-white rounded-3xl p-6
               border border-gray-100 shadow-sm
               hover:shadow-md transition block"
    >

        <p class="text-sm text-gray-500 mb-2">

            Total Tagihan

        </p>

        <h2 class="text-3xl font-bold text-[#0F0937]">

            {{ $totalTagihan }}

        </h2>

    </a>

    {{-- MENUNGGU --}}
    <a
        href="?filter=menunggu"
        class="bg-yellow-50 rounded-3xl p-6
               border border-yellow-100 shadow-sm
               hover:shadow-md transition block"
    >

        <p class="text-sm text-yellow-700 mb-2">

            Menunggu Verifikasi

        </p>

        <h2 class="text-3xl font-bold text-yellow-800">

            {{ $totalMenunggu }}

        </h2>

    </a>

    {{-- LUNAS --}}
    <a
        href="?filter=lunas"
        class="bg-green-50 rounded-3xl p-6
               border border-green-100 shadow-sm
               hover:shadow-md transition block"
    >

        <p class="text-sm text-green-700 mb-2">

            Sudah Lunas

        </p>

        <h2 class="text-3xl font-bold text-green-800">

            {{ $totalLunas }}

        </h2>

    </a>

    {{-- TELAT --}}
    <a
        href="?filter=telat"
        class="bg-red-50 rounded-3xl p-6
               border border-red-100 shadow-sm
               hover:shadow-md transition block"
    >

        <p class="text-sm text-red-700 mb-2">

            Telat Bayar

        </p>

        <h2 class="text-3xl font-bold text-red-800">

            {{ $totalTelat }}

        </h2>

    </a>

</div>

{{-- ========================================================= --}}
{{-- TABLE --}}
{{-- ========================================================= --}}
<div
    class="bg-white rounded-3xl shadow-sm
           border border-gray-100 overflow-hidden"
>

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

                $jumlahTagihan =
                    $tagihans->count();

                $belumBayar =
    $tagihans
        ->where('status', 'pending')
        ->where(
            'status_bukti',
            'belum_upload'
        )
        ->count();
        
                $menunggu =
                    $tagihans
                        ->where('status_bukti', 'menunggu')
                        ->count();

                $telat =
                    $tagihans
                        ->where('status', 'telat')
                        ->count();

            @endphp

            <tr class="hover:bg-gray-50">

                {{-- PENGHUNI --}}
                <td class="px-6 py-5">

                    <div class="font-semibold text-[#0F0937]">

                        {{ $user?->nama }}

                    </div>

                    <div class="text-sm text-gray-500 mt-1">

                        {{ $user?->username }}

                    </div>

                </td>

                {{-- TOTAL --}}
                <td class="px-6 py-5">

                    <div class="text-3xl font-bold text-[#0F0937]">

                        {{ $jumlahTagihan }}

                    </div>

                    <div class="text-sm text-gray-500 mt-1">

                        Total Tagihan

                    </div>

                </td>

                {{-- STATUS --}}
                <td class="px-6 py-5">

                    <div class="flex flex-wrap gap-2">

                        @if($belumBayar > 0)

                        <div
                            class="px-3 py-1 rounded-full
                                   bg-gray-100 text-gray-700
                                   text-xs font-semibold"
                        >

                            {{ $belumBayar }}
                            belum bayar

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

                    </div>

                </td>

                {{-- DETAIL --}}
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

@endsection