@extends('layouts.admin')

@section('content')

{{-- HEADER --}}
<div class="mb-8">

    <h1 class="text-3xl font-bold text-[#0F0937]">
        Dashboard Admin Kost
    </h1>

    <p class="text-gray-500 mt-2">
        Kelola kost, kamar, penghuni, dan pembayaran dengan mudah.
    </p>

</div>

{{-- CARD INFO --}}
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">

    {{-- KOST --}}
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

            <div class="text-4xl">
                🏠
            </div>

        </div>

    </div>

    {{-- KAMAR --}}
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

            <div class="text-4xl">
                🛏
            </div>

        </div>

    </div>

    {{-- PENGHUNI --}}
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

            <div class="text-4xl">
                👥
            </div>

        </div>

    </div>

    {{-- TAGIHAN --}}
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

            <div class="text-4xl">
                💳
            </div>

        </div>

    </div>

</div>

{{-- MENU AKSI --}}
<div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100">

    <h2 class="text-xl font-bold text-[#0F0937] mb-6">
        Menu Pengelolaan
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">

        {{-- INFO KOST --}}
        <a href="{{ route('admin.kost.edit') }}"
           class="bg-[#F8F5F0] hover:bg-[#D6E5D6] transition rounded-2xl p-6 border border-gray-100">

            <div class="text-4xl mb-4">
                🏠
            </div>

            <h3 class="font-bold text-[#0F0937] text-lg mb-2">
                Update Informasi Kost
            </h3>

            <p class="text-sm text-gray-500">
                Kelola nama kost, alamat, deskripsi, dan foto kost.
            </p>

        </a>

        {{-- KAMAR --}}
        <a href="{{ route('admin.kamar.index') }}"
           class="bg-[#F8F5F0] hover:bg-[#D6E5D6] transition rounded-2xl p-6 border border-gray-100">

            <div class="text-4xl mb-4">
                🛏
            </div>

            <h3 class="font-bold text-[#0F0937] text-lg mb-2">
                CRUD Kamar
            </h3>

            <p class="text-sm text-gray-500">
                Tambah, edit, dan kelola kamar kost beserta fasilitas.
            </p>

        </a>

        {{-- PERIODE --}}
        <a href="{{ route('admin.periode.index') }}"
           class="bg-[#F8F5F0] hover:bg-[#D6E5D6] transition rounded-2xl p-6 border border-gray-100">

            <div class="text-4xl mb-4">
                📅
            </div>

            <h3 class="font-bold text-[#0F0937] text-lg mb-2">
                Periode Penagihan
            </h3>

            <p class="text-sm text-gray-500">
                Atur periode pembayaran harian, bulanan, semester, dll.
            </p>

        </a>

        {{-- PENGHUNI --}}
        <a href="{{ route('admin.penghuni.index') }}"
           class="bg-[#F8F5F0] hover:bg-[#D6E5D6] transition rounded-2xl p-6 border border-gray-100">

            <div class="text-4xl mb-4">
                👥
            </div>

            <h3 class="font-bold text-[#0F0937] text-lg mb-2">
                Penghuni
            </h3>

            <p class="text-sm text-gray-500">
                Kelola data penghuni dan penempatan kamar kost.
            </p>

        </a>

        {{-- TAGIHAN --}}
        <a href="{{ route('admin.tagihan.index') }}"
           class="bg-[#F8F5F0] hover:bg-[#D6E5D6] transition rounded-2xl p-6 border border-gray-100">

            <div class="text-4xl mb-4">
                💳
            </div>

            <h3 class="font-bold text-[#0F0937] text-lg mb-2">
                Validasi Pembayaran
            </h3>

            <p class="text-sm text-gray-500">
                Validasi pembayaran penghuni dan cek tagihan.
            </p>

        </a>

    </div>

</div>

@endsection