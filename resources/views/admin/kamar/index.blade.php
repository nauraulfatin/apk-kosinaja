{{-- ========================================================= --}}
{{-- resources/views/admin/kamar/index.blade.php --}}
{{-- ========================================================= --}}

@extends('layouts.admin')

@section('content')

<div class="p-6 space-y-6">

    {{-- ========================================================= --}}
    {{-- HEADER --}}
    {{-- ========================================================= --}}

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

        <div class="flex items-center gap-4">

            <div class="w-12 h-12 rounded-2xl bg-[#EEF4EF] flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-[#6C8B6B]" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 21h18" />
                    <path d="M5 21V7l7-4 7 4v14" />
                    <path d="M9 21v-4h6v4" />
                    <path d="M9 9h.01" />
                    <path d="M15 9h.01" />
                    <path d="M9 13h.01" />
                    <path d="M15 13h.01" />
                </svg>
            </div>

            <div>
                <h1 class="text-3xl font-bold text-[#0F0937]">
                    Daftar Kamar
                </h1>

                <p class="text-gray-500 mt-1.5 text-sm">
                    Kelola daftar kamar kost anda
                </p>
            </div>

        </div>


        {{-- TAMBAH KAMAR --}}

        <a href="{{ route('admin.kamar.create') }}" class="inline-flex items-center justify-center gap-2
                   bg-[#6C8B6B] hover:bg-[#5B765A]
                   text-white px-5 py-3
                   rounded-2xl font-semibold text-sm
                   transition-all duration-200
                   shadow-sm hover:shadow-md">

            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 5v14" />
                <path d="M5 12h14" />
            </svg>

            Tambah Kamar

        </a>

    </div>


    {{-- ========================================================= --}}
    {{-- SUMMARY --}}
    {{-- ========================================================= --}}

    @php
    $totalKamar = $items->count();
    $kamarKosong = $items->where('status', 'kosong')->count();
    $kamarTerisi = $items->where('status', '!=', 'kosong')->count();
    @endphp

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">

        {{-- TOTAL --}}

        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-5">

            <div class="flex items-center justify-between">

                <div>
                    <p class="text-sm font-medium text-gray-500">
                        Total Kamar
                    </p>

                    <h2 class="text-2xl font-bold text-[#0F0937] mt-1">
                        {{ $totalKamar }}
                    </h2>
                </div>

                <div class="w-11 h-11 rounded-2xl bg-[#EEF4EF] flex items-center justify-center">

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-[#6C8B6B]" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M3 21h18" />
                        <path d="M5 21V7l7-4 7 4v14" />
                        <path d="M9 21v-4h6v4" />
                    </svg>

                </div>

            </div>

        </div>


        {{-- KOSONG --}}

        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-5">

            <div class="flex items-center justify-between">

                <div>
                    <p class="text-sm font-medium text-gray-500">
                        Kamar Kosong
                    </p>

                    <h2 class="text-2xl font-bold text-green-700 mt-1">
                        {{ $kamarKosong }}
                    </h2>
                </div>

                <div class="w-11 h-11 rounded-2xl bg-green-50 flex items-center justify-center">

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-600" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M20 6L9 17l-5-5" />
                    </svg>

                </div>

            </div>

        </div>


        {{-- TERISI --}}

        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-5">

            <div class="flex items-center justify-between">

                <div>
                    <p class="text-sm font-medium text-gray-500">
                        Kamar Terisi
                    </p>

                    <h2 class="text-2xl font-bold text-red-600 mt-1">
                        {{ $kamarTerisi }}
                    </h2>
                </div>

                <div class="w-11 h-11 rounded-2xl bg-red-50 flex items-center justify-center">

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-500" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="9" />
                        <path d="M8 12h8" />
                    </svg>

                </div>

            </div>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- TABLE --}}
    {{-- ========================================================= --}}

    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">

        {{-- TABLE HEADER --}}

        <div class="px-6 py-5 border-b border-gray-100">

            <div class="flex items-center gap-3">

                <div class="w-10 h-10 rounded-xl bg-[#F3F6F3] flex items-center justify-center">

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-[#6C8B6B]" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M8 6h13" />
                        <path d="M8 12h13" />
                        <path d="M8 18h13" />
                        <path d="M3 6h.01" />
                        <path d="M3 12h.01" />
                        <path d="M3 18h.01" />
                    </svg>

                </div>

                <div>
                    <h2 class="font-bold text-[#0F0937]">
                        Data Kamar
                    </h2>

                    <p class="text-xs text-gray-400 mt-0.5">
                        Daftar kamar yang tersedia di kost
                    </p>
                </div>

            </div>

        </div>


        <div class="overflow-x-auto">

            <table class="w-full min-w-[900px]">

                {{-- ================================================= --}}
                {{-- TABLE HEAD --}}
                {{-- ================================================= --}}

                <thead class="bg-[#F8F5F0]">

                    <tr>

                        <th class="px-6 py-4 text-left
                                   text-[11px] font-bold
                                   text-gray-500 uppercase
                                   tracking-wider">
                            Nama Kamar
                        </th>

                        <th class="px-6 py-4 text-left
                                   text-[11px] font-bold
                                   text-gray-500 uppercase
                                   tracking-wider">
                            Nomor
                        </th>

                        <th class="px-6 py-4 text-left
                                   text-[11px] font-bold
                                   text-gray-500 uppercase
                                   tracking-wider">
                            Ukuran
                        </th>

                        <th class="px-6 py-4 text-left
                                   text-[11px] font-bold
                                   text-gray-500 uppercase
                                   tracking-wider">
                            Status
                        </th>

                        <th class="px-6 py-4 text-left
                                   text-[11px] font-bold
                                   text-gray-500 uppercase
                                   tracking-wider">
                            Aksi
                        </th>

                    </tr>

                </thead>


                {{-- ================================================= --}}
                {{-- TABLE BODY --}}
                {{-- ================================================= --}}

                <tbody class="divide-y divide-gray-100">

                    @forelse($items as $i)

                    <tr class="hover:bg-[#FAFCFA] transition-colors">


                        {{-- NAMA KAMAR --}}

                        <td class="px-6 py-5">

                            <div class="flex items-center gap-3">

                                <div class="w-10 h-10 rounded-xl
                                            bg-[#EEF4EF]
                                            flex items-center justify-center
                                            flex-shrink-0">

                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-[#6C8B6B]"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M3 21h18" />
                                        <path d="M5 21V7l7-4 7 4v14" />
                                        <path d="M9 21v-4h6v4" />
                                    </svg>

                                </div>

                                <div>

                                    <p class="text-sm font-bold text-gray-800">
                                        {{ $i->nama_kamar }}
                                    </p>

                                    <p class="text-xs text-gray-400 mt-0.5">
                                        Kamar kost
                                    </p>

                                </div>

                            </div>

                        </td>


                        {{-- NOMOR --}}

                        <td class="px-6 py-5">

                            <span class="inline-flex items-center
                                         px-3 py-1.5 rounded-xl
                                         bg-gray-100
                                         text-gray-700
                                         text-sm font-semibold">

                                {{ $i->nomor_kamar }}

                            </span>

                        </td>


                        {{-- UKURAN --}}

                        <td class="px-6 py-5">

                            <div class="flex items-center gap-2
                                        text-sm text-gray-600">

                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M15 3h6v6" />
                                    <path d="M9 21H3v-6" />
                                    <path d="M21 3l-7 7" />
                                    <path d="M3 21l7-7" />
                                </svg>

                                {{ $i->ukuran_kamar }}

                            </div>

                        </td>


                        {{-- STATUS --}}

                        <td class="px-6 py-5">

                            @if($i->status == 'kosong')

                            <span class="inline-flex items-center gap-2
                                             px-3 py-1.5 rounded-full
                                             bg-green-50
                                             text-green-700
                                             text-xs font-bold">

                                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>

                                Kosong

                            </span>

                            @else

                            <span class="inline-flex items-center gap-2
                                             px-3 py-1.5 rounded-full
                                             bg-red-50
                                             text-red-700
                                             text-xs font-bold">

                                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>

                                {{ ucfirst($i->status) }}

                            </span>

                            @endif

                        </td>


                        {{-- AKSI --}}

                        <td class="px-6 py-5">

                            <div class="flex flex-wrap items-center gap-2">


                                {{-- EDIT --}}

                                <a href="{{ route('admin.kamar.edit', $i) }}" class="inline-flex items-center gap-1.5
                                           px-3.5 py-2 rounded-xl
                                           bg-blue-50 text-blue-700
                                           hover:bg-blue-100
                                           text-xs font-semibold
                                           transition-colors">

                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M12 20h9" />
                                        <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4Z" />
                                    </svg>

                                    Edit

                                </a>


                                {{-- HARGA --}}

                                <a href="{{ route('admin.kamar.harga.index', $i) }}" class="inline-flex items-center gap-1.5
                                           px-3.5 py-2 rounded-xl
                                           bg-green-50 text-green-700
                                           hover:bg-green-100
                                           text-xs font-semibold
                                           transition-colors">

                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="9" />
                                        <path d="M12 7v10" />
                                        <path d="M15 9.5c-.5-1-1.5-1.5-3-1.5
                                                 -1.7 0-3 .8-3 2
                                                 0 3 6 1.5 6 4
                                                 0 1.2-1.2 2-3 2
                                                 -1.5 0-2.5-.5-3-1.5" />
                                    </svg>

                                    Harga

                                </a>


                                {{-- HAPUS --}}

                                <form method="POST" action="{{ route('admin.kamar.destroy', $i) }}"
                                    onsubmit="return confirm('Hapus kamar ini?')">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="inline-flex items-center gap-1.5
                                               px-3.5 py-2 rounded-xl
                                               bg-red-50 text-red-700
                                               hover:bg-red-100
                                               text-xs font-semibold
                                               transition-colors
                                               cursor-pointer">

                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <polyline points="3 6 5 6 21 6" />
                                            <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6" />
                                            <path d="M10 11v6M14 11v6" />
                                            <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2" />
                                        </svg>

                                        Hapus

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                    @empty

                    {{-- ================================================= --}}
                    {{-- EMPTY STATE --}}
                    {{-- ================================================= --}}

                    <tr>

                        <td colspan="5" class="px-6 py-16">

                            <div class="flex flex-col items-center justify-center text-center">

                                <div class="w-16 h-16 rounded-2xl
                                            bg-[#F3F6F3]
                                            flex items-center justify-center mb-4">

                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-[#6C8B6B]"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M3 21h18" />
                                        <path d="M5 21V7l7-4 7 4v14" />
                                        <path d="M9 21v-4h6v4" />
                                    </svg>

                                </div>

                                <h3 class="text-base font-bold text-gray-700">
                                    Belum ada data kamar
                                </h3>

                                <p class="text-sm text-gray-400 mt-1">
                                    Tambahkan kamar untuk mulai mengelola data kamar kost.
                                </p>

                                <a href="{{ route('admin.kamar.create') }}" class="mt-5 inline-flex items-center gap-2
                                           bg-[#6C8B6B] hover:bg-[#5B765A]
                                           text-white px-4 py-2.5
                                           rounded-xl text-sm font-semibold
                                           transition">

                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M12 5v14" />
                                        <path d="M5 12h14" />
                                    </svg>

                                    Tambah Kamar

                                </a>

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