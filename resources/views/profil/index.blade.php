@extends('layouts.public')

@section('title', 'Profil Penghuni')

@section('content')

<div class="max-w-7xl mx-auto px-6 lg:px-8 py-10">

    {{-- ========================================================= --}}
    {{-- BREADCRUMB --}}
    {{-- ========================================================= --}}
    <div class="flex items-center gap-3 text-sm text-gray-400 mb-8">

        <a href="{{ route('home') }}" class="hover:text-[#6C8B6B]">
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
                <h2 class="text-[24px] font-bold text-[#1B2B1D]">
                    Data Diri
                </h2>

                {{-- FOTO --}}
                <div class="flex flex-col items-center mt-8">

                    <div class="w-[110px] h-[110px]
                                rounded-full overflow-hidden
                                border-[4px] border-[#F4F7F4]">
                        <img src="https://ui-avatars.com/api/?name={{ auth()->user()->nama }}"
                            class="w-full h-full object-cover">
                    </div>

                    {{-- UBAH FOTO BUTTON --}}
                    <button class="mt-3 flex items-center gap-1.5
                               text-[13px] text-[#6C8B6B]
                               font-medium hover:text-[#4B7A4A]
                               transition-colors duration-200">

                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>

                        Ubah Foto

                    </button>

                </div>

                {{-- INFO --}}
                <div class="mt-8 space-y-6">

                    {{-- NAMA --}}
                    <div class="flex gap-4 items-start">
                        <div class="text-[#6C8B6B] mt-[2px] shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-[12px] text-gray-400">Nama Lengkap</p>
                            <h4 class="text-[14px] font-semibold text-[#1B2B1D] mt-0.5 leading-6">
                                {{ auth()->user()->nama }}
                            </h4>
                        </div>
                    </div>

                    {{-- EMAIL --}}
                    <div class="flex gap-4 items-start">
                        <div class="text-[#6C8B6B] mt-[2px] shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-[12px] text-gray-400">Email</p>
                            <h4 class="text-[14px] font-semibold text-[#1B2B1D] mt-0.5 leading-6 break-all">
                                {{ auth()->user()->username }}
                            </h4>
                        </div>
                    </div>

                    {{-- HP --}}
                    <div class="flex gap-4 items-start">
                        <div class="text-[#6C8B6B] mt-[2px] shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-[12px] text-gray-400">No. Handphone</p>
                            <h4 class="text-[14px] font-semibold text-[#1B2B1D] mt-0.5 leading-6">
                                {{ auth()->user()->no_hp }}
                            </h4>
                        </div>
                    </div>

                    {{-- JENIS KELAMIN --}}
                    @if(auth()->user()->jenis_kelamin)
                    <div class="flex gap-4 items-start">
                        <div class="text-[#6C8B6B] mt-[2px] shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-[12px] text-gray-400">Jenis Kelamin</p>
                            <h4 class="text-[14px] font-semibold text-[#1B2B1D] mt-0.5 leading-6">
                                {{ auth()->user()->jenis_kelamin }}
                            </h4>
                        </div>
                    </div>
                    @endif

                    {{-- ASAL DAERAH --}}
                    @if(auth()->user()->asal_daerah)
                    <div class="flex gap-4 items-start">
                        <div class="text-[#6C8B6B] mt-[2px] shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-[12px] text-gray-400">Asal Daerah</p>
                            <h4 class="text-[14px] font-semibold text-[#1B2B1D] mt-0.5 leading-6">
                                {{ auth()->user()->asal_daerah }}
                            </h4>
                        </div>
                    </div>
                    @endif

                    {{-- STATUS --}}
                    <div class="flex gap-4 items-start">
                        <div class="text-[#6C8B6B] mt-[2px] shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-[12px] text-gray-400">Status Akun</p>
                            <div class="inline-flex items-center gap-1.5
                                       px-3 py-1.5 rounded-xl
                                       bg-[#EAF7EA]
                                       text-[#4B8A4B]
                                       text-[13px] font-semibold
                                       mt-1.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
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
                <h2 class="text-[24px] font-bold text-[#1B2B1D] mb-6">
                    Kos Saya
                </h2>

                {{-- ============================================
                     STATE 1 : BELUM PUNYA KOS (empty state)
                     Condition: user tidak punya undangan sama sekali
                     ============================================ --}}
                @if(!auth()->user()->undangan)

                <div class="flex flex-col items-center justify-center text-center py-16">

                    {{-- IMAGE --}}
                    <img src="{{ asset('empty-kos.png') }}" alt="Empty Kost" class="w-[260px] h-auto object-contain">

                    {{-- TITLE --}}
                    <h3 class="text-[28px] font-bold text-[#1B2B1D] leading-[1.4] mt-8 max-w-md">
                        Kamu belum terhubung
                        dengan kos manapun
                    </h3>

                    {{-- DESC --}}
                    <p class="text-gray-500 leading-7 text-[15px] max-w-sm mt-4">
                        Masukkan kode unik dari pemilik kost
                        untuk menghubungkan akunmu dan mulai
                        mengakses informasi kos.
                    </p>

                    {{-- BUTTON — onclick membuka modal --}}
                    <button onclick="bukaModalKodeUnik()" class="mt-8 px-8 py-4
                               rounded-2xl
                               bg-[#6C8B6B]
                               hover:bg-[#587357]
                               text-white font-semibold
                               text-[15px]
                               transition-all duration-300">
                        Masukkan kode dari pemilik
                    </button>

                </div>

                {{-- ============================================
                     STATE 2 : MENUNGGU APPROVAL (pending)
                     Condition: punya undangan dengan status 'menunggu'
                     ============================================ --}}
                @elseif(auth()->user()->undangan->status === 'menunggu')

                @php $undangan = auth()->user()->undangan; @endphp

                {{-- BANNER MENUNGGU APPROVAL --}}
                <div class="flex items-start gap-4 bg-[#FFFBF0] border border-[#F5E6BB] rounded-[18px] px-6 py-5 mb-8">
                    <div class="shrink-0 mt-0.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-[#D4A017]" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-[15px] font-bold text-[#B07D10]">Menunggu Approval</p>
                        <p class="text-[13px] text-[#C89A2A] mt-0.5 leading-6">
                            Kode berhasil dikirim ke pemilik kost dan sedang menunggu persetujuan.
                        </p>
                    </div>
                </div>

                {{-- DETAIL INFO --}}
                <div class="space-y-5">

                    <div class="flex items-center justify-between py-4
                                border-b border-[#F0F4F0]">
                        <span class="text-[14px] text-gray-500">Kode Unik</span>
                        <span class="text-[14px] font-semibold text-[#1B2B1D]">
                            {{ $undangan->kode_unik }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between py-4
                                border-b border-[#F0F4F0]">
                        <span class="text-[14px] text-gray-500">Tanggal Pengajuan</span>
                        <span class="text-[14px] font-semibold text-[#1B2B1D]">
                            {{ \Carbon\Carbon::parse($undangan->created_at)->translatedFormat('d M Y, H:i') }} WIB
                        </span>
                    </div>

                    <div class="flex items-center justify-between py-4">
                        <span class="text-[14px] text-gray-500">Status</span>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5
                                     rounded-xl bg-[#FFF4D6] text-[#B07D10]
                                     text-[13px] font-semibold">
                            Menunggu Approval
                        </span>
                    </div>

                </div>

                {{-- TOMBOL DISABLED --}}
                <button disabled class="mt-8 w-full py-4 rounded-2xl bg-[#D1DDD1] text-white
                           font-semibold text-[15px] cursor-not-allowed">
                    Menunggu Persetujuan
                </button>

                {{-- ============================================
                     STATE 3 : DISETUJUI (approved)
                     Condition: punya undangan dengan status 'disetujui'
                     ============================================ --}}
                @elseif(auth()->user()->undangan->status === 'disetujui')

                @php $undangan = auth()->user()->undangan; @endphp

                {{-- BANNER DISETUJUI --}}
                <div class="flex items-start gap-4 bg-[#F0FAF0] border border-[#C2E0C2] rounded-[18px] px-6 py-5 mb-8">
                    <div class="shrink-0 mt-0.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-[#4B8A4B]" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-[15px] font-bold text-[#2E6B2E]">Disetujui!</p>
                        <p class="text-[13px] text-[#4B7A4A] mt-0.5 leading-6">
                            Selamat! Kamu sudah terhubung dengan kost ini.
                            Sekarang kamu bisa mengakses dashboard penghuni.
                        </p>
                    </div>
                </div>

                {{-- DETAIL INFO --}}
                <div class="space-y-5">

                    <div class="flex items-center justify-between py-4
                                border-b border-[#F0F4F0]">
                        <span class="text-[14px] text-gray-500">Kode Unik</span>
                        <span class="text-[14px] font-semibold text-[#1B2B1D]">
                            {{ $undangan->kode_unik }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between py-4
                                border-b border-[#F0F4F0]">
                        <span class="text-[14px] text-gray-500">Disetujui Pada</span>
                        <span class="text-[14px] font-semibold text-[#1B2B1D]">
                            {{ \Carbon\Carbon::parse($undangan->approved_at)->translatedFormat('d M Y, H:i') }} WIB
                        </span>
                    </div>

                    <div class="flex items-center justify-between py-4">
                        <span class="text-[14px] text-gray-500">Status</span>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5
                                     rounded-xl bg-[#EAF7EA] text-[#4B8A4B]
                                     text-[13px] font-semibold">
                            Disetujui
                        </span>
                    </div>

                </div>

                {{-- TOMBOL LIHAT DASHBOARD --}}
                <a href="{{ route('penghuni.dashboard') }}" class="mt-8 w-full py-4 rounded-2xl
                           bg-[#4B8A4B] hover:bg-[#3A703A]
                           text-white font-semibold text-[15px]
                           transition-all duration-300
                           flex items-center justify-center gap-2">

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>

                    Lihat Dashboard

                </a>

                @endif

            </div>

        </div>

    </div>

</div>


{{-- =========================================================
     MODAL : KODE UNIK (8 DIGIT)
     Hanya tampil jika user belum punya undangan
     ========================================================= --}}
@if(!auth()->user()->undangan)
<div id="modalKodeUnik" class="hidden fixed inset-0 z-50 flex items-center justify-center
           bg-black/40 backdrop-blur-sm px-4">
    <div class="bg-white rounded-[24px] shadow-xl w-full max-w-lg p-8 relative">

        {{-- TOMBOL X (tutup) --}}
        <button onclick="tutupModalKodeUnik()" class="absolute top-5 right-5 text-gray-400
                   hover:text-gray-700 transition-colors duration-200" aria-label="Tutup">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        {{-- TOMBOL < (kembali) --}}
        <button onclick="tutupModalKodeUnik()" class="flex items-center gap-1.5 text-[13px] text-gray-400
                   hover:text-[#6C8B6B] transition-colors duration-200 mb-5" aria-label="Kembali">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
        </button>

        {{-- JUDUL --}}
        <h3 class="text-[20px] font-bold text-[#1B2B1D] mb-2">
            Masukkan kode unik dari pemilik
        </h3>

        {{-- DESKRIPSI --}}
        <p class="text-[13px] text-gray-500 leading-6 mb-7">
            Kamu bisa mengaktifkan halaman ini menggunakan kode unik dari pemilik kos.
            Jika belum menerimanya, silakan hubungi pemilik kos.
        </p>

        {{-- INPUT 8 DIGIT --}}
        <div class="flex gap-2 justify-center mb-2">
            @for ($i = 0; $i < 8; $i++) <input type="text" maxlength="1" inputmode="numeric" pattern="[0-9]" class="kode-unik-input w-[46px] h-[52px] text-center text-[20px]
                           font-semibold text-[#1B2B1D] border-2 border-[#E2E8E2]
                           rounded-[12px] focus:border-[#6C8B6B] focus:outline-none
                           transition-colors duration-200">
                @endfor
        </div>

        {{-- HINT --}}
        <p class="text-center text-[12px] text-gray-400 mb-4">
            Masukkan kode unik yang dikirim oleh pemilik kos
        </p>

        {{-- PESAN ERROR --}}
        <div id="kodeUnikPesanError" class="hidden items-center justify-center gap-1.5 mb-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-500 shrink-0" fill="none"
                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" />
            </svg>
            <p class="text-[13px] text-red-500 font-medium">
                Maaf, kode yang kamu masukkan salah.
            </p>
        </div>

        {{-- PESAN SUKSES (menunggu approval setelah submit) --}}
        <div id="kodeUnikPesanSukses" class="hidden items-center justify-center gap-1.5 mb-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-[#4B8A4B] shrink-0" fill="none"
                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <p class="text-[13px] text-[#4B8A4B] font-medium">
                Kode diterima. Menunggu persetujuan dari admin.
            </p>
        </div>

        {{-- TOMBOL KIRIM --}}
        <button id="btnKirimKode" onclick="submitKodeUnik()" disabled class="mt-2 w-full py-4 rounded-2xl bg-[#D1DDD1] text-white
                   font-semibold text-[15px] transition-all duration-300
                   cursor-not-allowed">
            Kirim kode unik
        </button>

    </div>
</div>
@endif


{{-- =========================================================
     SCRIPT
     ========================================================= --}}
@if(!auth()->user()->undangan)
<script>
const kodeUnikInputs = document.querySelectorAll('.kode-unik-input');
const kodeUnikBtn = document.getElementById('btnKirimKode');
const kodeUnikPesanError = document.getElementById('kodeUnikPesanError');
const kodeUnikPesanSukses = document.getElementById('kodeUnikPesanSukses');

/* ── navigasi antar kotak ── */
kodeUnikInputs.forEach((el, idx) => {

    el.addEventListener('input', () => {
        el.value = el.value.replace(/\D/g, '');
        if (el.value && idx < kodeUnikInputs.length - 1) kodeUnikInputs[idx + 1].focus();
        resetPesan();
        checkFilled();
    });

    el.addEventListener('keydown', e => {
        if (e.key === 'Backspace' && !el.value && idx > 0) kodeUnikInputs[idx - 1].focus();
    });

    el.addEventListener('paste', e => {
        e.preventDefault();
        const paste = (e.clipboardData || window.clipboardData)
            .getData('text').replace(/\D/g, '').slice(0, kodeUnikInputs.length);
        [...paste].forEach((char, i) => {
            if (kodeUnikInputs[i]) kodeUnikInputs[i].value = char;
        });
        (kodeUnikInputs[paste.length] ?? kodeUnikInputs[kodeUnikInputs.length - 1]).focus();
        resetPesan();
        checkFilled();
    });
});

/* ── helpers ── */
function checkFilled() {
    const filled = [...kodeUnikInputs].every(i => i.value.length === 1);
    kodeUnikBtn.disabled = !filled;
    if (filled) {
        kodeUnikBtn.classList.replace('bg-[#D1DDD1]', 'bg-[#6C8B6B]');
        kodeUnikBtn.classList.replace('cursor-not-allowed', 'cursor-pointer');
        kodeUnikBtn.classList.add('hover:bg-[#587357]');
    } else {
        kodeUnikBtn.classList.replace('bg-[#6C8B6B]', 'bg-[#D1DDD1]');
        kodeUnikBtn.classList.replace('cursor-pointer', 'cursor-not-allowed');
        kodeUnikBtn.classList.remove('hover:bg-[#587357]');
    }
}

function resetPesan() {
    kodeUnikPesanError.classList.replace('flex', 'hidden');
    kodeUnikPesanSukses.classList.replace('flex', 'hidden');
    kodeUnikPesanError.classList.add('hidden');
    kodeUnikPesanSukses.classList.add('hidden');
    kodeUnikInputs.forEach(i => {
        i.classList.remove('border-red-400', 'border-[#4B8A4B]');
        i.classList.add('border-[#E2E8E2]');
    });
}

function bukaModalKodeUnik() {
    document.getElementById('modalKodeUnik').classList.remove('hidden');
    document.getElementById('modalKodeUnik').classList.add('flex');
    resetPesan();
    kodeUnikInputs.forEach(i => {
        i.value = '';
        i.disabled = false;
    });
    checkFilled();
    kodeUnikInputs[0].focus();
}

function tutupModalKodeUnik() {
    document.getElementById('modalKodeUnik').classList.add('hidden');
    document.getElementById('modalKodeUnik').classList.remove('flex');
    resetPesan();
    kodeUnikInputs.forEach(i => {
        i.value = '';
        i.disabled = false;
    });
    checkFilled();
}

/* ── submit ke server ── */
function submitKodeUnik() {
    const kode = [...kodeUnikInputs].map(i => i.value).join('');

    kodeUnikBtn.disabled = true;
    kodeUnikBtn.textContent = 'Mengirim...';

    fetch('{{ route("penghuni.hubungkan") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: JSON.stringify({
                kode
            }),
        })
        .then(res => res.json())
        .then(data => {
            kodeUnikBtn.textContent = 'Kirim kode unik';

            if (data.success) {
                /* ✅ kode benar — tampilkan pesan sukses lalu reload halaman
                   agar state berganti ke "Menunggu Approval"             */
                kodeUnikPesanError.classList.add('hidden');
                kodeUnikPesanSukses.classList.remove('hidden');
                kodeUnikPesanSukses.classList.add('flex');
                kodeUnikInputs.forEach(i => {
                    i.classList.remove('border-[#E2E8E2]', 'border-red-400');
                    i.classList.add('border-[#4B8A4B]');
                    i.disabled = true;
                });
                kodeUnikBtn.classList.replace('bg-[#6C8B6B]', 'bg-[#D1DDD1]');
                kodeUnikBtn.classList.remove('hover:bg-[#587357]');
                kodeUnikBtn.classList.add('cursor-not-allowed');

                /* Reload setelah 1.5 detik agar user sempat baca pesan */
                setTimeout(() => {
                    window.location.reload();
                }, 1500);

            } else {
                /* ❌ kode salah */
                kodeUnikPesanSukses.classList.add('hidden');
                kodeUnikPesanError.classList.remove('hidden');
                kodeUnikPesanError.classList.add('flex');
                kodeUnikInputs.forEach(i => {
                    i.classList.remove('border-[#E2E8E2]', 'border-[#4B8A4B]');
                    i.classList.add('border-red-400');
                });
                checkFilled(); /* aktifkan tombol lagi agar bisa retry */
            }
        })
        .catch(() => {
            kodeUnikBtn.textContent = 'Kirim kode unik';
            kodeUnikPesanSukses.classList.add('hidden');
            kodeUnikPesanError.classList.remove('hidden');
            kodeUnikPesanError.classList.add('flex');
            checkFilled();
        });
}
</script>
@endif

@endsection