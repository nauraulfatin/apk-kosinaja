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

/* ====== GALERI (layout asli) ====== */
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

/* SEMUA FOTO */
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

/* PEMILIK CARD — style sesuai register page */
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

/* Info row dalam pemilik card — mirip field register */
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

/* Tombol kontak */
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
   FORM AJUKAN SEWA
   ===================== */

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

/* MODAL */
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

    .foto-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}
</style>
@endsection

@section('content')

@php
$galeri = $kost->foto_kost ?? [];
$fotoUtama = count($galeri) > 0 ? ('storage/' . $galeri[0]) : null;
$kamarKosong = $kost->kamars->where('status', 'kosong')->count();
$hargaAktif = $kost->kamars->flatMap(fn($k) => $k->hargaKamars->where('isactive', true));
$hargaMulai = $hargaAktif->min('harga');

$pemilik = $kost->user;
$noHpRaw = $pemilik?->no_hp ?? null;
$noWa = $noHpRaw ? '62' . ltrim(preg_replace('/[^0-9]/', '', $noHpRaw), '0') : null;
$pesanWa = urlencode('Halo, saya tertarik dengan kost ' . $kost->nama_kost . '. Apakah masih ada kamar yang tersedia?');
$galeriUrls = array_map(fn($f) => asset('storage/' . $f), $galeri); // asset() ok di Blade @php
@endphp

<div class="detail-wrap">

    <div class="breadcrumb">
        <a href="{{ route('home') }}">Beranda</a> › Detail Kost
    </div>

    <div class="detail-layout">

        {{-- ===== KOLOM KIRI ===== --}}
        <div>

            {{-- GALERI --}}
            <div class="section-box" style="padding: 16px;">
                <div class="galeri-grid">
                    <div class="galeri-main">
                        @if($fotoUtama)
                        <img src="{{ asset($fotoUtama) }}" alt="{{ $kost->nama_kost }}" onclick="bukaModal(0)">
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
                        @php $galeriSide = array_slice($galeri, 1, 2); @endphp
                        @forelse($galeriSide as $idx => $foto)
                        <img src="{{ asset('storage/' . $foto) }}" alt="Foto" onclick="bukaModal({{ $idx + 1 }})">
                        @empty
                        <div style="height:98px;background:#F0F5F1;border-radius:14px;"></div>
                        <div style="height:98px;background:#F0F5F1;border-radius:14px;"></div>
                        @endforelse

                        @if(count($galeri) > 3)
                        <div class="galeri-more" onclick="bukaModal(3)">
                            <img src="{{ asset('storage/' . $galeri[3]) }}" alt="Foto">
                            <span>+{{ count($galeri) - 3 }} Foto</span>
                        </div>
                        @else
                        <div style="height:98px;background:#F0F5F1;border-radius:14px;"></div>
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
                $fotoKamar = ($kamar->foto_kamar && count($kamar->foto_kamar) > 0)
                ? ('storage/' . $kamar->foto_kamar[0]) : null;
                $hargaKamar = $kamar->hargaKamars->where('isactive', true)->first();
                @endphp
                <div class="kamar-item">

                    @if($fotoKamar)
                    <img src="{{ asset($fotoKamar) }}" alt="{{ $kamar->nama_kamar }}" class="kamar-foto">
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
                        <a href="{{ route('detailKamar', $kamar->id_kamar) }}" class="btn-detail-kamar">Lihat Detail</a>
                    </div>

                </div>
                @empty
                <p style="text-align:center;color:#8a9e8c;padding:20px 0;font-size:0.88rem;">
                    Belum ada kamar yang tersedia
                </p>
                @endforelse
            </div>

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

