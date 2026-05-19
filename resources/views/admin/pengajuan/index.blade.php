@extends('layouts.admin')

@section('content')

<div class="flex items-center justify-between mb-8">

    <div>

        <h1 class="text-3xl font-bold text-[#0F0937]">

            Pengajuan Penghuni

        </h1>

        <p class="text-gray-500 mt-2">

            Daftar penghuni yang sedang
            menunggu persetujuan.

        </p>

    </div>

</div>

<div class="bg-white rounded-2xl
            shadow-sm border border-gray-100
            overflow-hidden">

    <div class="overflow-x-auto">

        <table class="w-full">

            {{-- HEADER --}}
            <thead class="bg-[#F8F5F0]">

                <tr>

                    <th class="px-6 py-4 text-left
                               text-sm font-semibold
                               text-gray-600">

                        Nama

                    </th>

                    <th class="px-6 py-4 text-left
                               text-sm font-semibold
                               text-gray-600">

                        Username

                    </th>

                    <th class="px-6 py-4 text-left
                               text-sm font-semibold
                               text-gray-600">

                        No HP

                    </th>

                    <th class="px-6 py-4 text-left
                               text-sm font-semibold
                               text-gray-600">

                        Status

                    </th>

                    <th class="px-6 py-4 text-left
                               text-sm font-semibold
                               text-gray-600">

                        Tanggal Pengajuan

                    </th>

                    <th class="px-6 py-4 text-left
                               text-sm font-semibold
                               text-gray-600">

                        Aksi

                    </th>

                </tr>

            </thead>

            {{-- BODY --}}
            <tbody class="divide-y divide-gray-100">

                @forelse($items as $i)

                    <tr class="hover:bg-gray-50">

                        {{-- NAMA --}}
                        <td class="px-6 py-4">

                            <div class="flex items-center gap-3">

                                <div
                                    class="w-11 h-11 rounded-full
                                           overflow-hidden"
                                >

                                    <img
                                        src="https://ui-avatars.com/api/?name={{ $i->user->nama }}"
                                        class="w-full h-full object-cover"
                                    >

                                </div>

                                <div>

                                    <h4 class="font-semibold">

                                        {{ $i->user->nama }}

                                    </h4>

                                    <p class="text-sm text-gray-400">

                                        {{ $i->user->nik }}

                                    </p>

                                </div>

                            </div>

                        </td>

                        {{-- USERNAME --}}
                        <td class="px-6 py-4">

                            {{ $i->user->username }}

                        </td>

                        {{-- HP --}}
                        <td class="px-6 py-4">

                            {{ $i->user->no_hp }}

                        </td>

                        {{-- STATUS --}}
                        <td class="px-6 py-4">

                            <span
                                class="px-4 py-2 rounded-xl
                                       bg-yellow-100
                                       text-yellow-700
                                       text-sm font-semibold"
                            >

                                Menunggu

                            </span>

                        </td>

                        {{-- TANGGAL --}}
                        <td class="px-6 py-4">

                            {{ $i->created_at->format('d M Y') }}

                        </td>

                        {{-- AKSI --}}
                        <td class="px-6 py-4">

                            <a
                                href="#"
                                class="bg-[#6C8B6B]
                                       hover:bg-[#5B765A]
                                       text-white px-5 py-2
                                       rounded-xl text-sm
                                       font-semibold transition"
                            >

                                Detail

                            </a>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="6"
                            class="px-6 py-12
                                   text-center text-gray-500"
                        >

                            Belum ada pengajuan penghuni

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection