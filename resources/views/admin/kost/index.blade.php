@extends('layouts.admin')

@section('content')

<div class="p-6 space-y-6">

    {{-- =========================================================
        HEADER
    ========================================================== --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

        <div class="flex items-center gap-3">

            {{-- ICON --}}
            <div class="w-12 h-12 rounded-2xl bg-[#EAF1EC]
                        flex items-center justify-center shrink-0">

                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-[#6E8B74]" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">

                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M3 10.5L12 3l9 7.5M5 9v10a2 2 0 002 2h10a2 2 0 002-2V9M9 21v-6h6v6" />

                </svg>

            </div>

            <div>

                <h1 class="text-2xl font-bold text-[#0F0937]">
                    Informasi Kost
                </h1>

                <p class="text-sm text-gray-500 mt-1">
                    Informasi lengkap kost yang tampil di katalog.
                </p>

            </div>

        </div>


        {{-- EDIT --}}
        <a href="{{ route('admin.kost.edit') }}" class="inline-flex items-center justify-center gap-2
                   bg-[#6C8B6B]
                   hover:bg-[#5B765A]
                   text-white
                   px-5 py-2.5
                   rounded-xl
                   font-semibold
                   text-sm
                   transition
                   shadow-sm">

            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">

                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h5m4-14l3 3m0 0l-8 8-4 1 1-4 8-8z" />

            </svg>

            Edit Informasi

        </a>

    </div>


    @if(!$kost)

    {{-- =====================================================
            EMPTY STATE
        ====================================================== --}}
    <div class="bg-white rounded-3xl border border-gray-100
                    shadow-sm overflow-hidden">

        <div class="py-20 px-6 text-center">

            <div class="w-16 h-16 mx-auto rounded-2xl
                            bg-[#F3F7F4]
                            flex items-center justify-center">

                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-[#6E8B74]" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">

                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M3 10.5L12 3l9 7.5M5 9v10a2 2 0 002 2h10a2 2 0 002-2V9M9 21v-6h6v6" />

                </svg>

            </div>

            <h2 class="text-lg font-bold text-[#0F0937] mt-5">
                Informasi Kost Belum Tersedia
            </h2>

            <p class="text-sm text-gray-500 mt-2">
                Lengkapi informasi kost terlebih dahulu agar dapat
                ditampilkan di katalog.
            </p>

            <a href="{{ route('admin.kost.edit') }}" class="inline-flex items-center justify-center gap-2
                           mt-6
                           bg-[#6C8B6B]
                           hover:bg-[#5B765A]
                           text-white
                           px-5 py-2.5
                           rounded-xl
                           font-semibold
                           text-sm
                           transition">

                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">

                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />

                </svg>

                Tambah Informasi

            </a>

        </div>

    </div>

    @else

    {{-- =====================================================
            INFORMASI UTAMA
        ====================================================== --}}
    <div class="bg-white rounded-3xl border border-gray-100
                    shadow-sm overflow-hidden">

        {{-- CARD HEADER --}}
        <div class="px-6 py-5 border-b border-gray-100">

            <div class="flex items-center gap-3">

                <div class="w-10 h-10 rounded-xl bg-[#F3F7F4]
                                flex items-center justify-center">

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-[#6E8B74]" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M13 16h-1v-4h-1m1-4h.01M12 21a9 9 0 100-18 9 9 0 000 18z" />

                    </svg>

                </div>

                <div>

                    <h2 class="text-lg font-bold text-[#0F0937]">
                        Informasi Utama
                    </h2>

                    <p class="text-sm text-gray-500 mt-1">
                        Informasi dasar mengenai kost.
                    </p>

                </div>

            </div>

        </div>


        {{-- CONTENT --}}
        <div class="p-6">

            <div class="flex flex-col lg:flex-row gap-7">

                {{-- FOTO UTAMA --}}
                <div class="w-full lg:w-[360px] shrink-0">

                    @if($kost->foto_kost && is_array($kost->foto_kost) && count($kost->foto_kost))

                    <div class="relative group overflow-hidden rounded-2xl">

                        <img src="{{ asset('storage/' . $kost->foto_kost[0]) }}" alt="Foto {{ $kost->nama_kost }}"
                            class="w-full h-[260px] object-cover
                                           rounded-2xl
                                           border border-gray-200
                                           group-hover:scale-105
                                           transition duration-500">

                    </div>

                    @elseif($kost->foto_kost)

                    <div class="relative group overflow-hidden rounded-2xl">

                        <img src="{{ asset('storage/' . $kost->foto_kost) }}" alt="Foto {{ $kost->nama_kost }}" class="w-full h-[260px] object-cover
                                           rounded-2xl
                                           border border-gray-200
                                           group-hover:scale-105
                                           transition duration-500">

                    </div>

                    @else

                    <div class="w-full h-[260px]
                                        bg-[#F5F7F5]
                                        rounded-2xl
                                        border border-dashed border-gray-200
                                        flex flex-col items-center justify-center
                                        text-gray-400">

                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 mb-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />

                        </svg>

                        <span class="text-sm">
                            Belum ada foto
                        </span>

                    </div>

                    @endif

                </div>


                {{-- DETAIL --}}
                <div class="flex-1">

                    <div class="mb-6">

                        <p class="text-xs font-semibold uppercase
                                      tracking-wider text-[#6E8B74] mb-2">
                            Nama Kost
                        </p>

                        <h2 class="text-2xl font-bold text-[#0F0937]">
                            {{ $kost->nama_kost }}
                        </h2>

                    </div>


                    {{-- ALAMAT --}}
                    <div class="mb-5">

                        <div class="flex items-center gap-2 mb-2">

                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-[#6E8B74]" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M12 21s7-5.686 7-12A7 7 0 005 9c0 6.314 7 12 7 12z" />

                                <circle cx="12" cy="9" r="2.5" stroke-width="1.8" />

                            </svg>

                            <p class="text-sm font-semibold text-gray-700">
                                Alamat
                            </p>

                        </div>

                        <div class="bg-[#F8FAF8]
                                        border border-gray-100
                                        rounded-xl
                                        px-4 py-3
                                        text-sm text-gray-700
                                        leading-6">

                            {{ $kost->alamat ?: '-' }}

                        </div>

                    </div>


                    {{-- DESKRIPSI --}}
                    <div class="mb-5">

                        <div class="flex items-center gap-2 mb-2">

                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-[#6E8B74]" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M8 10h8M8 14h5m5 7H6a3 3 0 01-3-3V6a3 3 0 013-3h8l6 6v9a3 3 0 01-3 3z" />

                            </svg>

                            <p class="text-sm font-semibold text-gray-700">
                                Deskripsi
                            </p>

                        </div>

                        <p class="text-sm text-gray-600 leading-6">
                            {{ $kost->deskripsi ?: '-' }}
                        </p>

                    </div>


                    {{-- NOMOR WHATSAPP --}}
                    <div>

                        <div class="flex items-center gap-2 mb-2">

                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-[#6E8B74]" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M21 11.5a8.38 8.38 0 01-9 8.5 8.5 8.5 0 01-4.2-1.1L3 20l1.1-4.6A8.5 8.5 0 1121 11.5z" />

                            </svg>

                            <p class="text-sm font-semibold text-gray-700">
                                Nomor WhatsApp
                            </p>

                        </div>

                        <div class="bg-[#F8FAF8]
                                        border border-gray-100
                                        rounded-xl
                                        px-4 py-3
                                        text-sm text-gray-700">

                            {{ $kost->user->no_hp ?: '-' }}

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- =====================================================
            FASILITAS
        ====================================================== --}}
    <div class="bg-white rounded-3xl border border-gray-100
                    shadow-sm overflow-hidden">

        <div class="px-6 py-5 border-b border-gray-100">

            <div class="flex items-center gap-3">

                <div class="w-10 h-10 rounded-xl bg-[#F3F7F4]
                                flex items-center justify-center">

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-[#6E8B74]" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 12c0 5.591 3.824 10.29 9 11.622C17.176 22.29 21 17.591 21 12c0-1.317-.211-2.585-.602-3.762z" />

                    </svg>

                </div>

                <div>

                    <h2 class="text-lg font-bold text-[#0F0937]">
                        Fasilitas Kost
                    </h2>

                    <p class="text-sm text-gray-500 mt-1">
                        Fasilitas yang tersedia di kost.
                    </p>

                </div>

            </div>

        </div>


        <div class="p-6">

            @if($kost->fasilitas->count())

            <div class="flex flex-wrap gap-3">

                @foreach($kost->fasilitas as $f)

                <span class="inline-flex items-center gap-2
                                         bg-[#F3F7F4]
                                         border border-[#E2EAE3]
                                         text-[#5F7865]
                                         px-4 py-2.5
                                         rounded-xl
                                         text-sm font-semibold">

                    <span class="w-2 h-2 rounded-full bg-[#6C8B6B]"></span>

                    {{ $f->nama_fasilitas }}

                </span>

                @endforeach

            </div>

            @else

            <div class="py-8 text-center">

                <p class="text-sm text-gray-400">
                    Belum ada fasilitas kost.
                </p>

            </div>

            @endif

        </div>

    </div>


    {{-- =====================================================
            GALERI
        ====================================================== --}}
    <div class="bg-white rounded-3xl border border-gray-100
                    shadow-sm overflow-hidden">

        <div class="px-6 py-5 border-b border-gray-100">

            <div class="flex items-center gap-3">

                <div class="w-10 h-10 rounded-xl bg-[#F3F7F4]
                                flex items-center justify-center">

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-[#6E8B74]" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />

                    </svg>

                </div>

                <div>

                    <h2 class="text-lg font-bold text-[#0F0937]">
                        Galeri Kost
                    </h2>

                    <p class="text-sm text-gray-500 mt-1">
                        Foto yang digunakan untuk menampilkan kost.
                    </p>

                </div>

            </div>

        </div>


        <div class="p-6">

            @if($kost->foto_kost && count($kost->foto_kost))

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">

                @foreach($kost->foto_kost as $foto)

                <div class="relative group overflow-hidden rounded-2xl">

                    <img src="{{ asset('storage/' . $foto) }}" alt="Foto Kost" class="w-full h-44 object-cover
                                           rounded-2xl
                                           border border-gray-200
                                           group-hover:scale-105
                                           transition duration-500">

                </div>

                @endforeach

            </div>

            @else

            <div class="py-10 text-center">

                <p class="text-sm text-gray-400">
                    Belum ada galeri foto.
                </p>

            </div>

            @endif

        </div>

    </div>


    {{-- =====================================================
            MAP
        ====================================================== --}}
    @if($kost->lokasi)

    <div class="bg-white rounded-3xl border border-gray-100
                        shadow-sm overflow-hidden">

        <div class="px-6 py-5 border-b border-gray-100">

            <div class="flex items-center gap-3">

                <div class="w-10 h-10 rounded-xl bg-[#F3F7F4]
                                    flex items-center justify-center">

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-[#6E8B74]" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M12 21s7-5.686 7-12A7 7 0 005 9c0 6.314 7 12 7 12z" />

                        <circle cx="12" cy="9" r="2.5" stroke-width="1.8" />

                    </svg>

                </div>

                <div>

                    <h2 class="text-lg font-bold text-[#0F0937]">
                        Lokasi Kost
                    </h2>

                    <p class="text-sm text-gray-500 mt-1">
                        Lokasi kost yang ditampilkan pada katalog.
                    </p>

                </div>

            </div>

        </div>


        <div class="p-6">

            <div class="rounded-2xl overflow-hidden
                                border border-gray-200
                                bg-gray-100">

                <iframe src="{{ $kost->lokasi }}" width="100%" height="450" style="border:0;" allowfullscreen=""
                    loading="lazy">
                </iframe>

            </div>

        </div>

    </div>

    @endif

    @endif

</div>

@endsection