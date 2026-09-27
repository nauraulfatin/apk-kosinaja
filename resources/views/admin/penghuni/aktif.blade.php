@extends('layouts.admin')

@section('content')

<div class="p-6 space-y-6">

    {{-- ===================================================== --}}
    {{-- HEADER --}}
    {{-- ===================================================== --}}
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5">

        <div class="flex items-start gap-4">

            {{-- Icon header --}}
            <div class="w-12 h-12 rounded-2xl bg-[#EEF4EF] flex items-center justify-center shrink-0">

                <svg class="w-6 h-6 text-[#6C8B6B]" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2M9 11a4 4 0 100-8 4 4 0 000 8zm7-3a4 4 0 110-8 4 4 0 000 8zm0 3a4 4 0 014 4v2" />

                </svg>

            </div>

            <div>

                <h1 class="text-2xl sm:text-3xl font-bold text-[#0F0937]">
                    Penghuni Aktif
                </h1>

                <p class="text-gray-500 mt-1 text-sm sm:text-base">
                    Daftar penghuni yang sedang aktif menempati kamar.
                </p>

            </div>

        </div>

    </div>


    {{-- ===================================================== --}}
    {{-- NAVIGATION --}}
    {{-- ===================================================== --}}
    <div class="border-b border-gray-200">

        <div class="flex items-center gap-7 sm:gap-8 overflow-x-auto">

            {{-- Penghuni Aktif --}}
            <a href="{{ route('admin.penghuni.aktif') }}" class="relative pb-3 text-sm font-semibold whitespace-nowrap transition
               {{ request()->routeIs('admin.penghuni.aktif')
                    ? 'text-[#6C8B6B]'
                    : 'text-gray-400 hover:text-[#6C8B6B]' }}">

                Penghuni Aktif

                @if(request()->routeIs('admin.penghuni.aktif'))
                <span class="absolute left-0 right-0 bottom-0 h-0.5 bg-[#6C8B6B] rounded-full"></span>
                @endif

            </a>


            {{-- Dalam Antrian --}}
            <a href="{{ route('admin.penghuni.antrian') }}" class="relative pb-3 text-sm font-semibold whitespace-nowrap transition
               {{ request()->routeIs('admin.penghuni.antrian')
                    ? 'text-[#E8B44D]'
                    : 'text-gray-400 hover:text-[#E8B44D]' }}">

                Dalam Antrian

                @if(request()->routeIs('admin.penghuni.antrian'))
                <span class="absolute left-0 right-0 bottom-0 h-0.5 bg-[#E8B44D] rounded-full"></span>
                @endif

            </a>


            {{-- Riwayat Penghuni --}}
            <a href="{{ route('admin.penghuni.nonaktif') }}" class="relative pb-3 text-sm font-semibold whitespace-nowrap transition
               {{ request()->routeIs('admin.penghuni.nonaktif')
                    ? 'text-red-500'
                    : 'text-gray-400 hover:text-red-500' }}">

                Riwayat Penghuni

                @if(request()->routeIs('admin.penghuni.nonaktif'))
                <span class="absolute left-0 right-0 bottom-0 h-0.5 bg-red-500 rounded-full"></span>
                @endif

            </a>

        </div>

    </div>


    {{-- ===================================================== --}}
    {{-- TABLE CARD --}}
    {{-- ===================================================== --}}
    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">

        {{-- TABLE HEADER --}}
        <div class="px-6 sm:px-8 py-5 border-b border-gray-100">

            <div class="flex items-center justify-between gap-4">

                <div>

                    <h2 class="text-lg font-bold text-[#0F0937]">
                        Daftar Penghuni
                    </h2>

                    <p class="text-sm text-gray-500 mt-1">
                        Penghuni yang saat ini masih menempati kamar.
                    </p>

                </div>

                @if($items->count() > 0)

                <span
                    class="px-3 py-1.5 rounded-full bg-[#EEF4EF] text-[#52705A] text-xs font-semibold whitespace-nowrap">
                    {{ $items->count() }} Penghuni
                </span>

                @endif

            </div>

        </div>


        {{-- ================================================= --}}
        {{-- TABLE --}}
        {{-- ================================================= --}}
        <div class="overflow-x-auto">

            <table class="w-full min-w-[950px]">

                <thead class="bg-[#F8F5F0]">

                    <tr>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Nama
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Kamar
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Tanggal Masuk
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Tanggal Keluar
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Status
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-gray-100">

                    @forelse($items as $i)

                    <tr class="hover:bg-[#FAFBFA] transition">


                        {{-- ================================= --}}
                        {{-- NAMA --}}
                        {{-- ================================= --}}
                        <td class="px-6 py-5">

                            <div class="flex items-center gap-3">

                                {{-- Avatar --}}
                                <div class="w-10 h-10 rounded-full bg-[#E2EAE3]
                                            flex items-center justify-center
                                            text-[#52705A] font-bold shrink-0">

                                    {{ strtoupper(substr($i->user->nama ?? 'P', 0, 1)) }}

                                </div>

                                <div>

                                    <h4 class="font-semibold text-[#0F0937]">
                                        {{ $i->user->nama }}
                                    </h4>

                                    <p class="text-sm text-gray-400 mt-0.5">
                                        {{ $i->user->username }}
                                    </p>

                                </div>

                            </div>

                        </td>


                        {{-- ================================= --}}
                        {{-- KAMAR --}}
                        {{-- ================================= --}}
                        <td class="px-6 py-5">

                            <span class="inline-flex items-center px-3 py-1.5
                                         rounded-xl bg-gray-100
                                         text-gray-700 text-sm font-semibold">

                                {{ $i->kamar->nomor_kamar ?? '-' }}

                            </span>

                        </td>


                        {{-- ================================= --}}
                        {{-- TANGGAL MASUK --}}
                        {{-- ================================= --}}
                        <td class="px-6 py-5 text-sm text-gray-600">

                            {{ \Carbon\Carbon::parse($i->tanggal_masuk)->format('d M Y') }}

                        </td>


                        {{-- ================================= --}}
                        {{-- TANGGAL KELUAR --}}
                        {{-- ================================= --}}
                        <td class="px-6 py-5 text-sm text-gray-600">

                            {{ \Carbon\Carbon::parse($i->tanggal_keluar)->format('d M Y') }}

                        </td>


                        {{-- ================================= --}}
                        {{-- STATUS --}}
                        {{-- ================================= --}}
                        <td class="px-6 py-5">

                            <span class="inline-flex items-center gap-2
                                         px-3 py-1.5 rounded-full
                                         bg-[#E2EAE3] text-[#52705A]
                                         text-xs font-semibold">

                                <span class="w-1.5 h-1.5 rounded-full bg-[#6C8B6B]"></span>

                                Aktif

                            </span>

                        </td>


                        {{-- ================================= --}}
                        {{-- AKSI --}}
                        {{-- ================================= --}}
                        <td class="px-6 py-5">

                            <form method="POST" action="{{ route('admin.penghuni.nonaktifkan', $i) }}"
                                onsubmit="return confirm('Nonaktifkan penghuni ini?')">

                                @csrf
                                @method('PUT')

                                <button type="submit" class="bg-[#FCEBEB] hover:bg-[#F7C1C1]
                                           text-[#791F1F]
                                           px-4 py-2.5 rounded-xl
                                           font-semibold text-sm transition">

                                    Nonaktifkan

                                </button>

                            </form>

                        </td>

                    </tr>


                    @empty

                    {{-- ================================= --}}
                    {{-- EMPTY STATE --}}
                    {{-- ================================= --}}
                    <tr>

                        <td colspan="6" class="px-6 py-16">

                            <div class="text-center">

                                {{-- Satu icon untuk empty state --}}
                                <div class="w-14 h-14 mx-auto rounded-2xl
                                            bg-[#EEF4EF]
                                            flex items-center justify-center mb-4">

                                    <svg class="w-7 h-7 text-[#6C8B6B]" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">

                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7"
                                            d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2M9 11a4 4 0 100-8 4 4 0 000 8zm7-3a4 4 0 110-8 4 4 0 000 8zm0 3a4 4 0 014 4v2" />

                                    </svg>

                                </div>

                                <h3 class="font-bold text-[#0F0937]">
                                    Belum Ada Penghuni Aktif
                                </h3>

                                <p class="text-sm text-gray-500 mt-1">
                                    Belum ada penghuni yang sedang aktif menempati kamar.
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