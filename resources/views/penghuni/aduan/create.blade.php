@extends('layouts.penghuni')

@section('content')

<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-3xl font-bold text-[#0F0937]">Buat Aduan</h1>
        <p class="text-gray-500 mt-2">Sampaikan kendala atau keluhan kamu di sini.</p>
    </div>
</div>

{{-- ERROR --}}
@if($errors->any())
<div class="bg-red-50 border border-red-200 text-red-700 rounded-2xl px-6 py-4 mb-6">
    <ul class="list-disc list-inside text-sm space-y-1">
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">

    <form action="{{ route('penghuni.aduan.store') }}" method="POST" enctype="multipart/form-data">

        @csrf

        {{-- Isi Aduan --}}
        <div class="mb-6">
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                Isi Aduan
            </label>
            <textarea name="isi_aduan" rows="6" required placeholder="Tuliskan aduan kamu di sini..."
                class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-[#6E8B74] resize-none">{{ old('isi_aduan') }}</textarea>
        </div>

        {{-- Foto Aduan --}}
        <div class="mb-8">
            <label class="block text-sm font-semibold text-gray-700 mb-3">
                Foto Aduan <span class="text-gray-400 font-normal">(opsional)</span>
            </label>

            <div class="bg-[#F8F5F0] border border-gray-200 rounded-2xl p-6">

                <p class="text-sm text-gray-600 mb-5">
                    Upload foto sebagai bukti aduan.
                </p>

                {{-- TOMBOL PILIH --}}
                <div class="flex flex-col gap-3">
                    <label for="foto_aduan" class="w-fit cursor-pointer bg-white border border-gray-300
                                  hover:border-[#6E8B74] px-5 py-3 rounded-xl
                                  text-sm font-medium text-gray-700 transition">
                        Pilih Foto
                    </label>
                    <input type="file" name="foto_aduan" id="foto_aduan" accept="image/jpg,image/jpeg,image/png"
                        class="hidden">
                    <p id="file-count" class="text-sm text-gray-500">
                        Belum ada foto dipilih
                    </p>
                </div>

                <p class="text-xs text-gray-400 mt-3">Format: JPG, PNG, JPEG · Maks. 5MB</p>

                {{-- PREVIEW --}}
                <div id="preview-container" class="mt-6"></div>

            </div>
        </div>

        {{-- Tombol --}}
        <div class="flex gap-3">
            <button type="submit"
                class="bg-[#6E8B74] hover:bg-[#5c7764] text-white px-8 py-2.5 rounded-xl transition text-sm font-semibold">
                Kirim Aduan
            </button>
            <a href="{{ route('penghuni.aduan.index') }}"
                class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-8 py-2.5 rounded-xl transition text-sm font-semibold">
                Batal
            </a>
        </div>

    </form>

</div>

<script>
const inputFoto = document.getElementById('foto_aduan');
const previewContainer = document.getElementById('preview-container');
const fileCount = document.getElementById('file-count');

inputFoto.addEventListener('change', function(e) {
    previewContainer.innerHTML = '';

    const file = e.target.files[0];

    if (!file) {
        fileCount.textContent = 'Belum ada foto dipilih';
        return;
    }

    fileCount.textContent = '1 foto dipilih';

    const reader = new FileReader();

    reader.onload = function(e) {
        const wrapper = document.createElement('div');
        wrapper.className = 'relative w-fit';
        wrapper.innerHTML = `
                <img src="${e.target.result}"
                     class="h-48 w-auto object-cover rounded-2xl border border-gray-200">
                <button type="button" id="remove-foto"
                        class="absolute top-2 right-2 bg-red-500 hover:bg-red-600
                               text-white rounded-full w-8 h-8 flex items-center
                               justify-center shadow transition text-sm">
                    ✕
                </button>
            `;
        previewContainer.appendChild(wrapper);

        document.getElementById('remove-foto').addEventListener('click', function() {
            inputFoto.value = '';
            previewContainer.innerHTML = '';
            fileCount.textContent = 'Belum ada foto dipilih';
        });
    };

    reader.readAsDataURL(file);
});
</script>

@endsection