{{-- FORM AJUKAN SEWA --}}
<div class="booking-card">

    <div class="booking-title">
        Ajukan Sewa
    </div>

    {{-- SUCCESS --}}
    @if(session('success'))

        <div class="booking-success">
            {{ session('success') }}
        </div>

    @endif

    {{-- ERROR --}}
    @if($errors->any())

        <div class="booking-alert">
            {{ $errors->first() }}
        </div>

    @endif

    <form
        action="{{ route('penghuni.pengajuan.store') }}"
        method="POST"
    >

        @csrf

        {{-- PILIH KAMAR --}}
        <div class="booking-group">

            <label class="booking-label">
                Pilih Kamar
            </label>

            <select
                name="id_kamar"
                class="booking-select"
                id="kamarSelect"
                required
            >

                <option value="">
                    -- Pilih Kamar --
                </option>

                @foreach($kost->kamars as $kamar)

                    <option
                        value="{{ $kamar->id_kamar }}"
                    >

                        {{ $kamar->nama_kamar }}

                    </option>

                @endforeach

            </select>

        </div>

        {{-- PILIH PERIODE --}}
        <div class="booking-group">

            <label class="booking-label">
                Pilih Periode Sewa
            </label>

            <select
                name="id_harga_kamar"
                class="booking-select"
                id="hargaSelect"
                required
            >

                <option value="">
                    -- Pilih Periode --
                </option>

            </select>

        </div>

        {{-- TANGGAL MASUK --}}
        <div class="booking-group">

            <label class="booking-label">
                Tanggal Masuk
            </label>

            <input
                type="date"
                name="tanggal_masuk"
                class="booking-input"
                required
            >

        </div>

        {{-- TANGGAL KELUAR --}}
        <div class="booking-group">

            <label class="booking-label">
                Tanggal Keluar
            </label>

            <input
                type="date"
                name="tanggal_keluar"
                class="booking-input"
                required
            >

        </div>

        {{-- BUTTON --}}
        <button
            type="submit"
            class="booking-button"
        >

            Ajukan Sewa

        </button>

    </form>

</div>

            {{-- PEMILIK CARD --}}
            @if($pemilik)
            <div class="pemilik-card">

                {{-- Judul --}}
                <p class="pemilik-card-title">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Pemilik Kost
                </p>

                {{-- Avatar + nama --}}
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
                        <div class="pemilik-username">@{{ $pemilik->username }}</div>
                        @endif
                        <div class="pemilik-sejak">Bergabung sejak {{ $pemilik->created_at->format('Y') }}</div>
                    </div>
                </div>

                {{-- No HP — style field register --}}
                @if($noHpRaw)
                <div class="pemilik-info-row">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                    <div>
                        <span class="pemilik-info-label">Nomor WhatsApp</span>
                        <span class="pemilik-info-value">{{ $noHpRaw }}</span>
                    </div>
                </div>
                @endif

                {{-- Email --}}
                @if(!empty($pemilik->email))
                <div class="pemilik-info-row">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <div>
                        <span class="pemilik-info-label">Email</span>
                        <span class="pemilik-info-value">{{ $pemilik->email }}</span>
                    </div>
                </div>
                @endif

                <div class="pemilik-divider"></div>

                <p class="pemilik-kontak-title">Hubungi Langsung</p>

                {{-- Tombol WA --}}
                @if($noWa)
                <a href="https://wa.me/{{ $noWa }}?text={{ $pesanWa }}" target="_blank"
                    class="btn-pemilik btn-pemilik-wa">
                    <svg fill="white" viewBox="0 0 24 24">
                        <path
                            d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                    </svg>
                    Chat WhatsApp
                </a>

                {{-- Tombol Telepon --}}
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

                {{-- Tombol Email --}}
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

    {{-- MODAL FOTO --}}
    <div class="modal-foto" id="modalFoto">
        <button class="modal-close" onclick="tutupModal()">✕</button>

        @if(count($galeri) > 1)
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
        <div class="modal-counter" id="modalCounter">1 / {{ count($galeri) }}</div>
        @endif

        <img id="modalImg" src="" alt="Foto" onclick="event.stopPropagation()">
    </div>

</div>

@endsection

@php

$hargaKamarJson = [];

foreach ($kost->kamars as $kamar) {

    $hargaKamarJson[$kamar->id_kamar] = [];

    foreach ($kamar->hargaKamars as $harga) {

        $hargaKamarJson[$kamar->id_kamar][] = [

            'id' => $harga->id_harga_kamar,

            'periode' =>
                $harga->periode->nama_periode ?? '-',

            'harga' =>
                $harga->harga

        ];

    }

}

@endphp

@push('scripts')

<script>

const hargaKamar = @json($hargaKamarJson);

const kamarSelect =
    document.getElementById('kamarSelect');

const hargaSelect =
    document.getElementById('hargaSelect');

kamarSelect.addEventListener(
    'change',
    function () {

        const kamarId = this.value;

        hargaSelect.innerHTML = `
            <option value="">
                -- Pilih Periode --
            </option>
        `;

        if (hargaKamar[kamarId]) {

            hargaKamar[kamarId]
            .forEach(function (harga) {

                hargaSelect.innerHTML += `
                    <option value="${harga.id}">
                        ${harga.periode}
                        -
                        Rp ${Number(harga.harga)
                            .toLocaleString('id-ID')}
                    </option>
                `;

            });

        }

    }
);

</script>

<script>
const galeriUrls = @json($galeriUrls);
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