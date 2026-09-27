{{-- ========================================================= --}}
{{-- resources/views/superadmin/fasilitas/form.blade.php --}}
{{-- ========================================================= --}}

@extends('layouts.superadmin')

@section('content')

<div class="p-6 bg-[#FCFAF6] min-h-full">

    {{-- =========================================================
        HEADER
    ========================================================== --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-7">

        <div>

            <h1 class="text-3xl font-bold text-[#0F0937]">
                {{ $item->exists ? 'Edit Fasilitas' : 'Tambah Fasilitas' }}
            </h1>

            <p class="text-sm text-gray-500 mt-2">
                {{ $item->exists
                    ? 'Perbarui data fasilitas kost yang sudah tersedia.'
                    : 'Tambahkan fasilitas baru untuk digunakan admin kost.' }}
            </p>

        </div>


        <a href="{{ route('superadmin.fasilitas.index') }}" class="inline-flex items-center justify-center
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


    {{-- =========================================================
        CONTENT
    ========================================================== --}}
    <div class="max-w-3xl">

        <div class="bg-white
                   rounded-3xl
                   border border-[#E9E7E1]
                   shadow-sm
                   overflow-hidden">

            {{-- =================================================
                CARD HEADER
            ================================================== --}}
            <div class="px-7 py-6
                       border-b border-gray-100
                       bg-[#FBFAF7]">

                <p class="text-xs font-semibold text-[#8A8D82] uppercase tracking-wide">
                    Master Fasilitas
                </p>

                <h2 class="text-lg font-bold text-[#0F0937] mt-2">
                    {{ $item->exists ? 'Perbarui Fasilitas' : 'Fasilitas Baru' }}
                </h2>

                <p class="text-sm text-gray-400 mt-1">
                    Isi nama fasilitas yang ingin ditambahkan ke master data.
                </p>

            </div>


            {{-- =================================================
                FORM
            ================================================== --}}
            <div class="p-7">

                <form method="POST" action="{{ $item->exists
                        ? route('superadmin.fasilitas.update', $item)
                        : route('superadmin.fasilitas.store') }}" class="space-y-7">

                    @csrf

                    @if($item->exists)
                    @method('PUT')
                    @endif


                    {{-- =================================================
                        NAMA FASILITAS
                    ================================================== --}}
                    <div>

                        <label for="nama_fasilitas" class="block text-sm font-semibold text-[#0F0937] mb-2">
                            Nama Fasilitas
                        </label>

                        <p class="text-xs text-gray-400 mb-3">
                            Masukkan nama fasilitas yang akan tersedia pada pilihan fasilitas kost.
                        </p>


                        <input id="nama_fasilitas" type="text" name="nama_fasilitas"
                            value="{{ old('nama_fasilitas', $item->nama_fasilitas) }}"
                            placeholder="Contoh: AC, WiFi, Kamar Mandi Dalam" autocomplete="off" class="w-full
                                   bg-[#FAFAF8]
                                   border border-gray-200
                                   rounded-2xl
                                   px-4 py-3.5
                                   text-sm
                                   text-[#0F0937]
                                   placeholder-gray-400
                                   outline-none
                                   focus:bg-white
                                   focus:border-[#A5AA98]
                                   focus:ring-4
                                   focus:ring-[#EEF0EA]
                                   transition">


                        @error('nama_fasilitas')

                        <p class="mt-2 text-xs text-red-500">
                            {{ $message }}
                        </p>

                        @enderror

                    </div>


                    {{-- =================================================
                        CONTOH
                    ================================================== --}}
                    <div class="rounded-2xl
                               bg-[#F8F6F1]
                               border border-[#ECE8DD]
                               px-5 py-4">

                        <p class="text-xs font-semibold text-[#777C6D]">
                            Contoh fasilitas
                        </p>

                        <p class="text-xs text-gray-500 mt-2 leading-5">
                            AC, WiFi, Kamar Mandi Dalam, Lemari, Meja Belajar,
                            Kasur, Parkir, CCTV, atau fasilitas lainnya.
                        </p>

                    </div>


                    {{-- =================================================
                        BUTTON
                    ================================================== --}}
                    <div class="flex flex-col-reverse sm:flex-row
                               sm:justify-end
                               gap-3
                               pt-2">

                        <a href="{{ route('superadmin.fasilitas.index') }}" class="inline-flex
                                   items-center
                                   justify-center
                                   px-6 py-3
                                   rounded-xl
                                   bg-gray-100
                                   hover:bg-gray-200
                                   text-gray-600
                                   text-sm
                                   font-semibold
                                   transition">
                            Batal
                        </a>


                        <button type="submit" class="inline-flex
                                   items-center
                                   justify-center
                                   px-6 py-3
                                   rounded-xl
                                   bg-[#7A806F]
                                   hover:bg-[#686D60]
                                   text-white
                                   text-sm
                                   font-semibold
                                   transition">
                            {{ $item->exists
                                ? 'Update Fasilitas'
                                : 'Simpan Fasilitas' }}
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection