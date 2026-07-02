{{-- ========================================================= --}}
{{-- resources/views/superadmin/fasilitas/index.blade.php --}}
{{-- ========================================================= --}}

@extends('layouts.superadmin')

@section('content')


{{-- HEADER --}}
<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-3xl font-bold text-[#0F0937]">Master Fasilitas Kost</h1>
        <p class="text-gray-500 mt-2">Kelola data fasilitas yang digunakan seluruh kost.</p>
    </div>
    <div class="flex gap-3">
        <a href="{{ route('superadmin.fasilitas.create') }}"
            class="bg-[#6C8B6B] hover:bg-[#5B765A] text-white px-5 py-2.5 rounded-xl font-medium text-sm transition">
            + Tambah fasilitas
        </a>
        <a href="{{ route('superadmin.dashboard') }}"
            class="bg-gray-100 hover:bg-gray-200 text-gray-600 px-5 py-2.5 rounded-xl font-medium text-sm transition">
            Kembali
        </a>
    </div>
</div>

{{-- TABLE --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-[#E6F4EC]">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500">ID</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500">Nama Fasilitas</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($items as $i)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-xs text-gray-400">
                        #{{ $i->id_fasilitas }}
                    </td>
                    <td class="px-6 py-4 text-sm text-[#0F0937]">
                        {{ $i->nama_fasilitas }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex gap-2">
                            <a href="{{ route('superadmin.fasilitas.edit', $i) }}"
                                class="bg-[#E6F1FB] hover:bg-[#B5D4F4] text-[#0C447C] px-3 py-1.5 rounded-lg text-xs font-medium transition">
                                Edit
                            </a>
                            <form method="POST" action="{{ route('superadmin.fasilitas.destroy', $i) }}"
                                onsubmit="return confirm('Hapus fasilitas ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="bg-[#FCEBEB] hover:bg-[#F7C1C1] text-[#791F1F] px-3 py-1.5 rounded-lg text-xs font-medium transition">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="px-6 py-12 text-center text-sm text-gray-400">
                        Belum ada data fasilitas.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection