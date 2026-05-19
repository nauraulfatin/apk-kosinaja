@extends('layouts.admin')

@section('content')

<div class="flex items-center justify-between mb-8">

    <div>

        <h1 class="text-3xl font-bold text-[#0F0937]">

            Data Penghuni

        </h1>

        <p class="text-gray-500 mt-2">

            Kelola daftar penghuni kost anda.

        </p>

    </div>

    <a
        href="{{ route('admin.penghuni.create') }}"
        class="bg-[#6C8B6B] hover:bg-[#5B765A] text-white px-5 py-3 rounded-xl font-semibold transition"
    >

        Tambah Penghuni

    </a>

</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

    <div class="overflow-x-auto">

        <table class="w-full">

            <thead class="bg-[#F8F5F0]">

                <tr>

                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                        Nama
                    </th>

                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                        Username
                    </th>

                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                        Kamar Aktif
                    </th>

                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                        Tanggal Masuk
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

                    @php

                        $hunian = $i->riwayatHunian
                            ->where('status', 'aktif')
                            ->first();

                    @endphp

                    <tr class="hover:bg-gray-50">

                        {{-- NAMA --}}
                        <td class="px-6 py-4">

                            <div class="font-semibold text-gray-800">

                                {{ $i->nama }}

                            </div>

                        </td>

                        {{-- USERNAME --}}
                        <td class="px-6 py-4 text-gray-600">

                            {{ $i->username }}

                        </td>

                        {{-- KAMAR --}}
                        <td class="px-6 py-4 text-gray-600">

                            @if($hunian)

                                {{ $hunian->kamar->nama_kamar }}
                                -
                                {{ $hunian->kamar->nomor_kamar }}

                            @else

                                -

                            @endif

                        </td>

                        {{-- TANGGAL MASUK --}}
                        <td class="px-6 py-4 text-gray-600">

                            @if($hunian)

                                {{ $hunian->tanggal_masuk->format('d M Y') }}

                            @else

                                -

                            @endif

                        </td>

                        {{-- STATUS --}}
                        <td class="px-6 py-4">

                            @if($hunian?->status == 'aktif')

                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">

                                    Aktif

                                </span>

                            @else

                                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">

                                    Nonaktif

                                </span>

                            @endif

                        </td>

                        {{-- AKSI --}}
                        <td class="px-6 py-4">

                            <div class="flex gap-2">

                                {{-- EDIT --}}
                                <a
                                    href="{{ route('admin.penghuni.edit', $i) }}"
                                    class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm"
                                >

                                    Edit

                                </a>

                                {{-- NONAKTIFKAN --}}
                                <form
                                    method="POST"
                                    action="{{ route('admin.penghuni.destroy', $i) }}"
                                    onsubmit="return confirm('Nonaktifkan penghuni ini?')"
                                >

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm"
                                    >

                                        Nonaktifkan

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="6"
                            class="px-6 py-10 text-center text-gray-500"
                        >

                            Belum ada data penghuni

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection