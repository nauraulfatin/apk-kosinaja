{{-- ========================================================= --}}
{{-- resources/views/admin/kamar/index.blade.php --}}
{{-- ========================================================= --}}

@extends('layouts.admin')

@section('content')

<div class="flex items-center justify-between mb-8">

    <div>

        <h1 class="text-3xl font-bold text-[#0F0937]">
            CRUD Kamar Kost
        </h1>

        <p class="text-gray-500 mt-2">
            Kelola data kamar kost.
        </p>

    </div>

    <a href="{{ route('admin.kamar.create') }}"
       class="bg-[#6C8B6B] hover:bg-[#5B765A] text-white px-5 py-3 rounded-xl font-semibold transition">

        Tambah Kamar

    </a>

</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

    <div class="overflow-x-auto">

        <table class="w-full">

            <thead class="bg-[#F8F5F0]">

                <tr>

                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                        Nama Kamar
                    </th>

                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                        Nomor
                    </th>

                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                        Ukuran
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

                @foreach($items as $i)

                <tr class="hover:bg-gray-50">

                    <td class="px-6 py-4">
                        {{ $i->nama_kamar }}
                    </td>

                    <td class="px-6 py-4">
                        {{ $i->nomor_kamar }}
                    </td>

                    <td class="px-6 py-4">
                        {{ $i->ukuran_kamar }}
                    </td>

                    <td class="px-6 py-4">

                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                        {{ $i->status == 'kosong'
                            ? 'bg-green-100 text-green-700'
                            : 'bg-red-100 text-red-700' }}">

                            {{ ucfirst($i->status) }}

                        </span>

                    </td>

                    <td class="px-6 py-4">

                        <div class="flex flex-wrap gap-2">

                            <a href="{{ route('admin.kamar.edit', $i) }}"
                               class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm">

                                Edit

                            </a>

                            <a href="{{ route('admin.kamar.fasilitas.edit', $i) }}"
                               class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg text-sm">

                                Fasilitas

                            </a>

                            <a href="{{ route('admin.kamar.harga.index', $i) }}"
                               class="bg-[#6C8B6B] hover:bg-[#5B765A] text-white px-4 py-2 rounded-lg text-sm">

                                Harga

                            </a>

                            <form
                                method="POST"
                                action="{{ route('admin.kamar.destroy', $i) }}"
                                onsubmit="return confirm('Hapus kamar ini?')"
                            >

                                @csrf
                                @method('DELETE')

                                <button
                                    class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm">

                                    Hapus

                                </button>

                            </form>

                        </div>

                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>

@endsection