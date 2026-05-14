@extends('layouts.public')

@section('title', 'Hubungi Kami - KosinAja!')

@section('content')

<div class="max-w-8xl mx-auto flex flex-col gap-6 px-4 py-2">

    {{-- HERO --}}
    <div class="bg-white rounded-2xl border border-[#E2EAE3] px-8 py-7 grid gap-6 items-center relative overflow-hidden"
        style="grid-template-columns:1.2fr 1fr">
        <div class="absolute -top-16 -right-16 w-56 h-56 rounded-full pointer-events-none"
            style="background:radial-gradient(circle,rgba(124,163,133,.12) 0%,transparent 70%)"></div>

        <div class="relative z-10">
            <div
                class="inline-flex items-center bg-[rgba(124,163,133,0.12)] border border-[rgba(124,163,133,0.3)] rounded-full px-4 py-1.5 text-xs font-semibold text-[#5F8568] mb-3">
                Kami Siap Membantu
            </div>
            <h1 class="font-extrabold text-[1.7rem] leading-tight text-[#1F3A2C] mb-2.5"
                style="font-family:'Plus Jakarta Sans',sans-serif">
                Hubungi Kami
            </h1>
            <p class="text-sm text-[#4A5E4C] leading-relaxed">
                Punya pertanyaan atau butuh bantuan? Kami siap membantu Anda kapan saja.
                Kami siap membantu kebutuhan pencarian kos, kendala akun, pendaftaran kos,
                maupun pertanyaan lainnya. Tim kami akan merespons pesan Anda secepat mungkin
                melalui email ataupun WhatsApp.


            </p>
        </div>

        <div class="flex justify-end items-center relative z-10">
            <img src="{{ asset('Ilustrasi Hubungi Kami.png') }}" alt="Ilustrasi Hubungi Kami"
                class="w-full max-w-md object-contain">
        </div>
    </div>

    {{-- CARA MENGHUBUNGI --}}
    <div class="bg-white rounded-2xl border border-[#E2EAE3] px-7 py-6">
        <div class="text-center mb-5">
            <span
                class="inline-flex items-center gap-1 text-[0.65rem] font-bold tracking-widest uppercase text-[#5F8568] bg-[rgba(95,133,104,0.10)] border border-[rgba(95,133,104,0.22)] px-3 py-1 rounded-full mb-2">
                Kontak
            </span>
            <h2 class="font-extrabold text-lg text-[#1F3A2C]" style="font-family:'Plus Jakarta Sans',sans-serif">
                Cara Menghubungi Kami
            </h2>
        </div>
        <div class="grid grid-cols-3 gap-3">

            <div class="bg-[#F5F4F0] border border-[#E2EAE3] rounded-2xl px-4 py-5 text-center">
                <div class="w-11 h-11 bg-[#f0f5f1] rounded-xl flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 fill-[#5F8568]" viewBox="0 0 24 24">
                        <path
                            d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5S10.62 6.5 12 6.5 14.5 7.62 14.5 9 13.38 11.5 12 11.5z" />
                    </svg>
                </div>
                <h4 class="font-bold text-[0.82rem] text-[#1F3A2C] mb-1"
                    style="font-family:'Plus Jakarta Sans',sans-serif">Alamat</h4>
                <p class="text-[0.72rem] text-[#7A8A7C] leading-relaxed">Banyuwangi, Jawa Timur<br>Indonesia</p>
            </div>

            <div class="bg-[#F5F4F0] border border-[#E2EAE3] rounded-2xl px-4 py-5 text-center">
                <div class="w-11 h-11 bg-[#f0f5f1] rounded-xl flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 fill-[#5F8568]" viewBox="0 0 24 24">
                        <path
                            d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z" />
                    </svg>
                </div>
                <h4 class="font-bold text-[0.82rem] text-[#1F3A2C] mb-1"
                    style="font-family:'Plus Jakarta Sans',sans-serif">Telepon</h4>
                <p class="text-[0.72rem] text-[#7A8A7C] leading-relaxed">0822-6467-6843<br>(08.00 – 20.00 WIB)</p>
            </div>

            <div class="bg-[#F5F4F0] border border-[#E2EAE3] rounded-2xl px-4 py-5 text-center">
                <div class="w-11 h-11 bg-[#f0f5f1] rounded-xl flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 fill-[#5F8568]" viewBox="0 0 24 24">
                        <path
                            d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z" />
                    </svg>
                </div>
                <h4 class="font-bold text-[0.82rem] text-[#1F3A2C] mb-1"
                    style="font-family:'Plus Jakarta Sans',sans-serif">Email</h4>
                <p class="text-[0.72rem] text-[#7A8A7C] leading-relaxed">twoorbital@gmail.com</p>
            </div>

        </div>
    </div>

    {{-- FAQ + MAP --}}
    <div class="grid grid-cols-2 gap-4">

        {{-- FAQ --}}
        <div class="bg-white rounded-2xl border border-[#E2EAE3] px-6 py-6">
            <span
                class="inline-flex items-center gap-1 text-[0.65rem] font-bold tracking-widest uppercase text-[#5F8568] bg-[rgba(95,133,104,0.10)] border border-[rgba(95,133,104,0.22)] px-3 py-1 rounded-full mb-2">
                FAQ
            </span>
            <h3 class="font-extrabold text-[0.95rem] text-[#1F3A2C] mb-4"
                style="font-family:'Plus Jakarta Sans',sans-serif">
                Pertanyaan Sering Ditanya
            </h3>

            @php
            $faqs = [
            ['q' => 'Bagaimana cara mencari kos?', 'a' => 'Klik tombol "Jelajahi Sekarang" di beranda, lalu gunakan
            filter kota, harga, dan fasilitas untuk menemukan kos yang sesuai.'],
            ['q' => 'Apakah daftar gratis?', 'a' => 'Ya, mendaftar sebagai penghuni sepenuhnya gratis tanpa biaya
            apapun.'],
            ['q' => 'Cara daftarkan kos saya?', 'a' => 'Daftar sebagai Admin/Owner, masuk ke dashboard, dan klik "Tambah
            Kos". Isi detail kos lengkap beserta foto.'],
            ['q' => 'Bisa survey kos dulu?', 'a' => 'Tentu bisa. Hubungi pemilik kos langsung melalui kontak di halaman
            detail kos untuk mengatur jadwal survey.'],
            ['q' => 'Bagaimana jika kos tidak sesuai?', 'a' => 'Segera hubungi tim KosinAja melalui WhatsApp atau email.
            Kami akan menindaklanjuti dan membantu menyelesaikan masalah.'],
            ['q' => 'Apakah data saya aman?', 'a' => 'Ya, data pribadimu tidak akan dibagikan kepada pihak ketiga tanpa
            izin.'],
            ];
            @endphp

            <div class="flex flex-col">
                @foreach($faqs as $i => $faq)
                <div class="faq-item {{ !$loop->last ? 'border-b border-[#E2EAE3]' : '' }}" data-open="0">
                    <button onclick="toggleFaq(this)"
                        class="w-full bg-transparent border-0 text-left py-3 flex items-center justify-between gap-2 cursor-pointer">
                        <span class="font-semibold text-[0.78rem] text-[#1F3A2C] leading-snug"
                            style="font-family:'Plus Jakarta Sans',sans-serif">
                            {{ $faq['q'] }}
                        </span>
                        <div
                            class="faq-icon w-[22px] h-[22px] min-w-[22px] bg-[#f0f5f1] rounded-md flex items-center justify-center transition-colors duration-200">
                            <svg class="faq-arrow w-[11px] h-[11px] fill-[#5F8568] transition-transform duration-300"
                                viewBox="0 0 24 24">
                                <path d="M7 10l5 5 5-5z" />
                            </svg>
                        </div>
                    </button>
                    <div class="faq-answer overflow-hidden transition-all duration-300 ease-in-out"
                        style="max-height:0">
                        <p class="text-[0.74rem] text-[#4A5E4C] leading-relaxed pb-3">{{ $faq['a'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- MAP --}}
        <div class="bg-white rounded-2xl border border-[#E2EAE3] overflow-hidden flex flex-col">
            <div class="px-6 pt-5 pb-3">
                <span
                    class="inline-flex items-center gap-1 text-[0.65rem] font-bold tracking-widest uppercase text-[#5F8568] bg-[rgba(95,133,104,0.10)] border border-[rgba(95,133,104,0.22)] px-3 py-1 rounded-full mb-2">
                    Lokasi
                </span>
                <h3 class="font-extrabold text-[0.95rem] text-[#1F3A2C]"
                    style="font-family:'Plus Jakarta Sans',sans-serif">
                    Lokasi Kami
                </h3>
            </div>
            <div class="flex-1 min-h-56 relative overflow-hidden">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126220.11088888127!2d114.27890!3d-8.21946!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd159b47c81bf45%3A0xf7990bde7d64a8b2!2sBanyuwangi%2C%20Jawa%20Timur!5e0!3m2!1sid!2sid!4v1690000000000!5m2!1sid!2sid"
                    class="w-full h-full border-0 block absolute inset-0" allowfullscreen loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
            <div class="px-6 py-4 flex items-center gap-2.5">
                <div class="w-7 h-7 bg-[#f0f5f1] rounded-lg flex items-center justify-center shrink-0">
                    <svg class="w-3.5 h-3.5 fill-[#5F8568]" viewBox="0 0 24 24">
                        <path
                            d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5S10.62 6.5 12 6.5 14.5 7.62 14.5 9 13.38 11.5 12 11.5z" />
                    </svg>
                </div>
                <span class="text-[0.78rem] text-[#4A5E4C] font-medium leading-snug">Banyuwangi, Jawa
                    Timur<br>Indonesia</span>
            </div>
        </div>

    </div>

    {{-- FORM KIRIM PESAN --}}
    <div class="bg-white rounded-2xl border border-[#E2EAE3] px-8 py-7">
        <span
            class="inline-flex items-center gap-1 text-[0.65rem] font-bold tracking-widest uppercase text-[#5F8568] bg-[rgba(95,133,104,0.10)] border border-[rgba(95,133,104,0.22)] px-3 py-1 rounded-full mb-2">
            Pesan
        </span>
        <h3 class="font-extrabold text-[0.95rem] text-[#1F3A2C] mb-1"
            style="font-family:'Plus Jakarta Sans',sans-serif">
            Kirim Pesan Langsung
        </h3>
        <p class="text-[0.78rem] text-[#7A8A7C] mb-5">Isi form di bawah dan kami akan membalas melalui email secepat
            mungkin.</p>

        <div class="grid grid-cols-2 gap-3 mb-3">
            <div class="flex flex-col gap-1.5">
                <label for="f-nama" class="text-[0.72rem] font-semibold text-[#4A5E4C]"
                    style="font-family:'Plus Jakarta Sans',sans-serif">Nama Lengkap</label>
                <input type="text" id="f-nama" placeholder="Nama kamu"
                    class="px-3.5 py-2.5 border border-[#E2EAE3] rounded-xl text-[0.78rem] text-[#1F3A2C] bg-white outline-none focus:border-[#5F8568] transition-colors">
            </div>
            <div class="flex flex-col gap-1.5">
                <label for="f-email" class="text-[0.72rem] font-semibold text-[#4A5E4C]"
                    style="font-family:'Plus Jakarta Sans',sans-serif">Email</label>
                <input type="email" id="f-email" placeholder="email@kamu.com"
                    class="px-3.5 py-2.5 border border-[#E2EAE3] rounded-xl text-[0.78rem] text-[#1F3A2C] bg-white outline-none focus:border-[#5F8568] transition-colors">
            </div>
        </div>

        <div class="flex flex-col gap-1.5 mb-3">
            <label for="f-topik" class="text-[0.72rem] font-semibold text-[#4A5E4C]"
                style="font-family:'Plus Jakarta Sans',sans-serif">Topik</label>
            <select id="f-topik"
                class="px-3.5 py-2.5 border border-[#E2EAE3] rounded-xl text-[0.78rem] text-[#1F3A2C] bg-white outline-none focus:border-[#5F8568] transition-colors appearance-none cursor-pointer">
                <option value="">Pilih topik...</option>
                <option>Pencarian Kos</option>
                <option>Daftarkan Kos Saya</option>
                <option>Masalah Akun</option>
                <option>Laporan Bug</option>
                <option>Lainnya</option>
            </select>
        </div>

        <div class="flex flex-col gap-1.5 mb-5">
            <label for="f-pesan" class="text-[0.72rem] font-semibold text-[#4A5E4C]"
                style="font-family:'Plus Jakarta Sans',sans-serif">Pesan</label>
            <textarea id="f-pesan" rows="3" placeholder="Tulis pesanmu di sini..."
                class="px-3.5 py-2.5 border border-[#E2EAE3] rounded-xl text-[0.78rem] text-[#1F3A2C] bg-white outline-none focus:border-[#5F8568] transition-colors resize-y"></textarea>
        </div>

        <div class="flex items-center gap-3 flex-wrap">
            <button onclick="kirimPesan()"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#5F8568] hover:bg-[#4e7057] text-white rounded-xl font-bold text-[0.78rem] transition-colors cursor-pointer border-0">
                <svg class="w-4 h-4 fill-white" viewBox="0 0 24 24">
                    <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z" />
                </svg>
                Kirim Pesan
            </button>
            <span id="form-success" class="hidden text-[0.75rem] font-semibold text-[#5F8568]">
                ✅ Membuka aplikasi email kamu...
            </span>
        </div>
    </div>

    {{-- BANTUAN WHATSAPP --}}
    <div class="bg-white rounded-2xl border border-[#E2EAE3] px-8 py-7 flex items-center gap-6 mb-1">
        <div
            class="w-24 h-20 bg-gradient-to-br from-[#EEF4EF] to-[#C5D5C7] rounded-2xl flex items-center justify-center text-4xl shrink-0">
            💬
        </div>
        <div class="flex-1">
            <h3 class="font-extrabold text-base text-[#1F3A2C] mb-1.5"
                style="font-family:'Plus Jakarta Sans',sans-serif">
                Masih butuh bantuan?
            </h3>
            <p class="text-[0.8rem] text-[#4A5E4C] leading-relaxed mb-3.5">
                Hubungi kami melalui WhatsApp atau email, kami akan merespons secepat mungkin.
            </p>
            <div class="flex gap-2.5 flex-wrap">
                <a href="https://wa.me/6282264676843" target="_blank"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#5F8568] hover:bg-[#4e7057] text-white rounded-xl font-bold text-[0.78rem] transition-colors no-underline">
                    <svg class="w-4 h-4 fill-white" viewBox="0 0 24 24">
                        <path
                            d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                    </svg>
                    Chat WhatsApp
                </a>
                <a href="mailto:twoorbital@gmail.com"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-transparent border-2 border-[#5F8568] text-[#5F8568] hover:bg-[#5F8568] hover:text-white rounded-xl font-bold text-[0.78rem] transition-colors no-underline group">
                    <svg class="w-4 h-4 fill-[#5F8568] group-hover:fill-white transition-colors" viewBox="0 0 24 24">
                        <path
                            d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z" />
                    </svg>
                    Kirim Email
                </a>
            </div>
        </div>
    </div>

</div>

<script>
function toggleFaq(btn) {
    const item = btn.parentElement;
    const answer = item.querySelector('.faq-answer');
    const icon = btn.querySelector('.faq-icon');
    const arrow = btn.querySelector('.faq-arrow');
    const isOpen = item.dataset.open === '1';

    document.querySelectorAll('.faq-item').forEach(el => {
        el.dataset.open = '0';
        el.querySelector('.faq-answer').style.maxHeight = '0';
        el.querySelector('.faq-icon').style.background = '#f0f5f1';
        el.querySelector('.faq-arrow').style.transform = '';
        el.querySelector('.faq-arrow').style.fill = '#5F8568';
    });

    if (!isOpen) {
        item.dataset.open = '1';
        answer.style.maxHeight = answer.scrollHeight + 'px';
        icon.style.background = '#5F8568';
        arrow.style.transform = 'rotate(180deg)';
        arrow.style.fill = '#fff';
    }
}

function kirimPesan() {
    const nama = document.getElementById('f-nama').value.trim();
    const email = document.getElementById('f-email').value.trim();
    const topik = document.getElementById('f-topik').value;
    const pesan = document.getElementById('f-pesan').value.trim();

    if (!nama || !email || !pesan) {
        alert('Mohon isi nama, email, dan pesan terlebih dahulu.');
        return;
    }

    const subject = encodeURIComponent('Pesan dari KosinAja' + (topik ? ' \u2013 ' + topik : ''));
    const body = encodeURIComponent(
        'Nama: ' + nama + '\n' +
        'Email: ' + email + '\n' +
        (topik ? 'Topik: ' + topik + '\n' : '') +
        '\nPesan:\n' + pesan
    );

    window.location.href = 'mailto:twoorbital@gmail.com?subject=' + subject + '&body=' + body;

    const status = document.getElementById('form-success');
    status.classList.remove('hidden');
    setTimeout(() => status.classList.add('hidden'), 4000);
}
</script>

@endsection