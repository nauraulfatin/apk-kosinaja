@extends('layouts.admin')

@section('content')

<div class="p-6 max-w-6xl mx-auto">

    {{-- =========================================================
        HEADER
    ========================================================== --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-7">

        <div>
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-2xl bg-[#EAF1EC] flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-[#6E8B74]" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M8 10h8m-8 4h5m6 1.5V6.5A2.5 2.5 0 0016.5 4h-9A2.5 2.5 0 005 6.5v11A2.5 2.5 0 007.5 20h6.5l4 2v-6.5z" />

                    </svg>
                </div>

                <div>
                    <h1 class="text-2xl font-bold text-[#1F2937]">
                        Detail Aduan
                    </h1>

                    <p class="text-sm text-gray-500 mt-0.5">
                        Lihat detail laporan dan berikan tanggapan.
                    </p>
                </div>
            </div>
        </div>


        {{-- TOMBOL KEMBALI --}}
        <a href="{{ route('admin.aduan.index') }}" class="inline-flex items-center justify-center gap-2
                   bg-white hover:bg-gray-50
                   border border-gray-200
                   text-gray-700
                   px-5 py-2.5
                   rounded-xl
                   transition
                   text-sm font-semibold
                   shadow-sm">

            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">

                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />

            </svg>

            Kembali

        </a>

    </div>


    {{-- =========================================================
        VALIDASI / ERROR
    ========================================================== --}}
    @if($errors->any())

    <div class="bg-red-50 border border-red-200 rounded-2xl px-5 py-4 mb-6">

        <div class="flex items-start gap-3">

            <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-600" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">

                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v3m0 4h.01M10.29 3.86l-7.18 12A2 2 0 004.82 19h14.36a2 2 0 001.71-3.14l-7.18-12a2 2 0 00-3.42 0z" />

                </svg>
            </div>

            <div>
                <p class="font-semibold text-red-700 text-sm">
                    Terjadi kesalahan
                </p>

                <ul class="list-disc list-inside text-sm text-red-600 mt-1 space-y-1">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>

        </div>

    </div>

    @endif


    @if(session('error'))

    <div class="bg-red-50 border border-red-200 text-red-700 rounded-2xl px-5 py-4 mb-6 text-sm">
        {{ session('error') }}
    </div>

    @endif


    {{-- =========================================================
        DETAIL ADUAN
    ========================================================== --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">


        {{-- =====================================================
            KOLOM KIRI
        ====================================================== --}}
        <div class="lg:col-span-2 space-y-6">


            {{-- INFORMASI ADUAN --}}
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">

                {{-- HEADER CARD --}}
                <div class="px-7 py-6 border-b border-gray-100">

                    <div class="flex items-center justify-between gap-4">

                        <div>
                            <h2 class="text-lg font-bold text-[#1F2937]">
                                Informasi Aduan
                            </h2>

                            <p class="text-sm text-gray-500 mt-1">
                                Detail laporan yang disampaikan penghuni.
                            </p>
                        </div>


                        {{-- STATUS --}}
                        @if($aduan->status === 'baru')

                        <span class="shrink-0 inline-flex items-center gap-1.5
                                     px-3 py-1.5
                                     rounded-full
                                     bg-blue-50
                                     text-blue-700
                                     text-xs font-semibold">

                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                            Baru

                        </span>

                        @elseif($aduan->status === 'diproses')

                        <span class="shrink-0 inline-flex items-center gap-1.5
                                     px-3 py-1.5
                                     rounded-full
                                     bg-yellow-50
                                     text-yellow-700
                                     text-xs font-semibold">

                            <span class="w-1.5 h-1.5 rounded-full bg-yellow-500"></span>
                            Diproses

                        </span>

                        @elseif($aduan->status === 'selesai')

                        <span class="shrink-0 inline-flex items-center gap-1.5
                                     px-3 py-1.5
                                     rounded-full
                                     bg-green-50
                                     text-green-700
                                     text-xs font-semibold">

                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                            Selesai

                        </span>

                        @endif

                    </div>

                </div>


                {{-- ISI INFORMASI --}}
                <div class="p-7 space-y-6">

                    {{-- PENGHUNI + TANGGAL --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                        {{-- NAMA --}}
                        <div class="bg-[#F8FAF8] rounded-2xl p-5">

                            <div class="flex items-center gap-3 mb-3">

                                <div class="w-9 h-9 rounded-xl bg-white flex items-center justify-center shadow-sm">

                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-[#6E8B74]" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">

                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                            d="M15 19a3 3 0 00-6 0m9-9a3 3 0 11-6 0 3 3 0 016 0zm-9 9a3 3 0 016 0" />

                                    </svg>

                                </div>

                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">
                                    Nama Penghuni
                                </p>

                            </div>

                            <p class="text-base font-bold text-[#1F2937]">
                                {{ $aduan->nama }}
                            </p>

                        </div>


                        {{-- TANGGAL --}}
                        <div class="bg-[#F8FAF8] rounded-2xl p-5">

                            <div class="flex items-center gap-3 mb-3">

                                <div class="w-9 h-9 rounded-xl bg-white flex items-center justify-center shadow-sm">

                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-[#6E8B74]" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">

                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                            d="M8 7V3m8 4V3m-9 8h10m-9 9h10a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v11a2 2 0 002 2z" />

                                    </svg>

                                </div>

                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">
                                    Tanggal Aduan
                                </p>

                            </div>

                            <p class="text-base font-bold text-[#1F2937]">
                                {{ $aduan->tanggal }}
                            </p>

                        </div>

                    </div>


                    {{-- ISI ADUAN --}}
                    <div>

                        <p class="text-sm font-semibold text-gray-600 mb-2">
                            Isi Aduan
                        </p>

                        <div class="bg-gray-50 border border-gray-100 rounded-2xl p-5">

                            <p class="text-sm text-gray-700 leading-7 whitespace-pre-line">
                                {{ $aduan->isi_aduan }}
                            </p>

                        </div>

                    </div>


                    {{-- FOTO ADUAN --}}
                    @if($aduan->foto_aduan)

                    <div>

                        <div class="flex items-center justify-between mb-3">

                            <p class="text-sm font-semibold text-gray-600">
                                Foto Aduan
                            </p>

                            <span class="text-xs text-gray-400">
                                Klik foto untuk memperbesar
                            </span>

                        </div>


                        {{-- THUMBNAIL --}}
                        <div class="relative w-full sm:w-72 h-52 rounded-2xl overflow-hidden
                                    border border-gray-200 cursor-pointer group" onclick="openFotoAduan()">

                            <img src="{{ asset('storage/' . $aduan->foto_aduan) }}" alt="Foto Aduan" class="w-full h-full object-cover
                                       group-hover:scale-105
                                       transition-transform duration-300">

                            {{-- OVERLAY --}}
                            <div class="absolute inset-0 bg-black/0
                                        group-hover:bg-black/30
                                        transition
                                        flex items-center justify-center">

                                <div class="opacity-0 group-hover:opacity-100
                                            transition
                                            bg-white/90
                                            rounded-full
                                            w-11 h-11
                                            flex items-center justify-center">

                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-700" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">

                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 15l6 6m-4-10a6 6 0 11-12 0 6 6 0 0112 0z" />

                                    </svg>

                                </div>

                            </div>

                        </div>

                    </div>

                    @endif

                </div>

            </div>


            {{-- =================================================
                FORM TANGGAPAN
            ================================================== --}}
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">

                <div class="px-7 py-6 border-b border-gray-100">

                    <h2 class="text-lg font-bold text-[#1F2937]">
                        Tanggapan Admin
                    </h2>

                    <p class="text-sm text-gray-500 mt-1">
                        Perbarui status dan berikan tanggapan kepada penghuni.
                    </p>

                </div>


                <form action="{{ route('admin.aduan.update', $aduan->id_aduan) }}" method="POST" class="p-7">

                    @csrf
                    @method('PUT')


                    {{-- STATUS --}}
                    <div class="mb-5">

                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Status Aduan
                        </label>

                        <select name="status" class="w-full border border-gray-200 bg-gray-50
                                   rounded-2xl px-4 py-3
                                   text-sm text-gray-700
                                   focus:outline-none
                                   focus:ring-2
                                   focus:ring-[#6E8B74]/30
                                   focus:border-[#6E8B74]
                                   transition" required>

                            <option value="baru" {{ old('status', $aduan->status) == 'baru' ? 'selected' : '' }}>
                                Baru
                            </option>

                            <option value="diproses"
                                {{ old('status', $aduan->status) == 'diproses' ? 'selected' : '' }}>
                                Diproses
                            </option>

                            <option value="selesai" {{ old('status', $aduan->status) == 'selesai' ? 'selected' : '' }}>
                                Selesai
                            </option>

                        </select>

                    </div>


                    {{-- TANGGAPAN --}}
                    <div class="mb-6">

                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Tanggapan Admin
                        </label>

                        <textarea name="tanggapan_admin" rows="6" required
                            placeholder="Tulis tanggapan untuk penghuni..." class="w-full border border-gray-200 bg-gray-50
                                   rounded-2xl px-4 py-3
                                   text-sm text-gray-700
                                   placeholder-gray-400
                                   focus:outline-none
                                   focus:ring-2
                                   focus:ring-[#6E8B74]/30
                                   focus:border-[#6E8B74]
                                   transition
                                   resize-none">{{ old('tanggapan_admin', $aduan->tanggapan_admin) }}</textarea>

                    </div>


                    {{-- TOMBOL --}}
                    <div class="flex justify-end">

                        <button type="submit" class="inline-flex items-center justify-center gap-2
                                   bg-[#6E8B74]
                                   hover:bg-[#5c7764]
                                   text-white
                                   px-6 py-3
                                   rounded-xl
                                   transition
                                   text-sm font-semibold
                                   shadow-sm">

                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 20 20"
                                stroke="currentColor">



                            </svg>

                            Simpan Tanggapan

                        </button>

                    </div>

                </form>

            </div>

        </div>


        {{-- =====================================================
            KOLOM KANAN
        ====================================================== --}}
        <div class="space-y-6">

            {{-- RINGKASAN --}}
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">

                <h3 class="font-bold text-[#1F2937]">
                    Ringkasan
                </h3>

                <p class="text-sm text-gray-500 mt-1">
                    Status penanganan aduan.
                </p>


                <div class="mt-5 space-y-4">

                    {{-- STATUS --}}
                    <div class="flex items-center justify-between py-3 border-b border-gray-100">

                        <span class="text-sm text-gray-500">
                            Status
                        </span>

                        @if($aduan->status === 'baru')

                        <span class="text-xs font-semibold text-blue-700 bg-blue-50 px-3 py-1.5 rounded-full">
                            Baru
                        </span>

                        @elseif($aduan->status === 'diproses')

                        <span class="text-xs font-semibold text-yellow-700 bg-yellow-50 px-3 py-1.5 rounded-full">
                            Diproses
                        </span>

                        @else

                        <span class="text-xs font-semibold text-green-700 bg-green-50 px-3 py-1.5 rounded-full">
                            Selesai
                        </span>

                        @endif

                    </div>


                    {{-- PENGHUNI --}}
                    <div class="flex items-center justify-between py-3 border-b border-gray-100">

                        <span class="text-sm text-gray-500">
                            Penghuni
                        </span>

                        <span class="text-sm font-semibold text-[#1F2937] text-right">
                            {{ $aduan->nama }}
                        </span>

                    </div>


                    {{-- TANGGAL --}}
                    <div class="flex items-center justify-between py-3">

                        <span class="text-sm text-gray-500">
                            Tanggal
                        </span>

                        <span class="text-sm font-semibold text-[#1F2937]">
                            {{ $aduan->tanggal }}
                        </span>

                    </div>

                </div>

            </div>


            {{-- INFO --}}
            <div class="bg-[#F3F7F4] rounded-3xl p-6 border border-[#E1EAE3]">

                <div class="flex gap-3">

                    <div class="w-9 h-9 rounded-xl bg-white flex items-center justify-center shrink-0">

                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-[#6E8B74]" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M13 16h-1v-4h-1m1-4h.01M12 21a9 9 0 100-18 9 9 0 000 18z" />

                        </svg>

                    </div>

                    <div>

                        <p class="font-semibold text-[#1F2937] text-sm">
                            Informasi
                        </p>

                        <p class="text-xs text-gray-500 leading-5 mt-1">
                            Pastikan status dan tanggapan sudah sesuai sebelum menyimpan perubahan.
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


{{-- =========================================================
    MODAL FOTO
========================================================= --}}
@if($aduan->foto_aduan)

<div id="fotoAduanModal" class="hidden fixed inset-0 bg-black/80 z-50
           flex items-center justify-center p-4" onclick="closeFotoAduan()">

    {{-- WRAPPER FOTO --}}
    <div class="relative max-w-full max-h-[90vh]" onclick="event.stopPropagation()">

        {{-- FOTO --}}
        <img src="{{ asset('storage/' . $aduan->foto_aduan) }}" alt="Foto Aduan" class="max-w-full max-h-[90vh]
                   object-contain
                   rounded-2xl
                   shadow-2xl">


        {{-- X DI DALAM FOTO --}}
        <button type="button" onclick="closeFotoAduan()" class="absolute top-3 right-3
                   w-10 h-10
                   rounded-full
                   bg-black/60
                   hover:bg-black/80
                   text-white
                   flex items-center justify-center
                   transition
                   z-50">

            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">

                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />

            </svg>

        </button>

    </div>

</div>

@endif


{{-- =========================================================
    SCRIPT
========================================================= --}}
@if($aduan->foto_aduan)

<script>
function openFotoAduan() {

    document
        .getElementById('fotoAduanModal')
        .classList.remove('hidden');

    document.body.classList.add('overflow-hidden');

}


function closeFotoAduan() {

    document
        .getElementById('fotoAduanModal')
        .classList.add('hidden');

    document.body.classList.remove('overflow-hidden');

}


// Tutup dengan tombol ESC
document.addEventListener('keydown', function(event) {

    if (event.key === 'Escape') {
        closeFotoAduan();
    }

});
</script>

@endif

@endsection