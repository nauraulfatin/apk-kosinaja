@extends('layouts.penghuni')
@section('content')
@php

$periode =
    $tagihanAktif->first()?->hargaKamar?->periode;

@endphp

<div class="mb-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-[#0F0937]">
                Pembayaran Saya
            </h1>
            <p class="text-gray-500 mt-2">
                Kelola tagihan dan pembayaran kost anda.
            </p>
        </div>

        {{-- BUTTON BAYAR --}}
        <button
            onclick="openModal()"
            class="bg-[#6C8B6B]
                   hover:bg-[#5B765A]
                   text-white px-5 py-3
                   rounded-2xl
                   font-semibold transition"
        >

            + Bayar Tagihan

        </button>
    </div>

    {{-- MENU --}}
    <div
        class="mt-8 flex items-center
               gap-10 border-b"
    >

        <a
            href="{{ route('penghuni.pembayaran.index') }}"
            class="pb-4 text-lg font-semibold
                   border-b-2 border-[#6C8B6B]
                   text-[#6C8B6B]"
        >
            Tagihan

        </a>

        <a
            href="{{ route('penghuni.riwayat-pembayaran') }}"
            class="pb-4 text-lg font-semibold
                   text-gray-400 hover:text-[#6C8B6B]"
        >

            Riwayat Pembayaran

        </a>
    </div>
</div>

{{-- ========================================================= --}}
{{-- TABLE --}}
{{-- ========================================================= --}}
<div
    class="bg-white rounded-3xl
           shadow-sm border
           border-gray-100 overflow-hidden"
>
   <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-[#F8F5F0]">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                        Periode
                    </th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                        Tagihan
                    </th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                        Jatuh Tempo
                    </th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                        Status
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($tagihanAktif as $i)
                @php

                    /*
                    |--------------------------------------------------------------------------
                    | TOTAL DIBAYAR
                    |--------------------------------------------------------------------------
                    */

                    $totalDibayar =
    $i->pembayaran
        ->where(
            'status_validasi',
            'diterima'
        )
        ->sum(
            'nominal_pembayaran'
        );

                    /*
                    |--------------------------------------------------------------------------
                    | TOTAL TAGIHAN
                    |--------------------------------------------------------------------------
                    */

                    $totalTagihan =
                        $i->hargaKamar?->harga ?? 0;

                    /*
                    |--------------------------------------------------------------------------
                    | SISA
                    |--------------------------------------------------------------------------
                    */

                    $sisa =
                        $totalTagihan - $totalDibayar;

                    /*
                    |--------------------------------------------------------------------------
                    | ADA MENUNGGU
                    |--------------------------------------------------------------------------
                    */

                    $adaMenunggu =
                        $i->status_label === 'menunggu_verifikasi';

                @endphp

                <tr class="hover:bg-gray-50 align-middle">

                    {{-- ========================================================= --}}
                    {{-- PERIODE --}}
                    {{-- ========================================================= --}}
                    <td class="px-6 py-5 min-w-[220px]">
                        <div class="font-semibold text-[#0F0937]">
                            {{ $i->tanggal_mulai->format('d M Y') }}
                        </div>
                        <div class="text-sm text-gray-400 my-1">sampai</div>

                        <div class="font-semibold text-[#0F0937]">

                            {{ $i->tanggal_selesai->format('d M Y') }}

                        </div>

                    </td>

                    {{-- ========================================================= --}}
                    {{-- TAGIHAN --}}
                    {{-- ========================================================= --}}
                    <td class="px-6 py-5 min-w-[260px]">

                        <div class="text-3xl font-bold text-[#0F0937]">

                            Rp
                            {{ number_format($totalTagihan,0,',','.') }}

                        </div>

                        <div class="mt-3 text-sm text-gray-500">

                            Sudah dibayar:
                            Rp
                            {{ number_format($totalDibayar,0,',','.') }}

                        </div>

                        <div class="mt-1 text-sm font-semibold text-red-500">

                            Sisa:
                            Rp
                            {{ number_format($sisa,0,',','.') }}

                        </div>

                    </td>

                    {{-- ========================================================= --}}
                    {{-- JATUH TEMPO --}}
                    {{-- ========================================================= --}}
                    <td class="px-6 py-5 min-w-[180px]">

                        <div class="font-semibold text-[#0F0937]">

                            {{ $i->tanggal_jatuh_tempo?->format('d M Y') ?? '-' }}

                        </div>

                    </td>

                    {{-- ========================================================= --}}
                    {{-- STATUS --}}
                    {{-- ========================================================= --}}
                    <td class="px-6 py-5 min-w-[220px]">

                        @if($i->status_label === 'lunas')

                        <div
                            class="inline-flex px-4 py-2
                                   rounded-full
                                   bg-green-100
                                   text-green-700
                                   text-sm font-semibold"
                        >

                            Lunas

                        </div>

                        @elseif($i->status_label === 'telat')

                        <div
                            class="inline-flex px-4 py-2
                                   rounded-full
                                   bg-red-100
                                   text-red-700
                                   text-sm font-semibold"
                        >

                            Telat

                        </div>

                        @elseif($i->status_label === 'menunggu_verifikasi')

                        <div class="space-y-2">

                            <div
                                class="inline-flex px-4 py-2
                                       rounded-full
                                       bg-yellow-100
                                       text-yellow-700
                                       text-sm font-semibold"
                            >

                                Menunggu Verifikasi

                            </div>

                            <div class="text-xs text-gray-500">

                                Pembayaran sedang dicek admin

                            </div>

                        </div>

                        @elseif($i->status_label === 'ditolak')

                        <div class="space-y-2">

                            <div
                                class="inline-flex px-4 py-2
                                       rounded-full
                                       bg-red-100
                                       text-red-700
                                       text-sm font-semibold"
                            >

                                Pembayaran Ditolak

                            </div>

                            <div class="text-xs text-gray-500">

                                Silahkan upload ulang pembayaran

                            </div>

                        </div>

                        @else

                        <div class="space-y-2">

                            <div
                                class="inline-flex px-4 py-2
                                       rounded-full
                                       bg-gray-100
                                       text-gray-700
                                       text-sm font-semibold"
                            >

                                Belum Lunas

                            </div>

                            @if($totalDibayar > 0)

                            <div
                                class="text-xs text-[#6C8B6B]
                                       font-semibold"
                            >

                                Pembayaran dicicil

                            </div>

                            @endif

                        </div>

                        @endif

                    </td>

                </tr>

                @empty

                <tr>

                    <td
                        colspan="5"
                        class="px-6 py-10 text-center text-gray-500"
                    >

                        Belum ada tagihan.

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

{{-- ========================================================= --}}
{{-- MODAL BAYAR --}}
{{-- ========================================================= --}}
<div
    id="modal-bayar"
    class="fixed inset-0 bg-black/40
           hidden items-center justify-center
           z-50"
>

    <div
        class="bg-white rounded-3xl
               w-full max-w-xl p-8 relative"
    >

        {{-- CLOSE --}}
        <button
            onclick="closeModal()"
            class="absolute top-5 right-5
                   text-gray-400 hover:text-black"
        >

            ✕

        </button>

        <h2
            class="text-2xl font-bold
                   text-[#0F0937]"
        >

            Bayar Tagihan

        </h2>

        <p class="text-gray-500 mt-2">

            Upload pembayaran tagihan kost anda.

        </p>

        <form
            method="POST"
            enctype="multipart/form-data"
            action="{{ route('penghuni.pembayaran.store') }}"
            class="space-y-5 mt-8"
        >

            @csrf

            {{-- PILIH TAGIHAN --}}
            <div>

                <label
                    class="block text-sm
                           font-medium text-gray-700
                           mb-2"
                >

                    Pilih Tagihan

                </label>

                <select
                    name="id_tagihan"
                    required
                    class="w-full border
                           border-gray-300
                           rounded-2xl px-4 py-3"
                >

                    <option value="">

                        -- Pilih Tagihan --

                    </option>

                    @foreach($tagihanAktif as $t)

                    @php

                    $dibayar =
    $t->pembayaran
        ->where(
            'status_validasi',
            'diterima'
        )
        ->sum(
            'nominal_pembayaran'
        );

                    $sisa =
                        ($t->hargaKamar?->harga ?? 0)
                        - $dibayar;

                    @endphp

                    @if(
    in_array(
        $t->status,
        [
            'pending',
            'telat',
            'ditolak',
            'menunggu_verifikasi'
        ]
    )
)

                    <option
                        value="{{ $t->id_tagihan }}"
                    >

                        {{ $t->tanggal_mulai->format('d M Y') }}
                        -
                        {{ $t->tanggal_selesai->format('d M Y') }}

                        | Sisa:
                        Rp {{ number_format($sisa,0,',','.') }}

                    </option>

                    @endif

                    @endforeach

                </select>

            </div>

            {{-- NOMINAL --}}
            <div>

                <label
                    class="block text-sm
                           font-medium text-gray-700
                           mb-2"
                >

                    Nominal Pembayaran

                </label>

                <input
                    type="number"
                    name="nominal_pembayaran"
                    required
                    min="1000"
                    class="w-full border
                           border-gray-300
                           rounded-2xl px-4 py-3"
                    placeholder="Masukkan nominal"
                >

            </div>

            {{-- FILE --}}
            <div>

                <label
                    class="block text-sm
                           font-medium text-gray-700
                           mb-2"
                >

                    Bukti Pembayaran

                </label>

                <input
                    type="file"
                    name="bukti_bayar"
                    required
                    accept="image/*"
                    class="w-full border
                           border-gray-300
                           rounded-2xl px-4 py-3"
                >

            </div>

            {{-- BUTTON --}}
            <div class="flex gap-3 pt-2">

                <button
                    type="button"
                    onclick="closeModal()"
                    class="flex-1 border border-gray-300
                           py-3 rounded-2xl
                           font-semibold"
                >

                    Kembali

                </button>

                <button
                    type="submit"
                    class="flex-1 bg-[#6C8B6B]
                           hover:bg-[#5B765A]
                           text-white py-3
                           rounded-2xl
                           font-semibold transition"
                >

                    Bayar

                </button>

            </div>

        </form>

    </div>

</div>
<script>

function openModal()
{
    document
        .getElementById('modal-bayar')
        .classList
        .remove('hidden');

    document
        .getElementById('modal-bayar')
        .classList
        .add('flex');
}

function closeModal()
{
    document
        .getElementById('modal-bayar')
        .classList
        .remove('flex');

    document
        .getElementById('modal-bayar')
        .classList
        .add('hidden');
}

</script>
@endsection