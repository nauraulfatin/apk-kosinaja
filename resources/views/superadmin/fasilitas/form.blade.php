{{-- ========================================================= --}}
{{-- resources/views/superadmin/fasilitas/form.blade.php --}}
{{-- ========================================================= --}}

@extends('layouts.superadmin')

@section('content')

{{-- ========================================================= --}}
{{-- HEADER --}}
{{-- ========================================================= --}}
<div class="mb-8">

    <h1 class="text-3xl font-bold text-[#0F0937]">

        {{ $item->exists ? 'Edit Fasilitas' : 'Tambah Fasilitas' }}

    </h1>

    <p class="text-gray-500 mt-2">

        {{ $item->exists
            ? 'Perbarui data fasilitas kost.'
            : 'Tambahkan fasilitas baru untuk digunakan admin kost.' }}

    </p>

</div>

{{-- ========================================================= --}}
{{-- FORM --}}
{{-- ========================================================= --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">

    <form
        method="POST"
        action="{{ $item->exists
            ? route('superadmin.fasilitas.update', $item)
            : route('superadmin.fasilitas.store') }}"
        class="space-y-6"
    >

        @csrf

        @if($item->exists)
            @method('PUT')
        @endif

        {{-- NAMA FASILITAS --}}
        <div>

            <label
                class="block text-sm font-medium text-gray-700 mb-2"
            >

                Nama Fasilitas

            </label>

            <input
                type="text"
                name="nama_fasilitas"
                value="{{ old('nama_fasilitas', $item->nama_fasilitas) }}"
                placeholder="Contoh: AC, WiFi, Kamar Mandi Dalam"
                class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-[#6C8B6B] focus:border-[#6C8B6B]"
            >

        </div>

        {{-- BUTTON --}}
        <div class="flex flex-wrap gap-3 pt-4">

            <button
                type="submit"
                class="bg-[#6C8B6B] hover:bg-[#5B765A] text-white px-8 py-3 rounded-xl font-semibold transition"
            >

                {{ $item->exists ? 'Update Fasilitas' : 'Simpan Fasilitas' }}

            </button>

            <a
                href="{{ route('superadmin.fasilitas.index') }}"
                class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-8 py-3 rounded-xl font-semibold transition"
            >

                Kembali

            </a>

        </div>

    </form>

</div>

@endsection