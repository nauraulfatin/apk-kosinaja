{{-- ========================================================= --}}
{{-- resources/views/admin/kamar/harga/index.blade.php --}}
{{-- ========================================================= --}}

@extends('layouts.admin')

@section('content')

<div class="flex items-center justify-between mb-8">

    <div>

        <h1 class="text-3xl font-bold text-[#0F0937]">
            Harga Kamar
        </h1>

        <p class="text-gray-500 mt-2">
            Kelola harga dan periode penagihan untuk kamar:
            <span class="font-semibold text-[#0F0937]">
                {{ $kamar->nama_kamar }}
            </span>
        </p>

    </div>

    <div class="flex gap-3">

        <a
            href="{{ route('admin.kamar.harga.create', $kamar) }}"
            class="bg-[#6C8B6B] hover:bg-[#5B765A] text-white px-5 py-3 rounded-xl font-semibold transition"
        >

            Tambah Harga

        </a>

        <a
            href="{{ route('admin.kamar.index') }}"
            class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-3 rounded-xl font-semibold transition"
        >

            Kembali

        </a>

    </div>

</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

    <div class="overflow-x-auto">

        <table class="w-full">

            <thead class="bg-[#F8F5F0]">

                <tr>

                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                        Harga
                    </th>

                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                        Periode
                    </th>

                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                        Status
                    </th>

                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                        Aksi
                    </th>

                </tr>

            </thead>

            <tbody class="divide-y divide-gray-100">

                @forelse($items as $i)

                <tr class="hover:bg-gray-50">

                    {{-- HARGA --}}
                    <td class="px-6 py-4 font-semibold text-[#0F0937]">

                        Rp {{ number_format($i->harga, 0, ',', '.') }}

                    </td>

                    {{-- PERIODE --}}
                    <td class="px-6 py-4">

                        <div class="font-medium text-[#0F0937]">

                            {{ $i->periode?->periode_penagihan }}

                        </div>

                        <div class="text-sm text-gray-500">

                            Setiap
                            {{ $i->periode?->jumlah_interval }}
                            {{ $i->periode?->satuan_interval }}

                        </div>

                    </td>

                    {{-- STATUS --}}
                    <td class="px-6 py-4">

                        @if($i->isactive)

                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">

                            Aktif

                        </span>

                        @else

                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-600">

                            Tidak Aktif

                        </span>

                        @endif

                    </td>

                    {{-- AKSI --}}
                    <td class="px-6 py-4">

                        <div class="flex flex-wrap gap-2">

                            <a
                                href="{{ route('admin.kamar.harga.edit', [$kamar, $i]) }}"
                                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm"
                            >

                                Edit

                            </a>

                            <form
                                method="POST"
                                action="{{ route('admin.kamar.harga.destroy', [$kamar, $i]) }}"
                                onsubmit="return confirm('Hapus harga kamar ini?')"
                            >

                                @csrf
                                @method('DELETE')

                                <button
                                    class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm"
                                >

                                    Hapus

                                </button>

                            </form>

                        </div>

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="4" class="px-6 py-10 text-center text-gray-500">

                        Belum ada data harga kamar.

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection