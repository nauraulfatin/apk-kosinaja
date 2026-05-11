{{-- ========================================================= --}}
{{-- resources/views/superadmin/fasilitas/index.blade.php --}}
{{-- ========================================================= --}}

@extends('layouts.superadmin')

@section('content')

{{-- ========================================================= --}}
{{-- HEADER --}}
{{-- ========================================================= --}}
<div class="flex items-center justify-between mb-8">

    <div>

        <h1 class="text-3xl font-bold text-[#0F0937]">
            Master Fasilitas Kost
        </h1>

        <p class="text-gray-500 mt-2">
            Kelola data fasilitas yang digunakan seluruh kost.
        </p>

    </div>

    <div class="flex gap-3">

        {{-- TAMBAH --}}
        <a
            href="{{ route('superadmin.fasilitas.create') }}"
            class="bg-[#6C8B6B] hover:bg-[#5B765A] text-white px-5 py-3 rounded-xl font-semibold transition"
        >

            Tambah Fasilitas

        </a>

        {{-- KEMBALI --}}
        <a
            href="{{ route('superadmin.dashboard') }}"
            class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-3 rounded-xl font-semibold transition"
        >

            Kembali

        </a>

    </div>

</div>

{{-- ========================================================= --}}
{{-- TABLE --}}
{{-- ========================================================= --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

    <div class="overflow-x-auto">

        <table class="w-full">

            <thead class="bg-[#F8F5F0]">

                <tr>

                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                        ID
                    </th>

                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                        Nama Fasilitas
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
                    <td class="px-6 py-5 font-medium text-[#0F0937]">

                        #{{ $i->id_fasilitas }}

                    </td>

                    {{-- NAMA --}}
                    <td class="px-6 py-5">

                        <div class="font-semibold text-[#0F0937]">

                            {{ $i->nama_fasilitas }}

                        </div>

                    </td>

                    {{-- AKSI --}}
                    <td class="px-6 py-5">

                        <div class="flex flex-wrap gap-2">

                            {{-- EDIT --}}
                            <a
                                href="{{ route('superadmin.fasilitas.edit', $i) }}"
                                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-xl text-sm font-semibold transition"
                            >

                                Edit

                            </a>

                            {{-- HAPUS --}}
                            <form
                                method="POST"
                                action="{{ route('superadmin.fasilitas.destroy', $i) }}"
                                onsubmit="return confirm('Hapus fasilitas ini?')"
                            >

                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-xl text-sm font-semibold transition"
                                >

                                    Hapus

                                </button>

                            </form>

                        </div>

                    </td>

                </tr>

                @empty

                <tr>

                    <td
                        colspan="3"
                        class="px-6 py-10 text-center text-gray-500"
                    >

                        Belum ada data fasilitas.

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection