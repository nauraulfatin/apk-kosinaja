{{-- ========================================================= --}}
{{-- resources/views/penghuni/tagihan/index.blade.php --}}
{{-- ========================================================= --}}

@extends('layouts.penghuni')

@section('content')

<div class="mb-8">

    <h1 class="text-3xl font-bold text-[#0F0937]">
        Tagihan Saya
    </h1>

    <p class="text-gray-500 mt-2">
        Lihat tagihan kost dan upload bukti pembayaran.
    </p>

</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

    <div class="overflow-x-auto">

        <table class="w-full">

            <thead class="bg-[#F8F5F0]">

                <tr>

                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                        Kamar
                    </th>

                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                        Periode
                    </th>

                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                        Harga
                    </th>

                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                        Jatuh Tempo
                    </th>

                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                        Status
                    </th>

                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                        Pembayaran
                    </th>

                </tr>

            </thead>

            <tbody class="divide-y divide-gray-100">

                @forelse($items as $i)

                <tr class="hover:bg-gray-50 align-top">

                    {{-- KAMAR --}}
                    <td class="px-6 py-5">

                        <div class="font-semibold text-[#0F0937]">

                            {{ $i->kamar?->nama_kamar }}

                        </div>

                    </td>

                    {{-- PERIODE --}}
                    <td class="px-6 py-5">

                        <div class="text-sm text-gray-700">

                            {{ $i->tanggal_mulai->format('d/m/Y') }}

                        </div>

                        <div class="text-sm text-gray-500">

                            sampai

                        </div>

                        <div class="text-sm text-gray-700">

                            {{ $i->tanggal_selesai->format('d/m/Y') }}

                        </div>

                    </td>

                    {{-- HARGA --}}
                    <td class="px-6 py-5">

                        <div class="font-bold text-[#0F0937]">

                            Rp {{ number_format($i->hargaKamar?->harga,0,',','.') }}

                        </div>

                    </td>

                    {{-- JATUH TEMPO --}}
                    <td class="px-6 py-5">

                        <div class="text-sm text-gray-700">

                            {{ $i->tanggal_jatuh_tempo->format('d/m/Y') }}

                        </div>

                    </td>

                    {{-- STATUS --}}
                    <td class="px-6 py-5">

                        <div class="flex flex-col gap-2">

                            {{-- BELUM BAYAR --}}
                            @if(
                                $i->status === 'pending' &&
                                $i->status_bukti === 'belum_upload'
                            )

                            <span class="px-3 py-1 rounded-full bg-gray-100 text-gray-700 text-xs font-semibold w-fit">

                                Belum Bayar

                            </span>

                            {{-- MENUNGGU --}}
                            @elseif(
                                $i->status === 'pending' &&
                                $i->status_bukti === 'menunggu'
                            )

                            <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-semibold w-fit">

                                Menunggu Verifikasi

                            </span>

                            {{-- DITOLAK --}}
                            @elseif(
                                $i->status === 'pending' &&
                                $i->status_bukti === 'ditolak'
                            )

                            <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-semibold w-fit">

                                Ditolak

                            </span>

                            {{-- LUNAS --}}
                            @elseif(
                                $i->status === 'lunas'
                            )

                            <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold w-fit">

                                Lunas

                            </span>

                            {{-- TELAT --}}
                            @elseif(
                                $i->status === 'telat'
                            )

                            <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-semibold w-fit">

                                Telat

                            </span>

                            @endif

                        </div>

                    </td>

                    {{-- PEMBAYARAN --}}
                    <td class="px-6 py-5 min-w-[300px]">

                        {{-- SUDAH ADA PEMBAYARAN --}}
                        @if($i->pembayaran)

                        <div class="space-y-3">

                            <div class="text-sm text-gray-600">

                                Bukti pembayaran sudah diupload

                            </div>

                            <a
                                href="{{ asset('storage/' . $i->pembayaran->bukti_bayar) }}"
                                target="_blank"
                                class="inline-block bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-xl text-sm font-semibold transition"
                            >

                                Lihat Bukti

                            </a>

                        </div>

                        @endif

                        {{-- FORM UPLOAD --}}
                        @if(
                            !$i->pembayaran ||
                            $i->status_bukti === 'ditolak'
                        )

                        <form
                            method="POST"
                            enctype="multipart/form-data"
                            action="{{ route('penghuni.tagihan.upload', $i) }}"
                            class="space-y-4"
                        >

                            @csrf

                            {{-- NOMINAL --}}
                            <input
                                type="number"
                                name="nominal_pembayaran"
                                value="{{ old('nominal_pembayaran', $i->hargaKamar?->harga) }}"
                                placeholder="Nominal pembayaran"
                                class="w-full border border-gray-300 rounded-xl px-4 py-3"
                            >

                            {{-- FILE --}}
                            <input
                                type="file"
                                name="bukti_bayar"
                                class="w-full border border-gray-300 rounded-xl px-4 py-3 bg-white"
                            >

                            {{-- BUTTON --}}
                            <button
                                type="submit"
                                class="bg-[#6C8B6B] hover:bg-[#5B765A] text-white px-5 py-3 rounded-xl font-semibold transition"
                            >

                                Upload Bukti

                            </button>

                        </form>

                        @endif

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="6" class="px-6 py-10 text-center text-gray-500">

                        Belum ada tagihan.

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection