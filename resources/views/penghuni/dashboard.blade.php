{{-- ========================================================= --}}
{{-- resources/views/penghuni/dashboard.blade.php --}}
{{-- ========================================================= --}}

@extends('layouts.penghuni')

@section('content')

<div class="space-y-8">

    {{-- ========================================================= --}}
    {{-- HEADER --}}
    {{-- ========================================================= --}}
    <div>

        <h1 class="text-3xl font-bold text-[#0F0937]">

            Dashboard Penghuni

        </h1>

        <p class="text-gray-500 mt-2">

            Informasi kamar, masa kos, dan tagihan anda.

        </p>

    </div>

    {{-- ========================================================= --}}
    {{-- JIKA BELUM AKTIF --}}
    {{-- ========================================================= --}}
    @if(!$hunianAktif)

    <div
        class="bg-white rounded-3xl
               border border-gray-100
               shadow-sm p-10"
    >

        <div class="text-center">

            <div
                class="w-24 h-24 mx-auto
                       rounded-full bg-gray-100
                       flex items-center justify-center"
            >

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="w-12 h-12 text-gray-400"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M3 7l9-4 9 4m-9 13V9m0 11L3 7m9 13l9-13" />

                </svg>

            </div>

            <h2 class="text-2xl font-bold text-[#0F0937] mt-6">

                Belum Ada Kamar Aktif

            </h2>

            <p class="text-gray-500 mt-3 max-w-xl mx-auto">

                Anda belum memiliki kamar aktif saat ini.
                Silahkan masukkan kode kost atau tunggu approval admin kost.

            </p>

            <div class="mt-8 flex justify-center">

                <a
                    href="{{ route('kost.saya') }}"
                    class="bg-[#6C8B6B]
                           hover:bg-[#5B765A]
                           text-white px-6 py-3
                           rounded-2xl font-semibold transition"
                >

                    Masuk Kost

                </a>

            </div>

        </div>

    </div>

    @else

    {{-- ========================================================= --}}
    {{-- INFO KAMAR --}}
    {{-- ========================================================= --}}
    <div
        class="bg-white rounded-3xl
               border border-gray-100
               shadow-sm p-10"
    >

        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-8">

            <div>

                <p class="text-gray-500 text-sm">

                    Kamar Aktif

                </p>

                <h2 class="text-5xl font-bold text-[#0F0937] mt-3">

                    {{ $hunianAktif->kamar?->nomor_kamar }}

                </h2>

                <p class="text-gray-500 mt-3 text-lg">

                    {{ $hunianAktif->kamar?->nama_kamar }}

                </p>

            </div>

            <div
                class="px-5 py-3 rounded-2xl
                       bg-green-100 text-green-700
                       font-semibold text-lg w-fit"
            >

                Penghuni Aktif

            </div>

        </div>

        {{-- ========================================================= --}}
        {{-- MASA KOS --}}
        {{-- ========================================================= --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 mt-10">

            <div>

                <p class="text-gray-500 text-sm">

                    Tanggal Masuk

                </p>

                <h3 class="text-3xl font-bold text-[#0F0937] mt-3">

                    {{ $hunianAktif->tanggal_masuk?->format('d M Y') }}

                </h3>

            </div>

            <div>

                <p class="text-gray-500 text-sm">

                    Tanggal Selesai

                </p>

                <h3 class="text-3xl font-bold text-[#0F0937] mt-3">

                    {{ $hunianAktif->tanggal_keluar?->format('d M Y') }}

                </h3>

            </div>

        </div>

    </div>

    {{-- ========================================================= --}}
    {{-- TAGIHAN TERBARU --}}
    {{-- ========================================================= --}}
    <div
        class="bg-white rounded-3xl
               border border-gray-100
               shadow-sm p-10"
    >

        <div class="flex items-center justify-between">

            <div>

                <h2 class="text-3xl font-bold text-[#0F0937]">

                    Tagihan Terbaru

                </h2>

                <p class="text-gray-500 mt-2">

                    Informasi tagihan pembayaran anda.

                </p>

            </div>

            <a
                href="{{ route('penghuni.pembayaran.index') }}"
                class="text-[#6C8B6B]
                       font-semibold text-lg"
            >

                Lihat Semua

            </a>

        </div>

        @if($tagihanTerbaru)

        <div
            class="mt-8 rounded-3xl
                   border border-gray-200
                   p-8 flex flex-col
                   lg:flex-row lg:items-center
                   lg:justify-between gap-8"
        >

            <div>

                {{-- KAMAR --}}
                <h3 class="text-4xl font-bold text-[#0F0937]">

                    Kamar
                    {{ $tagihanTerbaru->kamar?->nomor_kamar }}

                </h3>

                {{-- PERIODE --}}
                <p class="text-gray-500 mt-4 text-lg">

                    {{ $tagihanTerbaru->tanggal_mulai?->format('d M Y') }}
                    -
                    {{ $tagihanTerbaru->tanggal_selesai?->format('d M Y') }}

                </p>

                {{-- PERIODE PEMBAYARAN --}}
                <div
                    class="mt-5 inline-flex items-center
                           gap-3 bg-[#F8F5F0]
                           px-5 py-3 rounded-2xl"
                >

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="w-5 h-5 text-[#6C8B6B]"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M8 7V3m8 4V3m-9 8h10m-11 9h12a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v11a2 2 0 002 2z" />

                    </svg>

                    <span class="font-semibold text-[#0F0937]">

                        Pembayaran setiap
                        {{ $tagihanTerbaru->hargaKamar?->periode?->jumlah_interval }}
                        {{ $tagihanTerbaru->hargaKamar?->periode?->satuan_interval }}

                    </span>

                </div>

                {{-- JATUH TEMPO --}}
                <div class="mt-5">

                    <span
                        class="px-4 py-2 rounded-2xl
                               bg-red-100 text-red-700
                               text-sm font-semibold"
                    >

                        Jatuh tempo:
                        {{ $tagihanTerbaru->tanggal_jatuh_tempo?->format('d M Y') }}

                    </span>

                </div>

            </div>

            {{-- STATUS --}}
            <div>

                @if($tagihanTerbaru->status === 'lunas')

                <span
                    class="px-6 py-3 rounded-2xl
                           bg-green-100 text-green-700
                           text-lg font-semibold"
                >

                    Lunas

                </span>

                @elseif($tagihanTerbaru->status === 'telat')

                <span
                    class="px-6 py-3 rounded-2xl
                           bg-red-100 text-red-700
                           text-lg font-semibold"
                >

                    Telat

                </span>

                @else

                <span
                    class="px-6 py-3 rounded-2xl
                           bg-gray-100 text-gray-700
                           text-lg font-semibold"
                >

                    Belum Bayar

                </span>

                @endif

            </div>

        </div>

        @else

        <div
            class="mt-8 rounded-3xl
                   border border-dashed
                   border-gray-300
                   p-10 text-center"
        >

            <h3 class="text-2xl font-bold text-[#0F0937]">

                Belum Ada Tagihan

            </h3>

            <p class="text-gray-500 mt-3">

                Tagihan akan muncul otomatis setelah admin mengaktifkan penghuni.

            </p>

        </div>

        @endif

    </div>

    @endif

</div>

@endsection