@extends('layouts.penghuni')

@section('content')

<div class="p-6 space-y-7">

    {{-- =========================================================
        HEADER
    ========================================================== --}}
    <div>

        <div class="flex items-center gap-3">

            <div class="w-11 h-11
                       rounded-2xl
                       bg-[#F3F0E9]
                       flex items-center
                       justify-center">

                <svg class="w-5 h-5 text-[#7A806F]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7A8.38 8.38 0 014 11.5 8.5 8.5 0 0112.5 3a8.5 8.5 0 018.5 8.5z" />

                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M8 11h.01M12 11h.01M16 11h.01" />
                </svg>

            </div>


            <div>

                <h1 class="text-2xl
                           font-bold
                           text-[#0F0937]">
                    Buat Aduan
                </h1>

                <p class="text-gray-500
                           mt-1
                           text-sm">
                    Sampaikan kendala atau keluhan kamu di sini.
                </p>

            </div>

        </div>

    </div>


    {{-- =========================================================
        ERROR
    ========================================================== --}}
    @if($errors->any())

    <div class="bg-red-50
                   border border-red-100
                   text-red-700
                   rounded-2xl
                   px-5 py-4">

        <p class="text-sm font-semibold mb-2">
            Ada yang perlu diperbaiki:
        </p>

        <ul class="list-disc
                       list-inside
                       text-sm
                       space-y-1">

            @foreach($errors->all() as $error)

            <li>{{ $error }}</li>

            @endforeach

        </ul>

    </div>

    @endif


    {{-- =========================================================
        FORM
    ========================================================== --}}
    <div class="bg-white
               rounded-3xl
               border border-gray-100
               shadow-sm
               overflow-hidden">

        {{-- HEADER FORM --}}
        <div class="px-6 py-5
                   border-b border-gray-100
                   bg-[#FBFAF7]">

            <h2 class="text-base
                       font-bold
                       text-[#0F0937]">
                Sampaikan Aduan
            </h2>

            <p class="text-xs
                       text-gray-400
                       mt-1">
                Jelaskan kendala yang kamu alami agar dapat segera ditindaklanjuti.
            </p>

        </div>


        {{-- FORM CONTENT --}}
        <div class="p-6 sm:p-8">

            <form action="{{ route('penghuni.aduan.store') }}" method="POST" enctype="multipart/form-data">

                @csrf


                {{-- =================================================
                    ISI ADUAN
                ================================================== --}}
                <div class="mb-7">

                    <label class="block
                               text-sm
                               font-semibold
                               text-gray-700
                               mb-2">
                        Isi Aduan
                    </label>

                    <textarea name="isi_aduan" rows="7" required
                        placeholder="Tuliskan kendala atau keluhan kamu di sini..." class="w-full
                               bg-[#FAFAF8]
                               border border-gray-200
                               rounded-2xl
                               px-4 py-3.5
                               text-sm
                               text-gray-700
                               placeholder:text-gray-400
                               resize-none
                               outline-none
                               transition
                               focus:bg-white
                               focus:border-[#A5AA98]
                               focus:ring-2
                               focus:ring-[#A5AA98]/10">{{ old('isi_aduan') }}</textarea>

                    <p class="text-xs
                               text-gray-400
                               mt-2">
                        Jelaskan secara singkat dan jelas mengenai kendala yang terjadi.
                    </p>

                </div>


                {{-- =================================================
                    FOTO ADUAN
                ================================================== --}}
                <div class="mb-8">

                    <label class="block
                               text-sm
                               font-semibold
                               text-gray-700
                               mb-3">

                        Foto Aduan

                        <span class="text-gray-400
                                   font-normal">
                            (opsional)
                        </span>

                    </label>


                    <div class="bg-[#FBFAF7]
                               border border-gray-200
                               rounded-2xl
                               p-5 sm:p-6">

                        <p class="text-sm
                                   text-gray-600
                                   mb-4">
                            Tambahkan foto jika diperlukan sebagai bukti aduan.
                        </p>


                        {{-- UPLOAD AREA --}}
                        <label for="foto_aduan" class="flex
                                   items-center
                                   gap-4
                                   p-4
                                   rounded-2xl
                                   border border-dashed
                                   border-gray-300
                                   bg-white
                                   hover:border-[#A5AA98]
                                   hover:bg-[#FAFAF7]
                                   cursor-pointer
                                   transition">

                            <div class="w-11 h-11
                                       shrink-0
                                       rounded-xl
                                       bg-[#F3F0E9]
                                       flex items-center
                                       justify-center">

                                <svg class="w-5 h-5 text-[#7A806F]" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">

                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M4 16l4-4 3 3 5-6 4 5" />

                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z" />

                                </svg>

                            </div>


                            <div class="min-w-0">

                                <p class="text-sm
                                           font-semibold
                                           text-gray-700">
                                    Pilih Foto
                                </p>

                                <p id="file-count" class="text-xs
                                           text-gray-400
                                           mt-1">
                                    Belum ada foto dipilih
                                </p>

                            </div>

                        </label>


                        <input type="file" name="foto_aduan" id="foto_aduan" accept="image/jpg,image/jpeg,image/png"
                            class="hidden">


                        <p class="text-xs
                                   text-gray-400
                                   mt-3">
                            Format: JPG, PNG, JPEG · Maks. 5MB
                        </p>


                        {{-- PREVIEW --}}
                        <div id="preview-container" class="mt-5"></div>

                    </div>

                </div>


                {{-- =================================================
                    BUTTON
                ================================================== --}}
                <div class="flex flex-col-reverse
                           sm:flex-row
                           gap-3
                           pt-2
                           border-t
                           border-gray-100">

                    <a href="{{ route('penghuni.aduan.index') }}" class="sm:w-auto
                               text-center
                               bg-gray-100
                               hover:bg-gray-200
                               text-gray-700
                               px-7 py-3
                               rounded-xl
                               transition
                               text-sm
                               font-semibold">
                        Batal
                    </a>


                    <button type="submit" class="sm:w-auto
                               bg-[#7A806F]
                               hover:bg-[#686D60]
                               text-white
                               px-7 py-3
                               rounded-xl
                               transition
                               text-sm
                               font-semibold">
                        Kirim Aduan
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


{{-- =========================================================
    JAVASCRIPT PREVIEW
========================================================= --}}
<script>
const inputFoto =
    document.getElementById('foto_aduan');

const previewContainer =
    document.getElementById('preview-container');

const fileCount =
    document.getElementById('file-count');


inputFoto.addEventListener(
    'change',
    function(e) {

        previewContainer.innerHTML = '';

        const file = e.target.files[0];


        if (!file) {

            fileCount.textContent =
                'Belum ada foto dipilih';

            return;

        }


        fileCount.textContent =
            '1 foto dipilih';


        const reader =
            new FileReader();


        reader.onload =
            function(e) {

                const wrapper =
                    document.createElement('div');

                wrapper.className =
                    'relative w-fit';


                wrapper.innerHTML = `

                    <img
                        src="${e.target.result}"
                        class="h-48
                               max-w-full
                               object-cover
                               rounded-2xl
                               border
                               border-gray-200"
                    >

                    <button
                        type="button"
                        id="remove-foto"
                        class="absolute
                               top-2
                               right-2
                               bg-red-500
                               hover:bg-red-600
                               text-white
                               rounded-full
                               w-8 h-8
                               flex items-center
                               justify-center
                               shadow
                               transition
                               text-sm"
                    >
                        ✕
                    </button>

                `;


                previewContainer.appendChild(
                    wrapper
                );


                document
                    .getElementById('remove-foto')
                    .addEventListener(
                        'click',
                        function() {

                            inputFoto.value = '';

                            previewContainer.innerHTML = '';

                            fileCount.textContent =
                                'Belum ada foto dipilih';

                        }
                    );

            };


        reader.readAsDataURL(file);

    }
);
</script>

@endsection