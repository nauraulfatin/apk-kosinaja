@extends('layouts.public')

@section('title', 'KosinAja! - Cari Kos Jadi Lebih Mudah')

@section('styles')
<style>
:root {
    --green-dark: #1F3A2C;
    --green-mid: #284535;
    --green-cta: #5F8568;
    --green-light: #7CA385;
    --cream: #F5F4F0;
    --cream-2: #EEF4EF;
    --border-soft: #E2EAE3;
    --text-dark: #1F3A2C;
    --text-mid: #4A5E4C;
    --text-muted: #7A8A7C;
}

/* ─── GLOBAL ─────────────────────────────────── */
* {
    box-sizing: border-box;
}

.container {
    width: 90%;
    max-width: 1320px;
    margin: 0 auto;
}

/* ─── HERO ────────────────────────────────────── */
.hero {
    padding: 15px 0 20px;
    position: relative;
    overflow: hidden;
}

.hero-wrap {
    display: grid;
    grid-template-columns: 1fr 1.15fr;
    align-items: center;
    gap: 160px;
    min-height: 88vh;
}

.hero-blur {
    position: absolute;
    width: 420px;
    height: 420px;
    background: #DDEADF;
    border-radius: 999px;
    filter: blur(120px);
    opacity: .5;
    left: -120px;
    top: 120px;
    z-index: -1;
}

.hero::before {
    content: '';
    position: absolute;
    top: -80px;
    right: -80px;
    width: 400px;
    height: 400px;
    background: radial-gradient(circle, rgba(124, 163, 133, .12) 0%, transparent 70%);
    border-radius: 50%;
    pointer-events: none;
}

.hero::after {
    content: '';
    position: absolute;
    bottom: -60px;
    left: -60px;
    width: 300px;
    height: 300px;
    background: radial-gradient(circle, rgba(124, 163, 133, .10) 0%, transparent 70%);
    border-radius: 50%;
    pointer-events: none;
}

.hero-text {
    position: relative;
    z-index: 2;
    max-width: 560px;
}

.hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(124, 163, 133, .12);
    border: 1px solid rgba(124, 163, 133, .3);
    border-radius: 20px;
    padding: 8px 16px;
    font-size: 1rem;
    font-weight: 600;
    color: var(--green-cta);
    margin-bottom: 40px;
}

.hero-text h1 {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-weight: 800;
    font-size: clamp(2.3rem, 5vw, 4.5rem);
    line-height: 1.1;
    letter-spacing: -2.3px;
    color: var(--green-dark);
    margin-bottom: 30px;
}

.hero-text h1 em {
    font-style: normal;
    color: #729a7b;
}

.hero-text p {
    font-size: 1.08rem;
    color: var(--text-mid);
    line-height: 1.9;
    max-width: 520px;
    margin-bottom: 30px;
}

.hero-search {
    display: flex;
    align-items: center;
    gap: 16px;
    background: #fff;
    border: 1px solid #e6ece7;
    border-radius: 24px;
    padding: 10px;
    max-width: 580px;
    width: 100%;
    margin-bottom: 30px;
    box-shadow: 0 10px 35px rgba(124, 163, 133, .12), 0 2px 10px rgba(0, 0, 0, .03);
}

.hero-search input {
    flex: 1;
    min-width: 0;
    border: none;
    outline: none;
    padding: 0 8px;
    font-family: 'DM Sans', sans-serif;
    font-size: .9rem;
    background: transparent;
    color: var(--text-dark);
}

.hero-search input::placeholder {
    color: var(--text-muted);
}

.hero-search button {
    flex-shrink: 0;
    padding: 12px 20px;
    background: linear-gradient(135deg, #7CA385, #5F8568);
    color: #fff;
    border: none;
    border-radius: 18px;
    font-weight: 700;
    font-size: .95rem;
    cursor: pointer;
    white-space: nowrap;
    transition: all .25s ease;
    box-shadow: 0 10px 24px rgba(124, 163, 133, .28);
    min-width: 200px;
}

.hero-search button:hover {
    transform: translateY(-2px);
    box-shadow: 0 14px 28px rgba(124, 163, 133, .35);
    background: linear-gradient(135deg, #6C8B6B, #56725D);
}

.hero-trust {
    display: flex;
    gap: 18px;
    flex-wrap: wrap;
    margin-top: 22px;
}

.hero-trust span {
    font-size: .92rem;
    color: #6B7B6D;
    background: #F4F7F4;
    border: 1px solid #E4ECE5;
    padding: 10px 16px;
    border-radius: 999px;
}

.hero-image {
    position: relative;
    display: flex;
    justify-content: center;
    align-items: center;
}

.hero-image img {
    max-width: 180%;
    max-height: 800px;
    object-fit: contain;
    animation: float 4s ease-in-out infinite;
}

.hero-float-card {
    position: absolute;
    background: #fff;
    border-radius: 14px;
    padding: 12px 16px;
    box-shadow: 0 8px 28px rgba(0, 0, 0, .10);
    display: flex;
    align-items: center;
    gap: 10px;
    z-index: 5;
    animation: floatCard 3s ease-in-out infinite;
}

.hero-float-card.card-1 {
    top: 70px;
    left: -20px;
}

.hero-float-card.card-2 {
    bottom: 70px;
    left: -30px;
}

.float-icon {
    width: 36px;
    height: 36px;
    background: #f0f5f1;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.float-icon svg {
    width: 18px;
    height: 18px;
    fill: var(--green-cta);
}

.float-text strong {
    display: block;
    font-size: .88rem;
    font-weight: 700;
    color: var(--text-dark);
}

.float-text span {
    font-size: .75rem;
    color: var(--text-muted);
}

@keyframes float {

    0%,
    100% {
        transform: translateY(0)
    }

    50% {
        transform: translateY(-14px)
    }
}

@keyframes floatCard {

    0%,
    100% {
        transform: translateY(0)
    }

    50% {
        transform: translateY(-8px)
    }
}


/* ─── REKOMENDASI KOS ─────────────────────────── */
.rekom-section {
    padding: 60px 0 70px;
    background: var(--cream);
}

.sec-label {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: .72rem;
    font-weight: 700;
    letter-spacing: 1.4px;
    text-transform: uppercase;
    color: var(--green-cta);
    background: rgba(95, 133, 104, .10);
    border: 1px solid rgba(95, 133, 104, .22);
    padding: 5px 13px;
    border-radius: 999px;
    margin-bottom: 12px;
}

.sec-title {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-weight: 800;
    font-size: 2rem;
    line-height: 1.1;
    letter-spacing: -.8px;
    color: var(--green-dark);
    margin-bottom: 8px;
}

.sec-sub {
    font-size: 1rem;
    color: var(--text-muted);
    line-height: 1.7;
}

.sec-header {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    margin-bottom: 36px;
    gap: 20px;
}

/* ─── KOS CARD ────────────────────────────────── */
.kos-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 22px;
}

.kos-card {
    background: #fff;
    border-radius: 24px;
    overflow: hidden;
    border: 1px solid var(--border-soft);
    transition: .3s ease;
    position: relative;
}

.kos-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 20px 50px rgba(31, 58, 44, .11);
    border-color: #C5D5C7;
}

.kos-thumb {
    position: relative;
    height: 196px;
    overflow: hidden;
    background: #D5E0D6;
}

.kos-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform .5s ease;
}

.kos-card:hover .kos-thumb img {
    transform: scale(1.06);
}

.kos-body {
    padding: 16px 18px 20px;
}

.kos-name {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 1.05rem;
    font-weight: 800;
    color: var(--green-dark);
    margin-bottom: 4px;
}

.kos-loc {
    font-size: .82rem;
    color: var(--text-muted);
    margin-bottom: 12px;
}

.kos-divider {
    height: 1px;
    background: #EDF2EE;
    margin-bottom: 12px;
}

.kos-price {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 1.12rem;
    font-weight: 800;
    color: var(--green-mid);
    margin-bottom: 10px;
}

.kos-price span {
    font-size: .78rem;
    font-weight: 500;
    color: var(--text-muted);
}

.kos-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 5px;
    margin-bottom: 16px;
}

.kos-tag {
    padding: 4px 11px;
    border-radius: 999px;
    background: var(--cream-2);
    color: #3D6045;
    font-size: .71rem;
    font-weight: 600;
}

.kos-actions {
    display: flex;
    gap: 8px;
}

.btn-detail {
    flex: 1;
    padding: 10px 6px;
    border-radius: 12px;
    border: 1.5px solid var(--border-soft);
    background: #fff;
    color: var(--green-mid);
    text-decoration: none;
    font-weight: 700;
    font-size: .84rem;
    text-align: center;
    transition: .2s;
    display: flex;
    align-items: center;
    justify-content: center;
}

.btn-detail:hover {
    background: var(--cream);
    border-color: #B5C8B7;
}

.btn-hubungi {
    flex: 1;
    padding: 10px 6px;
    border-radius: 12px;
    background: var(--green-mid);
    color: #fff;
    text-decoration: none;
    font-weight: 700;
    font-size: .84rem;
    text-align: center;
    transition: .2s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
}

.btn-hubungi:hover {
    background: var(--green-dark);
}

.btn-lihat-semua {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 11px 22px;
    border-radius: 14px;
    border: 1.5px solid var(--green-mid);
    color: var(--green-mid);
    text-decoration: none;
    font-weight: 700;
    font-size: .88rem;
    transition: .2s;
    white-space: nowrap;
}

.btn-lihat-semua:hover {
    background: var(--green-mid);
    color: #fff;
}

.empty-kos {
    grid-column: 1/-1;
    text-align: center;
    padding: 60px 20px;
}

.empty-kos .empty-icon {
    font-size: 3rem;
    margin-bottom: 12px;
}

.empty-kos h3 {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-weight: 800;
    color: var(--green-dark);
    margin-bottom: 8px;
}

.empty-kos p {
    color: var(--text-muted);
    font-size: .95rem;
}


/* ─── STATS STRIP ─────────────────────────────── */
.stats-strip {
    background: var(--green-mid);
    padding: 36px 0;
}

.stats-inner {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
}

.stat-item {
    flex: 1;
    min-width: 150px;
    max-width: 220px;
    text-align: center;
    padding: 10px 24px;
    position: relative;
}

.stat-item:not(:last-child)::after {
    content: '';
    position: absolute;
    right: 0;
    top: 18%;
    height: 64%;
    width: 1px;
    background: rgba(255, 255, 255, .18);
}

.stat-num {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 1.9rem;
    font-weight: 800;
    color: #fff;
    line-height: 1;
    margin-bottom: 4px;
}

.stat-label {
    font-size: .78rem;
    color: rgba(255, 255, 255, .58);
}


/* ─── FASILITAS ───────────────────────────────── */
.fac-section {
    padding: 64px 0;
    background: #fff;
}

.fac-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    margin-top: 36px;
}

.fac-item {
    background: var(--cream);
    border: 1px solid var(--border-soft);
    border-radius: 20px;
    padding: 24px 14px 20px;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
    cursor: pointer;
    transition: .25s ease;
    text-align: center;
    text-decoration: none;
}

.fac-item:hover {
    background: var(--green-mid);
    border-color: var(--green-mid);
    transform: translateY(-4px);
    box-shadow: 0 14px 32px rgba(40, 69, 53, .13);
}

.fac-item:hover .fac-icon-wrap {
    background: rgba(255, 255, 255, .15);
}

