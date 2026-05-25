@extends('layouts.public')

@section('title', $kost->nama_kost . ' - KosinAja!')

@section('styles')
<style>
/* BASE */
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

/* LAYOUT 2 KOLOM */
.detail-layout {
    display: grid;
    grid-template-columns: 1fr 340px;
    gap: 28px;
    align-items: start;
}

/* ====== GALERI ====== */
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

/* SECTION BOX */
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

/* INFO UTAMA */
.kos-title {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-weight: 800;
    font-size: 1.8rem;
    color: #1F3A2C;
    margin-bottom: 8px;
    line-height: 1.2;
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

.tersedia-badge .jumlah {
    color: #6C8B6B;
}

/* FASILITAS */
.fasilitas-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.fasilitas-chip {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 16px;
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

/* DAFTAR KAMAR */
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

.kamar-foto {
    width: 100px;
    height: 72px;
    object-fit: cover;
    border-radius: 12px;
    background: #e5e7eb;
    flex-shrink: 0;
    cursor: pointer;
    transition: transform .2s, opacity .2s;
}

.kamar-foto:hover {
    transform: scale(1.04);
    opacity: 0.88;
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

/* LOKASI */
.lokasi-alamat {
    display: flex;
    align-items: flex-start;
    gap: 8px;
    font-size: 0.88rem;
    color: #4a5e4c;
    margin-bottom: 14px;
}

.lokasi-alamat svg {
    width: 15px;
    height: 15px;
    fill: #6C8B6B;
    flex-shrink: 0;
    margin-top: 2px;
}

.lokasi-map-wrap {
    border-radius: 14px;
    overflow: hidden;
    border: 1px solid #E8EFE9;
}

/* ====== KOLOM KANAN ====== */
.sticky-card {
    position: sticky;
    top: 104px;
    display: flex;
    flex-direction: column;
    gap: 16px;
}

/* HARGA CARD */
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

/* BOOKING CARD */
.booking-card {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 32px;
    padding: 24px;
    box-shadow: 0 1px 4px rgba(0, 0, 0, .04);
}

.booking-title {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 1rem;
    font-weight: 800;
    color: #1F3A2C;
    margin-bottom: 18px;
}

.booking-group {
    margin-bottom: 16px;
}

.booking-label {
    display: block;
    font-size: 0.82rem;
    font-weight: 700;
    color: #374151;
    margin-bottom: 8px;
}

.booking-input,
.booking-select {
    width: 100%;
    border: 1px solid #d1d5db;
    border-radius: 14px;
    padding: 13px 14px;
    font-size: 0.88rem;
    background: #fff;
    color: #1F2937;
    transition: .2s;
}

.booking-input:focus,
.booking-select:focus {
    outline: none;
    border-color: #6C8B6B;
    box-shadow: 0 0 0 4px rgba(108, 139, 107, .12);
}

.booking-button {
    width: 100%;
    border: none;
    border-radius: 16px;
    background: #6C8B6B;
    color: white;
    font-weight: 700;
    font-size: 0.9rem;
    padding: 14px;
    cursor: pointer;
    transition: .2s;
}

.booking-button:hover {
    background: #5A7A59;
    transform: translateY(-1px);
}

.booking-alert {
    background: #FEF2F2;
    color: #B91C1C;
    border: 1px solid #FECACA;
    padding: 12px 14px;
    border-radius: 14px;
    font-size: 0.82rem;
    margin-bottom: 16px;
}

.booking-success {
    background: #ECFDF5;
    color: #166534;
    border: 1px solid #BBF7D0;
    padding: 12px 14px;
    border-radius: 14px;
    font-size: 0.82rem;
    margin-bottom: 16px;
}

/* PEMILIK CARD */
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

/* ====== MODAL FOTO ====== */
.modal-foto {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, .92);
    z-index: 9999;
    align-items: center;
    justify-content: center;
    padding: 20px;
    box-sizing: border-box;
}

.modal-foto.active {
    display: flex;
}

.modal-foto-inner {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    height: 100%;
}

#modalImg {
    max-width: min(88vw, 1000px);
    max-height: 85vh;
    border-radius: 16px;
    object-fit: contain;
    display: block;
    transition: transform .25s ease, opacity .25s ease;
    user-select: none;
    -webkit-user-drag: none;
}

.modal-close {
    position: fixed;
    top: 20px;
    right: 24px;
    color: white;
    cursor: pointer;
    background: rgba(255, 255, 255, .18);
    border: none;
    width: 42px;
    height: 42px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    transition: background .2s;
    z-index: 10001;
    line-height: 1;
}

.modal-close:hover {
    background: rgba(255, 255, 255, .32);
}

.modal-nav {
    position: fixed;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(255, 255, 255, .18);
    border: none;
    width: 48px;
    height: 48px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: background .2s, transform .2s;
    z-index: 10001;
}

.modal-nav:hover {
    background: rgba(255, 255, 255, .32);
    transform: translateY(-50%) scale(1.08);
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
    position: fixed;
    bottom: 24px;
    left: 50%;
    transform: translateX(-50%);
    background: rgba(0, 0, 0, .55);
    color: #fff;
    font-size: 0.82rem;
    font-weight: 700;
    padding: 6px 18px;
    border-radius: 999px;
    pointer-events: none;
    z-index: 10001;
    white-space: nowrap;
}

/* Thumbnail strip di bawah modal */
.modal-thumbs {
    position: fixed;
    bottom: 64px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    gap: 8px;
    z-index: 10001;
    max-width: 90vw;
    overflow-x: auto;
    padding: 4px 8px;
}

.modal-thumb {
    width: 52px;
    height: 38px;
    object-fit: cover;
    border-radius: 8px;
    cursor: pointer;
    opacity: 0.5;
    border: 2px solid transparent;
    transition: opacity .2s, border-color .2s, transform .2s;
    flex-shrink: 0;
}

.modal-thumb.active-thumb {
    opacity: 1;
    border-color: #fff;
    transform: scale(1.08);
}

.modal-thumb:hover {
    opacity: 0.85;
}

/* RESPONSIVE */
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

    .modal-prev {
        left: 8px;
    }

    .modal-next {
        right: 8px;
    }

    .modal-thumbs {
        display: none;
    }
}
</style>
@endsection

@section('content')

@php
$galeri = $kost->foto_kost ?? [];

$fotoUtama = count($galeri) > 0 ? Storage::url($galeri[0]) : null;
$galeriUrls = array_map(fn($f) => Storage::url($f), $galeri);

$kamarKosong = $kost->kamars->where('status', 'kosong')->count();
$hargaAktif = $kost->kamars->flatMap(fn($k) => $k->hargaKamars ->where('isactive', true) ->filter(function ($harga) {
            return $harga->periode && $harga->periode->satuan_interval === 'bulan';
        })
);
$hargaMulai = $hargaAktif->min('harga');

$pemilik = $kost->user;
$noHpRaw = $pemilik?->no_hp ?? null;
$noWa = $noHpRaw ? '62' . ltrim(preg_replace('/[^0-9]/', '', $noHpRaw), '0') : null;
$pesanWa = urlencode('Halo, saya tertarik dengan kost ' . $kost->nama_kost . '. Apakah masih ada kamar yang tersedia?');
@endphp

<div class="detail-wrap">

    <div class="breadcrumb">
        <a href="{{ route('home') }}">Beranda</a> › Detail Kost
    </div>

    <div class="detail-layout">

        {{-- ===== KOLOM KIRI ===== --}}
        <div>

            {{-- GALERI --}}
            <div class="section-box" style="padding:16px;">
                <div class="galeri-grid">

                    {{-- Foto utama --}}
                    <div class="galeri-main">
                        @if($fotoUtama)
                        <img src="{{ $fotoUtama }}" alt="{{ $kost->nama_kost }}" onclick="bukaFoto(0)"
                            title="Klik untuk melihat foto">
                        @else
                        <div style="width:100%;height:320px;background:#D5E0D6;border-radius:20px;
                                    display:flex;align-items:center;justify-content:center;">
                            <svg style="width:56px;height:56px;fill:#A8C0AA;" viewBox="0 0 24 24">
                                <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z" />
                            </svg>
                        </div>
                        @endif
                    </div>

                    {{-- Foto samping --}}
                    <div class="galeri-side">
                        @php $galeriSide = array_slice($galeri, 1, 2); @endphp
                        @forelse($galeriSide as $idx => $foto)
                        <img src="{{ Storage::url($foto) }}" alt="Foto {{ $idx + 2 }}"
                            onclick="bukaFoto({{ $idx + 1 }})" title="Klik untuk melihat foto">
                        @empty
                        @endforelse

                        @if(count($galeri) > 3)
                        <div class="galeri-more" onclick="bukaFoto(3)">
                            <img src="{{ Storage::url($galeri[3]) }}" alt="Foto lebih">
                            <span>+{{ count($galeri) - 3 }} Foto</span>
                        </div>
                        @endif
                    </div>

                </div>
            </div>

            {{-- INFO UTAMA --}}
            <div class="section-box">
                <h1 class="kos-title">{{ $kost->nama_kost }}</h1>
                <div class="kos-meta">
                    <div class="kos-meta-item">
                        <svg viewBox="0 0 24 24">
                            <path
                                d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5S10.62 6.5 12 6.5 14.5 7.62 14.5 9 13.38 11.5 12 11.5z" />
                        </svg>
                        {{ $kost->alamat }}
                    </div>
                </div>

                @if($kost->deskripsi)
                <p class="kos-desc">{{ $kost->deskripsi }}</p>
                @endif

                <div class="tersedia-badge">
                    <svg xmlns="http://www.w3.org/2000/svg" style="width:14px;height:14px;fill:#6C8B6B;"
                        viewBox="0 0 24 24">
                        <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z" />
                    </svg>
                    <span class="jumlah">{{ $kamarKosong }} Kamar</span> tersedia
                </div>
            </div>

            {{-- DAFTAR KAMAR --}}
            <div class="section-box">
                <div class="section-title">Daftar Kamar</div>
                <p class="section-sub">Pilih kamar yang sesuai dengan kebutuhan Anda</p>

                @forelse($kost->kamars as $kamar)
                @php
                $fotoKamarArr = $kamar->foto_kamar ?? [];
                $fotoKamar = (is_array($fotoKamarArr) && count($fotoKamarArr) > 0)
                ? asset('storage/' . $fotoKamarArr[0])
                : null;
                $fotoKamarUrls = is_array($fotoKamarArr)
                ? array_map(fn($f) => asset('storage/' . $f), $fotoKamarArr)
                : [];
                $hargaKamar = $kamar->hargaKamars->where('isactive', true)->first();
                @endphp

                <div class="kamar-item">

                    {{-- Foto kamar --}}
                    @if($fotoKamar)
                    <img src="{{ $fotoKamar }}" alt="{{ $kamar->nama_kamar }}" class="kamar-foto"
                        onclick="bukaFotoKamar({{ json_encode($fotoKamarUrls) }}, 0)"
                        title="Klik untuk melihat foto kamar">
                    @else
                    <div class="kamar-foto"
                        style="display:flex;align-items:center;justify-content:center;background:#F0F5F1;">
                        <svg xmlns="http://www.w3.org/2000/svg" style="width:28px;height:28px;fill:#c7d5c8;"
                            viewBox="0 0 24 24">
                            <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z" />
                        </svg>
                    </div>
                    @endif

                    <div class="kamar-info">
                        <div class="kamar-nama">
                            {{ $kamar->nama_kamar }}
                            @if($kamar->nomor_kamar) - No. {{ $kamar->nomor_kamar }} @endif
                        </div>
                        @if($kamar->fasilitas && $kamar->fasilitas->count() > 0)
                        <div class="kamar-fasilitas">
                            @foreach($kamar->fasilitas->take(5) as $f)
                            <span class="kamar-tag">{{ $f->nama_fasilitas }}</span>
                            @endforeach
                            @if($kamar->fasilitas->count() > 5)
                            <span class="kamar-tag">+{{ $kamar->fasilitas->count() - 5 }}</span>
                            @endif
                        </div>
                        @endif
                        @if($kamar->ukuran_kamar)
                        <p style="font-size:0.78rem;color:#8a9e8c;margin-top:6px;">
                            Ukuran: {{ $kamar->ukuran_kamar }}
                        </p>
                        @endif
                    </div>

                    <div class="kamar-harga">
                        @if($hargaKamar)
                        <div class="harga">Rp {{ number_format($hargaKamar->harga, 0, ',', '.') }}</div>
                        <div class="per">/ bulan</div>
                        @else
                        <div class="harga" style="font-size:0.85rem;">Hubungi Kami</div>
                        @endif
                        <div>
                            @if($kamar->status == 'kosong')
                            <span class="badge-tersedia">Tersedia</span>
                            @else
                            <span class="badge-terisi">Terisi</span>
                            @endif
                        </div>
                        <a href="{{ route('detailKamar', $kamar->id_kamar) }}" class="btn-detail-kamar">
                            Lihat Detail
                        </a>
                    </div>

                </div>
                @empty
                <p style="text-align:center;color:#8a9e8c;padding:20px 0;font-size:0.88rem;">
                    Belum ada kamar yang tersedia
                </p>
                @endforelse
            </div>

            {{-- FASILITAS KOST --}}
            @if($kost->fasilitas && $kost->fasilitas->count() > 0)
            <div class="section-box">
                <div class="section-title">Fasilitas Kost</div>
                <p class="section-sub">Fasilitas yang tersedia di kost ini</p>

                <div class="fasilitas-grid">
                    @foreach($kost->fasilitas as $fasilitas)
                    <div class="fasilitas-chip">
                        {{ $fasilitas->nama_fasilitas }}
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- LOKASI --}}
            @if($kost->lokasi)
            <div class="section-box">
                <div class="section-title">Lokasi Kost</div>
                <div class="lokasi-alamat">
                    <svg viewBox="0 0 24 24">
                        <path
                            d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5S10.62 6.5 12 6.5 14.5 7.62 14.5 9 13.38 11.5 12 11.5z" />
                    </svg>
                    {{ $kost->alamat }}
                </div>
                <div class="lokasi-map-wrap">
                    <iframe src="{{ $kost->lokasi }}" width="100%" height="300" style="border:0;display:block;"
                        allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
            @endif

            {{-- ATURAN KOST --}}
            @if($kost->aturanKos && $kost->aturanKos->count() > 0)
            <div class="section-box">
                <div class="section-title">Aturan Kost</div>
                <p class="section-sub">Harap diperhatikan sebelum menyewa</p>

                <div style="display:flex;flex-direction:column;gap:10px;">
                    @foreach($kost->aturanKos->take(5) as $index => $aturan)
                    @if($kost->aturanKos->count() > 5)
<button
    onclick="bukaModalAturan()"
    class="mt-4 text-sm font-semibold text-[#6C8B6B]  hover:underline"
>
    Lihat Selengkapnya
</button>

@endif
                    <div style="display:flex;gap:14px;align-items:flex-start;
                                padding:14px 16px;
                                background:#F8FAF8;
                                border:1px solid #E8EFE9;
                                border-radius:12px;">
                        <div style="width:26px;height:26px;
                                    background:#EAF3EB;
                                    border-radius:8px;
                                    display:flex;align-items:center;justify-content:center;
                                    font-size:0.75rem;font-weight:800;
                                    color:#4B8A4B;flex-shrink:0;">
                            {{ $index + 1 }}
                        </div>
                        <p style="font-size:0.88rem;color:#4a5e4c;line-height:1.7;margin:0;padding-top:2px;">
                            {{ $aturan->isi }}
                        </p>
                    </div>
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
                <div class="harga-label">Harga mulai dari</div>
                <div class="harga-mulai">
                    @if($hargaMulai)
                    Rp {{ number_format($hargaMulai, 0, ',', '.') }}
                    <span>/ bulan</span>
                    @else
                    <span style="font-size:1rem;">Hubungi Kami</span>
                    @endif
                </div>
                <div class="harga-divider"></div>
                <div class="harga-info-row">
                    <span>Kamar Tersedia</span>
                    <strong>{{ $kamarKosong }} Kamar</strong>
                </div>
                <div class="harga-info-row">
                    <span>Lokasi</span>
                    <strong>{{ Str::limit($kost->alamat, 30) }}</strong>
                </div>
            </div>

            {{-- PEMILIK CARD --}}
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
                        <path
                            d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                    </svg>
                    Chat WhatsApp
                </a>

                <a href="tel:{{ $noHpRaw }}" class="btn-pemilik btn-pemilik-telp">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="#6C8B6B">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                    {{ $noHpRaw }}
                </a>
                @else
                <p style="font-size:0.8rem;color:#9ca3af;text-align:center;">Nomor tidak tersedia</p>
                @endif

                @if(!empty($pemilik->email))
                <a href="mailto:{{ $pemilik->email }}" class="btn-pemilik btn-pemilik-email">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="#6C8B6B">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
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

    {{-- ====== MODAL FOTO ====== --}}
    <div class="modal-foto" id="modalFoto" role="dialog" aria-modal="true" aria-label="Galeri foto">

        {{-- Tombol tutup --}}
        <button class="modal-close" onclick="tutupFoto()" aria-label="Tutup galeri">✕</button>

        {{-- Navigasi prev/next --}}
        <button class="modal-nav modal-prev" id="modalPrev" onclick="fotoNav(-1)" aria-label="Foto sebelumnya">
            <svg viewBox="0 0 24 24">
                <path d="M15.41 16.59L10.83 12l4.58-4.59L14 6l-6 6 6 6z" />
            </svg>
        </button>
        <button class="modal-nav modal-next" id="modalNext" onclick="fotoNav(1)" aria-label="Foto berikutnya">
            <svg viewBox="0 0 24 24">
                <path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6z" />
            </svg>
        </button>

        {{-- Gambar utama --}}
        <img id="modalImg" src="" alt="Preview foto" onclick="event.stopPropagation()">

        {{-- Counter --}}
        <div class="modal-counter" id="modalCounter">1 / 1</div>

        {{-- Thumbnail strip --}}
        <div class="modal-thumbs" id="modalThumbs"></div>

    </div>

</div>

{{-- MODAL ATURAN --}}
<div
    id="modalAturan"
    class="modal-foto"
    onclick="tutupModalAturan()"
>

    <div
        onclick="event.stopPropagation()"
        style="
            background:white;
            width:min(92vw,600px);
            max-height:85vh;
            overflow-y:auto;
            border-radius:28px;
            padding:28px;
            position:relative;
        "
    >

        <button
            onclick="tutupModalAturan()"
            style="
                position:absolute;
                top:18px;
                right:18px;
                width:38px;
                height:38px;
                border:none;
                border-radius:50%;
                background:#F3F4F6;
                cursor:pointer;
                font-size:1rem;
            "
        >

            ✕

        </button>

        <h2
            style="
                font-size:1.3rem;
                font-weight:800;
                color:#1F3A2C;
                margin-bottom:24px;
            "
        >

            Aturan Kost

        </h2>

        <div
            style="
                display:flex;
                flex-direction:column;
                gap:14px;
            "
        >

            @foreach($kost->aturanKos as $index => $aturan)

            <div
                style="
                    display:flex;
                    gap:14px;
                    align-items:flex-start;
                    padding:16px;
                    background:#F8FAF8;
                    border-radius:16px;
                    border:1px solid #E8EFE9;
                "
            >

                <div
                    style="
                        width:28px;
                        height:28px;
                        border-radius:10px;
                        background:#EAF3EB;
                        display:flex;
                        align-items:center;
                        justify-content:center;
                        font-weight:800;
                        font-size:.78rem;
                        color:#4B8A4B;
                        flex-shrink:0;
                    "
                >

                    {{ $index + 1 }}

                </div>

                <p
                    style="
                        margin:0;
                        font-size:.9rem;
                        line-height:1.8;
                        color:#4a5e4c;
                    "
                >

                    {{ $aturan->isi }}

                </p>

            </div>

            @endforeach

        </div>

    </div>

</div>
@endsection

{{-- ===== DATA HARGA KAMAR ===== --}}
@php
$hargaKamarJson = [];
foreach ($kost->kamars as $kamar) {
$hargaKamarJson[$kamar->id_kamar] = [];
foreach ($kamar->hargaKamars as $harga) {
$hargaKamarJson[$kamar->id_kamar][] = [
'id' => $harga->id_harga_kamar,
'periode' => $harga->periode->nama_periode ?? '-',
'harga' => $harga->harga,
];
}
}
@endphp

@push('scripts')

{{-- ===== 1. DATA GALERI KOST (PHP → JS) ===== --}}
<script>
const galeriUrls = @json($galeriUrls);
</script>

{{-- ===== 2. KAMAR & PERIODE SELECT ===== --}}
<script>
const hargaKamar = @json($hargaKamarJson);

const kamarSelect = document.getElementById('kamarSelect');
const hargaSelect = document.getElementById('hargaSelect');

if (kamarSelect && hargaSelect) {
    kamarSelect.addEventListener('change', function() {
        const kamarId = this.value;
        hargaSelect.innerHTML = '<option value="">-- Pilih Periode --</option>';
        if (hargaKamar[kamarId]) {
            hargaKamar[kamarId].forEach(function(harga) {
                hargaSelect.innerHTML += `
                        <option value="${harga.id}">
                            ${harga.periode} - Rp ${Number(harga.harga).toLocaleString('id-ID')}
                        </option>`;
            });
        }
    });
}
</script>

{{-- ===== 3. MODAL FOTO — KOST & KAMAR ===== --}}
<script>
/* ---- State ---- */
let modalUrls = []; // URL array yang sedang aktif di modal
let modalIndex = 0; // Indeks foto yang sedang tampil
let isAnimating = false;

/* ------------------------------------------------------------------ */
/* BUKA MODAL — galeri kost                                             */
/* ------------------------------------------------------------------ */
function bukaFoto(idx) {
    if (!galeriUrls || galeriUrls.length === 0) return;
    bukaModalDenganUrls(galeriUrls, idx);
}

/* ------------------------------------------------------------------ */
/* BUKA MODAL — foto kamar (dipanggil dengan array URLs & indeks)       */
/* ------------------------------------------------------------------ */
function bukaFotoKamar(urls, idx) {
    if (!urls || urls.length === 0) return;
    bukaModalDenganUrls(urls, idx);
}

/* ------------------------------------------------------------------ */
/* INTI: tampilkan modal dengan array urls & indeks awal               */
/* ------------------------------------------------------------------ */
function bukaModalDenganUrls(urls, idx) {
    modalUrls = urls;
    modalIndex = Math.max(0, Math.min(idx, urls.length - 1));

    const modal = document.getElementById('modalFoto');
    const img = document.getElementById('modalImg');

    /* Sembunyikan nav jika hanya 1 foto */
    const showNav = urls.length > 1;
    document.getElementById('modalPrev').style.display = showNav ? 'flex' : 'none';
    document.getElementById('modalNext').style.display = showNav ? 'flex' : 'none';

    /* Bangun thumbnail strip */
    renderThumbs();

    /* Tampilkan gambar pertama */
    img.style.transition = 'none';
    img.style.opacity = '0';
    img.style.transform = 'translateX(0) scale(1)';
    img.src = modalUrls[modalIndex];

    modal.classList.add('active');
    document.body.style.overflow = 'hidden';

    const onLoad = () => {
        img.style.transition = 'opacity .25s ease, transform .25s ease';
        img.style.opacity = '1';
    };
    img.onload = onLoad;
    if (img.complete && img.naturalWidth) onLoad();

    updateCounter();
}

/* ------------------------------------------------------------------ */
/* TUTUP MODAL                                                          */
/* ------------------------------------------------------------------ */
function tutupFoto() {
    const modal = document.getElementById('modalFoto');
    const img = document.getElementById('modalImg');

    img.style.transition = 'opacity .2s ease';
    img.style.opacity = '0';

    setTimeout(() => {
        modal.classList.remove('active');
        document.body.style.overflow = '';
        img.src = '';
    }, 200);
}

