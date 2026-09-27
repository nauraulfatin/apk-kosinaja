@extends('layouts.admin')

@section('content')

<div class="p-6 space-y-6">

    {{-- =========================================================
        HEADER
    ========================================================== --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

        <div class="flex items-center gap-3">

            {{-- ICON --}}
            <div class="w-12 h-12 rounded-2xl bg-[#EAF1EC]
                        flex items-center justify-center">

                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-[#6E8B74]" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">

                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M8 10h8m-8 4h5m6 1.5V6.5A2.5 2.5 0 0016.5 4h-9A2.5 2.5 0 005 6.5v11A2.5 2.5 0 007.5 20h6.5l4 2v-6.5z" />

                </svg>

            </div>


            <div>

                <h1 class="text-2xl font-bold text-[#0F0937]">
                    Data Aduan Penghuni
                </h1>

                <p class="text-sm text-gray-500 mt-1">
                    Kelola dan pantau aduan dari penghuni kost.
                </p>

            </div>

        </div>

    </div>


    {{-- =========================================================
        SUMMARY
    ========================================================== --}}
    @php
    $totalAduan = $aduan->count();
    $aduanBaru = $aduan->where('status', 'baru')->count();
    $aduanSelesai = $aduan->where('status', 'selesai')->count();
    @endphp


    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">


        {{-- TOTAL --}}
        <div class="bg-white rounded-2xl border border-gray-100
                    shadow-sm p-5">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-gray-500">
                        Total Aduan
                    </p>

                    <p class="text-2xl font-bold text-[#0F0937] mt-1">
                        {{ $totalAduan }}
                    </p>

                </div>


                <div class="w-11 h-11 rounded-xl bg-[#EAF1EC]
                            flex items-center justify-center">

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-[#6E8B74]" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M8 10h8m-8 4h5m6 1.5V6.5A2.5 2.5 0 0016.5 4h-9A2.5 2.5 0 005 6.5v11A2.5 2.5 0 007.5 20h6.5l4 2v-6.5z" />

                    </svg>

                </div>

            </div>

        </div>


        {{-- BARU --}}
        <div class="bg-white rounded-2xl border border-gray-100
                    shadow-sm p-5">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-gray-500">
                        Aduan Baru
                    </p>

                    <p class="text-2xl font-bold text-blue-600 mt-1">
                        {{ $aduanBaru }}
                    </p>

                </div>


                <div class="w-11 h-11 rounded-xl bg-blue-50
                            flex items-center justify-center">

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-600" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M12 9v3m0 4h.01M10.29 3.86l-7.18 12A2 2 0 004.82 19h14.36a2 2 0 001.71-3.14l-7.18-12a2 2 0 00-3.42 0z" />

                    </svg>

                </div>

            </div>

        </div>


        {{-- SELESAI --}}
        <div class="bg-white rounded-2xl border border-gray-100
                    shadow-sm p-5">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-gray-500">
                        Aduan Selesai
                    </p>

                    <p class="text-2xl font-bold text-green-600 mt-1">
                        {{ $aduanSelesai }}
                    </p>

                </div>


                <div class="w-11 h-11 rounded-xl bg-green-50
                            flex items-center justify-center">

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-600" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 13l4 4L19 7" />

                    </svg>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
        TABLE CARD
    ========================================================== --}}
    <div class="bg-white rounded-3xl border border-gray-100
                shadow-sm overflow-hidden">


        {{-- TABLE HEADER --}}
        <div class="px-6 py-5 border-b border-gray-100">

            <div class="flex items-center justify-between">

                <div>

                    <h2 class="text-lg font-bold text-[#0F0937]">
                        Daftar Aduan
                    </h2>

                    <p class="text-sm text-gray-500 mt-1">
                        Semua laporan yang dikirim oleh penghuni.
                    </p>

                </div>

                <div class="hidden sm:flex items-center gap-2
                            px-3 py-1.5
                            rounded-full
                            bg-[#F3F7F4]
                            text-[#6E8B74]
                            text-xs font-semibold">

                    <span class="w-2 h-2 rounded-full bg-[#6E8B74]"></span>

                    {{ $totalAduan }} Aduan

                </div>

            </div>

        </div>


        {{-- =====================================================
            TABLE
        ====================================================== --}}
        <div class="overflow-x-auto">

            <table class="w-full min-w-[850px]">

                {{-- HEADER --}}
                <thead>

                    <tr class="bg-[#F8FAF8]
                               text-left
                               text-xs
                               uppercase
                               tracking-wide
                               text-gray-500">

                        <th class="px-6 py-4 font-semibold">
                            No
                        </th>

                        <th class="px-6 py-4 font-semibold">
                            Penghuni
                        </th>

                        <th class="px-6 py-4 font-semibold">
                            Foto
                        </th>

                        <th class="px-6 py-4 font-semibold">
                            Tanggal
                        </th>

                        <th class="px-6 py-4 font-semibold">
                            Status
                        </th>

                        <th class="px-6 py-4 font-semibold text-right">
                            Aksi
                        </th>

                    </tr>

                </thead>


                {{-- BODY --}}
                <tbody class="divide-y divide-gray-100">

                    @forelse($aduan as $item)

                    <tr class="hover:bg-[#FAFCFA] transition">


                        {{-- NO --}}
                        <td class="px-6 py-5">

                            <span class="text-sm font-semibold text-gray-400">
                                {{ $loop->iteration }}
                            </span>

                        </td>


                        {{-- NAMA --}}
                        <td class="px-6 py-5">

                            <div class="flex items-center gap-3">

                                {{-- AVATAR --}}
                                <div class="w-10 h-10 rounded-xl
                                            bg-[#EAF1EC]
                                            flex items-center justify-center
                                            text-[#6E8B74]
                                            font-bold
                                            text-sm">

                                    {{ strtoupper(substr($item->nama, 0, 1)) }}

                                </div>


                                <div>

                                    <p class="font-semibold text-[#0F0937] text-sm">
                                        {{ $item->nama }}
                                    </p>

                                    <p class="text-xs text-gray-400 mt-0.5">
                                        Penghuni
                                    </p>

                                </div>

                            </div>

                        </td>


                        {{-- FOTO --}}
                        <td class="px-6 py-5">

                            @if($item->foto_aduan)

                            <div class="relative w-16 h-16 rounded-xl
                                        overflow-hidden
                                        border border-gray-200
                                        group">

                                <img src="{{ asset('storage/' . $item->foto_aduan) }}" alt="Foto Aduan" class="w-full h-full object-cover
                                           group-hover:scale-110
                                           transition-transform duration-300">

                            </div>

                            @else

                            <div class="w-16 h-16 rounded-xl
                                        bg-gray-50
                                        border border-dashed border-gray-200
                                        flex items-center justify-center">

                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-300" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">

                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />

                                </svg>

                            </div>

                            @endif

                        </td>


                        {{-- TANGGAL --}}
                        <td class="px-6 py-5">

                            <div class="flex items-center gap-2">

                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">

                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M8 7V3m8 4V3m-9 8h10m-9 9h10a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v11a2 2 0 002 2z" />

                                </svg>

                                <span class="text-sm text-gray-600">
                                    {{ $item->tanggal }}
                                </span>

                            </div>

                        </td>


                        {{-- STATUS --}}
                        <td class="px-6 py-5">

                            @if($item->status == 'baru')

                            <span class="inline-flex items-center gap-2
                                         px-3 py-1.5
                                         rounded-full
                                         text-xs font-semibold
                                         bg-blue-50
                                         text-blue-700">

                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>

                                Baru

                            </span>

                            @elseif($item->status == 'diproses')

                            <span class="inline-flex items-center gap-2
                                         px-3 py-1.5
                                         rounded-full
                                         text-xs font-semibold
                                         bg-yellow-50
                                         text-yellow-700">

                                <span class="w-1.5 h-1.5 rounded-full bg-yellow-500"></span>

                                Diproses

                            </span>

                            @else

                            <span class="inline-flex items-center gap-2
                                         px-3 py-1.5
                                         rounded-full
                                         text-xs font-semibold
                                         bg-green-50
                                         text-green-700">

                                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>

                                Selesai

                            </span>

                            @endif

                        </td>


                        {{-- AKSI --}}
                        <td class="px-6 py-5 text-right">

                            <a href="{{ route('admin.aduan.show', $item->id_aduan) }}" class="inline-flex items-center gap-2
                                       bg-[#6E8B74]
                                       hover:bg-[#5c7764]
                                       text-white
                                       px-4 py-2.5
                                       rounded-xl
                                       text-sm
                                       font-semibold
                                       transition
                                       shadow-sm">

                                Detail

                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">

                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />

                                </svg>

                            </a>

                        </td>

                    </tr>

                    @empty

                    {{-- EMPTY STATE --}}
                    <tr>

                        <td colspan="6">

                            <div class="py-16 text-center">

                                <div class="w-16 h-16 mx-auto
                                            rounded-2xl
                                            bg-[#F3F7F4]
                                            flex items-center justify-center">

                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-[#6E8B74]" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">

                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6"
                                            d="M8 10h8m-8 4h5m6 1.5V6.5A2.5 2.5 0 0016.5 4h-9A2.5 2.5 0 005 6.5v11A2.5 2.5 0 007.5 20h6.5l4 2v-6.5z" />

                                    </svg>

                                </div>

                                <h3 class="text-base font-bold text-[#0F0937] mt-4">
                                    Belum Ada Aduan
                                </h3>

                                <p class="text-sm text-gray-400 mt-1">
                                    Belum ada laporan yang dikirim oleh penghuni.
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