{{-- ========================================================= --}}
{{-- resources/views/superadmin/pengajuan/index.blade.php --}}
{{-- ========================================================= --}}

@extends('layouts.superadmin')

@section('content')

{{-- ========================================================= --}}
{{-- HEADER --}}
{{-- ========================================================= --}}
<div class="flex items-center justify-between mb-8">

    <div>

        <h1 class="text-3xl font-bold text-[#0F0937]">
            Pengajuan Admin Kost
        </h1>

        <p class="text-gray-500 mt-2">
            Daftar admin kost yang menunggu verifikasi.
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

                    {{-- HP --}}
                    <td class="px-6 py-5 text-gray-600">

                        {{ $u->no_hp }}

                    </td>

                    {{-- KOST --}}
                    <td class="px-6 py-5">

                        <div class="font-medium text-[#0F0937]">

                            {{ $u->kost?->nama_kost }}

                        </div>

                    </td>

                    {{-- STATUS --}}
                    <td class="px-6 py-5">

                        <span
                            class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-semibold"
                        >

                            Menunggu Verifikasi

                        </span>

                    </td>

                    {{-- AKSI --}}
                    <td class="px-6 py-5">

                        <a
                            href="{{ route('superadmin.admin.detail', $u) }}"
                            class="text-[#3A5C3A] hover:underline font-semibold"
                        >

                            Lihat Detail

                        </a>

                    </td>

                </tr>

                @empty

                <tr>

                    <td
                        colspan="7"
                        class="px-6 py-10 text-center text-gray-500"
                    >

                        Belum ada pengajuan admin kost.

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection