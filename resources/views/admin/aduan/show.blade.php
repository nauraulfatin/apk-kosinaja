@extends('layouts.admin')

@section('content')

<div class="p-6">

    {{-- Header --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-black">Detail Aduan</h1>
        <a href="{{ route('admin.aduan.index') }}"
            class="bg-[#6E8B74] hover:bg-[#5c7764] text-white px-5 py-2 rounded-xl transition text-sm">
            Kembali
        </a>
    </div>


{{-- VALIDASI / ERROR --}}
@if($errors->any())
<div class="bg-red-50 border border-red-200 text-red-700 rounded-2xl px-6 py-4 mb-6">
    <ul class="list-disc list-inside text-sm space-y-1">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

@if(session('error'))
<div class="bg-red-50 border border-red-200 text-red-700 rounded-2xl px-6 py-4 mb-6 text-sm">
    {{ session('error') }}
</div>
@endif

    <div class="bg-white rounded-2xl shadow p-6">

        {{-- Nama Penghuni --}}
        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-600 mb-1">Nama Penghuni</label>
            <p class="bg-gray-50 border border-gray-200 rounded-xl px-4 py-2 text-gray-800">
                {{ $aduan->nama }}
            </p>
        </div>

        {{-- Tanggal Aduan --}}
        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-600 mb-1">Tanggal Aduan</label>
            <p class="bg-gray-50 border border-gray-200 rounded-xl px-4 py-2 text-gray-800">
                {{ $aduan->tanggal }}
            </p>
        </div>

        {{-- Isi Aduan --}}
        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-600 mb-1">Isi Aduan</label>
            <p class="bg-gray-50 border border-gray-200 rounded-xl px-4 py-2 text-gray-800 leading-relaxed">
                {{ $aduan->isi_aduan }}
            </p>
        </div>

        {{-- Foto Aduan --}}
        @if($aduan->foto_aduan)
        <div class="mb-6">
            <label class="block text-sm font-semibold text-gray-600 mb-2">Foto Aduan</label>
            <img src="{{ asset('storage/' . $aduan->foto_aduan) }}" alt="Foto Aduan" class="rounded-xl border max-w-sm">
        </div>
        @endif

        {{-- Form Tanggapan --}}
        <form action="{{ route('admin.aduan.update', $aduan->id_aduan) }}" method="POST">

            @csrf
            @method('PUT')

            {{-- Status --}}
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-600 mb-1">Status Aduan</label>
                <select name="status"
                    class="w-full border border-gray-300 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#6E8B74]"
                    required>
                    <option value="baru" {{ old('status', $aduan->status) == 'baru' ? 'selected' : '' }}>Baru</option>
                    <option value="diproses" {{ old('status', $aduan->status) == 'diproses' ? 'selected' : '' }}>Diproses</option>
                    <option value="selesai" {{ old('status', $aduan->status) == 'selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>

            {{-- Tanggapan Admin --}}
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-600 mb-1">Tanggapan Admin</label>
                <textarea name="tanggapan_admin" rows="5" required
                    class="w-full border border-gray-300 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#6E8B74]">{{ old('tanggapan_admin', $aduan->tanggapan_admin) }}</textarea>
            </div>

            <button type="submit"
                class="bg-[#6E8B74] hover:bg-[#5c7764] text-white px-6 py-2 rounded-xl transition text-sm">
                Simpan Tanggapan
            </button>

        </form>

    </div>

</div>

@endsection