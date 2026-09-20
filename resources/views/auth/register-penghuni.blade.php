@extends('layouts.app')

@section('content')

<div class="h-screen bg-[#F8F5F0] flex overflow-hidden">

    {{-- ========================================================= --}}
    {{-- LEFT IMAGE --}}
    {{-- ========================================================= --}}
    <div class="hidden lg:block lg:w-[42%]
               relative overflow-hidden
               h-screen sticky top-0">

        <img src="{{ asset('foto-pintu.png') }}" alt="Login" class="absolute inset-0 w-full h-full object-cover">

        <div class="absolute inset-0
                   bg-gradient-to-t
                   from-black/80
                   via-black/20
                   to-transparent"></div>

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

                            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 11c0-1.657 1.343-3 3-3s3 1.343 3 3v2a3 3 0 11-6 0v-2zm0 0V9a5 5 0 0110 0v2m-10 0H6a2 2 0 00-2 2v5a2 2 0 002 2h12a2 2 0 002-2v-5a2 2 0 00-2-2h-2" />

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

                    Daftar Sebagai Penghuni

                </h1>

                <p class="text-gray-500 mt-2 lg:mt-3
                          text-sm lg:text-base
                          leading-relaxed">

                    Buat akun untuk mulai mencari kost.

                </p>

            </div>


            {{-- FORM --}}
            <form method="POST" action="{{ route('register.penghuni.store') }}">

                @csrf


                {{-- ========================================================= --}}
                {{-- DATA AKUN --}}
                {{-- ========================================================= --}}
                <div class="mb-8">

                    <div class="flex items-center gap-3 mb-5">

                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-[#6C8B6B]" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16
                                   c2.5 0 4.847.655 6.879 1.804
                                   M15 11a3 3 0 11-6 0
                                   3 3 0 016 0z" />

                        </svg>

                        <h2 class="text-xl font-semibold text-[#4F6B4F]">
                            Data Akun
                        </h2>

                    </div>


                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-5">


                        {{-- ================================================= --}}
                        {{-- NAMA --}}
                        {{-- ================================================= --}}
                        <div>

                            <label class="block text-sm font-medium
                                          text-gray-600 mb-2">

                                Nama Lengkap

                            </label>

                            <input id="nama" type="text" name="nama" placeholder="Masukkan nama lengkap"
                                value="{{ old('nama') }}" maxlength="100" class="w-full rounded-xl lg:rounded-2xl
                                       border border-gray-200
                                       px-4 py-3.5 lg:px-5 lg:py-3.5
                                       text-sm lg:text-base
                                       focus:outline-none
                                       focus:ring-2
                                       focus:ring-[#6C8B6B]">

                            <p id="namaHelp" class="hidden mt-1.5 text-sm font-normal">
                            </p>

                        </div>


                        {{-- ================================================= --}}
                        {{-- NIK --}}
                        {{-- ================================================= --}}
                        <div>

                            <label class="block text-sm font-medium
                                          text-gray-600 mb-2">

                                NIK

                            </label>

                            <input id="nik" type="text" name="nik" placeholder="Masukkan NIK" value="{{ old('nik') }}"
                                maxlength="16" inputmode="numeric" class="w-full rounded-xl lg:rounded-2xl
                                       border border-gray-200
                                       px-4 py-3.5 lg:px-5 lg:py-3.5
                                       text-sm lg:text-base
                                       focus:outline-none
                                       focus:ring-2
                                       focus:ring-[#6C8B6B]">

                            <p id="nikHelp" class="hidden mt-1.5 text-sm font-normal">
                            </p>

                        </div>


                        {{-- ================================================= --}}
                        {{-- USERNAME --}}
                        {{-- ================================================= --}}
                        <div>

                            <label class="block text-sm font-medium
                                          text-gray-600 mb-2">

                                Username

                            </label>

                            <input id="username" type="text" name="username" placeholder="Masukkan username anda"
                                value="{{ old('username') }}" maxlength="30" class="w-full rounded-xl lg:rounded-2xl
                                       border border-gray-200
                                       px-4 py-3.5 lg:px-5 lg:py-3.5
                                       text-sm lg:text-base
                                       focus:outline-none
                                       focus:ring-2
                                       focus:ring-[#6C8B6B]">

                            <p id="usernameHelp" class="hidden mt-1.5 text-sm font-normal">
                            </p>

                        </div>


                        {{-- ================================================= --}}
                        {{-- NO HP --}}
                        {{-- ================================================= --}}
                        <div>

                            <label class="block text-sm font-medium
                                          text-gray-600 mb-2">

                                Nomor WhatsApp

                            </label>

                            <input id="no_hp" type="text" name="no_hp" placeholder="08xxxxxxxxxx"
                                value="{{ old('no_hp') }}" maxlength="13" inputmode="numeric" class="w-full rounded-xl lg:rounded-2xl
                                       border border-gray-200
                                       px-4 py-3.5 lg:px-5 lg:py-3.5
                                       text-sm lg:text-base
                                       focus:outline-none
                                       focus:ring-2
                                       focus:ring-[#6C8B6B]">

                            <p id="noHpHelp" class="hidden mt-1.5 text-sm font-normal">
                            </p>

                        </div>


                        {{-- ================================================= --}}
                        {{-- PASSWORD --}}
                        {{-- ================================================= --}}
                        <div>

                            <label class="block text-sm font-medium
                                          text-gray-600 mb-2">

                                Password

                            </label>

                            <div class="relative">

                                <input id="password" type="password" name="password" placeholder="Masukkan password"
                                    class="w-full rounded-xl lg:rounded-2xl
                                           border border-gray-200
                                           px-4 py-3.5 lg:px-5 lg:py-3.5
                                           pr-12 lg:pr-14
                                           text-sm lg:text-base
                                           focus:outline-none
                                           focus:ring-2
                                           focus:ring-[#6C8B6B]">

                                <button type="button" onclick="togglePassword('password')" class="absolute right-4 lg:right-5
                                           top-1/2
                                           -translate-y-1/2
                                           text-gray-400">

                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">

                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0
                                               3 3 0 016 0z" />

                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943
                                               7.523 5 12 5
                                               c4.478 0 8.268 2.943
                                               9.542 7
                                               -1.274 4.057-5.064 7-9.542 7
                                               -4.477 0-8.268-2.943-9.542-7z" />

                                    </svg>

                                </button>

                            </div>


                            {{-- PASSWORD VALIDATION --}}
                            <div id="passwordHelp" class="hidden mt-2 space-y-1 text-sm font-normal">

                                <p id="lengthCheck" class="before:content-['•'] before:mr-2"></p>
                                <p id="uppercaseCheck" class="before:content-['•'] before:mr-2"></p>
                                <p id="lowercaseCheck" class="before:content-['•'] before:mr-2"></p>
                                <p id="numberCheck" class="before:content-['•'] before:mr-2"></p>
                            </div>

                        </div>


                        {{-- ================================================= --}}
                        {{-- KONFIRMASI PASSWORD --}}
                        {{-- ================================================= --}}
                        <div>

                            <label class="block text-sm font-medium
                                          text-gray-600 mb-2">

                                Konfirmasi Password

                            </label>

                            <div class="relative">

                                <input id="password_confirmation" type="password" name="password_confirmation"
                                    placeholder="Ulangi password" class="w-full rounded-xl lg:rounded-2xl
                                           border border-gray-200
                                           px-4 py-3.5 lg:px-5 lg:py-3.5
                                           pr-12 lg:pr-14
                                           text-sm lg:text-base
                                           focus:outline-none
                                           focus:ring-2
                                           focus:ring-[#6C8B6B]">

                                <button type="button" onclick="togglePassword('password_confirmation')" class="absolute right-4 lg:right-5
                                           top-1/2
                                           -translate-y-1/2
                                           text-gray-400">

                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">

                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0
                                               3 3 0 016 0z" />

                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943
                                               7.523 5 12 5
                                               c4.478 0 8.268 2.943
                                               9.542 7
                                               -1.274 4.057-5.064 7-9.542 7
                                               -4.477 0-8.268-2.943-9.542-7z" />

                                    </svg>

                                </button>

                            </div>


                            {{-- CONFIRMATION VALIDATION --}}
                            <p id="confirmationHelp" class="hidden mt-1.5 text-sm font-normal">
                            </p>

                        </div>

                    </div>

                </div>


                {{-- ========================================================= --}}
                {{-- RECAPTCHA --}}
                {{-- ========================================================= --}}
                <div class="mb-6">

                    <div class="scale-[0.92] lg:scale-100 origin-left">

                        <div class="g-recaptcha" data-sitekey="{{ env('NOCAPTCHA_SITEKEY') }}">
                        </div>

                    </div>

                    @if ($errors->has('g-recaptcha-response'))

                    <p class="text-red-500 text-sm mt-2">
                        {{ $errors->first('g-recaptcha-response') }}
                    </p>

                    @endif

                </div>


                {{-- ========================================================= --}}
                {{-- BUTTON --}}
                {{-- ========================================================= --}}
                <button type="submit" class="w-full bg-[#6C8B6B]
                           hover:bg-[#5B765A]
                           text-white font-semibold
                           py-3.5 lg:py-4
                           rounded-xl lg:rounded-2xl
                           text-base
                           transition">

                    Daftar Sekarang

                </button>


                {{-- ========================================================= --}}
                {{-- LOGIN --}}
                {{-- ========================================================= --}}
                <div class="text-center mt-5 lg:mt-6">

                    <p class="text-gray-500">

                        Sudah punya akun?

                        <a href="{{ route('login') }}" class="text-[#6C8B6B] font-semibold hover:underline">

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

    const input = document.getElementById(id);

    input.type =
        input.type === 'password' ?
        'text' :
        'password';
}


/* =========================================================
   FUNGSI VALIDASI
   Valid   = hijau
   Invalid = merah
   Tanpa centang dan tanda X
========================================================= */

function showValidation(element, valid, message) {

    element.classList.remove(
        'hidden',
        'text-red-500',
        'text-green-600'
    );

    element.textContent = message;

    if (valid) {

        element.classList.add('text-green-600');

    } else {

        element.classList.add('text-red-500');

    }
}


/* =========================================================
   NAMA LENGKAP
   AuthController:
   required | string | max:100
========================================================= */

const nama = document.getElementById('nama');
const namaHelp = document.getElementById('namaHelp');

nama.addEventListener('input', function() {

    const value = nama.value;

    if (value.length === 0) {

        namaHelp.classList.add('hidden');
        return;

    }

    const valid = value.length <= 100;

    showValidation(
        namaHelp,
        valid,
        'Harus maksimal 100 karakter'
    );

});


/* =========================================================
   NIK
   AuthController:
   required | digits:16 | regex:/^[0-9]+$/
========================================================= */

const nik = document.getElementById('nik');
const nikHelp = document.getElementById('nikHelp');

nik.addEventListener('input', function() {

    /* Hanya izinkan angka */
    nik.value = nik.value.replace(/[^0-9]/g, '');

    const value = nik.value;

    if (value.length === 0) {

        nikHelp.classList.add('hidden');
        return;

    }

    const valid = /^[0-9]{16}$/.test(value);

    showValidation(
        nikHelp,
        valid,
        'Harus 16 digit dan hanya boleh angka'
    );

});


/* =========================================================
   USERNAME
   AuthController:
   required | min:3 | max:30
   regex:/^[a-zA-Z0-9._]+$/
========================================================= */

const username = document.getElementById('username');
const usernameHelp = document.getElementById('usernameHelp');

username.addEventListener('input', function() {

    const value = username.value;

    if (value.length === 0) {

        usernameHelp.classList.add('hidden');
        return;

    }

    const valid =
        /^[a-zA-Z0-9._]{3,30}$/.test(value);

    showValidation(
        usernameHelp,
        valid,
        'Harus 3–30 karakter dan hanya boleh huruf, angka, titik, dan underscore'
    );

});


/* =========================================================
   NOMOR WHATSAPP
   AuthController:
   required | digits_between:10,13
========================================================= */

const noHp = document.getElementById('no_hp');
const noHpHelp = document.getElementById('noHpHelp');

noHp.addEventListener('input', function() {

    /* Hanya izinkan angka */
    noHp.value = noHp.value.replace(/[^0-9]/g, '');

    const value = noHp.value;

    if (value.length === 0) {

        noHpHelp.classList.add('hidden');
        return;

    }

    const valid =
        /^[0-9]{10,13}$/.test(value);

    showValidation(
        noHpHelp,
        valid,
        'Harus 10–13 digit dan hanya boleh angka'
    );

});


/* =========================================================
   PASSWORD
   AuthController:
   required
   confirmed
   min:8
   huruf besar
   huruf kecil
   angka
========================================================= */

const password =
    document.getElementById('password');

const passwordHelp =
    document.getElementById('passwordHelp');

const lengthCheck =
    document.getElementById('lengthCheck');

const uppercaseCheck =
    document.getElementById('uppercaseCheck');

const lowercaseCheck =
    document.getElementById('lowercaseCheck');

const numberCheck =
    document.getElementById('numberCheck');


password.addEventListener('input', function() {

    const value = password.value;

    if (value.length === 0) {

        passwordHelp.classList.add('hidden');

        lengthCheck.classList.add('hidden');
        uppercaseCheck.classList.add('hidden');
        lowercaseCheck.classList.add('hidden');
        numberCheck.classList.add('hidden');

        return;

    }


    /* Tampilkan semua ketentuan */
    passwordHelp.classList.remove('hidden');


    /* Minimal 8 karakter */
    showValidation(
        lengthCheck,
        value.length >= 8,
        'Harus minimal 8 karakter'
    );


    /* Huruf besar */
    showValidation(
        uppercaseCheck,
        /[A-Z]/.test(value),
        'Harus mengandung huruf besar'
    );


    /* Huruf kecil */
    showValidation(
        lowercaseCheck,
        /[a-z]/.test(value),
        'Harus mengandung huruf kecil'
    );


    /* Angka */
    showValidation(
        numberCheck,
        /[0-9]/.test(value),
        'Harus mengandung angka'
    );


    /* Cek konfirmasi password */
    checkPasswordConfirmation();

});


/* =========================================================
   KONFIRMASI PASSWORD
   AuthController:
   confirmed
========================================================= */

const passwordConfirmation =
    document.getElementById('password_confirmation');

const confirmationHelp =
    document.getElementById('confirmationHelp');


passwordConfirmation.addEventListener('input', function() {

    checkPasswordConfirmation();

});


function checkPasswordConfirmation() {

    const passwordValue =
        password.value;

    const confirmationValue =
        passwordConfirmation.value;


    if (confirmationValue.length === 0) {

        confirmationHelp.classList.add('hidden');
        return;

    }


    const valid =
        confirmationValue === passwordValue;


    showValidation(
        confirmationHelp,
        valid,
        'Harus sama dengan password'
    );

}
</script>

@endsection