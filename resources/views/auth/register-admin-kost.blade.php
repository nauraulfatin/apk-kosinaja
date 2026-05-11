@extends('layouts.app')

@section('content')

<div class="flex min-h-screen bg-[#FDFAF4]">

    {{-- FORM --}}
    <div class="w-full lg:w-3/4 flex items-center justify-center px-10 py-12">

        <div class="w-full max-w-2xl">

            {{-- Logo --}}
            <div class="flex items-center mb-6">
                <img src="{{ asset('logo.png') }}" class="h-10 w-10">
                <span class="text-2xl font-bold text-[#0F0937]">
                    KosinAja!
                </span>
            </div>

            <h1 class="text-2xl font-bold text-[#0F0937] mb-1">
                Daftar Admin Kost
            </h1>

            <p class="text-gray-500 mb-8">
                Daftarkan kost Anda dan mulai kelola penghuni dengan mudah
            </p>

            <form method="POST" enctype="multipart/form-data">
                @csrf

                {{-- DATA USER --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <div>
                        <label class="text-sm text-gray-500">
                            Username
                        </label>

                        <input
                            type="text"
                            name="username"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3"
                        >
                    </div>

                    <div>
                        <label class="text-sm text-gray-500">
                            NIK
                        </label>

                        <input
                            type="text"
                            name="nik"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3"
                        >
                    </div>

                    <div>
                        <label class="text-sm text-gray-500">
                            Nama
                        </label>

                        <input
                            type="text"
                            name="nama"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3"
                        >
                    </div>

                    <div>
                        <label class="text-sm text-gray-500">
                            No HP
                        </label>

                        <input
                            type="text"
                            name="no_hp"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3"
                        >
                    </div>

                </div>

                {{-- PASSWORD --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">

                    <div>
                        <label class="text-sm text-gray-500">
                            Password
                        </label>

                        <input
                            type="password"
                            name="password"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3"
                        >
                    </div>

                    <div>
                        <label class="text-sm text-gray-500">
                            Konfirmasi Password
                        </label>

                        <input
                            type="password"
                            name="password_confirmation"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3"
                        >
                    </div>

                </div>

                {{-- DATA KOST --}}
                <div class="mt-8">

                    <h2 class="text-lg font-semibold text-[#0F0937] mb-4">
                        Data Kost
                    </h2>

                    <div class="mb-4">

                        <label class="text-sm text-gray-500">
                            Nama Kost
                        </label>

                        <input
                            type="text"
                            name="nama_kost"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3"
                        >
                    </div>

                    <div class="mb-4">

                        <label class="text-sm text-gray-500">
                            Alamat
                        </label>

                        <textarea
                            name="alamat"
                            rows="3"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3"
                        ></textarea>

                    </div>

                </div>

                {{-- BUTTON --}}
                <button
                    type="submit"
                    class="w-full bg-[#6C8B6B] hover:bg-[#5a7a59] text-white font-semibold py-4 rounded-lg transition"
                >
                    Daftar
                </button>

                {{-- LOGIN --}}
                <p class="text-center text-sm text-gray-500 mt-4">

                    Sudah punya akun?

                    <a
                        href="{{ route('login') }}"
                        class="text-[#6C8B6B] font-semibold hover:underline"
                    >
                        Masuk
                    </a>

                </p>

            </form>

        </div>
    </div>

</div>

@endsection