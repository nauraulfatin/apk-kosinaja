{{-- ========================================================= --}}
{{-- resources/views/admin/kamar/harga/form.blade.php --}}
{{-- ========================================================= --}}

@extends('layouts.admin')

@section('content')

<div class="p-6 space-y-6">

    {{-- ===================================================== --}}
    {{-- HEADER --}}
    {{-- ===================================================== --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

        <div class="flex items-start gap-4">

            <div class="w-12 h-12 rounded-2xl bg-[#EEF4EF] flex items-center justify-center shrink-0">
                <svg class="w-6 h-6 text-[#6C8B6B]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M12 8c-2.21 0-4 1.12-4 2.5S9.79 13 12 13s4 1.12 4 2.5S14.21 18 12 18m0-12v2m0 10v2m8-8a8 8 0 11-16 0 8 8 0 0116 0z" />
                </svg>
            </div>

            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-[#0F0937]">
                    {{ $item->exists ? 'Edit Harga Kamar' : 'Tambah Harga Kamar' }}
                </h1>

                <p class="text-gray-500 mt-1 text-sm sm:text-base">
                    {{ $item->exists
                        ? 'Perbarui harga kamar dan periode penagihan.'
                        : 'Tambahkan harga baru untuk kamar kost.' }}
                </p>
            </div>

        </div>

    </div>


    {{-- ===================================================== --}}
    {{-- ERROR VALIDATION --}}
    {{-- ===================================================== --}}
    @if ($errors->any())
    <div class="bg-red-50 border border-red-200 rounded-2xl p-5">

        <div class="flex items-start gap-3">

            <div class="w-9 h-9 rounded-xl bg-red-100 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4m0 4h.01M10.29 3.86l-7.82 13.5A2 2 0 004.2 20h15.6a2 2 0 001.73-2.64l-7.82-13.5a2 2 0 00-3.42 0z" />
                </svg>
            </div>

            <div>
                <p class="font-semibold text-red-800">
                    Data belum dapat disimpan
                </p>

                <ul class="mt-2 text-sm text-red-600 space-y-1">
                    @foreach ($errors->all() as $error)
                    <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>

        </div>

    </div>
    @endif


    {{-- ===================================================== --}}
    {{-- FORM --}}
    {{-- ===================================================== --}}
    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">

        {{-- FORM HEADER --}}
        <div class="px-6 sm:px-8 py-6 border-b border-gray-100">

            <div class="flex items-center gap-3">

                <div class="w-10 h-10 rounded-xl bg-[#EEF4EF] flex items-center justify-center">
                    <svg class="w-5 h-5 text-[#6C8B6B]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M3 10.5L12 4l9 6.5M5 9.5V20h14V9.5M9 20v-6h6v6" />
                    </svg>
                </div>

                <div>
                    <h2 class="font-bold text-[#0F0937]">
                        Informasi Harga
                    </h2>

                    <p class="text-sm text-gray-500">
                        Lengkapi informasi harga kamar di bawah ini.
                    </p>
                </div>

            </div>

        </div>


        <form method="POST" action="{{ $item->exists
                    ? route('admin.kamar.harga.update', [$kamar, $item])
                    : route('admin.kamar.harga.store', $kamar) }}" class="p-6 sm:p-8 space-y-7">

            @csrf

            @if($item->exists)
            @method('PUT')
            @endif


            {{-- ================================================= --}}
            {{-- INFO KAMAR --}}
            {{-- ================================================= --}}
            <div>

                <label class="block text-sm font-semibold text-gray-700 mb-3">
                    Kamar
                </label>

                <div class="flex items-center gap-4 bg-[#F8F5F0] border border-gray-200 rounded-2xl p-5">

                    <div class="w-12 h-12 rounded-xl bg-white flex items-center justify-center shadow-sm shrink-0">

                        <svg class="w-6 h-6 text-[#6C8B6B]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M3 10.5L12 4l9 6.5M5 9.5V20h14V9.5M9 20v-6h6v6" />
                        </svg>

                    </div>

                    <div>

                        <p class="text-xs text-gray-500 mb-1">
                            Nama Kamar
                        </p>

                        <h2 class="text-lg font-bold text-[#0F0937]">
                            {{ $kamar->nama_kamar }}
                        </h2>

                    </div>

                </div>

            </div>


            {{-- ================================================= --}}
            {{-- HARGA --}}
            {{-- ================================================= --}}
            <div>

                <label for="harga" class="block text-sm font-semibold text-gray-700 mb-2">
                    Harga Kamar
                </label>

                <div class="relative">

                    <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                        <span class="text-gray-500 font-medium">
                            Rp
                        </span>
                    </div>

                    <input type="number" id="harga" name="harga" value="{{ old('harga', $item->harga) }}"
                        placeholder="750000" min="0" class="w-full bg-gray-50 border border-gray-200 rounded-2xl pl-12 pr-4 py-3.5
                               text-gray-800 placeholder-gray-400
                               focus:outline-none focus:ring-2 focus:ring-[#6C8B6B]/20
                               focus:border-[#6C8B6B] transition">

                </div>

                <p class="text-xs text-gray-400 mt-2">
                    Masukkan nominal tanpa titik atau koma.
                </p>

            </div>


            {{-- ================================================= --}}
            {{-- PERIODE PENAGIHAN --}}
            {{-- ================================================= --}}
            <div>

                <label for="id_periode" class="block text-sm font-semibold text-gray-700 mb-2">
                    Periode Penagihan
                </label>

                <div class="relative">

                    <select id="id_periode" name="id_periode" class="w-full appearance-none bg-gray-50 border border-gray-200 rounded-2xl
                               px-4 py-3.5 pr-11 text-gray-800
                               focus:outline-none focus:ring-2 focus:ring-[#6C8B6B]/20
                               focus:border-[#6C8B6B] transition">

                        @foreach($periodes as $p)

                        <option value="{{ $p->id_penagihan }}" @selected(old('id_periode', $item->id_periode) ==
                            $p->id_penagihan)
                            >
                            {{ $p->periode_penagihan }}
                            (setiap {{ $p->jumlah_interval }} {{ $p->satuan_interval }})
                        </option>

                        @endforeach

                    </select>

                    <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">

                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>

                    </div>

                </div>

                <p class="text-xs text-gray-400 mt-2">
                    Pilih periode yang digunakan untuk penagihan kamar.
                </p>

            </div>


            {{-- ================================================= --}}
            {{-- STATUS --}}
            {{-- ================================================= --}}
            <div>

                <label class="block text-sm font-semibold text-gray-700 mb-3">
                    Status Harga
                </label>

                <label class="flex items-center gap-4 bg-[#F8F5F0] border border-gray-200
                           rounded-2xl px-5 py-4 cursor-pointer
                           hover:border-[#B7C9B8] transition">

                    <input type="checkbox" name="isactive" value="1" @checked(old('isactive', $item->isactive ?? true))
                    class="w-5 h-5 rounded border-gray-300
                    text-[#6C8B6B]
                    focus:ring-[#6C8B6B]">

                    <div class="flex-1">

                        <div class="flex items-center gap-2">

                            <p class="font-semibold text-[#0F0937]">
                                Harga Aktif
                            </p>

                            <span
                                class="px-2.5 py-1 rounded-full bg-[#E2EAE3] text-[#52705A] text-[11px] font-semibold">
                                Aktif
                            </span>

                        </div>

                        <p class="text-sm text-gray-500 mt-1">
                            Harga ini digunakan untuk transaksi dan tagihan.
                        </p>

                    </div>

                </label>

            </div>


            {{-- ================================================= --}}
            {{-- BUTTON --}}
            {{-- ================================================= --}}
            <div class="flex flex-col-reverse sm:flex-row sm:justify-end gap-3 pt-5 border-t border-gray-100">

                <a href="{{ route('admin.kamar.harga.index', $kamar) }}" class="inline-flex items-center justify-center gap-2
                           bg-gray-100 hover:bg-gray-200
                           text-gray-700 px-6 py-3.5 rounded-xl
                           font-semibold transition">

                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>

                    Kembali

                </a>


                <button type="submit" class="inline-flex items-center justify-center gap-2
                           bg-[#6C8B6B] hover:bg-[#5B765A]
                           text-white px-6 py-3.5 rounded-xl
                           font-semibold shadow-sm hover:shadow-md
                           transition">

                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>

                    {{ $item->exists ? 'Update Harga' : 'Simpan Harga' }}

                </button>

            </div>

        </form>

    </div>

</div>

@endsection