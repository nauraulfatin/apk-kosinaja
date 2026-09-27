{{-- ========================================================= --}}
{{-- resources/views/admin/kamar/harga/index.blade.php --}}
{{-- ========================================================= --}}

@extends('layouts.admin')

@section('content')

<div class="p-6 space-y-6">

    {{-- ===================================================== --}}
    {{-- HEADER --}}
    {{-- ===================================================== --}}
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5">

        <div class="flex items-start gap-4">

            {{-- Icon utama --}}
            <div class="w-12 h-12 rounded-2xl bg-[#EEF4EF] flex items-center justify-center shrink-0">

                <svg class="w-6 h-6 text-[#6C8B6B]" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M12 8c-2.21 0-4 1.12-4 2.5S9.79 13 12 13s4 1.12 4 2.5S14.21 18 12 18m0-12v2m0 10v2m8-8a8 8 0 11-16 0 8 8 0 0116 0z" />

                </svg>

            </div>

            <div>

                <h1 class="text-2xl sm:text-3xl font-bold text-[#0F0937]">
                    Harga Kamar
                </h1>

                <p class="text-gray-500 mt-1 text-sm sm:text-base">
                    Kelola harga dan periode penagihan untuk kamar:
                    <span class="font-semibold text-[#0F0937]">
                        {{ $kamar->nama_kamar }}
                    </span>
                </p>

            </div>

        </div>


        {{-- BUTTON --}}
        <div class="flex flex-col sm:flex-row gap-3">

            <a href="{{ route('admin.kamar.harga.create', $kamar) }}" class="inline-flex items-center justify-center gap-2
                      bg-[#6C8B6B] hover:bg-[#5B765A]
                      text-white px-5 py-3 rounded-xl
                      font-semibold shadow-sm hover:shadow-md
                      transition">

                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />

                </svg>

                Tambah Harga

            </a>

            <a href="{{ route('admin.kamar.index') }}" class="inline-flex items-center justify-center
                      bg-gray-100 hover:bg-gray-200
                      text-gray-700 px-5 py-3 rounded-xl
                      font-semibold transition">

                Kembali

            </a>

        </div>

    </div>


    {{-- ===================================================== --}}
    {{-- INFO KAMAR --}}
    {{-- ===================================================== --}}
    <div class="bg-[#F8F5F0] border border-gray-200 rounded-2xl px-5 py-4">

        <p class="text-xs text-gray-500 mb-1">
            Kamar
        </p>

        <p class="font-semibold text-[#0F0937]">
            {{ $kamar->nama_kamar }}
        </p>

    </div>


    {{-- ===================================================== --}}
    {{-- DATA HARGA --}}
    {{-- ===================================================== --}}
    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">

        {{-- TABLE HEADER --}}
        <div class="px-6 sm:px-8 py-5 border-b border-gray-100">

            <h2 class="font-bold text-lg text-[#0F0937]">
                Daftar Harga
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Harga dan periode penagihan yang tersedia untuk kamar ini.
            </p>

        </div>


        {{-- ================================================= --}}
        {{-- TABLE --}}
        {{-- ================================================= --}}
        <div class="overflow-x-auto">

            <table class="w-full min-w-[850px]">

                <thead class="bg-[#F8F5F0]">

                    <tr>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Harga
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Periode
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
                        {{-- HARGA --}}
                        {{-- ================================= --}}
                        <td class="px-6 py-5">

                            <p class="font-bold text-[#0F0937]">
                                Rp {{ number_format($i->harga, 0, ',', '.') }}
                            </p>

                        </td>


                        {{-- ================================= --}}
                        {{-- PERIODE --}}
                        {{-- ================================= --}}
                        <td class="px-6 py-5">

                            <p class="font-semibold text-[#0F0937]">

                                {{ $i->periode?->periode_penagihan ?? '-' }}

                            </p>

                            <p class="text-sm text-gray-500 mt-1">

                                Setiap
                                {{ $i->periode?->jumlah_interval ?? '-' }}
                                {{ $i->periode?->satuan_interval ?? '' }}

                            </p>

                        </td>


                        {{-- ================================= --}}
                        {{-- STATUS --}}
                        {{-- ================================= --}}
                        <td class="px-6 py-5">

                            @if($i->isactive)

                            <span class="inline-flex items-center gap-2
                                             px-3 py-1.5 rounded-full
                                             text-xs font-semibold
                                             bg-[#E2EAE3] text-[#52705A]">

                                <span class="w-1.5 h-1.5 rounded-full bg-[#6C8B6B]"></span>

                                Aktif

                            </span>

                            @else

                            <span class="inline-flex items-center gap-2
                                             px-3 py-1.5 rounded-full
                                             text-xs font-semibold
                                             bg-gray-100 text-gray-600">

                                <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>

                                Tidak Aktif

                            </span>

                            @endif

                        </td>


                        {{-- ================================= --}}
                        {{-- AKSI --}}
                        {{-- ================================= --}}
                        <td class="px-6 py-5">

                            <div class="flex flex-wrap gap-2">

                                {{-- EDIT --}}
                                <a href="{{ route('admin.kamar.harga.edit', [$kamar, $i]) }}" class="inline-flex items-center gap-2
                                          bg-[#EAF1FB] hover:bg-[#D6E4FA]
                                          text-[#1D4E89]
                                          px-4 py-2.5 rounded-xl
                                          font-semibold text-sm transition">

                                    Edit

                                </a>


                                {{-- HAPUS --}}
                                <form method="POST" action="{{ route('admin.kamar.harga.destroy', [$kamar, $i]) }}"
                                    onsubmit="return confirm('Hapus harga kamar ini?')">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="inline-flex items-center gap-2
                                                   bg-[#FCEBEB] hover:bg-[#F7C1C1]
                                                   text-[#791F1F]
                                                   px-4 py-2.5 rounded-xl
                                                   font-semibold text-sm transition">

                                        Hapus

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>


                    @empty

                    {{-- ================================= --}}
                    {{-- EMPTY STATE --}}
                    {{-- ================================= --}}
                    <tr>

                        <td colspan="4" class="px-6 py-14">

                            <div class="text-center">

                                {{-- Icon hanya untuk empty state --}}
                                <div class="w-14 h-14 mx-auto rounded-2xl
                                            bg-[#EEF4EF]
                                            flex items-center justify-center mb-4">

                                    <svg class="w-7 h-7 text-[#6C8B6B]" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">

                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7"
                                            d="M12 8c-2.21 0-4 1.12-4 2.5S9.79 13 12 13s4 1.12 4 2.5S14.21 18 12 18m0-12v2m0 10v2m8-8a8 8 0 11-16 0 8 8 0 0116 0z" />

                                    </svg>

                                </div>

                                <h3 class="font-bold text-[#0F0937]">
                                    Belum Ada Harga Kamar
                                </h3>

                                <p class="text-sm text-gray-500 mt-1">
                                    Belum ada harga yang ditambahkan untuk kamar ini.
                                </p>

                                <a href="{{ route('admin.kamar.harga.create', $kamar) }}" class="inline-block mt-4
                                          bg-[#6C8B6B] hover:bg-[#5B765A]
                                          text-white px-5 py-2.5 rounded-xl
                                          font-semibold text-sm transition">

                                    Tambah Harga

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