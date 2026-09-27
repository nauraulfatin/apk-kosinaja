{{-- ========================================================= --}}
{{-- resources/views/admin/kost/edit.blade.php --}}
{{-- ========================================================= --}}

@extends('layouts.admin')

@section('content')

<div class="p-6 space-y-6">

    {{-- =========================================================
        HEADER
    ========================================================== --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

        <div class="flex items-center gap-3">

            <div class="w-12 h-12 rounded-2xl bg-[#EAF1EC]
                        flex items-center justify-center shrink-0">

                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-[#6E8B74]" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">

                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h5m4-14l3 3m0 0l-8 8-4 1 1-4 8-8z" />

                </svg>

            </div>

            <div>

                <h1 class="text-2xl font-bold text-[#0F0937]">
                    Edit Informasi Kost
                </h1>

                <p class="text-sm text-gray-500 mt-1">
                    Lengkapi dan perbarui informasi kost Anda.
                </p>

            </div>

        </div>


        {{-- KEMBALI --}}
        <a href="{{ route('admin.kost.index') }}" class="inline-flex items-center justify-center gap-2
                   bg-white hover:bg-gray-50
                   border border-gray-200
                   text-gray-700
                   px-5 py-2.5
                   rounded-xl
                   font-semibold
                   text-sm
                   transition
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

    <div class="bg-red-50 border border-red-200
                    text-red-700 rounded-2xl px-6 py-4">

        <div class="flex items-start gap-3">

            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">

                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 9v4m0 4h.01M10.29 3.86l-8.18 14a2 2 0 001.73 3h16.32a2 2 0 001.73-3l-8.18-14a2 2 0 00-3.42 0z" />

            </svg>

            <div>

                <p class="font-semibold text-sm mb-2">
                    Terdapat kesalahan pada data:
                </p>

                <ul class="list-disc list-inside text-sm space-y-1">

                    @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        </div>

    </div>

    @endif


    @if(session('error'))

    <div class="bg-red-50 border border-red-200
                    text-red-700 rounded-2xl px-6 py-4 text-sm">

        {{ session('error') }}

    </div>

    @endif


    {{-- =========================================================
        FORM CARD
    ========================================================== --}}
    <div class="bg-white rounded-3xl
                border border-gray-100
                shadow-sm overflow-hidden">


        {{-- CARD HEADER --}}
        <div class="px-7 py-6 border-b border-gray-100">

            <div class="flex items-center gap-3">

                <div class="w-10 h-10 rounded-xl bg-[#F3F7F4]
                            flex items-center justify-center">

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-[#6E8B74]" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />

                    </svg>

                </div>

                <div>

                    <h2 class="text-lg font-bold text-[#0F0937]">
                        Informasi Kost
                    </h2>

                    <p class="text-sm text-gray-500 mt-1">
                        Perbarui data kost yang akan ditampilkan pada katalog.
                    </p>

                </div>

            </div>

        </div>


        {{-- =====================================================
            FORM
        ====================================================== --}}
        <form method="POST" enctype="multipart/form-data" action="{{ route('admin.kost.update') }}"
            class="p-7 space-y-8">

            @csrf
            @method('PUT')


            {{-- =================================================
                INFORMASI DASAR
            ================================================== --}}
            <div>

                <div class="flex items-center gap-2 mb-5">

                    <div class="w-8 h-8 rounded-lg bg-[#EAF1EC]
                                flex items-center justify-center">

                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-[#6E8B74]" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M13 16h-1v-4h-1m1-4h.01M12 21a9 9 0 100-18 9 9 0 000 18z" />

                        </svg>

                    </div>

                    <h3 class="text-base font-bold text-[#0F0937]">
                        Informasi Dasar
                    </h3>

                </div>


                {{-- NAMA KOST --}}
                <div class="mb-6">

                    <label for="nama_kost" class="block text-sm font-semibold text-gray-700 mb-2">

                        Nama Kost

                    </label>

                    <input type="text" id="nama_kost" name="nama_kost" value="{{ old('nama_kost', $kost->nama_kost) }}"
                        placeholder="Masukkan nama kost" class="w-full
                               bg-gray-50
                               border border-gray-200
                               rounded-xl
                               px-4 py-3
                               text-sm text-gray-700
                               placeholder-gray-400
                               focus:outline-none
                               focus:ring-2
                               focus:ring-[#6C8B6B]/30
                               focus:border-[#6C8B6B]
                               transition">

                </div>


                {{-- NOMOR WHATSAPP --}}
                <div class="mb-6">

                    <label for="no_hp" class="block text-sm font-semibold text-gray-700 mb-2">

                        Nomor WhatsApp

                    </label>

                    <input type="text" id="no_hp" name="no_hp" value="{{ old('no_hp', auth()->user()->no_hp) }}"
                        placeholder="08xxxxxxxxxx" class="w-full
                               bg-gray-50
                               border border-gray-200
                               rounded-xl
                               px-4 py-3
                               text-sm text-gray-700
                               placeholder-gray-400
                               focus:outline-none
                               focus:ring-2
                               focus:ring-[#6C8B6B]/30
                               focus:border-[#6C8B6B]
                               transition">

                    <p class="text-xs text-gray-400 mt-2">
                        Nomor ini akan ditampilkan pada katalog kost.
                    </p>

                </div>


                {{-- ALAMAT --}}
                <div class="mb-6">

                    <label for="alamat" class="block text-sm font-semibold text-gray-700 mb-2">

                        Alamat Kost

                    </label>

                    <textarea id="alamat" name="alamat" rows="4" placeholder="Masukkan alamat kost" class="w-full
                               bg-gray-50
                               border border-gray-200
                               rounded-xl
                               px-4 py-3
                               text-sm text-gray-700
                               placeholder-gray-400
                               focus:outline-none
                               focus:ring-2
                               focus:ring-[#6C8B6B]/30
                               focus:border-[#6C8B6B]
                               transition
                               resize-none">{{ old('alamat', $kost->alamat) }}</textarea>

                </div>


                {{-- DESKRIPSI --}}
                <div>

                    <label for="deskripsi" class="block text-sm font-semibold text-gray-700 mb-2">

                        Deskripsi Kost

                    </label>

                    <textarea id="deskripsi" name="deskripsi" rows="5" placeholder="Deskripsi kost..." class="w-full
                               bg-gray-50
                               border border-gray-200
                               rounded-xl
                               px-4 py-3
                               text-sm text-gray-700
                               placeholder-gray-400
                               focus:outline-none
                               focus:ring-2
                               focus:ring-[#6C8B6B]/30
                               focus:border-[#6C8B6B]
                               transition
                               resize-none">{{ old('deskripsi', $kost->deskripsi) }}</textarea>

                </div>

            </div>


            {{-- =================================================
                FASILITAS
            ================================================== --}}
            <div class="pt-2">

                <div class="flex items-center gap-2 mb-5">

                    <div class="w-8 h-8 rounded-lg bg-[#EAF1EC]
                                flex items-center justify-center">

                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-[#6E8B74]" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 12c0 5.591 3.824 10.29 9 11.622C17.176 22.29 21 17.591 21 12c0-1.317-.211-2.585-.602-3.762z" />

                        </svg>

                    </div>

                    <div>

                        <h3 class="text-base font-bold text-[#0F0937]">
                            Fasilitas Kost
                        </h3>

                        <p class="text-xs text-gray-400 mt-0.5">
                            Pilih fasilitas yang tersedia di kost.
                        </p>

                    </div>

                </div>


                <div class="grid grid-cols-1 md:grid-cols-2 gap-3
                            bg-[#F8FAF8]
                            border border-gray-100
                            rounded-2xl p-5">

                    @foreach($fasilitas as $f)

                    <label class="flex items-center gap-3
                                   bg-white
                                   rounded-xl
                                   px-4 py-3
                                   border border-gray-100
                                   hover:border-[#6C8B6B]
                                   hover:bg-[#FAFCFA]
                                   cursor-pointer
                                   transition">

                        <input type="checkbox" name="fasilitas[]" value="{{ $f->id_fasilitas }}" @checked(
                            $kost->fasilitas->contains(
                        'id_fasilitas',
                        $f->id_fasilitas
                        )
                        )

                        class="w-4 h-4
                        rounded
                        border-gray-300
                        text-[#6C8B6B]
                        focus:ring-[#6C8B6B]"
                        >

                        <span class="text-sm text-gray-700">
                            {{ $f->nama_fasilitas }}
                        </span>

                    </label>

                    @endforeach

                </div>

            </div>


            {{-- =================================================
                FOTO KOST
            ================================================== --}}
            <div class="pt-2">

                <div class="flex items-center gap-2 mb-5">

                    <div class="w-8 h-8 rounded-lg bg-[#EAF1EC]
                                flex items-center justify-center">

                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-[#6E8B74]" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />

                        </svg>

                    </div>

                    <div>

                        <h3 class="text-base font-bold text-[#0F0937]">
                            Foto Kost
                        </h3>

                        <p class="text-xs text-gray-400 mt-0.5">
                            Kelola foto yang akan ditampilkan pada katalog.
                        </p>

                    </div>

                </div>


                <div class="bg-[#F8FAF8]
                            border border-gray-100
                            rounded-2xl p-6">

                    {{-- INFO --}}
                    <div class="mb-5">

                        <p class="text-sm text-gray-600">
                            Upload satu atau lebih foto kost.
                        </p>

                        <p class="text-xs text-[#6C8B6B] mt-2 font-semibold">
                            Foto pertama akan menjadi foto utama / thumbnail katalog kost.
                        </p>

                    </div>


                    {{-- INPUT FOTO --}}
                    <div class="flex flex-col gap-3">

                        <label for="foto_kost" class="w-fit inline-flex items-center gap-2
                                   cursor-pointer
                                   bg-white
                                   border border-gray-200
                                   hover:border-[#6C8B6B]
                                   hover:bg-[#FAFCFA]
                                   px-5 py-3
                                   rounded-xl
                                   text-sm
                                   font-semibold
                                   text-gray-700
                                   transition">

                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-[#6C8B6B]" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />

                            </svg>

                            Pilih Foto

                        </label>

                        <input type="file" name="foto_kost[]" id="foto_kost" multiple accept="image/*" class="hidden">

                        <p id="file-count" class="text-sm text-gray-500">

                            Belum ada foto dipilih

                        </p>

                    </div>


                    <p class="text-xs text-gray-400 mt-3">
                        Format yang didukung: JPG, PNG, JPEG.
                    </p>


                    {{-- PREVIEW FOTO BARU --}}
                    <div id="preview-container" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mt-6"></div>


                    {{-- FOTO LAMA --}}
                    @if($kost->foto_kost)

                    <div class="mt-10">

                        <div class="flex items-center justify-between mb-4">

                            <p class="text-sm font-bold text-[#0F0937]">
                                Foto Saat Ini
                            </p>

                            <span class="text-xs text-gray-400">
                                Klik ✕ untuk menghapus foto
                            </span>

                        </div>


                        <div id="old-photo-container" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">

                            @foreach($kost->foto_kost as $index => $foto)

                            <div class="relative old-photo-item group">

                                <img src="{{ asset('storage/' . $foto) }}" alt="Foto Kost" class="w-full h-40 object-cover
                                                   rounded-2xl
                                                   border border-gray-200">


                                {{-- FOTO UTAMA --}}
                                @if($loop->first)

                                <div class="absolute top-2 left-2
                                                       bg-[#6C8B6B]
                                                       text-white
                                                       text-[10px]
                                                       px-2.5 py-1
                                                       rounded-full
                                                       font-semibold">

                                    Foto Utama

                                </div>

                                @endif


                                {{-- HAPUS --}}
                                <button type="button" onclick="removeOldImage(this, '{{ $foto }}')" class="absolute top-2 right-2
                                                   bg-red-500
                                                   hover:bg-red-600
                                                   text-white
                                                   rounded-full
                                                   w-8 h-8
                                                   flex items-center justify-center
                                                   shadow-lg
                                                   opacity-90
                                                   hover:opacity-100
                                                   transition">

                                    ✕

                                </button>

                            </div>

                            @endforeach

                        </div>


                        {{-- INPUT HIDDEN --}}
                        <input type="hidden" name="deleted_old_images" id="deleted_old_images">

                    </div>

                    @endif

                </div>

            </div>


            {{-- =================================================
                GOOGLE MAPS
            ================================================== --}}
            <div class="pt-2">

                <div class="flex items-center gap-2 mb-5">

                    <div class="w-8 h-8 rounded-lg bg-[#EAF1EC]
                                flex items-center justify-center">

                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-[#6E8B74]" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M12 21s7-5.686 7-12A7 7 0 005 9c0 6.314 7 12 7 12z" />

                            <circle cx="12" cy="9" r="2.5" stroke-width="1.8" />

                        </svg>

                    </div>

                    <div>

                        <h3 class="text-base font-bold text-[#0F0937]">
                            Lokasi Kost
                        </h3>

                        <p class="text-xs text-gray-400 mt-0.5">
                            Masukkan link embed Google Maps kost.
                        </p>

                    </div>

                </div>


                {{-- TUTORIAL --}}
                <div class="bg-[#FFF9E8]
                            border border-yellow-200
                            rounded-2xl p-5 mb-5">

                    <div class="flex items-start gap-3">

                        <div class="w-9 h-9 rounded-xl bg-white
                                    flex items-center justify-center
                                    shrink-0">

                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-yellow-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M13 16h-1v-4h-1m1-4h.01M12 21a9 9 0 100-18 9 9 0 000 18z" />

                            </svg>

                        </div>

                        <div class="text-sm text-yellow-800">

                            <h3 class="font-bold mb-3">
                                Cara Mengambil Embed Google Maps
                            </h3>

                            <ol class="list-decimal ml-5 space-y-2">

                                <li>Buka Google Maps.</li>

                                <li>Cari lokasi kost Anda.</li>

                                <li>Klik tombol <b>Bagikan</b>.</li>

                                <li>Pilih menu <b>Sematkan Peta</b>.</li>

                                <li>Klik <b>Salin HTML</b>.</li>

                                <li>
                                    Ambil hanya link pada bagian:
                                    <br>

                                    <span class="bg-white
                                                 border border-yellow-100
                                                 px-2 py-1
                                                 rounded-lg
                                                 mt-2
                                                 inline-block
                                                 text-xs
                                                 break-all">

                                        https://www.google.com/maps/embed?pb=...

                                    </span>

                                </li>

                                <li>
                                    Tempel link tersebut di kolom bawah.
                                </li>

                            </ol>

                        </div>

                    </div>

                </div>


                {{-- INPUT MAP --}}
                <textarea name="lokasi" rows="5" placeholder="https://www.google.com/maps/embed?pb=..." class="w-full
                           bg-gray-50
                           border border-gray-200
                           rounded-2xl
                           px-4 py-3
                           text-sm text-gray-700
                           placeholder-gray-400
                           focus:outline-none
                           focus:ring-2
                           focus:ring-[#6C8B6B]/30
                           focus:border-[#6C8B6B]
                           transition
                           resize-none">{{ old('lokasi', $kost->lokasi) }}</textarea>

            </div>


            {{-- =================================================
                PREVIEW MAP
            ================================================== --}}
            @if($kost->lokasi)

            <div>

                <div class="flex items-center justify-between mb-4">

                    <div>

                        <h3 class="text-base font-bold text-[#0F0937]">
                            Preview Lokasi Kost
                        </h3>

                        <p class="text-xs text-gray-400 mt-1">
                            Tampilan lokasi berdasarkan link yang tersimpan.
                        </p>

                    </div>

                </div>


                <div class="rounded-2xl overflow-hidden
                                border border-gray-200
                                bg-gray-100">

                    <iframe src="{{ $kost->lokasi }}" width="100%" height="450" style="border:0;" allowfullscreen=""
                        loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

                </div>

            </div>

            @endif


            {{-- =================================================
                BUTTON
            ================================================== --}}
            <div class="flex flex-col-reverse sm:flex-row
                        sm:justify-end
                        gap-3
                        pt-6
                        border-t border-gray-100">

                {{-- KEMBALI --}}
                <a href="{{ route('admin.kost.index') }}" class="inline-flex items-center justify-center
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

                    Simpan Informasi

                </button>

            </div>

        </form>

    </div>

</div>


{{-- =========================================================
    SCRIPT FOTO
========================================================== --}}
<script>
const inputFoto = document.getElementById('foto_kost');
const previewContainer = document.getElementById('preview-container');
const fileCount = document.getElementById('file-count');

let selectedFiles = [];


/*
|--------------------------------------------------------------------------
| SELECT FILE
|--------------------------------------------------------------------------
*/

inputFoto.addEventListener('change', function(e) {

    const newFiles = Array.from(e.target.files);

    selectedFiles = [
        ...selectedFiles,
        ...newFiles
    ];

    updateInputFiles();

    renderPreview();

});


/*
|--------------------------------------------------------------------------
| UPDATE INPUT FILES
|--------------------------------------------------------------------------
*/

function updateInputFiles() {
    const dataTransfer = new DataTransfer();

    selectedFiles.forEach(file => {

        dataTransfer.items.add(file);

    });

    inputFoto.files = dataTransfer.files;
}


/*
|--------------------------------------------------------------------------
| RENDER PREVIEW
|--------------------------------------------------------------------------
*/

function renderPreview() {
    previewContainer.innerHTML = '';

    fileCount.innerHTML =
        selectedFiles.length ?
        `${selectedFiles.length} foto dipilih` :
        'Belum ada foto dipilih';


    selectedFiles.forEach((file, index) => {

        const reader = new FileReader();

        reader.onload = function(e) {
            const wrapper = document.createElement('div');

            wrapper.className = 'relative';


            wrapper.innerHTML = `

                    <img
                        src="${e.target.result}"
                        class="w-full h-40 object-cover
                               rounded-2xl
                               border border-gray-200"
                    >

                    ${
                        index === 0
                        ?
                        `
                        <div
                            class="absolute top-2 left-2
                                   bg-[#6C8B6B]
                                   text-white
                                   text-[10px]
                                   px-2.5 py-1
                                   rounded-full
                                   font-semibold"
                        >
                            Foto Utama
                        </div>
                        `
                        :
                        ''
                    }

                    <button
                        type="button"
                        data-index="${index}"
                        class="remove-image
                               absolute top-2 right-2
                               bg-red-500
                               hover:bg-red-600
                               text-white
                               rounded-full
                               w-8 h-8
                               flex items-center justify-center
                               shadow-lg
                               transition"
                    >

                        ✕

                    </button>

                `;


            previewContainer.appendChild(wrapper);


            /*
            |--------------------------------------------------------------------------
            | REMOVE FOTO BARU
            |--------------------------------------------------------------------------
            */

            wrapper
                .querySelector('.remove-image')
                .addEventListener('click', function() {

                    const removeIndex =
                        parseInt(this.dataset.index);

                    selectedFiles.splice(
                        removeIndex,
                        1
                    );

                    updateInputFiles();

                    renderPreview();

                });

        };


        reader.readAsDataURL(file);

    });

}


/*
|--------------------------------------------------------------------------
| DELETE FOTO LAMA
|--------------------------------------------------------------------------
*/

let deletedOldImages = [];


function removeOldImage(button, imagePath) {

    /*
    |--------------------------------------------------------------------------
    | HAPUS CARD FOTO
    |--------------------------------------------------------------------------
    */

    button.parentElement.remove();


    /*
    |--------------------------------------------------------------------------
    | SIMPAN PATH FOTO
    |--------------------------------------------------------------------------
    */

    deletedOldImages.push(imagePath);


    /*
    |--------------------------------------------------------------------------
    | UPDATE INPUT HIDDEN
    |--------------------------------------------------------------------------
    */

    document.getElementById(
        'deleted_old_images'
    ).value = JSON.stringify(
        deletedOldImages
    );

}
</script>

@endsection