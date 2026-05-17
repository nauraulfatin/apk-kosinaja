@extends('layouts.app')

@section('content')

<div class="min-h-screen flex bg-[#F8F5F0]">

    {{-- ========================================================= --}}
    {{-- LEFT IMAGE --}}
    {{-- ========================================================= --}}
    <div class="hidden lg:block lg:w-1/2 relative overflow-hidden">

        <img
            src="{{ asset('pintu-kosin.jpeg') }}"
            alt="KosinAja"
            class="absolute inset-0 w-full h-full object-cover"
        >

        {{-- OVERLAY --}}
        <div
            class="absolute inset-0 bg-gradient-to-t
                   from-black/60 via-black/20 to-transparent"
        ></div>

    </div>

    {{-- ========================================================= --}}
    {{-- RIGHT FORM --}}
    {{-- ========================================================= --}}
    <div
        class="w-full lg:w-1/2
               flex items-center justify-center
               px-6 py-10 lg:px-16"
    >

        <div class="w-full max-w-md">

            {{-- LOGO --}}
            <div class="flex items-center gap-3 mb-10">

                <img
                    src="{{ asset('logo.png') }}"
                    alt="Logo"
                    class="w-12 h-12 object-contain"
                >

                <div>

                    <h1 class="text-2xl font-bold text-[#0F0937]">

                        KosinAja!

                    </h1>

                                   </div>

            </div>

            {{-- TITLE --}}
            <div class="mb-8">

                <h2 class="text-3xl font-bold text-[#0F0937]">

                    Selamat Datang

                </h2>

                <p class="text-gray-500 mt-2 leading-relaxed">

                    Masuk untuk melanjutkan aktivitas
                    anda di aplikasi KosinAja!

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
                action="{{ route('login.post') }}"
                class="space-y-5"
            >

                @csrf

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
                        placeholder="Masukkan email anda"
                        class="w-full rounded-2xl
                               border border-gray-200
                               bg-white px-5 py-4
                               text-[#0F0937]
                               focus:outline-none
                               focus:ring-2
                               focus:ring-[#6C8B6B]
                               focus:border-transparent
                               transition"
                    >

                </div>

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
                                   text-[#0F0937]
                                   focus:outline-none
                                   focus:ring-2
                                   focus:ring-[#6C8B6B]
                                   focus:border-transparent
                                   transition"
                        >

                        {{-- TOGGLE --}}
                        <button
                            type="button"
                            onclick="togglePassword('password', this)"
                            class="absolute right-4 top-1/2
                                   -translate-y-1/2
                                   text-gray-400 hover:text-gray-600
                                   transition"
                        >

                            {{-- EYE ICON --}}
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
                           hover:bg-[#5B765A]
                           text-white font-semibold
                           py-4 rounded-2xl
                           transition duration-200"
                >

                    Masuk

                </button>

                {{-- REGISTER --}}
                <div class="text-center pt-2">

                    <p class="text-sm text-gray-500">

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