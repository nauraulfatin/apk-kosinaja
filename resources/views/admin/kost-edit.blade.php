{{-- ========================================================= --}}
{{-- resources/views/admin/kost/edit.blade.php --}}
{{-- ========================================================= --}}

@extends('layouts.admin')

@section('content')

{{-- ========================================================= --}}
{{-- HEADER --}}
{{-- ========================================================= --}}
<div class="mb-8">

    <h1 class="text-3xl font-bold text-[#0F0937]">
        Informasi Kost
    </h1>

    <p class="text-gray-500 mt-2">
        Lengkapi dan perbarui informasi kost Anda.
    </p>

</div>

{{-- ========================================================= --}}
{{-- FORM --}}
{{-- ========================================================= --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">

    <form
        method="POST"
        enctype="multipart/form-data"
        action="{{ route('admin.kost.update') }}"
        class="space-y-8"
    >

        @csrf
        @method('PUT')

        {{-- ========================================================= --}}
        {{-- NAMA KOST --}}
        {{-- ========================================================= --}}
        <div>

            <label class="block text-sm font-medium text-gray-700 mb-2">

                Nama Kost

            </label>

            <input
                type="text"
                name="nama_kost"
                value="{{ old('nama_kost', $kost->nama_kost) }}"
                placeholder="Masukkan nama kost"
                class="w-full border border-gray-300 rounded-xl px-4 py-3"
            >

        </div>

        {{-- ========================================================= --}}
        {{-- ALAMAT --}}
        {{-- ========================================================= --}}
        <div>

            <label class="block text-sm font-medium text-gray-700 mb-2">

                Alamat Kost

            </label>

            <textarea
                name="alamat"
                rows="4"
                placeholder="Masukkan alamat kost"
                class="w-full border border-gray-300 rounded-xl px-4 py-3"
            >{{ old('alamat', $kost->alamat) }}</textarea>

        </div>

        {{-- ========================================================= --}}
        {{-- DESKRIPSI --}}
        {{-- ========================================================= --}}
        <div>

            <label class="block text-sm font-medium text-gray-700 mb-2">

                Deskripsi Kost

            </label>

            <textarea
                name="deskripsi"
                rows="5"
                placeholder="Deskripsi kost..."
                class="w-full border border-gray-300 rounded-xl px-4 py-3"
            >{{ old('deskripsi', $kost->deskripsi) }}</textarea>

        </div>

        {{-- ========================================================= --}}
        {{-- FOTO --}}
        {{-- ========================================================= --}}
        <div>

            <label class="block text-sm font-medium text-gray-700 mb-3">

                Foto Kost

            </label>

            @if($kost->foto_kost)

            <div class="mb-5">

                <img
                    src="{{ asset('storage/' . $kost->foto_kost) }}"
                    alt="Foto Kost"
                    class="w-full max-w-md rounded-2xl border border-gray-200"
                >

            </div>

            @endif

            <input
                type="file"
                name="foto_kost"
                class="w-full border border-gray-300 rounded-xl px-4 py-3 bg-white"
            >

        </div>

        {{-- ========================================================= --}}
        {{-- GOOGLE MAPS --}}
        {{-- ========================================================= --}}
        <div>

            <label class="block text-sm font-medium text-gray-700 mb-3">

                Embed Google Maps

            </label>

            {{-- TUTORIAL --}}
            <div
                class="bg-yellow-50 border border-yellow-200 text-yellow-700 rounded-2xl p-5 mb-5 text-sm"
            >

                <h3 class="font-semibold mb-3">
                    Cara Mengambil Embed Google Maps
                </h3>

                <ol class="list-decimal ml-5 space-y-2">

                    <li>
                        Buka Google Maps
                    </li>

                    <li>
                        Cari lokasi kost Anda
                    </li>

                    <li>
                        Klik tombol <b>Bagikan</b>
                    </li>

                    <li>
                        Pilih menu <b>Sematkan Peta</b>
                    </li>

                    <li>
                        Klik <b>Salin HTML</b>
                    </li>

                    <li>
                        Ambil hanya link pada bagian:
                        <br>

                        <span class="bg-white px-2 py-1 rounded mt-2 inline-block text-xs">

                            src="https://www.google.com/maps/embed?pb=..."

                        </span>

                    </li>

                    <li>
                        Tempel link tersebut di kolom bawah
                    </li>

                </ol>

            </div>

            {{-- INPUT --}}
            <textarea
                name="lokasi"
                rows="5"
                placeholder="https://www.google.com/maps/embed?pb=..."
                class="w-full border border-gray-300 rounded-xl px-4 py-3"
            >{{ old('lokasi', $kost->lokasi) }}</textarea>

        </div>

        {{-- ========================================================= --}}
        {{-- PREVIEW MAP --}}
        {{-- ========================================================= --}}
        @if($kost->lokasi)

        <div>

            <h3 class="text-lg font-semibold text-[#0F0937] mb-4">

                Preview Lokasi Kost

            </h3>

            <div class="rounded-2xl overflow-hidden border border-gray-200">

                <iframe
                    src="{{ $kost->lokasi }}"
                    width="100%"
                    height="450"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                ></iframe>

            </div>

        </div>

        @endif

        {{-- ========================================================= --}}
        {{-- BUTTON --}}
        {{-- ========================================================= --}}
        <div class="flex flex-wrap gap-3 pt-4">

            <button
                type="submit"
                class="bg-[#6C8B6B] hover:bg-[#5B765A] text-white px-8 py-3 rounded-xl font-semibold transition"
            >

                Simpan Informasi

            </button>

            <a
                href="{{ route('admin.dashboard') }}"
                class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-8 py-3 rounded-xl font-semibold transition"
            >

                Kembali

            </a>

        </div>

    </form>

</div>

@endsection