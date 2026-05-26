{{-- ========================================================= --}}
{{-- resources/views/admin/kamar/index.blade.php --}}
{{-- ========================================================= --}}

@extends('layouts.admin')

@section('content')

<div class="flex items-center justify-between mb-8">

    <div>

        <h1 class="text-3xl font-bold text-[#0F0937]">
            Daftar Kamar
        </h1>

        <p class="text-gray-500 mt-2">
            Kelola daftar kamar kost anda
        </p>

    </div>

    <a href="{{ route('admin.kamar.create') }}" class="inline-flex items-center gap-2 bg-[#6C8B6B] hover:bg-[#5B765A]
              text-white px-5 py-2.5 rounded-xl font-semibold text-sm transition">
        + Tambah Kamar
    </a>

</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

    <div class="overflow-x-auto">

        <table class="w-full">

            <thead class="bg-[#F8F5F0]">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Nama
                        Kamar</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Nomor
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Ukuran
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Status
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Aksi
                    </th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">

                @forelse($items as $i)

                <tr class="hover:bg-gray-50 transition-colors">

                    {{-- NAMA --}}
                    <td class="px-6 py-4 text-sm font-medium text-gray-800">
                        {{ $i->nama_kamar }}
                    </td>

                    {{-- NOMOR --}}
                    <td class="px-6 py-4 text-sm text-gray-600">
                        {{ $i->nomor_kamar }}
                    </td>

                    {{-- UKURAN --}}
                    <td class="px-6 py-4 text-sm text-gray-600">
                        {{ $i->ukuran_kamar }}
                    </td>

                    {{-- STATUS --}}
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                            {{ $i->status == 'kosong'
                                ? 'bg-green-100 text-green-700'
                                : 'bg-red-100 text-red-700' }}">
                            {{ ucfirst($i->status) }}
                        </span>
                    </td>

                    {{-- AKSI --}}
                    <td class="px-6 py-4">

                        <div class="flex flex-wrap gap-2">

                            {{-- EDIT --}}
                            <a href="{{ route('admin.kamar.edit', $i) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full
                                      bg-blue-50 text-blue-700 hover:bg-blue-100
                                      text-xs font-medium transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                                </svg>
                                Edit
                            </a>

                            {{-- FASILITAS --}}
                            <a href="{{ route('admin.kamar.fasilitas.edit', $i) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full
                                      bg-amber-50 text-amber-700 hover:bg-amber-100
                                      text-xs font-medium transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M20 9V6a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v3" />
                                    <path
                                        d="M2 11v5a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-5a2 2 0 0 0-4 0v2H6v-2a2 2 0 0 0-4 0z" />
                                    <path d="M4 19v2M20 19v2" />
                                </svg>
                                Fasilitas
                            </a>

                            {{-- HARGA --}}
                            <a href="{{ route('admin.kamar.harga.index', $i) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full
                                      bg-green-50 text-green-700 hover:bg-green-100
                                      text-xs font-medium transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path
                                        d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z" />
                                    <line x1="7" y1="7" x2="7.01" y2="7" />
                                </svg>
                                Harga
                            </a>

                            {{-- HAPUS --}}
                            <form method="POST" action="{{ route('admin.kamar.destroy', $i) }}"
                                onsubmit="return confirm('Hapus kamar ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full
                                               bg-red-50 text-red-700 hover:bg-red-100
                                               text-xs font-medium transition-colors cursor-pointer">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <polyline points="3 6 5 6 21 6" />
                                        <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6" />
                                        <path d="M10 11v6M14 11v6" />
                                        <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2" />
                                    </svg>
                                    Hapus
                                </button>
                            </form>

                        </div>

                    </td>

                </tr>

                @empty

                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-sm text-gray-400">
                        Belum ada data kamar
                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection