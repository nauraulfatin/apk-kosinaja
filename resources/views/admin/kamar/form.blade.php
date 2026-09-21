{{-- ========================================================= --}}
{{-- resources/views/admin/kamar/form.blade.php --}}
{{-- ========================================================= --}}

@extends('layouts.admin')

@section('content')

<div class="mb-8">

    <h1 class="text-3xl font-bold text-[#0F0937]">

        {{ $item->exists ? 'Kelola Kamar' : 'Tambah Kamar' }}

    </h1>

    <p class="text-gray-500 mt-2">

        {{ $item->exists
            ? 'Kelola informasi kamar, fasilitas, dan harga kamar kost.'
            : 'Tambahkan kamar baru ke dalam sistem kost.' }}

    </p>

</div>


{{-- ========================================================= --}}
{{-- VALIDASI / ERROR --}}
{{-- ========================================================= --}}

@if($errors->any())

<div class="bg-red-50 border border-red-200 text-red-700 rounded-2xl px-6 py-4 mb-6">

    <ul class="list-disc list-inside text-sm space-y-1">

        @foreach($errors->all() as $error)

            <li>
                {{ $error }}
            </li>

        @endforeach

    </ul>

</div>

@endif


@if(session('error'))

<div class="bg-red-50 border border-red-200 text-red-700 rounded-2xl px-6 py-4 mb-6 text-sm">

    {{ session('error') }}

</div>

@endif


{{-- ========================================================= --}}
{{-- FORM --}}
{{-- ========================================================= --}}

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">

    <form
        method="POST"
        enctype="multipart/form-data"
        action="{{ $item->exists
            ? route('admin.kamar.update', $item)
            : route('admin.kamar.store') }}"
        class="space-y-8"
    >

        @csrf

        @if($item->exists)

            @method('PUT')

        @endif


        {{-- ========================================================= --}}
        {{-- INFORMASI KAMAR --}}
        {{-- ========================================================= --}}

        <div>

            <h2 class="text-xl font-bold text-[#0F0937] mb-2">
                Informasi Kamar
            </h2>

            <p class="text-sm text-gray-500 mb-6">
                Masukkan informasi dasar kamar.
            </p>


            {{-- NAMA KAMAR --}}

            <div class="mb-6">

                <label class="block text-sm font-medium text-gray-700 mb-2">

                    Nama atau Tipe Kamar

                </label>

                <input
                    type="text"
                    name="nama_kamar"
                    value="{{ old('nama_kamar', $item->nama_kamar) }}"
                    placeholder="Contoh: Kamar Melati atau Kamar Standar"
                    class="w-full border border-gray-300 rounded-xl px-4 py-3
                           focus:ring-[#6C8B6B]
                           focus:border-[#6C8B6B]"
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
                        class="w-full border border-gray-300 rounded-xl px-4 py-3
                               focus:ring-[#6C8B6B]
                               focus:border-[#6C8B6B]"
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
                        class="w-full border border-gray-300 rounded-xl px-4 py-3
                               focus:ring-[#6C8B6B]
                               focus:border-[#6C8B6B]"
                    >

                </div>

            </div>

        </div>


        {{-- ========================================================= --}}
        {{-- FOTO KAMAR --}}
        {{-- ========================================================= --}}

        <div class="border-t border-gray-100 pt-8">

            <label class="block text-sm font-medium text-gray-700 mb-3">

                Foto Kamar

            </label>

            <div class="bg-[#F8F5F0] border border-gray-200 rounded-2xl p-6">

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


                {{-- PREVIEW FOTO BARU --}}

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

                    <div
                        id="old-photo-container"
                        class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4"
                    >

                        @foreach($item->foto_kamar as $index => $foto)

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
        {{-- FASILITAS KAMAR --}}
        {{-- ========================================================= --}}

        @if($item->exists)

        <div class="border-t border-gray-100 pt-8">

            <h2 class="text-xl font-bold text-[#0F0937] mb-2">

                Fasilitas Kamar

            </h2>

            <p class="text-sm text-gray-500 mb-5">

                Pilih fasilitas yang tersedia di kamar ini.

            </p>


            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">

                @foreach($fasilitas as $f)

                <label
                    class="flex items-center gap-4 border border-gray-200 rounded-2xl px-5 py-4
                           hover:border-[#6C8B6B] hover:bg-[#F8F5F0]
                           transition cursor-pointer"
                >

                    <input
                        type="checkbox"
                        name="fasilitas[]"
                        value="{{ $f->id_fasilitas }}"
                        @checked(
                            in_array(
                                $f->id_fasilitas,
                                old(
                                    'fasilitas',
                                    $selected ?? []
                                )
                            )
                        )
                        class="w-5 h-5 text-[#6C8B6B]
                               border-gray-300 rounded
                               focus:ring-[#6C8B6B]"
                    >

                    <span class="font-semibold text-[#0F0937]">

                        {{ $f->nama_fasilitas }}

                    </span>

                </label>

                @endforeach

            </div>

        </div>


        {{-- ========================================================= --}}
        {{-- HARGA KAMAR --}}
        {{-- ========================================================= --}}

        <div class="border-t border-gray-100 pt-8">

            <h2 class="text-xl font-bold text-[#0F0937] mb-2">

                Harga Kamar

            </h2>

            <p class="text-sm text-gray-500 mb-5">

                Atur harga dan periode penagihan kamar.

            </p>


            <div class="space-y-6">


                {{-- HARGA --}}

                <div>

                    <label class="block text-sm font-medium text-gray-700 mb-2">

                        Harga Kamar

                    </label>

                    <input
                        type="number"
                        name="harga"
                        value="{{ old('harga', $harga?->harga) }}"
                        placeholder="Contoh: 750000"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3
                               focus:ring-[#6C8B6B]
                               focus:border-[#6C8B6B]"
                    >

                    <p class="text-xs text-gray-400 mt-2">

                        Masukkan nominal tanpa titik atau koma.

                    </p>

                </div>


                {{-- PERIODE --}}

                <div>

                    <label class="block text-sm font-medium text-gray-700 mb-2">

                        Periode Penagihan

                    </label>

                    <select
                        name="id_periode"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3
                               focus:ring-[#6C8B6B]
                               focus:border-[#6C8B6B]"
                    >

                        <option value="">

                            Pilih periode penagihan

                        </option>


                        @foreach($periodes as $p)

                        <option
                            value="{{ $p->id_penagihan }}"
                            @selected(
                                old(
                                    'id_periode',
                                    $harga?->id_periode
                                ) == $p->id_penagihan
                            )
                        >

                            {{ $p->periode_penagihan }}

                            (setiap
                            {{ $p->jumlah_interval }}
                            {{ $p->satuan_interval }})

                        </option>

                        @endforeach

                    </select>

                </div>


                {{-- STATUS HARGA --}}

                <div>

                    <label
                        class="flex items-center gap-3 bg-[#F8F5F0]
                               border border-gray-200 rounded-2xl px-5 py-4
                               cursor-pointer"
                    >

                        <input
                            type="checkbox"
                            name="isactive"
                            value="1"
                            @checked(
                                old(
                                    'isactive',
                                    $harga?->isactive ?? true
                                )
                            )
                            class="w-5 h-5 text-[#6C8B6B]
                                   border-gray-300 rounded
                                   focus:ring-[#6C8B6B]"
                        >

                        <div>

                            <p class="font-semibold text-[#0F0937]">

                                Harga Aktif

                            </p>

                            <p class="text-sm text-gray-500">

                                Harga ini digunakan untuk transaksi dan tagihan.

                            </p>

                        </div>

                    </label>

                </div>

            </div>

        </div>

        @endif


        {{-- ========================================================= --}}
        {{-- SCRIPT PREVIEW FOTO --}}
        {{-- ========================================================= --}}

        <script>

            const inputFoto =
                document.getElementById('foto_kamar');

            const previewContainer =
                document.getElementById('preview-container');

            const fileCount =
                document.getElementById('file-count');

            let selectedFiles = [];


            inputFoto.addEventListener(
                'change',
                function (e)
                {

                    const newFiles =
                        Array.from(
                            e.target.files
                        );

                    selectedFiles = [

                        ...selectedFiles,

                        ...newFiles

                    ];

                    updateInputFiles();

                    renderPreview();

                }
            );


            function updateInputFiles()
            {

                const dataTransfer =
                    new DataTransfer();

                selectedFiles.forEach(
                    file =>
                    {
                        dataTransfer.items.add(file);
                    }
                );

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


                selectedFiles.forEach(
                    (file, index) =>
                    {

                        const reader =
                            new FileReader();


                        reader.onload =
                            function (e)
                            {

                                const wrapper =
                                    document.createElement(
                                        'div'
                                    );

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


                                previewContainer.appendChild(
                                    wrapper
                                );


                                wrapper
                                    .querySelector(
                                        '.remove-image'
                                    )
                                    .addEventListener(
                                        'click',
                                        function ()
                                        {

                                            const removeIndex =
                                                parseInt(
                                                    this.dataset.index
                                                );

                                            selectedFiles.splice(
                                                removeIndex,
                                                1
                                            );

                                            updateInputFiles();

                                            renderPreview();

                                        }
                                    );

                            };


                        reader.readAsDataURL(
                            file
                        );

                    }
                );

            }

        </script>


        {{-- ========================================================= --}}
        {{-- SCRIPT HAPUS FOTO LAMA --}}
        {{-- ========================================================= --}}

        <script>

            let deletedOldImages = [];


            function removeOldImage(
                button,
                imagePath
            )
            {

                button.parentElement.remove();


                deletedOldImages.push(
                    imagePath
                );


                document.getElementById(
                    'deleted_old_images'
                ).value =
                    JSON.stringify(
                        deletedOldImages
                    );

            }

        </script>


        {{-- ========================================================= --}}
        {{-- BUTTON --}}
        {{-- ========================================================= --}}

        <div class="flex flex-wrap gap-3 pt-4">

            <button
                type="submit"
                class="bg-[#6C8B6B] hover:bg-[#5B765A]
                       text-white px-8 py-3 rounded-xl
                       font-semibold transition"
            >

                {{ $item->exists
                    ? 'Simpan Perubahan'
                    : 'Simpan Kamar' }}

            </button>


            <a
                href="{{ route('admin.kamar.index') }}"
                class="bg-gray-100 hover:bg-gray-200
                       text-gray-700 px-8 py-3 rounded-xl
                       font-semibold transition"
            >

                Kembali

            </a>

        </div>

    </form>

</div>

@endsection