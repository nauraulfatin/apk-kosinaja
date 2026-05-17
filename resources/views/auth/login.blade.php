@extends('layouts.app')

@section('content')

<div class="h-screen bg-[#F8F5F0] flex overflow-hidden">

    {{-- ========================================================= --}}
    {{-- LEFT IMAGE --}}
    {{-- ========================================================= --}}
    <div
        class="hidden lg:block lg:w-[42%]
               relative overflow-hidden
               h-screen sticky top-0"
    >

        {{-- IMAGE --}}
        <img
            src="{{ asset('foto-pintu.png') }}"
            alt="Login"
            class="absolute inset-0 w-full h-full object-cover"
        >

        {{-- OVERLAY --}}
        <div
            class="absolute inset-0
                   bg-gradient-to-t
                   from-black/80
                   via-black/20
                   to-transparent"
        ></div>

        {{-- CONTENT --}}
        <div
            class="absolute inset-0 z-10
                   flex flex-col justify-between
                   p-10"
        >

            {{-- LOGO --}}
            <div class="flex items-center gap-3">

                <img
                    src="{{ asset('logo.png') }}"
                    class="w-11 h-11 object-contain"
                >

                <h1 class="text-3xl font-bold text-white">
                    KosinAja!
                </h1>

            </div>

            {{-- TEXT --}}
            <div>

                <h2
                    class="text-5xl font-bold text-white
                           leading-[1.15]"
                >

                    Kelola Kost
                    <br>

                    <span class="text-[#D6E5D6]">

                        Lebih Praktis,

                    </span>

                    <br>

                    Semua Dalam
                    Satu Platform.

                </h2>

                <p
                    class="text-white/80 text-lg
                           leading-relaxed mt-6
                           max-w-md"
                >

                    Kelola penghuni,
                    pembayaran,
                    kamar, dan seluruh
                    operasional kost
                    dengan lebih modern.

                </p>

                {{-- FLOATING CARD --}}
                <div
                    class="mt-10 bg-white/10
                           backdrop-blur-md
                           border border-white/20
                           rounded-3xl p-5
                           max-w-sm"
                >

                    <div class="flex items-start gap-4">

                        {{-- ICON --}}
                        <div
                            class="w-14 h-14 rounded-2xl
                                   bg-[#D6E5D6]/20
                                   flex items-center justify-center
                                   text-white"
                        >

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="w-7 h-7"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >

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

                            <p
                                class="text-white/70 text-sm
                                       mt-1 leading-relaxed"
                            >

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
    {{-- RIGHT FORM --}}
    {{-- ========================================================= --}}
    <div
        class="w-full lg:w-[58%]
               h-screen overflow-y-auto
               flex items-center justify-center
               px-6 py-10"
    >

        <div
            class="w-full max-w-xl
                   bg-white/95 backdrop-blur-sm
                   rounded-[36px]
                   border border-[#ECE8E1]
                   shadow-[0_10px_40px_rgba(0,0,0,0.05)]
                   p-8 lg:p-10"
        >

            {{-- HEADER --}}
            <div class="mb-10">

                {{-- ICON --}}
                <div
                    class="w-20 h-20 rounded-3xl
                           bg-[#F5F7F2]
                           flex items-center justify-center
                           mb-6"
                >

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="w-10 h-10 text-[#6C8B6B]"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M15 7a2 2 0 012 2v8a2 2 0 01-2 2H7a2 2 0 01-2-2V9a2 2 0 012-2m8 0V5a3 3 0 10-6 0v2"
                        />

                    </svg>

                </div>

                {{-- TITLE --}}
                <h1
                    class="text-[40px]
                           leading-tight
                           font-bold
                           text-[#0F0937]"
                >

                    Selamat Datang!

                </h1>

                {{-- SUBTITLE --}}
                <p class="text-gray-500 mt-3 text-base leading-relaxed">

                    Masuk untuk melanjutkan
                    aktivitas anda di KosinAja.

                </p>

            </div>

            {{-- ERROR --}}
            @if($errors->any())

            <div
                class="mb-8 bg-red-50 border border-red-200
                       rounded-2xl px-5 py-4 text-red-700"
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

            {{-- SUCCESS --}}
            @if(session('success'))

            <div
                class="mb-8 bg-green-50 border border-green-200
                       rounded-2xl px-5 py-4 text-green-700"
            >

                {{ session('success') }}

            </div>

            @endif

            {{-- FORM --}}
            <form
                method="POST"
                action="{{ route('login.post') }}"
                class="space-y-6"
            >

                @csrf

                {{-- USERNAME --}}
                <div>

                    <label
                        class="block text-sm font-medium
                               text-gray-600 mb-2"
                    >

                        Username

                    </label>

                    <input
                        type="text"
                        name="username"
                        value="{{ old('username') }}"
                        placeholder="Masukkan email anda"
                        class="w-full rounded-2xl
                               border border-[#E7E2DA]
                               bg-[#FCFBF8]
                               px-5 py-4
                               text-[#0F0937]
                               placeholder:text-gray-400
                               focus:ring-2
                               focus:ring-[#6C8B6B]
                               focus:border-transparent
                               transition-all"
                    >

                </div>

                {{-- PASSWORD --}}
                <div>

                    <label
                        class="block text-sm font-medium
                               text-gray-600 mb-2"
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
                                   border border-[#E7E2DA]
                                   bg-[#FCFBF8]
                                   px-5 py-4 pr-14
                                   text-[#0F0937]
                                   placeholder:text-gray-400
                                   focus:ring-2
                                   focus:ring-[#6C8B6B]
                                   focus:border-transparent
                                   transition-all"
                        >

                        {{-- TOGGLE --}}
                        <button
                            type="button"
                            onclick="togglePassword('password', this)"
                            class="absolute right-5 top-1/2
                                   -translate-y-1/2
                                   text-gray-400"
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

                {{-- BUTTON --}}
                <button
                    type="submit"
                    class="w-full bg-[#6C8B6B]
                           hover:bg-[#5E7B5D]
                           text-white font-semibold
                           py-4 rounded-2xl
                           text-lg transition-all
                           shadow-lg shadow-[#6C8B6B]/20
                           hover:scale-[1.01]"
                >

                    Masuk

                </button>

                {{-- DIVIDER --}}
                <div class="relative py-2">

                    <div class="absolute inset-0 flex items-center">

                        <div class="w-full border-t border-gray-200"></div>

                    </div>

                    <div class="relative flex justify-center">

                        <span
                            class="bg-white px-4
                                   text-sm text-gray-400"
                        >

                            atau

                        </span>

                    </div>

                </div>

                {{-- REGISTER --}}
                <div class="text-center">

                    <p class="text-gray-500">

                        Belum punya akun?

                        <a
                            href="{{ route('admin-kost.register') }}"
                            class="text-[#6C8B6B]
                                   font-semibold hover:underline"
                        >

                            Daftar Sekarang

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

function togglePassword(id, button)
{
    const input =
        document.getElementById(id);

    const isPassword =
        input.type === 'password';

    input.type =
        isPassword
            ? 'text'
            : 'password';

    button.innerHTML =
        isPassword
            ? `
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="w-5 h-5"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M13.875 18.825A10.05 10.05 0 0112 19
                           c-4.478 0-8.268-2.943-9.542-7
                           a9.956 9.956 0 012.223-3.592m3.1-2.542
                           A9.953 9.953 0 0112 5
                           c4.478 0 8.268 2.943 9.542 7
                           a9.97 9.97 0 01-4.132 5.411M15 12
                           a3 3 0 11-6 0 3 3 0 016 0zm6 6L3 3"
                    />

                </svg>
            `
            : `
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
                        d="M2.458 12C3.732 7.943 7.523 5 12 5
                           c4.478 0 8.268 2.943 9.542 7
                           -1.274 4.057-5.064 7-9.542 7
                           -4.477 0-8.268-2.943-9.542-7z"
                    />

                </svg>
            `;
}

</script>

@endsection