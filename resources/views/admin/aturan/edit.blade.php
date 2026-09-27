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
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.5-8.5a2.121 2.121 0 013 3L12 14l-4 1 1-4 8.5-8.5z" />

                </svg>

            </div>

            <div>
                <h1 class="text-2xl font-bold text-[#0F0937]">
                    Edit Aturan Kos
                </h1>

                <p class="text-sm text-gray-500 mt-1">
                    Perbarui aturan kost yang sudah ada.
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
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.5-8.5a2.121 2.121 0 013 3L12 14l-4 1 1-4 8.5-8.5z" />

                    </svg>

                </div>

                <div>

                    <h2 class="text-lg font-bold text-[#1F2937]">
                        Informasi Aturan
                    </h2>

                    <p class="text-sm text-gray-500 mt-0.5">
                        Ubah isi aturan sesuai kebutuhan.
                    </p>

                </div>

            </div>

        </div>


        {{-- FORM --}}
        <form action="{{ route('admin.aturan.update', $aturan->id) }}" method="POST" class="p-7">

            @csrf
            @method('PUT')


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


                <textarea id="isi_aturan" name="isi_aturan" rows="7" required placeholder="Masukkan aturan kost..."
                    class="w-full
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
                           resize-none">{{ old('isi_aturan', $aturan->isi) }}</textarea>


                <div class="flex items-center gap-2 mt-2">

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 shrink-0" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M13 16h-1v-4h-1m1-4h.01M12 21a9 9 0 100-18 9 9 0 000-18 9 9 0 000 18z" />

                    </svg>

                    <p class="text-xs text-gray-400">
                        Pastikan aturan yang diperbarui sudah sesuai sebelum disimpan.
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


                {{-- UPDATE --}}
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

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h5m4-14l3 3m0 0l-8 8-4 1 1-4 8-8z" />

                    </svg>

                    Update Aturan

                </button>

            </div>

        </form>

    </div>

</div>

@endsection