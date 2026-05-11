{{-- ========================================================= --}}
{{-- resources/views/superadmin/riwayat/index.blade.php --}}
{{-- ========================================================= --}}

@extends('layouts.superadmin')

@section('content')

{{-- ========================================================= --}}
{{-- HEADER --}}
{{-- ========================================================= --}}
<div class="flex items-center justify-between mb-8">

    <div>

        <h1 class="text-3xl font-bold text-[#0F0937]">
            Riwayat Pengajuan
        </h1>

        <p class="text-gray-500 mt-2">
            Daftar seluruh pengajuan admin kost yang sudah diverifikasi.
        </p>

    </div>

    {{-- KEMBALI --}}
    <a
        href="{{ route('superadmin.dashboard') }}"
        class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-3 rounded-xl font-semibold transition"
    >

        Kembali

    </a>

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
                        No
                    </th>

                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                        Nama
                    </th>

                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                        Username
                    </th>

                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                        No HP
                    </th>

                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                        Nama Kost
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

                @forelse($items as $u)

                <tr class="hover:bg-gray-50">

                    {{-- NO --}}
                    <td class="px-6 py-5">

                        {{ $loop->iteration }}

                    </td>

                    {{-- NAMA --}}
                    <td class="px-6 py-5">

                        <div class="font-semibold text-[#0F0937]">

                            {{ $u->nama }}

                        </div>

                    </td>

                    {{-- USERNAME --}}
                    <td class="px-6 py-5 text-gray-600">

                        {{ $u->username }}

                    </td>

                    {{-- NO HP --}}
                    <td class="px-6 py-5 text-gray-600">

                        {{ $u->no_hp }}

                    </td>

                    {{-- NAMA KOST --}}
                    <td class="px-6 py-5">

                        <div class="font-medium text-[#0F0937]">

                            {{ $u->kost?->nama_kost }}

                        </div>

                    </td>

                    {{-- STATUS --}}
                    <td class="px-6 py-5">

                        @if($u->status === 'aktif')

                        <span
                            class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold"
                        >

                            Disetujui

                        </span>

                        @elseif($u->status === 'ditolak')

                        <span
                            class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-semibold"
                        >

                            Ditolak

                        </span>

                        @endif

                    </td>

                    {{-- AKSI --}}
                    <td class="px-6 py-5">

                        <a
                            href="{{ route('superadmin.riwayat.edit', $u) }}"
                            class="text-[#3A5C3A] hover:underline font-semibold"
                        >

                            Edit

                        </a>

                    </td>

                </tr>

                @empty

                <tr>

                    <td
                        colspan="7"
                        class="px-6 py-10 text-center text-gray-500"
                    >

                        Belum ada riwayat pengajuan admin kost.

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection