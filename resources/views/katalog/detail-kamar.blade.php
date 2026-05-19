@extends('layouts.public')

@section('title', 'Kamar ' . ($kamar->nama_kamar ?? $kamar->nomor_kamar) . ' — ' . $kos->nama_kost . ' - KosinAja!')

@section('styles')
<style>
/* =====================
   BASE — identik dengan detail-kost
   ===================== */
.detail-wrap {
    background: #F8F7F4;
    min-height: 100vh;
    padding: 32px 64px 64px;
}

.breadcrumb {
    font-size: 0.82rem;
    color: #8a9e8c;
    margin-bottom: 24px;
}

.breadcrumb a {
    color: #8a9e8c;
    text-decoration: none;
    transition: color .2s;
}

.breadcrumb a:hover {
    color: #6C8B6B;
}

/* =====================
   LAYOUT 2 KOLOM — identik dengan detail-kost
   ===================== */
.detail-layout {
    display: grid;
    grid-template-columns: 1fr 340px;
    gap: 28px;
    align-items: start;
}

/* =====================
   GALERI — identik dengan detail-kost
   ===================== */
.galeri-grid {
    display: grid;
    grid-template-columns: 1fr 180px;
    gap: 10px;
    margin-bottom: 20px;
}

.galeri-main img {
    width: 100%;
    height: 320px;
    object-fit: cover;
    border-radius: 20px;
    cursor: pointer;
    transition: transform .3s ease;
}

.galeri-main img:hover {
    transform: scale(1.01);
}

.galeri-side {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.galeri-side img {
    width: 100%;
    height: 98px;
    object-fit: cover;
    border-radius: 14px;
    cursor: pointer;
    transition: transform .3s ease;
}

.galeri-side img:hover {
    transform: scale(1.02);
}

.galeri-more {
    position: relative;
    border-radius: 14px;
    overflow: hidden;
    cursor: pointer;
}

.galeri-more img {
    width: 100%;
    height: 98px;
    object-fit: cover;
    filter: brightness(0.45);
}

.galeri-more span {
    position: absolute;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 800;
    font-size: 1rem;
    font-family: 'Plus Jakarta Sans', sans-serif;
}

/* =====================
   SECTION BOX — identik dengan detail-kost
   ===================== */
.section-box {
    background: #fff;
    border: 1px solid #E8EFE9;
    border-radius: 20px;
    padding: 24px;
    margin-bottom: 20px;
    box-shadow: 0 2px 12px rgba(26, 47, 36, 0.05);
}

.section-title {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-weight: 800;
    font-size: 1.05rem;
    color: #1F3A2C;
    margin-bottom: 16px;
}

.section-sub {
    font-size: 0.82rem;
    color: #8a9e8c;
    margin-top: -10px;
    margin-bottom: 16px;
}

/* =====================
   INFO UTAMA — identik dengan detail-kost
   ===================== */
.kos-title {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-weight: 800;
    font-size: 1.8rem;
    color: #1F3A2C;
    margin-bottom: 8px;
    line-height: 1.2;
}

.kos-sub {
    font-size: 0.88rem;
    color: #8a9e8c;
    margin-bottom: 14px;
    margin-top: -4px;
}

.kos-meta {
    display: flex;
    align-items: center;
    gap: 16px;
    margin-bottom: 14px;
    flex-wrap: wrap;
}

.kos-meta-item {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 0.88rem;
    color: #7A8A7C;
}

.kos-meta-item svg {
    width: 15px;
    height: 15px;
    fill: #6C8B6B;
    flex-shrink: 0;
}

.kos-desc {
    font-size: 0.9rem;
    color: #4a5e4c;
    line-height: 1.85;
    margin-bottom: 14px;
}

/* Badge — sama persis dengan detail-kost */
.tersedia-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 0.82rem;
    font-weight: 700;
    color: #1F3A2C;
    background: #EAF3EB;
    border: 1px solid #D0E5D2;
    padding: 6px 14px;
    border-radius: 999px;
}

.tersedia-badge .dot-hijau {
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: #6C8B6B;
    display: inline-block;
    flex-shrink: 0;
}

.terisi-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 0.82rem;
    font-weight: 700;
    color: #991b1b;
    background: #fee2e2;
    border: 1px solid #fecaca;
    padding: 6px 14px;
    border-radius: 999px;
}

.terisi-badge .dot-merah {
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: #dc2626;
    display: inline-block;
    flex-shrink: 0;
}

/* =====================
   FASILITAS KAMAR — tile style (spesifik kamar)
   ===================== */
.fas-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.fas-tile {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
    padding: 12px 16px;
    background: #F0F5F1;
    border: 1px solid #E0EBE2;
    border-radius: 14px;
    min-width: 72px;
    cursor: default;
    transition: background .2s, transform .2s;
}

.fas-tile:hover {
    background: #E2EDE3;
    transform: translateY(-1px);
}

.fas-tile-icon {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    background: #6C8B6B;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.fas-tile-icon svg {
    width: 18px;
    height: 18px;
    fill: white;
}

.fas-tile-label {
    font-size: 0.72rem;
    color: #4a5e4c;
    font-weight: 600;
    text-align: center;
    line-height: 1.3;
}

/* =====================
   FASILITAS UMUM — chip (identik detail-kost)
   ===================== */
.fasilitas-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.fasilitas-chip {
    display: flex;
    align-items: center;
    gap: 7px;
    padding: 9px 14px;
    background: #F0F5F1;
    border-radius: 12px;
    font-size: 0.82rem;
    color: #2a4a2c;
    font-weight: 600;
    border: 1px solid #E0EBE2;
    transition: background .2s, transform .2s;
}

.fasilitas-chip:hover {
    background: #E2EDE3;
    transform: translateY(-1px);
}

.fasilitas-chip svg {
    width: 16px;
    height: 16px;
    fill: #6C8B6B;
    flex-shrink: 0;
}

/* =====================
   KAMAR LAIN — identik dengan detail-kost
   ===================== */
.kamar-item {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 16px 0;
    border-bottom: 1px solid #F0F5F1;
}

.kamar-item:last-child {
    border-bottom: none;
    padding-bottom: 0;
}

.kamar-item.active-kamar {
    background: #F5FAF5;
    border-radius: 14px;
    padding: 14px;
    border: 1px solid #6C8B6B;
    margin: 0 -14px;
}

.kamar-foto {
    width: 100px;
    height: 72px;
    object-fit: cover;
    border-radius: 12px;
    background: #e5e7eb;
    flex-shrink: 0;
}

.kamar-info {
    flex: 1;
}

.kamar-nama {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-weight: 700;
    font-size: 0.95rem;
    color: #1F3A2C;
    margin-bottom: 4px;
}

.kamar-fasilitas {
    display: flex;
    flex-wrap: wrap;
    gap: 4px;
    margin-top: 6px;
}

.kamar-tag {
    padding: 3px 10px;
    background: #F0F5F1;
    border-radius: 6px;
    font-size: 0.7rem;
    color: #4a5e4c;
    font-weight: 600;
    border: 1px solid #E0EBE2;
}

.kamar-harga {
    text-align: right;
    flex-shrink: 0;
}

.kamar-harga .harga {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-weight: 800;
    font-size: 1rem;
    color: #1F3A2C;
}

.kamar-harga .per {
    font-size: 0.75rem;
    color: #8a9e8c;
}

/* Badge kecil untuk daftar kamar — identik dengan detail-kost */
.badge-tersedia {
    display: inline-flex;
    align-items: center;
    padding: 4px 12px;
    border-radius: 999px;
    background: #dcfce7;
    color: #166534;
    font-size: 0.72rem;
    font-weight: 700;
    margin-top: 6px;
}

.badge-terisi {
    display: inline-flex;
    align-items: center;
    padding: 4px 12px;
    border-radius: 999px;
    background: #fee2e2;
    color: #991b1b;
    font-size: 0.72rem;
    font-weight: 700;
    margin-top: 6px;
}

.btn-detail-kamar {
    display: inline-block;
    background: #6C8B6B;
    color: white;
    padding: 7px 16px;
    border-radius: 10px;
    font-size: 0.8rem;
    font-weight: 700;
    text-decoration: none;
    margin-top: 8px;
    transition: background .2s, transform .2s;
}

.btn-detail-kamar:hover {
    background: #5a7a59;
    transform: translateY(-1px);
}

/* =====================
   SEMUA FOTO — identik dengan detail-kost
   ===================== */
.foto-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 10px;
}

.foto-grid img {
    width: 100%;
    height: 120px;
    object-fit: cover;
    border-radius: 12px;
    cursor: pointer;
    transition: transform .25s ease, opacity .2s;
}

.foto-grid img:hover {
    transform: scale(1.03);
    opacity: .9;
}

/* =====================
   KOLOM KANAN — identik dengan detail-kost
   ===================== */
.sticky-card {
    position: sticky;
    top: 104px;
    display: flex;
    flex-direction: column;
    gap: 16px;
}

/* HARGA CARD — identik dengan detail-kost */
.harga-card {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 32px;
    padding: 24px;
    box-shadow: 0 1px 4px rgba(0, 0, 0, .04);
}

.harga-label {
    font-size: 0.78rem;
    color: #8a9e8c;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: .5px;
    margin-bottom: 4px;
}

.harga-mulai {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-weight: 800;
    font-size: 1.8rem;
    color: #1F3A2C;
    line-height: 1.1;
}

.harga-mulai span {
    font-size: 0.9rem;
    font-weight: 500;
    color: #7A8A7C;
}

.harga-divider {
    height: 1px;
    background: #F0F5F1;
    margin: 16px 0;
}

.harga-info-row {
    display: flex;
    justify-content: space-between;
    font-size: 0.85rem;
    color: #4a5e4c;
    margin-bottom: 8px;
}

.harga-info-row strong {
    color: #1F3A2C;
    font-weight: 700;
}

/* PEMILIK CARD — identik dengan detail-kost */
.pemilik-card {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 32px;
    padding: 24px;
    box-shadow: 0 1px 4px rgba(0, 0, 0, .04);
}

.pemilik-card-title {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-weight: 700;
    font-size: 1rem;
    color: #0F0937;
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.pemilik-card-title svg {
    width: 18px;
    height: 18px;
    color: #6C8B6B;
    flex-shrink: 0;
}

.pemilik-avatar-row {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 20px;
}

.pemilik-avatar {
    width: 52px;
    height: 52px;
    border-radius: 50%;
    background: #D6E5D6;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.pemilik-nama {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-weight: 700;
    font-size: 0.95rem;
    color: #0F0937;
}

.pemilik-username {
    font-size: 0.78rem;
    color: #6C8B6B;
    font-weight: 600;
    margin-top: 2px;
}

.pemilik-sejak {
    font-size: 0.75rem;
    color: #9ca3af;
    margin-top: 2px;
}

.pemilik-info-row {
    border: 1px solid #e5e7eb;
    border-radius: 16px;
    padding: 12px 16px;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.pemilik-info-row svg {
    width: 16px;
    height: 16px;
    flex-shrink: 0;
    color: #6C8B6B;
}

.pemilik-info-label {
    font-size: 0.72rem;
    color: #9ca3af;
    font-weight: 500;
    display: block;
    margin-bottom: 1px;
}

.pemilik-info-value {
    font-size: 0.85rem;
    color: #374151;
    font-weight: 600;
}

.pemilik-divider {
    height: 1px;
    background: #f3f4f6;
    margin: 16px 0;
}

.pemilik-kontak-title {
    font-size: 0.82rem;
    font-weight: 700;
    color: #4F6B4F;
    margin-bottom: 10px;
}

/* Tombol kontak — identik dengan detail-kost */
.btn-pemilik {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    width: 100%;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.88rem;
    border-radius: 16px;
    padding: 14px;
    margin-bottom: 10px;
    transition: background .2s, transform .15s;
}

.btn-pemilik:last-child {
    margin-bottom: 0;
}

.btn-pemilik:hover {
    transform: translateY(-1px);
}

.btn-pemilik svg {
    width: 18px;
    height: 18px;
    flex-shrink: 0;
}

.btn-pemilik-wa {
    background: #6C8B6B;
    color: #fff;
}

.btn-pemilik-wa:hover {
    background: #5B765A;
}

.btn-pemilik-telp {
    background: #F8F5F0;
    color: #374151;
    border: 1px solid #e5e7eb;
}

.btn-pemilik-telp:hover {
    background: #f0ede8;
}

.btn-pemilik-email {
    background: #F8F5F0;
    color: #374151;
    border: 1px solid #e5e7eb;
}

.btn-pemilik-email:hover {
    background: #f0ede8;
}

.hubungi-note {
    font-size: 0.73rem;
    color: #9ca3af;
    text-align: center;
    margin-top: 12px;
}

/* =====================
   MODAL — identik dengan detail-kost
   ===================== */
.modal-foto {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, .88);
    z-index: 999;
    align-items: center;
    justify-content: center;
}

.modal-foto.active {
    display: flex;
}

.modal-foto img {
    max-width: 88vw;
    max-height: 88vh;
    border-radius: 16px;
    object-fit: contain;
}

.modal-close {
    position: absolute;
    top: 20px;
    right: 24px;
    color: white;
    cursor: pointer;
    background: rgba(255, 255, 255, .15);
    border: none;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    transition: background .2s;
    z-index: 1001;
}

.modal-close:hover {
    background: rgba(255, 255, 255, .28);
}

.modal-nav {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(255, 255, 255, .15);
    border: none;
    width: 44px;
    height: 44px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: background .2s;
    z-index: 1001;
}

.modal-nav:hover {
    background: rgba(255, 255, 255, .28);
}

.modal-nav svg {
    width: 22px;
    height: 22px;
    fill: white;
}

.modal-prev {
    left: 20px;
}

.modal-next {
    right: 20px;
}

.modal-counter {
    position: absolute;
    bottom: 20px;
    left: 50%;
    transform: translateX(-50%);
    background: rgba(0, 0, 0, .5);
    color: #fff;
    font-size: 0.8rem;
    font-weight: 700;
    padding: 5px 16px;
    border-radius: 999px;
    pointer-events: none;
    z-index: 1001;
}

/* =====================
   RESPONSIVE — identik dengan detail-kost
   ===================== */
@media(max-width: 1024px) {
    .detail-wrap {
        padding: 24px 32px 48px;
    }

    .detail-layout {
        grid-template-columns: 1fr;
    }

    .sticky-card {
        position: static;
    }
}

@media(max-width: 768px) {
    .detail-wrap {
        padding: 20px 20px 40px;
    }

    .galeri-grid {
        grid-template-columns: 1fr;
    }

    .galeri-side {
        display: none;
    }

    .kos-title {
        font-size: 1.4rem;
    }

    .foto-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}
</style>
@endsection

@section('content')

@php
/* ── foto kamar ── */
$fotoKamarList = $kamar->foto_kamar ?? [];
$fotoUtama = count($fotoKamarList) > 0 ? asset('storage/' . $fotoKamarList[0]) : null;
$galeriUrls = array_map(fn($f) => asset('storage/' . $f), $fotoKamarList);

/* ── data kamar ── */
$hargaKamar = $kamar->hargaKamars->where('isactive', true)->first();

/* ── data kos / pemilik ── */
$pemilik = $kos->user ?? null;
$noHpRaw = $pemilik?->no_hp ?? null;
$noWa = $noHpRaw ? '62' . ltrim(preg_replace('/[^0-9]/', '', $noHpRaw), '0') : null;
$pesanWa = urlencode('Halo, saya tertarik dengan ' . ($kamar->nama_kamar ?? 'Kamar ' . $kamar->nomor_kamar) . ' di ' .
$kos->nama_kost . '. Apakah masih tersedia?');

/* ── kamar lain ── */
$kamarsLain = $kos->kamars ?? collect();

/* ── fasilitas icons ── */
$fasIcons = [
'WiFi' => '
<path
    d="M1 9l2 2c4.97-4.97 13.03-4.97 18 0l2-2C16.93 2.93 7.08 2.93 1 9zm8 8l3 3 3-3c-1.66-1.65-4.34-1.65-6 0zm-4-4l2 2c2.76-2.76 7.24-2.76 10 0l2-2C15.14 9.14 8.87 9.14 5 13z" />
',
'AC' => '
<path
    d="M22 11h-4.17l3.24-3.24-1.41-1.42L15 11h-2V9l4.66-4.66-1.42-1.41L13 6.17V2h-2v4.17L7.76 2.93 6.34 4.34 11 9v2H9L4.34 6.34 2.93 7.76 6.17 11H2v2h4.17l-3.24 3.24 1.41 1.42L9 13h2v2l-4.66 4.66 1.42 1.41L11 17.83V22h2v-4.17l3.24 3.24 1.42-1.41L13 15v-2h2l4.66 4.66 1.41-1.42L17.83 13H22v-2z" />
',
'KM Dalam' => '
<path d="M7 2v2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2h-2V2h-2v2H9V2H7zm0 7h10v9H7V9z" />
',
'Dapur' => '
<path
    d="M18 2.01L6 2c-1.1 0-2 .89-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.11-.9-1.99-2-1.99zM18 20H6v-9.02h12V20zm0-11H6V4h12v5zM9 5H7v3h2V5zm8 0h-2v3h2V5z" />
',
'Laundry' => '
<path
    d="M9.17 16.83a4 4 0 1 0 5.66-5.66 4 4 0 0 0-5.66 5.66zM18 2.01L6 2C4.9 2 4 2.89 4 4v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.11-.9-1.99-2-1.99zM10 4h1v1h-1V4zm-2 0h1v1H8V4zm-2 0h1v1H6V4zm12 16H6V7h12v13z" />
',
'Parkir' => '
<path d="M13 3H6v18h4v-6h3c3.31 0 6-2.69 6-6s-2.69-6-6-6zm.2 8H10V7h3.2c1.1 0 2 .9 2 2s-.9 2-2 2z" />',
'CCTV' => '
<path d="M17 10.5V7c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1v10c0 .55.45 1 1 1h12c.55 0 1-.45 1-1v-3.5l4 4v-11l-4 4z" />',
'Akses 24 Jam' => '
<path
    d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67V7z" />
',
'Kasur' => '
<path
    d="M7 13c1.66 0 3-1.34 3-3S8.66 7 7 7s-3 1.34-3 3 1.34 3 3 3zm12-6h-8v7H3V5H1v15h2v-3h18v3h2v-9c0-2.21-1.79-4-4-4z" />
',
'Lemari' => '
<path d="M20 2H4c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-8 18H4V4h8v16zm8 0h-6V4h6v16z" />
',
'Meja Kursi' => '
<path d="M4 6h16v2H4zm0 5h16v2H4zm0 5h16v2H4z" />',
'Musholla' => '
<path d="M12 3L2 12h3v7h6v-4h2v4h6v-7h3L12 3z" />',
'default' => '
<path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z" />',
];
@endphp

<div class="detail-wrap">

    <div class="breadcrumb">
        <a href="{{ route('home') }}">Beranda</a> ›
        <a href="{{ route('detailKost', $kos->id) }}">{{ $kos->nama_kost }}</a> ›
        {{ $kamar->nama_kamar ?? 'Kamar ' . $kamar->nomor_kamar }}
    </div>

    <div class="detail-layout">

        {{-- ===== KOLOM KIRI ===== --}}
        <div>

            {{-- GALERI --}}
            <div class="section-box" style="padding: 16px;">
                <div class="galeri-grid">
                    <div class="galeri-main">
                        @if($fotoUtama)
                        <img src="{{ $fotoUtama }}" alt="{{ $kamar->nama_kamar ?? 'Kamar ' . $kamar->nomor_kamar }}"
                            onclick="bukaModal(0)">
                        @else
                        <div style="width:100%;height:320px;background:#D5E0D6;border-radius:20px;
                                        display:flex;align-items:center;justify-content:center;">
                            <svg style="width:56px;height:56px;fill:#A8C0AA;" viewBox="0 0 24 24">
                                <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z" />
                            </svg>
                        </div>
                        @endif
                    </div>

                    <div class="galeri-side">
                        @php $galeriSide = array_slice($fotoKamarList, 1, 2); @endphp
                        @forelse($galeriSide as $idx => $foto)
                        <img src="{{ asset('storage/' . $foto) }}" alt="Foto" onclick="bukaModal({{ $idx + 1 }})">
                        @empty
                        <div style="height:98px;background:#F0F5F1;border-radius:14px;"></div>
                        <div style="height:98px;background:#F0F5F1;border-radius:14px;"></div>
                        @endforelse

                        @if(count($fotoKamarList) > 3)
                        <div class="galeri-more" onclick="bukaModal(3)">
                            <img src="{{ asset('storage/' . $fotoKamarList[3]) }}" alt="Foto">
                            <span>+{{ count($fotoKamarList) - 3 }} Foto</span>
                        </div>
                        @else
                        <div style="height:98px;background:#F0F5F1;border-radius:14px;"></div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- INFO UTAMA KAMAR --}}
            <div class="section-box">
                <h1 class="kos-title">{{ $kamar->nama_kamar ?? 'Kamar ' . $kamar->nomor_kamar }}</h1>
                <p class="kos-sub">{{ $kos->nama_kost }}</p>

                <div class="kos-meta">
                    <div class="kos-meta-item">
                        <svg viewBox="0 0 24 24">
                            <path
                                d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5S10.62 6.5 12 6.5 14.5 7.62 14.5 9 13.38 11.5 12 11.5z" />
                        </svg>
                        {{ $kos->alamat }}
                    </div>
                    @if($kamar->ukuran_kamar)
                    <div class="kos-meta-item">
                        <svg viewBox="0 0 24 24">
                            <path
                                d="M20 2H4c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 18H4V4h16v16z" />
                        </svg>
                        {{ $kamar->ukuran_kamar }}
                    </div>
                    @endif
                    @if($kamar->kapasitas)
                    <div class="kos-meta-item">
                        <svg viewBox="0 0 24 24">
                            <path
                                d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                        </svg>
                        {{ $kamar->kapasitas }} Orang
                    </div>
                    @endif
                </div>

                @if($kamar->keterangan)
                <p class="kos-desc">{{ $kamar->keterangan }}</p>
                @endif

                {{-- Badge status — gaya tersedia-badge seperti detail-kost --}}
                @if($kamar->status == 'kosong')
                <span class="tersedia-badge">
                    <span class="dot-hijau"></span>
                    Tersedia
                </span>
                @else
                <span class="terisi-badge">
                    <span class="dot-merah"></span>
                    Tidak Tersedia
                </span>
                @endif
            </div>

            {{-- FASILITAS KAMAR --}}
            @if($kamar->fasilitas && $kamar->fasilitas->count() > 0)
            <div class="section-box">
                <div class="section-title">Fasilitas Kamar</div>
                <div class="fas-grid">
                    @foreach($kamar->fasilitas as $f)
                    @php $ico = $fasIcons[$f->nama_fasilitas] ?? $fasIcons['default']; @endphp
                    <div class="fas-tile">
                        <div class="fas-tile-icon">
                            <svg viewBox="0 0 24 24">{!! $ico !!}</svg>
                        </div>
                        <span class="fas-tile-label">{{ $f->nama_fasilitas }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif



            {{-- KAMAR LAIN DI KOS INI --}}
            @if($kamarsLain->count() > 1)
            <div class="section-box">
                <div class="section-title">Kamar Lain di {{ $kos->nama_kost }}</div>
                <p class="section-sub">Pilih kamar lain yang sesuai kebutuhanmu</p>

                @foreach($kamarsLain as $k)
                @php
                $fotoK = ($k->foto_kamar && count($k->foto_kamar) > 0) ? asset('storage/' . $k->foto_kamar[0]) : null;
                $hargaK = $k->hargaKamars->where('isactive', true)->first();
                $isAktif = $k->id_kamar == $kamar->id_kamar;
                @endphp
                <div class="kamar-item {{ $isAktif ? 'active-kamar' : '' }}">

                    @if($fotoK)
                    <img src="{{ $fotoK }}" alt="{{ $k->nama_kamar ?? 'Kamar ' . $k->nomor_kamar }}" class="kamar-foto">
                    @else
                    <div class="kamar-foto"
                        style="display:flex;align-items:center;justify-content:center;background:#F0F5F1;">
                        <svg style="width:28px;height:28px;fill:#c7d5c8;" viewBox="0 0 24 24">
                            <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z" />
                        </svg>
                    </div>
                    @endif

                    <div class="kamar-info">
                        <div class="kamar-nama">
                            {{ $k->nama_kamar ?? 'Kamar ' . $k->nomor_kamar }}
                            @if($isAktif)
                            <span style="font-size:0.72rem;color:#6C8B6B;font-weight:600;"> · Sedang dilihat</span>
                            @endif
                        </div>
                        @if($k->fasilitas && $k->fasilitas->count() > 0)
                        <div class="kamar-fasilitas">
                            @foreach($k->fasilitas->take(4) as $f)
                            <span class="kamar-tag">{{ $f->nama_fasilitas }}</span>
                            @endforeach
                            @if($k->fasilitas->count() > 4)
                            <span class="kamar-tag">+{{ $k->fasilitas->count() - 4 }}</span>
                            @endif
                        </div>
                        @endif
                        @if($k->ukuran_kamar)
                        <p style="font-size:0.78rem;color:#8a9e8c;margin-top:6px;">Ukuran: {{ $k->ukuran_kamar }}</p>
                        @endif
                    </div>

                    <div class="kamar-harga">
                        @if($hargaK)
                        <div class="harga">Rp {{ number_format($hargaK->harga, 0, ',', '.') }}</div>
                        <div class="per">/ bulan</div>
                        @else
                        <div class="harga" style="font-size:0.85rem;">Hubungi Kami</div>
                        @endif
                        <div>
                            @if($k->status == 'kosong')
                            <span class="badge-tersedia">Tersedia</span>
                            @else
                            <span class="badge-terisi">Terisi</span>
                            @endif
                        </div>
                        @if(!$isAktif)
                        <a href="{{ route('detailKamar', $k->id_kamar) }}" class="btn-detail-kamar">Lihat Detail</a>
                        @endif
                    </div>

                </div>
                @endforeach
            </div>
            @endif

            {{-- SEMUA FOTO --}}
            @if(count($galeriUrls) > 1)
            <div class="section-box">
                <div class="section-title">Semua Foto</div>
                <div class="foto-grid">
                    @foreach($galeriUrls as $i => $foto)
                    <img src="{{ $fotoUtama }}" alt="{{ $kost->nama_kost }}" onclick="bukaModal(0)">
                    @endforeach
                </div>
            </div>
            @endif

        </div>
        {{-- akhir kolom kiri --}}

        {{-- ===== KOLOM KANAN ===== --}}
        <div class="sticky-card">

            {{-- HARGA CARD --}}
            <div class="harga-card">
                <div class="harga-label">Harga sewa</div>
                <div class="harga-mulai">
                    @if($hargaKamar)
                    Rp {{ number_format($hargaKamar->harga, 0, ',', '.') }}
                    <span>/ bulan</span>
                    @else
                    <span style="font-size:1rem;">Hubungi Kami</span>
                    @endif
                </div>
                <div class="harga-divider"></div>

                <div class="harga-info-row">
                    <span>Nomor Kamar</span>
                    <strong>{{ $kamar->nomor_kamar }}</strong>
                </div>
                @if($kamar->ukuran_kamar)
                <div class="harga-info-row">
                    <span>Ukuran</span>
                    <strong>{{ $kamar->ukuran_kamar }}</strong>
                </div>
                @endif
                @if($kamar->kapasitas)
                <div class="harga-info-row">
                    <span>Kapasitas</span>
                    <strong>{{ $kamar->kapasitas }} Orang</strong>
                </div>
                @endif
                <div class="harga-info-row">
                    <span>Status</span>
                    <strong>
                        @if($kamar->status == 'kosong')
                        <span style="color:#16a34a;">Tersedia</span>
                        @else
                        <span style="color:#dc2626;">Penuh</span>
                        @endif
                    </strong>
                </div>
                <div class="harga-info-row">

                </div>
            </div>

            {{-- PEMILIK CARD — identik dengan detail-kost --}}
            @if($pemilik)
            <div class="pemilik-card">

                <p class="pemilik-card-title">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Pemilik Kost
                </p>

                <div class="pemilik-avatar-row">
                    <div class="pemilik-avatar">
                        <svg style="width:28px;height:28px;" fill="#6C8B6B" viewBox="0 0 24 24">
                            <path
                                d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z" />
                        </svg>
                    </div>
                    <div>
                        <div class="pemilik-nama">{{ $pemilik->nama ?? $pemilik->username }}</div>
                        @if($pemilik->username)
                        <div class="pemilik-username">{{ '@' . $pemilik->username }}</div>
                        @endif
                        <div class="pemilik-sejak">Bergabung sejak {{ $pemilik->created_at->format('Y') }}</div>
                    </div>
                </div>

                <div class="pemilik-divider"></div>
                <p class="pemilik-kontak-title">Hubungi Langsung</p>

                @if($noWa)
                <a href="https://wa.me/{{ $noWa }}?text={{ $pesanWa }}" target="_blank"
                    class="btn-pemilik btn-pemilik-wa">
                    <svg fill="white" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967..." />
                    </svg>
                    Chat WhatsApp
                </a>

                <a href="tel:{{ $noHpRaw }}" class="btn-pemilik btn-pemilik-telp">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="#6C8B6B"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28..." />
                    </svg>
                    {{ $noHpRaw }}
                </a>
                @else
                <p style="font-size:0.8rem;color:#9ca3af;text-align:center;">Nomor tidak tersedia</p>
                @endif

                @if(!empty($pemilik->email))
                <a href="mailto:{{ $pemilik->email }}" class="btn-pemilik btn-pemilik-email">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="#6C8B6B"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14..." />
                    </svg>
                    Kirim Email
                </a>
                @endif

                <p class="hubungi-note">⏱ Biasanya membalas dalam beberapa menit</p>

            </div>
            @endif

        </div>
        {{-- akhir kolom kanan --}}

    </div>

    {{-- MODAL FOTO --}}
    <div class="modal-foto" id="modalFoto">
        <button class="modal-close" onclick="tutupModal()">✕</button>

        @if(count($galeriUrls) > 1)
        <button class="modal-nav modal-prev" onclick="modalNav(-1)">
            <svg viewBox="0 0 24 24">
                <path d="M15.41 16.59L10.83 12l4.58-4.59L14 6l-6 6 6 6z" />
            </svg>
        </button>
        <button class="modal-nav modal-next" onclick="modalNav(1)">
            <svg viewBox="0 0 24 24">
                <path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6z" />
            </svg>
        </button>
        <div class="modal-counter" id="modalCounter">1 / {{ count($galeriUrls) }}</div>
        @endif

        <img id="modalImg" src="" alt="Foto" onclick="event.stopPropagation()">
    </div>

</div>

@endsection

@push('scripts')
<script>
const galeriUrls = JSON.parse('{!! addslashes(json_encode($galeriUrls)) !!}');
let modalIndex = 0;

function bukaModal(idx) {
    modalIndex = idx;
    updateModal();
    document.getElementById('modalFoto').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function tutupModal() {
    document.getElementById('modalFoto').classList.remove('active');
    document.body.style.overflow = '';
}

function modalNav(dir) {
    if (!galeriUrls.length) return;
    modalIndex = (modalIndex + dir + galeriUrls.length) % galeriUrls.length;
    updateModal();
}

function updateModal() {
    document.getElementById('modalImg').src = galeriUrls[modalIndex];
    const counter = document.getElementById('modalCounter');
    if (counter) counter.textContent = `${modalIndex + 1} / ${galeriUrls.length}`;
}

document.getElementById('modalFoto').addEventListener('click', function(e) {
    if (e.target === this) tutupModal();
});

document.addEventListener('keydown', e => {
    if (!document.getElementById('modalFoto').classList.contains('active')) return;
    if (e.key === 'Escape') tutupModal();
    if (e.key === 'ArrowRight') modalNav(1);
    if (e.key === 'ArrowLeft') modalNav(-1);
});
</script>
@endpush