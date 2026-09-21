@extends('layouts.public')

@section('title', $kost->nama_kost . ' - KosinAja!')

@section('styles')
<style>
/* BASE */
.detail-wrap {
    background: #F8F7F4;
    min-height: 100vh;
    padding: 32px 64px 64px
}

.breadcrumb {
    font-size: .82rem;
    color: #8a9e8c;
    margin-bottom: 24px
}

.breadcrumb a {
    color: #8a9e8c;
    text-decoration: none;
    transition: color .2s
}

.breadcrumb a:hover {
    color: #6C8B6B
}

.detail-layout {
    display: grid;
    grid-template-columns: minmax(0, 1fr) 340px;
    gap: 28px;
    align-items: start
}

/* GALERI */
.galeri-grid {
    display: grid;
    grid-template-columns: 1fr 180px;
    gap: 10px;
    margin-bottom: 20px
}

.galeri-main img {
    width: 100%;
    height: 320px;
    object-fit: cover;
    border-radius: 20px;
    cursor: pointer;
    transition: transform .3s ease
}

.galeri-main img:hover {
    transform: scale(1.01)
}

.galeri-side {
    display: flex;
    flex-direction: column;
    gap: 10px
}

.galeri-side img {
    width: 100%;
    height: 98px;
    object-fit: cover;
    border-radius: 14px;
    cursor: pointer;
    transition: transform .3s ease
}

.galeri-side img:hover {
    transform: scale(1.02)
}

.galeri-more {
    position: relative;
    border-radius: 14px;
    overflow: hidden;
    cursor: pointer
}

.galeri-more img {
    width: 100%;
    height: 98px;
    object-fit: cover;
    filter: brightness(.45)
}

.galeri-more span {
    position: absolute;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-weight: 800;
    font-size: 1rem;
    font-family: 'Plus Jakarta Sans', sans-serif
}

/* SECTION BOX */
.section-box {
    background: #fff;
    border: 1px solid #E8EFE9;
    border-radius: 20px;
    padding: 24px;
    margin-bottom: 20px;
    box-shadow: 0 2px 12px rgba(26, 47, 36, .05)
}

.section-title {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-weight: 800;
    font-size: 1.05rem;
    color: #1F3A2C;
    margin-bottom: 16px
}

.section-sub {
    font-size: .82rem;
    color: #8a9e8c;
    margin-top: -10px;
    margin-bottom: 16px
}

/* INFO UTAMA */
.kos-title {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-weight: 800;
    font-size: 1.8rem;
    color: #1F3A2C;
    margin-bottom: 8px;
    line-height: 1.2
}

.kos-meta {
    display: flex;
    align-items: center;
    gap: 16px;
    margin-bottom: 14px;
    flex-wrap: wrap
}

.kos-meta-item {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: .88rem;
    color: #7A8A7C
}

.kos-meta-item svg {
    width: 15px;
    height: 15px;
    fill: #6C8B6B;
    flex-shrink: 0
}

.kos-desc {
    font-size: .9rem;
    color: #4a5e4c;
    line-height: 1.85;
    margin-bottom: 14px
}

.tersedia-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: .82rem;
    font-weight: 700;
    color: #1F3A2C;
    background: #EAF3EB;
    border: 1px solid #D0E5D2;
    padding: 6px 14px;
    border-radius: 999px
}

.tersedia-badge .jumlah {
    color: #6C8B6B
}

/* FASILITAS */
.fasilitas-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 10px
}

.fasilitas-chip {
    padding: 10px 16px;
    background: #F0F5F1;
    border-radius: 12px;
    font-size: .82rem;
    color: #2a4a2c;
    font-weight: 600;
    border: 1px solid #E0EBE2;
    transition: background .2s, transform .2s
}

.fasilitas-chip:hover {
    background: #E2EDE3;
    transform: translateY(-1px)
}

/* DAFTAR KAMAR */
.kamar-item {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 16px 0;
    border-bottom: 1px solid #F0F5F1
}

.kamar-item:last-child {
    border-bottom: none;
    padding-bottom: 0
}

.kamar-foto {
    width: 100px;
    height: 72px;
    object-fit: cover;
    border-radius: 12px;
    background: #e5e7eb;
    flex-shrink: 0;
    cursor: pointer;
    transition: transform .2s, opacity .2s
}

.kamar-foto:hover {
    transform: scale(1.04);
    opacity: .88
}

.kamar-info {
    flex: 1
}

.kamar-nama {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-weight: 700;
    font-size: .95rem;
    color: #1F3A2C;
    margin-bottom: 4px
}

.kamar-fasilitas {
    display: flex;
    flex-wrap: wrap;
    gap: 4px;
    margin-top: 6px
}

.kamar-tag {
    padding: 3px 10px;
    background: #F0F5F1;
    border-radius: 6px;
    font-size: .7rem;
    color: #4a5e4c;
    font-weight: 600;
    border: 1px solid #E0EBE2
}

.kamar-harga {
    text-align: right;
    flex-shrink: 0
}

.kamar-harga .harga {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-weight: 800;
    font-size: 1rem;
    color: #1F3A2C
}

.kamar-harga .per {
    font-size: .75rem;
    color: #8a9e8c
}

.badge-tersedia,
.badge-terisi {
    display: inline-flex;
    align-items: center;
    padding: 4px 12px;
    border-radius: 999px;
    font-size: .72rem;
    font-weight: 700;
    margin-top: 6px
}

.badge-tersedia {
    background: #dcfce7;
    color: #166534
}

.badge-terisi {
    background: #fee2e2;
    color: #991b1b
}

.btn-detail-kamar {
    display: inline-block;
    background: #6C8B6B;
    color: #fff;
    padding: 7px 16px;
    border-radius: 10px;
    font-size: .8rem;
    font-weight: 700;
    text-decoration: none;
    margin-top: 8px;
    transition: background .2s, transform .2s
}

.btn-detail-kamar:hover {
    background: #5a7a59;
    transform: translateY(-1px)
}

/* LOKASI DAN RUTE (SATU PETA) */
.lokasi-head {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 14px;
    flex-wrap: wrap;
    margin-bottom: 16px
}

.lokasi-alamat {
    display: flex;
    align-items: flex-start;
    gap: 8px;
    font-size: .86rem;
    color: #4a5e4c;
    line-height: 1.5
}

.lokasi-alamat svg {
    width: 15px;
    height: 15px;
    fill: #6C8B6B;
    flex-shrink: 0;
    margin-top: 2px
}

.seg {
    display: inline-flex;
    gap: 2px;
    padding: 3px;
    background: #F0F5F1;
    border-radius: 12px;
    flex-shrink: 0
}

.seg button {
    border: none;
    background: transparent;
    color: #7A8A7C;
    font: inherit;
    font-size: .8rem;
    font-weight: 700;
    padding: 7px 14px;
    border-radius: 9px;
    cursor: pointer;
    transition: background .2s, color .2s
}

.seg button.on {
    background: #fff;
    color: #1F3A2C;
    box-shadow: 0 1px 3px rgba(26, 47, 36, .12)
}

.rute-map-wrap {
    position: relative;
    width: 100%;
    height: 380px;
    border-radius: 14px;
    overflow: hidden;
    border: 1px solid #E8EFE9;
    background: #EEF4EF
}

#mapFrame {
    width: 100%;
    height: 100%;
    border: 0;
    display: block
}

.rute-loading {
    display: none;
    font-size: .8rem;
    color: #6C8B6B;
    margin-top: 12px
}

.rute-loading.active {
    display: block
}

.rute-note {
    display: none;
    margin-top: 12px;
    padding: 10px 14px;
    border-radius: 10px;
    background: #FFF8E6;
    border: 1px solid #F5E2A8;
    color: #7A5B00;
    font-size: .8rem;
    line-height: 1.6
}

.rute-note.active {
    display: block
}

.rute-result {
    display: none;
    margin-top: 14px;
    gap: 12px;
    grid-template-columns: repeat(2, minmax(0, 1fr))
}

.rute-result.active {
    display: grid
}

.rute-result-item {
    background: #F0F5F1;
    border: 1px solid #E0EBE2;
    border-radius: 12px;
    padding: 10px 14px;
    display: flex;
    flex-direction: column;
    gap: 2px
}

.rute-result-label {
    font-size: .72rem;
    color: #8a9e8c
}

.rute-result-value {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 1.05rem;
    font-weight: 800;
    color: #1F3A2C
}

.rute-actions {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    margin-top: 14px
}

.rute-button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    border: 1px solid #6C8B6B;
    border-radius: 12px;
    background: #6C8B6B;
    color: #fff;
    padding: 11px 18px;
    font: inherit;
    font-size: .82rem;
    font-weight: 700;
    cursor: pointer;
    text-decoration: none;
    transition: background .2s, transform .2s;
    white-space: nowrap
}

.rute-button:hover {
    background: #5A7A59;
    transform: translateY(-1px)
}

.rute-button.ghost {
    background: #fff;
    color: #4F6B4F;
    border-color: #D0E5D2
}

.rute-button.ghost:hover {
    background: #F0F5F1
}

.rute-button:disabled {
    opacity: .6;
    cursor: not-allowed;
    transform: none
}

.rute-button svg {
    width: 16px;
    height: 16px;
    flex-shrink: 0
}

.map-pin {
    width: 34px;
    height: 34px;
    border-radius: 50%;
    border: 4px solid #fff;
    box-shadow: 0 2px 10px rgba(0, 0, 0, .25);
    display: flex;
    align-items: center;
    justify-content: center
}

.map-pin.user {
    background: #4285F4
}

.map-pin.user::after {
    content: '';
    width: 10px;
    height: 10px;
    background: #fff;
    border-radius: 50%
}

.map-pin.kost {
    background: #6C8B6B
}

.map-pin.kost svg {
    width: 16px;
    height: 16px;
    fill: #fff
}

/* KOLOM KANAN */
.sticky-card {
    position: sticky;
    top: 104px;
    display: flex;
    flex-direction: column;
    gap: 16px
}

.harga-card,
.pemilik-card {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 32px;
    padding: 24px;
    box-shadow: 0 1px 4px rgba(0, 0, 0, .04)
}

.harga-label {
    font-size: .78rem;
    color: #8a9e8c;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: .5px;
    margin-bottom: 4px
}

.harga-mulai {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-weight: 800;
    font-size: 1.8rem;
    color: #1F3A2C;
    line-height: 1.1
}

.harga-mulai span {
    font-size: .9rem;
    font-weight: 500;
    color: #7A8A7C
}

.harga-divider {
    height: 1px;
    background: #F0F5F1;
    margin: 16px 0
}

.harga-info-row {
    display: flex;
    justify-content: space-between;
    gap: 12px;
    font-size: .85rem;
    color: #4a5e4c;
    margin-bottom: 8px
}

.harga-info-row strong {
    color: #1F3A2C;
    font-weight: 700;
    text-align: right
}

/* PEMILIK */
.pemilik-card-title {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-weight: 700;
    font-size: 1rem;
    color: #1F3A2C;
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    gap: 8px
}

.pemilik-card-title svg {
    width: 18px;
    height: 18px;
    color: #6C8B6B;
    flex-shrink: 0
}

.pemilik-avatar-row {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 20px
}

.pemilik-avatar {
    width: 52px;
    height: 52px;
    border-radius: 50%;
    background: #D6E5D6;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0
}

.pemilik-nama {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-weight: 700;
    font-size: .95rem;
    color: #1F3A2C
}

.pemilik-username {
    font-size: .78rem;
    color: #6C8B6B;
    font-weight: 600;
    margin-top: 2px
}

.pemilik-sejak {
    font-size: .75rem;
    color: #9ca3af;
    margin-top: 2px
}

.pemilik-divider {
    height: 1px;
    background: #f3f4f6;
    margin: 16px 0
}

.pemilik-kontak-title {
    font-size: .82rem;
    font-weight: 700;
    color: #4F6B4F;
    margin-bottom: 10px
}

.btn-pemilik {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    width: 100%;
    text-decoration: none;
    font-weight: 600;
    font-size: .88rem;
    border-radius: 16px;
    padding: 14px;
    margin-bottom: 10px;
    transition: background .2s, transform .15s
}

.btn-pemilik:last-child {
    margin-bottom: 0
}

.btn-pemilik:hover {
    transform: translateY(-1px)
}

.btn-pemilik svg {
    width: 18px;
    height: 18px;
    flex-shrink: 0
}

.btn-pemilik-wa {
    background: #6C8B6B;
    color: #fff
}

.btn-pemilik-wa:hover {
    background: #5B765A
}

.btn-pemilik-telp,
.btn-pemilik-email {
    background: #F8F5F0;
    color: #374151;
    border: 1px solid #e5e7eb
}

.btn-pemilik-telp:hover,
.btn-pemilik-email:hover {
    background: #f0ede8
}

.hubungi-note {
    font-size: .73rem;
    color: #9ca3af;
    text-align: center;
    margin-top: 12px
}

/* MODAL FOTO */
.modal-foto {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, .92);
    z-index: 9999;
    align-items: center;
    justify-content: center;
    padding: 20px;
    box-sizing: border-box
}

.modal-foto.active {
    display: flex
}

#modalImg {
    max-width: min(88vw, 1000px);
    max-height: 85vh;
    border-radius: 16px;
    object-fit: contain;
    display: block;
    transition: transform .25s ease, opacity .25s ease;
    user-select: none;
    -webkit-user-drag: none
}

.modal-close {
    position: fixed;
    top: 20px;
    right: 24px;
    color: #fff;
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
    line-height: 1
}

.modal-close:hover {
    background: rgba(255, 255, 255, .32)
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
    z-index: 10001
}

.modal-nav:hover {
    background: rgba(255, 255, 255, .32);
    transform: translateY(-50%) scale(1.08)
}

.modal-nav svg {
    width: 22px;
    height: 22px;
    fill: #fff
}

.modal-prev {
    left: 20px
}

.modal-next {
    right: 20px
}

.modal-counter {
    position: fixed;
    bottom: 24px;
    left: 50%;
    transform: translateX(-50%);
    background: rgba(0, 0, 0, .55);
    color: #fff;
    font-size: .82rem;
    font-weight: 700;
    padding: 6px 18px;
    border-radius: 999px;
    pointer-events: none;
    z-index: 10001;
    white-space: nowrap
}

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
    padding: 4px 8px
}

.modal-thumb {
    width: 52px;
    height: 38px;
    object-fit: cover;
    border-radius: 8px;
    cursor: pointer;
    opacity: .5;
    border: 2px solid transparent;
    transition: opacity .2s, border-color .2s, transform .2s;
    flex-shrink: 0
}

.modal-thumb.active-thumb {
    opacity: 1;
    border-color: #fff;
    transform: scale(1.08)
}

.modal-thumb:hover {
    opacity: .85
}

/* RESPONSIVE */
@media (max-width:1024px) {
    .detail-wrap {
        padding: 24px 32px 48px
    }

    .detail-layout {
        grid-template-columns: 1fr
    }

    .sticky-card {
        position: static
    }
}

