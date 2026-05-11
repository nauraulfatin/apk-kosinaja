@extends('layouts.app')

@section('content')

<div class="min-h-screen flex items-center justify-center px-6">

    <div class="bg-white rounded-2xl shadow-xl p-10 w-full max-w-md">

        <div class="text-center mb-8">

            <img
                src="{{ asset('logo.png') }}"
                class="h-14 mx-auto mb-4"
            >

            <h1 class="text-2xl font-bold text-[#0F0937]">
                Ganti Password Awal
            </h1>

            <p class="text-gray-500 mt-2">
                Demi keamanan akun, silakan ganti password default Anda
            </p>

        </div>

        <form method="POST">
            @csrf

            <div class="mb-4">

                <label class="text-sm text-gray-500">
                    Password Baru
                </label>

                <input
                    type="password"
                    name="password"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3"
                >

            </div>

            <div class="mb-6">

                <label class="text-sm text-gray-500">
                    Konfirmasi Password
                </label>

                <input
                    type="password"
                    name="password_confirmation"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3"
                >

            </div>

            <button
                type="submit"
                class="w-full bg-[#6C8B6B] hover:bg-[#5a7a59] text-white font-semibold py-4 rounded-lg transition"
            >
                Simpan Password
            </button>

        </form>

    </div>

</div>

@endsection