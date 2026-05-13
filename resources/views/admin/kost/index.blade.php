@extends('layouts.admin')

@section('content')

<div class="flex items-center justify-between mb-8">

    <div>

        <h1 class="text-3xl font-bold text-[#0F0937]">
            Informasi Kost
        </h1>

        <p class="text-gray-500 mt-2">
            Informasi lengkap kost yang tampil di katalog.
        </p>

    </div>

    <a
        href="{{ route('admin.kost.edit') }}"
        class="bg-[#6C8B6B] hover:bg-[#5B765A]
               text-white px-5 py-3 rounded-xl
               font-semibold transition"
    >

        Edit Informasi

    </a>

</div>

@if(!$kost)

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-10 text-center">

    <h2 class="text-lg font-semibold text-[#0F0937] mb-2">

        Informasi kost belum tersedia

    </h2>

    <p class="text-gray-500 mb-6">

        Lengkapi informasi kost terlebih dahulu

    </p>

    <a
        href="{{ route('admin.kost.edit') }}"
        class="bg-[#6C8B6B] hover:bg-[#5B765A]
               text-white px-5 py-3 rounded-xl
               font-semibold transition"
    >

        Tambah Informasi

    </a>

</div>

@else

<div class="space-y-6">

    {{-- INFORMASI UTAMA --}}
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">

        <div class="flex flex-col lg:flex-row gap-6">

            {{-- FOTO --}}
            <div class="w-full lg:w-[350px] shrink-0">

              @if($kost->foto_kost && is_array($kost->foto_kost) && count($kost->foto_kost))

<img
    src="{{ asset('storage/' . $kost->foto_kost[0]) }}"
    class="w-full h-[250px] object-cover rounded-2xl border border-gray-200"
>

@elseif($kost->foto_kost)

<img
    src="{{ asset('storage/' . $kost->foto_kost) }}"
    class="w-full h-[250px] object-cover rounded-2xl border border-gray-200"
>

@else

                <div class="w-full h-[250px]
                            bg-gray-100 rounded-2xl
                            flex items-center justify-center
                            text-gray-400 text-sm">

                    Belum ada foto

                </div>

                @endif

            </div>

            {{-- DETAIL --}}
            <div class="flex-1">

                <h2 class="text-2xl font-bold text-[#0F0937]">

                    {{ $kost->nama_kost }}

                </h2>

                <div class="mt-6">

                    <p class="text-sm text-gray-500 mb-2">

                        Alamat

                    </p>

                    <div class="border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-700">

                        {{ $kost->alamat }}

                    </div>

                </div>

                <div class="mt-6">

                    <p class="text-sm text-gray-500 mb-2">

                        Deskripsi

                    </p>

                    <p class="text-gray-700 leading-relaxed">

                        {{ $kost->deskripsi ?: '-' }}

                    </p>

                </div>
                {{-- NO HP --}}
<div class="mt-6">

    <p class="text-sm text-gray-500 mb-2">

        Nomor WhatsApp

    </p>

    <div
        class="border border-gray-200 rounded-xl
               px-4 py-3 text-sm text-gray-700"
    >

        {{ $kost->user->no_hp ?: '-' }}

    </div>

</div>

            </div>

        </div>

    </div>

    {{-- FASILITAS --}}
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">

        <h2 class="text-lg font-bold text-[#0F0937] mb-5">

            Fasilitas Kost

        </h2>

        @if($kost->fasilitas->count())

        <div class="flex flex-wrap gap-3">

            @foreach($kost->fasilitas as $f)

            <span
                class="bg-[#F8F5F0] text-[#6C8B6B]
                       px-4 py-2 rounded-full
                       text-sm font-medium"
            >

                {{ $f->nama_fasilitas }}

            </span>

            @endforeach

        </div>

        @else

        <p class="text-gray-500 text-sm">

            Belum ada fasilitas kost

        </p>

        @endif

    </div>

    {{-- GALERI --}}
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">

        <h2 class="text-lg font-bold text-[#0F0937] mb-5">

            Galeri Kost

        </h2>

        @if($kost->foto_kost && count($kost->foto_kost))

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">

            @foreach($kost->foto_kost as $foto)

            <img
                src="{{ asset('storage/' . $foto) }}"
                class="w-full h-44 object-cover rounded-2xl border border-gray-200"
            >

            @endforeach

        </div>

        @else

        <p class="text-gray-500 text-sm">

            Belum ada galeri foto

        </p>

        @endif

    </div>

    {{-- MAP --}}
    @if($kost->lokasi)

    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">

        <h2 class="text-lg font-bold text-[#0F0937] mb-5">

            Lokasi Kost

        </h2>

        <div class="rounded-2xl overflow-hidden border border-gray-200">

            <iframe
                src="{{ $kost->lokasi }}"
                width="100%"
                height="450"
                style="border:0;"
                allowfullscreen=""
                loading="lazy"
            ></iframe>

        </div>

    </div>

    @endif

</div>

@endif

@endsection