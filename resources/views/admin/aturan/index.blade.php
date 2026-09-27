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
                        flex items-center justify-center shrink-0">

                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-[#6E8B74]" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">

                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5S19.832 5.477 21 6.253v13C19.832 18.477 18.246 18 16.5 18s-3.332.477-4.5 1.253" />

                </svg>

            </div>

            <div>

                <h1 class="text-2xl font-bold text-[#0F0937]">
                    Aturan Kos
                </h1>

                <p class="text-sm text-gray-500 mt-1">
                    Harap diperhatikan sebelum menyewa.
                </p>

            </div>

        </div>


        {{-- TAMBAH ATURAN --}}
        <a href="{{ route('admin.aturan.create') }}" class="inline-flex items-center justify-center gap-2
                   bg-[#6C8B6B]
                   hover:bg-[#5B765A]
                   text-white
                   px-5 py-2.5
                   rounded-xl
                   font-semibold
                   text-sm
                   transition
                   shadow-sm">

            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">

                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />

            </svg>

            Tambah Aturan

        </a>

    </div>


    {{-- =========================================================
        SUMMARY
    ========================================================== --}}
    @php
    $totalAturan = $aturans->count();
    @endphp

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

        {{-- TOTAL ATURAN --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-gray-500">
                        Total Aturan
                    </p>

                    <p class="text-2xl font-bold text-[#0F0937] mt-1">
                        {{ $totalAturan }}
                    </p>

                </div>

                <div class="w-11 h-11 rounded-xl bg-[#EAF1EC]
                            flex items-center justify-center">

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-[#6E8B74]" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />

                    </svg>

                </div>

            </div>

        </div>


        {{-- INFO --}}
        <div class="sm:col-span-2 bg-[#F3F7F4]
                    rounded-2xl border border-[#E2EAE3] p-5">

            <div class="flex items-start gap-3">

                <div class="w-10 h-10 rounded-xl bg-white
                            flex items-center justify-center shrink-0">

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-[#6E8B74]" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M13 16h-1v-4h-1m1-4h.01M12 21a9 9 0 100-18 9 9 0 000 18z" />

                    </svg>

                </div>

                <div>

                    <p class="font-semibold text-[#1F2937]">
                        Informasi Aturan
                    </p>

                    <p class="text-sm text-gray-500 mt-1">
                        Aturan yang tercantum digunakan sebagai panduan bagi
                        penghuni selama tinggal di kost.
                    </p>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
        DAFTAR ATURAN
    ========================================================== --}}
    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">

        {{-- CARD HEADER --}}
        <div class="px-6 py-5 border-b border-gray-100">

            <div class="flex items-center justify-between">

                <div>

                    <h2 class="text-lg font-bold text-[#0F0937]">
                        Daftar Aturan
                    </h2>

                    <p class="text-sm text-gray-500 mt-1">
                        Kelola aturan yang berlaku untuk penghuni kost.
                    </p>

                </div>

                <div class="hidden sm:flex items-center gap-2
                            px-3 py-1.5 rounded-full
                            bg-[#F3F7F4]
                            text-[#6E8B74]
                            text-xs font-semibold">

                    <span class="w-2 h-2 rounded-full bg-[#6E8B74]"></span>

                    {{ $totalAturan }} Aturan

                </div>

            </div>

        </div>


        {{-- LIST --}}
        <div class="p-4">

            @forelse($aturans as $aturan)

            <div class="group flex flex-col sm:flex-row
                            sm:items-center sm:justify-between
                            gap-4
                            px-5 py-4
                            rounded-2xl
                            border border-gray-100
                            hover:bg-[#FAFCFA]
                            hover:border-[#E2EAE3]
                            transition
                            mb-3 last:mb-0">


                {{-- NOMOR + ATURAN --}}
                <div class="flex items-start gap-4 min-w-0">

                    {{-- NOMOR --}}
                    <div class="w-9 h-9 rounded-xl
                                    bg-[#EAF1EC]
                                    text-[#6E8B74]
                                    flex items-center justify-center
                                    text-sm font-bold
                                    shrink-0">

                        {{ $loop->iteration }}

                    </div>


                    {{-- ISI --}}
                    <div class="pt-1 min-w-0">

                        <p class="text-sm font-medium
                                      text-gray-700
                                      leading-6">

                            {{ $aturan->isi }}

                        </p>

                    </div>

                </div>


                {{-- ACTION --}}
                <div class="flex items-center gap-2 shrink-0">

                    {{-- EDIT --}}
                    <a href="{{ route('admin.aturan.edit', $aturan->id) }}" class="inline-flex items-center justify-center gap-2
                                   bg-gray-100
                                   hover:bg-gray-200
                                   text-gray-700
                                   px-4 py-2.5
                                   rounded-xl
                                   text-sm
                                   font-semibold
                                   transition">

                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h5m4-14l3 3m0 0l-8 8-4 1 1-4 8-8z" />

                        </svg>

                        Edit

                    </a>


                    {{-- HAPUS --}}
                    <form action="{{ route('admin.aturan.destroy', $aturan->id) }}" method="POST">

                        @csrf
                        @method('DELETE')

                        <button type="submit" onclick="return confirm('Yakin ingin menghapus aturan ini?')" class="inline-flex items-center justify-center gap-2
                                       bg-[#FCEBEB]
                                       hover:bg-[#F7C1C1]
                                       text-[#791F1F]
                                       px-4 py-2.5
                                       rounded-xl
                                       text-sm
                                       font-semibold
                                       transition">

                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3m-4 0h14" />

                            </svg>

                            Hapus

                        </button>

                    </form>

                </div>

            </div>

            @empty

            {{-- EMPTY STATE --}}
            <div class="py-16 text-center">

                <div class="w-16 h-16 mx-auto
                                rounded-2xl
                                bg-[#F3F7F4]
                                flex items-center justify-center">

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-[#6E8B74]" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l4.414 4.414a1 1 0 012.293.707V19a2 2 0 01-2 2z" />

                    </svg>

                </div>

                <h3 class="text-base font-bold text-[#0F0937] mt-4">
                    Belum Ada Aturan
                </h3>

                <p class="text-sm text-gray-400 mt-1">
                    Belum ada aturan yang ditambahkan.
                </p>

                <a href="{{ route('admin.aturan.create') }}" class="inline-flex items-center gap-2
                               mt-5
                               bg-[#6C8B6B]
                               hover:bg-[#5B765A]
                               text-white
                               px-5 py-2.5
                               rounded-xl
                               text-sm
                               font-semibold
                               transition">

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />

                    </svg>

                    Tambah Aturan

                </a>

            </div>

            @endforelse

        </div>

    </div>

</div>

@endsection