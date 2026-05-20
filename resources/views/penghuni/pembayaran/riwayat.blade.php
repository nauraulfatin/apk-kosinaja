@extends('layouts.penghuni')

@section('content')

<div class="mb-8">

    <h1 class="text-3xl font-bold text-[#0F0937]">

        Riwayat Pembayaran

    </h1>

    <p class="text-gray-500 mt-2">

        Semua transaksi pembayaran kost anda.

    </p>

</div>

<div
    class="mt-8 flex items-center
           gap-10 border-b mb-8"
>

    <a
        href="{{ route('penghuni.pembayaran.index') }}"
        class="pb-4 text-lg font-semibold
               text-gray-400 hover:text-[#6C8B6B]"
    >

        Tagihan

    </a>

    <a
        href="{{ route('penghuni.riwayat-pembayaran') }}"
        class="pb-4 text-lg font-semibold
               border-b-2 border-[#6C8B6B]
               text-[#6C8B6B]"
    >

        Riwayat Pembayaran

    </a>

</div>

<div
    class="bg-white rounded-3xl
           shadow-sm border border-gray-100
           overflow-hidden"
>

    <div class="overflow-x-auto">

        <table class="w-full">

            <thead class="bg-[#F8F5F0]">

                <tr>

                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                        Tanggal
                    </th>

                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                        Periode
                    </th>

                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                        Nominal
                    </th>

                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                        Status
                    </th>

                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                        Bukti
                    </th>

                </tr>

            </thead>

            <tbody class="divide-y divide-gray-100">

                @forelse($items as $i)

                <tr class="hover:bg-gray-50">

                    {{-- TANGGAL --}}
                    <td class="px-6 py-4">

                        {{ $i->tanggal_bayar?->format('d M Y H:i') }}

                    </td>

                    {{-- PERIODE --}}
                    <td class="px-6 py-4">

                        {{ $i->tagihan?->tanggal_mulai?->format('d M Y') }}

                        -

                        {{ $i->tagihan?->tanggal_selesai?->format('d M Y') }}

                    </td>

                    {{-- NOMINAL --}}
                    <td class="px-6 py-4 font-semibold text-[#0F0937]">

                        Rp
                        {{ number_format($i->nominal_pembayaran,0,',','.') }}

                    </td>

                    {{-- STATUS --}}
<td class="px-6 py-4">

    @if($i->status_validasi === 'diterima')

    <span
        class="px-3 py-1 rounded-full
               bg-green-100 text-green-700
               text-xs font-semibold"
    >

        Diterima

    </span>

    @elseif($i->status_validasi === 'ditolak')

    <span
        class="px-3 py-1 rounded-full
               bg-red-100 text-red-700
               text-xs font-semibold"
    >

        Ditolak

    </span>

    @else

    <span
        class="px-3 py-1 rounded-full
               bg-yellow-100 text-yellow-700
               text-xs font-semibold"
    >

        Menunggu

    </span>

    @endif

</td>

                    {{-- FOTO --}}
                    <td class="px-6 py-4">

                        @if($i->bukti_bayar)

                        <a
                            href="{{ asset('storage/' . $i->bukti_bayar) }}"
                            target="_blank"
                        >

                            <img
                                src="{{ asset('storage/' . $i->bukti_bayar) }}"
                                class="w-20 h-20 rounded-2xl
                                       object-cover border"
                            >

                        </a>

                        @endif

                    </td>

                </tr>

                @empty

                <tr>

                    <td
                        colspan="5"
                        class="px-6 py-10 text-center text-gray-500"
                    >

                        Belum ada riwayat pembayaran.

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection