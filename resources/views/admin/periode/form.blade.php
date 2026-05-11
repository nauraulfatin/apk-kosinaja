{{-- ========================================================= --}}
{{-- resources/views/admin/periode/form.blade.php --}}
{{-- ========================================================= --}}

@extends('layouts.admin')

@section('content')

<div class="mb-8">

    <h1 class="text-3xl font-bold text-[#0F0937]">

        {{ $item->exists ? 'Edit Periode' : 'Tambah Periode' }}

    </h1>

    <p class="text-gray-500 mt-2">

        {{ $item->exists
            ? 'Perbarui konfigurasi periode penagihan.'
            : 'Tambahkan periode penagihan baru untuk sistem kost.' }}

    </p>

</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">

    <div class="mb-6 bg-[#F8F5F0] border border-gray-100 rounded-2xl p-5">

        <p class="text-sm text-gray-600 leading-relaxed">

            Nama periode adalah label yang tampil di aplikasi.
            Jumlah dan satuan interval dipakai sistem untuk
            menghitung jumlah tagihan otomatis.

        </p>

    </div>

    <form
        method="POST"
        action="{{ $item->exists
            ? route('admin.periode.update', $item)
            : route('admin.periode.store') }}"
        class="space-y-6"
    >

        @csrf

        @if($item->exists)
            @method('PUT')
        @endif

        {{-- NAMA PERIODE --}}
        <div>

            <label class="block text-sm font-medium text-gray-700 mb-2">
                Nama Periode Penagihan
            </label>

            <input
                type="text"
                name="periode_penagihan"
                value="{{ old('periode_penagihan', $item->periode_penagihan) }}"
                placeholder="Contoh: Bulanan, Semester"
                class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-[#6C8B6B] focus:border-[#6C8B6B]"
            >

        </div>

        {{-- INTERVAL --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- JUMLAH --}}
            <div>

                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Jumlah Interval
                </label>

                <input
                    type="number"
                    min="1"
                    name="jumlah_interval"
                    value="{{ old('jumlah_interval', $item->jumlah_interval ?? 1) }}"
                    placeholder="Contoh: 1, 3, 6"
                    class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-[#6C8B6B] focus:border-[#6C8B6B]"
                >

            </div>

            {{-- SATUAN --}}
            <div>

                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Satuan Interval
                </label>

                <select
                    name="satuan_interval"
                    class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-[#6C8B6B] focus:border-[#6C8B6B]"
                >

                    @foreach([
                        'hari' => 'Hari',
                        'minggu' => 'Minggu',
                        'bulan' => 'Bulan',
                        'tahun' => 'Tahun'
                    ] as $value => $label)

                    <option
                        value="{{ $value }}"
                        @selected(old('satuan_interval', $item->satuan_interval ?? 'bulan') === $value)
                    >

                        {{ $label }}

                    </option>

                    @endforeach

                </select>

            </div>

        </div>

        {{-- BUTTON --}}
        <div class="flex flex-wrap gap-3 pt-4">

            <button
                type="submit"
                class="bg-[#6C8B6B] hover:bg-[#5B765A] text-white px-8 py-3 rounded-xl font-semibold transition"
            >

                {{ $item->exists ? 'Update Periode' : 'Simpan Periode' }}

            </button>

            <a
                href="{{ route('admin.periode.index') }}"
                class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-8 py-3 rounded-xl font-semibold transition"
            >

                Kembali

            </a>

        </div>

    </form>

</div>

@endsection