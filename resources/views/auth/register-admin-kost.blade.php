@extends('layouts.app')

@section('content')

<div class="min-h-screen flex bg-[#F8F5F0]">

    {{-- ========================================================= --}}
    {{-- LEFT FORM --}}
    {{-- ========================================================= --}}
    <div
        class="w-full lg:w-1/2
               flex items-center justify-center
               px-6 py-10 lg:px-16"
    >

        <div class="w-full max-w-2xl">

            {{-- LOGO --}}
            <div class="flex items-center gap-3 mb-10">

                <img
                    src="{{ asset('logo.png') }}"
                    class="w-12 h-12 object-contain"
                >

                <div>

                    <h1 class="text-2xl font-bold text-[#0F0937]">
                        KosinAja!
                    </h1>

                    <p class="text-sm text-gray-500">
                        Sistem Manajemen Kost
                    </p>

                </div>

            </div>

            {{-- TITLE --}}
            <div class="mb-8">

                <h2 class="text-3xl font-bold text-[#0F0937]">

                    Daftar Admin Kost 👋

                </h2>

                <p class="text-gray-500 mt-2 leading-relaxed">

                    Mulai kelola kost anda dengan lebih
                    praktis dan modern bersama KosinAja.

                </p>

            </div>

            {{-- ERROR --}}
            @if($errors->any())

            <div
                class="mb-6 bg-red-50 border border-red-200
                       text-red-700 rounded-2xl px-5 py-4"
            >

                <ul class="space-y-1 text-sm">

                    @foreach($errors->all() as $e)

                    <li>
                        • {{ $e }}
                    </li>

                    @endforeach

                </ul>

            </div>

            @endif

            {{-- FORM --}}
            <form
                method="POST"
                enctype="multipart/form-data"
                class="space-y-8"
            >

                @csrf

                {{-- ========================================================= --}}
                {{-- DATA ADMIN --}}
                {{-- ========================================================= --}}
                <div>

                    <h3 class="text-lg font-semibold text-[#0F0937] mb-5">

                        Data Admin

                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                        {{-- USERNAME --}}
                        <div>

                            <label
                                class="block text-sm font-medium
                                       text-gray-700 mb-2"
                            >

                                Username

                            </label>

                            <input
                                type="text"
                                name="username"
                                value="{{ old('username') }}"
                                placeholder="Masukkan username"
                                class="w-full rounded-2xl
                                       border border-gray-200
                                       bg-white px-5 py-4
                                       focus:outline-none
                                       focus:ring-2
                                       focus:ring-[#6C8B6B]"
                            >

                        </div>

                        {{-- NIK --}}
                        <div>

                            <label
                                class="block text-sm font-medium
                                       text-gray-700 mb-2"
                            >

                                NIK

                            </label>

                            <input
                                type="text"
                                name="nik"
                                value="{{ old('nik') }}"
                                placeholder="Masukkan NIK"
                                class="w-full rounded-2xl
                                       border border-gray-200
                                       bg-white px-5 py-4
                                       focus:outline-none
                                       focus:ring-2
                                       focus:ring-[#6C8B6B]"
                            >

                        </div>

                        {{-- NAMA --}}
                        <div>

                            <label
                                class="block text-sm font-medium
                                       text-gray-700 mb-2"
                            >

                                Nama Lengkap

                            </label>

                            <input
                                type="text"
                                name="nama"
                                value="{{ old('nama') }}"
                                placeholder="Masukkan nama lengkap"
                                class="w-full rounded-2xl
                                       border border-gray-200
                                       bg-white px-5 py-4
                                       focus:outline-none
                                       focus:ring-2
                                       focus:ring-[#6C8B6B]"
                            >

                        </div>

                        {{-- HP --}}
                        <div>

                            <label
                                class="block text-sm font-medium
                                       text-gray-700 mb-2"
                            >

                                Nomor WhatsApp

                            </label>

                            <input
                                type="text"
                                name="no_hp"
                                value="{{ old('no_hp') }}"
                                placeholder="08xxxxxxxxxx"
                                class="w-full rounded-2xl
                                       border border-gray-200
                                       bg-white px-5 py-4
                                       focus:outline-none
                                       focus:ring-2
                                       focus:ring-[#6C8B6B]"
                            >

                        </div>

                    </div>

                </div>

                {{-- ========================================================= --}}
                {{-- PASSWORD --}}
                {{-- ========================================================= --}}
                <div>

                    <h3 class="text-lg font-semibold text-[#0F0937] mb-5">

                        Keamanan Akun

                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                        {{-- PASSWORD --}}
                        <div>

                            <label
                                class="block text-sm font-medium
                                       text-gray-700 mb-2"
                            >

                                Password

                            </label>

                            <div class="relative">

                                <input
                                    id="password"
                                    type="password"
                                    name="password"
                                    placeholder="Masukkan password"
                                    class="w-full rounded-2xl
                                           border border-gray-200
                                           bg-white px-5 py-4 pr-14
                                           focus:outline-none
                                           focus:ring-2
                                           focus:ring-[#6C8B6B]"
                                >

                                <button
                                    type="button"
                                    onclick="togglePassword('password', this)"
                                    class="absolute right-4 top-1/2
                                           -translate-y-1/2
                                           text-gray-400 hover:text-gray-600"
                                >

                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="w-5 h-5"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                        />

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5
                                               c4.478 0 8.268 2.943 9.542 7
                                               -1.274 4.057-5.064 7-9.542 7
                                               -4.477 0-8.268-2.943-9.542-7z"
                                        />

                                    </svg>

                                </button>

                            </div>

                        </div>

                        {{-- CONFIRM --}}
                        <div>

                            <label
                                class="block text-sm font-medium
                                       text-gray-700 mb-2"
                            >

                                Konfirmasi Password

                            </label>

                            <div class="relative">

                                <input
                                    id="password_confirmation"
                                    type="password"
                                    name="password_confirmation"
                                    placeholder="Konfirmasi password"
                                    class="w-full rounded-2xl
                                           border border-gray-200
                                           bg-white px-5 py-4 pr-14
                                           focus:outline-none
                                           focus:ring-2
                                           focus:ring-[#6C8B6B]"
                                >

                                <button
                                    type="button"
                                    onclick="togglePassword('password_confirmation', this)"
                                    class="absolute right-4 top-1/2
                                           -translate-y-1/2
                                           text-gray-400 hover:text-gray-600"
                                >

                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="w-5 h-5"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                        />

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5
                                               c4.478 0 8.268 2.943 9.542 7
                                               -1.274 4.057-5.064 7-9.542 7
                                               -4.477 0-8.268-2.943-9.542-7z"
                                        />

                                    </svg>

                                </button>

                            </div>

                        </div>

                    </div>

                </div>

                {{-- ========================================================= --}}
                {{-- DATA KOST --}}
                {{-- ========================================================= --}}
                <div>

                    <h3 class="text-lg font-semibold text-[#0F0937] mb-5">

                        Data Kost

                    </h3>

                    <div class="space-y-5">

                        {{-- NAMA KOST --}}
                        <div>

                            <label
                                class="block text-sm font-medium
                                       text-gray-700 mb-2"
                            >

                                Nama Kost

                            </label>

                            <input
                                type="text"
                                name="nama_kost"
                                value="{{ old('nama_kost') }}"
                                placeholder="Masukkan nama kost"
                                class="w-full rounded-2xl
                                       border border-gray-200
                                       bg-white px-5 py-4
                                       focus:outline-none
                                       focus:ring-2
                                       focus:ring-[#6C8B6B]"
                            >

                        </div>

                        {{-- ALAMAT --}}
                        <div>

                            <label
                                class="block text-sm font-medium
                                       text-gray-700 mb-2"
                            >

                                Alamat Kost

                            </label>

                            <textarea
                                name="alamat"
                                rows="4"
                                placeholder="Masukkan alamat lengkap kost"
                                class="w-full rounded-2xl
                                       border border-gray-200
                                       bg-white px-5 py-4
                                       focus:outline-none
                                       focus:ring-2
                                       focus:ring-[#6C8B6B]"
                            >{{ old('alamat') }}</textarea>

                        </div>

                    </div>

                </div>

                {{-- BUTTON --}}
                <button
                    type="submit"
                    class="w-full bg-[#6C8B6B]
                           hover:bg-[#5B765A]
                           text-white font-semibold
                           py-4 rounded-2xl transition"
                >

                    Daftar Sekarang

                </button>

                {{-- LOGIN --}}
                <div class="text-center">

                    <p class="text-sm text-gray-500">

                        Sudah punya akun?

                        <a
                            href="{{ route('login') }}"
                            class="text-[#6C8B6B]
                                   font-semibold hover:underline"
                        >

                            Masuk

                        </a>

                    </p>

                </div>

            </form>

        </div>

    </div>

    {{-- ========================================================= --}}
    {{-- RIGHT IMAGE --}}
    {{-- ========================================================= --}}
    <div class="hidden lg:block lg:w-1/2 relative overflow-hidden">

        <img
            src="{{ asset('pintu-login.png') }}"
            alt="KosinAja"
            class="absolute inset-0 w-full h-full
       object-cover object-center"
        >

        {{-- OVERLAY --}}
        <div
            class="absolute inset-0 bg-gradient-to-t
                   from-black/70 via-black/20 to-transparent"
        ></div>

        {{-- TEXT --}}
        <div
            class="absolute inset-0 z-10
                   flex flex-col justify-end
                   p-14"
        >

            <div
                class="inline-flex items-center gap-2
                       bg-white/15 backdrop-blur-md
                       border border-white/20
                       px-4 py-2 rounded-full
                       text-white text-sm font-medium
                       w-fit mb-6"
            >

                Kelola Kost Jadi Lebih Praktis

            </div>

            <h1
                class="text-5xl font-bold text-white
                       leading-[1.15] max-w-xl"
            >

                Mulai Perjalanan
                <br>

                <span class="text-[#D6E5D6]">

                    Digitalisasi

                </span>

                Kost Anda

            </h1>

            <p
                class="text-white/80 mt-6 text-lg
                       leading-relaxed max-w-lg"
            >

                Pantau penghuni, pembayaran,
                kamar, dan seluruh operasional
                kost dalam satu platform modern.

            </p>

        </div>

    </div>

</div>

{{-- ========================================================= --}}
{{-- SCRIPT --}}
{{-- ========================================================= --}}
<script>

function togglePassword(id)
{
    const input =
        document.getElementById(id);

    input.type =
        input.type === 'password'
            ? 'text'
            : 'password';
}

</script>

@endsection