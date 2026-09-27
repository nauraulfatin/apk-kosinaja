@extends('layouts.penghuni')

@section('content')

@php

$totalTransaksi = $items->count();

$totalDiterima = $items
->where('status_validasi', 'diterima')
->count();

$totalMenunggu = $items
->where('status_validasi', 'menunggu')
->count();

$totalDitolak = $items
->where('status_validasi', 'ditolak')
->count();

$totalNominal = $items->sum('nominal_pembayaran');

@endphp


<div class="p-6 space-y-7">


    {{-- =========================================================
        HEADER
    ========================================================== --}}

    <div>

        <div class="flex items-start justify-between gap-5">

            <div>

                <div class="flex items-center gap-3">

                    <div class="w-11 h-11
                               rounded-2xl
                               bg-[#EEF4EF]
                               flex items-center
                               justify-center">

                        <svg class="w-5 h-5 text-[#6C8B6B]" fill="none" viewBox="0 0 24 24" stroke="currentColor">

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M3 10h18M5 6h14a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2z" />

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 15h3" />

                        </svg>

                    </div>


                    <div>

                        <h1 class="text-2xl
                                   font-bold
                                   text-[#0F0937]">

                            Riwayat Pembayaran

                        </h1>

                        <p class="text-gray-500
                                   mt-1
                                   text-sm">

                            Semua transaksi pembayaran kost Anda.

                        </p>

                    </div>

                </div>

            </div>

        </div>


        {{-- =====================================================
            TABS
        ====================================================== --}}

        <div class="mt-7
                   flex items-center
                   gap-8
                   border-b border-gray-200">

            <a href="{{ route('penghuni.pembayaran.index') }}" class="relative
                       pb-4
                       text-sm
                       font-semibold
                       text-gray-400
                       hover:text-[#6C8B6B]
                       transition">

                Tagihan

            </a>


            <a href="{{ route('penghuni.riwayat-pembayaran') }}" class="relative
                       pb-4
                       text-sm
                       font-semibold
                       text-[#6C8B6B]">

                Riwayat Pembayaran

                <span class="absolute
                           left-0 right-0
                           bottom-[-1px]
                           h-0.5
                           bg-[#6C8B6B]
                           rounded-full"></span>

            </a>

        </div>

    </div>



    {{-- =========================================================
        SUMMARY
    ========================================================== --}}

    <div class="grid
               grid-cols-1
               sm:grid-cols-2
               xl:grid-cols-4
               gap-4">

        {{-- TOTAL TRANSAKSI --}}
        <div class="bg-[#1F3A2C]
                   rounded-3xl
                   p-6
                   text-white
                   relative
                   overflow-hidden">

            <div class="absolute
                       -right-8
                       -top-8
                       w-24 h-24
                       rounded-full
                       bg-white/5"></div>


            <p class="text-sm
                       text-white/60">

                Total Transaksi

            </p>


            <div class="flex items-end
                       gap-2
                       mt-2">

                <h2 class="text-3xl
                           font-bold">

                    {{ $totalTransaksi }}

                </h2>

                <span class="text-xs
                           text-white/50
                           mb-1.5">
                    transaksi
                </span>

            </div>

        </div>



        {{-- TOTAL NOMINAL --}}
        <div class="bg-white
                   rounded-3xl
                   p-6
                   border border-gray-100
                   shadow-sm">

            <p class="text-sm
                       text-gray-500">

                Total Pembayaran

            </p>


            <h2 class="text-xl
                       font-bold
                       text-[#0F0937]
                       mt-2">

                Rp {{ number_format(
                    $totalNominal,
                    0,
                    ',',
                    '.'
                ) }}

            </h2>


            <p class="text-xs
                       text-gray-400
                       mt-1">

                seluruh transaksi

            </p>

        </div>



        {{-- DITERIMA --}}
        <div class="bg-[#F2F8F3]
                   rounded-3xl
                   p-6
                   border border-[#E1ECE2]">

            <div class="flex items-center
                       justify-between">

                <p class="text-sm
                           text-[#5E7964]">

                    Diterima

                </p>


                <span class="w-2 h-2
                           rounded-full
                           bg-green-500"></span>

            </div>


            <h2 class="text-3xl
                       font-bold
                       text-[#315B3B]
                       mt-2">

                {{ $totalDiterima }}

            </h2>


            <p class="text-xs
                       text-[#78927D]
                       mt-1">

                pembayaran berhasil

            </p>

        </div>



        {{-- MENUNGGU --}}
        <div class="bg-[#FFF8ED]
                   rounded-3xl
                   p-6
                   border border-[#F2E6D3]">

            <div class="flex items-center
                       justify-between">

                <p class="text-sm
                           text-orange-600">

                    Menunggu

                </p>


                <span class="w-2 h-2
                           rounded-full
                           bg-orange-400"></span>

            </div>


            <h2 class="text-3xl
                       font-bold
                       text-orange-800
                       mt-2">

                {{ $totalMenunggu }}

            </h2>


            <p class="text-xs
                       text-orange-500
                       mt-1">

                menunggu verifikasi

            </p>

        </div>

    </div>



    {{-- =========================================================
        TRANSACTION HEADER
    ========================================================== --}}

    <div>

        <div class="flex items-end
                   justify-between
                   gap-4
                   mb-4">

            <div>

                <h2 class="text-xl
                           font-bold
                           text-[#0F0937]">

                    Semua Transaksi

                </h2>


                <p class="text-sm
                           text-gray-500
                           mt-1">

                    Catatan pembayaran yang telah Anda lakukan.

                </p>

            </div>


            @if($totalDitolak > 0)

            <span class="hidden sm:inline-flex
                           px-3 py-1.5
                           rounded-full
                           bg-red-50
                           text-red-600
                           text-xs
                           font-semibold">

                {{ $totalDitolak }} ditolak

            </span>

            @endif

        </div>



        {{-- =====================================================
            TRANSACTION LIST
        ====================================================== --}}

        @if($items->count())

        <div class="bg-white
                       rounded-3xl
                       border border-gray-100
                       shadow-sm
                       overflow-hidden">

            <div class="px-6 py-4
                           bg-[#F8F9F7]
                           border-b border-gray-100
                           hidden md:grid
                           grid-cols-[1.1fr_1.5fr_1.2fr_1fr_100px]
                           gap-5
                           items-center">

                <span class="text-xs
                               font-semibold
                               uppercase
                               tracking-wide
                               text-gray-400">
                    Tanggal
                </span>


                <span class="text-xs
                               font-semibold
                               uppercase
                               tracking-wide
                               text-gray-400">
                    Periode
                </span>


                <span class="text-xs
                               font-semibold
                               uppercase
                               tracking-wide
                               text-gray-400">
                    Nominal
                </span>


                <span class="text-xs
                               font-semibold
                               uppercase
                               tracking-wide
                               text-gray-400">
                    Status
                </span>


                <span class="text-xs
                               font-semibold
                               uppercase
                               tracking-wide
                               text-gray-400">
                    Bukti
                </span>

            </div>



            {{-- =================================================
                    TRANSACTIONS
                ================================================== --}}

            <div class="divide-y divide-gray-100">

                @foreach($items as $i)

                <div class="group
                                   px-6 py-5
                                   hover:bg-[#FAFCFA]
                                   transition">

                    {{-- DESKTOP --}}
                    <div class="hidden md:grid
                                       grid-cols-[1.1fr_1.5fr_1.2fr_1fr_100px]
                                       gap-5
                                       items-center">

                        {{-- TANGGAL --}}
                        <div>

                            <p class="font-semibold
                                               text-[#0F0937]
                                               text-sm">

                                {{ $i->tanggal_bayar?->format('d M Y') }}

                            </p>


                            <p class="text-xs
                                               text-gray-400
                                               mt-1">

                                {{ $i->tanggal_bayar?->format('H:i') ?? '-' }}

                                WIB

                            </p>

                        </div>



                        {{-- PERIODE --}}
                        <div>

                            <p class="text-sm
                                               font-medium
                                               text-gray-700">

                                {{ $i->tagihan?->tanggal_mulai?->format('d M Y') }}

                            </p>


                            <p class="text-xs
                                               text-gray-400
                                               mt-1">

                                sampai

                                {{ $i->tagihan?->tanggal_selesai?->format('d M Y') }}

                            </p>

                        </div>



                        {{-- NOMINAL --}}
                        <div>

                            <p class="text-sm
                                               font-bold
                                               text-[#0F0937]">

                                Rp {{ number_format(
                                            $i->nominal_pembayaran,
                                            0,
                                            ',',
                                            '.'
                                        ) }}

                            </p>

                        </div>



                        {{-- STATUS --}}
                        <div>

                            @if($i->status_validasi === 'diterima')

                            <span class="inline-flex
                                                   items-center
                                                   gap-2
                                                   px-3 py-1.5
                                                   rounded-full
                                                   bg-green-50
                                                   text-green-700
                                                   text-xs
                                                   font-semibold">

                                <span class="w-1.5 h-1.5
                                                       rounded-full
                                                       bg-green-500"></span>

                                Diterima

                            </span>


                            @elseif($i->status_validasi === 'ditolak')

                            <span class="inline-flex
                                                   items-center
                                                   gap-2
                                                   px-3 py-1.5
                                                   rounded-full
                                                   bg-red-50
                                                   text-red-700
                                                   text-xs
                                                   font-semibold">

                                <span class="w-1.5 h-1.5
                                                       rounded-full
                                                       bg-red-500"></span>

                                Ditolak

                            </span>


                            @else

                            <span class="inline-flex
                                                   items-center
                                                   gap-2
                                                   px-3 py-1.5
                                                   rounded-full
                                                   bg-yellow-50
                                                   text-yellow-700
                                                   text-xs
                                                   font-semibold">

                                <span class="w-1.5 h-1.5
                                                       rounded-full
                                                       bg-yellow-500"></span>

                                Menunggu

                            </span>

                            @endif

                        </div>



                        {{-- BUKTI --}}
                        <div>

                            @if($i->bukti_bayar)

                            <button type="button" onclick="openImageModal('{{ asset('storage/' . $i->bukti_bayar) }}')"
                                class="relative
                                                   block
                                                   group/image">

                                <img src="{{ asset('storage/' . $i->bukti_bayar) }}" alt="Bukti Pembayaran" class="w-16 h-16
                                                       rounded-xl
                                                       object-cover
                                                       border border-gray-200
                                                       group-hover/image:scale-105
                                                       group-hover/image:border-[#6C8B6B]
                                                       transition">


                                <span class="absolute
                                                       inset-0
                                                       rounded-xl
                                                       bg-black/0
                                                       group-hover/image:bg-black/20
                                                       transition"></span>

                            </button>

                            @else

                            <span class="text-xs
                                                   text-gray-400">

                                Tidak ada

                            </span>

                            @endif

                        </div>

                    </div>



                    {{-- =================================================
                                MOBILE
                            ================================================== --}}

                    <div class="md:hidden">

                        <div class="flex
                                           items-start
                                           justify-between
                                           gap-4">

                            <div>

                                <p class="font-bold
                                                   text-[#0F0937]">

                                    Rp {{ number_format(
                                                $i->nominal_pembayaran,
                                                0,
                                                ',',
                                                '.'
                                            ) }}

                                </p>


                                <p class="text-xs
                                                   text-gray-400
                                                   mt-1">

                                    {{ $i->tanggal_bayar?->format('d M Y, H:i') }}

                                    WIB

                                </p>

                            </div>


                            @if($i->status_validasi === 'diterima')

                            <span class="px-2.5 py-1
                                                   rounded-full
                                                   bg-green-50
                                                   text-green-700
                                                   text-[11px]
                                                   font-semibold">
                                Diterima
                            </span>


                            @elseif($i->status_validasi === 'ditolak')

                            <span class="px-2.5 py-1
                                                   rounded-full
                                                   bg-red-50
                                                   text-red-700
                                                   text-[11px]
                                                   font-semibold">
                                Ditolak
                            </span>


                            @else

                            <span class="px-2.5 py-1
                                                   rounded-full
                                                   bg-yellow-50
                                                   text-yellow-700
                                                   text-[11px]
                                                   font-semibold">
                                Menunggu
                            </span>

                            @endif

                        </div>


                        <div class="mt-4
                                           pt-4
                                           border-t border-gray-100
                                           flex
                                           items-center
                                           justify-between
                                           gap-4">

                            <div>

                                <p class="text-xs
                                                   text-gray-400">

                                    Periode

                                </p>


                                <p class="text-sm
                                                   font-medium
                                                   text-gray-700
                                                   mt-1">

                                    {{ $i->tagihan?->tanggal_mulai?->format('d M Y') }}

                                    -

                                    {{ $i->tagihan?->tanggal_selesai?->format('d M Y') }}

                                </p>

                            </div>


                            @if($i->bukti_bayar)

                            <button type="button" onclick="openImageModal('{{ asset('storage/' . $i->bukti_bayar) }}')"
                                class="shrink-0">

                                <img src="{{ asset('storage/' . $i->bukti_bayar) }}" alt="Bukti Pembayaran" class="w-14 h-14
                                                       rounded-xl
                                                       object-cover
                                                       border border-gray-200">

                            </button>

                            @endif

                        </div>

                    </div>

                </div>

                @endforeach

            </div>

        </div>


        @else


        {{-- =================================================
                EMPTY STATE
            ================================================== --}}

        <div class="bg-white
                       rounded-3xl
                       border border-gray-100
                       shadow-sm
                       p-14
                       text-center">

            <div class="w-20 h-20
                           mx-auto
                           rounded-3xl
                           bg-[#EEF4EF]
                           flex items-center
                           justify-center">

                <svg class="w-9 h-9
                               text-[#6C8B6B]" fill="none" viewBox="0 0 24 24" stroke="currentColor">

                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M3 10h18M5 6h14a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2z" />

                </svg>

            </div>


            <h3 class="text-lg
                           font-bold
                           text-[#0F0937]
                           mt-5">

                Belum Ada Transaksi

            </h3>


            <p class="text-sm
                           text-gray-500
                           mt-2">

                Belum ada pembayaran yang tercatat
                pada akun Anda.

            </p>

        </div>

        @endif

    </div>

</div>



{{-- =========================================================
    MODAL PREVIEW BUKTI PEMBAYARAN
========================================================= --}}

<div id="imageModal" class="fixed inset-0
           z-[9999]
           hidden
           items-center
           justify-center
           bg-black/75
           backdrop-blur-sm
           p-5" onclick="closeImageModal(event)">

    <div class="relative
               max-w-4xl
               max-h-[90vh]" onclick="event.stopPropagation()">

        {{-- GAMBAR --}}
        <img id="modalImage" src="" alt="Bukti Pembayaran" class="max-w-full
                   max-h-[85vh]
                   object-contain
                   rounded-2xl
                   shadow-2xl
                   bg-white">


        {{-- CLOSE --}}
        <button type="button" onclick="closeImageModal()" class="absolute
                   top-3
                   right-3
                   w-10 h-10
                   rounded-full
                   bg-white/95
                   text-gray-700
                   shadow-lg
                   hover:bg-white
                   hover:text-red-500
                   transition
                   flex items-center
                   justify-center">

            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">

                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 6l12 12M18 6L6 18" />

            </svg>

        </button>

    </div>

</div>



{{-- =========================================================
    JAVASCRIPT
========================================================= --}}

<script>
function openImageModal(imageUrl) {

    const modal =
        document.getElementById('imageModal');

    const image =
        document.getElementById('modalImage');


    image.src = imageUrl;


    modal.classList.remove('hidden');

    modal.classList.add('flex');


    document.body.classList.add(
        'overflow-hidden'
    );

}



function closeImageModal(event) {

    if (
        event &&
        event.target &&
        event.target.id !== 'imageModal'
    ) {
        return;
    }


    const modal =
        document.getElementById('imageModal');

    const image =
        document.getElementById('modalImage');


    modal.classList.add('hidden');

    modal.classList.remove('flex');


    image.src = '';


    document.body.classList.remove(
        'overflow-hidden'
    );

}



document.addEventListener(
    'keydown',
    function(event) {

        if (
            event.key === 'Escape'
        ) {

            closeImageModal();

        }

    }
);
</script>

@endsection