@extends('layouts.penghuni')

@section('content')
<div class="p-6">

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-black">Buat Aduan</h1>
    </div>

    <div class="bg-white rounded-2xl shadow p-6 max-w-2xl">

        <form action="{{ route('penghuni.aduan.store') }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf

            {{-- Isi Aduan --}}
            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Isi Aduan
                </label>
                <textarea name="isi_aduan"
                          rows="5"
                          required
                          placeholder="Tuliskan aduan kamu di sini..."
                          class="w-full border border-gray-300 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#6E8B74]"></textarea>
            </div>

            {{-- Foto Aduan --}}
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Foto Aduan <span class="text-gray-400">(opsional)</span>
                </label>
                <input type="file"
                       name="foto_aduan"
                       accept="image/*"
                       class="w-full border border-gray-300 rounded-xl px-4 py-2 text-sm focus:outline-none">
            </div>

            {{-- Tombol --}}
            <div class="flex gap-3">
                <button type="submit"
                        class="bg-[#6E8B74] hover:bg-[#5c7764] text-white px-6 py-2 rounded-xl transition text-sm">
                    Kirim Aduan
                </button>
                <a href="{{ route('penghuni.aduan.index') }}"
                   class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2 rounded-xl transition text-sm">
                    Batal
                </a>
            </div>

        </form>

    </div>

</div>
@endsection