.fac-item:hover .fac-name {
    color: #fff;
}

.fac-item:hover .fac-count {
    color: rgba(255, 255, 255, .65);
}

.fac-icon-wrap {
    width: 48px;
    height: 48px;
    background: var(--cream-2);
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: .25s;
}

.fac-icon-wrap svg {
    width: 24px;
    height: 24px;
    fill: none;
    stroke: var(--green-mid);
    stroke-width: 1.7;
    stroke-linecap: round;
    stroke-linejoin: round;
    transition: stroke .25s;
}

.fac-item:hover .fac-icon-wrap svg {
    stroke: #fff;
}

.fac-name {
    font-size: .86rem;
    font-weight: 700;
    color: var(--green-dark);
    transition: color .25s;
}

.fac-count {
    font-size: .72rem;
    color: var(--text-muted);
    transition: color .25s;
}


/* ─── KEUNGGULAN KAMI ────────────────────────── */
.why-section {
    padding: 70px 0;
    background: var(--cream);
}

.why-layout {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 52px;
    align-items: start;
}

.why-list {
    display: flex;
    flex-direction: column;
    margin-top: 28px;
}

.why-item {
    display: flex;
    gap: 18px;
    align-items: flex-start;
    padding: 20px 0;
    border-bottom: 1px solid var(--border-soft);
    transition: .2s;
}

.why-item:last-child {
    border-bottom: none;
}

.why-item:hover .why-num {
    background: var(--green-mid);
    color: #fff;
    border-color: var(--green-mid);
}

.why-num {
    width: 38px;
    height: 38px;
    border-radius: 11px;
    background: var(--cream-2);
    border: 1.5px solid #C5D5C7;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-weight: 800;
    font-size: .8rem;
    color: var(--green-mid);
    flex-shrink: 0;
    transition: .2s;
}

.why-text strong {
    display: block;
    font-size: .95rem;
    font-weight: 700;
    color: var(--green-dark);
    margin-bottom: 3px;
}

.why-text p {
    font-size: .82rem;
    color: var(--text-muted);
    line-height: 1.65;
}

.why-panel {
    background: var(--green-mid);
    border-radius: 28px;
    padding: 38px 34px;
    position: relative;
    overflow: hidden;
}

.why-panel::before,
.why-panel::after {
    content: '';
    position: absolute;
    border-radius: 50%;
    background: rgba(255, 255, 255, .05);
    pointer-events: none;
}

.why-panel::before {
    width: 240px;
    height: 240px;
    top: -80px;
    right: -70px;
}

.why-panel::after {
    width: 160px;
    height: 160px;
    bottom: -50px;
    left: -50px;
}

.panel-label {
    font-size: .72rem;
    font-weight: 700;
    letter-spacing: 1.3px;
    text-transform: uppercase;
    color: rgba(255, 255, 255, .5);
    margin-bottom: 18px;
}

.testi-card {
    background: rgba(255, 255, 255, .09);
    border: 1px solid rgba(255, 255, 255, .13);
    border-radius: 18px;
    padding: 20px;
    margin-bottom: 14px;
}

.testi-stars {
    color: #F5C842;
    font-size: .85rem;
    margin-bottom: 10px;
}

.testi-text {
    font-size: .87rem;
    color: rgba(255, 255, 255, .82);
    line-height: 1.65;
    font-style: italic;
}


/* ─── CTA BANNER ───────────────────────────────── */
.cta-banner {
    margin: 0 5% 60px;
    border-radius: 28px;
    overflow: hidden;
    position: relative;
    min-height: 400px;
}

.cta-banner img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    position: absolute;
    inset: 0;
}

.cta-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(20, 40, 22, .84) 0%, rgba(20, 40, 22, .55) 100%);
}

.cta-content {
    position: relative;
    z-index: 2;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    min-height: 400px;
    text-align: center;
    padding: 60px 40px;
}

.cta-content h2 {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-weight: 800;
    font-size: clamp(1.6rem, 3vw, 2.4rem);
    color: #fff;
    margin-bottom: 12px;
}

.cta-content p {
    font-size: 1rem;
    color: rgba(255, 255, 255, .82);
    margin-bottom: 28px;
    max-width: 420px;
}

.btn-cta-white {
    padding: 14px 36px;
    background: var(--green-cta);
    color: #fff;
    border-radius: 12px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-weight: 700;
    font-size: 1rem;
    text-decoration: none;
    transition: background .2s, transform .2s;
}

.btn-cta-white:hover {
    background: #56725D;
    transform: translateY(-2px);
}


/* ─── RESPONSIVE ───────────────────────────────── */
@media (max-width: 1024px) {
    .kos-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .fac-grid {
        grid-template-columns: repeat(4, 1fr);
    }

    .why-layout {
        grid-template-columns: 1fr;
        gap: 32px;
    }
}

@media (max-width: 768px) {
    .hero-wrap {
        grid-template-columns: 1fr;
        gap: 40px;
    }

    .hero {
        padding: 30px 0 50px;
    }

    .hero-text {
        text-align: center;
    }

    .hero-search {
        margin-inline: auto;
    }

    .hero-trust {
        justify-content: center;
    }

    .kos-grid {
        grid-template-columns: 1fr;
    }

    .fac-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .cta-banner {
        margin: 0 4% 40px;
    }
}
</style>
@endsection

@section('content')

{{-- ══════════════════ HERO ══════════════════ --}}
<section class="hero">
    <div class="container hero-wrap">

        <div class="hero-text">
            <div class="hero-blur"></div>
            <div class="hero-badge">Bingung nyari kos? Yuuk cari di KosinAja!</div>
            <h1>Cari Kos Jadi <em>Lebih Mudah</em> & Nyaman</h1>
            <p>Jelajahi pilihan kos terbaik dan lihat detail lengkap sebelum memilih. Cepat, mudah, dan terpercaya.</p>
            <div class="hero-search">
                <input type="text" id="searchInput" placeholder="Cari kos di kota atau daerah...">
                <button type="button" id="searchBtn">Jelajahi Sekarang</button>
            </div>
            <div class="hero-trust">
                <span>✓ Informasi Lengkap</span>
                <span>✓ Harga Transparan</span>
                <span>✓ Lihat Lokasi dan Fasilitas</span>
            </div>
        </div>

        <div class="hero-image">
            <div class="hero-float-card card-1">
                <div class="float-icon">
                    <svg viewBox="0 0 24 24">
                        <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z" />
                    </svg>
                </div>
                <div class="float-text">
                    <strong>Terverifikasi</strong>
                    <span>Semua kos sudah dicek</span>
                </div>
            </div>
            <div class="hero-float-card card-2">
                <div class="float-icon">
                    <svg viewBox="0 0 24 24">
                        <path
                            d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5S10.62 6.5 12 6.5 14.5 7.62 14.5 9 13.38 11.5 12 11.5z" />
                    </svg>
                </div>
                <div class="float-text">
                    <strong>Temukan kos</strong>
                    <span>Sesuai Lokasimu</span>
                </div>
            </div>
            <img src="{{ asset('hero.png') }}" alt="Ilustrasi Cari Kos">
        </div>

    </div>
</section>

{{-- ══════════════════ STATS STRIP ══════════════════ --}}
<div class="stats-strip">
    <div class="container stats-inner">
        <div class="stat-item">
            <div class="stat-num">{{ $kostTerbaru->count() }}</div>
            <div class="stat-label">Kos Terdaftar</div>
        </div>
        <div class="stat-item">
            <div class="stat-num">{{ $kostTerbaru->sum(fn($k) => $k->kamars->count()) }}</div>
            <div class="stat-label">Total Kamar</div>
        </div>
        <div class="stat-item">
            <div class="stat-num">{{ $kostTerbaru->sum(fn($k) => $k->kamars->flatMap->hargaKamars->count()) }}+</div>
            <div class="stat-label">Penghuni Aktif</div>
        </div>
    </div>
</div>

{{-- ══════════════════ REKOMENDASI KOS ══════════════════ --}}
<section class="rekom-section">
    <div class="container">

        <div class="sec-header">
            <div>
                <div class="sec-label">🏡 Pilihan Terbaik</div>
                <h2 class="sec-title">Rekomendasi Kos</h2>
                <p class="sec-sub">
                    Temukan kos nyaman dengan fasilitas lengkap,<br>
                    lokasi strategis, dan harga terbaik untuk kebutuhanmu.
                </p>
            </div>
            <a href="{{ route('katalog') }}" class="btn-lihat-semua">Lihat Semua →</a>
        </div>

        <div class="kos-grid">
            @forelse($kostTerbaru as $kost)

            @php
            $hargaMin = $kost->kamars
            ->flatMap(fn($kamar) => $kamar->hargaKamars)
            ->min('harga');

            $fasilitasKamar = $kost->kamars->first()?->fasilitas ?? collect();
            @endphp

            <div class="kos-card">

                <div class="kos-thumb">
                    @if($kost->foto_utama)
                    <img src="{{ Storage::url($kost->foto_utama) }}" alt="{{ $kost->nama_kost }}">
                    @else
                    <img src="https://images.unsplash.com/photo-1555854877-bab0e564b8d5?w=800&q=80"
                        alt="{{ $kost->nama_kost }}">
                    @endif
                </div>

                <div class="kos-body">
                    <div class="kos-name">{{ $kost->nama_kost }}</div>
                    <div class="kos-loc">📍 {{ $kost->kota ?? $kost->alamat }}</div>

                    <div class="kos-divider"></div>

                    <div class="kos-price">
                        @if($hargaMin)
                        Rp {{ number_format($hargaMin, 0, ',', '.') }}
                        <span>/ bulan</span>
                        @else
                        <span>Hubungi Kami</span>
                        @endif
                    </div>

                    @if($fasilitasKamar->count() > 0)
                    <div class="kos-tags">
                        @foreach($fasilitasKamar->take(4) as $fasilitas)
                        <span class="kos-tag">{{ $fasilitas->nama_fasilitas }}</span>
                        @endforeach
                        @if($fasilitasKamar->count() > 4)
                        <span class="kos-tag">+{{ $fasilitasKamar->count() - 4 }}</span>
                        @endif
                    </div>
                    @endif

                    <div class="kos-actions">
                        <a href="{{ route('detailKost', $kost->id) }}" class="btn-detail">
                            Lihat Detail
                        </a>

                        @if(!empty($kost->no_telepon))
                        <a href="https://wa.me/62{{ ltrim(preg_replace('/[^0-9]/', '', $kost->no_telepon), '0') }}"
                            class="btn-hubungi" target="_blank">
                            Hubungi
                        </a>
                        @else
                        <a href="{{ route('hubungi') }}" class="btn-hubungi">Hubungi</a>
                        @endif
                    </div>
                </div>

            </div>
            @empty
            <div class="empty-kos">
                <div class="empty-icon">🏡</div>
                <h3>Belum Ada Kos Tersedia</h3>
                <p>Kos akan muncul di sini setelah admin menambahkan informasi kos.</p>
            </div>
            @endforelse
        </div>

    </div>
</section>


{{-- ══════════════════ FASILITAS POPULER ══════════════════ --}}
<section class="fac-section">
    <div class="container">

        <div class="sec-header">
            <div>
                <div class="sec-label">✨ Apa yang Kamu Butuhkan</div>
                <h2 class="sec-title">Fasilitas Populer</h2>
                <p class="sec-sub">Filter kos berdasarkan fasilitas yang paling kamu butuhkan.</p>
            </div>
        </div>

        <div class="fac-grid">

            <a href="{{ route('katalog', ['fasilitas' => 'WiFi']) }}" class="fac-item">
                <div class="fac-icon-wrap">
                    <svg viewBox="0 0 24 24">
                        <path d="M5 12.55a11 11 0 0 1 14 0" />
                        <path d="M1.42 9A16 16 0 0 1 22.58 9" />
                        <path d="M8.53 16.11a6 6 0 0 1 6.95 0" />
                        <circle cx="12" cy="20" r="1" fill="currentColor" stroke="none" />
                    </svg>
                </div>
                <span class="fac-name">WiFi</span>
            </a>

            <a href="{{ route('katalog', ['fasilitas' => 'AC']) }}" class="fac-item">
                <div class="fac-icon-wrap">
                    <svg viewBox="0 0 24 24">
                        <rect x="2" y="6" width="20" height="8" rx="2" />
                        <path d="M7 14v4M12 14v4M17 14v4" />
                        <path d="M6 10h.01M10 10h.01M14 10h.01" />
                    </svg>
                </div>
                <span class="fac-name">AC</span>
            </a>

            <a href="{{ route('katalog', ['fasilitas' => 'KM Dalam']) }}" class="fac-item">
                <div class="fac-icon-wrap">
                    <svg viewBox="0 0 24 24">
                        <path d="M4 6h16v12a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6z" />
                        <path d="M12 6V4" />
                        <path d="M8 10h8" />
                        <circle cx="12" cy="15" r="2" />
                    </svg>
                </div>
                <span class="fac-name">KM Dalam</span>
            </a>

            <a href="{{ route('katalog', ['fasilitas' => 'Dapur']) }}" class="fac-item">
                <div class="fac-icon-wrap">
                    <svg viewBox="0 0 24 24">
                        <path d="M3 11V3h5v8a3 3 0 0 1-6 0z" />
                        <path d="M6 3v8" />
                        <path d="M21 3c-1 4-1 6 0 10H9" />
                        <path d="M9 13v7a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1v-7" />
                    </svg>
                </div>
                <span class="fac-name">Dapur</span>
            </a>

            <a href="{{ route('katalog', ['fasilitas' => 'CCTV']) }}" class="fac-item">
                <div class="fac-icon-wrap">
                    <svg viewBox="0 0 24 24">
                        <path d="M23 7l-7 5 7 5V7z" />
                        <rect x="1" y="5" width="15" height="14" rx="2" />
                    </svg>
                </div>
                <span class="fac-name">CCTV</span>
            </a>

            <a href="{{ route('katalog', ['fasilitas' => 'Laundry']) }}" class="fac-item">
                <div class="fac-icon-wrap">
                    <svg viewBox="0 0 24 24">
                        <rect x="3" y="3" width="18" height="18" rx="3" />
                        <circle cx="12" cy="13" r="4" />
                        <path d="M8 6h.01M11 6h.01" />
                    </svg>
                </div>
                <span class="fac-name">Laundry</span>
            </a>

            <a href="{{ route('katalog', ['fasilitas' => 'Parkir']) }}" class="fac-item">
                <div class="fac-icon-wrap">
                    <svg viewBox="0 0 24 24">
                        <rect x="3" y="3" width="18" height="18" rx="2" />
                        <path d="M9 17V7h4a3 3 0 0 1 0 6H9" />
                    </svg>
                </div>
                <span class="fac-name">Parkir</span>
            </a>

            <a href="{{ route('katalog', ['fasilitas' => 'Kolam Renang']) }}" class="fac-item">
                <div class="fac-icon-wrap">
                    <svg viewBox="0 0 24 24">
                        <path d="M2 12h20" />
                        <path d="M2 16c2-2 4-2 6 0s4 2 6 0 4-2 6 0" />
                        <path d="M7 12V7l5-3 5 3v5" />
                        <path d="M11 7h2" />
                    </svg>
                </div>
                <span class="fac-name">Kolam Renang</span>
            </a>

        </div>
    </div>
