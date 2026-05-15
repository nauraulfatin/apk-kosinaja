@extends('layouts.penghuni')

@section('content')

{{-- ========================================================= --}}
{{-- HEADER --}}
{{-- ========================================================= --}}
<div class="mb-8">

    <h1 class="text-4xl font-bold text-[#0F0937]">

        Dashboard Penghuni

    </h1>

    <p class="text-gray-500 mt-3">

        Informasi kamar dan tagihan kost anda.

    </p>

</div>

{{-- ========================================================= --}}
{{-- CARD --}}
{{-- ========================================================= --}}
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">

    {{-- KOST --}}
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">

        <p class="text-sm text-gray-500">

            Nama Kost

        </p>

        <h2 class="text-2xl font-bold text-[#0F0937] mt-3">

            {{ $tagihan?->kamar?->kost?->nama_kost ?? '-' }}

        </h2>

    </div>

    {{-- NOMOR KAMAR --}}
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">

        <p class="text-sm text-gray-500">

            Kamar

        </p>

        <h2 class="text-2xl font-bold text-[#0F0937] mt-3">

            {{ $tagihan?->kamar?->nomor_kamar ?? '-' }}

        </h2>

        <p class="text-sm text-gray-400 mt-2">

            {{ $tagihan?->kamar?->nama_kamar ?? 'Tanpa Nama Kamar' }}

        </p>

    </div>

    {{-- TOTAL TAGIHAN --}}
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">

        <p class="text-sm text-gray-500">

            Total Tagihan

        </p>

        <h2 class="text-3xl font-bold text-[#0F0937] mt-3">

            {{ $jumlahTagihan }}

        </h2>

    </div>

    {{-- BELUM LUNAS --}}
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">

        <p class="text-sm text-gray-500">

            Belum Lunas

        </p>

        <h2 class="text-3xl font-bold text-[#0F0937] mt-3">

            {{ $tagihanPending }}

        </h2>

    </div>

</div>

{{-- ========================================================= --}}
{{-- INFORMASI MASA KOS --}}
{{-- ========================================================= --}}
<div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 mb-8">

    <div class="flex items-center justify-between mb-6">

        <div>

            <h2 class="text-2xl font-bold text-[#0F0937]">

                Masa Kos

            </h2>

            <p class="text-gray-500 mt-2">

                Informasi periode sewa kamar anda.

            </p>

        </div>

    </div>

    @if($tagihan)

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- MULAI --}}
            <div>

                <p class="text-sm text-gray-500">

                    Tanggal Masuk

                </p>

                <h3 class="text-xl font-bold text-[#0F0937] mt-2">

                    {{ $tagihan->tanggal_mulai->format('d M Y') }}

                </h3>

            </div>

            {{-- SELESAI --}}
            <div>

                <p class="text-sm text-gray-500">

                    Tanggal Selesai

                </p>

                <h3 class="text-xl font-bold text-[#0F0937] mt-2">

                    {{ $tagihan->tanggal_selesai->format('d M Y') }}

                </h3>

            </div>

        </div>

    @else

        <div class="text-gray-400 py-10 text-center">

            Belum ada data masa kos.

        </div>

    @endif

</div>

{{-- ========================================================= --}}
{{-- TAGIHAN TERBARU --}}
{{-- ========================================================= --}}
<div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">

    <div class="flex items-center justify-between mb-6">

        <div>

            <h2 class="text-2xl font-bold text-[#0F0937]">

                Tagihan Terbaru

            </h2>

            <p class="text-gray-500 mt-2">

                Informasi tagihan pembayaran anda.

            </p>

        </div>

        <a
            href="{{ route('penghuni.pembayaran.index') }}"
            class="text-[#6C8B6B] font-semibold"
        >

            Lihat Semua

        </a>

    </div>

    @if($tagihan)

    <div
        class="border border-gray-200 rounded-2xl p-6"
    >

        <div
            class="flex flex-col lg:flex-row
                   lg:items-center lg:justify-between gap-6"
        >

            {{-- INFORMASI --}}
            <div>

                {{-- KAMAR --}}
                <h3
                    class="text-2xl font-bold text-[#0F0937]"
                >

                    Kamar
                    {{ $tagihan->kamar->nomor_kamar }}

                </h3>

                {{-- PERIODE --}}
                <p class="text-gray-500 mt-3">

                    {{ $tagihan->tanggal_mulai->format('d M Y') }}
                    -
                    {{ $tagihan->tanggal_selesai->format('d M Y') }}

                </p>

                {{-- INTERVAL PEMBAYARAN --}}
                @if(
                    $tagihan->hargaKamar &&
                    $tagihan->hargaKamar->periode
                )

                <div
                    class="mt-4 inline-flex items-center gap-2
                           bg-[#F8F5F0]
                           px-4 py-2 rounded-xl"
                >

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="w-5 h-5 text-[#6C8B6B]"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10m-11 9h12a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v11a2 2 0 002 2z"
                        />

                    </svg>

                    <span
                        class="text-sm font-semibold text-[#0F0937]"
                    >

                        Pembayaran setiap
                        {{ $tagihan->hargaKamar->periode->jumlah_interval }}
                        {{ $tagihan->hargaKamar->periode->satuan_interval }}

                    </span>

                </div>

                @endif

            </div>

            {{-- STATUS --}}
            <div>

                @if(
                    $tagihan->status === 'pending' &&
                    $tagihan->status_bukti === 'belum_upload'
                )

                <span
                    class="px-4 py-2 rounded-full
                           bg-gray-100 text-gray-700
                           text-sm font-semibold"
                >

                    Belum Bayar

                </span>

                @elseif(
                    $tagihan->status === 'pending' &&
                    $tagihan->status_bukti === 'menunggu'
                )

                <span
                    class="px-4 py-2 rounded-full
                           bg-yellow-100 text-yellow-700
                           text-sm font-semibold"
                >

                    Menunggu Verifikasi

                </span>

                @elseif(
                    $tagihan->status === 'pending' &&
                    $tagihan->status_bukti === 'ditolak'
                )

                <span
                    class="px-4 py-2 rounded-full
                           bg-red-100 text-red-700
                           text-sm font-semibold"
                >

                    Ditolak

                </span>

                @elseif($tagihan->status === 'lunas')

                <span
                    class="px-4 py-2 rounded-full
                           bg-green-100 text-green-700
                           text-sm font-semibold"
                >

                    Lunas

                </span>

                @elseif($tagihan->status === 'telat')

                <span
                    class="px-4 py-2 rounded-full
                           bg-red-100 text-red-700
                           text-sm font-semibold"
                >

                    Telat

                </span>

                @endif

            </div>

        </div>

    </div>

    @else

    <div class="text-gray-400 py-10 text-center">

        Belum ada tagihan.

    </div>

    @endif

</div>

@endsection