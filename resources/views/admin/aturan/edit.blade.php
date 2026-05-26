@extends('layouts.admin')

@section('content')

<div class="mb-8">
    <h1 class="text-3xl font-bold text-[#0F0937]">Edit Aturan Kos</h1>
    <p class="text-gray-500 mt-2">Perbarui aturan kost yang sudah ada.</p>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">

    <form action="{{ route('admin.aturan.update', $aturan->id) }}" method="POST" class="space-y-6">

        @csrf
        @method('PUT')

        <div>
            <label class="block mb-2 font-semibold text-gray-700">
                Isi Aturan
            </label>
            <textarea name="isi_aturan" rows="5" required
                class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#6C8B6B]">{{ old('isi_aturan', $aturan->isi) }}</textarea>
        </div>

        <div class="flex gap-4">
            <button type="submit"
                class="bg-[#6C8B6B] hover:bg-[#5B765A] text-white px-8 py-3 rounded-xl font-semibold transition">
                Update
            </button>
            <a href="{{ route('admin.aturan.index') }}"
                class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-8 py-3 rounded-xl font-semibold transition">
                Kembali
            </a>
        </div>

    </form>

</div>

@endsection