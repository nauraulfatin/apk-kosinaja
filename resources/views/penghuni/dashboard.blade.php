@extends('layouts.penghuni')

@section('content')

<div class="space-y-8">

    {{-- HEADER --}}
    <div>
        <h1 class="text-3xl font-bold text-[#0F0937]">Dashboard Penghuni</h1>
        <p class="text-gray-500 mt-2">
            Informasi kamar, masa kos, dan tagihan anda.
        </p>
    </div>

    {{-- JIKA BELUM AKTIF --}}
    @if(!$hunianAktif)

    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-12">
        <div class="text-center">

            <div class="w-24 h-24 mx-auto rounded-full bg-gray-100 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
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
                <a href="{{ route('penghuni.profil.index') }}"
                    class="bg-[#6C8B6B] hover:bg-[#5B765A] text-white px-6 py-3 rounded-2xl font-semibold transition">
                    Masuk Kost
                </a>
            </div>

        </div>
    </div>

    @else

    {{-- =========================================================
        CARD INFO STATS
    ========================================================== --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

        {{-- NAMA KOST --}}
        <div class="bg-yellow-50 rounded-2xl p-6 shadow-sm border border-yellow-100">
            <p class="text-sm text-yellow-600">Nama Kost</p>

            <h2 class="text-xl font-bold text-yellow-800 mt-2">
                {{ $hunianAktif->kamar?->kost?->nama_kost ?? '-' }}
            </h2>
        </div>

        {{-- NAMA & NOMOR KAMAR --}}
        <div class="bg-[#FFF8F0] rounded-2xl p-6 shadow-sm border border-orange-100">
            <p class="text-sm text-orange-600">Kamar</p>

            <h2 class="text-xl font-bold text-orange-800 mt-2">
                {{ $hunianAktif->kamar?->nama_kamar ?? '-' }}
            </h2>

            <p class="text-sm text-orange-600 mt-1">
                Nomor Kamar:
                <span class="font-bold text-orange-800">
                    {{ $hunianAktif->kamar?->nomor_kamar ?? '-' }}
                </span>
            </p>
        </div>

        {{-- TANGGAL MASUK --}}
        <div class="bg-green-50 rounded-2xl p-6 shadow-sm border border-green-100">
            <p class="text-sm text-green-600">Tanggal Masuk</p>

            <h2 class="text-xl font-bold text-green-800 mt-2">
                {{ $hunianAktif->tanggal_masuk?->format('d M Y') ?? '-' }}
            </h2>
        </div>

        {{-- TANGGAL SELESAI --}}
        <div class="bg-blue-50 rounded-2xl p-6 shadow-sm border border-blue-100">
            <p class="text-sm text-blue-600">Tanggal Selesai</p>

            <h2 class="text-xl font-bold text-blue-800 mt-2">
                {{ $hunianAktif->tanggal_keluar?->format('d M Y') ?? '-' }}
            </h2>
        </div>

    </div>


    {{-- =========================================================
        BARIS BAWAH
    ========================================================== --}}
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">

        {{-- =====================================================
            INFO KAMAR
        ====================================================== --}}
        <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100">

            {{-- HEADER INFO KAMAR --}}
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-xl font-bold text-[#0F0937]">
                        Info Kamar
                    </h2>

                    <p class="text-sm text-gray-500 mt-1">
                        Detail kamar yang anda tempati.
                    </p>
                </div>

                <span class="px-3 py-1.5 rounded-full bg-green-100 text-green-700 text-xs font-semibold">
                    Penghuni Aktif
                </span>
            </div>


            {{-- =================================================
                FOTO KAMAR - SLIDER
            ================================================== --}}
            @php
            $fotos = $hunianAktif->kamar?->foto_kamar ?? [];
            @endphp

            @if(count($fotos))

            <div class="relative mb-6">

                {{-- SLIDER --}}
                <div id="roomSlider"
                    class="relative w-full h-64 md:h-80 rounded-2xl overflow-hidden bg-gray-100 select-none">

                    @foreach($fotos as $idx => $foto)

                    <img src="{{ asset('storage/' . $foto) }}" data-index="{{ $idx }}" draggable="false" class="room-slide absolute inset-0 w-full h-full object-cover transition-opacity duration-300
                        {{ $idx === 0
                            ? 'opacity-100'
                            : 'opacity-0 pointer-events-none' }}">

                    @endforeach


                    {{-- TOMBOL SEBELUMNYA --}}
                    @if(count($fotos) > 1)

                    <button type="button" onclick="prevRoomImage()" class="absolute left-3 top-1/2 -translate-y-1/2
                               w-10 h-10 rounded-full
                               bg-white/85 hover:bg-white
                               shadow-md
                               flex items-center justify-center
                               text-gray-700
                               transition
                               z-20">

                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />

                        </svg>

                    </button>


                    {{-- TOMBOL BERIKUTNYA --}}
                    <button type="button" onclick="nextRoomImage()" class="absolute right-3 top-1/2 -translate-y-1/2
                               w-10 h-10 rounded-full
                               bg-white/85 hover:bg-white
                               shadow-md
                               flex items-center justify-center
                               text-gray-700
                               transition
                               z-20">

                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />

                        </svg>

                    </button>


                    {{-- INDIKATOR --}}
                    <div class="absolute bottom-3 left-1/2 -translate-x-1/2
                                flex items-center gap-2 z-20">

                        @foreach($fotos as $idx => $foto)

                        <button type="button" onclick="showRoomImage({{ $idx }})" class="room-dot h-2 rounded-full transition-all duration-300
                            {{ $idx === 0
                                ? 'bg-white w-5'
                                : 'bg-white/60 w-2' }}">
                        </button>

                        @endforeach

                    </div>

                    @endif

                </div>

            </div>

            @else

            {{-- JIKA TIDAK ADA FOTO --}}
            <div class="w-full h-64 md:h-80 rounded-2xl bg-gray-100
                        flex items-center justify-center mb-6">

                <p class="text-gray-400 text-sm">
                    Belum ada foto kamar
                </p>

            </div>

            @endif


            {{-- =================================================
                DETAIL KAMAR
            ================================================== --}}
            <div class="grid grid-cols-2 gap-4">

                {{-- NAMA KAMAR --}}
                <div>
                    <p class="text-xs text-gray-500">
                        Nama Kamar
                    </p>

                    <p class="text-sm font-semibold text-[#0F0937] mt-1">
                        {{ $hunianAktif->kamar?->nama_kamar ?? '-' }}
                    </p>
                </div>


                {{-- UKURAN KAMAR --}}
                <div>
                    <p class="text-xs text-gray-500">
                        Ukuran Kamar
                    </p>

                    <p class="text-sm font-semibold text-[#0F0937] mt-1">
                        {{ $hunianAktif->kamar?->ukuran_kamar ?? '-' }}
                    </p>
                </div>

            </div>


            {{-- =================================================
                FASILITAS
            ================================================== --}}
            @php
            $fasilitas = $hunianAktif->kamar?->fasilitas ?? collect();
            @endphp

            @if($fasilitas->count())

            <div class="mt-4">

                <p class="text-xs text-gray-500 mb-2">
                    Fasilitas
                </p>

                <div class="flex flex-wrap gap-2">

                    @foreach($fasilitas as $f)

                    <span class="px-3 py-1
                                 bg-[#F8F5F0]
                                 text-[#6C8B6B]
                                 text-xs
                                 font-semibold
                                 rounded-full">

                        {{ $f->nama_fasilitas }}

                    </span>

                    @endforeach

                </div>

            </div>

            @endif

        </div>


        {{-- =====================================================
            TAGIHAN TERBARU
        ====================================================== --}}
        <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100">

            {{-- HEADER --}}
            <div class="flex items-center justify-between mb-6">

                <div>
                    <h2 class="text-xl font-bold text-[#0F0937]">
                        Tagihan Terbaru
                    </h2>

                    <p class="text-sm text-gray-500 mt-1">
                        Informasi tagihan pembayaran anda.
                    </p>
                </div>

                <a href="{{ route('penghuni.pembayaran.index') }}"
                    class="text-sm font-semibold text-[#6C8B6B] hover:underline">

                    Lihat Semua

                </a>

            </div>


            @if($tagihanTerbaru)

            <div class="rounded-2xl border border-gray-100 p-6 flex flex-col gap-5">

                {{-- KAMAR & PERIODE --}}
                <div>

                    <h3 class="text-lg font-bold text-[#0F0937]">
                        Kamar {{ $tagihanTerbaru->kamar?->nomor_kamar ?? '-' }}
                    </h3>

                    <p class="text-sm text-gray-500 mt-1">

                        {{ $tagihanTerbaru->tanggal_mulai?->format('d M Y') ?? '-' }}

                        –

                        {{ $tagihanTerbaru->tanggal_selesai?->format('d M Y') ?? '-' }}

                    </p>

                </div>


                {{-- PERIODE PEMBAYARAN --}}
                <div class="inline-flex items-center gap-3
                            bg-[#F8F5F0]
                            px-4 py-3
                            rounded-2xl
                            w-fit">

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-[#6C8B6B]" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10m-11 9h12a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v11a2 2 0 002 2z" />

                    </svg>

                    <span class="text-sm font-semibold text-[#0F0937]">

                        Pembayaran setiap

                        {{ $tagihanTerbaru->hargaKamar?->periode?->jumlah_interval ?? '-' }}

                        {{ $tagihanTerbaru->hargaKamar?->periode?->satuan_interval ?? '' }}

                    </span>

                </div>


                {{-- JATUH TEMPO --}}
                <div>

                    <span class="px-4 py-2
                                 rounded-2xl
                                 bg-red-100
                                 text-red-700
                                 text-sm
                                 font-semibold">

                        Jatuh tempo:
                        {{ $tagihanTerbaru->tanggal_jatuh_tempo?->format('d M Y') ?? '-' }}

                    </span>

                </div>


                {{-- STATUS --}}
                <div class="flex items-center justify-between
                            pt-4
                            border-t
                            border-gray-100">

                    <span class="text-sm text-gray-500">
                        Status
                    </span>


                    @if($tagihanTerbaru->status_label === 'lunas')

                    <span class="px-4 py-2
                                 rounded-2xl
                                 bg-green-100
                                 text-green-700
                                 font-semibold
                                 text-sm">

                        Lunas

                    </span>

                    @elseif($tagihanTerbaru->status_label === 'telat')

                    <span class="px-4 py-2
                                 rounded-2xl
                                 bg-red-100
                                 text-red-700
                                 font-semibold
                                 text-sm">

                        Telat

                    </span>

                    @elseif($tagihanTerbaru->status_label === 'menunggu_verifikasi')

                    <span class="px-4 py-2
                                 rounded-2xl
                                 bg-yellow-100
                                 text-yellow-700
                                 font-semibold
                                 text-sm">

                        Menunggu Verifikasi

                    </span>

                    @else

                    <span class="px-4 py-2
                                 rounded-2xl
                                 bg-gray-100
                                 text-gray-700
                                 font-semibold
                                 text-sm">

                        Belum Bayar

                    </span>

                    @endif

                </div>

            </div>


            {{-- =================================================
                SUMMARY TAGIHAN
            ================================================== --}}
            <div class="grid grid-cols-2 gap-4 mt-4">

                {{-- TOTAL --}}
                <div class="bg-gray-50 rounded-2xl p-4">

                    <p class="text-xs text-gray-500">
                        Total Tagihan
                    </p>

                    <h3 class="text-xl font-bold text-[#0F0937] mt-1">
                        {{ $jumlahTagihan }}
                    </h3>

                    <p class="text-xs text-gray-400">
                        periode
                    </p>

                </div>


                {{-- BELUM LUNAS --}}
                <div class="bg-red-50 rounded-2xl p-4">

                    <p class="text-xs text-red-500">
                        Belum Lunas
                    </p>

                    <h3 class="text-xl font-bold text-red-700 mt-1">
                        {{ $tagihanPending }}
                    </h3>

                    <p class="text-xs text-red-400">
                        tagihan
                    </p>

                </div>

            </div>

            @else

            {{-- TIDAK ADA TAGIHAN --}}
            <div class="rounded-2xl border border-dashed
                        border-gray-300
                        p-16
                        text-center">

                <h3 class="text-lg font-bold text-[#0F0937]">
                    Belum Ada Tagihan
                </h3>

                <p class="text-gray-500 mt-2 text-sm">
                    Tagihan akan muncul otomatis setelah admin mengaktifkan penghuni.
                </p>

            </div>

            @endif

        </div>

    </div>

    @endif

</div>


{{-- =========================================================
    SCRIPT SLIDER FOTO KAMAR
========================================================= --}}
@if($hunianAktif && count($fotos ?? []))

<script>
let currentRoomImage = 0;

const roomSlider = document.getElementById('roomSlider');

let startX = 0;
let endX = 0;


// ========================================================
// TAMPILKAN FOTO
// ========================================================
function showRoomImage(index) {

    const slides = document.querySelectorAll('.room-slide');
    const dots = document.querySelectorAll('.room-dot');

    if (!slides.length) return;


    // Jika melewati foto pertama
    if (index < 0) {
        index = slides.length - 1;
    }


    // Jika melewati foto terakhir
    if (index >= slides.length) {
        index = 0;
    }


    // GANTI FOTO
    slides.forEach((slide, i) => {

        if (i === index) {

            slide.classList.remove(
                'opacity-0',
                'pointer-events-none'
            );

            slide.classList.add('opacity-100');

        } else {

            slide.classList.remove('opacity-100');

            slide.classList.add(
                'opacity-0',
                'pointer-events-none'
            );

        }

    });


    // GANTI DOT
    dots.forEach((dot, i) => {

        if (i === index) {

            dot.classList.remove(
                'bg-white/60',
                'w-2'
            );

            dot.classList.add(
                'bg-white',
                'w-5'
            );

        } else {

            dot.classList.remove(
                'bg-white',
                'w-5'
            );

            dot.classList.add(
                'bg-white/60',
                'w-2'
            );

        }

    });


    currentRoomImage = index;
}


// ========================================================
// FOTO BERIKUTNYA
// ========================================================
function nextRoomImage() {

    showRoomImage(currentRoomImage + 1);

}


// ========================================================
// FOTO SEBELUMNYA
// ========================================================
function prevRoomImage() {

    showRoomImage(currentRoomImage - 1);

}


// ========================================================
// SWIPE / GESER
// ========================================================

if (roomSlider) {

    // TOUCH DEVICE
    roomSlider.addEventListener('touchstart', function(e) {

        startX = e.touches[0].clientX;

    }, {
        passive: true
    });


    roomSlider.addEventListener('touchend', function(e) {

        endX = e.changedTouches[0].clientX;

        handleSwipe();

    }, {
        passive: true
    });


    // MOUSE / DESKTOP
    roomSlider.addEventListener('mousedown', function(e) {

        startX = e.clientX;

        roomSlider.classList.add('cursor-grabbing');

    });


    roomSlider.addEventListener('mouseup', function(e) {

        endX = e.clientX;

        roomSlider.classList.remove('cursor-grabbing');

        handleSwipe();

    });


    roomSlider.addEventListener('mouseleave', function() {

        roomSlider.classList.remove('cursor-grabbing');

    });

}


// ========================================================
// HANDLE SWIPE
// ========================================================
function handleSwipe() {

    const swipeDistance = endX - startX;

    // Geser ke kiri = foto berikutnya
    if (swipeDistance < -50) {

        nextRoomImage();

    }

    // Geser ke kanan = foto sebelumnya
    else if (swipeDistance > 50) {

        prevRoomImage();

    }

}
</script>

@endif

@endsection