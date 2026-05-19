@extends('layouts.public')

@section('title', 'Profil Penghuni')

@section('content')

<div class="max-w-7xl mx-auto px-6 lg:px-8 py-10">

    {{-- ========================================================= --}}
    {{-- BREADCRUMB --}}
    {{-- ========================================================= --}}
    <div class="flex items-center gap-3 text-sm text-gray-400 mb-8">

        <a
            href="{{ route('home') }}"
            class="hover:text-[#6C8B6B]"
        >

            Beranda

        </a>

        <span>›</span>

        <span class="text-[#1B2B1D] font-medium">

            Profil Penghuni

        </span>

    </div>

    {{-- ========================================================= --}}
    {{-- MAIN CONTENT --}}
    {{-- ========================================================= --}}
    <div class="flex flex-col lg:flex-row gap-8 items-start">

        {{-- ========================================================= --}}
        {{-- LEFT : DATA DIRI --}}
        {{-- ========================================================= --}}
        <div class="w-full lg:w-[320px] shrink-0">

            <div class="bg-white rounded-[28px]
                        border border-[#EEF2EE]
                        shadow-sm p-8">

                {{-- TITLE --}}
                <h2 class="text-[24px]
                           font-bold text-[#1B2B1D]">

                    Data Diri

                </h2>

                {{-- FOTO --}}
                <div class="flex justify-center mt-8">

                    <div class="w-[130px] h-[130px]
                                rounded-full overflow-hidden
                                border-[6px] border-[#F4F7F4]">

                        <img
                            src="https://ui-avatars.com/api/?name={{ auth()->user()->nama }}"
                            class="w-full h-full object-cover"
                        >

                    </div>

                </div>

                {{-- INFO --}}
                <div class="mt-10 space-y-7">

                    {{-- NAMA --}}
                    <div class="flex gap-4">

                        <div class="text-[#6C8B6B]
                                    text-[18px] mt-[2px]">

                            👤

                        </div>

                        <div>

                            <p class="text-[13px] text-gray-400">

                                Nama Lengkap

                            </p>

                            <h4 class="text-[15px]
                                       font-semibold
                                       text-[#1B2B1D]
                                       mt-1 leading-6">

                                {{ auth()->user()->nama }}

                            </h4>

                        </div>

                    </div>

                    {{-- USERNAME --}}
                    <div class="flex gap-4">

                        <div class="text-[#6C8B6B]
                                    text-[18px] mt-[2px]">

                            ✉️

                        </div>

                        <div>

                            <p class="text-[13px] text-gray-400">

                                Username

                            </p>

                            <h4 class="text-[15px]
                                       font-semibold
                                       text-[#1B2B1D]
                                       mt-1 leading-6">

                                {{ auth()->user()->username }}

                            </h4>

                        </div>

                    </div>

                    {{-- HP --}}
                    <div class="flex gap-4">

                        <div class="text-[#6C8B6B]
                                    text-[18px] mt-[2px]">

                            📞

                        </div>

                        <div>

                            <p class="text-[13px] text-gray-400">

                                No. Handphone

                            </p>

                            <h4 class="text-[15px]
                                       font-semibold
                                       text-[#1B2B1D]
                                       mt-1 leading-6">

                                {{ auth()->user()->no_hp }}

                            </h4>

                        </div>

                    </div>

                    {{-- STATUS --}}
                    <div class="flex gap-4">

                        <div class="text-[#6C8B6B]
                                    text-[18px] mt-[2px]">

                            ✅

                        </div>

                        <div>

                            <p class="text-[13px] text-gray-400">

                                Status Akun

                            </p>

                            <div
                                class="inline-flex items-center
                                       px-4 py-2 rounded-xl
                                       bg-[#EAF7EA]
                                       text-[#4B8A4B]
                                       text-sm font-semibold
                                       mt-2"
                            >

                                Terverifikasi

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- ========================================================= --}}
        {{-- RIGHT : KOS SAYA --}}
        {{-- ========================================================= --}}
        <div class="flex-1 w-full">

            <div class="bg-white rounded-[28px]
                        border border-[#EEF2EE]
                        shadow-sm p-10">

                {{-- TITLE --}}
                <h2 class="text-[24px]
                           font-bold text-[#1B2B1D]">

                    Kos Saya

                </h2>

                {{-- EMPTY STATE --}}
                <div class="flex flex-col
                            items-center justify-center
                            text-center py-20">

                    {{-- IMAGE --}}
                    <img
                        src="{{ asset('empty-kost.png') }}"
                        class="w-[300px] object-contain"
                    >

                    {{-- TITLE --}}
                    <h3 class="text-[34px]
                               font-bold text-[#1B2B1D]
                               leading-[1.4]
                               mt-10">

                        Kamu belum terhubung
                        dengan kos manapun

                    </h3>

                    {{-- DESC --}}
                    <p class="text-gray-500
                              leading-8 text-[17px]
                              max-w-2xl mt-6">

                        Masukkan kode unik dari pemilik kost
                        untuk menghubungkan akunmu dan mulai
                        mengakses informasi kost.

                    </p>

                    {{-- BUTTON --}}
                    <button
                        class="mt-10 px-10 py-5
                               rounded-2xl
                               bg-[#22C55E]
                               hover:bg-[#16A34A]
                               text-white font-bold
                               text-[17px]
                               shadow-lg shadow-green-200
                               transition-all duration-300"
                    >

                        Masukkan kode dari pemilik

                    </button>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection