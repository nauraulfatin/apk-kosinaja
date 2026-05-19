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

                {{-- KAMAR --}}
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
                                {{ ucfirst($k->status) }}

                            </option>

                        @endforeach

                    </select>

                </div>

                {{-- TANGGAL --}}
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

                {{-- PERIODE --}}
                <div>

                    <label
                        class="block text-sm
                               font-medium text-gray-700
                               mb-2"
                    >

                        Periode Tagihan

                    </label>

                    <select
                        name="id_periode"
                        required
                        class="w-full border
                               border-gray-300
                               rounded-xl px-4 py-3"
                    >

                        <option value="">

                            -- Pilih Periode --

                        </option>

                        @foreach($periodes as $p)

                            <option
                                value="{{ $p->periode_penagihan }}"
                            >

                                {{ $p->periode }}

                            </option>

                        @endforeach

                    </select>

                </div>

                {{-- JATUH TEMPO --}}
                <div>

                    <label
                        class="block text-sm
                               font-medium text-gray-700
                               mb-2"
                    >

                        Tanggal Jatuh Tempo

                    </label>

                    <input
                        type="date"
                        name="jatuh_tempo"
                        required
                        class="w-full border
                               border-gray-300
                               rounded-xl px-4 py-3"
                    >

                </div>

                {{-- BUTTON --}}
                <button
                    type="submit"
                    class="bg-[#6C8B6B]
                           hover:bg-[#5B765A]
                           text-white px-8 py-4
                           rounded-xl font-semibold
                           transition"
                >

                    Approve Penghuni

                </button>

            </form>

        </div>

    </div>

</div>

@endsection