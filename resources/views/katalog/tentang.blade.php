@extends('layouts.public')

@section('title', 'Tentang Kami - KosinAja!')

@section('content')

<div class="max-w-8xl mx-auto px-6 py-8 flex flex-col gap-4">

    {{-- HERO --}}
    <div
        class="bg-white rounded-2xl border border-[#E2EAE3] p-8 grid grid-cols-2 gap-6 items-center relative overflow-hidden">
        <div class="absolute -top-16 -right-16 w-56 h-56 rounded-full pointer-events-none"
            style="background:radial-gradient(circle,rgba(124,163,133,.12) 0%,transparent 70%)"></div>

        <div class="relative z-10">
            <div
                class="inline-flex items-center bg-[rgba(124,163,133,.12)] border border-[rgba(124,163,133,.3)] rounded-full px-4 py-1.5 text-xs font-semibold text-[#5F8568] mb-4">
                Tentang Kami
            </div>
            <h1 class="font-extrabold text-3xl leading-tight text-[#1F3A2C] mb-4">Tentang KosinAja</h1>
            <p class="text-sm text-[#4A5E4C] leading-relaxed">
                Platform pencarian kost tanpa harus datang ke tempat — cukup lihat foto, cek fasilitas, dan bandingkan
                harga dari mana saja. Pemilik kost pun bisa mengelola data penghuni dan pembayaran secara digital,
                praktis, dan efisien dalam satu platform.
            </p>
        </div>

        <div class="flex justify-end relative z-10">
            <img src="{{ asset('Ilustrasi Tentang KosinAja.png') }}" alt="Ilustrasi Tentang KosinAja"
                class="w-full h-auto">
        </div>
    </div>

    {{-- KISAH --}}
    <div class="bg-white rounded-2xl border border-[#E2EAE3] p-8 grid grid-cols-2 gap-6 items-center">
        <div class="rounded-xl overflow-hidden">
            <img src="{{ asset('fasilitas.png') }}" alt="Ruangan Kost" class="w-full h-52 object-cover rounded-xl">
        </div>
        <div>
            <div
                class="inline-flex items-center gap-1.5 text-[.65rem] font-bold tracking-widest uppercase text-[#5F8568] bg-[rgba(95,133,104,.10)] border border-[rgba(95,133,104,.22)] px-3 py-1 rounded-full mb-3">
                Kisah Kami
            </div>
            <h2 class="font-extrabold text-xl text-[#1F3A2C] mb-3">Kisah Kami</h2>
            <p class="text-sm text-[#4A5E4C] leading-relaxed mb-3">
                KosinAja lahir dari sebuah tugas kuliah Project Based Learning (PBL) pada tahun 2026. Berawal dari
                keresahan betapa sulitnya mencari kost yang terpercaya dan bisa dilihat tanpa harus survey langsung —
                kami memutuskan untuk membangun solusinya.
            </p>
            <p class="text-sm text-[#4A5E4C] leading-relaxed">
                Kami menggabungkan teknologi dan kemudahan dalam satu platform agar pencari kost dan pemilik kost
                sama-sama diuntungkan.
            </p>
        </div>
    </div>

    {{-- VISI MISI --}}
    <div class="grid grid-cols-2 gap-3">
        <div class="bg-white rounded-2xl border border-[#E2EAE3] p-6">
            <div class="w-10 h-10 bg-[#f0f5f1] rounded-xl flex items-center justify-center text-xl mb-4">👁️</div>
            <h3 class="font-extrabold text-base text-[#1F3A2C] mb-2">Visi Kami</h3>
            <p class="text-sm text-[#4A5E4C] leading-relaxed">
                Menjadi platform kost terdepan yang memberikan solusi terbaik bagi penghuni dan pemilik kost melalui
                teknologi yang mudah digunakan.
            </p>
        </div>
        <div class="bg-white rounded-2xl border border-[#E2EAE3] p-6">
            <div class="w-10 h-10 bg-[#f0f5f1] rounded-xl flex items-center justify-center text-xl mb-4">🎯</div>
            <h3 class="font-extrabold text-base text-[#1F3A2C] mb-2">Misi Kami</h3>
            <ul class="flex flex-col gap-2">
                <li class="flex gap-2 text-sm text-[#4A5E4C] leading-relaxed">
                    <span class="text-[#5F8568] text-xs mt-0.5 flex-shrink-0">▸</span>
                    Memudahkan pencarian kost secara online tanpa harus datang langsung
                </li>
                <li class="flex gap-2 text-sm text-[#4A5E4C] leading-relaxed">
                    <span class="text-[#5F8568] text-xs mt-0.5 flex-shrink-0">▸</span>
                    Membantu pemilik kost mengelola penghuni dan pembayaran secara digital
                </li>
                <li class="flex gap-2 text-sm text-[#4A5E4C] leading-relaxed">
                    <span class="text-[#5F8568] text-xs mt-0.5 flex-shrink-0">▸</span>
                    Memberikan pengalaman yang aman, nyaman, dan terpercaya
                </li>
            </ul>
        </div>
    </div>

    {{-- KEUNGGULAN --}}
    <div class="bg-white rounded-2xl border border-[#E2EAE3] p-6">
        <div class="text-center mb-5">
            <div
                class="inline-flex items-center gap-1.5 text-[.65rem] font-bold tracking-widest uppercase text-[#5F8568] bg-[rgba(95,133,104,.10)] border border-[rgba(95,133,104,.22)] px-3 py-1 rounded-full mb-2">
                Keunggulan
            </div>
            <h2 class="font-extrabold text-xl text-[#1F3A2C]">Keunggulan Kami</h2>
        </div>
        <div class="grid grid-cols-3 gap-3">
            <div class="bg-[#F5F4F0] border border-[#E2EAE3] rounded-xl p-4 text-center">
                <div class="w-11 h-11 bg-[#f0f5f1] rounded-xl flex items-center justify-center mx-auto mb-3 text-xl">🔍
                </div>
                <h4 class="font-bold text-sm text-[#1F3A2C] mb-1.5">Mudah Cari Kost</h4>
                <p class="text-xs text-[#7A8A7C] leading-relaxed">Temukan pilihan kost terbaik sesuai lokasi, harga, dan
                    fasilitas.</p>
            </div>
            <div class="bg-[#F5F4F0] border border-[#E2EAE3] rounded-xl p-4 text-center">
                <div class="w-11 h-11 bg-[#f0f5f1] rounded-xl flex items-center justify-center mx-auto mb-3 text-xl">💳
                </div>
                <h4 class="font-bold text-sm text-[#1F3A2C] mb-1.5">Pembayaran Tercatat</h4>
                <p class="text-xs text-[#7A8A7C] leading-relaxed">Pencatatan pembayaran digital yang rapi dan mudah
                    dipantau kapan saja.</p>
            </div>
            <div class="bg-[#F5F4F0] border border-[#E2EAE3] rounded-xl p-4 text-center">
                <div class="w-11 h-11 bg-[#f0f5f1] rounded-xl flex items-center justify-center mx-auto mb-3 text-xl">🏠
                </div>
                <h4 class="font-bold text-sm text-[#1F3A2C] mb-1.5">Kelola Kost Praktis</h4>
                <p class="text-xs text-[#7A8A7C] leading-relaxed">Pemilik kost dapat mengelola kamar dan penghuni dalam
                    satu platform.</p>
            </div>
        </div>
    </div>

    {{-- STATS --}}
    <div class="bg-[#284535] rounded-2xl px-8 py-6 grid grid-cols-3 text-center">
        <div class="border-r border-white/20 px-4">
            <div class="font-extrabold text-2xl text-white leading-none mb-1">{{ $totalKos ?? '—' }}</div>
            <div class="text-xs text-white/55">Kost Terdaftar</div>
        </div>
        <div class="border-r border-white/20 px-4">
            <div class="font-extrabold text-2xl text-white leading-none mb-1">{{ $totalKamar ?? '—' }}</div>
            <div class="text-xs text-white/55">Total Kamar</div>
        </div>
        <div class="px-4">
            <div class="font-extrabold text-2xl text-white leading-none mb-1">{{ $totalPenghuni ?? '—' }}</div>
            <div class="text-xs text-white/55">Penghuni Aktif</div>
        </div>
    </div>

    {{-- TIMELINE --}}
    <div class="bg-white rounded-2xl border border-[#E2EAE3] p-6">
        <div class="text-center mb-6">
            <div
                class="inline-flex items-center gap-1.5 text-[.65rem] font-bold tracking-widest uppercase text-[#5F8568] bg-[rgba(95,133,104,.10)] border border-[rgba(95,133,104,.22)] px-3 py-1 rounded-full mb-2">




                Perjalanan Kami
            </div>
            <h2 class="font-extrabold text-xl text-[#1F3A2C]">Dari Ide Hingga Platform Nyata</h2>
        </div>

        <div class="relative max-w-xl mx-auto">
            {{-- garis tengah --}}
            <div class="absolute left-1/2 -translate-x-1/2 top-2 bottom-2 w-0.5 bg-[#E2EAE3]"></div>

            {{-- Item 1 - kiri --}}
            <div class="flex justify-end pr-[calc(50%+22px)] mb-5 relative">
                <div class="bg-[#F5F4F0] border border-[#E2EAE3] rounded-xl p-4 max-w-[190px]">
                    <div class="text-[.62rem] font-bold text-[#5F8568] tracking-wide uppercase mb-1">Februari 2026</div>
                    <div class="font-extrabold text-sm text-[#1F3A2C] mb-1">Ide Lahir dari PBL</div>
                    <div class="text-xs text-[#7A8A7C] leading-relaxed">KosinAja lahir sebagai proyek tugas kuliah PBL
                        dari keresahan sulitnya mencari kost secara online.</div>
                </div>
                <div
                    class="absolute right-[calc(50%-9px)] top-4 w-4 h-4 bg-[#5F8568] rounded-full border-3 border-[#F5F4F0]">
                </div>
            </div>

            {{-- Item 2 - kanan --}}
            <div class="flex justify-start pl-[calc(50%+22px)] mb-5 relative">
                <div class="bg-[#F5F4F0] border border-[#E2EAE3] rounded-xl p-4 max-w-[190px]">
                    <div class="text-[.62rem] font-bold text-[#5F8568] tracking-wide uppercase mb-1">Mei — Juni 2026
                    </div>
                    <div class="font-extrabold text-sm text-[#1F3A2C] mb-1">Platform Diluncurkan</div>
                    <div class="text-xs text-[#7A8A7C] leading-relaxed">KosinAja resmi diluncurkan dengan fitur
                        pencarian, katalog kost, dan manajemen penghuni.</div>
                </div>
                <div
                    class="absolute left-[calc(50%-9px)] top-4 w-4 h-4 bg-[#5F8568] rounded-full border-3 border-[#F5F4F0]">
                </div>
            </div>

            {{-- Item 3 - kiri --}}
            <div class="flex justify-end pr-[calc(50%+22px)] mb-5 relative">
                <div class="bg-[#F5F4F0] border border-[#E2EAE3] rounded-xl p-4 max-w-[190px]">
                    <div class="text-[.62rem] font-bold text-[#5F8568] tracking-wide uppercase mb-1">Pertengahan Juni
                        2026</div>
                    <div class="font-extrabold text-sm text-[#1F3A2C] mb-1">Pengguna Bisa Akses</div>
                    <div class="text-xs text-[#7A8A7C] leading-relaxed">Platform mulai bisa digunakan penghuni untuk
                        mencari kost secara lengkap tanpa datang langsung.</div>
                </div>
                <div
                    class="absolute right-[calc(50%-9px)] top-4 w-4 h-4 bg-[#5F8568] rounded-full border-3 border-[#F5F4F0]">
                </div>
            </div>

            {{-- Item 4 - kanan (highlight) --}}
            <div class="flex justify-start pl-[calc(50%+22px)] relative">
                <div class="bg-[#284535] border border-[#284535] rounded-xl p-4 max-w-[190px]">
                    <div class="text-[.62rem] font-bold text-white/50 tracking-wide uppercase mb-1">Sekarang &
                        Seterusnya</div>
                    <div class="font-extrabold text-sm text-white mb-1">Terus Berkembang</div>
                    <div class="text-xs text-white/70 leading-relaxed">Fitur pembayaran, manajemen kamar, dan data
                        penghuni terus disempurnakan.</div>
                </div>
                <div
                    class="absolute left-[calc(50%-9px)] top-4 w-4 h-4 bg-[#284535] rounded-full border-3 border-[#F5F4F0]">
                </div>
            </div>
        </div>
    </div>

    {{-- TIM KAMI --}}
    <div class="bg-white rounded-2xl border border-[#E2EAE3] p-6">
        <div class="text-center mb-5">
            <div
                class="inline-flex items-center gap-1.5 text-[.65rem] font-bold tracking-widest uppercase text-[#5F8568] bg-[rgba(95,133,104,.10)] border border-[rgba(95,133,104,.22)] px-3 py-1 rounded-full mb-2">
                👥 Tim Kami
            </div>
            <h2 class="font-extrabold text-xl text-[#1F3A2C]">Orang-orang di Balik KosinAja</h2>
            <p class="text-sm text-[#7A8A7C] mt-1">Empat mahasiswa yang membangun KosinAja dari nol</p>
        </div>
        <div class="grid grid-cols-4 gap-3">
            <div
                class="bg-[#F5F4F0] border border-[#E2EAE3] rounded-xl p-5 text-center hover:-translate-y-1 transition-transform">
                <div class="w-14 h-14 rounded-full flex items-center justify-center mx-auto mb-3 font-extrabold text-lg text-white"
                    style="background:linear-gradient(135deg,#7CA385,#284535)">NA</div>
                <div class="font-bold text-sm text-[#1F3A2C] mb-1">Naura</div>
                <div class="text-xs text-[#5F8568] font-semibold">Developer</div>
            </div>
            <div
                class="bg-[#F5F4F0] border border-[#E2EAE3] rounded-xl p-5 text-center hover:-translate-y-1 transition-transform">
                <div class="w-14 h-14 rounded-full flex items-center justify-center mx-auto mb-3 font-extrabold text-lg text-white"
                    style="background:linear-gradient(135deg,#BE4178,#7a1a4a)">SH</div>
                <div class="font-bold text-sm text-[#1F3A2C] mb-1">Shavira</div>
                <div class="text-xs text-[#5F8568] font-semibold">Developer</div>
            </div>
            <div
                class="bg-[#F5F4F0] border border-[#E2EAE3] rounded-xl p-5 text-center hover:-translate-y-1 transition-transform">
                <div class="w-14 h-14 rounded-full flex items-center justify-center mx-auto mb-3 font-extrabold text-lg text-white"
                    style="background:linear-gradient(135deg,#5F8568,#1F3A2C)">RA</div>
                <div class="font-bold text-sm text-[#1F3A2C] mb-1">Rahma</div>
                <div class="text-xs text-[#5F8568] font-semibold">Developer</div>
            </div>
            <div
                class="bg-[#F5F4F0] border border-[#E2EAE3] rounded-xl p-5 text-center hover:-translate-y-1 transition-transform">
                <div class="w-14 h-14 rounded-full flex items-center justify-center mx-auto mb-3 font-extrabold text-lg text-white"
                    style="background:linear-gradient(135deg,#2C64AA,#0a2a5e)">YU</div>
                <div class="font-bold text-sm text-[#1F3A2C] mb-1">Yusril</div>
                <div class="text-xs text-[#5F8568] font-semibold">Developer</div>
            </div>
        </div>
    </div>

    {{-- CTA JOIN --}}
    <div class="bg-white rounded-2xl border border-[#E2EAE3] p-8 flex items-center justify-between gap-8 mb-4">
        <div class="flex-1">
            <h2 class="font-extrabold text-xl text-[#1F3A2C] mb-2">Bersama KosinAja, semua jadi lebih mudah!</h2>
            <p class="text-sm text-[#4A5E4C] leading-relaxed">Temukan kost impianmu atau kelola kostmu sekarang juga.
            </p>
        </div>
        <div class="flex gap-3 flex-shrink-0">

            <a href="{{ route('admin-kost.register') }}"
                class="px-6 py-3 border-[1.5px] border-[#5F8568] text-[#5F8568] hover:bg-[#5F8568] hover:text-white rounded-xl font-bold text-sm transition-all">
                Daftarkan Kost Anda
            </a>
        </div>
        <div>
            <img src="{{ asset('daon (1).png') }}" alt="Ilustrasi" class="w-36 object-contain">
        </div>
    </div>

</div>

@endsection