@media (max-width:768px) {
    .detail-wrap {
        padding: 20px 20px 40px
    }

    .galeri-grid {
        grid-template-columns: 1fr
    }

    .galeri-side {
        display: none
    }

    .kos-title {
        font-size: 1.4rem
    }

    .kamar-item {
        align-items: flex-start
    }

    .kamar-harga {
        min-width: 105px
    }

    .modal-prev {
        left: 8px
    }

    .modal-next {
        right: 8px
    }

    .modal-thumbs {
        display: none
    }

    .rute-map-wrap {
        height: 300px
    }

    .seg {
        width: 100%
    }

    .seg button {
        flex: 1
    }

    .rute-actions {
        flex-direction: column
    }

    .rute-button {
        width: 100%
    }
}

@media (max-width:520px) {
    .kamar-item {
        flex-wrap: wrap
    }

    .kamar-info {
        min-width: calc(100% - 116px)
    }

    .kamar-harga {
        width: 100%;
        text-align: left;
        margin-left: 116px
    }

    .rute-result {
        grid-template-columns: 1fr
    }
}
</style>
@endsection


@section('content')

@php
$galeri = is_array($kost->foto_kost ?? null) ? $kost->foto_kost : [];
$fotoUtama = count($galeri) > 0 ? Storage::url($galeri[0]) : null;
$galeriUrls = array_map(fn ($foto) => Storage::url($foto), $galeri);

$kamarKosong = $kost->kamars->where('status', 'kosong')->count();

// Harga termurah (periode bulanan)
$hargaAktif = $kost->kamars->flatMap(function ($kamar) {
return $kamar->hargaKamars
->where('isactive', true)
->filter(fn ($h) => $h->periode && $h->periode->satuan_interval === 'bulan');
});
$hargaMulai = $hargaAktif->min('harga');

// Data pemilik
$pemilik = $kost->user;
$noHpRaw = $pemilik?->no_hp ?? null;
$nomorBersih = $noHpRaw ? preg_replace('/[^0-9]/', '', $noHpRaw) : null;
$noWa = $nomorBersih ? '62' . ltrim($nomorBersih, '0') : null;
$pesanWa = urlencode('Halo, saya tertarik dengan kost ' . $kost->nama_kost . '. Apakah masih ada kamar yang tersedia?');

/*
| KOORDINAT KOST (urutan prioritas)
| 1. Kolom latitude / longitude di tabel kost
| 2. Koordinat yang sudah ada di link Google Maps ($kost->lokasi)
| 3. Fallback di browser: cari dari alamat lewat Nominatim
*/
$routeLatitude = $kost->latitude ?? $kost->lat ?? $kost->lintang ?? null;
$routeLongitude = $kost->longitude ?? $kost->lng ?? $kost->bujur ?? null;

if ((!is_numeric($routeLatitude) || !is_numeric($routeLongitude)) && !empty($kost->lokasi)) {
$link = urldecode((string) $kost->lokasi);

if (preg_match('/!2d(-?\d+(?:\.\d+)?)!3d(-?\d+(?:\.\d+)?)/', $link, $m)) {
$routeLongitude = $m[1];
$routeLatitude = $m[2];
} elseif (preg_match('/!3d(-?\d+(?:\.\d+)?)!4d(-?\d+(?:\.\d+)?)/', $link, $m)) {
$routeLatitude = $m[1];
$routeLongitude = $m[2];
} elseif (preg_match('/[?&](?:q|ll)=(-?\d+(?:\.\d+)?),\s*(-?\d+(?:\.\d+)?)/', $link, $m)) {
$routeLatitude = $m[1];
$routeLongitude = $m[2];
}
}

$adaKoordinat = is_numeric($routeLatitude) && is_numeric($routeLongitude);

// Sumber iframe awal: link embed Google dari database (lengkap dengan kartu tempat),
// kalau kosong pakai koordinat, kalau tidak ada juga pakai alamat.
if (!empty($kost->lokasi)) {
$embedDefault = $kost->lokasi;
} elseif ($adaKoordinat) {
$embedDefault = 'https://maps.google.com/maps?q=' . $routeLatitude . ',' . $routeLongitude . '&z=16&hl=id&output=embed';
} else {
$embedDefault = 'https://maps.google.com/maps?q=' . urlencode((string) $kost->alamat) . '&z=15&hl=id&output=embed';
}
@endphp


