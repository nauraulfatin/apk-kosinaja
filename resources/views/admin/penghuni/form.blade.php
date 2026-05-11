{{-- ========================================================= --}}
{{-- resources/views/admin/penghuni/form.blade.php --}}
{{-- ========================================================= --}}

@extends('layouts.admin')

@section('content')

<div class="mb-8">

    <h1 class="text-3xl font-bold text-[#0F0937]">

        {{ $item->exists ? 'Edit Penghuni' : 'Tambah Penghuni' }}

    </h1>

    <p class="text-gray-500 mt-2">

        {{ $item->exists
            ? 'Perbarui data penghuni kost.'
            : 'Tambahkan penghuni baru ke sistem kost.' }}

    </p>

</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">

    <form
        method="POST"
        action="{{ $item->exists
            ? route('admin.penghuni.update', $item)
            : route('admin.penghuni.store') }}"
        class="space-y-6"
    >

        @csrf

        @if($item->exists)
            @method('PUT')
        @endif

        {{-- USER DATA --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- USERNAME --}}
            <div>

                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Username
                </label>

                <input
                    type="text"
                    name="username"
                    value="{{ old('username', $item->username) }}"
                    class="w-full border border-gray-300 rounded-xl px-4 py-3"
                >

            </div>

            {{-- NIK --}}
            <div>

                <label class="block text-sm font-medium text-gray-700 mb-2">
                    NIK
                </label>

                <input
                    type="text"
                    name="nik"
                    value="{{ old('nik', $item->nik) }}"
                    class="w-full border border-gray-300 rounded-xl px-4 py-3"
                >

            </div>

            {{-- NAMA --}}
            <div>

                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Nama
                </label>

                <input
                    type="text"
                    name="nama"
                    value="{{ old('nama', $item->nama) }}"
                    class="w-full border border-gray-300 rounded-xl px-4 py-3"
                >

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
                    class="w-full border border-gray-300 rounded-xl px-4 py-3"
                >

            </div>

        </div>

        {{-- PASSWORD --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div>

                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Password
                </label>

                <input
                    type="password"
                    name="password"
                    class="w-full border border-gray-300 rounded-xl px-4 py-3"
                >

            </div>

            <div>

                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Konfirmasi Password
                </label>

                <input
                    type="password"
                    name="password_confirmation"
                    class="w-full border border-gray-300 rounded-xl px-4 py-3"
                >

            </div>

        </div>

        {{-- KAMAR --}}
        <div>

            <label class="block text-sm font-medium text-gray-700 mb-2">
                Kamar
            </label>

            <select
                name="id_kamar"
                id="kamar"
                class="w-full border border-gray-300 rounded-xl px-4 py-3"
            >

                <option value="">
                    Pilih kamar
                </option>

                @foreach($kamars as $k)

                <option
                    value="{{ $k->id_kamar }}"
                    @selected(old('id_kamar', $item->id_kamar ?? '') == $k->id_kamar)
                >

                    {{ $k->nama_kamar }}
                    -
                    {{ $k->nomor_kamar }}

                </option>

                @endforeach

            </select>

        </div>

        {{-- HARGA --}}
        <div>

            <label class="block text-sm font-medium text-gray-700 mb-2">
                Harga Kamar
            </label>

            <select
                name="id_harga_kamar"
                id="harga-kamar"
                class="w-full border border-gray-300 rounded-xl px-4 py-3"
            >

                <option value="">
                    Pilih harga kamar
                </option>

                @foreach($kamars as $k)
                    @foreach($k->hargaKamars as $h)

                    <option
                        value="{{ $h->id_harga_kamar }}"
                        data-kamar="{{ $k->id_kamar }}"
                        @selected(old('id_harga_kamar', $item->id_harga_kamar ?? '') == $h->id_harga_kamar)
                    >

                        {{ $k->nama_kamar }}
                        -
                        Rp {{ number_format($h->harga,0,',','.') }}

                    </option>

                    @endforeach
                @endforeach

            </select>

        </div>

        {{-- TANGGAL --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div>

                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Tanggal Mulai
                </label>

                <input
                    type="date"
                    name="tanggal_mulai"
                    value="{{ old('tanggal_mulai', $item->tanggal_mulai ?? '') }}"
                    class="w-full border border-gray-300 rounded-xl px-4 py-3"
                >

            </div>

            <div>

                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Tanggal Selesai
                </label>

                <input
                    type="date"
                    name="tanggal_selesai"
                    value="{{ old('tanggal_selesai', $item->tanggal_selesai ?? '') }}"
                    class="w-full border border-gray-300 rounded-xl px-4 py-3"
                >

            </div>

        </div>

        {{-- BUTTON --}}
        <div class="flex flex-wrap gap-3 pt-4">

            <button
                type="submit"
                class="bg-[#6C8B6B] hover:bg-[#5B765A] text-white px-8 py-3 rounded-xl font-semibold transition"
            >

                {{ $item->exists ? 'Update Penghuni' : 'Simpan Penghuni' }}

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

{{-- FILTER HARGA BERDASARKAN KAMAR --}}
<script>

const kamarSelect = document.getElementById('kamar');
const hargaSelect = document.getElementById('harga-kamar');

function filterHargaByKamar() {

    const selectedKamar = kamarSelect.value;

    [...hargaSelect.options].forEach((option) => {

        if (!option.dataset.kamar) return;

        option.hidden =
            selectedKamar &&
            option.dataset.kamar !== selectedKamar;

    });

}

kamarSelect.addEventListener('change', filterHargaByKamar);

filterHargaByKamar();

</script>

@endsection