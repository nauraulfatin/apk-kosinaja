@extends('layouts.admin')

@section('content')

<div class="max-w-4xl mx-auto">

    {{-- HEADER --}}
    <div class="mb-8">

        <h1 class="text-3xl font-bold text-[#0F0937]">

            Aktifkan Penghuni

        </h1>

        <p class="text-gray-500 mt-2">

            Pilih kamar dan atur periode tinggal penghuni.

        </p>

    </div>

    {{-- CARD --}}
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">

        {{-- DATA PENGHUNI --}}
        <div class="mb-8">

            <h2 class="text-lg font-bold text-gray-800 mb-4">

                Data Penghuni

            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                <div>

                    <p class="text-sm text-gray-400 mb-1">

                        Nama

                    </p>

                    <p class="font-semibold text-gray-800">

                        {{ $riwayatHunian->user->nama }}

                    </p>

                </div>

                <div>

                    <p class="text-sm text-gray-400 mb-1">

                        Username

                    </p>

                    <p class="font-semibold text-gray-800">

                        {{ $riwayatHunian->user->username }}

                    </p>

                </div>

            </div>

        </div>

        {{-- FORM --}}
        <form
            method="POST"
            action="{{ route('admin.penghuni.aktifkan', $riwayatHunian) }}"
            class="space-y-7"
        >

            @csrf
            @method('PUT')

            {{-- PILIH KAMAR --}}
            <div>

                <label class="block mb-2 font-semibold text-gray-700">

                    Pilih Kamar

                </label>

                <select
                    id="selectKamar"
                    name="id_kamar"
                    required
                    class="w-full border border-gray-300
                           rounded-xl px-4 py-3
                           focus:outline-none
                           focus:ring-2
                           focus:ring-[#6C8B6B]"
                >

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

            {{-- TANGGAL MASUK --}}
            <div>

                <label class="block mb-2 font-semibold text-gray-700">

                    Tanggal Masuk

                </label>

                <input
                    type="date"
                    name="tanggal_masuk"
                    required
                    value="{{ old('tanggal_masuk') }}"
                    class="w-full border border-gray-300
                           rounded-xl px-4 py-3
                           focus:outline-none
                           focus:ring-2
                           focus:ring-[#6C8B6B]"
                >

                @error('tanggal_masuk')

                    <p class="text-red-500 text-sm mt-2">

                        {{ $message }}

                    </p>

                @enderror

            </div>

            {{-- TANGGAL KELUAR --}}
            <div>

                <label class="block mb-2 font-semibold text-gray-700">

                    Tanggal Keluar

                </label>

                <input
                    type="date"
                    name="tanggal_keluar"
                    required
                    value="{{ old('tanggal_keluar') }}"
                    class="w-full border border-gray-300
                           rounded-xl px-4 py-3
                           focus:outline-none
                           focus:ring-2
                           focus:ring-[#6C8B6B]"
                >

                @error('tanggal_keluar')

                    <p class="text-red-500 text-sm mt-2">

                        {{ $message }}

                    </p>

                @enderror

            </div>

            {{-- HARGA KAMAR --}}
            <div>

                <label class="block mb-2 font-semibold text-gray-700">

                    Pilih Harga Kamar

                </label>

                <select
                    id="selectHarga"
                    name="id_harga_kamar"
                    required
                    class="w-full border border-gray-300
                           rounded-xl px-4 py-3
                           focus:outline-none
                           focus:ring-2
                           focus:ring-[#6C8B6B]"
                >

                    <option value="">

                        -- Pilih Harga --

                    </option>

                    @foreach($hargaKamars as $h)

                        <option
                            value="{{ $h->id_harga_kamar }}"
                            data-kamar="{{ $h->id_kamar }}"
                        >


                            Rp {{ number_format($h->harga, 0, ',', '.') }}

                            /

                            {{ $h->periode->periode_penagihan }}

                        </option>

                    @endforeach

                </select>

                @error('id_harga_kamar')

                    <p class="text-red-500 text-sm mt-2">

                        {{ $message }}

                    </p>

                @enderror

            </div>

            <label class="block mb-2 font-semibold text-gray-700">

    Jatuh Tempo Setelah (Hari)

</label>

<input
    type="number"
    name="jatuh_tempo_hari"
    min="1"
    max="31"
    value="{{ old('jatuh_tempo_hari', 5) }}"
    required
    class="w-full border border-gray-300
           rounded-xl px-4 py-3
           focus:outline-none
           focus:ring-2
           focus:ring-[#6C8B6B]"
>

<p class="text-sm text-gray-400 mt-2">

    Contoh:
    5 = tagihan jatuh tempo
    5 hari setelah periode dimulai

</p>

@error('jatuh_tempo_hari')

    <p class="text-red-500 text-sm mt-2">

        {{ $message }}

    </p>

@enderror

            {{-- BUTTON --}}
            <div class="pt-4 flex items-center gap-4">

                <button
                    type="submit"
                    class="bg-[#6C8B6B]
                           hover:bg-[#5B765A]
                           text-white
                           px-8 py-3
                           rounded-xl
                           font-semibold
                           transition"
                >

                    Aktifkan Penghuni

                </button>

                <a
                    href="
@if(request('from') === 'aktif')
    {{ route('admin.penghuni.aktif') }}

@elseif(request('from') === 'antrian')
    {{ route('admin.penghuni.antrian') }}

@else
    {{ route('admin.penghuni.nonaktif') }}
@endif
"
                    class="bg-gray-100
                           hover:bg-gray-200
                           text-gray-700
                           px-8 py-3
                           rounded-xl
                           font-semibold
                           transition"
                >

                    Kembali

                </a>

            </div>

        </form>

    </div>

</div>

{{-- FILTER HARGA BERDASARKAN KAMAR --}}
<script>

document.addEventListener('DOMContentLoaded', function () {

    const selectKamar = document.getElementById('selectKamar');

    const selectHarga = document.getElementById('selectHarga');

    const semuaOptionHarga = [
        ...selectHarga.querySelectorAll('option')
    ];

    selectKamar.addEventListener('change', function () {

        const kamarDipilih = this.value;

        /*
        |--------------------------------------------------------------------------
        | RESET
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

        defaultOption.textContent =
            '-- Pilih Harga --';

        selectHarga.appendChild(defaultOption);

        /*
        |--------------------------------------------------------------------------
        | FILTER HARGA
        |--------------------------------------------------------------------------
        */

        semuaOptionHarga.forEach(option => {

            /*
            |--------------------------------------------------------------------------
            | SKIP DEFAULT
            |--------------------------------------------------------------------------
            */

            if (!option.value) {
                return;
            }

            /*
            |--------------------------------------------------------------------------
            | TAMPILKAN SESUAI KAMAR
            |--------------------------------------------------------------------------
            */

            if (
                option.dataset.kamar === kamarDipilih
            ) {

                selectHarga.appendChild(
                    option.cloneNode(true)
                );

            }

        });

    });

});

</script>

@endsection