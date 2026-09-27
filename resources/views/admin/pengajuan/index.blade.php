@extends('layouts.admin')

@section('content')

<div class="p-6 space-y-6">

    {{-- ===================================================== --}}
    {{-- HEADER --}}
    {{-- ===================================================== --}}
    <div class="flex items-start gap-4">

        {{-- Icon header --}}
        <div class="w-12 h-12 rounded-2xl bg-[#EEF4EF]
                    flex items-center justify-center shrink-0">

            <svg class="w-6 h-6 text-[#6C8B6B]" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                    d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2M9 11a4 4 0 100-8 4 4 0 000 8zm7-3a4 4 0 110-8 4 4 0 000 8zm0 3a4 4 0 014 4v2" />

            </svg>

        </div>

        <div>

            <h1 class="text-2xl sm:text-3xl font-bold text-[#0F0937]">
                Pengajuan Penghuni
            </h1>

            <p class="text-gray-500 mt-1 text-sm sm:text-base">
                Daftar penghuni yang sedang menunggu persetujuan.
            </p>

        </div>

    </div>


    {{-- ===================================================== --}}
    {{-- SUMMARY --}}
    {{-- ===================================================== --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">

        {{-- TOTAL PENGAJUAN --}}
        <div class="bg-white rounded-3xl border border-gray-100
                    shadow-sm p-6">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-gray-500">
                        Total Pengajuan
                    </p>

                    <h2 class="text-3xl font-bold text-[#0F0937] mt-2">
                        {{ $items->count() }}
                    </h2>

                    <p class="text-xs text-gray-400 mt-1">
                        Pengajuan menunggu persetujuan
                    </p>

                </div>

                <div class="w-11 h-11 rounded-2xl bg-[#EEF4EF]
                            flex items-center justify-center">

                    <svg class="w-5 h-5 text-[#6C8B6B]" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M12 6v6l4 2m6-2a10 10 0 11-20 0 10 10 0 0120 0z" />

                    </svg>

                </div>

            </div>

        </div>

    </div>


    {{-- ===================================================== --}}
    {{-- TABLE --}}
    {{-- ===================================================== --}}
    <div class="bg-white rounded-3xl border border-gray-100
                shadow-sm overflow-hidden">

        {{-- TABLE HEADER --}}
        <div class="px-6 sm:px-8 py-5 border-b border-gray-100
                    flex flex-col sm:flex-row
                    sm:items-center sm:justify-between gap-2">

            <div>

                <h2 class="text-lg font-bold text-[#0F0937]">
                    Daftar Pengajuan
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Pengajuan penghuni yang perlu diproses.
                </p>

            </div>

            <span class="text-sm text-gray-500">
                {{ $items->count() }} pengajuan
            </span>

        </div>


        <div class="overflow-x-auto">

            <table class="w-full min-w-[950px]">

                {{-- ================================================= --}}
                {{-- HEADER --}}
                {{-- ================================================= --}}
                <thead class="bg-[#F8F5F0]">

                    <tr>

                        <th class="px-6 py-4 text-left
                                   text-xs font-semibold
                                   uppercase tracking-wide
                                   text-gray-500">

                            Nama

                        </th>

                        <th class="px-6 py-4 text-left
                                   text-xs font-semibold
                                   uppercase tracking-wide
                                   text-gray-500">

                            Username

                        </th>

                        <th class="px-6 py-4 text-left
                                   text-xs font-semibold
                                   uppercase tracking-wide
                                   text-gray-500">

                            No HP

                        </th>

                        <th class="px-6 py-4 text-left
                                   text-xs font-semibold
                                   uppercase tracking-wide
                                   text-gray-500">

                            Status

                        </th>

                        <th class="px-6 py-4 text-left
                                   text-xs font-semibold
                                   uppercase tracking-wide
                                   text-gray-500">

                            Tanggal Pengajuan

                        </th>

                        <th class="px-6 py-4 text-left
                                   text-xs font-semibold
                                   uppercase tracking-wide
                                   text-gray-500">

                            Aksi

                        </th>

                    </tr>

                </thead>


                {{-- ================================================= --}}
                {{-- BODY --}}
                {{-- ================================================= --}}
                <tbody class="divide-y divide-gray-100">

                    @forelse($items as $i)

                    <tr class="hover:bg-[#FAFCFA] transition">

                        {{-- NAMA --}}
                        <td class="px-6 py-5">

                            <div class="flex items-center gap-3">

                                <div class="w-11 h-11 rounded-full
                                                overflow-hidden shrink-0
                                                bg-[#EEF4EF]">

                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($i->user->nama) }}&background=EEF4EF&color=6C8B6B"
                                        alt="{{ $i->user->nama }}" class="w-full h-full object-cover">

                                </div>

                                <div class="min-w-0">

                                    <h4 class="font-semibold
                                                   text-[#0F0937]
                                                   truncate">

                                        {{ $i->user->nama }}

                                    </h4>

                                    <p class="text-xs text-gray-400 mt-1">

                                        NIK:
                                        {{ $i->user->nik }}

                                    </p>

                                </div>

                            </div>

                        </td>


                        {{-- USERNAME --}}
                        <td class="px-6 py-5">

                            <span class="text-sm text-gray-700">
                                {{ $i->user->username }}
                            </span>

                        </td>


                        {{-- NO HP --}}
                        <td class="px-6 py-5">

                            <span class="text-sm text-gray-700">
                                {{ $i->user->no_hp }}
                            </span>

                        </td>


                        {{-- STATUS --}}
                        <td class="px-6 py-5">

                            <span class="inline-flex items-center gap-2
                                             px-3.5 py-2 rounded-full
                                             bg-yellow-50
                                             text-yellow-700
                                             border border-yellow-100
                                             text-xs font-semibold">

                                <span class="w-2 h-2 rounded-full
                                                 bg-yellow-500"></span>

                                Menunggu

                            </span>

                        </td>


                        {{-- TANGGAL --}}
                        <td class="px-6 py-5">

                            <span class="text-sm text-gray-600">

                                {{ $i->created_at->format('d M Y') }}

                            </span>

                            <p class="text-xs text-gray-400 mt-1">

                                {{ $i->created_at->format('H:i') }}

                            </p>

                        </td>


                        {{-- AKSI --}}
                        <td class="px-6 py-5">

                            <a href="{{ route('admin.pengajuan.show', $i->id_riwayat_hunian) }}" class="inline-flex items-center gap-2
                                           bg-[#6C8B6B]
                                           hover:bg-[#5B765A]
                                           text-white
                                           px-5 py-2.5
                                           rounded-xl
                                           text-sm
                                           font-semibold
                                           transition
                                           shadow-sm hover:shadow">

                                Detail

                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />

                                </svg>

                            </a>

                        </td>

                    </tr>


                    @empty

                    {{-- ================================================= --}}
                    {{-- EMPTY STATE --}}
                    {{-- ================================================= --}}
                    <tr>

                        <td colspan="6" class="px-6 py-16">

                            <div class="flex flex-col items-center
                                            justify-center text-center">

                                <div class="w-16 h-16 rounded-2xl
                                                bg-[#EEF4EF]
                                                flex items-center justify-center
                                                mb-4">

                                    <svg class="w-7 h-7 text-[#6C8B6B]" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">

                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />

                                    </svg>

                                </div>

                                <h3 class="font-semibold
                                               text-gray-700 text-lg">

                                    Belum Ada Pengajuan

                                </h3>

                                <p class="text-sm text-gray-400 mt-1">

                                    Belum ada penghuni yang mengajukan
                                    permintaan untuk diproses.

                                </p>

                            </div>

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection