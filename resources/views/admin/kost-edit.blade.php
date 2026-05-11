@extends('layouts.admin')

@section('content')

{{-- HEADER --}}
<div class="mb-8">

    <h1 class="text-3xl font-bold text-[#0F0937]">
        Update Informasi Kost
    </h1>

    <p class="text-gray-500 mt-2">
        Kelola informasi utama kost Anda.
    </p>

</div>

{{-- FORM --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">

    <form
        method="POST"
        enctype="multipart/form-data"
        action="{{ route('admin.kost.update') }}"
        class="space-y-6"
    >

        @csrf
        @method('PUT')

        {{-- NAMA KOST --}}
        <div>

            <label class="block text-sm font-medium text-gray-700 mb-2">
                Nama Kost
            </label>

            <input
                type="text"
                name="nama_kost"
                value="{{ old('nama_kost', $kost->nama_kost) }}"
                class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-[#6C8B6B] focus:border-[#6C8B6B]"
            >

        </div>

        {{-- ALAMAT --}}
        <div>

            <label class="block text-sm font-medium text-gray-700 mb-2">
                Alamat
            </label>

            <textarea
                name="alamat"
                rows="4"
                class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-[#6C8B6B] focus:border-[#6C8B6B]"
            >{{ old('alamat', $kost->alamat) }}</textarea>

        </div>

        {{-- DESKRIPSI --}}
        <div>

            <label class="block text-sm font-medium text-gray-700 mb-2">
                Deskripsi
            </label>

            <textarea
                name="deskripsi"
                rows="5"
                class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-[#6C8B6B] focus:border-[#6C8B6B]"
            >{{ old('deskripsi', $kost->deskripsi) }}</textarea>

        </div>

        {{-- FOTO --}}
        <div>

            <label class="block text-sm font-medium text-gray-700 mb-2">
                Foto Kost
            </label>

            <input
                type="file"
                name="foto_kost"
                class="w-full border border-gray-300 rounded-xl px-4 py-3 bg-white"
            >

        </div>

        {{-- PREVIEW FOTO --}}
        @if($kost->foto_kost)

        <div>

            <p class="text-sm text-gray-500 mb-3">
                Foto Saat Ini
            </p>

            <img
                src="{{ asset('storage/' . $kost->foto_kost) }}"
                class="w-full max-w-md rounded-2xl border border-gray-200 shadow-sm"
            >

        </div>

        @endif

        {{-- BUTTON --}}
        <div class="pt-4">

            <button
                type="submit"
                class="bg-[#6C8B6B] hover:bg-[#5B765A] text-white px-8 py-3 rounded-xl font-semibold transition"
            >
                Simpan Perubahan
            </button>

        </div>

    </form>

</div>

@endsection