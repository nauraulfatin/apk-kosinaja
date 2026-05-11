{{-- ========================================================= --}}
{{-- resources/views/admin/kamar/harga/form.blade.php --}}
{{-- ========================================================= --}}

@extends('layouts.admin')

@section('content')

<div class="mb-8">

    <h1 class="text-3xl font-bold text-[#0F0937]">

        {{ $item->exists ? 'Edit Harga Kamar' : 'Tambah Harga Kamar' }}

    </h1>

    <p class="text-gray-500 mt-2">

        {{ $item->exists
            ? 'Perbarui harga kamar dan periode penagihan.'
            : 'Tambahkan harga baru untuk kamar kost.' }}

    </p>

</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">

    <form
        method="POST"
        action="{{ $item->exists
            ? route('admin.kamar.harga.update', [$kamar, $item])
            : route('admin.kamar.harga.store', $kamar) }}"
        class="space-y-6"
    >

        @csrf

        @if($item->exists)
            @method('PUT')
        @endif

        {{-- INFO KAMAR --}}
        <div class="bg-[#F8F5F0] rounded-2xl p-5 border border-gray-100">

            <p class="text-sm text-gray-500 mb-1">
                Kamar
            </p>

            <h2 class="text-xl font-bold text-[#0F0937]">
                {{ $kamar->nama_kamar }}
            </h2>

        </div>

        {{-- HARGA --}}
        <div>

            <label class="block text-sm font-medium text-gray-700 mb-2">
                Harga Kamar
            </label>

            <input
                type="number"
                name="harga"
                value="{{ old('harga', $item->harga) }}"
                placeholder="Contoh: 750000"
                class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-[#6C8B6B] focus:border-[#6C8B6B]"
            >

            <p class="text-xs text-gray-400 mt-2">
                Masukkan nominal tanpa titik atau koma.
            </p>

        </div>

        {{-- PERIODE --}}
        <div>

            <label class="block text-sm font-medium text-gray-700 mb-2">
                Periode Penagihan
            </label>

            <select
                name="id_periode"
                class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-[#6C8B6B] focus:border-[#6C8B6B]"
            >

                @foreach($periodes as $p)

                <option
                    value="{{ $p->id_penagihan }}"
                    @selected(old('id_periode', $item->id_periode) == $p->id_penagihan)
                >

                    {{ $p->periode_penagihan }}
                    (setiap {{ $p->jumlah_interval }} {{ $p->satuan_interval }})

                </option>

                @endforeach

            </select>

        </div>

        {{-- STATUS --}}
        <div>

            <label
                class="flex items-center gap-3 bg-[#F8F5F0] border border-gray-200 rounded-2xl px-5 py-4 cursor-pointer"
            >

                <input
                    type="checkbox"
                    name="isactive"
                    value="1"
                    @checked(old('isactive', $item->isactive ?? true))
                    class="w-5 h-5 text-[#6C8B6B] border-gray-300 rounded focus:ring-[#6C8B6B]"
                >

                <div>

                    <p class="font-semibold text-[#0F0937]">
                        Harga Aktif
                    </p>

                    <p class="text-sm text-gray-500">
                        Harga ini digunakan untuk transaksi dan tagihan.
                    </p>

                </div>

            </label>

        </div>

        {{-- BUTTON --}}
        <div class="flex flex-wrap gap-3 pt-4">

            <button
                type="submit"
                class="bg-[#6C8B6B] hover:bg-[#5B765A] text-white px-8 py-3 rounded-xl font-semibold transition"
            >

                {{ $item->exists ? 'Update Harga' : 'Simpan Harga' }}

            </button>

            <a
                href="{{ route('admin.kamar.harga.index', $kamar) }}"
                class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-8 py-3 rounded-xl font-semibold transition"
            >

                Kembali

            </a>

        </div>

    </form>

</div>

@endsection