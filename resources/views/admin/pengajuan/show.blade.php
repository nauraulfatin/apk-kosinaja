@extends('layouts.admin')

@section('content')

<div class="p-6 space-y-6">

    {{-- ========================================================= --}}
    {{-- HEADER --}}
    {{-- ========================================================= --}}
    <div class="flex items-start gap-4">

        <div class="w-12 h-12 rounded-2xl bg-[#EEF4EF]
                    flex items-center justify-center shrink-0">

            <svg class="w-6 h-6 text-[#6C8B6B]" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                    d="M15 19a4 4 0 00-8 0m4-8a4 4 0 100-8 4 4 0 000 8zm5 8v-2a4 4 0 00-3-3.87M17 3.13a4 4 0 010 7.75" />

            </svg>

        </div>

        <div>

            <h1 class="text-2xl sm:text-3xl font-bold text-[#0F0937]">
                Detail Pengajuan
            </h1>

            <p class="text-gray-500 mt-1">
                Approve penghuni dan tentukan kamar.
            </p>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- ERROR SESSION --}}
    {{-- ========================================================= --}}
    @if(session('error'))

    <div class="bg-red-50 border border-red-100
                    text-red-700 px-5 py-4 rounded-2xl">

        {{ session('error') }}

    </div>

    @endif


    {{-- ========================================================= --}}
    {{-- MAIN CONTENT --}}
    {{-- ========================================================= --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- ===================================================== --}}
        {{-- PROFILE PENGHUNI --}}
        {{-- ===================================================== --}}
        <div class="bg-white rounded-3xl
                    border border-gray-100
                    shadow-sm p-7">

            <div class="text-center">

                <div class="w-24 h-24 rounded-full
                            overflow-hidden mx-auto
                            bg-[#EEF4EF]">

                    <img src="https://ui-avatars.com/api/?name={{ urlencode($riwayatHunian->user->nama) }}&background=EEF4EF&color=6C8B6B"
                        alt="{{ $riwayatHunian->user->nama }}" class="w-full h-full object-cover">

                </div>

                <h2 class="text-xl font-bold
                           text-[#0F0937] mt-5">

                    {{ $riwayatHunian->user->nama }}

                </h2>

                <p class="text-sm text-gray-400 mt-1">

                    {{ $riwayatHunian->user->username }}

                </p>

            </div>


            {{-- DATA PENGHUNI --}}
            <div class="mt-8 border-t border-gray-100 pt-6 space-y-5">

                <div>

                    <p class="text-xs text-gray-400 uppercase
                              tracking-wide mb-1">

                        NIK

                    </p>

                    <p class="text-sm font-semibold text-gray-700">

                        {{ $riwayatHunian->user->nik }}

                    </p>

                </div>


                <div>

                    <p class="text-xs text-gray-400 uppercase
                              tracking-wide mb-1">

                        No HP

                    </p>

                    <p class="text-sm font-semibold text-gray-700">

                        {{ $riwayatHunian->user->no_hp }}

                    </p>

                </div>


                <div>

                    <p class="text-xs text-gray-400 uppercase
                              tracking-wide mb-2">

                        Status Pengajuan

                    </p>

                    <span class="inline-flex items-center gap-2
                                 px-3.5 py-2 rounded-full
                                 bg-yellow-50
                                 border border-yellow-100
                                 text-yellow-700
                                 text-xs font-semibold">

                        <span class="w-2 h-2 rounded-full
                                     bg-yellow-500"></span>

                        Menunggu Approval

                    </span>

                </div>

            </div>

        </div>


        {{-- ===================================================== --}}
        {{-- FORM APPROVAL --}}
        {{-- ===================================================== --}}
        <div class="lg:col-span-2">

            <div class="bg-white rounded-3xl
                        border border-gray-100
                        shadow-sm overflow-hidden">

                {{-- CARD HEADER --}}
                <div class="px-7 py-6 border-b border-gray-100">

                    <h2 class="text-lg font-bold text-[#0F0937]">
                        Pengaturan Hunian
                    </h2>

                    <p class="text-sm text-gray-500 mt-1">
                        Tentukan kamar, periode tinggal, dan harga
                        sebelum pengajuan diproses.
                    </p>

                </div>


                <form method="POST" action="{{ route('admin.pengajuan.approve', $riwayatHunian) }}"
                    class="p-7 space-y-6">

                    @csrf
                    @method('PUT')


                    {{-- ================================================= --}}
                    {{-- PILIH KAMAR --}}
                    {{-- ================================================= --}}
                    <div>

                        <label for="kamarSelect" class="block text-sm font-semibold
                                   text-gray-700 mb-2">
                            Pilih Kamar
                        </label>

                        <select name="id_kamar" id="kamarSelect" required class="w-full bg-[#F8FAF8]
                                   border border-gray-200
                                   rounded-2xl px-4 py-3.5
                                   text-sm text-gray-700
                                   outline-none
                                   focus:border-[#6C8B6B]
                                   focus:ring-2
                                   focus:ring-[#6C8B6B]/10
                                   transition">

                            <option value="">
                                -- Pilih Kamar --
                            </option>

                            @foreach($kamars as $k)

                            @php

                            $terisi = \App\Models\RiwayatHunian::where(
                            'id_kamar',
                            $k->id_kamar
                            )
                            ->where(
                            'status',
                            'aktif'
                            )
                            ->exists();

                            @endphp

                            <option value="{{ $k->id_kamar }}">

                                {{ $k->nomor_kamar }}
                                -
                                {{ $terisi ? 'Terisi' : 'Kosong' }}

                            </option>

                            @endforeach

                        </select>

                        @error('id_kamar')

                        <p class="text-sm text-red-500 mt-2">
                            {{ $message }}
                        </p>

                        @enderror

                    </div>


                    {{-- ================================================= --}}
                    {{-- TANGGAL --}}
                    {{-- ================================================= --}}
                    <div>

                        <label class="block text-sm font-semibold
                                      text-gray-700 mb-3">

                            Periode Tinggal

                        </label>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                            <div>

                                <label for="tanggal_masuk" class="block text-xs
                                           text-gray-500 mb-2">
                                    Tanggal Masuk
                                </label>

                                <input type="date" name="tanggal_masuk" id="tanggal_masuk"
                                    value="{{ old('tanggal_masuk') }}" required class="w-full bg-[#F8FAF8]
                                           border border-gray-200
                                           rounded-2xl px-4 py-3.5
                                           text-sm text-gray-700
                                           outline-none
                                           focus:border-[#6C8B6B]
                                           focus:ring-2
                                           focus:ring-[#6C8B6B]/10
                                           transition">

                                @error('tanggal_masuk')

                                <p class="text-sm text-red-500 mt-2">
                                    {{ $message }}
                                </p>

                                @enderror

                            </div>


                            <div>

                                <label for="tanggal_keluar" class="block text-xs
                                           text-gray-500 mb-2">
                                    Tanggal Keluar
                                </label>

                                <input type="date" name="tanggal_keluar" id="tanggal_keluar"
                                    value="{{ old('tanggal_keluar') }}" required class="w-full bg-[#F8FAF8]
                                           border border-gray-200
                                           rounded-2xl px-4 py-3.5
                                           text-sm text-gray-700
                                           outline-none
                                           focus:border-[#6C8B6B]
                                           focus:ring-2
                                           focus:ring-[#6C8B6B]/10
                                           transition">

                                @error('tanggal_keluar')

                                <p class="text-sm text-red-500 mt-2">
                                    {{ $message }}
                                </p>

                                @enderror

                            </div>

                        </div>

                    </div>


                    {{-- ================================================= --}}
                    {{-- HARGA KAMAR --}}
                    {{-- ================================================= --}}
                    <div>

                        <label for="hargaSelect" class="block text-sm font-semibold
                                   text-gray-700 mb-2">
                            Pilih Harga Kamar
                        </label>

                        <select name="id_harga_kamar" id="hargaSelect" required class="w-full bg-[#F8FAF8]
                                   border border-gray-200
                                   rounded-2xl px-4 py-3.5
                                   text-sm text-gray-700
                                   outline-none
                                   focus:border-[#6C8B6B]
                                   focus:ring-2
                                   focus:ring-[#6C8B6B]/10
                                   transition">

                            <option value="">
                                -- Pilih kamar terlebih dahulu --
                            </option>

                            @foreach($hargaKamars as $h)

                            <option value="{{ $h->id_harga_kamar }}" data-kamar="{{ $h->id_kamar }}"
                                class="harga-option" hidden>

                                Rp {{ number_format($h->harga, 0, ',', '.') }}
                                /
                                {{ $h->periode->periode_penagihan }}

                            </option>

                            @endforeach

                        </select>

                        @error('id_harga_kamar')

                        <p class="text-sm text-red-500 mt-2">
                            {{ $message }}
                        </p>

                        @enderror

                    </div>


                    {{-- ================================================= --}}
                    {{-- JATUH TEMPO --}}
                    {{-- ================================================= --}}
                    <div>

                        <label for="jatuh_tempo_hari" class="block text-sm font-semibold
                                   text-gray-700 mb-2">
                            Jatuh Tempo Setelah (Hari)
                        </label>

                        <input type="number" name="jatuh_tempo_hari" id="jatuh_tempo_hari" min="1" max="31"
                            value="{{ old('jatuh_tempo_hari', 5) }}" required class="w-full bg-[#F8FAF8]
                                   border border-gray-200
                                   rounded-2xl px-4 py-3.5
                                   text-sm text-gray-700
                                   outline-none
                                   focus:border-[#6C8B6B]
                                   focus:ring-2
                                   focus:ring-[#6C8B6B]/10
                                   transition">

                        <p class="text-xs text-gray-400 mt-2">

                            Contoh: 5 = tagihan jatuh tempo
                            5 hari setelah periode dimulai.

                        </p>

                        @error('jatuh_tempo_hari')

                        <p class="text-sm text-red-500 mt-2">
                            {{ $message }}
                        </p>

                        @enderror

                    </div>


                    {{-- ================================================= --}}
                    {{-- ACTION --}}
                    {{-- ================================================= --}}
                    <div class="pt-4 border-t border-gray-100">

                        <div class="flex flex-col sm:flex-row
                                    gap-3">

                            {{-- APPROVE --}}
                            <button type="submit" name="status" value="aktif" class="flex-1
                                       bg-[#6C8B6B]
                                       hover:bg-[#5B765A]
                                       text-white
                                       px-6 py-3.5
                                       rounded-2xl
                                       font-semibold
                                       text-sm
                                       transition
                                       shadow-sm
                                       hover:shadow-md">

                                Approve Penghuni

                            </button>


                            {{-- ANTRIAN --}}
                            <button type="submit" name="status" value="antrian" class="flex-1
                                       bg-[#E8B44D]
                                       hover:bg-[#D89D28]
                                       text-white
                                       px-6 py-3.5
                                       rounded-2xl
                                       font-semibold
                                       text-sm
                                       transition
                                       shadow-sm
                                       hover:shadow-md">

                                Masukkan Antrian

                            </button>

                        </div>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>


{{-- ========================================================= --}}
{{-- FILTER HARGA BERDASARKAN KAMAR --}}
{{-- ========================================================= --}}
<script>
const kamarSelect = document.getElementById('kamarSelect');
const hargaSelect = document.getElementById('hargaSelect');
const hargaOptions = document.querySelectorAll('.harga-option');

kamarSelect.addEventListener('change', function() {

    const kamarId = this.value;

    // Reset pilihan harga
    hargaSelect.value = '';

    // Jika belum memilih kamar
    if (!kamarId) {

        hargaOptions.forEach(option => {
            option.hidden = true;
        });

        return;
    }

    // Tampilkan harga sesuai kamar
    hargaOptions.forEach(option => {

        if (option.dataset.kamar === kamarId) {
            option.hidden = false;
        } else {
            option.hidden = true;
        }

    });

});
</script>

@endsection