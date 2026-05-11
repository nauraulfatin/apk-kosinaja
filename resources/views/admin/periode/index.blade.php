{{-- ========================================================= --}}
{{-- resources/views/admin/periode/index.blade.php --}}
{{-- ========================================================= --}}

@extends('layouts.admin')

@section('content')

<div class="flex items-center justify-between mb-8">

    <div>

        <h1 class="text-3xl font-bold text-[#0F0937]">
            Periode Penagihan
        </h1>

        <p class="text-gray-500 mt-2">
            Kelola periode dan interval penagihan kost.
        </p>

    </div>

    <div class="flex gap-3">

        <a
            href="{{ route('admin.periode.create') }}"
            class="bg-[#6C8B6B] hover:bg-[#5B765A] text-white px-5 py-3 rounded-xl font-semibold transition"
        >

            Tambah Periode

        </a>

        <a
            href="{{ route('admin.dashboard') }}"
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
                        ID
                    </th>

                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                        Nama Periode
                    </th>

                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                        Interval Penagihan
                    </th>

                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                        Aksi
                    </th>

                </tr>

            </thead>

            <tbody class="divide-y divide-gray-100">

                @forelse($items as $i)

                <tr class="hover:bg-gray-50">

                    {{-- ID --}}
                    <td class="px-6 py-4 font-medium text-[#0F0937]">

                        #{{ $i->id_penagihan }}

                    </td>

                    {{-- PERIODE --}}
                    <td class="px-6 py-4">

                        <div class="font-semibold text-[#0F0937]">

                            {{ $i->periode_penagihan }}

                        </div>

                    </td>

                    {{-- INTERVAL --}}
                    <td class="px-6 py-4 text-gray-600">

                        Setiap
                        <span class="font-semibold">

                            {{ $i->jumlah_interval }}
                            {{ $i->satuan_interval }}

                        </span>

                    </td>

                    {{-- AKSI --}}
                    <td class="px-6 py-4">

                        <div class="flex flex-wrap gap-2">

                            <a
                                href="{{ route('admin.periode.edit', $i) }}"
                                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm"
                            >

                                Edit

                            </a>

                            <form
                                method="POST"
                                action="{{ route('admin.periode.destroy', $i) }}"
                                onsubmit="return confirm('Hapus periode ini?')"
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

                        Belum ada data periode penagihan.

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection