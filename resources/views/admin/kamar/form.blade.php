{{-- ========================================================= --}}
{{-- resources/views/admin/kamar/form.blade.php --}}
{{-- ========================================================= --}}

@extends('layouts.admin')

@section('content')

<div class="mb-8">

    <h1 class="text-3xl font-bold text-[#0F0937]">

        {{ $item->exists ? 'Edit Kamar' : 'Tambah Kamar' }}

    </h1>

    <p class="text-gray-500 mt-2">

        {{ $item->exists
            ? 'Perbarui informasi kamar kost.'
            : 'Tambahkan kamar baru ke dalam sistem kost.' }}

    </p>

</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">

    <form
        method="POST"
        enctype="multipart/form-data"
        action="{{ $item->exists
            ? route('admin.kamar.update', $item)
            : route('admin.kamar.store') }}"
        class="space-y-6"
    >

        @csrf

        @if($item->exists)
            @method('PUT')
        @endif

        {{-- NAMA KAMAR --}}
        <div>

            <label class="block text-sm font-medium text-gray-700 mb-2">
                Nama Kamar
            </label>

            <input
                type="text"
                name="nama_kamar"
                value="{{ old('nama_kamar', $item->nama_kamar) }}"
                placeholder="Opsional, Contoh: Kamar Melati"
                class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-[#6C8B6B] focus:border-[#6C8B6B]"
            >

        </div>

        {{-- NOMOR + UKURAN --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- NOMOR --}}
            <div>

                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Nomor Kamar
                </label>

                <input
                    type="text"
                    name="nomor_kamar"
                    value="{{ old('nomor_kamar', $item->nomor_kamar) }}"
                    placeholder="Contoh: A01 atau 01"
                    class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-[#6C8B6B] focus:border-[#6C8B6B]"
                >

            </div>

            {{-- UKURAN --}}
            <div>

                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Ukuran Kamar
                </label>

                <input
                    type="text"
                    name="ukuran_kamar"
                    value="{{ old('ukuran_kamar', $item->ukuran_kamar) }}"
                    placeholder="Contoh: 3x4"
                    class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-[#6C8B6B] focus:border-[#6C8B6B]"
                >

            </div>

        </div>

        {{-- ========================================================= --}}
{{-- FOTO KAMAR --}}
{{-- ========================================================= --}}
<div>

    <label class="block text-sm font-medium text-gray-700 mb-3">

        Foto Kamar

    </label>

    <div class="bg-[#F8F5F0] border border-gray-200 rounded-2xl p-6">

        {{-- INFO --}}
        <div class="mb-5">

            <p class="text-sm text-gray-600">

                Upload satu atau lebih foto kamar.

            </p>

            <p class="text-xs text-[#6C8B6B] mt-2 font-medium">

                Foto pertama akan menjadi foto utama kamar.

            </p>

        </div>

        {{-- INPUT --}}
        <div class="flex flex-col gap-4">

            <label
                for="foto_kamar"
                class="w-fit cursor-pointer bg-white border border-gray-300
                       hover:border-[#6C8B6B]
                       px-5 py-3 rounded-xl text-sm font-medium
                       text-gray-700 transition"
            >

                Pilih Foto

            </label>

            <input
                type="file"
                name="foto_kamar[]"
                id="foto_kamar"
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

        {{-- PREVIEW --}}
        <div
            id="preview-container"
            class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mt-6"
        ></div>

        {{-- FOTO LAMA --}}
        @if($item->exists && $item->foto_kamar)

        <div class="mt-10">

            <p class="text-sm font-semibold text-[#0F0937] mb-4">

                Foto Saat Ini

            </p>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">

                @foreach($item->foto_kamar as $foto)

                <div class="relative">

                    <img
                        src="{{ asset('storage/' . $foto) }}"
                        class="w-full h-40 object-cover rounded-2xl border border-gray-200"
                    >

                    @if($loop->first)

                    <div
                        class="absolute top-2 left-2
                               bg-[#6C8B6B] text-white
                               text-[10px] px-2 py-1 rounded-full"
                    >

                        Foto Utama

                    </div>

                    @endif

                </div>

                @endforeach

            </div>

        </div>

        @endif

    </div>

</div>

{{-- ========================================================= --}}
{{-- SCRIPT PREVIEW --}}
{{-- ========================================================= --}}
<script>

    const inputFoto =
        document.getElementById('foto_kamar');

    const previewContainer =
        document.getElementById('preview-container');

    const fileCount =
        document.getElementById('file-count');

    let selectedFiles = [];

    inputFoto.addEventListener('change', function (e)
    {
        const newFiles =
            Array.from(e.target.files);

        selectedFiles = [

            ...selectedFiles,

            ...newFiles

        ];

        updateInputFiles();

        renderPreview();
    });

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

    function renderPreview()
    {
        previewContainer.innerHTML = '';

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
                        class="remove-image absolute top-2 right-2
                               bg-red-500 hover:bg-red-600
                               text-white rounded-full
                               w-8 h-8 flex items-center justify-center"
                    >

                        ✕

                    </button>

                `;

                previewContainer.appendChild(wrapper);

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

        {{-- BUTTON --}}
        <div class="flex flex-wrap gap-3 pt-4">

            <button
                type="submit"
                class="bg-[#6C8B6B] hover:bg-[#5B765A] text-white px-8 py-3 rounded-xl font-semibold transition"
            >

                {{ $item->exists ? 'Update Kamar' : 'Simpan Kamar' }}

            </button>

            <a
                href="{{ route('admin.kamar.index') }}"
                class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-8 py-3 rounded-xl font-semibold transition"
            >

                Kembali

            </a>

        </div>

    </form>

</div>

@endsection