@extends('layouts.app')

@section('content')

<div class="flex min-h-screen bg-[#FDFAF4]">

    {{-- Kiri --}}
    <div class="hidden lg:block w-2/4 relative">
        <img
            src="{{ asset('pintu-kosin.jpeg') }}"
            class="absolute inset-0 w-full h-full object-cover"
        >
    </div>

    {{-- Kanan --}}
    <div class="w-full lg:w-3/4 flex items-center justify-center px-10 py-12">

        <div class="w-full max-w-lg">

            {{-- Logo --}}
            <div class="flex items-center mb-6">
                <img src="{{ asset('logo.png') }}" class="h-10 w-10 object-contain">
                <span class="text-2xl font-bold text-[#0F0937]">
                    KosinAja!
                </span>
            </div>

            <h1 class="text-2xl font-bold text-[#0F0937] mb-1">
                Selamat Datang
            </h1>

            <p class="text-gray-500 mb-8">
                Masuk dan lanjutkan aktivitas Anda di KosinAja!
            </p>

            <form method="POST" action="{{ route('login.post') }}">
                @csrf

                {{-- Username --}}
                <div class="mb-4">

                    <label class="text-sm text-gray-500 mb-1 block">
                        Username
                    </label>

                    <input
                        type="text"
                        name="username"
                        value="{{ old('username') }}"
                        placeholder="Username"
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-[#6C8B6B] focus:border-[#6C8B6B]"
                    >
                </div>

                {{-- Password --}}
                <div class="mb-6">

                    <label class="text-sm text-gray-500 mb-1 block">
                        Password
                    </label>

                    <div class="relative">

                        <input
                            id="password"
                            type="password"
                            name="password"
                            placeholder="Password"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 pr-10 focus:ring-[#6C8B6B] focus:border-[#6C8B6B]"
                        >

                        <button
                            type="button"
                            onclick="togglePassword('password')"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400"
                        >
                            👁
                        </button>

                    </div>

                </div>

                {{-- Button --}}
                <button
                    type="submit"
                    class="w-full bg-[#6C8B6B] hover:bg-[#5a7a59] text-white font-semibold py-4 rounded-lg transition"
                >
                    Masuk
                </button>

                {{-- Register --}}
                <p class="text-center text-sm text-gray-500 mt-4">

                    Belum punya akun?

                    <a
                        href="{{ route('admin-kost.register') }}"
                        class="text-[#6C8B6B] font-semibold hover:underline"
                    >
                        Daftar Sekarang
                    </a>

                </p>

            </form>

        </div>
    </div>
</div>

<script>
function togglePassword(id) {
    const input = document.getElementById(id);
    input.type = input.type === 'password'
        ? 'text'
        : 'password';
}
</script>

@endsection