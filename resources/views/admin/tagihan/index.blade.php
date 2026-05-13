{{-- ========================================================= --}}
{{-- resources/views/admin/tagihan/index.blade.php --}}
{{-- ========================================================= --}}

@extends('layouts.admin')

@section('content')

<div class="flex items-center justify-between mb-8">

    <div>

        <h1 class="text-3xl font-bold text-[#0F0937]">
           Pembayaran
        </h1>

        <p class="text-gray-500 mt-2">
            Validasi pembayaran penghuni kost anda!
        </p>

    </div>

    {{-- BUTTON --}}
    <div class="flex gap-3">

        {{-- PERIODE PENAGIHAN --}}
        <a
            href="{{ route('admin.periode.index') }}"
            class="bg-[#6C8B6B] hover:bg-[#5B765A] text-white px-5 py-3 rounded-xl font-semibold transition"
        >

            Kelola Periode Penagihan

        </a>

    </div>

</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

    <div class="overflow-x-auto">

        <table class="w-full">

            <thead class="bg-[#F8F5F0]">

                <tr>

                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                        Penghuni
                    </th>

                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                        No Kamar
                    </th>

                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                        Periode
                    </th>

                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                        Status
                    </th>

                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                        Bukti
                    </th>

                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                        Aksi
                    </th>

                </tr>

            </thead>

            <tbody class="divide-y divide-gray-100">

                @forelse($items as $i)

                <tr class="hover:bg-gray-50">

                    {{-- PENGHUNI --}}
                    <td class="px-6 py-5">

                        <div class="font-semibold text-[#0F0937]">

                            {{ $i->user?->nama }}

                        </div>

                    </td>

                    {{-- KAMAR --}}
                    <td class="px-6 py-5">

                        <div class="font-medium text-[#0F0937]">

                            {{ $i->kamar?->nomor_kamar }}

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

                    {{-- STATUS --}}
                    <td class="px-6 py-5">

                        @if(
                            $i->status === 'pending' &&
                            $i->status_bukti === 'belum_upload'
                        )

                        <span class="px-3 py-1 rounded-full bg-gray-100 text-gray-700 text-xs font-semibold">

                            Belum Bayar

                        </span>

                        @elseif(
                            $i->status === 'pending' &&
                            $i->status_bukti === 'menunggu'
                        )

                        <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-semibold">

                            Menunggu Verifikasi

                        </span>

                        @elseif(
                            $i->status === 'pending' &&
                            $i->status_bukti === 'ditolak'
                        )

                        <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-semibold">

                            Ditolak

                        </span>

                        @elseif(
                            $i->status === 'lunas'
                        )

                        <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">

                            Lunas

                        </span>

                        @elseif(
                            $i->status === 'telat'
                        )

                        <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-semibold">

                            Telat

                        </span>

                        @endif

                    </td>

                    {{-- BUKTI --}}
                    <td class="px-6 py-5">

                        @if($i->bukti_bayar)

                        <a
                            href="{{ asset('storage/'.$i->bukti_bayar) }}"
                            target="_blank"
                            class="inline-block bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-xl text-sm font-semibold transition"
                        >

                            Lihat Bukti

                        </a>

                        @else

                        <span class="text-sm text-gray-400">
                            Belum Upload
                        </span>

                        @endif

                    </td>

                    {{-- AKSI --}}
                    <td class="px-6 py-5">

                        @if($i->status_bukti === 'menunggu')

                        <div class="flex flex-wrap gap-2">

                            {{-- VALIDASI --}}
                            <form
                                method="POST"
                                action="{{ route('admin.tagihan.validasi', $i) }}"
                            >

                                @csrf

                                <button
                                    type="submit"
                                    class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-xl text-sm font-semibold transition"
                                >

                                    Validasi

                                </button>

                            </form>

                            {{-- TOLAK --}}
                            <form
                                method="POST"
                                action="{{ route('admin.tagihan.tolak', $i) }}"
                            >

                                @csrf

                                <button
                                    type="submit"
                                    class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-xl text-sm font-semibold transition"
                                >

                                    Tolak

                                </button>

                            </form>

                        </div>

                        @elseif($i->status === 'lunas')

                        <span class="text-sm text-green-600 font-semibold">

                            Sudah Lunas

                        </span>

                        @elseif($i->status_bukti === 'ditolak')

                        <span class="text-sm text-red-500 font-semibold">

                            Menunggu Upload Ulang

                        </span>

                        @else

                        <span class="text-sm text-gray-400">

                            Tidak Ada Aksi

                        </span>

                        @endif

                    </td>

                </tr>

                @empty

                <tr>

                    <td
                        colspan="6"
                        class="px-6 py-10 text-center text-gray-500"
                    >

                        Belum ada data tagihan.

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection