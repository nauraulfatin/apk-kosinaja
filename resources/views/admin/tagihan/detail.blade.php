@extends('layouts.admin')

@section('content')

{{-- ========================================================= --}}
{{-- HEADER --}}
{{-- ========================================================= --}}
<div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5 mb-8">

    <div>

        <h1 class="text-3xl font-bold text-[#0F0937]">

            Detail Tagihan

        </h1>

        <p class="text-gray-500 mt-2">

            Daftar tagihan milik penghuni.

        </p>

    </div>

    <a
        href="{{ route('admin.tagihan.index') }}"
        class="bg-gray-100 hover:bg-gray-200
               text-gray-700 px-5 py-3
               rounded-2xl font-semibold transition w-fit"
    >

        Kembali

    </a>

</div>

{{-- ========================================================= --}}
{{-- CARD USER --}}
{{-- ========================================================= --}}
<div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 mb-8">

    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5">

        <div>

            <h2 class="text-2xl font-bold text-[#0F0937]">

                {{ $user->nama }}

            </h2>

            <p class="text-gray-500 mt-1">

                {{ $user->username }}

            </p>

        </div>

    </div>

</div>

{{-- ========================================================= --}}
{{-- LIST TAGIHAN --}}
{{-- ========================================================= --}}
<div class="space-y-5">

    @forelse($items as $i)

    @php

        $totalBayar =
            $i->pembayaran
                ->where(
                    'status_validasi',
                    'diterima'
                )
                ->sum(
                    'nominal_pembayaran'
                );

        $sisa =
            ($i->hargaKamar?->harga ?? 0)
            - $totalBayar;

        $pembayaranTerakhir =
            $i->pembayaran
                ->sortByDesc('created_at')
                ->first();

    @endphp

    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">

        <div class="grid grid-cols-1 xl:grid-cols-5 gap-6 items-start">

            {{-- ========================================================= --}}
            {{-- KAMAR --}}
            {{-- ========================================================= --}}
            <div>

                <p class="text-xs text-gray-500 mb-2">

                    Kamar

                </p>

                <h3 class="text-xl font-bold text-[#0F0937]">

                    {{ $i->kamar?->nomor_kamar }}

                </h3>

            </div>

            {{-- ========================================================= --}}
            {{-- PERIODE --}}
            {{-- ========================================================= --}}
            <div>

                <p class="text-xs text-gray-500 mb-2">

                    Periode

                </p>

                <div class="text-sm font-medium text-[#0F0937]">

                    {{ $i->tanggal_mulai->format('d M Y') }}

                </div>

                <div class="text-xs text-gray-400 my-1">

                    sampai

                </div>

                <div class="text-sm font-medium text-[#0F0937]">

                    {{ $i->tanggal_selesai->format('d M Y') }}

                </div>

            </div>

            {{-- ========================================================= --}}
            {{-- NOMINAL --}}
            {{-- ========================================================= --}}
            <div>

                <p class="text-xs text-gray-500 mb-2">

                    Tagihan

                </p>

                <div class="text-2xl font-bold text-[#0F0937]">

                    Rp
                    {{ number_format($i->hargaKamar?->harga,0,',','.') }}

                </div>

                <div class="text-sm text-gray-500 mt-2">

                    Dibayar:
                    Rp
                    {{ number_format($totalBayar,0,',','.') }}

                </div>

                <div class="text-sm font-semibold text-red-500 mt-1">

                    Sisa:
                    Rp
                    {{ number_format($sisa,0,',','.') }}

                </div>

            </div>

            {{-- ========================================================= --}}
            {{-- STATUS --}}
            {{-- ========================================================= --}}
            <div>

                <p class="text-xs text-gray-500 mb-2">

                    Status

                </p>

                @if($i->status_label === 'lunas')

                    <span
                        class="px-3 py-1.5 rounded-full
                               bg-green-100 text-green-700
                               text-xs font-semibold"
                    >

                        Lunas

                    </span>

                @elseif($i->status_label === 'telat')

                    <span
                        class="px-3 py-1.5 rounded-full
                               bg-red-100 text-red-700
                               text-xs font-semibold"
                    >

                        Telat

                    </span>

                @elseif($pembayaranTerakhir?->status_validasi === 'menunggu')

                    <span
                        class="px-3 py-1.5 rounded-full
                               bg-yellow-100 text-yellow-700
                               text-xs font-semibold"
                    >

                        Menunggu Verifikasi

                    </span>

                @elseif($pembayaranTerakhir?->status_validasi === 'ditolak')

                    <span
                        class="px-3 py-1.5 rounded-full
                               bg-red-100 text-red-700
                               text-xs font-semibold"
                    >

                        Ditolak

                    </span>

                @else

                    <span
                        class="px-3 py-1.5 rounded-full
                               bg-gray-100 text-gray-700
                               text-xs font-semibold"
                    >

                        Belum Lunas

                    </span>

                @endif

            </div>

            {{-- ========================================================= --}}
            {{-- PEMBAYARAN --}}
            {{-- ========================================================= --}}
            <div>

                @if($i->pembayaran->count())

                <div class="space-y-4">

                    @foreach(
                        $i->pembayaran
                            ->sortByDesc('created_at')
                        as $p
                    )

                    <div
                        class="border border-gray-200
                               rounded-2xl p-4"
                    >

                        <div class="flex flex-wrap items-start gap-4">

                            {{-- FOTO --}}
                            <a
                                href="{{ asset('storage/' . $p->bukti_bayar) }}"
                                target="_blank"
                            >

                                <img
                                    src="{{ asset('storage/' . $p->bukti_bayar) }}"
                                    class="w-24 h-24 object-cover
                                           rounded-2xl border"
                                >

                            </a>

                            {{-- INFO --}}
                            <div class="flex-1">

                                {{-- NOMINAL --}}
                                <div
                                    class="text-lg font-bold
                                           text-[#0F0937]"
                                >

                                    Rp
                                    {{ number_format($p->nominal_pembayaran,0,',','.') }}

                                </div>

                                {{-- TANGGAL --}}
                                <div
                                    class="text-sm text-gray-500
                                           mt-1"
                                >

                                    {{ $p->tanggal_bayar?->format('d M Y H:i') }}

                                </div>

                                {{-- STATUS --}}
                                <div class="mt-3">

                                    @if($p->status_validasi === 'diterima')

                                        <span
                                            class="px-3 py-1 rounded-full
                                                   bg-green-100 text-green-700
                                                   text-xs font-semibold"
                                        >

                                            Diterima

                                        </span>

                                    @elseif($p->status_validasi === 'ditolak')

                                        <span
                                            class="px-3 py-1 rounded-full
                                                   bg-red-100 text-red-700
                                                   text-xs font-semibold"
                                        >

                                            Ditolak

                                        </span>

                                    @else

                                        <span
                                            class="px-3 py-1 rounded-full
                                                   bg-yellow-100 text-yellow-700
                                                   text-xs font-semibold"
                                        >

                                            Menunggu Verifikasi

                                        </span>

                                    @endif

                                </div>

                            </div>

                            {{-- BUTTON --}}
                            @if($p->status_validasi === 'menunggu')

                            <div class="flex flex-col gap-2">

                                {{-- VALIDASI --}}
                                <form
                                    method="POST"
                                    action="{{ route('admin.tagihan.validasi', $p->id_pembayaran) }}"
                                >

                                    @csrf

                                    <button
                                        class="bg-green-500 hover:bg-green-600
                                               text-white px-4 py-2
                                               rounded-xl text-sm
                                               font-semibold transition"
                                    >

                                        Validasi

                                    </button>

                                </form>

                                {{-- TOLAK --}}
                                <form
                                    method="POST"
                                    action="{{ route('admin.tagihan.tolak', $p) }}"
                                >

                                    @csrf

                                    <button
                                        class="bg-red-500 hover:bg-red-600
                                               text-white px-4 py-2
                                               rounded-xl text-sm
                                               font-semibold transition"
                                    >

                                        Tolak

                                    </button>

                                </form>

                            </div>

                            @endif

                        </div>

                    </div>

                    @endforeach

                </div>

                @else

                <span class="text-sm text-gray-400">

                    Belum Upload

                </span>

                @endif

            </div>

        </div>

    </div>

    @empty

    <div
        class="bg-white rounded-3xl
               border border-gray-100
               shadow-sm p-12
               text-center text-gray-500"
    >

        Belum ada data tagihan.

    </div>

    @endforelse

</div>

@endsection