@extends('layouts.admin')

@section('content')

<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-3xl font-bold text-[#0F0937]">Aturan Kos</h1>
        <p class="text-gray-500 mt-2">Harap diperhatikan sebelum menyewa.</p>
    </div>
    <a href="{{ route('admin.aturan.create') }}"
        class="bg-[#6C8B6B] hover:bg-[#5B765A] text-white px-6 py-3 rounded-xl font-semibold transition">
        + Tambah Aturan
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-2 space-y-2">

    @forelse($aturans as $aturan)

    <div
        class="flex justify-between items-center px-4 py-3 rounded-xl border border-gray-100 hover:bg-gray-50 transition">

        <div class="flex items-center gap-4">
            <span
                class="w-7 h-7 flex items-center justify-center rounded-full bg-[#EEF3EE] text-[#6C8B6B] text-sm font-bold">
                {{ $loop->iteration }}
            </span>
            <p class="text-gray-700 font-medium">
                {{ $aturan->isi }}
            </p>
        </div>

        <div class="flex gap-2">
            <a href="{{ route('admin.aturan.edit', $aturan->id) }}"
                class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm font-semibold transition">
                Edit
            </a>
            <form action="{{ route('admin.aturan.destroy', $aturan->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button onclick="return confirm('Yakin ingin menghapus aturan ini?')"
                    class="bg-[#FCEBEB] hover:bg-[#F7C1C1] text-[#791F1F] px-6 py-2.5 rounded-xl font-medium text-sm transition">

                    Hapus

                </button>
            </form>
        </div>

    </div>

    @empty

    <div class="text-center py-12 text-gray-500">
        Belum ada aturan kos
    </div>

    @endforelse

</div>

@endsection