<div class="detail-wrap">

    <div class="breadcrumb">
        <a href="{{ route('home') }}">Beranda</a> › Detail Kost
    </div>

    <div class="detail-layout">

        {{-- ================= KOLOM KIRI ================= --}}
        <div>

            {{-- GALERI --}}
            <div class="section-box" style="padding:16px;">
                <div class="galeri-grid">

                    <div class="galeri-main">
                        @if($fotoUtama)
                        <img src="{{ $fotoUtama }}" alt="{{ $kost->nama_kost }}" onclick="bukaFoto(0)"
                            title="Klik untuk melihat foto">
                        @else
                        <div
                            style="width:100%;height:320px;background:#D5E0D6;border-radius:20px;display:flex;align-items:center;justify-content:center;">
                            <svg style="width:56px;height:56px;fill:#A8C0AA;" viewBox="0 0 24 24">
                                <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z" />
                            </svg>
                        </div>
                        @endif
                    </div>

                    <div class="galeri-side">
                        @foreach(array_slice($galeri, 1, 2) as $idx => $foto)
                        <img src="{{ Storage::url($foto) }}" alt="Foto {{ $idx + 2 }}"
                            onclick="bukaFoto({{ $idx + 1 }})" title="Klik untuk melihat foto">
                        @endforeach

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
                    <svg style="width:14px;height:14px;fill:#6C8B6B;" viewBox="0 0 24 24">
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
                $fotoKamarArr = is_array($kamar->foto_kamar ?? null) ? $kamar->foto_kamar : [];
                $fotoKamar = count($fotoKamarArr) > 0 ? Storage::url($fotoKamarArr[0]) : null;
                $fotoKamarUrls = array_map(fn ($foto) => Storage::url($foto), $fotoKamarArr);
                $hargaKamar = $kamar->hargaKamars->where('isactive', true)->first();
                @endphp

                <div class="kamar-item">

                    @if($fotoKamar)
                    <img src="{{ $fotoKamar }}" alt="{{ $kamar->nama_kamar }}" class="kamar-foto"
                        onclick='bukaFotoKamar(@json($fotoKamarUrls), 0)' title="Klik untuk melihat foto kamar">
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
                        <p style="font-size:.78rem;color:#8a9e8c;margin-top:6px;">Ukuran: {{ $kamar->ukuran_kamar }}</p>
                        @endif
                    </div>

                    <div class="kamar-harga">
                        @if($hargaKamar)
                        <div class="harga">Rp {{ number_format($hargaKamar->harga, 0, ',', '.') }}</div>
                        <div class="per">/ bulan</div>
                        @else
                        <div class="harga" style="font-size:.85rem;">Hubungi Kami</div>
                        @endif

                        <div>
                            @if($kamar->status === 'kosong')
                            <span class="badge-tersedia">Tersedia</span>
                            @else
                            <span class="badge-terisi">Terisi</span>
                            @endif
                        </div>

                        <a href="{{ route('detailKamar', $kamar->id_kamar) }}" class="btn-detail-kamar">Lihat Detail</a>
                    </div>

                </div>
                @empty
                <p style="text-align:center;color:#8a9e8c;padding:20px 0;font-size:.88rem;">Belum ada kamar yang
                    tersedia</p>
                @endforelse
            </div>


            {{-- FASILITAS KOST --}}
            @if($kost->fasilitas && $kost->fasilitas->count() > 0)
            <div class="section-box">
                <div class="section-title">Fasilitas Kost</div>
                <p class="section-sub">Fasilitas yang tersedia di kost ini</p>

                <div class="fasilitas-grid">
                    @foreach($kost->fasilitas as $fasilitas)
                    <div class="fasilitas-chip">{{ $fasilitas->nama_fasilitas }}</div>
                    @endforeach
                </div>
            </div>
            @endif


            {{-- =====================================================
                 LOKASI DAN RUTE (SATU KARTU, SATU PETA)
                 Menggantikan iframe Google Maps + kartu rute terpisah
            ====================================================== --}}
            @if($kost->alamat || $adaKoordinat)
            <div class="section-box" id="lokasiBox">

                <div class="lokasi-head">
                    <div>
                        <div class="section-title" style="margin-bottom:6px;">Lokasi dan Rute</div>
                        <div class="lokasi-alamat">
                            <svg viewBox="0 0 24 24">
                                <path
                                    d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5S10.62 6.5 12 6.5 14.5 7.62 14.5 9 13.38 11.5 12 11.5z" />
                            </svg>
                            <span>{{ $kost->alamat }}</span>
                        </div>
                    </div>

                    <div class="seg" role="tablist">
                        <button type="button" id="tabLokasi" class="on" onclick="setTab(false)">Lokasi</button>
                        <button type="button" id="tabRute" onclick="setTab(true)">Rute dari lokasimu</button>
                    </div>
                </div>

                <div class="rute-map-wrap" id="mapWrap">
                    <iframe id="mapFrame" src="{{ $embedDefault }}" title="Peta lokasi {{ $kost->nama_kost }}"
                        allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>

                <div id="routeLoading" class="rute-loading">Sedang mencari lokasi dan menghitung rute...</div>
                <div id="routeMsg" class="rute-note"></div>

                <div id="routeResult" class="rute-result">
                    <div class="rute-result-item">
                        <span class="rute-result-label">Perkiraan waktu</span>
                        <span id="routeDuration" class="rute-result-value">-</span>
                    </div>
                    <div class="rute-result-item">
                        <span class="rute-result-label">Jarak</span>
                        <span id="routeDistance" class="rute-result-value">-</span>
                    </div>
                </div>

                <div class="rute-actions">
                    <button type="button" id="btnRoute" class="rute-button" onclick="buatRute()">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="3" />
                            <path d="M12 2v3M12 19v3M2 12h3M19 12h3" />
                            <circle cx="12" cy="12" r="8" />
                        </svg>
                        <span id="btnRouteText">Gunakan lokasi saya</span>
                    </button>

                    <a id="btnGmaps" class="rute-button ghost" target="_blank" rel="noopener noreferrer"
                        href="https://www.google.com/maps/search/?api=1&query={{ $adaKoordinat ? $routeLatitude . ',' . $routeLongitude : urlencode($kost->alamat) }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6M15 3h6v6M10 14L21 3" />
                        </svg>
                        Buka di Google Maps
                    </a>
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
                    <div
                        style="display:flex;gap:14px;align-items:flex-start;padding:14px 16px;background:#F8FAF8;border:1px solid #E8EFE9;border-radius:12px;">
                        <div
                            style="width:26px;height:26px;background:#EAF3EB;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:.75rem;font-weight:800;color:#4B8A4B;flex-shrink:0;">
                            {{ $index + 1 }}</div>
                        <p style="font-size:.88rem;color:#4a5e4c;line-height:1.7;margin:0;padding-top:2px;">
                            {{ $aturan->isi }}</p>
                    </div>
                    @endforeach
                </div>

                @if($kost->aturanKos->count() > 5)
                <button type="button" onclick="bukaModalAturan()"
                    style="margin-top:16px;border:none;background:none;padding:0;font-size:.85rem;font-weight:700;color:#6C8B6B;cursor:pointer;">
                    Lihat Selengkapnya →
                </button>
                @endif
            </div>
            @endif

        </div>


        {{-- ================= KOLOM KANAN ================= --}}
        <div class="sticky-card">

            {{-- HARGA --}}
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


            {{-- PEMILIK --}}
            @if($pemilik)
            <div class="pemilik-card">

                <p class="pemilik-card-title">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
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

                        @if($pemilik->created_at)
                        <div class="pemilik-sejak">Bergabung sejak {{ $pemilik->created_at->format('Y') }}</div>
                        @endif
                    </div>
                </div>

                <div class="pemilik-divider"></div>

                <p class="pemilik-kontak-title">Hubungi Langsung</p>

                @if($noWa)
                <a href="https://wa.me/{{ $noWa }}?text={{ $pesanWa }}" target="_blank" rel="noopener noreferrer"
                    class="btn-pemilik btn-pemilik-wa">
                    <svg fill="white" viewBox="0 0 24 24">
                        <path
                            d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                    </svg>
                    Chat WhatsApp
                </a>

                <a href="tel:{{ $noHpRaw }}" class="btn-pemilik btn-pemilik-telp">
                    <svg fill="none" viewBox="0 0 24 24" stroke="#6C8B6B">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                    {{ $noHpRaw }}
                </a>
                @else
                <p style="font-size:.8rem;color:#9ca3af;text-align:center;">Nomor tidak tersedia</p>
                @endif

                @if(!empty($pemilik->email))
                <a href="mailto:{{ $pemilik->email }}" class="btn-pemilik btn-pemilik-email">
                    <svg fill="none" viewBox="0 0 24 24" stroke="#6C8B6B">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    Kirim Email
                </a>
                @endif

                <p class="hubungi-note">Biasanya membalas dalam beberapa menit</p>

            </div>
            @endif

        </div>

    </div>


    {{-- MODAL FOTO --}}
    <div class="modal-foto" id="modalFoto" role="dialog" aria-modal="true" aria-label="Galeri foto">
        <button class="modal-close" onclick="tutupFoto()" aria-label="Tutup galeri">✕</button>

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

        <img id="modalImg" src="" alt="Preview foto" onclick="event.stopPropagation()">

        <div class="modal-counter" id="modalCounter">1 / 1</div>
        <div class="modal-thumbs" id="modalThumbs"></div>
    </div>

