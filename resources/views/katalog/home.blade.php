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

* {
    box-sizing: border-box;
}

.container {
    width: 90%;
    max-width: 1320px;
    margin: 0 auto;
}

/* ─── HERO FULL ────────────────────────────────────────── */
.hero {
    position: relative;
    width: 100%;
    min-height: 100vh;
    display: flex;
    align-items: center;
    overflow: hidden;
}

.hero-bg {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center top;
    z-index: 0;
    filter: brightness(1.25) saturate(1.05);
}

.hero-overlay {
    position: absolute;
    inset: 0;
    z-index: 1;
    background: linear-gradient(to right,
            rgba(8, 20, 10, 0.55) 0%,
            rgba(8, 20, 10, 0.35) 35%,
            rgba(8, 20, 10, 0.10) 58%,
            rgba(8, 20, 10, 0.00) 80%);
}

.hero-overlay::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(to top,
            rgba(8, 20, 10, 0.18) 0%,
            rgba(8, 20, 10, 0.04) 22%,
            transparent 48%);
}

.hero-content {
    position: relative;
    z-index: 2;
    padding: 70px 0 100px;
    max-width: 620px;
    margin-left: calc((100% - 1320px) / 2);
    padding-left: 0;
}

@media (max-width: 1320px) {
    .hero-content {
        margin-left: 5%;
    }
}

.hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(255, 255, 255, 0.12);
    border: 1px solid rgba(255, 255, 255, 0.28);
    backdrop-filter: blur(6px);
    -webkit-backdrop-filter: blur(6px);
    border-radius: 999px;
    padding: 9px 16px;
    font-size: 0.92rem;
    font-weight: 600;
    color: rgba(255, 255, 255, 0.92);
    margin-bottom: 16px;
}

.hero-content h1 {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-weight: 800;
    font-size: clamp(2.4rem, 4.5vw, 4rem);
    line-height: 1.1;
    letter-spacing: -2px;
    color: #ffffff;
    margin-bottom: 20px;
    text-shadow: 0 2px 20px rgba(10, 22, 12, 0.35);
}

.hero-content h1 em {
    font-style: normal;
    color: #8FC99A;
}

.hero-content p {
    font-size: 1.05rem;
    color: rgba(255, 255, 255, 0.88);
    line-height: 1.85;
    max-width: 480px;
    margin-bottom: 32px;
    text-shadow: 0 1px 10px rgba(10, 22, 12, 0.30);
}

/* Search bar */
.hero-search {
    display: flex;
    align-items: center;
    gap: 10px;
    background: #fff;
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 20px;
    padding: 8px 8px 8px 16px;
    max-width: 540px;
    width: 100%;
    margin-bottom: 28px;
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.22);
}

.hero-search svg {
    width: 18px;
    height: 18px;
    fill: #9CA3AF;
    flex-shrink: 0;
}

.hero-search input {
    flex: 1;
    min-width: 0;
    border: none;
    outline: none;
    font-family: 'DM Sans', sans-serif;
    font-size: 0.9rem;
    background: transparent;
    color: var(--text-dark);
}

.hero-search input::placeholder {
    color: #9CA3AF;
}

.hero-search button {
    flex-shrink: 0;
    padding: 12px 22px;
    background: var(--green-mid);
    color: #fff;
    border: none;
    border-radius: 14px;
    font-weight: 700;
    font-size: 0.92rem;
    cursor: pointer;
    white-space: nowrap;
    transition: all 0.25s ease;
}

.hero-search button:hover {
    background: var(--green-dark);
    transform: translateY(-1px);
}

/* Trust badges */
.hero-trust {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.hero-trust span {
    font-size: 0.85rem;
    font-weight: 600;
    color: rgba(255, 255, 255, 0.88);
    background: rgba(255, 255, 255, 0.10);
    border: 1px solid rgba(255, 255, 255, 0.20);
    backdrop-filter: blur(4px);
    -webkit-backdrop-filter: blur(4px);
    padding: 8px 16px;
    border-radius: 999px;
}

/* Float cards */
.hero-float-card {
    position: absolute;
    background: #fff;
    border-radius: 14px;
    padding: 12px 16px;
    box-shadow: 0 8px 28px rgba(0, 0, 0, 0.14);
    display: flex;
    align-items: center;
    gap: 10px;
    z-index: 3;
    animation: floatCard 3.5s ease-in-out infinite;
}

.hero-float-card.card-1 {
    top: 22%;
    right: 8%;
    animation-delay: 0s;
}

.hero-float-card.card-2 {
    bottom: 20%;
    right: 14%;
    animation-delay: 1.2s;
}

@keyframes floatCard {

    0%,
    100% {
        transform: translateY(0);
    }

    50% {
        transform: translateY(-10px);
    }
}

/* ── CTA Button Hero ── */
.hero-cta-group {
    display: flex;
    align-items: center;
    gap: 14px;
    flex-wrap: wrap;
    margin-bottom: 28px;
}

.btn-hero-primary {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 14px 28px;
    background: #5F8568;
    color: #fff;
    border: none;
    border-radius: 16px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-weight: 700;
    font-size: 0.98rem;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.28s ease;
    box-shadow: 0 6px 24px rgba(31, 58, 44, 0.40);
}

.btn-hero-primary:hover {
    background: #4a6e52;
    transform: translateY(-2px);
    box-shadow: 0 12px 36px rgba(31, 58, 44, 0.50);
    color: #fff;
}

.btn-hero-primary svg {
    width: 18px;
    height: 18px;
    fill: currentColor;
    transition: transform 0.2s ease;
}

.btn-hero-primary:hover svg {
    transform: translateX(3px);
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
    font-size: 0.86rem;
    font-weight: 700;
    color: var(--text-dark);
}

.float-text span {
    font-size: 0.73rem;
    color: var(--text-muted);
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
    padding: 26px 0;
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
    grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
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


/* ─── CARA KERJA ─────────────────────────────── */
.how-section {
    padding: 80px 0;
    background: #fff;
}

.how-grid {
    display: grid;
    grid-template-columns: 1fr 24px 1fr 24px 1fr 24px 1fr;
    gap: 0 8px;
    align-items: center;
}

.how-card {
    background: transparent;
    border: 1.5px solid var(--border-soft);
    border-radius: 24px;
    padding: 28px 24px 26px;
    display: flex;
    flex-direction: column;
    gap: 10px;
    transition: all 0.25s ease;
    position: relative;
    z-index: 1;
    cursor: default;
}

.how-card:hover {
    background: var(--green-mid);
    border-color: var(--green-mid);
    transform: translateY(-5px);
    box-shadow: 0 16px 40px rgba(31, 58, 44, 0.18);
}

.how-card:hover .how-step-num {
    color: rgba(255, 255, 255, 0.50);
}

.how-card:hover .how-title {
    color: #fff;
}

.how-card:hover .how-desc {
    color: rgba(255, 255, 255, 0.75);
}

.how-card:hover .how-icon-wrap {
    background: rgba(255, 255, 255, 0.15) !important;
}

.how-card:hover .how-icon-wrap svg {
    stroke: #fff;
}

.how-card:hover .how-cta {
    border-color: rgba(255, 255, 255, 0.50);
    color: #fff;
}

.how-card:hover .how-cta:hover {
    background: rgba(255, 255, 255, 0.20);
}

.how-card--highlight {
    background: var(--green-mid);
    border-color: var(--green-mid);
}

.how-card--highlight .how-step-num {
    color: rgba(255, 255, 255, 0.45);
}

.how-icon-wrap {
    width: 52px;
    height: 52px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 4px;
}

.how-icon-wrap svg {
    width: 26px;
    height: 26px;
}

.how-step-num {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 0.72rem;
    font-weight: 800;
    letter-spacing: 1.5px;
    color: var(--green-cta);
    text-transform: uppercase;
}

.how-title {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 1rem;
    font-weight: 800;
    color: var(--green-dark);
    line-height: 1.3;
    margin: 0;
}

.how-desc {
    font-size: 0.82rem;
    color: var(--text-muted);
    line-height: 1.7;
    margin: 0;
}

.how-cta {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    margin-top: 8px;
    padding: 8px 16px;
    font-size: 0.80rem;
    font-weight: 700;
    color: var(--green-mid);
    text-decoration: none;
    border: 1.5px solid var(--green-mid);
    border-radius: 10px;
    background: transparent;
    transition: all 0.22s ease;
    touch-action: manipulation;
    cursor: pointer;
    width: fit-content;
}

.how-cta:hover {
    background: var(--green-mid);
    color: #fff;
    gap: 10px;
}

.how-arrow {
    text-align: center;
    font-size: 1.2rem;
    color: #C5D5C7;
    font-weight: 300;
    user-select: none;
}

@media (max-width: 768px) {
    .how-grid {
        grid-template-columns: 1fr;
        gap: 12px;
    }

    .how-arrow {
        display: none;
    }

    .how-card {
        padding: 22px 20px;
        flex-direction: row;
        align-items: flex-start;
        gap: 16px;
    }

    .how-icon-wrap {
        flex-shrink: 0;
        width: 44px;
        height: 44px;
        border-radius: 14px;
        margin-bottom: 0;
    }

    .how-icon-wrap svg {
        width: 22px;
        height: 22px;
    }

    .how-card>div:not(.how-icon-wrap) {
        display: contents;
    }

    .how-step-num {
        order: -1;
    }

    .how-cta {
        display: inline-flex;
        margin-top: 4px;
        padding: 8px 16px;
        background: var(--green-mid);
        color: #fff;
        border-radius: 10px;
        font-size: 0.78rem;
        font-weight: 700;
        text-decoration: none;
        width: fit-content;
        -webkit-tap-highlight-color: rgba(0, 0, 0, 0.1);
        touch-action: manipulation;
    }

    .how-cta:hover,
    .how-cta:active {
        background: var(--green-dark);
        gap: 8px;
    }

    .how-card--highlight .how-cta {
        background: rgba(255, 255, 255, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.4);
    }
}

/* ═══════════════════════════════════════════════════
   RESPONSIVE — MOBILE (≤768px)
═══════════════════════════════════════════════════ */
@media (max-width: 768px) {

    /* ── Hero: tata letak teks di kiri atas, tinggi menyesuaikan konten ── */
    .hero {
        /* Bukan 100svh lagi — cukup muat konten tanpa sisa ruang berlebih */
        min-height: auto;
        height: auto;
        align-items: flex-start;
    }

    .hero-bg {
        /* Foto tetap mengisi kotak hero */
        position: absolute;
        inset: 0;
        height: 100%;
        object-position: 68% center;
    }

    /* Overlay kuat di kiri-atas supaya teks jelas terbaca */
    .hero-overlay {
        background: linear-gradient(to right,
                rgba(8, 20, 10, 0.68) 0%,
                rgba(8, 20, 10, 0.40) 50%,
                rgba(8, 20, 10, 0.08) 100%);
    }

    .hero-content {
        /* top = navbar (~64px) + 10px, bawah ramping */
        padding: 48px 5% 24px;
        max-width: 100%;
        margin-left: 0;
        width: 100%;
    }

    .hero-badge {
        font-size: 0.68rem;
        padding: 8px 10px;
        margin-bottom: 8px;
        gap: 5px;
    }

    /* Judul: BESAR & bold — kontras tinggi vs paragraf */
    .hero-content h1 {
        font-size: clamp(2rem, 8vw, 2.8rem);
        font-weight: 900;
        line-height: 0.98;
        letter-spacing: -0.5px;
        margin-bottom: 14px;
        max-width: 260px;
        text-wrap: balance;
        color: #ffffff;
    }

    /* Paragraf: kecil & lebih redup — jelas di bawah judul */
    .hero-content p {
        font-size: 0.74rem;
        font-weight: 400;
        line-height: 1.7;
        color: rgba(255, 255, 255, 0.78);
        margin-bottom: 12px;
        max-width: 250px;
    }

    /* ── Search bar: compact, tetap 1 baris ── */
    .hero-search {
        display: none;
    }

    .hero-trust {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
        margin-top: 16px;
    }

    .hero-trust span {
        font-size: 0.68rem;
        padding: 5px 10px;
    }

    /* Float cards: sembunyikan */
    .hero-float-card {
        display: none;
    }

    /* ── Stats strip ── */
    .stats-strip {
        padding: 20px 0;
    }

    .stats-inner {
        gap: 0;
    }

    .stat-item {
        min-width: 90px;
        padding: 6px 12px;
    }

    .stat-num {
        font-size: 1.3rem;
    }

    .stat-label {
        font-size: 0.65rem;
    }

    /* ── Rekomendasi Kos ── */
    .rekom-section {
        padding: 36px 0 44px;
    }

    .sec-header {
        flex-direction: row;
        /* judul & tombol tetap sejajar */
        align-items: center;
        margin-bottom: 20px;
        gap: 12px;
    }

    .sec-title {
        font-size: 1.35rem;
        margin-bottom: 4px;
    }

    .sec-sub {
        font-size: 0.78rem;
        display: none;
        /* sembunyikan subtitle agar tidak penuh */
    }

    .btn-lihat-semua {
        padding: 8px 14px;
        font-size: 0.75rem;
        border-radius: 10px;
        flex-shrink: 0;
    }

    /* ── Kos card: layout HORIZONTAL (seperti Mamikos) ── */
    .kos-grid {
        grid-template-columns: 1fr;
        gap: 12px;
    }

    /* Ubah card jadi horizontal: foto kiri, info kanan */
    .kos-card {
        display: flex;
        flex-direction: row;
        border-radius: 18px;
        min-height: 0;
    }

    .kos-thumb {
        width: 120px;
        min-width: 120px;
        height: auto;
        min-height: 140px;
        border-radius: 0;
        flex-shrink: 0;
    }

    /* Sembunyikan peta di dalam card mobile — terlalu padat */
    .kos-card .kos-body iframe,
    .kos-card .kos-body div[style*="height:120px"] {
        display: none;
    }

    .kos-body {
        padding: 12px 13px 12px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        min-width: 0;
        flex: 1;
    }

    .kos-name {
        font-size: 0.88rem;
        font-weight: 800;
        margin-bottom: 2px;
        /* potong jika kepanjangan */
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .kos-loc {
        font-size: 0.72rem;
        margin-bottom: 6px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .kos-divider {
        margin-bottom: 6px;
    }

    .kos-price {
        font-size: 0.88rem;
        margin-bottom: 6px;
    }

    .kos-price span {
        font-size: 0.7rem;
    }

    .kos-tags {
        gap: 4px;
        margin-bottom: 8px;
    }

    .kos-tag {
        font-size: 0.62rem;
        padding: 3px 8px;
    }

    .kos-actions {
        gap: 6px;
    }

    .btn-detail,
    .btn-hubungi {
        padding: 8px 6px;
        font-size: 0.75rem;
        border-radius: 10px;
    }

    /* ── Fasilitas: 4 kolom kecil seperti Mamikos ── */
    .fac-section {
        padding: 36px 0;
    }

    .fac-grid {
        grid-template-columns: repeat(4, 1fr);
        gap: 8px;
        margin-top: 20px;
    }

    .fac-item {
        padding: 14px 6px 12px;
        border-radius: 14px;
        gap: 6px;
    }

    .fac-icon-wrap {
        width: 34px;
        height: 34px;
        border-radius: 10px;
    }

    .fac-icon-wrap svg {
        width: 17px;
        height: 17px;
    }

    .fac-name {
        font-size: 0.68rem;
        line-height: 1.2;
    }

    .fac-count {
        font-size: 0.6rem;
    }

    /* ── Keunggulan ── */
    .why-section {
        padding: 40px 0;
    }

    .why-layout {
        grid-template-columns: 1fr;
        gap: 24px;
    }

    .why-panel {
        padding: 24px 18px;
        border-radius: 20px;
    }

    .testi-card {
        padding: 14px;
        margin-bottom: 8px;
    }

    .testi-text {
        font-size: 0.8rem;
    }

    /* ── CTA Banner ── */
    .cta-banner {
        margin: 0 4% 36px;
        border-radius: 18px;
        min-height: 240px;
    }

    .cta-content {
        min-height: 240px;
        padding: 36px 20px;
    }

    .cta-content h2 {
        font-size: clamp(1.2rem, 5vw, 1.6rem);
        margin-bottom: 8px;
    }

    .cta-content p {
        font-size: 0.83rem;
        margin-bottom: 18px;
    }

    .btn-cta-white {
        padding: 12px 28px;
        font-size: 0.9rem;
    }
}

/* ═══════════════════════════════════════════════════
   RESPONSIVE — MOBILE KECIL (≤400px)
═══════════════════════════════════════════════════ */
@media (max-width: 400px) {
    .hero-content h1 {
        font-size: 1.5rem;
        max-width: 320px;
    }

    .hero-search button {
        font-size: 0.72rem;
        padding: 8px 10px;
    }

    /* Stats: tetap 3 kolom tapi lebih kecil */
    .stat-num {
        font-size: 1.1rem;
    }

    .stat-label {
        font-size: 0.6rem;
    }

    /* Foto card kos sedikit lebih sempit */
    .kos-thumb {
        width: 100px;
        min-width: 100px;
    }

    /* Fasilitas: tetap 4 kolom, lebih rapat */
    .fac-grid {
        gap: 6px;
    }

    .fac-item {
        padding: 12px 4px 10px;
    }

    .fac-name {
        font-size: 0.62rem;
    }
}
</style>
@endsection

@section('content')

{{-- ══════════════════ HERO FULL IMAGE ══════════════════ --}}
<section class="hero">

    {{-- Background image full cover --}}
    <img src="{{ asset('hero.png') }}" alt="KosinAja Hero" class="hero-bg">

    {{-- Overlay gelap dari kiri --}}
    <div class="hero-overlay"></div>

    {{-- Float cards di atas gambar (pojok kanan) --}}
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

    {{-- Konten teks kiri --}}
    <div class="hero-content">
        <div class="hero-badge">🌿 Bingung nyari kos? Yuk cari di KosinAja!</div>

        <h1>Cari Kos Jadi <em>Lebih Mudah</em> & Nyaman</h1>

        <p>Temukan kos impianmu dengan mudah dan cepat. Tidak perlu repot survey ke sana-sini,
            cukup buka KosinAja dan temukan kos yang pas untuk kamu!</p>

        <div class="hero-trust">
            <span>✓ Informasi Lengkap</span>
            <span>✓ Harga Transparan</span>
            <span>✓ Lihat Lokasi & Fasilitas</span>
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
            <div class="stat-num">{{ $kostTerbaru->sum(fn($k) => $k->kamars->flatMap->hargaKamars->count()) }}</div>
            <div class="stat-label">Penghuni Aktif</div>
        </div>
    </div>
</div>

{{-- ══════════════════ CARA KERJA ══════════════════ --}}
<section class="how-section">
    <div class="container">

        <div style="text-align:center;margin-bottom:56px;">
            <div class="sec-label">🌿 Cara Kerja</div>
            <h2 class="sec-title">Mudah dalam 4 Langkah</h2>
            <p class="sec-sub">Dari cari hingga tinggal — semua bisa dilakukan dari sini</p>
        </div>

        <div class="how-grid">

            {{-- Step 1 --}}
            <div class="how-card">
                <div class="how-icon-wrap" style="background:#E8F4EC;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#284535" stroke-width="1.8" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                        <polyline points="9 22 9 12 15 12 15 22" />
                    </svg>
                </div>
                <div class="how-step-num">01</div>
                <h4 class="how-title">Lihat Pilihan Kost</h4>
                <p class="how-desc">Jelajahi daftar kost tersedia lengkap dengan foto, fasilitas, harga, dan lokasi yang
                    sudah terverifikasi.</p>
            </div>

            <div class="how-arrow">→</div>

            {{-- Step 2 --}}
            <div class="how-card">
                <div class="how-icon-wrap" style="background:#EEF4EF;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#284535" stroke-width="1.8" stroke-linecap="round"
                        stroke-linejoin="round">
                        <rect x="3" y="3" width="18" height="14" rx="2" />
                        <path d="M3 9h18" />
                        <path d="M9 21h6" />
                        <path d="M12 17v4" />
                    </svg>
                </div>
                <div class="how-step-num">02</div>
                <h4 class="how-title">Lihat Detail & Foto</h4>
                <p class="how-desc">Cek foto asli, fasilitas lengkap, harga transparan, dan lokasi kos langsung di peta
                    sebelum memutuskan.</p>
            </div>

            <div class="how-arrow">→</div>

            {{-- Step 3 --}}
            <div class="how-card">
                <div class="how-icon-wrap" style="background:#E8F4EC;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#284535" stroke-width="1.8" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z" />
                        <path d="M8 10h8M8 14h5" />
                    </svg>
                </div>
                <div class="how-step-num">03</div>
                <h4 class="how-title">Hubungi Pemilik</h4>
                <p class="how-desc">Langsung hubungi pemilik kos via WhatsApp untuk tanya-tanya atau jadwalkan kunjungan
                    ke lokasi.</p>
            </div>

            <div class="how-arrow">→</div>

            {{-- Step 4 --}}
            <div class="how-card">
                <div class="how-icon-wrap" style="background:#E8F4EC;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#284535" stroke-width="1.8" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                        <polyline points="9 22 9 12 15 12 15 22" />
                    </svg>
                </div>
                <div class="how-step-num">04</div>
                <h4 class="how-title">Nikmati Kost baru mu!</h4>
                <p class="how-desc">Setelah deal, kamu tinggal pindah dan nikmati
                    kos barumu. Semudah itu!</p>
            </div>

            <div class="how-arrow">→</div>

        </div>
    </div>
</section>

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
        </div>

        <div class="kos-grid">
            @forelse($kostTerbaru as $kost)

            @php
            $hargaAktif = $kost->kamars
            ->flatMap(function ($kamar) {

            return $kamar->hargaKamars
            ->where('isactive', true);

            });

            /*
            |--------------------------------------------------------------------------
            | PRIORITAS HARGA BULANAN
            |--------------------------------------------------------------------------
            */

            $hargaBulanan = $hargaAktif->filter(function ($harga) {

            return $harga->periode
            &&
            $harga->periode->satuan_interval === 'bulan';

            });

            /*
            |--------------------------------------------------------------------------
            | JIKA ADA BULANAN → PAKAI BULANAN
            |--------------------------------------------------------------------------
            */

            if ($hargaBulanan->count() > 0)
            {
            $hargaDipakai = $hargaBulanan;

            $labelPeriode = 'bulan';
            }

            /*
            |--------------------------------------------------------------------------
            | JIKA TIDAK ADA → PAKAI SEMUA HARGA AKTIF
            |--------------------------------------------------------------------------
            */

            else
            {
            $hargaDipakai = $hargaAktif;

            $periodePertama =
            $hargaAktif->first()?->periode;

            $labelPeriode =
            $periodePertama?->satuan_interval
            ?? '-';
            }

            $hargaMin = $hargaDipakai->min('harga');

            $hargaMax = $hargaDipakai->max('harga');

            $fasilitasKost = $kost->fasilitas ?? collect();

            $noHp = $kost->user?->no_hp;
            $noWa = $noHp ? '62' . ltrim(preg_replace('/[^0-9]/', '', $noHp), '0') : null;
            @endphp

            <div class="kos-card">

                <div class="kos-thumb">
                    @if($kost->foto_kost && count($kost->foto_kost) > 0)
                    <img src="{{ Storage::url($kost->foto_kost[0]) }}" alt="{{ $kost->nama_kost }}">
                    @else
                    <div
                        style="width:100%;height:100%;background:#D5E0D6;display:flex;align-items:center;justify-content:center;">
                        <svg xmlns="http://www.w3.org/2000/svg" style="width:48px;height:48px;fill:#A8C0AA;"
                            viewBox="0 0 24 24">
                            <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z" />
                        </svg>
                    </div>
                    @endif
                </div>

                <div class="kos-body">
                    <div class="kos-name">{{ $kost->nama_kost }}</div>
                    <div class="kos-loc">📍 {{ $kost->alamat }}</div>

                    @if($kost->lokasi)
                    <div style="margin-bottom:10px;border-radius:10px;overflow:hidden;height:120px;">
                        <iframe src="{{ $kost->lokasi }}" width="100%" height="120" style="border:0;display:block;"
                            allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                    @endif

                    <div class="kos-divider"></div>

                    <div class="kos-price">
                        @if($hargaMin && $hargaMax && $hargaMin != $hargaMax)
                        Rp {{ number_format($hargaMin, 0, ',', '.') }}
                        <span>

                            – Rp {{ number_format($hargaMax, 0, ',', '.') }}

                            / {{ $labelPeriode }}

                        </span>
                        @elseif($hargaMin)
                        Rp {{ number_format($hargaMin, 0, ',', '.') }}
                        <span>

                            / {{ $labelPeriode }}

                        </span>
                        @else
                        <span>Hubungi Kami</span>
                        @endif
                    </div>

                    @if($fasilitasKost->count() > 0)
                    <div class="kos-tags">
                        @foreach($fasilitasKost->take(4) as $fasilitas)
                        <span class="kos-tag">{{ $fasilitas->nama_fasilitas }}</span>
                        @endforeach
                        @if($fasilitasKost->count() > 4)
                        <span class="kos-tag">+{{ $fasilitasKost->count() - 4 }}</span>
                        @endif
                    </div>
                    @endif

                    <div class="kos-actions">
                        <a href="{{ route('detailKost', $kost->id) }}" class="btn-detail">Lihat Detail</a>

                        @if($noWa)
                        <a href="https://wa.me/{{ $noWa }}" class="btn-hubungi" target="_blank">Hubungi</a>
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
            @forelse($fasilitasPopuler as $nama => $data)
            @php
            $total = ($data->kosts_count ?? 0) + ($data->kamars_count ?? 0);
            @endphp
            <a href="{{ route('katalog', ['fasilitas' => $nama]) }}" class="fac-item">
                <div class="fac-icon-wrap">
                    @php

                    $icons = [
                    'WiFi' => '
                    <path d="M2 8.82a15 15 0 0120 0" />
                    <path d="M5 12.86a10 10 0 0114 0" />
                    <path d="M8.5 16.9a5 5 0 017 0" />
                    <path d="M12 20h.01" />',
                    'AC' => '
                    <path d="M12 2v20" />
                    <path d="M4.93 4.93l14.14 14.14" />
                    <path d="M2 12h20" />
                    <path d="M4.93 19.07L19.07 4.93" />',
                    'Kulkas' => '
                    <rect x="7" y="2" width="10" height="20" rx="2" />
                    <path d="M7 12h10" />
                    <path d="M10 6h.01" />
                    <path d="M10 16h.01" />',
                    'CCTV' => '
                    <path d="M3 10l10-5 3 6-10 5z" />
                    <path d="M13 5l4-2" />
                    <path d="M16 14l2 4" />',
                    'Ruang Tamu' => '
                    <path d="M4 12V7a2 2 0 012-2h12a2 2 0 012 2v5" />
                    <path d="M2 12h20v5H2z" />',
                    'TV' => '
                    <rect x="3" y="5" width="18" height="12" rx="2" />
                    <path d="M8 21h8" />',
                    'Kipas Angin' => '
                    <circle cx="12" cy="12" r="2" />
                    <path d="M12 4 C15 4 16 7 14 9 C13 10 11 9 11 7 C11 5 11.5 4 12 4Z" />
                    <path d="M20 12 C20 15 17 16 15 14 C14 13 15 11 17 11 C19 11 20 11.5 20 12Z" />
                    <path d="M12 20 C9 20 8 17 10 15 C11 14 13 15 13 17 C13 19 12.5 20 12 20Z" />
                    <path d="M4 12 C4 9 7 8 9 10 C10 11 9 13 7 13 C5 13 4 12.5 4 12Z " />',
                    'Area Parkir' => '
                    <path d="M6 4h7a4 4 0 010 8H6z" />
                    <path d="M6 12v8" />'
                    ];

                    @endphp

                    <svg viewBox="0 0 24 24">

                        {!! $icons[$nama] ?? '
                        <circle cx="12" cy="12" r="8" />
                        ' !!}

                    </svg>
                </div>
                <span class="fac-name">{{ $nama }}</span>
                <span class="fac-count">
                    {{ $total > 0 ? $total . ' tersedia' : 'Belum tersedia' }}
                </span>
            </a>
            @empty
            <p class="text-gray-400 col-span-4 text-center py-8">Belum ada fasilitas tersedia.</p>
            @endforelse
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
                    <div class="testi-stars">🔍 Lihat Detail Kos</div>
                    <div class="testi-text">
                        Cek kondisi kamar, fasilitas, harga, keamanan, dan informasi lingkungan kos langsung melalui
                        platform sebelum melakukan pengajuan.
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