@extends('layouts.app')

@section('title', 'Daftar sebagai Penghuni — KosinAja!')

@section('styles')
<style>
.input-field {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 1.5px solid #dde8dd;
    border-radius: 0.875rem;
    background: #ffffff;
    color: #102313;
    font-size: 15px;
    font-family: 'DM Sans', sans-serif;
    transition: border-color 0.2s, box-shadow 0.2s;
    outline: none;
}

.input-field:focus {
    border-color: #6C8B6B;
    box-shadow: 0 0 0 3px rgba(108, 139, 107, 0.15);
}

.input-field::placeholder {
    color: #9aafa9;
}

.input-label {
    display: block;
    font-size: 13px;
    font-weight: 600;
    color: #314233;
    margin-bottom: 6px;
    font-family: 'Plus Jakarta Sans', sans-serif;
}

.error-msg {
    color: #c0392b;
    font-size: 12px;
    margin-top: 4px;
}
</style>
@endsection

@section('content')

<section class="min-h-screen bg-[#FDFBF7] flex items-center justify-center px-4 py-16">

    <div class="w-full max-w-md">

        {{-- CARD --}}
        <div class="bg-white border border-[#edf1ed] rounded-3xl shadow-sm px-10 py-10">

            {{-- HEADER --}}
            <div class="text-center mb-8">

                {{-- Badge peran --}}
                <div class="inline-flex items-center gap-2 px-4 py-1.5
                            rounded-full bg-[#edf5ed] border border-[#c7ddc7]
                            text-[#4a6b4a] text-xs font-semibold mb-5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Penghuni
                </div>

                <h1 class="text-2xl font-extrabold text-[#102313] mb-1">
                    Buat akun penghuni
                </h1>
                <p class="text-[#526453] text-sm">
                    Temukan kos impianmu bersama KosinAja!
                </p>

            </div>

            {{-- FORM --}}
            <form method="POST" action="{{ route('register.penghuni.store') }}" class="space-y-5">
                @csrf
                <input type="hidden" name="role" value="penghuni">

                {{-- Nama Lengkap --}}
                <div>
                    <label class="input-label" for="name">Nama Lengkap</label>
                    <input type="text" id="name" name="name" class="input-field @error('name') border-red-400 @enderror"
                        placeholder="contoh: Budi Santoso" value="{{ old('name') }}" required autofocus>
                    @error('name')
                    <p class="error-msg">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label class="input-label" for="email">Alamat Email</label>
                    <input type="email" id="email" name="email"
                        class="input-field @error('email') border-red-400 @enderror" placeholder="email@contoh.com"
                        value="{{ old('email') }}" required>
                    @error('email')
                    <p class="error-msg">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Nomor WhatsApp --}}
                <div>
                    <label class="input-label" for="phone">Nomor WhatsApp</label>
                    <div class="flex gap-2">
                        <span class="flex items-center px-3 rounded-xl border border-[#dde8dd]
                                     bg-[#f4f8f4] text-[#526453] text-sm font-medium whitespace-nowrap">
                            +62
                        </span>
                        <input type="tel" id="phone" name="phone"
                            class="input-field @error('phone') border-red-400 @enderror" placeholder="8123456789"
                            value="{{ old('phone') }}" required>
                    </div>
                    @error('phone')
                    <p class="error-msg">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label class="input-label" for="password">Kata Sandi</label>
                    <div class="relative">
                        <input type="password" id="password" name="password"
                            class="input-field pr-11 @error('password') border-red-400 @enderror"
                            placeholder="Minimal 8 karakter" required>
                        <button type="button" onclick="togglePassword('password', this)" class="absolute right-3 top-1/2 -translate-y-1/2
                                       text-[#9aafa9] hover:text-[#6C8B6B] transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                    @error('password')
                    <p class="error-msg">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Konfirmasi Password --}}
                <div>
                    <label class="input-label" for="password_confirmation">Konfirmasi Kata Sandi</label>
                    <div class="relative">
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            class="input-field pr-11" placeholder="Ulangi kata sandi" required>
                        <button type="button" onclick="togglePassword('password_confirmation', this)" class="absolute right-3 top-1/2 -translate-y-1/2
                                       text-[#9aafa9] hover:text-[#6C8B6B] transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Submit --}}
                <button type="submit" class="w-full py-3.5 rounded-2xl bg-[#6C8B6B] hover:bg-[#587357]
                               text-white font-bold text-[15px]
                               transition-all duration-200 shadow-sm hover:shadow-md mt-2">
                    Daftar Sekarang
                </button>

            </form>

            {{-- DIVIDER --}}
            <div class="flex items-center gap-3 my-6">
                <div class="flex-1 h-px bg-[#edf1ed]"></div>
                <span class="text-[#9aafa9] text-xs font-medium">atau</span>
                <div class="flex-1 h-px bg-[#edf1ed]"></div>
            </div>

            {{-- DAFTAR SEBAGAI ADMIN --}}
            <a href="{{ route('register.admin') }}" class="w-full flex items-center justify-center gap-2 py-3 rounded-2xl
                      border-2 border-[#dde8dd] hover:border-[#6C8B6B]
                      text-[#314233] hover:text-[#6C8B6B]
                      font-semibold text-[14px] transition-all duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 12l9-9 9 9M5 10v9a1 1 0 001 1h4v-5h4v5h4a1 1 0 001-1v-9" />
                </svg>
                Daftar sebagai Admin / Owner
            </a>

            {{-- LOGIN LINK --}}
            <p class="text-center mt-6 text-[13px] text-[#526453]">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="font-bold text-[#6C8B6B] hover:text-[#102313] transition-colors">
                    Masuk di sini
                </a>
            </p>

        </div>

        {{-- BACK LINK --}}
        <div class="text-center mt-5">
            <a href="{{ route('home') }}"
                class="inline-flex items-center gap-1.5 text-sm text-[#7A9A7B] hover:text-[#314233] transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali ke beranda
            </a>
        </div>

    </div>

</section>

<script>
function togglePassword(id, btn) {
    const input = document.getElementById(id);
    const isText = input.type === 'text';
    input.type = isText ? 'password' : 'text';
    btn.style.opacity = isText ? '1' : '0.7';
}
</script>

@endsection