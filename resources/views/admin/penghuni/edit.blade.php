@extends('layouts.admin')

@section('content')

<div class="mb-8">

    <h1 class="text-3xl font-bold text-[#0F0937]">

        Edit Penghuni

    </h1>

    <p class="text-gray-500 mt-2">

        Perbarui data penghuni kost.

    </p>

</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">

    <form
        method="POST"
        action="{{ route('admin.penghuni.update', $item) }}"
        class="space-y-6"
    >

        @csrf
        @method('PUT')

        {{-- NAMA --}}
        <div>

            <label class="block text-sm font-medium text-gray-700 mb-2">

                Nama Penghuni

            </label>

            <input
                type="text"
                name="nama"
                value="{{ old('nama', $item->nama) }}"
                class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-[#6C8B6B] focus:border-[#6C8B6B]"
            >

            @error('nama')

                <p class="text-red-500 text-sm mt-2">
                    {{ $message }}
                </p>

            @enderror

        </div>

        {{-- NO HP --}}
        <div>

            <label class="block text-sm font-medium text-gray-700 mb-2">

                Nomor HP

            </label>

            <input
                type="text"
                name="no_hp"
                value="{{ old('no_hp', $item->no_hp) }}"
                class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-[#6C8B6B] focus:border-[#6C8B6B]"
            >

            @error('no_hp')

                <p class="text-red-500 text-sm mt-2">
                    {{ $message }}
                </p>

            @enderror

        </div>

        {{-- BUTTON --}}
        <div class="flex flex-wrap gap-3 pt-4">

            <button
                type="submit"
                class="bg-[#6C8B6B] hover:bg-[#5B765A] text-white px-8 py-3 rounded-xl font-semibold transition"
            >

                Simpan Perubahan

            </button>

            <a
                href="{{ route('admin.penghuni.index') }}"
                class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-8 py-3 rounded-xl font-semibold transition"
            >

                Kembali

            </a>

        </div>

    </form>

</div>

@endsection