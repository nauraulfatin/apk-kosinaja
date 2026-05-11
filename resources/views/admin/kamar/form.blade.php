{{-- ========================================================= --}}
{{-- resources/views/admin/kamar/form.blade.php --}}
{{-- ========================================================= --}}

@extends('layouts.admin')

@section('content')

<div class="mb-8">

    <h1 class="text-3xl font-bold text-[#0F0937]">

        {{ $item->exists ? 'Edit Kamar' : 'Tambah Kamar' }}

    </h1>

    <p class="text-gray-500 mt-2">

        {{ $item->exists
            ? 'Perbarui informasi kamar kost.'
            : 'Tambahkan kamar baru ke dalam sistem kost.' }}

    </p>

</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">

    <form
        method="POST"
        enctype="multipart/form-data"
        action="{{ $item->exists
            ? route('admin.kamar.update', $item)
            : route('admin.kamar.store') }}"
        class="space-y-6"
    >

        @csrf

        @if($item->exists)
            @method('PUT')
        @endif

        {{-- NAMA KAMAR --}}
        <div>

            <label class="block text-sm font-medium text-gray-700 mb-2">
                Nama Kamar
            </label>

            <input
                type="text"
                name="nama_kamar"
                value="{{ old('nama_kamar', $item->nama_kamar) }}"
                placeholder="Contoh: Kamar Melati"
                class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-[#6C8B6B] focus:border-[#6C8B6B]"
            >

        </div>

        {{-- NOMOR + UKURAN --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- NOMOR --}}
            <div>

                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Nomor Kamar
                </label>

                <input
                    type="text"
                    name="nomor_kamar"
                    value="{{ old('nomor_kamar', $item->nomor_kamar) }}"
                    placeholder="Contoh: A01"
                    class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-[#6C8B6B] focus:border-[#6C8B6B]"
                >

            </div>

            {{-- UKURAN --}}
            <div>

                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Ukuran Kamar
                </label>

                <input
                    type="text"
                    name="ukuran_kamar"
                    value="{{ old('ukuran_kamar', $item->ukuran_kamar) }}"
                    placeholder="Contoh: 3x4"
                    class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-[#6C8B6B] focus:border-[#6C8B6B]"
                >

            </div>

        </div>

        {{-- FOTO --}}
        <div>

            <label class="block text-sm font-medium text-gray-700 mb-2">
                Foto Kamar
            </label>

            <input
                type="file"
                name="foto_kamar"
                class="w-full border border-gray-300 rounded-xl px-4 py-3 bg-white"
            >

            <p class="text-xs text-gray-400 mt-2">
                Format: JPG, PNG, JPEG
            </p>

        </div>

        {{-- PREVIEW FOTO --}}
        @if($item->exists && $item->foto_kamar)

        <div>

            <p class="text-sm text-gray-500 mb-3">
                Foto Saat Ini
            </p>

            <img
                src="{{ asset('storage/' . $item->foto_kamar) }}"
                alt="Foto Kamar"
                class="w-full max-w-md rounded-2xl border border-gray-200 shadow-sm"
            >

        </div>

        @endif

        {{-- STATUS --}}
        <div>

            <label class="block text-sm font-medium text-gray-700 mb-2">
                Status Kamar
            </label>

            <select
                name="status"
                class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-[#6C8B6B] focus:border-[#6C8B6B]"
            >

                <option
                    value="kosong"
                    @selected(old('status', $item->status) === 'kosong')
                >
                    Kosong
                </option>

                <option
                    value="terisi"
                    @selected(old('status', $item->status) === 'terisi')
                >
                    Terisi
                </option>

            </select>

        </div>

        {{-- BUTTON --}}
        <div class="flex flex-wrap gap-3 pt-4">

            <button
                type="submit"
                class="bg-[#6C8B6B] hover:bg-[#5B765A] text-white px-8 py-3 rounded-xl font-semibold transition"
            >

                {{ $item->exists ? 'Update Kamar' : 'Simpan Kamar' }}

            </button>

            <a
                href="{{ route('admin.kamar.index') }}"
                class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-8 py-3 rounded-xl font-semibold transition"
            >

                Kembali

            </a>

        </div>

    </form>

</div>

@endsection