/* ------------------------------------------------------------------ */
/* NAVIGASI (dir: -1 = prev, +1 = next)                                */
/* ------------------------------------------------------------------ */
function fotoNav(dir) {
    if (!modalUrls.length || isAnimating) return;
    isAnimating = true;

    const img = document.getElementById('modalImg');

    img.style.transition = 'transform .2s ease, opacity .2s ease';
    img.style.transform = 'translateX(' + (dir > 0 ? '-60px' : '60px') + ')';
    img.style.opacity = '0';

    setTimeout(() => {
        modalIndex = (modalIndex + dir + modalUrls.length) % modalUrls.length;

        img.style.transition = 'none';
        img.style.transform = 'translateX(' + (dir > 0 ? '60px' : '-60px') + ')';
        img.src = modalUrls[modalIndex];

        requestAnimationFrame(() => {
            requestAnimationFrame(() => {
                img.style.transition = 'transform .25s ease, opacity .25s ease';
                img.style.transform = 'translateX(0)';
                img.style.opacity = '1';
                isAnimating = false;
            });
        });

        updateCounter();
        updateActiveThumbs();
    }, 200);
}

/* ------------------------------------------------------------------ */
/* COUNTER & THUMBS                                                     */
/* ------------------------------------------------------------------ */
function updateCounter() {
    const counter = document.getElementById('modalCounter');
    if (counter) {
        counter.textContent = (modalIndex + 1) + ' / ' + modalUrls.length;
        counter.style.display = modalUrls.length > 1 ? 'block' : 'none';
    }
}

function renderThumbs() {
    const strip = document.getElementById('modalThumbs');
    if (!strip) return;
    strip.innerHTML = '';

    if (modalUrls.length <= 1) return; /* sembunyikan jika 1 foto */

    modalUrls.forEach((url, i) => {
        const thumb = document.createElement('img');
        thumb.src = url;
        thumb.alt = 'Foto ' + (i + 1);
        thumb.className = 'modal-thumb' + (i === modalIndex ? ' active-thumb' : '');
        thumb.addEventListener('click', (e) => {
            e.stopPropagation();
            if (i !== modalIndex) {
                const dir = i > modalIndex ? 1 : -1;
                modalIndex = i - dir; /* fotoNav akan increment */
                fotoNav(dir);
            }
        });
        strip.appendChild(thumb);
    });
}

function updateActiveThumbs() {
    const thumbs = document.querySelectorAll('.modal-thumb');
    thumbs.forEach((t, i) => {
        t.classList.toggle('active-thumb', i === modalIndex);
    });

    /* Scroll thumbnail yang aktif ke tengah strip */
    const activeThumb = thumbs[modalIndex];
    if (activeThumb) {
        activeThumb.scrollIntoView({
            behavior: 'smooth',
            block: 'nearest',
            inline: 'center'
        });
    }
}

/* ------------------------------------------------------------------ */
/* EVENT LISTENERS                                                      */
/* ------------------------------------------------------------------ */

/* Klik backdrop tutup modal */
document.getElementById('modalFoto').addEventListener('click', function(e) {
    if (e.target === this) tutupFoto();
});

/* Keyboard: Escape, ArrowLeft, ArrowRight */
document.addEventListener('keydown', function(e) {
    if (!document.getElementById('modalFoto').classList.contains('active')) return;
    if (e.key === 'Escape') tutupFoto();
    if (e.key === 'ArrowRight') fotoNav(1);
    if (e.key === 'ArrowLeft') fotoNav(-1);
});

/* Touch/swipe support */
let touchStartX = 0;
let touchStartY = 0;
const modalEl = document.getElementById('modalFoto');

modalEl.addEventListener('touchstart', function(e) {
    touchStartX = e.touches[0].clientX;
    touchStartY = e.touches[0].clientY;
}, {
    passive: true
});

modalEl.addEventListener('touchend', function(e) {
    const diffX = touchStartX - e.changedTouches[0].clientX;
    const diffY = Math.abs(touchStartY - e.changedTouches[0].clientY);
    /* Hanya swipe horizontal yang lebih dominan dari vertikal */
    if (Math.abs(diffX) > 50 && Math.abs(diffX) > diffY) {
        fotoNav(diffX > 0 ? 1 : -1);
    }
}, {
    passive: true
});

function bukaModalAturan()
{
    document
        .getElementById('modalAturan')
        .classList
        .add('active');

    document.body.style.overflow = 'hidden';
}

function tutupModalAturan()
{
    document
        .getElementById('modalAturan')
        .classList
        .remove('active');

    document.body.style.overflow = '';
}
</script>

@endpush