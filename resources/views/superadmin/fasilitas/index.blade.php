{{-- ========================================================= --}}
{{-- resources/views/superadmin/fasilitas/index.blade.php --}}
{{-- ========================================================= --}}

@extends('layouts.superadmin')

@section('content')

<div class="p-6 bg-[#FCFAF6] min-h-full">

    {{-- =========================================================
        HEADER
    ========================================================== --}}
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5 mb-7">

        <div>
            <h1 class="text-3xl font-bold text-[#0F0937]">
                Master Fasilitas Kost
            </h1>

            <p class="text-sm text-gray-500 mt-2">
                Kelola data fasilitas yang dapat digunakan oleh seluruh kost.
            </p>
        </div>


        <div class="flex flex-wrap gap-3">

            <a href="{{ route('superadmin.fasilitas.create') }}" class="inline-flex items-center justify-center
                       px-5 py-2.5
                       rounded-xl
                       bg-[#7A806F]
                       hover:bg-[#686D60]
                       text-white
                       text-sm
                       font-semibold
                       transition">
                + Tambah Fasilitas
            </a>


            <a href="{{ route('superadmin.dashboard') }}" class="inline-flex items-center justify-center
                       px-5 py-2.5
                       rounded-xl
                       bg-white
                       hover:bg-gray-50
                       border border-gray-200
                       text-gray-600
                       text-sm
                       font-semibold
                       transition">
                Kembali
            </a>

        </div>

    </div>


    {{-- =========================================================
        SUMMARY
    ========================================================== --}}
    <div class="mb-6">

        <div class="bg-white
                   rounded-3xl
                   border border-[#E9E7E1]
                   shadow-sm
                   p-6
                   max-w-sm">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-gray-500">
                        Total Fasilitas
                    </p>

                    <h2 class="text-3xl font-bold text-[#0F0937] mt-2">
                        {{ $items->count() }}
                    </h2>

                    <p class="text-xs text-gray-400 mt-1">
                        Fasilitas tersedia di master data.
                    </p>

                </div>


                <div class="w-12 h-12
                           rounded-2xl
                           bg-[#F3F0E9]
                           text-[#7A806F]
                           flex items-center
                           justify-center
                           text-sm
                           font-bold">
                    {{ $items->count() }}
                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
        TABLE CARD
    ========================================================== --}}
    <div class="bg-white
               rounded-3xl
               border border-[#E9E7E1]
               shadow-sm
               overflow-hidden">

        {{-- TABLE HEADER --}}
        <div class="px-6 py-5
                   border-b border-gray-100
                   bg-[#FBFAF7]
                   flex flex-col sm:flex-row
                   sm:items-center
                   sm:justify-between
                   gap-2">

            <div>

                <h2 class="text-base font-bold text-[#0F0937]">
                    Daftar Fasilitas
                </h2>

                <p class="text-xs text-gray-400 mt-1">
                    Data fasilitas yang tersedia untuk digunakan pada kost.
                </p>

            </div>


            @if($items->count() > 0)

            <span class="w-fit
                           px-3 py-1.5
                           rounded-full
                           bg-[#F3F0E9]
                           text-[#777C6D]
                           text-xs
                           font-semibold">
                {{ $items->count() }} Fasilitas
            </span>

            @endif

        </div>


        {{-- =====================================================
            TABLE
        ====================================================== --}}
        <div class="overflow-x-auto">

            <table class="w-full min-w-[700px]">

                <thead>

                    <tr class="border-b border-gray-100">

                        <th class="px-6 py-4
                                   text-left
                                   text-[11px]
                                   uppercase
                                   tracking-wide
                                   font-semibold
                                   text-gray-400
                                   w-24">
                            ID
                        </th>

                        <th class="px-6 py-4
                                   text-left
                                   text-[11px]
                                   uppercase
                                   tracking-wide
                                   font-semibold
                                   text-gray-400">
                            Nama Fasilitas
                        </th>

                        <th class="px-6 py-4
                                   text-right
                                   text-[11px]
                                   uppercase
                                   tracking-wide
                                   font-semibold
                                   text-gray-400
                                   w-48">
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-gray-100">

                    @forelse($items as $i)

                    <tr class="hover:bg-[#FCFBF8]
                                   transition">

                        {{-- ID --}}
                        <td class="px-6 py-5">

                            <span class="text-xs
                                           font-medium
                                           text-gray-400">
                                #{{ $i->id_fasilitas }}
                            </span>

                        </td>


                        {{-- NAMA --}}
                        <td class="px-6 py-5">

                            <p class="text-sm
                                           font-semibold
                                           text-[#0F0937]">
                                {{ $i->nama_fasilitas }}
                            </p>

                        </td>


                        {{-- AKSI --}}
                        <td class="px-6 py-5">

                            <div class="flex
                                           items-center
                                           justify-end
                                           gap-2">

                                {{-- EDIT --}}
                                <a href="{{ route('superadmin.fasilitas.edit', $i) }}" class="px-3.5 py-2
                                               rounded-xl
                                               bg-[#F1F3EF]
                                               hover:bg-[#E4E8E1]
                                               text-[#68705F]
                                               text-xs
                                               font-semibold
                                               transition">
                                    Edit
                                </a>


                                {{-- HAPUS --}}
                                <form method="POST" action="{{ route('superadmin.fasilitas.destroy', $i) }}"
                                    onsubmit="return confirm('Hapus fasilitas ini?')">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="px-3.5 py-2
                                                   rounded-xl
                                                   bg-[#FFF0EE]
                                                   hover:bg-[#FBE3E0]
                                                   text-[#A75A4D]
                                                   text-xs
                                                   font-semibold
                                                   transition">
                                        Hapus
                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                    @empty

                    {{-- =================================================
                            EMPTY STATE
                        ================================================== --}}
                    <tr>

                        <td colspan="3" class="px-6 py-16">

                            <div class="text-center">

                                <div class="w-14 h-14
                                               mx-auto
                                               rounded-2xl
                                               bg-[#F3F0E9]
                                               text-[#858979]
                                               flex items-center
                                               justify-center">

                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7"
                                            d="M4 6h16M4 12h16M4 18h10" />
                                    </svg>

                                </div>


                                <h3 class="mt-4
                                               text-sm
                                               font-semibold
                                               text-[#0F0937]">
                                    Belum Ada Fasilitas
                                </h3>


                                <p class="mt-1
                                               text-xs
                                               text-gray-400">
                                    Belum ada data fasilitas yang ditambahkan.
                                </p>


                                <a href="{{ route('superadmin.fasilitas.create') }}" class="inline-flex
                                               mt-5
                                               px-4 py-2.5
                                               rounded-xl
                                               bg-[#7A806F]
                                               hover:bg-[#686D60]
                                               text-white
                                               text-xs
                                               font-semibold
                                               transition">
                                    Tambah Fasilitas
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