@extends('layouts.admin')

@section('content')

{{-- ========================================================= --}}
{{-- HEADER --}}
{{-- ========================================================= --}}
<div class="mb-8">

    <h1 class="text-3xl font-bold text-[#0F0937]">
        Dashboard Admin Kost
    </h1>

    <p class="text-gray-500 mt-2">
        Kelola usaha kost anda dengan mudah.
    </p>

</div>

{{-- ========================================================= --}}
{{-- CARD INFO --}}
{{-- ========================================================= --}}
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">

    {{-- NAMA KOST --}}
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">

        <div class="flex items-center justify-between">

            <div>

                <p class="text-sm text-gray-500">
                    Nama Kost
                </p>

                <h2 class="text-xl font-bold text-[#0F0937] mt-2">
                    {{ $kost?->nama_kost ?? '-' }}
                </h2>

            </div>

            <div>

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-8 w-8 text-[#0F0937]"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M3 10.5L12 3l9 7.5M5 9.5V20h14V9.5"
                    />

                </svg>

            </div>

        </div>

    </div>

    {{-- TOTAL KAMAR --}}
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">

        <div class="flex items-center justify-between">

            <div>

                <p class="text-sm text-gray-500">
                    Total Kamar
                </p>

                <h2 class="text-3xl font-bold text-[#0F0937] mt-2">
                    {{ $totalKamar ?? 0 }}
                </h2>

            </div>

            <div>

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-8 w-8 text-[#0F0937]"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M3 7h18M3 12h18M3 17h18"
                    />

                </svg>

            </div>

        </div>

    </div>

    {{-- TOTAL PENGHUNI --}}
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">

        <div class="flex items-center justify-between">

            <div>

                <p class="text-sm text-gray-500">
                    Penghuni
                </p>

                <h2 class="text-3xl font-bold text-[#0F0937] mt-2">
                    {{ $totalPenghuni ?? 0 }}
                </h2>

            </div>

            <div>

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-8 w-8 text-[#0F0937]"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                    />

                </svg>

            </div>

        </div>

    </div>

    {{-- PEMBAYARAN PENDING --}}
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">

        <div class="flex items-center justify-between">

            <div>

                <p class="text-sm text-gray-500">
                    Pembayaran Pending
                </p>

                <h2 class="text-3xl font-bold text-[#0F0937] mt-2">
                    {{ $pendingPembayaran ?? 0 }}
                </h2>

            </div>

            <div>

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-8 w-8 text-[#0F0937]"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 1v22m5-18H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H7"
                    />

                </svg>

            </div>

        </div>

    </div>

</div>

{{-- ========================================================= --}}
{{-- DASHBOARD BAWAH --}}
{{-- ========================================================= --}}
<div class="grid grid-cols-1 xl:grid-cols-2 gap-6">

    {{-- ========================================================= --}}
    {{-- PEMBAYARAN TERBARU --}}
    {{-- ========================================================= --}}
    <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100">

        <div class="flex items-center justify-between mb-6">

            <div>

                <h2 class="text-xl font-bold text-[#0F0937]">
                    Pembayaran Terbaru
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Lihat dan konfirmasi pembayaran penghuni.
                </p>

            </div>

        </div>

        @forelse($pembayaranTerbaru ?? [] as $item)

        <div
            class="flex items-center justify-between py-4 border-b border-gray-100 last:border-0"
        >

            <div>

                <h3 class="font-semibold text-[#0F0937]">
                    {{ $item->user?->nama }}
                </h3>

                <p class="text-sm text-gray-500 mt-1">
                    {{ $item->tanggal_bayar?->format('d M Y') }}
                </p>

            </div>

            <div class="text-right">

                <h3 class="font-bold text-[#0F0937]">
                    Rp {{ number_format($item->nominal_pembayaran,0,',','.') }}
                </h3>

                <span
                    class="inline-flex mt-2 px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700"
                >

                    {{ ucfirst($item->status ?? 'pending') }}

                </span>

            </div>

        </div>

        @empty

        <div class="text-center py-10 text-gray-400">
            Belum ada pembayaran terbaru.
        </div>

        @endforelse

        <div class="mt-6">

            <a
                href="{{ route('admin.tagihan.index') }}"
                class="text-sm font-semibold text-[#6C8B6B] hover:underline"
            >

                Lihat Semua

            </a>

        </div>

    </div>

    {{-- ========================================================= --}}
    {{-- ADUAN TERBARU --}}
    {{-- ========================================================= --}}
    <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100">

        <div class="flex items-center justify-between mb-6">

            <div>

                <h2 class="text-xl font-bold text-[#0F0937]">
                    Aduan Terbaru
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Keluhan terbaru dari penghuni kost.
                </p>

            </div>

        </div>

        @forelse($aduanTerbaru ?? [] as $item)

        <div
            class="py-4 border-b border-gray-100 last:border-0"
        >

            <div class="flex items-center justify-between">

                <h3 class="font-semibold text-[#0F0937]">
                    {{ $item->user?->nama }}
                </h3>

                <span
                    class="inline-flex px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700"
                >

                    {{ $item->status ?? 'pending' }}

                </span>

            </div>

            <p class="text-sm text-gray-500 mt-2 line-clamp-2">
                {{ $item->isi_aduan }}
            </p>

        </div>

        @empty

        <div class="text-center py-10 text-gray-400">
            Belum ada aduan terbaru.
        </div>

        @endforelse

        <div class="mt-6">

            <a
                href="#"
                class="text-sm font-semibold text-[#6C8B6B] hover:underline"
            >

                Lihat Semua

            </a>

        </div>

    </div>

</div>

@endsection