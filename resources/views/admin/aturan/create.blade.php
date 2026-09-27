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
                    Tambah Aturan Kos
                </h1>

                <p class="text-sm text-gray-500 mt-1">
                    Tambahkan aturan baru untuk penghuni kost.
                </p>
            </div>

        </div>


        {{-- KEMBALI --}}
        <a href="{{ route('admin.aturan.index') }}" class="inline-flex items-center justify-center gap-2
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
        FORM CARD
    ========================================================== --}}
    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden w-full">


        {{-- CARD HEADER --}}
        <div class="px-7 py-6 border-b border-gray-100">

            <div class="flex items-center gap-3">

                <div class="w-10 h-10 rounded-xl bg-[#F3F7F4]
                            flex items-center justify-center shrink-0">

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-[#6E8B74]" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />

                    </svg>

                </div>

                <div>

                    <h2 class="text-lg font-bold text-[#1F2937]">
                        Informasi Aturan
                    </h2>

                    <p class="text-sm text-gray-500 mt-0.5">
                        Masukkan aturan yang akan diberlakukan di kost.
                    </p>

                </div>

            </div>

        </div>


        {{-- FORM --}}
        <form action="{{ route('admin.aturan.store') }}" method="POST" class="p-7">

            @csrf


            {{-- ISI ATURAN --}}
            <div>

                <div class="flex items-center justify-between mb-2">

                    <label for="isi_aturan" class="block text-sm font-semibold text-gray-700">

                        Isi Aturan

                    </label>

                    <span class="text-xs text-gray-400">
                        Wajib diisi
                    </span>

                </div>


                <textarea id="isi_aturan" name="isi_aturan" rows="7" required
                    placeholder="Contoh: Penghuni wajib menjaga kebersihan kamar dan lingkungan kost." class="w-full
                           border border-gray-200
                           bg-gray-50
                           rounded-2xl
                           px-4 py-3
                           text-sm text-gray-700
                           placeholder-gray-400
                           focus:outline-none
                           focus:ring-2
                           focus:ring-[#6C8B6B]/30
                           focus:border-[#6C8B6B]
                           transition
                           resize-none">{{ old('isi_aturan') }}</textarea>


                <div class="flex items-center gap-2 mt-2">

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 shrink-0" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M13 16h-1v-4h-1m1-4h.01M12 21a9 9 0 100-18 9 9 0 000 18z" />

                    </svg>

                    <p class="text-xs text-gray-400">
                        Tuliskan aturan dengan jelas agar mudah dipahami penghuni.
                    </p>

                </div>

            </div>


            {{-- TOMBOL --}}
            <div class="flex flex-col-reverse sm:flex-row
                        sm:justify-end
                        gap-3
                        mt-8
                        pt-6
                        border-t border-gray-100">

                {{-- BATAL --}}
                <a href="{{ route('admin.aturan.index') }}" class="inline-flex items-center justify-center
                           px-6 py-3
                           rounded-xl
                           bg-gray-100
                           hover:bg-gray-200
                           text-gray-700
                           font-semibold
                           text-sm
                           transition">

                    Batal

                </a>


                {{-- SIMPAN --}}
                <button type="submit" class="inline-flex items-center justify-center gap-2
                           bg-[#6C8B6B]
                           hover:bg-[#5B765A]
                           text-white
                           px-7 py-3
                           rounded-xl
                           font-semibold
                           text-sm
                           transition
                           shadow-sm">

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />

                    </svg>

                    Simpan Aturan

                </button>

            </div>

        </form>

    </div>

</div>

@endsection