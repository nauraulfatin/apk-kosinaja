{{-- ========================================================= --}}
{{-- resources/views/superadmin/riwayat/edit.blade.php --}}
{{-- ========================================================= --}}

@extends('layouts.superadmin')

@section('content')

@php
/*
|--------------------------------------------------------------------------
| FOTO KOST
|--------------------------------------------------------------------------
| Menangani foto_kost jika disimpan sebagai JSON array,
| array biasa, atau satu string path.
*/

$fotoKost = $user->kost?->foto_kost ?? [];

if (is_string($fotoKost)) {

$decodedFoto = json_decode($fotoKost, true);

if (json_last_error() === JSON_ERROR_NONE && is_array($decodedFoto)) {
$fotoKost = $decodedFoto;
} else {
$fotoKost = [$fotoKost];
}
}

if (!is_array($fotoKost)) {
$fotoKost = [];
}

$fotoKost = array_values(array_filter($fotoKost));
@endphp


<div class="p-6 bg-[#FCFAF6] min-h-full">

    {{-- =========================================================
        HEADER
    ========================================================== --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-7">

        <div>
            <h1 class="text-3xl font-bold text-[#0F0937]">
                Detail Pengajuan Admin Kost
            </h1>

            <p class="text-sm text-gray-500 mt-2">
                Lihat informasi dan kelola status pengajuan admin kost.
            </p>
        </div>


        <a href="{{ route('superadmin.riwayat.index') }}" class="inline-flex items-center justify-center
                   px-5 py-2.5
                   rounded-xl
                   bg-white
                   border border-gray-200
                   text-gray-600
                   text-sm
                   font-semibold
                   hover:bg-gray-50
                   transition">
            Kembali
        </a>

    </div>


    {{-- =========================================================
        MAIN CONTENT
    ========================================================== --}}
    <div class="grid grid-cols-1 xl:grid-cols-[minmax(0,1fr)_320px] gap-6">


        {{-- =====================================================
            LEFT CONTENT
        ====================================================== --}}
        <div class="space-y-6">


            {{-- =================================================
                INFORMASI ADMIN
            ================================================== --}}
            <div class="bg-white
                       rounded-3xl
                       border border-[#E9E7E1]
                       shadow-sm
                       overflow-hidden">

                {{-- HEADER --}}
                <div class="px-7 py-6
                           border-b border-gray-100
                           bg-[#FBFAF7]">

                    <p class="text-xs font-semibold text-[#8A8D82] uppercase tracking-wide">
                        Informasi Admin
                    </p>


                    <div class="flex items-center gap-4 mt-3">

                        {{-- INITIAL --}}
                        <div class="w-12 h-12
                                   rounded-2xl
                                   bg-[#F3F0E9]
                                   text-[#7A806F]
                                   flex items-center
                                   justify-center
                                   text-lg
                                   font-bold
                                   shrink-0">
                            {{ strtoupper(substr($user->nama ?? '-', 0, 1)) }}
                        </div>


                        <div>

                            <h2 class="text-xl font-bold text-[#0F0937]">
                                {{ $user->nama ?? '-' }}
                            </h2>

                            <p class="text-sm text-gray-400 mt-1">
                                {{ '@' . ($user->username ?? '-') }}
                            </p>

                        </div>

                    </div>

                </div>


                {{-- DATA ADMIN --}}
                <div class="p-7">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-7">

                        {{-- NAMA --}}
                        <div>

                            <p class="text-xs text-gray-400 mb-2">
                                Nama Lengkap
                            </p>

                            <p class="text-sm font-semibold text-[#0F0937]">
                                {{ $user->nama ?? '-' }}
                            </p>

                        </div>


                        {{-- USERNAME --}}
                        <div>

                            <p class="text-xs text-gray-400 mb-2">
                                Username
                            </p>

                            <p class="text-sm font-semibold text-[#0F0937]">
                                {{ $user->username ?? '-' }}
                            </p>

                        </div>


                        {{-- NIK --}}
                        <div>

                            <p class="text-xs text-gray-400 mb-2">
                                NIK
                            </p>

                            <p class="text-sm font-semibold text-[#0F0937]">
                                {{ $user->nik ?? '-' }}
                            </p>

                        </div>


                        {{-- NOMOR HP --}}
                        <div>

                            <p class="text-xs text-gray-400 mb-2">
                                Nomor HP
                            </p>

                            <p class="text-sm font-semibold text-[#0F0937]">
                                {{ $user->no_hp ?? '-' }}
                            </p>

                        </div>

                    </div>

                </div>

            </div>


            {{-- =================================================
                INFORMASI KOST
            ================================================== --}}
            <div class="bg-white
                       rounded-3xl
                       border border-[#E9E7E1]
                       shadow-sm
                       overflow-hidden">

                {{-- HEADER --}}
                <div class="px-7 py-5
                           border-b border-gray-100">

                    <h2 class="text-base font-bold text-[#0F0937]">
                        Informasi Kost
                    </h2>

                    <p class="text-xs text-gray-400 mt-1">
                        Informasi usaha kost yang didaftarkan oleh admin.
                    </p>

                </div>


                <div class="p-7">


                    {{-- =================================================
                        FOTO KOST SLIDER
                    ================================================== --}}
                    @if(count($fotoKost) > 0)

                    <div class="mb-8">

                        {{-- JUDUL FOTO --}}
                        <div class="flex items-center justify-between mb-3">

                            <div>

                                <p class="text-sm font-semibold text-[#0F0937]">
                                    Foto Kost
                                </p>

                                <p class="text-xs text-gray-400 mt-1">
                                    Dokumentasi foto kost yang didaftarkan.
                                </p>

                            </div>


                            @if(count($fotoKost) > 1)

                            <span class="px-3 py-1.5
                                               rounded-full
                                               bg-[#F3F0E9]
                                               text-[#7A806F]
                                               text-xs
                                               font-semibold">
                                {{ count($fotoKost) }} Foto
                            </span>

                            @endif

                        </div>


                        {{-- =================================================
                                SLIDER
                            ================================================== --}}
                        <div id="kostSlider" class="relative
                                       w-full
                                       h-[280px]
                                       md:h-[360px]
                                       overflow-hidden
                                       rounded-2xl
                                       bg-[#F5F4F0]
                                       border border-gray-100
                                       cursor-pointer">

                            {{-- FOTO --}}
                            @foreach($fotoKost as $index => $foto)

                            <div class="kost-slide absolute inset-0
                                               {{ $index === 0 ? 'opacity-100 z-[1]' : 'opacity-0 z-0' }}
                                               transition-opacity duration-500" data-index="{{ $index }}">

                                <img src="{{ asset('storage/' . $foto) }}" alt="Foto Kost {{ $index + 1 }}"
                                    class="w-full h-full object-cover"
                                    onclick="openFotoKost('{{ asset('storage/' . $foto) }}')"
                                    onerror="this.style.display='none';">

                            </div>

                            @endforeach


                            {{-- =================================================
                                    TOMBOL SEBELUMNYA
                                ================================================== --}}
                            @if(count($fotoKost) > 1)

                            <button type="button" onclick="event.stopPropagation(); prevKostImage();" class="absolute
                                               left-3
                                               top-1/2
                                               -translate-y-1/2
                                               z-10
                                               w-10 h-10
                                               rounded-full
                                               bg-white/90
                                               hover:bg-white
                                               shadow-md
                                               flex items-center
                                               justify-center
                                               text-gray-600
                                               transition
                                               hover:scale-105">

                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 19l-7-7 7-7" />
                                </svg>

                            </button>


                            {{-- =================================================
                                        TOMBOL BERIKUTNYA
                                    ================================================== --}}
                            <button type="button" onclick="event.stopPropagation(); nextKostImage();" class="absolute
                                               right-3
                                               top-1/2
                                               -translate-y-1/2
                                               z-10
                                               w-10 h-10
                                               rounded-full
                                               bg-white/90
                                               hover:bg-white
                                               shadow-md
                                               flex items-center
                                               justify-center
                                               text-gray-600
                                               transition
                                               hover:scale-105">

                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>

                            </button>

                            @endif


                            {{-- =================================================
                                    INDIKATOR DOT
                                ================================================== --}}
                            @if(count($fotoKost) > 1)

                            <div id="kostDots" class="absolute
                                               bottom-3
                                               left-1/2
                                               -translate-x-1/2
                                               z-10
                                               flex items-center
                                               gap-1.5
                                               px-2.5 py-1.5
                                               rounded-full
                                               bg-black/25
                                               backdrop-blur-sm">

                                @foreach($fotoKost as $index => $foto)

                                <button type="button" onclick="event.stopPropagation(); showKostImage({{ $index }});"
                                    class="kost-dot
                                                       {{ $index === 0
                                                            ? 'w-5 bg-white'
                                                            : 'w-2 bg-white/60' }}
                                                       h-2
                                                       rounded-full
                                                       transition-all duration-300"
                                    aria-label="Foto {{ $index + 1 }}"></button>

                                @endforeach

                            </div>

                            @endif


                            {{-- NOMOR FOTO --}}
                            @if(count($fotoKost) > 1)

                            <div id="kostCounter" class="absolute
                                               top-3
                                               right-3
                                               z-10
                                               px-3 py-1.5
                                               rounded-full
                                               bg-black/45
                                               backdrop-blur-sm
                                               text-white
                                               text-xs
                                               font-medium">
                                1 / {{ count($fotoKost) }}
                            </div>

                            @endif

                        </div>

                    </div>

                    @else

                    {{-- =================================================
                            EMPTY FOTO
                        ================================================== --}}
                    <div class="mb-8
                                   rounded-2xl
                                   border border-dashed
                                   border-gray-200
                                   bg-[#FBFAF7]
                                   p-8
                                   text-center">

                        <div class="w-12 h-12
                                       mx-auto
                                       rounded-2xl
                                       bg-[#F3F0E9]
                                       flex items-center
                                       justify-center">

                            <svg class="w-6 h-6 text-[#858979]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14
                                           M14 7h.01
                                           M5 20h14a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v14a1 1 0 001 1z" />
                            </svg>

                        </div>

                        <p class="text-sm font-semibold text-[#0F0937] mt-3">
                            Belum Ada Foto Kost
                        </p>

                        <p class="text-xs text-gray-400 mt-1">
                            Admin belum menambahkan foto kost.
                        </p>

                    </div>

                    @endif


                    {{-- =================================================
                        DETAIL KOST
                    ================================================== --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-7">

                        {{-- NAMA KOST --}}
                        <div>

                            <p class="text-xs text-gray-400 mb-2">
                                Nama Kost
                            </p>

                            <p class="text-sm font-semibold text-[#0F0937]">
                                {{ $user->kost?->nama_kost ?? '-' }}
                            </p>

                        </div>


                        {{-- NOMOR KONTAK --}}
                        <div>

                            <p class="text-xs text-gray-400 mb-2">
                                Nomor Kontak Kost
                            </p>

                            <p class="text-sm font-semibold text-[#0F0937]">
                                {{ $user->kost?->no_hp ?? $user->no_hp ?? '-' }}
                            </p>

                        </div>


                        {{-- ALAMAT --}}
                        <div class="md:col-span-2">

                            <p class="text-xs text-gray-400 mb-2">
                                Alamat Kost
                            </p>

                            <p class="text-sm font-medium text-gray-700 leading-6">
                                {{ $user->kost?->alamat ?? '-' }}
                            </p>

                        </div>


                        {{-- DESKRIPSI --}}
                        @if($user->kost?->deskripsi)

                        <div class="md:col-span-2">

                            <p class="text-xs text-gray-400 mb-2">
                                Deskripsi Kost
                            </p>

                            <p class="text-sm text-gray-700 leading-6">
                                {{ $user->kost->deskripsi }}
                            </p>

                        </div>

                        @endif

                    </div>

                </div>

            </div>

        </div>


        {{-- =====================================================
            RIGHT SIDEBAR
        ====================================================== --}}
        <div class="space-y-6">


            {{-- =================================================
                STATUS
            ================================================== --}}
            <div class="bg-white
                       rounded-3xl
                       border border-[#E9E7E1]
                       shadow-sm
                       p-6">

                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">
                    Status Pengajuan
                </p>


                @if($user->status === 'aktif')

                <div class="mt-4
                               rounded-2xl
                               bg-[#F1F4EF]
                               border border-[#E2E8DF]
                               p-5">

                    <div class="flex items-center gap-3">

                        <div class="w-10 h-10
                                       rounded-xl
                                       bg-[#E3E9DF]
                                       flex items-center
                                       justify-center">
                            <span class="w-2.5 h-2.5
                                           rounded-full
                                           bg-[#7A806F]"></span>
                        </div>

                        <div>

                            <p class="text-sm font-bold text-[#596052]">
                                Disetujui
                            </p>

                            <p class="text-xs text-gray-400 mt-1">
                                Pengajuan telah diterima.
                            </p>

                        </div>

                    </div>

                </div>

                @elseif($user->status === 'ditolak')

                <div class="mt-4
                               rounded-2xl
                               bg-[#FFF5F3]
                               border border-[#F2DFDA]
                               p-5">

                    <div class="flex items-center gap-3">

                        <div class="w-10 h-10
                                       rounded-xl
                                       bg-[#FBE8E4]
                                       flex items-center
                                       justify-center">
                            <span class="w-2.5 h-2.5
                                           rounded-full
                                           bg-[#C56B5C]"></span>
                        </div>

                        <div>

                            <p class="text-sm font-bold text-[#A75A4D]">
                                Ditolak
                            </p>

                            <p class="text-xs text-gray-400 mt-1">
                                Pengajuan tidak disetujui.
                            </p>

                        </div>

                    </div>

                </div>

                @else

                <div class="mt-4
                               rounded-2xl
                               bg-[#FAF7EE]
                               border border-[#EEE7D4]
                               p-5">

                    <div class="flex items-center gap-3">

                        <div class="w-10 h-10
                                       rounded-xl
                                       bg-[#F1EBDD]
                                       flex items-center
                                       justify-center">
                            <span class="w-2.5 h-2.5
                                           rounded-full
                                           bg-[#B49A62]"></span>
                        </div>

                        <div>

                            <p class="text-sm font-bold text-[#8A764B]">
                                Menunggu Verifikasi
                            </p>

                            <p class="text-xs text-gray-400 mt-1">
                                Pengajuan belum diproses.
                            </p>

                        </div>

                    </div>

                </div>

                @endif

            </div>


            {{-- =================================================
                TINDAKAN
            ================================================== --}}
            <div class="bg-white
                       rounded-3xl
                       border border-[#E9E7E1]
                       shadow-sm
                       p-6">

                <h2 class="text-base font-bold text-[#0F0937]">
                    Tindakan
                </h2>

                <p class="text-xs text-gray-400 mt-1 leading-5">
                    Pilih tindakan untuk mengubah status akun.
                </p>


                <div class="mt-6 space-y-3">


                    {{-- =================================================
                        SETUJUI
                    ================================================== --}}
                    @if($user->status === 'ditolak')

                    <form method="POST" action="{{ route('superadmin.admin.validasi', $user) }}">

                        @csrf

                        <button type="submit" class="w-full
                                       px-4 py-3
                                       rounded-xl
                                       bg-[#E8EDE5]
                                       hover:bg-[#DDE5D9]
                                       text-[#66705F]
                                       text-sm
                                       font-semibold
                                       transition">
                            Setujui Pengajuan
                        </button>

                    </form>

                    @endif


                    {{-- =================================================
                        TOLAK
                    ================================================== --}}
                    @if($user->status === 'aktif')

                    <form method="POST" action="{{ route('superadmin.admin.tolak', $user) }}">

                        @csrf

                        <button type="submit" class="w-full
                                       px-4 py-3
                                       rounded-xl
                                       bg-[#FFF0EE]
                                       hover:bg-[#FBE3E0]
                                       text-[#A75A4D]
                                       text-sm
                                       font-semibold
                                       transition">
                            Tolak Pengajuan
                        </button>

                    </form>

                    @endif


                    {{-- =================================================
                        HAPUS ADMIN
                    ================================================== --}}
                    <form method="POST" action="{{ route('superadmin.admin.hapus', $user) }}"
                        onsubmit="return confirm('Hapus akun admin kost ini?')">

                        @csrf
                        @method('DELETE')

                        <button type="submit" class="w-full
                                   px-4 py-3
                                   rounded-xl
                                   border border-[#E8D5D2]
                                   bg-white
                                   hover:bg-[#FFF5F3]
                                   text-[#A75A4D]
                                   text-sm
                                   font-semibold
                                   transition">
                            Hapus Admin
                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>


{{-- =========================================================
    MODAL FOTO
========================================================== --}}
<div id="fotoKostModal" class="hidden fixed inset-0 z-50
           bg-black/80
           items-center justify-center
           p-4" onclick="closeFotoKost()">

    <div class="relative
               max-w-6xl
               max-h-[90vh]" onclick="event.stopPropagation()">

        <img id="fotoKostPreview" src="" alt="Preview Foto Kost" class="max-w-full
                   max-h-[85vh]
                   object-contain
                   rounded-2xl
                   shadow-2xl">


        {{-- CLOSE --}}
        <button type="button" onclick="closeFotoKost()" class="absolute
                   -top-3
                   -right-3
                   w-9 h-9
                   rounded-full
                   bg-white
                   text-gray-600
                   flex items-center
                   justify-center
                   shadow-lg
                   hover:bg-gray-100
                   transition">

            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>

        </button>

    </div>

</div>


{{-- =========================================================
    JAVASCRIPT SLIDER
========================================================== --}}
<script>
let currentKostImage = 0;

const kostSlides = document.querySelectorAll('.kost-slide');
const kostDots = document.querySelectorAll('.kost-dot');
const kostCounter = document.getElementById('kostCounter');


function showKostImage(index) {

    if (!kostSlides.length) {
        return;
    }

    if (index >= kostSlides.length) {
        index = 0;
    }

    if (index < 0) {
        index = kostSlides.length - 1;
    }

    currentKostImage = index;


    /* FOTO */
    kostSlides.forEach((slide, i) => {

        if (i === index) {

            slide.classList.remove('opacity-0', 'z-0');
            slide.classList.add('opacity-100', 'z-[1]');

        } else {

            slide.classList.remove('opacity-100', 'z-[1]');
            slide.classList.add('opacity-0', 'z-0');

        }

    });


    /* DOT */
    kostDots.forEach((dot, i) => {

        if (i === index) {

            dot.classList.remove('w-2', 'bg-white/60');
            dot.classList.add('w-5', 'bg-white');

        } else {

            dot.classList.remove('w-5', 'bg-white');
            dot.classList.add('w-2', 'bg-white/60');

        }

    });


    /* COUNTER */
    if (kostCounter) {

        kostCounter.textContent =
            `${index + 1} / ${kostSlides.length}`;

    }

}


function nextKostImage() {

    showKostImage(currentKostImage + 1);

}


function prevKostImage() {

    showKostImage(currentKostImage - 1);

}


/* =========================================================
   TOUCH / SWIPE
========================================================= */

let kostStartX = 0;
let kostEndX = 0;

const kostSlider = document.getElementById('kostSlider');

if (kostSlider) {

    kostSlider.addEventListener('touchstart', function(event) {

        kostStartX = event.changedTouches[0].screenX;

    }, {
        passive: true
    });


    kostSlider.addEventListener('touchend', function(event) {

        kostEndX = event.changedTouches[0].screenX;

        handleKostSwipe();

    }, {
        passive: true
    });

}


function handleKostSwipe() {

    const distance = kostEndX - kostStartX;

    if (Math.abs(distance) < 50) {
        return;
    }

    if (distance < 0) {

        nextKostImage();

    } else {

        prevKostImage();

    }

}


/* =========================================================
   KEYBOARD
========================================================= */

document.addEventListener('keydown', function(event) {

    const modal = document.getElementById('fotoKostModal');

    if (modal && !modal.classList.contains('hidden')) {

        if (event.key === 'Escape') {
            closeFotoKost();
        }

        return;
    }


    if (event.key === 'ArrowRight') {
        nextKostImage();
    }


    if (event.key === 'ArrowLeft') {
        prevKostImage();
    }

});


/* =========================================================
   MODAL FOTO
========================================================= */

function openFotoKost(url) {

    const modal = document.getElementById('fotoKostModal');
    const image = document.getElementById('fotoKostPreview');

    if (!modal || !image) {
        return;
    }

    image.src = url;

    modal.classList.remove('hidden');
    modal.classList.add('flex');

    document.body.classList.add('overflow-hidden');

}


function closeFotoKost() {

    const modal = document.getElementById('fotoKostModal');
    const image = document.getElementById('fotoKostPreview');

    if (!modal || !image) {
        return;
    }

    modal.classList.add('hidden');
    modal.classList.remove('flex');

    image.src = '';

    document.body.classList.remove('overflow-hidden');

}
</script>

@endsection