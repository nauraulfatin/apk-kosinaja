@extends('layouts.superadmin')

@section('content')

<div class="mb-8">
    <h1 class="text-3xl font-bold text-[#0F0937]">
        {{ $item->exists ? 'Edit Master Periode' : 'Tambah Master Periode' }}
    </h1>

    <p class="text-gray-500 mt-2">
        {{ $item->exists
            ? 'Perbarui master periode yang digunakan oleh seluruh kos.'
            : 'Tambahkan periode penagihan yang dapat dipilih oleh Admin Kos.' }}
    </p>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 max-w-3xl">
    @if($sedangDigunakan)
        <div class="mb-6 bg-amber-50 border border-amber-200 rounded-2xl p-5">
            <p class="text-sm text-amber-800 leading-relaxed">
                <span class="font-semibold">Periode sedang digunakan.</span>
                Nama periode masih boleh diubah, tetapi jumlah dan satuan interval dikunci agar tidak mengubah pola tagihan kos yang sudah memakai periode ini.
            </p>
        </div>
    @else
        <div class="mb-6 bg-[#F8F5F0] border border-gray-100 rounded-2xl p-5">
            <p class="text-sm text-gray-600 leading-relaxed">
                Master periode berlaku untuk seluruh kos. Contoh: Bulanan = setiap 1 bulan, Semester = setiap 6 bulan.
            </p>
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 rounded-2xl p-5">
            <ul class="list-disc list-inside text-sm text-red-700 space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST"
        action="{{ $item->exists
            ? route('superadmin.periode.update', $item)
            : route('superadmin.periode.store') }}"
        class="space-y-6">

        @csrf

        @if($item->exists)
            @method('PUT')
        @endif

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Nama Periode Penagihan
            </label>

            <input type="text"
                name="periode_penagihan"
                value="{{ old('periode_penagihan', $item->periode_penagihan) }}"
                placeholder="Contoh: Bulanan, Semester"
                required
                class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-[#6C8B6B] focus:border-[#6C8B6B]">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Jumlah Interval
                </label>

                <input type="number"
                    min="1"
                    max="120"
                    name="jumlah_interval"
                    value="{{ old('jumlah_interval', $item->jumlah_interval ?? 1) }}"
                    @disabled($sedangDigunakan)
                    required
                    class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-[#6C8B6B] focus:border-[#6C8B6B] disabled:bg-gray-100 disabled:text-gray-500 disabled:cursor-not-allowed">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Satuan Interval
                </label>

                <select name="satuan_interval"
                    @disabled($sedangDigunakan)
                    required
                    class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-[#6C8B6B] focus:border-[#6C8B6B] disabled:bg-gray-100 disabled:text-gray-500 disabled:cursor-not-allowed">
                    @foreach([
                        'hari' => 'Hari',
                        'minggu' => 'Minggu',
                        'bulan' => 'Bulan',
                        'tahun' => 'Tahun',
                    ] as $value => $label)
                        <option value="{{ $value }}"
                            @selected(old('satuan_interval', $item->satuan_interval ?? 'bulan') === $value)>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="flex flex-wrap gap-3 pt-4">
            <button type="submit"
                class="bg-[#6C8B6B] hover:bg-[#5B765A] text-white px-8 py-3 rounded-xl font-semibold transition">
                {{ $item->exists ? 'Simpan Perubahan' : 'Simpan Periode' }}
            </button>

            <a href="{{ route('superadmin.periode.index') }}"
                class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-8 py-3 rounded-xl font-semibold transition">
                Kembali
            </a>
        </div>
    </form>
</div>

@endsection
