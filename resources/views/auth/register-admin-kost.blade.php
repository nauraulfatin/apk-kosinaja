@extends('layouts.app')

@section('content')

<div class="h-screen bg-[#F8F5F0] flex overflow-hidden">

    {{-- ========================================================= --}}
    {{-- LEFT IMAGE --}}
    {{-- ========================================================= --}}
    <div class="hidden lg:block lg:w-[42%]
               relative overflow-hidden
               h-screen sticky top-0">

        {{-- IMAGE --}}
        <img src="{{ asset('foto-pintu.png') }}" alt="Login" class="absolute inset-0 w-full h-full object-cover">

        {{-- OVERLAY --}}
        <div class="absolute inset-0
                   bg-gradient-to-t
                   from-black/80
                   via-black/20
                   to-transparent"></div>

        {{-- CONTENT --}}
        <div class="absolute inset-0 z-10
                   flex flex-col justify-between
                   p-10">

            {{-- LOGO --}}
            <div class="flex items-center gap-3">

                <img src="{{ asset('logo.png') }}" class="w-11 h-11 object-contain">

                <h1 class="text-3xl font-bold text-white">
                    KosinAja!
                </h1>

            </div>

            {{-- TEXT --}}
            <div>

                <h2 class="text-4xl font-bold text-white leading-[1.15]">

                    Kelola Kost
                    <br>

                    <span class="text-[#D6E5D6]">
                        Lebih Praktis,
                    </span>

                    <br>

                    Semua Dalam
                    Satu Platform.

                </h2>

                <p class="text-white/80 text-lg leading-relaxed mt-6 max-w-md">

                    Kelola penghuni,
                    pembayaran,
                    kamar, dan seluruh
                    operasional kost
                    dengan lebih modern.

                </p>

                {{-- FLOATING CARD --}}
                <div class="mt-10 bg-white/10
                           backdrop-blur-md
                           border border-white/20
                           rounded-[24px] p-4
                           max-w-sm">

                    <div class="flex items-start gap-4">

                        {{-- ICON --}}
                        <div class="w-14 h-14 rounded-2xl
                                   bg-[#D6E5D6]/20
                                   flex items-center justify-center
                                   text-white">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="w-7 h-7"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor">

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 11c0-1.657 1.343-3 3-3s3 1.343 3 3v2a3 3 0 11-6 0v-2zm0 0V9a5 5 0 0110 0v2m-10 0H6a2 2 0 00-2 2v5a2 2 0 002 2h12a2 2 0 002-2v-5a2 2 0 00-2-2h-2"
                                />

                            </svg>

                        </div>

                        {{-- TEXT --}}
                        <div>

                            <h3 class="text-white font-semibold text-lg">
                                Aman & Modern
                            </h3>

                            <p class="text-white/70 text-sm mt-1 leading-relaxed">

                                Sistem manajemen kost
                                modern dengan pengalaman
                                pengguna yang nyaman.

                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- ========================================================= --}}
    {{-- FORM --}}
    {{-- ========================================================= --}}
    <div class="w-full lg:w-[58%]
                h-screen overflow-y-auto
                flex items-start justify-center
                px-4 py-6 lg:px-8 lg:py-6">

        <div class="w-full max-w-md lg:max-w-2xl
                    bg-white
                    rounded-[24px] lg:rounded-[28px]
                    border border-gray-100
                    shadow-sm
                    p-5 lg:p-8">

            {{-- HEADER --}}
            <div class="mb-6 lg:mb-8">

                <h1 class="text-[28px] lg:text-3xl
                           leading-tight
                           font-bold
                           text-[#0F0937]">

                    Daftar Sebagai Admin Kost

                </h1>

                <p class="text-gray-500 mt-2 lg:mt-3 text-sm lg:text-base leading-relaxed">

                    Daftarkan kost anda dan tunggu persetujuan super admin.

                </p>

            </div>

            {{-- ERROR --}}
            @if($errors->any())

                <div class="mb-6 bg-red-50 border border-red-200
                            rounded-xl lg:rounded-2xl
                            px-4 py-3 lg:px-5 lg:py-4
                            text-red-700">

                    <ul class="space-y-1 text-sm">

                        @foreach($errors->all() as $e)

                            <li>• {{ $e }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif

            {{-- FORM --}}
            <form method="POST" action="{{ route('register.admin') }}">

                @csrf

                {{-- ========================================================= --}}
                {{-- DATA ADMIN --}}
                {{-- ========================================================= --}}
                <div class="mb-8">

                    <div class="flex items-center gap-3 mb-5">

                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="w-5 h-5 text-[#6C8B6B]"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor">

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z"
                            />

                        </svg>

                        <h2 class="text-xl font-semibold text-[#4F6B4F]">
                            Data Akun
                        </h2>

                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-5">

                        {{-- NAMA --}}
                        <div>

                            <label class="block text-sm font-medium text-gray-600 mb-2">
                                Nama Lengkap
                            </label>

                            <input
                                type="text"
                                name="nama"
                                placeholder="Masukkan nama lengkap"
                                value="{{ old('nama') }}"
                                class="w-full rounded-xl lg:rounded-2xl
                                       border border-gray-200
                                       px-4 py-3.5 lg:px-5 lg:py-3.5
                                       text-sm lg:text-base
                                       focus:outline-none
                                       focus:ring-2
                                       focus:ring-[#6C8B6B]"
                            >

                        </div>

                        {{-- NIK --}}
                        <div>

                            <label class="block text-sm font-medium text-gray-600 mb-2">
                                NIK
                            </label>

                            <input
                                type="text"
                                name="nik"
                                placeholder="Masukkan NIK"
                                value="{{ old('nik') }}"
                                class="w-full rounded-xl lg:rounded-2xl
                                       border border-gray-200
                                       px-4 py-3.5 lg:px-5 lg:py-3.5
                                       text-sm lg:text-base
                                       focus:outline-none
                                       focus:ring-2
                                       focus:ring-[#6C8B6B]"
                            >

                        </div>

                        {{-- USERNAME --}}
                        <div>

                            <label class="block text-sm font-medium text-gray-600 mb-2">
                                Username
                            </label>

                            <input
                                type="text"
                                name="username"
                                placeholder="Masukkan username anda"
                                value="{{ old('username') }}"
                                class="w-full rounded-xl lg:rounded-2xl
                                       border border-gray-200
                                       px-4 py-3.5 lg:px-5 lg:py-3.5
                                       text-sm lg:text-base
                                       focus:outline-none
                                       focus:ring-2
                                       focus:ring-[#6C8B6B]"
                            >

                        </div>

                        {{-- NO HP --}}
                        <div>

                            <label class="block text-sm font-medium text-gray-600 mb-2">
                                Nomor WhatsApp
                            </label>

                            <input
                                type="text"
                                name="no_hp"
                                placeholder="08xxxxxxxxxx"
                                value="{{ old('no_hp') }}"
                                class="w-full rounded-xl lg:rounded-2xl
                                       border border-gray-200
                                       px-4 py-3.5 lg:px-5 lg:py-3.5
                                       text-sm lg:text-base
                                       focus:outline-none
                                       focus:ring-2
                                       focus:ring-[#6C8B6B]"
                            >

                        </div>

                        {{-- PASSWORD --}}
                        <div>

                            <label class="block text-sm font-medium text-gray-600 mb-2">
                                Password
                            </label>

                            <div class="relative">

                                <input
                                    id="password"
                                    type="password"
                                    name="password"
                                    placeholder="Masukkan password"
                                    class="w-full rounded-xl lg:rounded-2xl
                                           border border-gray-200
                                           px-4 py-3.5 lg:px-5 lg:py-3.5
                                           pr-12 lg:pr-14
                                           text-sm lg:text-base
                                           focus:outline-none
                                           focus:ring-2
                                           focus:ring-[#6C8B6B]"
                                >

                                <button
                                    type="button"
                                    onclick="togglePassword('password')"
                                    class="absolute right-4 lg:right-5 top-1/2
                                           -translate-y-1/2 text-gray-400">

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         class="w-5 h-5"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor">

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
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5 c4.478 0 8.268 2.943 9.542 7 -1.274 4.057-5.064 7-9.542 7 -4.477 0-8.268-2.943-9.542-7z"
                                        />

                                    </svg>

                                </button>

                            </div>

                        </div>

                        {{-- KONFIRMASI --}}
                        <div>

                            <label class="block text-sm font-medium text-gray-600 mb-2">
                                Konfirmasi Password
                            </label>

                            <div class="relative">

                                <input
                                    id="password_confirmation"
                                    type="password"
                                    name="password_confirmation"
                                    placeholder="Ulangi password"
                                    class="w-full rounded-xl lg:rounded-2xl
                                           border border-gray-200
                                           px-4 py-3.5 lg:px-5 lg:py-3.5
                                           pr-12 lg:pr-14
                                           text-sm lg:text-base
                                           focus:outline-none
                                           focus:ring-2
                                           focus:ring-[#6C8B6B]"
                                >

                                <button
                                    type="button"
                                    onclick="togglePassword('password_confirmation')"
                                    class="absolute right-4 lg:right-5 top-1/2
                                           -translate-y-1/2 text-gray-400">

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         class="w-5 h-5"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor">

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
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5 c4.478 0 8.268 2.943 9.542 7 -1.274 4.057-5.064 7-9.542 7 -4.477 0-8.268-2.943-9.542-7z"
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
                <div id="kostFields" class="mb-8">

                    <div class="flex items-center gap-3 mb-5">

                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="w-5 h-5 text-[#6C8B6B]"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor">

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M3 10l9-7 9 7v10a2 2 0 01-2 2H5a2 2 0 01-2-2V10z"
                            />

                        </svg>

                        <h2 class="text-xl font-semibold text-[#4F6B4F]">
                            Data Kost
                        </h2>

                    </div>

                    <div class="space-y-5">

                        {{-- NAMA KOST --}}
                        <div>

                            <label class="block text-sm font-medium text-gray-600 mb-2">
                                Nama Kost
                            </label>

                            <input
                                type="text"
                                name="nama_kost"
                                placeholder="Masukkan nama kost"
                                value="{{ old('nama_kost') }}"
                                class="w-full rounded-xl lg:rounded-2xl
                                       border border-gray-200
                                       px-4 py-3.5 lg:px-5 lg:py-3.5
                                       text-sm lg:text-base
                                       focus:outline-none
                                       focus:ring-2
                                       focus:ring-[#6C8B6B]"
                            >

                        </div>

                        {{-- ALAMAT --}}
                        <div>

                            <label class="block text-sm font-medium text-gray-600 mb-2">
                                Alamat Kost
                            </label>

                            <textarea
                                name="alamat"
                                rows="3"
                                placeholder="Masukkan alamat lengkap kost"
                                class="w-full rounded-xl lg:rounded-2xl
                                       border border-gray-200
                                       px-4 py-3.5 lg:px-5 lg:py-3.5
                                       text-sm lg:text-base
                                       focus:outline-none
                                       focus:ring-2
                                       focus:ring-[#6C8B6B]"
                            >{{ old('alamat') }}</textarea>

                        </div>

                    </div>

                </div>

                {{-- ========================================================= --}}
                {{-- RECAPTCHA --}}
                {{-- ========================================================= --}}
                <div class="mb-6">

                    <div class="scale-[0.92] lg:scale-100 origin-left">

                        <div
                            class="g-recaptcha"
                            data-sitekey="{{ env('NOCAPTCHA_SITEKEY') }}"
                        ></div>

                    </div>

                    @if ($errors->has('g-recaptcha-response'))

                        <p class="text-red-500 text-sm mt-2">
                            {{ $errors->first('g-recaptcha-response') }}
                        </p>

                    @endif

                </div>

                {{-- BUTTON --}}
                <button
                    type="submit"
                    class="w-full bg-[#6C8B6B]
                           hover:bg-[#5B765A]
                           text-white font-semibold
                           py-3.5 lg:py-4
                           rounded-xl lg:rounded-2xl
                           text-base
                           transition">

                    Daftar Sekarang

                </button>

                {{-- LOGIN --}}
                <div class="text-center mt-5 lg:mt-6">

                    <p class="text-gray-500">

                        Sudah punya akun?

                        <a
                            href="{{ route('login') }}"
                            class="text-[#6C8B6B] font-semibold hover:underline">

                            Masuk di sini

                        </a>

                    </p>

                </div>

            </form>

        </div>

    </div>

</div>

{{-- ========================================================= --}}
{{-- SCRIPT --}}
{{-- ========================================================= --}}
<script>
function togglePassword(id) {

    const input =
        document.getElementById(id);

    input.type =
        input.type === 'password'
            ? 'text'
            : 'password';

}
</script>

{{-- ========================================================= --}}
{{-- SUCCESS MODAL --}}
{{-- ========================================================= --}}
@if(session('register_success'))

<div id="successModal" class="fixed inset-0 z-50
           flex items-center justify-center
           bg-black/50 backdrop-blur-sm">

    <div class="bg-white
               max-w-sm lg:max-w-md
               w-full mx-4
               p-5 lg:p-7
               rounded-[24px] lg:rounded-3xl
               text-center
               animate-[fadeIn_.2s_ease]">

        {{-- ICON --}}
        <div class="w-16 h-16 lg:w-20 lg:h-20 mx-auto
                   rounded-full
                   bg-green-100
                   flex items-center justify-center">

            <svg xmlns="http://www.w3.org/2000/svg"
                 class="w-10 h-10 text-green-600"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor">

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M5 13l4 4L19 7"
                />

            </svg>

        </div>

        {{-- TITLE --}}
        <h2 class="text-xl lg:text-2xl font-bold text-[#0F0937] mt-6">
            Pendaftaran Berhasil
        </h2>

        {{-- DESC --}}
        <p class="text-gray-500 leading-relaxed text-sm lg:text-base mt-3">
            Pendaftaran anda berhasil
            dan sedang menunggu
            persetujuan superadmin.
            <br><br>
            Hubungi kami untuk konfirmasi.
        </p>

        {{-- BUTTON --}}
        <a
            href="{{ route('home') }}"
            class="mt-7 inline-flex
                   items-center justify-center
                   bg-[#6C8B6B]
                   hover:bg-[#5B765A]
                   text-white font-semibold
                   px-6 py-3 rounded-2xl
                   transition">

            OK

        </a>

    </div>

</div>

@endif

@endsection