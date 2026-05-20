@extends('layouts.admin')

@section('content')

<div class="mb-8">

    <h1 class="text-3xl font-bold text-[#0F0937]">

        Detail Pengajuan

    </h1>

    <p class="text-gray-500 mt-2">

        Approve penghuni dan tentukan kamar.

    </p>

</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

    {{-- ========================================================= --}}
    {{-- PROFILE --}}
    {{-- ========================================================= --}}
    <div
        class="bg-white rounded-2xl
               border border-gray-100
               shadow-sm p-8"
    >

        <div class="flex flex-col items-center">

            <div
                class="w-28 h-28 rounded-full
                       overflow-hidden"
            >

                <img
                    src="https://ui-avatars.com/api/?name={{ $riwayatHunian->user->nama }}"
                    class="w-full h-full object-cover"
                >

            </div>

            <h2
                class="text-2xl font-bold
                       mt-5 text-center"
            >

                {{ $riwayatHunian->user->nama }}

            </h2>

            <p class="text-gray-400 mt-1">

                {{ $riwayatHunian->user->username }}

            </p>

        </div>

        <div class="mt-8 space-y-5">

            <div>

                <p class="text-sm text-gray-400">

                    NIK

                </p>

                <h4 class="font-semibold">

                    {{ $riwayatHunian->user->nik }}

                </h4>

            </div>

            <div>

                <p class="text-sm text-gray-400">

                    No HP

                </p>

                <h4 class="font-semibold">

                    {{ $riwayatHunian->user->no_hp }}

                </h4>

            </div>

            <div>

                <p class="text-sm text-gray-400">

                    Status

                </p>

                <span
                    class="inline-flex px-4 py-2
                           rounded-xl bg-yellow-100
                           text-yellow-700
                           text-sm font-semibold"
                >

                    Menunggu Approval

                </span>

            </div>

        </div>

    </div>

    {{-- ========================================================= --}}
    {{-- FORM APPROVE --}}
    {{-- ========================================================= --}}
    <div class="lg:col-span-2">

        <div
            class="bg-white rounded-2xl
                   border border-gray-100
                   shadow-sm p-8"
        >

            <form
                method="POST"
                action="{{ route('admin.pengajuan.approve', $riwayatHunian) }}"
                class="space-y-6"
            >

                @csrf
                @method('PUT')

                {{-- ========================================================= --}}
                {{-- PILIH KAMAR --}}
                {{-- ========================================================= --}}
                <div>

                    <label
                        class="block text-sm
                               font-medium text-gray-700
                               mb-2"
                    >

                        Pilih Kamar

                    </label>

                    <select
                        name="id_kamar"
                        id="kamarSelect"
                        required
                        class="w-full border
                               border-gray-300
                               rounded-xl px-4 py-3"
                    >

                        <option value="">

                            -- Pilih Kamar --

                        </option>

                        @foreach($kamars as $k)

                            <option
                                value="{{ $k->id_kamar }}"
                            >

                                {{ $k->nomor_kamar }}
                                -
                                {{ ucfirst($k->status_label) }}

                            </option>

                        @endforeach

                    </select>

                </div>

                {{-- ========================================================= --}}
                {{-- TANGGAL --}}
                {{-- ========================================================= --}}
                <div class="grid grid-cols-2 gap-6">

                    <div>

                        <label
                            class="block text-sm
                                   font-medium text-gray-700
                                   mb-2"
                        >

                            Tanggal Masuk

                        </label>

                        <input
                            type="date"
                            name="tanggal_masuk"
                            required
                            class="w-full border
                                   border-gray-300
                                   rounded-xl px-4 py-3"
                        >

                    </div>

                    <div>

                        <label
                            class="block text-sm
                                   font-medium text-gray-700
                                   mb-2"
                        >

                            Tanggal Keluar

                        </label>

                        <input
                            type="date"
                            name="tanggal_keluar"
                            required
                            class="w-full border
                                   border-gray-300
                                   rounded-xl px-4 py-3"
                        >

                    </div>

                </div>

                {{-- ========================================================= --}}
                {{-- HARGA KAMAR --}}
                {{-- ========================================================= --}}
                <div>

                    <label
                        class="block text-sm
                               font-medium text-gray-700
                               mb-2"
                    >

                        Pilih Harga Kamar

                    </label>

                    <select
                        name="id_harga_kamar"
                        id="hargaSelect"
                        required
                        class="w-full border
                               border-gray-300
                               rounded-xl px-4 py-3"
                    >

                        <option value="">

                            -- Pilih Harga --

                        </option>

                        @foreach($hargaKamars as $h)

                            <option
                                value="{{ $h->id_harga_kamar }}"
                                data-kamar="{{ $h->id_kamar }}"
                                class="harga-option"
                                hidden
                            >

                                Rp {{ number_format($h->harga,0,',','.') }}
                                /
                                {{ $h->periode->periode_penagihan }}

                            </option>

                        @endforeach

                    </select>

                </div>

                {{-- ========================================================= --}}
                {{-- JATUH TEMPO --}}
                {{-- ========================================================= --}}
                <div>

                    <label
                        class="block text-sm
                               font-medium text-gray-700
                               mb-2"
                    >

                        Jatuh Tempo Setelah (Hari)

                    </label>

                    <input
                        type="number"
                        name="jatuh_tempo_hari"
                        min="1"
                        max="31"
                        value="5"
                        required
                        class="w-full border
                               border-gray-300
                               rounded-xl px-4 py-3"
                    >

                    <p class="text-sm text-gray-400 mt-2">

                        Contoh:
                        5 = tagihan jatuh tempo
                        5 hari setelah periode dimulai

                    </p>

                </div>

                {{-- ========================================================= --}}
                {{-- ACTION --}}
                {{-- ========================================================= --}}
                <div class="flex flex-wrap gap-4 pt-4">

                    {{-- APPROVE --}}
                    <button
                        type="submit"
                        name="status"
                        value="aktif"
                        class="bg-[#6C8B6B]
                               hover:bg-[#5B765A]
                               text-white px-8 py-4
                               rounded-xl font-semibold
                               transition"
                    >

                        Approve Penghuni

                    </button>

                    {{-- ANTRIAN --}}
                    <button
                        type="submit"
                        name="status"
                        value="antrian"
                        class="bg-[#E8B44D]
                               hover:bg-[#D89D28]
                               text-white px-8 py-4
                               rounded-xl font-semibold
                               transition"
                    >

                        Masukkan Antrian

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

{{-- ========================================================= --}}
{{-- FILTER HARGA BERDASARKAN KAMAR --}}
{{-- ========================================================= --}}
<script>

    const kamarSelect = document.getElementById(
        'kamarSelect'
    );

    const hargaSelect = document.getElementById(
        'hargaSelect'
    );

    const hargaOptions = document.querySelectorAll(
        '.harga-option'
    );

    kamarSelect.addEventListener(

        'change',

        function ()
        {
            const kamarId = this.value;

            /*
            |--------------------------------------------------------------------------
            | RESET
            |--------------------------------------------------------------------------
            */

            hargaSelect.value = '';

            /*
            |--------------------------------------------------------------------------
            | FILTER HARGA
            |--------------------------------------------------------------------------
            */

            hargaOptions.forEach(option => {

                if (
                    option.dataset.kamar === kamarId
                )
                {
                    option.hidden = false;
                }
                else
                {
                    option.hidden = true;
                }

            });

        }

    );

</script>

@endsection