</div>


{{-- MODAL ATURAN --}}
@if($kost->aturanKos && $kost->aturanKos->count() > 5)
<div id="modalAturan" class="modal-foto" onclick="tutupModalAturan()">
    <div onclick="event.stopPropagation()"
        style="background:white;width:min(92vw,600px);max-height:85vh;overflow-y:auto;border-radius:28px;padding:28px;position:relative;">

        <button type="button" onclick="tutupModalAturan()"
            style="position:absolute;top:18px;right:18px;width:38px;height:38px;border:none;border-radius:50%;background:#F3F4F6;cursor:pointer;font-size:1rem;">✕</button>

        <h2 style="font-size:1.3rem;font-weight:800;color:#1F3A2C;margin-bottom:24px;">Aturan Kost</h2>

        <div style="display:flex;flex-direction:column;gap:14px;">
            @foreach($kost->aturanKos as $index => $aturan)
            <div
                style="display:flex;gap:14px;align-items:flex-start;padding:16px;background:#F8FAF8;border-radius:16px;border:1px solid #E8EFE9;">
                <div
                    style="width:28px;height:28px;border-radius:10px;background:#EAF3EB;display:flex;align-items:center;justify-content:center;font-weight:800;font-size:.78rem;color:#4B8A4B;flex-shrink:0;">
                    {{ $index + 1 }}</div>
                <p style="margin:0;font-size:.9rem;line-height:1.8;color:#4a5e4c;">{{ $aturan->isi }}</p>
            </div>
            @endforeach
        </div>

    </div>
