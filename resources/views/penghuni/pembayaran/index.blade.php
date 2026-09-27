@extends('layouts.penghuni')

@section('content')

@php

$grouped = $tagihanAktif->groupBy(
fn($i) => $i->tanggal_mulai->format('F Y')
);

$totalSemuaTagihan = $tagihanAktif->sum(
fn($i) => $i->hargaKamar?->harga ?? 0
);

$totalSudahDibayar = $tagihanAktif->sum(
fn($i) => $i->pembayaran
->where('status_validasi', 'diterima')
->sum('nominal_pembayaran')
);

$totalSisaTagihan = max(
0,
$totalSemuaTagihan - $totalSudahDibayar
);

$jumlahBelumLunas = $tagihanAktif->filter(
fn($i) => $i->status_label !== 'lunas'
)->count();

$progressPembayaran = $totalSemuaTagihan > 0
? min(
100,
round(
($totalSudahDibayar / $totalSemuaTagihan) * 100
)
)
: 0;

@endphp


<div class="p-6 space-y-7">


    {{-- ========================================================= --}}
    {{-- HEADER --}}
    {{-- ========================================================= --}}

    <div>

        <h1 class="text-3xl font-bold text-[#0F0937]">
            Pembayaran Saya
        </h1>

        <p class="text-gray-500 mt-1">
            Pantau tagihan dan pembayaran kost Anda dengan mudah.
        </p>

    </div>



    {{-- ========================================================= --}}
    {{-- TAB --}}
    {{-- ========================================================= --}}

    <div class="flex items-center gap-8 border-b border-gray-200">

        <a href="{{ route('penghuni.pembayaran.index') }}" class="relative pb-4 text-sm font-semibold text-[#6C8B6B]">

            Tagihan

            <span class="absolute bottom-[-1px]
                       left-0 right-0
                       h-0.5
                       bg-[#6C8B6B]
                       rounded-full"></span>

        </a>


        <a href="{{ route('penghuni.riwayat-pembayaran') }}" class="pb-4 text-sm font-semibold
                   text-gray-400
                   hover:text-[#6C8B6B]
                   transition">

            Riwayat Pembayaran

        </a>

    </div>



    {{-- ========================================================= --}}
    {{-- HERO PAYMENT SUMMARY --}}
    {{-- ========================================================= --}}

    <div class="relative overflow-hidden
               rounded-[2rem]
               bg-[#1F3A2C]
               text-white
               p-7 sm:p-9">

        {{-- DECORATION --}}
        <div class="absolute
                   -right-16 -top-20
                   w-64 h-64
                   rounded-full
                   bg-[#6C8B6B]/30"></div>

        <div class="absolute
                   -right-5 -bottom-24
                   w-48 h-48
                   rounded-full
                   border-[30px]
                   border-white/5"></div>


        <div class="relative z-10
                   grid grid-cols-1
                   xl:grid-cols-[1fr_auto]
                   gap-8
                   items-center">

            {{-- LEFT --}}
            <div>

                <div class="flex items-center gap-2 mb-4">

                    <span class="w-2 h-2
                               rounded-full
                               bg-[#A9C6AD]"></span>

                    <span class="text-sm
                               text-white/70">

                        Ringkasan Pembayaran

                    </span>

                </div>


                <p class="text-sm text-white/60">
                    Total sisa tagihan
                </p>


                <h2 class="text-3xl sm:text-4xl
                           font-bold mt-1">

                    Rp {{ number_format(
                        $totalSisaTagihan,
                        0,
                        ',',
                        '.'
                    ) }}

                </h2>


                <div class="mt-6
                           max-w-xl">

                    <div class="flex justify-between
                               text-xs
                               text-white/60
                               mb-2">

                        <span>
                            Progress pembayaran
                        </span>

                        <span>
                            {{ $progressPembayaran }}%
                        </span>

                    </div>


                    <div class="h-2
                               rounded-full
                               bg-white/10
                               overflow-hidden">

                        <div class="h-full
                                   rounded-full
                                   bg-[#A9C6AD]
                                   transition-all" style="width: {{ $progressPembayaran }}%"></div>

                    </div>

                </div>

            </div>


            {{-- RIGHT CTA --}}
            <div class="relative">

                <button type="button" onclick="openModal()" class="w-full sm:w-auto
                           bg-white
                           text-[#1F3A2C]
                           hover:bg-[#F3F7F3]
                           px-7 py-4
                           rounded-2xl
                           font-bold
                           text-sm
                           shadow-lg
                           transition">

                    + Bayar Tagihan

                </button>

            </div>

        </div>

    </div>



    {{-- ========================================================= --}}
    {{-- SUMMARY CARDS --}}
    {{-- ========================================================= --}}

    <div class="grid grid-cols-1
               sm:grid-cols-3
               gap-4">

        {{-- TOTAL --}}
        <div class="bg-white
                   rounded-3xl
                   border border-gray-100
                   p-6
                   shadow-sm">

            <p class="text-sm text-gray-500">
                Total Tagihan
            </p>

            <h3 class="text-2xl
                       font-bold
                       text-[#0F0937]
                       mt-2">

                Rp {{ number_format(
                    $totalSemuaTagihan,
                    0,
                    ',',
                    '.'
                ) }}

            </h3>

            <p class="text-xs text-gray-400 mt-1">
                seluruh periode
            </p>

        </div>


        {{-- SUDAH BAYAR --}}
        <div class="bg-[#F3F8F4]
                   rounded-3xl
                   border border-[#E1ECE2]
                   p-6">

            <p class="text-sm text-[#6C8B6B]">
                Sudah Dibayar
            </p>

            <h3 class="text-2xl
                       font-bold
                       text-[#315B3B]
                       mt-2">

                Rp {{ number_format(
                    $totalSudahDibayar,
                    0,
                    ',',
                    '.'
                ) }}

            </h3>

            <p class="text-xs text-[#78927D] mt-1">
                pembayaran diterima
            </p>

        </div>


        {{-- BELUM LUNAS --}}
        <div class="bg-[#FFF7F2]
                   rounded-3xl
                   border border-[#F5E4D8]
                   p-6">

            <p class="text-sm text-orange-600">
                Belum Lunas
            </p>

            <h3 class="text-2xl
                       font-bold
                       text-orange-800
                       mt-2">

                {{ $jumlahBelumLunas }}

            </h3>

            <p class="text-xs text-orange-500 mt-1">
                tagihan perlu diperhatikan
            </p>

        </div>

    </div>



    {{-- ========================================================= --}}
    {{-- DAFTAR TAGIHAN --}}
    {{-- ========================================================= --}}

    <div>

        <div class="flex items-center
                   justify-between
                   mb-5">

            <div>

                <h2 class="text-xl
                           font-bold
                           text-[#0F0937]">

                    Daftar Tagihan

                </h2>

                <p class="text-sm
                           text-gray-500
                           mt-1">

                    Riwayat tagihan berdasarkan periode.

                </p>

            </div>

        </div>



        @forelse($grouped as $bulan => $tagihanBulan)

        {{-- BULAN --}}
        <div class="mb-7">

            <div class="flex items-center
                           gap-3
                           mb-4">

                <span class="text-sm
                               font-bold
                               text-[#0F0937]">

                    {{ $bulan }}

                </span>


                <div class="flex-1
                               h-px
                               bg-gray-200"></div>

            </div>



            {{-- ================================================= --}}
            {{-- TIMELINE --}}
            {{-- ================================================= --}}

            <div class="relative">

                {{-- GARIS TIMELINE --}}
                <div class="hidden sm:block
                               absolute
                               left-[27px]
                               top-7
                               bottom-7
                               w-px
                               bg-gray-200"></div>


                <div class="space-y-4">

                    @foreach($tagihanBulan as $i)

                    @php

                    $totalDibayar =
                    $i->pembayaran
                    ->where(
                    'status_validasi',
                    'diterima'
                    )
                    ->sum(
                    'nominal_pembayaran'
                    );

                    $totalTagihan =
                    $i->hargaKamar?->harga ?? 0;

                    $sisa =
                    max(
                    0,
                    $totalTagihan
                    - $totalDibayar
                    );

                    $progress =
                    $totalTagihan > 0
                    ? min(
                    100,
                    round(
                    (
                    $totalDibayar
                    /
                    $totalTagihan
                    ) * 100
                    )
                    )
                    : 0;

                    @endphp


                    <div class="relative
                                       bg-white
                                       rounded-3xl
                                       border border-gray-100
                                       shadow-sm
                                       overflow-hidden">

                        {{-- ================================================= --}}
                        {{-- MAIN ROW --}}
                        {{-- ================================================= --}}

                        <button type="button" onclick="toggleDetail('detail-{{ $i->id_tagihan }}')" class="w-full
                                           text-left
                                           p-5 sm:p-6
                                           hover:bg-gray-50/70
                                           transition">

                            <div class="flex
                                               flex-col
                                               sm:flex-row
                                               sm:items-center
                                               gap-5">

                                {{-- TIMELINE DOT --}}
                                <div class="hidden sm:flex
                                                   relative z-10
                                                   w-14 h-14
                                                   rounded-2xl
                                                   bg-[#EEF4EF]
                                                   items-center
                                                   justify-center
                                                   shrink-0">

                                    <svg class="w-6 h-6
                                                       text-[#6C8B6B]" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">

                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                            d="M8 7V3m8 4V3m-9 8h10m-9 4h4m-8 5h14a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v11a2 2 0 002 2z" />

                                    </svg>

                                </div>


                                {{-- INFO --}}
                                <div class="flex-1 min-w-0">

                                    <div class="flex
                                                       flex-wrap
                                                       items-center
                                                       gap-2">

                                        <h3 class="font-bold
                                                           text-[#0F0937]">

                                            {{ $i->tanggal_mulai->format('d M') }}

                                            –

                                            {{ $i->tanggal_selesai->format('d M Y') }}

                                        </h3>


                                        {{-- STATUS --}}
                                        @if($i->status_label === 'lunas')

                                        <span class="px-2.5 py-1
                                                               rounded-full
                                                               bg-green-50
                                                               text-green-700
                                                               text-[11px]
                                                               font-bold">
                                            Lunas
                                        </span>

                                        @elseif($i->status_label === 'menunggu_verifikasi')

                                        <span class="px-2.5 py-1
                                                               rounded-full
                                                               bg-yellow-50
                                                               text-yellow-700
                                                               text-[11px]
                                                               font-bold">
                                            Menunggu Verifikasi
                                        </span>

                                        @elseif($i->status_label === 'telat')

                                        <span class="px-2.5 py-1
                                                               rounded-full
                                                               bg-red-50
                                                               text-red-700
                                                               text-[11px]
                                                               font-bold">
                                            Telat
                                        </span>

                                        @elseif($i->status_label === 'ditolak')

                                        <span class="px-2.5 py-1
                                                               rounded-full
                                                               bg-red-50
                                                               text-red-700
                                                               text-[11px]
                                                               font-bold">
                                            Ditolak
                                        </span>

                                        @else

                                        <span class="px-2.5 py-1
                                                               rounded-full
                                                               bg-gray-100
                                                               text-gray-600
                                                               text-[11px]
                                                               font-bold">
                                            Belum Lunas
                                        </span>

                                        @endif

                                    </div>


                                    <p class="text-xs
                                                       text-gray-400
                                                       mt-1">

                                        Jatuh tempo:
                                        {{ $i->tanggal_jatuh_tempo?->format('d M Y') ?? '-' }}

                                    </p>

                                </div>


                                {{-- NOMINAL --}}
                                <div class="sm:text-right
                                                   sm:min-w-[160px]">

                                    <p class="text-xs
                                                       text-gray-400">
                                        Total
                                    </p>

                                    <p class="text-base
                                                       font-bold
                                                       text-[#0F0937]
                                                       mt-0.5">

                                        Rp {{ number_format(
                                                    $totalTagihan,
                                                    0,
                                                    ',',
                                                    '.'
                                                ) }}

                                    </p>

                                </div>


                                {{-- CHEVRON --}}
                                <div class="hidden sm:flex
                                                   w-9 h-9
                                                   rounded-xl
                                                   bg-gray-50
                                                   items-center
                                                   justify-center
                                                   shrink-0">

                                    <svg id="chevron-{{ $i->id_tagihan }}" class="w-4 h-4
                                                       text-gray-400
                                                       transition-transform
                                                       duration-200" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">

                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />

                                    </svg>

                                </div>

                            </div>

                        </button>



                        {{-- ================================================= --}}
                        {{-- DETAIL --}}
                        {{-- ================================================= --}}

                        <div id="detail-{{ $i->id_tagihan }}" class="hidden
                                           border-t
                                           border-gray-100
                                           bg-[#FAFBFA]
                                           px-5 sm:px-6
                                           py-6">

                            <div class="grid
                                               grid-cols-1
                                               lg:grid-cols-[1fr_280px]
                                               gap-6">

                                {{-- LEFT --}}
                                <div>

                                    <h4 class="text-sm
                                                       font-bold
                                                       text-[#0F0937]
                                                       mb-4">

                                        Detail Pembayaran

                                    </h4>


                                    <div class="grid
                                                       grid-cols-2
                                                       sm:grid-cols-3
                                                       gap-3">

                                        <div class="bg-white
                                                           border border-gray-100
                                                           rounded-2xl
                                                           p-4">

                                            <p class="text-[11px]
                                                               text-gray-400">
                                                Total
                                            </p>

                                            <p class="text-sm
                                                               font-bold
                                                               text-[#0F0937]
                                                               mt-1">

                                                Rp {{ number_format(
                                                            $totalTagihan,
                                                            0,
                                                            ',',
                                                            '.'
                                                        ) }}

                                            </p>

                                        </div>


                                        <div class="bg-white
                                                           border border-gray-100
                                                           rounded-2xl
                                                           p-4">

                                            <p class="text-[11px]
                                                               text-gray-400">
                                                Dibayar
                                            </p>

                                            <p class="text-sm
                                                               font-bold
                                                               text-green-600
                                                               mt-1">

                                                Rp {{ number_format(
                                                            $totalDibayar,
                                                            0,
                                                            ',',
                                                            '.'
                                                        ) }}

                                            </p>

                                        </div>


                                        <div class="bg-white
                                                           border border-gray-100
                                                           rounded-2xl
                                                           p-4">

                                            <p class="text-[11px]
                                                               text-gray-400">
                                                Sisa
                                            </p>

                                            <p class="text-sm
                                                               font-bold
                                                               {{ $sisa > 0
                                                                    ? 'text-red-600'
                                                                    : 'text-gray-400' }}
                                                               mt-1">

                                                Rp {{ number_format(
                                                            $sisa,
                                                            0,
                                                            ',',
                                                            '.'
                                                        ) }}

                                            </p>

                                        </div>

                                    </div>


                                    {{-- PROGRESS --}}
                                    <div class="mt-5">

                                        <div class="flex
                                                           justify-between
                                                           text-xs
                                                           mb-2">

                                            <span class="text-gray-500">
                                                Progress pembayaran
                                            </span>

                                            <span class="font-semibold
                                                               text-[#6C8B6B]">

                                                {{ $progress }}%

                                            </span>

                                        </div>


                                        <div class="h-2
                                                           bg-gray-200
                                                           rounded-full
                                                           overflow-hidden">

                                            <div class="h-full
                                                               bg-[#6C8B6B]
                                                               rounded-full" style="width: {{ $progress }}%"></div>

                                        </div>

                                    </div>

                                </div>


                                {{-- RIGHT --}}
                                <div>

                                    @if(
                                    $i->status_label
                                    === 'menunggu_verifikasi'
                                    )

                                    <div class="bg-yellow-50
                                                           border border-yellow-100
                                                           rounded-2xl
                                                           p-4">

                                        <p class="text-sm
                                                               font-bold
                                                               text-yellow-800">

                                            Sedang Diverifikasi

                                        </p>

                                        <p class="text-xs
                                                               text-yellow-700
                                                               mt-1
                                                               leading-relaxed">

                                            Pembayaran Anda sedang
                                            diperiksa oleh admin.

                                        </p>

                                    </div>


                                    @elseif(
                                    $i->status_label
                                    === 'ditolak'
                                    )

                                    <div class="bg-red-50
                                                           border border-red-100
                                                           rounded-2xl
                                                           p-4">

                                        <p class="text-sm
                                                               font-bold
                                                               text-red-800">

                                            Pembayaran Ditolak

                                        </p>

                                        <p class="text-xs
                                                               text-red-700
                                                               mt-1
                                                               leading-relaxed">

                                            Silakan upload kembali
                                            bukti pembayaran.

                                        </p>

                                    </div>


                                    @elseif(
                                    $totalDibayar > 0
                                    && $sisa > 0
                                    )

                                    <div class="bg-[#EEF4EF]
                                                           border border-[#DCE9DE]
                                                           rounded-2xl
                                                           p-4">

                                        <p class="text-sm
                                                               font-bold
                                                               text-[#315B3B]">

                                            Pembayaran Dicicil

                                        </p>

                                        <p class="text-xs
                                                               text-[#5F7864]
                                                               mt-1">

                                            Masih ada sisa pembayaran
                                            pada periode ini.

                                        </p>

                                    </div>

                                    @endif

                                </div>

                            </div>

                        </div>

                    </div>

                    @endforeach

                </div>

            </div>

        </div>

        @empty


        {{-- ================================================= --}}
        {{-- EMPTY --}}
        {{-- ================================================= --}}

        <div class="bg-white
                       border border-gray-100
                       rounded-[2rem]
                       p-14
                       text-center
                       shadow-sm">

            <div class="w-20 h-20
                           mx-auto
                           rounded-3xl
                           bg-[#EEF4EF]
                           flex items-center
                           justify-center">

                <svg class="w-9 h-9 text-[#6C8B6B]" fill="none" viewBox="0 0 24 24" stroke="currentColor">

                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M3 7h18M5 7v12h14V7M8 4h8l1 3H7l1-3z" />

                </svg>

            </div>


            <h3 class="text-xl
                           font-bold
                           text-[#0F0937]
                           mt-5">

                Belum Ada Tagihan

            </h3>


            <p class="text-sm
                           text-gray-500
                           mt-2">

                Tagihan akan muncul setelah admin
                mengaktifkan penghuni.

            </p>

        </div>

        @endforelse

    </div>

</div>



{{-- ========================================================= --}}
{{-- MODAL BAYAR --}}
{{-- ========================================================= --}}

<div id="modal-bayar" class="fixed inset-0
           bg-[#0F172A]/60
           backdrop-blur-sm
           hidden
           items-center
           justify-center
           z-50
           p-4">

    <div class="bg-white
               rounded-[2rem]
               w-full
               max-w-xl
               max-h-[90vh]
               overflow-y-auto
               shadow-2xl">

        {{-- HEADER --}}
        <div class="bg-[#1F3A2C]
                   px-6 sm:px-8
                   py-7
                   text-white">

            <div class="flex items-start
                       justify-between
                       gap-4">

                <div>

                    <p class="text-xs
                               uppercase
                               tracking-widest
                               text-white/50">

                        Pembayaran

                    </p>

                    <h2 class="text-2xl
                               font-bold
                               mt-1">

                        Bayar Tagihan

                    </h2>

                    <p class="text-sm
                               text-white/60
                               mt-1">

                        Upload bukti pembayaran Anda.

                    </p>

                </div>


                <button type="button" onclick="closeModal()" class="w-9 h-9
                           rounded-xl
                           bg-white/10
                           hover:bg-white/20
                           flex items-center
                           justify-center
                           transition">

                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 6l12 12M18 6L6 18" />

                    </svg>

                </button>

            </div>

        </div>


        {{-- FORM --}}
        <div class="p-6 sm:p-8">

            <form method="POST" enctype="multipart/form-data" action="{{ route('penghuni.pembayaran.store') }}"
                class="space-y-5">

                @csrf


                {{-- PILIH TAGIHAN --}}
                <div>

                    <label class="block
                               text-sm
                               font-semibold
                               text-gray-700
                               mb-2">

                        Pilih Tagihan

                    </label>


                    <select name="id_tagihan" required class="w-full
                               bg-gray-50
                               border border-gray-200
                               rounded-2xl
                               px-4 py-3.5
                               text-sm
                               outline-none
                               focus:border-[#6C8B6B]
                               focus:ring-2
                               focus:ring-[#6C8B6B]/10">

                        <option value="">
                            -- Pilih Tagihan --
                        </option>


                        @foreach($tagihanAktif as $t)

                        @php

                        $dibayar =
                        $t->pembayaran
                        ->where(
                        'status_validasi',
                        'diterima'
                        )
                        ->sum(
                        'nominal_pembayaran'
                        );

                        $sisa =
                        ($t->hargaKamar?->harga ?? 0)
                        - $dibayar;

                        @endphp


                        @if(
                        in_array(
                        $t->status_label,
                        [
                        'pending',
                        'telat',
                        'ditolak'
                        ],
                        true
                        )
                        )

                        <option value="{{ $t->id_tagihan }}">

                            {{ $t->tanggal_mulai->format('d M Y') }}

                            -

                            {{ $t->tanggal_selesai->format('d M Y') }}

                            | Sisa:
                            Rp {{ number_format(
                                        $sisa,
                                        0,
                                        ',',
                                        '.'
                                    ) }}

                        </option>

                        @endif

                        @endforeach

                    </select>

                </div>



                {{-- NOMINAL --}}
                <div>

                    <label class="block
                               text-sm
                               font-semibold
                               text-gray-700
                               mb-2">

                        Nominal Pembayaran

                    </label>


                    <div class="relative">

                        <span class="absolute
                                   left-4
                                   top-1/2
                                   -translate-y-1/2
                                   text-sm
                                   font-semibold
                                   text-gray-400">

                            Rp

                        </span>


                        <input type="number" name="nominal_pembayaran" required min="1000" class="w-full
                                   bg-gray-50
                                   border border-gray-200
                                   rounded-2xl
                                   pl-12 pr-4
                                   py-3.5
                                   text-sm
                                   outline-none
                                   focus:border-[#6C8B6B]
                                   focus:ring-2
                                   focus:ring-[#6C8B6B]/10" placeholder="Masukkan nominal">

                    </div>

                </div>



                {{-- BUKTI --}}
                <div>

                    <label class="block
                               text-sm
                               font-semibold
                               text-gray-700
                               mb-2">

                        Bukti Pembayaran

                    </label>


                    <label for="bukti_bayar" class="block
                               bg-[#F7F9F7]
                               border-2
                               border-dashed
                               border-gray-200
                               hover:border-[#6C8B6B]
                               rounded-2xl
                               p-5
                               cursor-pointer
                               transition">

                        <div class="flex items-center
                                   gap-4">

                            <div class="w-11 h-11
                                       rounded-xl
                                       bg-[#E8F0E9]
                                       flex items-center
                                       justify-center
                                       shrink-0">

                                <svg class="w-5 h-5
                                           text-[#6C8B6B]" fill="none" viewBox="0 0 24 24" stroke="currentColor">

                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M4 16l4-4 3 3 5-6 4 5M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z" />

                                </svg>

                            </div>


                            <div class="min-w-0">

                                <p class="text-sm
                                           font-semibold
                                           text-[#0F0937]">

                                    Pilih bukti pembayaran

                                </p>

                                <p id="file-name" class="text-xs
                                           text-gray-400
                                           mt-1
                                           truncate">

                                    JPG, JPEG, PNG · Maks. 10 MB

                                </p>

                            </div>

                        </div>

                    </label>


                    <input type="file" name="bukti_bayar" id="bukti_bayar" accept=".jpg,.jpeg,.png" class="hidden"
                        required>


                    <p id="file-error" class="hidden
                               text-xs
                               text-red-600
                               mt-2
                               font-medium"></p>


                    <button type="button" id="preview-button" class="hidden
                               mt-3
                               text-sm
                               font-semibold
                               text-[#6C8B6B]
                               hover:underline">

                        Lihat Bukti Pembayaran

                    </button>


                    @error('bukti_bayar')

                    <p class="text-xs
                                   text-red-600
                                   mt-2">

                        {{ $message }}

                    </p>

                    @enderror

                </div>



                {{-- BUTTON --}}
                <div class="flex gap-3 pt-2">

                    <button type="button" onclick="closeModal()" class="flex-1
                               border border-gray-200
                               hover:bg-gray-50
                               py-3.5
                               rounded-2xl
                               font-semibold
                               text-sm
                               text-gray-600
                               transition">

                        Kembali

                    </button>


                    <button type="submit" class="flex-1
                               bg-[#6C8B6B]
                               hover:bg-[#5B765A]
                               text-white
                               py-3.5
                               rounded-2xl
                               font-semibold
                               text-sm
                               transition">

                        Kirim Pembayaran

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>



{{-- ========================================================= --}}
{{-- PREVIEW IMAGE --}}
{{-- ========================================================= --}}

<div id="image-modal" class="fixed inset-0
           bg-black/70
           backdrop-blur-sm
           hidden
           items-center
           justify-center
           z-[60]
           p-4">

    <div class="relative
               bg-white
               rounded-3xl
               p-5
               max-w-lg
               w-full
               shadow-2xl">

        <button type="button" id="close-image-modal" class="absolute
                   -top-3
                   -right-3
                   w-9 h-9
                   rounded-full
                   bg-white
                   shadow-lg
                   flex items-center
                   justify-center
                   text-gray-500
                   hover:text-red-500">

            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">

                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 6l12 12M18 6L6 18" />

            </svg>

        </button>


        <h3 class="text-lg
                   font-bold
                   text-[#0F0937]
                   mb-4">

            Preview Bukti Pembayaran

        </h3>


        <div class="flex justify-center">

            <img id="preview-image" src="" alt="Preview Bukti Pembayaran" class="max-h-[70vh]
                       max-w-full
                       rounded-2xl
                       object-contain">

        </div>

    </div>

</div>



{{-- ========================================================= --}}
{{-- JAVASCRIPT --}}
{{-- ========================================================= --}}

<script>
// =========================================================
// DETAIL TAGIHAN
// =========================================================

function toggleDetail(id) {

    const detail =
        document.getElementById(id);

    const tagId =
        id.replace('detail-', '');

    const chevron =
        document.getElementById(
            'chevron-' + tagId
        );

    const isOpen = !detail.classList.contains('hidden');


    document
        .querySelectorAll('[id^="detail-"]')
        .forEach(d => {

            d.classList.add('hidden');

        });


    document
        .querySelectorAll('[id^="chevron-"]')
        .forEach(c => {

            c.style.transform = '';

        });


    if (!isOpen) {

        detail.classList.remove('hidden');

        if (chevron) {

            chevron.style.transform =
                'rotate(180deg)';

        }

    }

}



// =========================================================
// MODAL BAYAR
// =========================================================

function openModal() {

    const modal =
        document.getElementById('modal-bayar');

    modal.classList.remove('hidden');

    modal.classList.add('flex');

    document.body.classList.add(
        'overflow-hidden'
    );

}


function closeModal() {

    const modal =
        document.getElementById('modal-bayar');

    modal.classList.remove('flex');

    modal.classList.add('hidden');

    document.body.classList.remove(
        'overflow-hidden'
    );

}



// =========================================================
// FILE
// =========================================================

const buktiBayar =
    document.getElementById('bukti_bayar');

const fileName =
    document.getElementById('file-name');

const fileError =
    document.getElementById('file-error');

const previewButton =
    document.getElementById('preview-button');

const imageModal =
    document.getElementById('image-modal');

const previewImage =
    document.getElementById('preview-image');

const closeImageModal =
    document.getElementById('close-image-modal');

let selectedImage = null;



// =========================================================
// PILIH FILE
// =========================================================

buktiBayar.addEventListener(
    'change',
    function() {

        const file =
            this.files[0];


        fileError.classList.add('hidden');

        fileError.innerText = '';

        previewButton.classList.add('hidden');

        previewImage.src = '';

        selectedImage = null;


        if (!file) {

            fileName.innerText =
                'JPG, JPEG, PNG · Maks. 10 MB';

            return;

        }


        // MAX 10 MB
        const maxSize =
            10 * 1024 * 1024;


        if (file.size > maxSize) {

            fileError.innerText =
                'Ukuran file terlalu besar. Maksimal 10 MB.';

            fileError.classList.remove(
                'hidden'
            );

            fileName.innerText =
                'File terlalu besar';

            this.value = '';

            return;

        }


        // FORMAT
        const allowedTypes = [
            'image/jpeg',
            'image/png'
        ];


        if (!allowedTypes.includes(file.type)) {

            fileError.innerText =
                'Format file tidak sesuai. Gunakan JPG, JPEG, atau PNG.';

            fileError.classList.remove(
                'hidden'
            );

            fileName.innerText =
                'Format file tidak sesuai';

            this.value = '';

            return;

        }


        // FILE NAME
        const sizeMB =
            (
                file.size /
                (1024 * 1024)
            ).toFixed(2);


        fileName.innerText =
            file.name +
            ' · ' +
            sizeMB +
            ' MB';


        // PREVIEW
        selectedImage =
            URL.createObjectURL(file);

        previewImage.src =
            selectedImage;

        previewButton.classList.remove(
            'hidden'
        );

    }
);



// =========================================================
// PREVIEW
// =========================================================

previewButton.addEventListener(
    'click',
    function() {

        if (!selectedImage) {
            return;
        }


        const paymentModal =
            document.getElementById(
                'modal-bayar'
            );


        paymentModal.classList.remove(
            'flex'
        );

        paymentModal.classList.add(
            'hidden'
        );


        imageModal.classList.remove(
            'hidden'
        );

        imageModal.classList.add(
            'flex'
        );

    }
);



// =========================================================
// CLOSE PREVIEW
// =========================================================

function closeImagePreview() {

    imageModal.classList.remove(
        'flex'
    );

    imageModal.classList.add(
        'hidden'
    );


    const paymentModal =
        document.getElementById(
            'modal-bayar'
        );


    paymentModal.classList.remove(
        'hidden'
    );

    paymentModal.classList.add(
        'flex'
    );

}



// =========================================================
// CLOSE BUTTON
// =========================================================

closeImageModal.addEventListener(
    'click',
    function() {

        closeImagePreview();

    }
);



// =========================================================
// CLICK OUTSIDE
// =========================================================

imageModal.addEventListener(
    'click',
    function(event) {

        if (event.target === imageModal) {

            closeImagePreview();

        }

    }
);



// =========================================================
// ESC
// =========================================================

document.addEventListener(
    'keydown',
    function(event) {

        if (event.key !== 'Escape') {
            return;
        }


        if (
            !imageModal.classList
            .contains('hidden')
        ) {

            closeImagePreview();

            return;

        }


        const paymentModal =
            document.getElementById(
                'modal-bayar'
            );


        if (
            !paymentModal.classList
            .contains('hidden')
        ) {

            closeModal();

        }

    }
);
</script>

@endsection