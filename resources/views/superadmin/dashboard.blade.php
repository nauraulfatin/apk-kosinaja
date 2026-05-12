{{-- ========================================================= --}}
{{-- resources/views/superadmin/dashboard.blade.php --}}
{{-- ========================================================= --}}

@extends('layouts.superadmin')

@section('content')

{{-- ========================================================= --}}
{{-- HEADER --}}
{{-- ========================================================= --}}
<div class="mb-8">

    <h1 class="text-3xl font-bold text-[#0F0937]">
        Dashboard Super Admin
    </h1>

    <p class="text-gray-500 mt-2">
        Kelola pengajuan admin kost dan master fasilitas.
    </p>

</div>

{{-- ========================================================= --}}
{{-- STATISTIC CARD --}}
{{-- ========================================================= --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

    {{-- TOTAL MITRA --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">

        <div class="flex items-center justify-between">

            <div>

                <p class="text-sm text-gray-500 mb-2">
                    Total Mitra
                </p>

                <h2 class="text-4xl font-bold text-[#0F0937]">

                    {{ $admins->where('status', 'aktif')->count() }}

                </h2>

                <p class="text-sm text-gray-400 mt-2">
                    Admin kost aktif.
                </p>

            </div>

            <div
                class="w-16 h-16 rounded-2xl bg-[#D6E5D6] flex items-center justify-center text-3xl"
            >

                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>

            </div>

        </div>

    </div>

    {{-- TOTAL PENGAJUAN --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">

        <div class="flex items-center justify-between">

            <div>

                <p class="text-sm text-gray-500 mb-2">
                    Menunggu Verifikasi
                </p>

                <h2 class="text-4xl font-bold text-[#0F0937]">

                    {{ $admins->where('status', 'pending')->count() }}

                </h2>

                <p class="text-sm text-gray-400 mt-2">
                    Pengajuan admin kost baru.
                </p>

            </div>

            <div
                class="w-16 h-16 rounded-2xl bg-yellow-100 flex items-center justify-center text-3xl"
            >

                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>

            </div>

        </div>

    </div>

    {{-- TOTAL DITOLAK --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">

        <div class="flex items-center justify-between">

            <div>

                <p class="text-sm text-gray-500 mb-2">
                    Pengajuan Ditolak
                </p>

                <h2 class="text-4xl font-bold text-[#0F0937]">

                    {{ $admins->where('status', 'ditolak')->count() }}

                </h2>

                <p class="text-sm text-gray-400 mt-2">
                    Pengajuan tidak disetujui.
                </p>

            </div>

            <div
                class="w-16 h-16 rounded-2xl bg-red-100 flex items-center justify-center text-3xl"
            >

                <svg xmlns="http://www.w3.org/2000/svg"
     class="h-5 w-5"
     fill="none"
     viewBox="0 0 24 24"
     stroke="currentColor">

    <path
        stroke-linecap="round"
        stroke-linejoin="round"
        stroke-width="2"
        d="M6 18L18 6M6 6l12 12"
    />

</svg>

            </div>

        </div>

    </div>

</div>

{{-- ========================================================= --}}
{{-- PENGAJUAN TERBARU --}}
{{-- ========================================================= --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

    {{-- HEADER --}}
    <div class="px-6 py-5 border-b border-gray-100 bg-[#F8F5F0]">

        <div class="flex items-center justify-between">

            <div>

                <h2 class="text-xl font-bold text-[#0F0937]">
                    Pengajuan Terbaru
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Daftar admin kost yang belum diverifikasi.
                </p>

            </div>

        </div>

    </div>

    {{-- TABLE --}}
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
                        Aksi
                    </th>

                </tr>

            </thead>

            <tbody class="divide-y divide-gray-100">

                @php
                    $pendingAdmins = $admins
                        ->where('status', 'pending')
                        ->sortByDesc('created_at')
                        ->take(5);
                @endphp

                @forelse($pendingAdmins as $u)

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
                        colspan="6"
                        class="px-6 py-10 text-center text-gray-500"
                    >

                        Belum ada pengajuan admin kost.

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    {{-- FOOTER --}}
    @if($pendingAdmins->count())

    <div class="px-6 py-4 border-t border-gray-100 bg-[#FAFAFA]">

        <a
            href="{{ route('superadmin.pengajuan.index') }}"
            class="text-[#3A5C3A] hover:underline font-semibold text-sm"
        >

            Lihat Semua Pengajuan

        </a>

    </div>

    @endif

</div>

@endsection