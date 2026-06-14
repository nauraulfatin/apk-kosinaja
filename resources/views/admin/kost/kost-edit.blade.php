{{-- ========================================================= --}}
{{-- resources/views/admin/kost/edit.blade.php --}}
{{-- ========================================================= --}}

@extends('layouts.admin')

@section('content')

{{-- ========================================================= --}}
{{-- HEADER --}}
{{-- ========================================================= --}}
<div class="mb-8">

    <h1 class="text-3xl font-bold text-[#0F0937]">
        Informasi Kost
    </h1>

    <p class="text-gray-500 mt-2">
        Lengkapi dan perbarui informasi kost Anda.
    </p>

</div>

{{-- ========================================================= --}}
{{-- FORM --}}
{{-- ========================================================= --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">

    <form
        method="POST"
        enctype="multipart/form-data"
        action="{{ route('admin.kost.update') }}"
        class="space-y-8"
    >

        @csrf
        @method('PUT')

        {{-- ========================================================= --}}
        {{-- NAMA KOST --}}
        {{-- ========================================================= --}}
        <div>

            <label class="block text-sm font-medium text-gray-700 mb-2">

                Nama Kost

            </label>

            <input
                type="text"
                name="nama_kost"
                value="{{ old('nama_kost', $kost->nama_kost) }}"
                placeholder="Masukkan nama kost"
                class="w-full border border-gray-300 rounded-xl px-4 py-3"
            >

        </div>

        {{-- ========================================================= --}}
{{-- NOMOR WHATSAPP --}}
{{-- ========================================================= --}}
<div>

    <label class="block text-sm font-medium text-gray-700 mb-2">

        Nomor WhatsApp

    </label>

    <input
        type="text"
        name="no_hp"
        value="{{ old('no_hp', auth()->user()->no_hp) }}"
        placeholder="08xxxxxxxxxx"
        class="w-full border border-gray-300 rounded-xl px-4 py-3"
    >

    <p class="text-xs text-gray-400 mt-2">

        Nomor ini akan ditampilkan pada katalog kost.

    </p>

</div>

        {{-- ========================================================= --}}
        {{-- ALAMAT --}}
        {{-- ========================================================= --}}
        <div>

            <label class="block text-sm font-medium text-gray-700 mb-2">

                Alamat Kost

            </label>

            <textarea
                name="alamat"
                rows="4"
                placeholder="Masukkan alamat kost"
                class="w-full border border-gray-300 rounded-xl px-4 py-3"
            >{{ old('alamat', $kost->alamat) }}</textarea>

        </div>

        {{-- ========================================================= --}}
        {{-- DESKRIPSI --}}
        {{-- ========================================================= --}}
        <div>

            <label class="block text-sm font-medium text-gray-700 mb-2">

                Deskripsi Kost

            </label>

            <textarea
                name="deskripsi"
                rows="5"
                placeholder="Deskripsi kost..."
                class="w-full border border-gray-300 rounded-xl px-4 py-3"
            >{{ old('deskripsi', $kost->deskripsi) }}</textarea>

        </div>

        {{-- ========================================================= --}}
        {{-- FASILITAS KOST --}}
        {{-- ========================================================= --}}
        <div>

            <label class="block text-sm font-medium text-gray-700 mb-4">

                Fasilitas Kost

            </label>

            <div
                class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-[#F8F5F0] border border-gray-200 rounded-2xl p-5"
            >

                @foreach($fasilitas as $f)

                <label
                    class="flex items-center gap-3 bg-white rounded-xl px-4 py-3 border border-gray-100 hover:border-[#6C8B6B] cursor-pointer transition"
                >

                    <input
    type="checkbox"
    name="fasilitas[]"
    value="{{ $f->id_fasilitas }}"

    @checked(
        $kost->fasilitas->contains(
            'id_fasilitas',
            $f->id_fasilitas
        )
    )

    class="rounded border-gray-300 text-[#6C8B6B] focus:ring-[#6C8B6B]"
>

                    <span class="text-sm text-gray-700">

                        {{ $f->nama_fasilitas }}

                    </span>

                </label>

                @endforeach

            </div>

        </div>

      {{-- ========================================================= --}}
{{-- FOTO KOST --}}
{{-- ========================================================= --}}
<div>

    <label class="block text-sm font-medium text-gray-700 mb-3">

        Foto Kost

    </label>

    <div class="bg-[#F8F5F0] border border-gray-200 rounded-2xl p-6">

        {{-- INFO --}}
        <div class="mb-5">

            <p class="text-sm text-gray-600">

                Upload satu atau lebih foto kost.

            </p>

            <p class="text-xs text-[#6C8B6B] mt-2 font-medium">

                Foto pertama akan menjadi foto utama / thumbnail katalog kost.

            </p>

        </div>

        {{-- CUSTOM INPUT --}}
        <div class="flex flex-col gap-4">

            <label
                for="foto_kost"
                class="w-fit cursor-pointer bg-white border border-gray-300 hover:border-[#6C8B6B]
                       px-5 py-3 rounded-xl text-sm font-medium text-gray-700 transition"
            >

                Pilih Foto

            </label>

            <input
                type="file"
                name="foto_kost[]"
                id="foto_kost"
                multiple
                accept="image/*"
                class="hidden"
            >

            <p
                id="file-count"
                class="text-sm text-gray-500"
            >

                Belum ada foto dipilih

            </p>

        </div>

        <p class="text-xs text-gray-400 mt-3">

            Format: JPG, PNG, JPEG

        </p>

        {{-- PREVIEW FOTO BARU --}}
        <div
            id="preview-container"
            class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mt-6"
        ></div>

       {{-- FOTO LAMA --}}
@if($kost->foto_kost)

<div class="mt-10">

    <p class="text-sm font-semibold text-[#0F0937] mb-4">

        Foto Saat Ini

    </p>

    <div
        id="old-photo-container"
        class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4"
    >

        @foreach($kost->foto_kost as $index => $foto)

        <div class="relative old-photo-item">

            <img
                src="{{ asset('storage/' . $foto) }}"
                class="w-full h-40 object-cover rounded-2xl border border-gray-200"
            >

            {{-- FOTO UTAMA --}}
            @if($loop->first)

            <div
                class="absolute top-2 left-2
                       bg-[#6C8B6B] text-white
                       text-[10px] px-2 py-1 rounded-full"
            >

                Foto Utama

            </div>

            @endif

            {{-- BUTTON HAPUS --}}
            <button
                type="button"
                onclick="removeOldImage(this, '{{ $foto }}')"
                class="absolute top-2 right-2
                       bg-red-500 hover:bg-red-600
                       text-white rounded-full
                       w-8 h-8 flex items-center justify-center
                       shadow-lg transition"
            >

                ✕

            </button>

        </div>

        @endforeach

    </div>

    {{-- INPUT HIDDEN --}}
    <input
        type="hidden"
        name="deleted_old_images"
        id="deleted_old_images"
    >

</div>

@endif
    </div>

</div>

{{-- ========================================================= --}}
{{-- SCRIPT PREVIEW FOTO --}}
{{-- ========================================================= --}}
<script>

    const inputFoto =
        document.getElementById('foto_kost');

    const previewContainer =
        document.getElementById('preview-container');

    const fileCount =
        document.getElementById('file-count');

    let selectedFiles = [];

    /*
    |--------------------------------------------------------------------------
    | SELECT FILE
    |--------------------------------------------------------------------------
    */

    inputFoto.addEventListener('change', function (e)
    {
        const newFiles =
            Array.from(e.target.files);

        /*
        |--------------------------------------------------------------------------
        | GABUNG FILE BARU
        |--------------------------------------------------------------------------
        */

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

    function updateInputFiles()
    {
        const dataTransfer =
            new DataTransfer();

        selectedFiles.forEach(file =>
        {
            dataTransfer.items.add(file);
        });

        inputFoto.files =
            dataTransfer.files;
    }

    /*
    |--------------------------------------------------------------------------
    | RENDER PREVIEW
    |--------------------------------------------------------------------------
    */

    function renderPreview()
    {
        previewContainer.innerHTML = '';

        /*
        |--------------------------------------------------------------------------
        | FILE COUNT
        |--------------------------------------------------------------------------
        */

        fileCount.innerHTML =
            selectedFiles.length
            ? `${selectedFiles.length} foto dipilih`
            : 'Belum ada foto dipilih';

        selectedFiles.forEach((file, index) =>
        {
            const reader = new FileReader();

            reader.onload = function (e)
            {
                const wrapper =
                    document.createElement('div');

                wrapper.className =
                    'relative';

                wrapper.innerHTML = `

                    <img
                        src="${e.target.result}"
                        class="w-full h-40 object-cover rounded-2xl border border-gray-200"
                    >

                    ${
                        index === 0
                        ?
                        `
                        <div
                            class="absolute top-2 left-2
                                   bg-[#6C8B6B] text-white
                                   text-[10px] px-2 py-1 rounded-full"
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
                               bg-red-500 hover:bg-red-600
                               text-white rounded-full
                               w-8 h-8 flex items-center justify-center
                               shadow-lg transition"
                    >

                        ✕

                    </button>

                `;

                previewContainer.appendChild(wrapper);

                /*
                |--------------------------------------------------------------------------
                | REMOVE FOTO
                |--------------------------------------------------------------------------
                */

                wrapper
                    .querySelector('.remove-image')
                    .addEventListener('click', function ()
                    {
                        const removeIndex =
                            parseInt(this.dataset.index);

                        selectedFiles.splice(removeIndex, 1);

                        updateInputFiles();

                        renderPreview();
                    });

            };

            reader.readAsDataURL(file);

        });
    }

</script>
<script>

    /*
    |--------------------------------------------------------------------------
    | DELETE FOTO LAMA
    |--------------------------------------------------------------------------
    */

    let deletedOldImages = [];

    function removeOldImage(button, imagePath)
    {
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

        {{-- ========================================================= --}}
        {{-- GOOGLE MAPS --}}
        {{-- ========================================================= --}}
        <div>

            <label class="block text-sm font-medium text-gray-700 mb-3">

                Embed Google Maps

            </label>

            {{-- TUTORIAL --}}
            <div
                class="bg-yellow-50 border border-yellow-200 text-yellow-700 rounded-2xl p-5 mb-5 text-sm"
            >

                <h3 class="font-semibold mb-3">
                    Cara Mengambil Embed Google Maps
                </h3>

                <ol class="list-decimal ml-5 space-y-2">

                    <li>Buka Google Maps</li>

                    <li>Cari lokasi kost Anda</li>

                    <li>Klik tombol <b>Bagikan</b></li>

                    <li>Pilih menu <b>Sematkan Peta</b></li>

                    <li>Klik <b>Salin HTML</b></li>

                    <li>
                        Ambil hanya link pada bagian:
                        <br>

                        <span class="bg-white px-2 py-1 rounded mt-2 inline-block text-xs">

                            src="https://www.google.com/maps/embed?pb=..."

                        </span>

                    </li>

                    <li>Tempel link tersebut di kolom bawah</li>

                </ol>

            </div>

            {{-- INPUT --}}
            <textarea
                name="lokasi"
                rows="5"
                placeholder="https://www.google.com/maps/embed?pb=..."
                class="w-full border border-gray-300 rounded-xl px-4 py-3"
            >{{ old('lokasi', $kost->lokasi) }}</textarea>

        </div>

        {{-- ========================================================= --}}
        {{-- PREVIEW MAP --}}
        {{-- ========================================================= --}}
        @if($kost->lokasi)

        <div>

            <h3 class="text-lg font-semibold text-[#0F0937] mb-4">

                Preview Lokasi Kost

            </h3>

            <div class="rounded-2xl overflow-hidden border border-gray-200">

                <iframe
                    src="{{ $kost->lokasi }}"
                    width="100%"
                    height="450"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                ></iframe>

            </div>

        </div>

        @endif

        {{-- ========================================================= --}}
        {{-- BUTTON --}}
        {{-- ========================================================= --}}
        <div class="flex flex-wrap gap-3 pt-4">

            <button
                type="submit"
                class="bg-[#6C8B6B] hover:bg-[#5B765A] text-white px-8 py-3 rounded-xl font-semibold transition"
            >

                Simpan Informasi

            </button>

            <a
                href="{{ route('admin.kost.index') }}"
                class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-8 py-3 rounded-xl font-semibold transition"
            >

                Kembali

            </a>

        </div>

    </form>

</div>

{{-- ========================================================= --}}
{{-- PREVIEW FOTO --}}
{{-- ========================================================= --}}
<script>

    document.getElementById('fotoKostInput')
    .addEventListener('change', function(e)
    {
        const preview =
            document.getElementById('previewFotoKost');

        preview.innerHTML = '';

        Array.from(e.target.files).forEach(file =>
        {
            const reader = new FileReader();

            reader.onload = function(event)
            {
                preview.innerHTML += `
                    <img
                        src="${event.target.result}"
                        class="w-full h-48 object-cover rounded-2xl border border-gray-200"
                    >
                `;
            }

            reader.readAsDataURL(file);
        });
    });

</script>

@endsection