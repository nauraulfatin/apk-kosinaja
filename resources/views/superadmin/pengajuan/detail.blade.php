{{-- ========================================================= --}}
{{-- resources/views/superadmin/pengajuan/detail.blade.php --}}
{{-- ========================================================= --}}

@extends('layouts.superadmin')

@section('content')

{{-- ========================================================= --}}
{{-- HEADER --}}
{{-- ========================================================= --}}
<div class="flex items-center justify-between mb-8">

    <div>

        <h1 class="text-3xl font-bold text-[#0F0937]">
            Detail Pengajuan Admin Kost
        </h1>

        <p class="text-gray-500 mt-2">
            Verifikasi data pengajuan admin kost.
        </p>

    </div>

    {{-- KEMBALI --}}
    <a
        href="{{ route('superadmin.pengajuan.index') }}"
        class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-3 rounded-xl font-semibold transition"
    >

        Kembali

    </a>

</div>

{{-- ========================================================= --}}
{{-- DETAIL --}}
{{-- ========================================================= --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

    {{-- HEADER --}}
    <div class="px-6 py-5 border-b border-gray-100 bg-[#F8F5F0]">

        <h2 class="text-xl font-bold text-[#0F0937]">
            Informasi Admin Kost
        </h2>

    </div>

    {{-- CONTENT --}}
    <div class="p-8">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

            {{-- NAMA --}}
            <div>

                <p class="text-sm text-gray-500 mb-2">
                    Nama Lengkap
                </p>

                <h3 class="font-semibold text-[#0F0937]">
                    {{ $user->nama }}
                </h3>

            </div>

            {{-- USERNAME --}}
            <div>

                <p class="text-sm text-gray-500 mb-2">
                    Username
                </p>

                <h3 class="font-semibold text-[#0F0937]">
                    {{ $user->username }}
                </h3>

            </div>

            {{-- NIK --}}
            <div>

                <p class="text-sm text-gray-500 mb-2">
                    NIK
                </p>

                <h3 class="font-semibold text-[#0F0937]">
                    {{ $user->nik }}
                </h3>

            </div>

            {{-- NO HP --}}
            <div>

                <p class="text-sm text-gray-500 mb-2">
                    Nomor HP
                </p>

                <h3 class="font-semibold text-[#0F0937]">
                    {{ $user->no_hp }}
                </h3>

            </div>

            {{-- NAMA KOST --}}
            <div>

                <p class="text-sm text-gray-500 mb-2">
                    Nama Kost
                </p>

                <h3 class="font-semibold text-[#0F0937]">
                    {{ $user->kost?->nama_kost }}
                </h3>

            </div>

            {{-- ALAMAT --}}
            <div>

                <p class="text-sm text-gray-500 mb-2">
                    Alamat Kost
                </p>

                <h3 class="font-semibold text-[#0F0937]">
                    {{ $user->kost?->alamat }}
                </h3>

            </div>

        </div>

        {{-- DESKRIPSI --}}
        @if($user->kost?->deskripsi)

        <div class="mt-8">

            <p class="text-sm text-gray-500 mb-2">
                Deskripsi Kost
            </p>

            <div class="bg-[#F8F5F0] rounded-2xl p-5 text-gray-700 leading-relaxed">

                {{ $user->kost?->deskripsi }}

            </div>

        </div>

        @endif

        {{-- FOTO --}}
        @if($user->kost?->foto_kost)

        <div class="mt-8">

            <p class="text-sm text-gray-500 mb-3">
                Foto Kost
            </p>

            <img
                src="{{ asset('storage/' . $user->kost->foto_kost) }}"
                alt="Foto Kost"
                class="w-full max-w-xl rounded-2xl border border-gray-200"
            >

        </div>

        @endif

        {{-- GOOGLE MAPS --}}
        @if($user->kost?->lokasi)

        <div class="mt-8">

            <h3 class="text-lg font-semibold text-[#0F0937] mb-4">
                Lokasi Kost
            </h3>

            <div class="rounded-2xl overflow-hidden border border-gray-200">

                <iframe
                    src="{{ $user->kost->lokasi }}"
                    width="100%"
                    height="450"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                ></iframe>

            </div>

        </div>

        @endif

        {{-- ACTION --}}
        <div class="flex flex-wrap gap-3 mt-10">

            {{-- VALIDASI --}}
            <form
                method="POST"
                action="{{ route('superadmin.admin.validasi', $user) }}"
            >

                @csrf

                <button
                    type="submit"
                    class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-xl font-semibold transition"
                >

                    Terima Pengajuan

                </button>

            </form>

            {{-- TOLAK --}}
            <form
                method="POST"
                action="{{ route('superadmin.admin.tolak', $user) }}"
            >

                @csrf

                <button
                    type="submit"
                    class="bg-red-500 hover:bg-red-600 text-white px-6 py-3 rounded-xl font-semibold transition"
                >

                    Tolak Pengajuan

                </button>

            </form>

        </div>

    </div>

</div>

@endsection