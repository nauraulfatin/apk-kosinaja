{{-- ========================================================= --}}
{{-- resources/views/admin/kamar/fasilitas/edit.blade.php --}}
{{-- ========================================================= --}}

@extends('layouts.admin')

@section('content')

<div class="mb-8">

    <h1 class="text-3xl font-bold text-[#0F0937]">
        Fasilitas Kamar
    </h1>

    <p class="text-gray-500 mt-2">
        Kelola fasilitas untuk kamar:
        <span class="font-semibold text-[#0F0937]">
            {{ $kamar->nama_kamar }}
        </span>
    </p>

</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">

    <form
        method="POST"
        action="{{ route('admin.kamar.fasilitas.update', $kamar) }}"
        class="space-y-8"
    >

        @csrf
        @method('PUT')

        {{-- LIST FASILITAS --}}
        <div>

            <h2 class="text-lg font-bold text-[#0F0937] mb-5">
                Pilih Fasilitas
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">

                @foreach($fasilitas as $f)

                <label
                    class="flex items-center gap-4 border border-gray-200 rounded-2xl px-5 py-4 hover:border-[#6C8B6B] hover:bg-[#F8F5F0] transition cursor-pointer"
                >

                    <input
                        type="checkbox"
                        name="fasilitas[]"
                        value="{{ $f->id_fasilitas }}"
                        @checked(in_array($f->id_fasilitas, $selected))
                        class="w-5 h-5 text-[#6C8B6B] border-gray-300 rounded focus:ring-[#6C8B6B]"
                    >

                    <div>

                        <p class="font-semibold text-[#0F0937]">
                            {{ $f->nama_fasilitas }}
                        </p>

                    </div>

                </label>

                @endforeach

            </div>

        </div>

        {{-- BUTTON --}}
        <div class="flex flex-wrap gap-3 pt-4">

            <button
                type="submit"
                class="bg-[#6C8B6B] hover:bg-[#5B765A] text-white px-8 py-3 rounded-xl font-semibold transition"
            >

                Simpan Fasilitas

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