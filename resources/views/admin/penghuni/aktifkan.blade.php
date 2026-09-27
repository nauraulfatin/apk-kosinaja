@extends('layouts.admin')

@section('content')

<div class="p-6 space-y-6">

    {{-- ===================================================== --}}
    {{-- HEADER --}}
    {{-- ===================================================== --}}
    <div class="flex items-start gap-4">

        {{-- Icon header saja --}}
        <div class="w-12 h-12 rounded-2xl bg-[#EEF4EF] flex items-center justify-center shrink-0">

            <svg class="w-6 h-6 text-[#6C8B6B]" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                    d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2M9 11a4 4 0 100-8 4 4 0 000 8zm7-3a4 4 0 110-8 4 4 0 000 8zm0 3a4 4 0 014 4v2" />

            </svg>

        </div>

        <div>

            <h1 class="text-2xl sm:text-3xl font-bold text-[#0F0937]">
                Aktifkan Penghuni
            </h1>

            <p class="text-gray-500 mt-1 text-sm sm:text-base">
                Pilih kamar dan atur periode tinggal penghuni.
            </p>

        </div>

    </div>


    {{-- ===================================================== --}}
    {{-- DATA PENGHUNI --}}
    {{-- ===================================================== --}}
    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">

        <div class="px-6 sm:px-8 py-5 border-b border-gray-100">

            <h2 class="text-lg font-bold text-[#0F0937]">
                Data Penghuni
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Informasi penghuni yang akan diaktifkan.
            </p>

        </div>

        <div class="p-6 sm:p-8">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                <div class="bg-[#F8F5F0] rounded-2xl px-5 py-4">

                    <p class="text-xs text-gray-500 mb-1">
                        Nama
                    </p>

                    <p class="font-semibold text-[#0F0937]">
                        {{ $riwayatHunian->user->nama }}
                    </p>

                </div>

                <div class="bg-[#F8F5F0] rounded-2xl px-5 py-4">

                    <p class="text-xs text-gray-500 mb-1">
                        Username
                    </p>

                    <p class="font-semibold text-[#0F0937]">
                        {{ $riwayatHunian->user->username }}
                    </p>

                </div>

            </div>

        </div>

    </div>


    {{-- ===================================================== --}}
    {{-- FORM AKTIFKAN --}}
    {{-- ===================================================== --}}
    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">

        <div class="px-6 sm:px-8 py-5 border-b border-gray-100">

            <h2 class="text-lg font-bold text-[#0F0937]">
                Detail Hunian
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Tentukan kamar, periode tinggal, dan harga yang digunakan.
            </p>

        </div>


        <form method="POST" action="{{ route('admin.penghuni.aktifkan', $riwayatHunian) }}"
            class="p-6 sm:p-8 space-y-7">

            @csrf
            @method('PUT')


            {{-- ================================================= --}}
            {{-- PILIH KAMAR --}}
            {{-- ================================================= --}}
            <div>

                <label for="selectKamar" class="block mb-2 text-sm font-semibold text-gray-700">

                    Pilih Kamar

                </label>

                <select id="selectKamar" name="id_kamar" required class="w-full bg-gray-50 border border-gray-200
                               rounded-2xl px-4 py-3.5
                               text-gray-800
                               focus:outline-none
                               focus:ring-2 focus:ring-[#6C8B6B]/20
                               focus:border-[#6C8B6B]
                               transition">

                    <option value="">
                        -- Pilih Kamar --
                    </option>

                    @foreach($kamars as $k)

                    @php

                    $aktif = $k->riwayatHunian
                    ->where('status', 'aktif')
                    ->first();

                    @endphp

                    <option value="{{ $k->id_kamar }}">

                        {{ $k->nomor_kamar }}

                        -

                        {{ strtoupper($k->status) }}

                        @if($aktif)

                        | Terisi oleh:
                        {{ $aktif->user->nama }}

                        @endif

                    </option>

                    @endforeach

                </select>

                @error('id_kamar')

                <p class="text-red-500 text-sm mt-2">
                    {{ $message }}
                </p>

                @enderror

            </div>


            {{-- ================================================= --}}
            {{-- TANGGAL MASUK & KELUAR --}}
            {{-- ================================================= --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                {{-- TANGGAL MASUK --}}
                <div>

                    <label for="tanggal_masuk" class="block mb-2 text-sm font-semibold text-gray-700">

                        Tanggal Masuk

                    </label>

                    <input type="date" id="tanggal_masuk" name="tanggal_masuk" required
                        value="{{ old('tanggal_masuk') }}" class="w-full bg-gray-50 border border-gray-200
                                  rounded-2xl px-4 py-3.5
                                  text-gray-800
                                  focus:outline-none
                                  focus:ring-2 focus:ring-[#6C8B6B]/20
                                  focus:border-[#6C8B6B]
                                  transition">

                    @error('tanggal_masuk')

                    <p class="text-red-500 text-sm mt-2">
                        {{ $message }}
                    </p>

                    @enderror

                </div>


                {{-- TANGGAL KELUAR --}}
                <div>

                    <label for="tanggal_keluar" class="block mb-2 text-sm font-semibold text-gray-700">

                        Tanggal Keluar

                    </label>

                    <input type="date" id="tanggal_keluar" name="tanggal_keluar" required
                        value="{{ old('tanggal_keluar') }}" class="w-full bg-gray-50 border border-gray-200
                                  rounded-2xl px-4 py-3.5
                                  text-gray-800
                                  focus:outline-none
                                  focus:ring-2 focus:ring-[#6C8B6B]/20
                                  focus:border-[#6C8B6B]
                                  transition">

                    @error('tanggal_keluar')

                    <p class="text-red-500 text-sm mt-2">
                        {{ $message }}
                    </p>

                    @enderror

                </div>

            </div>


            {{-- ================================================= --}}
            {{-- HARGA KAMAR --}}
            {{-- ================================================= --}}
            <div>

                <label for="selectHarga" class="block mb-2 text-sm font-semibold text-gray-700">

                    Pilih Harga Kamar

                </label>

                <select id="selectHarga" name="id_harga_kamar" required class="w-full bg-gray-50 border border-gray-200
                               rounded-2xl px-4 py-3.5
                               text-gray-800
                               focus:outline-none
                               focus:ring-2 focus:ring-[#6C8B6B]/20
                               focus:border-[#6C8B6B]
                               transition">

                    <option value="">
                        -- Pilih Harga --
                    </option>

                    @foreach($hargaKamars as $h)

                    <option value="{{ $h->id_harga_kamar }}" data-kamar="{{ $h->id_kamar }}">

                        Rp {{ number_format($h->harga, 0, ',', '.') }}

                        /

                        {{ $h->periode->periode_penagihan }}

                    </option>

                    @endforeach

                </select>

                <p class="text-xs text-gray-400 mt-2">
                    Harga yang muncul akan menyesuaikan kamar yang dipilih.
                </p>

                @error('id_harga_kamar')

                <p class="text-red-500 text-sm mt-2">
                    {{ $message }}
                </p>

                @enderror

            </div>


            {{-- ================================================= --}}
            {{-- JATUH TEMPO --}}
            {{-- ================================================= --}}
            <div>

                <label for="jatuh_tempo_hari" class="block mb-2 text-sm font-semibold text-gray-700">

                    Jatuh Tempo Setelah (Hari)

                </label>

                <input type="number" id="jatuh_tempo_hari" name="jatuh_tempo_hari" min="1" max="31"
                    value="{{ old('jatuh_tempo_hari', 5) }}" required class="w-full bg-gray-50 border border-gray-200
                              rounded-2xl px-4 py-3.5
                              text-gray-800
                              focus:outline-none
                              focus:ring-2 focus:ring-[#6C8B6B]/20
                              focus:border-[#6C8B6B]
                              transition">

                <p class="text-sm text-gray-400 mt-2">
                    Contoh: 5 = tagihan jatuh tempo 5 hari setelah periode dimulai.
                </p>

                @error('jatuh_tempo_hari')

                <p class="text-red-500 text-sm mt-2">
                    {{ $message }}
                </p>

                @enderror

            </div>


            {{-- ================================================= --}}
            {{-- BUTTON --}}
            {{-- ================================================= --}}
            <div class="pt-5 border-t border-gray-100
                        flex flex-col-reverse sm:flex-row
                        sm:justify-end gap-3">

                <a href="
                    @if(request('from') === 'aktif')
                        {{ route('admin.penghuni.aktif') }}
                    @elseif(request('from') === 'antrian')
                        {{ route('admin.penghuni.antrian') }}
                    @else
                        {{ route('admin.penghuni.nonaktif') }}
                    @endif
                " class="inline-flex items-center justify-center
                          bg-gray-100 hover:bg-gray-200
                          text-gray-700
                          px-6 py-3.5 rounded-xl
                          font-semibold transition">

                    Kembali

                </a>


                <button type="submit" class="inline-flex items-center justify-center gap-2
                               bg-[#6C8B6B] hover:bg-[#5B765A]
                               text-white
                               px-6 py-3.5 rounded-xl
                               font-semibold
                               shadow-sm hover:shadow-md
                               transition">

                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />

                    </svg>

                    Aktifkan Penghuni

                </button>

            </div>

        </form>

    </div>

</div>


{{-- ========================================================= --}}
{{-- FILTER HARGA BERDASARKAN KAMAR --}}
{{-- ========================================================= --}}
<script>
document.addEventListener('DOMContentLoaded', function() {

    const selectKamar = document.getElementById('selectKamar');
    const selectHarga = document.getElementById('selectHarga');

    const semuaOptionHarga = [
        ...selectHarga.querySelectorAll('option')
    ];


    selectKamar.addEventListener('change', function() {

        const kamarDipilih = this.value;


        /*
        |--------------------------------------------------------------------------
        | RESET SELECT HARGA
        |--------------------------------------------------------------------------
        */

        selectHarga.innerHTML = '';


        /*
        |--------------------------------------------------------------------------
        | OPTION DEFAULT
        |--------------------------------------------------------------------------
        */

        const defaultOption = document.createElement('option');

        defaultOption.value = '';
        defaultOption.textContent = '-- Pilih Harga --';

        selectHarga.appendChild(defaultOption);


        /*
        |--------------------------------------------------------------------------
        | FILTER HARGA SESUAI KAMAR
        |--------------------------------------------------------------------------
        */

        semuaOptionHarga.forEach(option => {

            if (!option.value) {
                return;
            }


            if (option.dataset.kamar === kamarDipilih) {

                selectHarga.appendChild(
                    option.cloneNode(true)
                );

            }

        });

    });

});
</script>

@endsection