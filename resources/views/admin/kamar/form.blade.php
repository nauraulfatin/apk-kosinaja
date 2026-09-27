@extends('layouts.admin')

@section('content')

<div class="p-6">

    {{-- ========================================================= --}}
    {{-- HEADER --}}
    {{-- ========================================================= --}}

    <div class="flex items-center gap-4 mb-8">

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

                {{ $item->exists ? 'Edit Kamar' : 'Tambah Kamar' }}

            </h1>

            <p class="text-gray-500 mt-1.5 text-sm">

                {{ $item->exists
                    ? 'Perbarui informasi kamar kost'
                    : 'Tambahkan kamar baru ke kost anda'
                }}

            </p>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- FORM --}}
    {{-- ========================================================= --}}

    <form method="POST" action="{{ $item->exists
            ? route('admin.kamar.update', $item)
            : route('admin.kamar.store')
        }}" enctype="multipart/form-data" class="space-y-6">

        @csrf

        @if($item->exists)
        @method('PUT')
        @endif


        {{-- ========================================================= --}}
        {{-- INFORMASI KAMAR --}}
        {{-- ========================================================= --}}

        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">

            <div class="px-6 py-5 border-b border-gray-100">

                <div class="flex items-center gap-3">

                    <div class="w-10 h-10 rounded-xl bg-[#EEF4EF] flex items-center justify-center">

                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-[#6C8B6B]" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M4 21V5a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v16" />
                            <path d="M8 7h8" />
                            <path d="M8 11h8" />
                            <path d="M8 15h5" />
                        </svg>

                    </div>

                    <div>

                        <h2 class="font-bold text-[#0F0937]">
                            Informasi Kamar
                        </h2>

                        <p class="text-xs text-gray-400 mt-0.5">
                            Masukkan informasi dasar kamar
                        </p>

                    </div>

                </div>

            </div>


            <div class="p-6">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                    {{-- NAMA KAMAR --}}

                    <div>

                        <label for="nama_kamar" class="block text-sm font-semibold text-gray-700 mb-2">
                            Nama Kamar
                            <span class="text-red-500">*</span>
                        </label>

                        <input type="text" id="nama_kamar" name="nama_kamar"
                            value="{{ old('nama_kamar', $item->nama_kamar) }}" class="w-full rounded-2xl
                                   border border-gray-200
                                   bg-[#FAFBFA]
                                   px-4 py-3
                                   text-sm text-gray-700
                                   placeholder:text-gray-400
                                   focus:outline-none
                                   focus:border-[#6C8B6B]
                                   focus:ring-2
                                   focus:ring-[#6C8B6B]/20
                                   transition" placeholder="Contoh: Kamar A" required>

                        @error('nama_kamar')
                        <p class="text-red-500 text-xs mt-2">
                            {{ $message }}
                        </p>
                        @enderror

                    </div>


                    {{-- NOMOR KAMAR --}}

                    <div>

                        <label for="nomor_kamar" class="block text-sm font-semibold text-gray-700 mb-2">
                            Nomor Kamar
                            <span class="text-red-500">*</span>
                        </label>

                        <input type="text" id="nomor_kamar" name="nomor_kamar"
                            value="{{ old('nomor_kamar', $item->nomor_kamar) }}" class="w-full rounded-2xl
                                   border border-gray-200
                                   bg-[#FAFBFA]
                                   px-4 py-3
                                   text-sm text-gray-700
                                   placeholder:text-gray-400
                                   focus:outline-none
                                   focus:border-[#6C8B6B]
                                   focus:ring-2
                                   focus:ring-[#6C8B6B]/20
                                   transition" placeholder="Contoh: A01" required>

                        @error('nomor_kamar')
                        <p class="text-red-500 text-xs mt-2">
                            {{ $message }}
                        </p>
                        @enderror

                    </div>


                    {{-- UKURAN KAMAR --}}

                    <div class="md:col-span-2">

                        <label for="ukuran_kamar" class="block text-sm font-semibold text-gray-700 mb-2">
                            Ukuran Kamar
                        </label>

                        <input type="text" id="ukuran_kamar" name="ukuran_kamar"
                            value="{{ old('ukuran_kamar', $item->ukuran_kamar) }}" class="w-full rounded-2xl
                                   border border-gray-200
                                   bg-[#FAFBFA]
                                   px-4 py-3
                                   text-sm text-gray-700
                                   placeholder:text-gray-400
                                   focus:outline-none
                                   focus:border-[#6C8B6B]
                                   focus:ring-2
                                   focus:ring-[#6C8B6B]/20
                                   transition" placeholder="Contoh: 3 x 4 meter">

                        @error('ukuran_kamar')
                        <p class="text-red-500 text-xs mt-2">
                            {{ $message }}
                        </p>
                        @enderror

                    </div>

                </div>

            </div>

        </div>


        {{-- ========================================================= --}}
        {{-- FASILITAS --}}
        {{-- ========================================================= --}}

        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">

            <div class="px-6 py-5 border-b border-gray-100">

                <div class="flex items-center gap-3">

                    <div class="w-10 h-10 rounded-xl bg-[#EEF4EF] flex items-center justify-center">

                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-[#6C8B6B]" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M12 3v18" />
                            <path d="M3 12h18" />
                            <path d="M5.6 5.6l12.8 12.8" />
                            <path d="M18.4 5.6L5.6 18.4" />
                        </svg>

                    </div>

                    <div>

                        <h2 class="font-bold text-[#0F0937]">
                            Fasilitas Kamar
                        </h2>

                        <p class="text-xs text-gray-400 mt-0.5">
                            Pilih fasilitas yang tersedia di kamar ini
                        </p>

                    </div>

                </div>

            </div>


            <div class="p-6">

                @php
                $selectedFasilitas = old(
                'fasilitas',
                $selected ?? []
                );
                @endphp


                @if($fasilitas->count())

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">

                    @foreach($fasilitas as $fasilitasItem)

                    <label class="group flex items-center gap-3
                                       p-4 rounded-2xl
                                       border border-gray-200
                                       bg-[#FAFBFA]
                                       hover:border-[#B8CBB9]
                                       hover:bg-[#F4F8F4]
                                       cursor-pointer
                                       transition-all">

                        <input type="checkbox" name="fasilitas[]" value="{{ $fasilitasItem->id_fasilitas }}" class="w-4 h-4 rounded
                                           border-gray-300
                                           text-[#6C8B6B]
                                           focus:ring-[#6C8B6B]" {{ in_array(
                                        $fasilitasItem->id_fasilitas,
                                        $selectedFasilitas
                                    ) ? 'checked' : '' }}>

                        <span class="text-sm font-medium text-gray-700">
                            {{ $fasilitasItem->nama_fasilitas }}
                        </span>

                    </label>

                    @endforeach

                </div>

                @else

                <div class="rounded-2xl bg-[#F8F9F8] border border-gray-100 p-5">

                    <div class="flex items-center gap-3">

                        <div class="w-10 h-10 rounded-xl bg-gray-100 flex items-center justify-center">

                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="1.8">
                                <circle cx="12" cy="12" r="9" />
                                <path d="M12 8v4" />
                                <path d="M12 16h.01" />
                            </svg>

                        </div>

                        <p class="text-sm text-gray-500">
                            Belum ada data fasilitas.
                        </p>

                    </div>

                </div>

                @endif


                @error('fasilitas')
                <p class="text-red-500 text-xs mt-2">
                    {{ $message }}
                </p>
                @enderror

            </div>

        </div>


        {{-- ========================================================= --}}
        {{-- FOTO KAMAR --}}
        {{-- ========================================================= --}}

        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">

            <div class="px-6 py-5 border-b border-gray-100">

                <div class="flex items-center gap-3">

                    <div class="w-10 h-10 rounded-xl bg-[#EEF4EF] flex items-center justify-center">

                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-[#6C8B6B]" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                            stroke-linejoin="round">
                            <rect x="3" y="3" width="18" height="18" rx="2" />
                            <circle cx="8.5" cy="8.5" r="1.5" />
                            <path d="M21 15l-5-5L5 21" />
                        </svg>

                    </div>

                    <div>

                        <h2 class="font-bold text-[#0F0937]">
                            Foto Kamar
                        </h2>

                        <p class="text-xs text-gray-400 mt-0.5">
                            Tambahkan foto untuk memperjelas kondisi kamar
                        </p>

                    </div>

                </div>

            </div>


            <div class="p-6">

                <label for="foto_kamar" class="flex flex-col items-center justify-center
                           w-full min-h-[170px]
                           rounded-2xl
                           border-2 border-dashed border-gray-200
                           bg-[#FAFBFA]
                           hover:bg-[#F4F8F4]
                           hover:border-[#AFC3B0]
                           cursor-pointer
                           transition-all">

                    <div class="w-12 h-12 rounded-2xl bg-[#EEF4EF]
                                flex items-center justify-center mb-3">

                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-[#6C8B6B]" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M12 16V4" />
                            <path d="M7 9l5-5 5 5" />
                            <path d="M5 20h14" />
                        </svg>

                    </div>

                    <span class="text-sm font-semibold text-gray-700">
                        Pilih Foto
                    </span>

                    <span class="text-xs text-gray-400 mt-1">
                        Bisa memilih lebih dari satu foto
                    </span>

                </label>


                <input type="file" id="foto_kamar" name="foto_kamar[]" accept="image/jpeg,image/png,image/webp" multiple
                    class="hidden">


                {{-- JUMLAH FOTO --}}

                <div id="jumlah-foto" class="flex items-center gap-2
                           mt-5
                           text-sm text-gray-500">

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="1.8">
                        <rect x="3" y="3" width="18" height="18" rx="2" />
                        <circle cx="8.5" cy="8.5" r="1.5" />
                    </svg>

                    Belum ada foto dipilih

                </div>


                {{-- PREVIEW FOTO BARU --}}

                <div id="preview-foto" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 mt-5"></div>


                <div class="mt-4 flex items-start gap-2">

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 mt-0.5 flex-shrink-0"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <circle cx="12" cy="12" r="9" />
                        <path d="M12 8v4" />
                        <path d="M12 16h.01" />
                    </svg>

                    <p class="text-xs text-gray-400">
                        Format JPG, JPEG, PNG, atau WEBP. Maksimal 5MB per foto.
                    </p>

                </div>


                @error('foto_kamar')
                <p class="text-red-500 text-xs mt-2">
                    {{ $message }}
                </p>
                @enderror

                @error('foto_kamar.*')
                <p class="text-red-500 text-xs mt-2">
                    {{ $message }}
                </p>
                @enderror


                {{-- FOTO LAMA --}}

                @if($item->exists && !empty($item->foto_kamar))

                <div class="mt-8 pt-6 border-t border-gray-100">

                    <div class="flex items-center justify-between mb-4">

                        <div>

                            <h3 class="text-sm font-bold text-gray-700">
                                Foto Saat Ini
                            </h3>

                            <p class="text-xs text-gray-400 mt-1">
                                Foto yang sudah tersimpan pada kamar
                            </p>

                        </div>

                        <span class="text-xs font-semibold
                                         px-3 py-1.5 rounded-full
                                         bg-[#EEF4EF] text-[#6C8B6B]">

                            {{ count($item->foto_kamar) }} foto

                        </span>

                    </div>


                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">

                        @foreach($item->foto_kamar as $index => $foto)

                        <div class="relative group rounded-2xl overflow-hidden border border-gray-200 bg-gray-100">

                            <img src="{{ asset('storage/'.$foto) }}" class="w-full h-36 object-cover
                                               group-hover:scale-105
                                               transition-transform duration-300" alt="Foto Kamar">


                            @if($index == 0)

                            <span class="absolute top-2 left-2
                                                   bg-[#6C8B6B]
                                                   text-white
                                                   text-[10px]
                                                   font-semibold
                                                   px-2.5 py-1
                                                   rounded-full
                                                   shadow-sm">
                                Foto Utama
                            </span>

                            @endif

                        </div>

                        @endforeach

                    </div>

                </div>

                @endif

            </div>

        </div>


        {{-- ========================================================= --}}
        {{-- BUTTON --}}
        {{-- ========================================================= --}}

        <div class="flex flex-col-reverse sm:flex-row
                    items-stretch sm:items-center
                    justify-end gap-3
                    pt-2">

            <a href="{{ route('admin.kamar.index') }}" class="inline-flex items-center justify-center gap-2
                       px-5 py-3 rounded-2xl
                       border border-gray-200
                       bg-white
                       text-gray-600
                       hover:bg-gray-50
                       text-sm font-semibold
                       transition">

                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 12H5" />
                    <path d="M12 19l-7-7 7-7" />
                </svg>

                Batal

            </a>


            <button type="submit" class="inline-flex items-center justify-center gap-2
                       px-5 py-3 rounded-2xl
                       bg-[#6C8B6B]
                       hover:bg-[#5B765A]
                       text-white
                       text-sm font-semibold
                       shadow-sm hover:shadow-md
                       transition-all">

                @if($item->exists)

                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2Z" />
                    <polyline points="17 21 17 13 7 13 7 21" />
                    <polyline points="7 3 7 8 15 8" />
                </svg>

                Update Kamar

                @else

                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 5v14" />
                    <path d="M5 12h14" />
                </svg>

                Simpan Kamar

                @endif

            </button>

        </div>

    </form>

</div>


{{-- ========================================================= --}}
{{-- JAVASCRIPT FOTO --}}
{{-- ========================================================= --}}

<script>
let daftarFoto = [];

const inputFoto = document.getElementById('foto_kamar');
const preview = document.getElementById('preview-foto');
const jumlah = document.getElementById('jumlah-foto');


inputFoto.addEventListener('change', function() {

    Array.from(this.files).forEach(file => {

        if (
            file.type === 'image/jpeg' ||
            file.type === 'image/png' ||
            file.type === 'image/webp'
        ) {

            // Hindari file yang sama masuk dua kali
            const sudahAda = daftarFoto.some(existingFile =>
                existingFile.name === file.name &&
                existingFile.size === file.size &&
                existingFile.lastModified === file.lastModified
            );

            if (!sudahAda) {
                daftarFoto.push(file);
            }

        }

    });

    sinkronFile();
    updatePreview();

});


function updatePreview() {

    preview.innerHTML = '';

    jumlah.innerHTML = daftarFoto.length ?
        `
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="w-4 h-4 text-[#6C8B6B]"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="1.8"
            >
                <rect x="3" y="3" width="18" height="18" rx="2"/>
                <circle cx="8.5" cy="8.5" r="1.5"/>
            </svg>

            ${daftarFoto.length} foto dipilih
        ` :
        `
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="w-4 h-4 text-gray-400"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="1.8"
            >
                <rect x="3" y="3" width="18" height="18" rx="2"/>
                <circle cx="8.5" cy="8.5" r="1.5"/>
            </svg>

            Belum ada foto dipilih
        `;


    daftarFoto.forEach((file, index) => {

        const reader = new FileReader();

        reader.onload = function(e) {

            const wrapper = document.createElement('div');

            wrapper.className =
                'relative group rounded-2xl overflow-hidden border border-gray-200 bg-gray-100';


            wrapper.innerHTML = `

                <img
                    src="${e.target.result}"
                    class="w-full h-36 object-cover
                           group-hover:scale-105
                           transition-transform duration-300"
                    alt="Preview Foto"
                >


                ${index === 0 ? `
                    <span
                        class="absolute top-2 left-2
                               bg-[#6C8B6B]
                               text-white
                               text-[10px]
                               font-semibold
                               px-2.5 py-1
                               rounded-full"
                    >
                        Foto Utama
                    </span>
                ` : ''}


                <button
                    type="button"
                    onclick="hapusFoto(${index})"
                    class="absolute top-2 right-2
                           w-8 h-8
                           rounded-full
                           bg-red-500
                           hover:bg-red-600
                           text-white
                           flex items-center justify-center
                           shadow-md
                           transition"
                    title="Hapus foto"
                >

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="w-4 h-4"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path d="M6 6l12 12"/>
                        <path d="M18 6L6 18"/>
                    </svg>

                </button>

            `;


            preview.appendChild(wrapper);

        };

        reader.readAsDataURL(file);

    });

}


function hapusFoto(index) {

    daftarFoto.splice(index, 1);

    sinkronFile();
    updatePreview();

}


function sinkronFile() {

    const dataTransfer = new DataTransfer();

    daftarFoto.forEach(file => {
        dataTransfer.items.add(file);
    });

    inputFoto.files = dataTransfer.files;

}
</script>

@endsection