</section>


{{-- ══════════════════ KEUNGGULAN KAMI ══════════════════ --}}
<section class="why-section">
    <div class="container">

        <div class="why-layout">

            <div>
                <div class="sec-label">🌿 Keunggulan Kami</div>
                <h2 class="sec-title">Kenapa Pilih<br>KosinAja?</h2>
                <p class="sec-sub">Kami hadir untuk memudahkan kamu menemukan dan mengelola kos dengan lebih baik.</p>

                <div class="why-list">
                    <div class="why-item">
                        <div class="why-num">01</div>
                        <div class="why-text">
                            <strong>Pilihan Kos Terpercaya</strong>
                            <p>Semua kos sudah terverifikasi dengan ketat oleh tim kami sebelum ditayangkan.</p>
                        </div>
                    </div>
                    <div class="why-item">
                        <div class="why-num">02</div>
                        <div class="why-text">
                            <strong>Informasi Lengkap & Transparan</strong>
                            <p>Foto asli, harga jelas, dan fasilitas lengkap tanpa biaya tersembunyi.</p>
                        </div>
                    </div>
                    <div class="why-item">
                        <div class="why-num">03</div>
                        <div class="why-text">
                            <strong>Proses Mudah & Cepat</strong>
                            <p>Temukan dan hubungi pemilik kos hanya dalam beberapa klik saja.</p>
                        </div>
                    </div>
                    <div class="why-item">
                        <div class="why-num">04</div>
                        <div class="why-text">
                            <strong>Aman & Terjamin</strong>
                            <p>Privasi data kamu aman bersama kami. Setiap transaksi terproteksi.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="why-panel">
                <p class="panel-label">💡 Tips Memilih Kos</p>

                <div class="testi-card">
                    <div class="testi-stars">📍 Lokasi</div>
                    <div class="testi-text">
                        Pilih kos yang dekat dengan kampus atau tempat kerja. Perhatikan akses transportasi umum dan
                        jarak ke fasilitas seperti minimarket dan warung makan.
                    </div>
                </div>

                <div class="testi-card">
                    <div class="testi-stars">💰 Harga</div>
                    <div class="testi-text">
                        Sesuaikan harga kos dengan budget bulanan. Jangan lupa hitung biaya tambahan seperti listrik,
                        air, dan WiFi sebelum memutuskan.
                    </div>
                </div>

                <div class="testi-card">
                    <div class="testi-stars">🔍 Survey Langsung</div>
                    <div class="testi-text">
                        Selalu survey langsung sebelum memilih. Cek kondisi kamar, kamar mandi, keamanan, dan
                        kebersihan lingkungan sekitar.
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>


{{-- ══════════════════ CTA BANNER ══════════════════ --}}
<div class="cta-banner">
    <img src="{{ asset('why.png') }}" alt="Kelola Kos">
    <div class="cta-overlay"></div>
    <div class="cta-content">
        <h2>Punya kos? Kelola di KosinAja!</h2>
        <p>Daftarkan dan kelola kos Anda dengan mudah dan praktis</p>
        <a href="{{ route('admin-kost.register') }}" class="btn-cta-white">Daftar Sekarang</a>
    </div>
</div>

@endsection

@push('scripts')
<script>
var katalogUrl = "{{ route('katalog') }}";

// Tombol search
document.getElementById('searchBtn').addEventListener('click', function() {
    var q = document.getElementById('searchInput').value;
    window.location.href = katalogUrl + '?search=' + encodeURIComponent(q);
});

// Enter key
document.getElementById('searchInput').addEventListener('keydown', function(e) {
    if (e.key === 'Enter') {
        window.location.href = katalogUrl + '?search=' + encodeURIComponent(this.value);
    }
});
</script>
@endpush