</div>
@endif

@endsection


@push('scripts')
<script>
/* =========================================================
   DATA
========================================================= */
const galeriUrls = @json($galeriUrls);
const alamatKost = @json($kost -> alamat);
const namaKost = @json($kost -> nama_kost);
const koordinatKostAwal = {
    latitude: @json($routeLatitude),
    longitude: @json($routeLongitude)
};
const $ = id => document.getElementById(id);


/* =========================================================
   MODAL FOTO
========================================================= */
let modalUrls = [];
let modalIndex = 0;
let isAnimating = false;

function bukaFoto(idx) {
    if (galeriUrls && galeriUrls.length) bukaModalDenganUrls(galeriUrls, idx);
}

function bukaFotoKamar(urls, idx) {
    if (urls && urls.length) bukaModalDenganUrls(urls, idx);
}

function bukaModalDenganUrls(urls, idx) {
    modalUrls = urls;
    modalIndex = Math.max(0, Math.min(idx, urls.length - 1));

    const modal = $('modalFoto');
    const img = $('modalImg');
    const showNav = urls.length > 1;

    $('modalPrev').style.display = showNav ? 'flex' : 'none';
    $('modalNext').style.display = showNav ? 'flex' : 'none';

    renderThumbs();

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

function tutupFoto() {
    const modal = $('modalFoto');
    const img = $('modalImg');

    img.style.transition = 'opacity .2s ease';
    img.style.opacity = '0';

    setTimeout(() => {
        modal.classList.remove('active');
        document.body.style.overflow = '';
        img.src = '';
    }, 200);
}

function fotoNav(dir) {
    if (!modalUrls.length || isAnimating) return;
    isAnimating = true;

    const img = $('modalImg');
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

function updateCounter() {
    const counter = $('modalCounter');
    if (!counter) return;
    counter.textContent = (modalIndex + 1) + ' / ' + modalUrls.length;
    counter.style.display = modalUrls.length > 1 ? 'block' : 'none';
}

function renderThumbs() {
    const strip = $('modalThumbs');
    if (!strip) return;

    strip.innerHTML = '';
    if (modalUrls.length <= 1) return;

    modalUrls.forEach((url, i) => {
        const thumb = document.createElement('img');
        thumb.src = url;
        thumb.alt = 'Foto ' + (i + 1);
        thumb.className = 'modal-thumb' + (i === modalIndex ? ' active-thumb' : '');

        thumb.addEventListener('click', e => {
            e.stopPropagation();
            if (i === modalIndex) return;
            const dir = i > modalIndex ? 1 : -1;
            modalIndex = i - dir;
            fotoNav(dir);
        });

        strip.appendChild(thumb);
    });
}

function updateActiveThumbs() {
    const thumbs = document.querySelectorAll('.modal-thumb');
    thumbs.forEach((t, i) => t.classList.toggle('active-thumb', i === modalIndex));

    if (thumbs[modalIndex]) {
        thumbs[modalIndex].scrollIntoView({
            behavior: 'smooth',
            block: 'nearest',
            inline: 'center'
        });
    }
}

const modalFoto = $('modalFoto');

if (modalFoto) {
    modalFoto.addEventListener('click', function(e) {
        if (e.target === this) tutupFoto();
    });

    let touchStartX = 0,
        touchStartY = 0;

    modalFoto.addEventListener('touchstart', e => {
        touchStartX = e.touches[0].clientX;
        touchStartY = e.touches[0].clientY;
    }, {
        passive: true
    });

    modalFoto.addEventListener('touchend', e => {
        const diffX = touchStartX - e.changedTouches[0].clientX;
        const diffY = Math.abs(touchStartY - e.changedTouches[0].clientY);
        if (Math.abs(diffX) > 50 && Math.abs(diffX) > diffY) fotoNav(diffX > 0 ? 1 : -1);
    }, {
        passive: true
    });
}

document.addEventListener('keydown', e => {
    const modal = $('modalFoto');
    if (!modal || !modal.classList.contains('active')) return;

    if (e.key === 'Escape') tutupFoto();
    if (e.key === 'ArrowRight') fotoNav(1);
    if (e.key === 'ArrowLeft') fotoNav(-1);
});


/* =========================================================
   MODAL ATURAN
========================================================= */
function bukaModalAturan() {
    const modal = $('modalAturan');
    if (!modal) return;
    modal.classList.add('active');
    document.body.style.overflow = 'hidden';
}

function tutupModalAturan() {
    const modal = $('modalAturan');
    if (!modal) return;
    modal.classList.remove('active');
    document.body.style.overflow = '';
}


/* =========================================================
   LOKASI DAN RUTE (SATU PETA GOOGLE MAPS)
   Peta yang sama berganti dari "lokasi kost" ke "rute" lewat iframe.
========================================================= */
const mapFrame = $('mapFrame');
const embedAwal = @json($embedDefault);
const kostLat = parseFloat(koordinatKostAwal.latitude);
const kostLng = parseFloat(koordinatKostAwal.longitude);
const punyaKoordinat = Number.isFinite(kostLat) && Number.isFinite(kostLng);
const tujuan = punyaKoordinat ? kostLat + ',' + kostLng : alamatKost;

let userPos = null;
let rutaAktif = false;

function showMsg(text) {
    const box = $('routeMsg');
    if (!box) return;
    box.textContent = text || '';
    box.classList.toggle('active', !!text);
}

function setTabUI(rute) {
    $('tabLokasi').classList.toggle('on', !rute);
    $('tabRute').classList.toggle('on', rute);
}

function updateGmapsLink() {
    const a = $('btnGmaps');
    if (!a) return;

    a.href = userPos ?
        'https://www.google.com/maps/dir/?api=1&travelmode=driving&origin=' +
        userPos.latitude + ',' + userPos.longitude +
        '&destination=' + encodeURIComponent(tujuan) :
        'https://www.google.com/maps/search/?api=1&query=' + encodeURIComponent(tujuan);
}

/* Tab: Lokasi = peta kost, Rute = rute dari posisi pengguna */
function setTab(rute) {
    if (rute) {
        if (!rutaAktif) buatRute();
        else setTabUI(true);
    } else {
        resetRute();
    }
}

function resetRute() {
    rutaAktif = false;
    userPos = null;
    setTabUI(false);
    showMsg('');
    $('routeResult').classList.remove('active');
    $('btnRouteText').textContent = 'Gunakan lokasi saya';
    mapFrame.src = embedAwal;
    updateGmapsLink();
}

function ambilLokasiUser() {
    return new Promise((resolve, reject) => {
        if (!navigator.geolocation) {
            reject(new Error('Browser kamu belum mendukung fitur lokasi.'));
            return;
        }

        navigator.geolocation.getCurrentPosition(
            p => resolve({
                latitude: p.coords.latitude,
                longitude: p.coords.longitude
            }),
            error => {
                let pesan = 'Lokasi kamu belum bisa diambil. Coba lagi.';
                if (error.code === 1) pesan =
                    'Aktifkan izin lokasi di browser untuk melihat rute dari posisimu.';
                if (error.code === 2) pesan =
                    'Lokasi kamu tidak ditemukan. Pastikan GPS atau lokasi perangkat aktif.';
                if (error.code === 3) pesan = 'Pencarian lokasi terlalu lama. Coba lagi.';
                reject(new Error(pesan));
            }, {
                enableHighAccuracy: true,
                timeout: 15000,
                maximumAge: 0
            }
        );
    });
}

/* Ringkasan jarak dan waktu (OSRM, hanya angka; garis rute digambar Google) */
async function cariRingkasan(uLat, uLng) {
    const url = 'https://router.project-osrm.org/route/v1/driving/' +
        uLng + ',' + uLat + ';' + kostLng + ',' + kostLat + '?overview=false';

    const response = await fetch(url);
    if (!response.ok) throw new Error('OSRM tidak dapat dihubungi.');

    const data = await response.json();
    if (data.code !== 'Ok' || !data.routes || !data.routes.length) throw new Error('Rute tidak ditemukan.');

    return data.routes[0];
}

function formatDurasi(totalMinutes) {
    if (totalMinutes < 1) return '< 1 menit';

    const jam = Math.floor(totalMinutes / 60);
    const menit = totalMinutes % 60;

    if (jam > 0) return menit > 0 ? jam + ' jam ' + menit + ' menit' : jam + ' jam';
    return menit + ' menit';
}

async function buatRute() {
    const button = $('btnRoute');
    const buttonText = $('btnRouteText');
    const loading = $('routeLoading');

    showMsg('');
    $('routeResult').classList.remove('active');
    loading.classList.add('active');
    button.disabled = true;
    buttonText.textContent = 'Mencari rute...';
    setTabUI(true);

    try {
        const u = await ambilLokasiUser();
        userPos = u;
        rutaAktif = true;

        mapFrame.src = 'https://maps.google.com/maps?saddr=' + u.latitude + ',' + u.longitude +
            '&daddr=' + encodeURIComponent(tujuan) + '&dirflg=d&hl=id&output=embed';

        buttonText.textContent = 'Perbarui rute';
        updateGmapsLink();

        if (punyaKoordinat) {
            try {
                const r = await cariRingkasan(u.latitude, u.longitude);

                $('routeDistance').textContent =
                    (r.distance / 1000).toLocaleString('id-ID', {
                        minimumFractionDigits: 1,
                        maximumFractionDigits: 1
                    }) + ' km';
                $('routeDuration').textContent = formatDurasi(Math.round(r.duration / 60));
                $('routeResult').classList.add('active');
            } catch (e) {
                console.warn('Ringkasan rute:', e);
            }
        }

    } catch (error) {
        console.error('Rute error:', error);
        showMsg(error.message || 'Terjadi kesalahan saat membuat rute.');
        buttonText.textContent = 'Gunakan lokasi saya';
        if (!rutaAktif) setTabUI(false);

    } finally {
        loading.classList.remove('active');
        button.disabled = false;
    }
}

updateGmapsLink();
</script>
@endpush