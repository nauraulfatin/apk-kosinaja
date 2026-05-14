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

/* ====== KOLOM KIRI ====== */

/* GALERI */
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

/* LOKASI */
.lokasi-alamat {
    display: flex;
    align-items: flex-start;
    gap: 8px;
    font-size: 0.88rem;
    color: #4a5e4c;
    margin-bottom: 12px;
}

.lokasi-alamat svg {
    width: 15px;
    height: 15px;
    fill: #6C8B6B;
    flex-shrink: 0;
    margin-top: 2px;
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

/* ====== KOLOM KANAN (STICKY CARD) ====== */
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
    border: 1px solid #E8EFE9;
    border-radius: 20px;
    padding: 24px;
    box-shadow: 0 2px 12px rgba(26, 47, 36, 0.06);
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

.btn-wa-full {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    width: 100%;
    padding: 14px;
    border-radius: 14px;
    background: #6C8B6B;
    color: #fff;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-weight: 700;
    font-size: 0.95rem;
    text-decoration: none;
    margin-top: 16px;
    transition: background .2s, transform .2s;
    box-shadow: 0 6px 20px rgba(108, 139, 107, .25);
}

.btn-wa-full:hover {
    background: #5a7a59;
    transform: translateY(-2px);
}

.btn-wa-full svg {
    width: 20px;
    height: 20px;
    fill: #fff;
    flex-shrink: 0;
}

.btn-telp-full {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    width: 100%;
    padding: 12px;
    border-radius: 14px;
    background: #F0F5F1;
    color: #1F3A2C;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-weight: 700;
    font-size: 0.9rem;
    text-decoration: none;
    margin-top: 10px;
    border: 1px solid #E0EBE2;
    transition: background .2s;
}

.btn-telp-full:hover {
    background: #E2EDE3;
}

.btn-telp-full svg {
    width: 18px;
    height: 18px;
    fill: #6C8B6B;
    flex-shrink: 0;
}

.hubungi-note {
    font-size: 0.75rem;
    color: #8a9e8c;
    text-align: center;
    margin-top: 12px;
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
    max-width: 90vw;
    max-height: 90vh;
    border-radius: 16px;
    object-fit: contain;
}

.modal-close {
    position: absolute;
    top: 20px;
    right: 24px;
    color: white;
    font-size: 1.8rem;
    cursor: pointer;
    background: rgba(255, 255, 255, .15);
    border: none;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background .2s;
}

.modal-close:hover {
    background: rgba(255, 255, 255, .25);
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
$fotoUtama = ($kost->foto_kost && count($kost->foto_kost) > 0)
? Storage::url($kost->foto_kost[0])
: 'https://images.unsplash.com/photo-1555854877-bab0e564b8d5?w=800&q=80';

$galeri = $kost->foto_kost ?? [];
$kamarKosong = $kost->kamars->where('status', 'kosong')->count();
$hargaMulai = $kost->kamars
->flatMap(fn($k) => $k->hargaKamars)
->where('isactive', true)
->min('harga');
@endphp

<div class="detail-wrap">

    {{-- BREADCRUMB --}}
    <div class="breadcrumb">
        <a href="{{ route('home') }}">Beranda</a> › Detail Kost
    </div>

    <div class="detail-layout">

        {{-- ===== KOLOM KIRI ===== --}}
        <div>

            {{-- GALERI --}}
            <div class="galeri-grid">
                <div class="galeri-main">
                    <img src="{{ $fotoUtama }}" alt="{{ $kost->nama_kost }}" onclick="bukaModal('{{ $fotoUtama }}')">
                </div>
                <div class="galeri-side">
                    @php $galeriSide = array_slice($galeri, 1, 2); @endphp
                    @forelse($galeriSide as $foto)
                    <img src="{{ Storage::url($foto) }}" alt="Foto" onclick="bukaModal('{{ Storage::url($foto) }}')">
                    @empty
                    <div style="height:98px;background:#F0F5F1;border-radius:14px;"></div>
                    <div style="height:98px;background:#F0F5F1;border-radius:14px;"></div>
                    @endforelse

                    @if(count($galeri) > 3)
                    <div class="galeri-more" onclick="bukaModal('{{ Storage::url($galeri[3]) }}')">
                        <img src="{{ Storage::url($galeri[3]) }}" alt="Foto">
                        <span>+{{ count($galeri) - 3 }} Foto</span>
                    </div>
                    @else
                    <div style="height:98px;background:#F0F5F1;border-radius:14px;"></div>
                    @endif
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

            {{-- FASILITAS UMUM --}}
            @if($kost->fasilitas && $kost->fasilitas->count() > 0)
            <div class="section-box">
                <div class="section-title">Fasilitas Umum</div>
                <div class="fasilitas-grid">
                    @foreach($kost->fasilitas as $f)
                    <div class="fasilitas-chip">
                        <svg viewBox="0 0 24 24">
                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z" />
                        </svg>
                        {{ $f->nama_fasilitas }}
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- LOKASI --}}
            @if($kost->lokasi)
            <div class="section-box">
                <div class="section-title">Lokasi</div>
                <div class="lokasi-alamat">
                    <svg viewBox="0 0 24 24">
                        <path
                            d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5S10.62 6.5 12 6.5 14.5 7.62 14.5 9 13.38 11.5 12 11.5z" />
                    </svg>
                    {{ $kost->lokasi }}
                </div>
            </div>
            @endif

            {{-- DAFTAR KAMAR --}}
            <div class="section-box">
                <div class="section-title">Daftar Kamar</div>
                <p class="section-sub">Pilih kamar yang sesuai dengan kebutuhan Anda</p>

                @forelse($kost->kamars as $kamar)
                @php
                $fotoKamar = ($kamar->foto_kamar && count($kamar->foto_kamar) > 0)
                ? Storage::url($kamar->foto_kamar[0])
                : null;
                $hargaKamar = $kamar->hargaKamars->where('isactive', true)->first();
                @endphp
                <div class="kamar-item">

                    @if($fotoKamar)
                    <img src="{{ $fotoKamar }}" alt="{{ $kamar->nama_kamar }}" class="kamar-foto">
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
                            @if($kamar->nomor_kamar)
                            - No. {{ $kamar->nomor_kamar }}
                            @endif
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

            {{-- SEMUA FOTO --}}
            @if(count($galeri) > 1)
            <div id="semua-foto" class="section-box">
                <div class="section-title">Semua Foto</div>
                <div class="foto-grid">
                    @foreach($galeri as $foto)
                    <img src="{{ Storage::url($foto) }}" onclick="bukaModal('{{ Storage::url($foto) }}')">
                    @endforeach
                </div>
            </div>
            @endif

        </div>
        {{-- akhir kolom kiri --}}

        {{-- ===== KOLOM KANAN (STICKY) ===== --}}
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

                @if($kost->user && $kost->user->no_telepon)
                @php
                $noWa = '62' . ltrim(preg_replace('/[^0-9]/', '', $kost->user->no_telepon), '0');
                @endphp
                <a href="https://wa.me/{{ $noWa }}?text=Halo,%20saya%20tertarik%20dengan%20{{ urlencode($kost->nama_kost) }}"
                    target="_blank" class="btn-wa-full">
                    <svg viewBox="0 0 24 24">
                        <path
                            d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                    </svg>
                    Chat via WhatsApp
                </a>

                <a href="tel:{{ $kost->user->no_telepon }}" class="btn-telp-full">
                    <svg viewBox="0 0 24 24">
                        <path
                            d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z" />
                    </svg>
                    {{ $kost->user->no_telepon }}
                </a>

                <p class="hubungi-note">⏱ Biasanya membalas dalam beberapa menit</p>
                @else
                <p class="hubungi-note" style="margin-top:16px;">
                    Hubungi kami melalui halaman
                    <a href="{{ route('hubungi') }}" style="color:#6C8B6B;font-weight:700;">Hubungi</a>
                </p>
                @endif
            </div>

            {{-- PEMILIK CARD --}}
            <div
                style="background:#fff;border:1px solid #E8EFE9;border-radius:20px;padding:20px;box-shadow:0 2px 12px rgba(26,47,36,.05);">

                <p
                    style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:1rem;color:#1F3A2C;margin-bottom:16px;">
                    Pemilik Kost
                </p>

                {{-- Avatar + Nama --}}
                <div style="display:flex;align-items:center;gap:16px;margin-bottom:20px;">
                    <div
                        style="width:56px;height:56px;border-radius:50%;background:#D6E5D6;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <svg style="width:32px;height:32px;" fill="#6C8B6B" viewBox="0 0 24 24">
                            <path
                                d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z" />
                        </svg>
                    </div>
                    <div>
                        <div
                            style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:0.95rem;color:#1F3A2C;">
                            {{ $kost->user->name }}
                        </div>
                        <div style="font-size:12px;color:#8a9e8c;margin-top:2px;">
                            Bergabung sejak {{ $kost->user->created_at->format('Y') }}
                        </div>
                    </div>
                </div>

                {{-- Responsif Box --}}
                <div
                    style="background:#F5FAF5;border:1px solid #E0EBE2;border-radius:12px;padding:16px;margin-bottom:20px;">
                    <p
                        style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:0.82rem;color:#1F3A2C;margin-bottom:12px;">
                        Responsif
                    </p>
                    <div style="display:flex;align-items:center;gap:8px;margin-bottom:10px;">
                        <svg style="width:16px;height:16px;flex-shrink:0;" fill="none" stroke="#6C8B6B" stroke-width="2"
                            viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10" />
                            <path stroke-linecap="round" d="M12 6v6l4 2" />
                        </svg>
                        <div>
                            <span style="font-size:12px;color:#4a5e4c;font-weight:600;">Waktu respon
                                rata-rata</span><br>
                            <span style="font-size:11px;color:#6C8B6B;font-weight:700;">30 Menit</span>
                        </div>
                    </div>
                    <div style="display:flex;align-items:center;gap:8px;">
                        <svg style="width:16px;height:16px;flex-shrink:0;" fill="#6C8B6B" viewBox="0 0 24 24">
                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z" />
                        </svg>
                        <span style="font-size:12px;color:#4a5e4c;font-weight:600;">98% chat dibalas</span>
                    </div>
                </div>

                <div style="height:1px;background:#F0F5F1;margin-bottom:16px;"></div>

                <p
                    style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:0.82rem;color:#1F3A2C;margin-bottom:12px;">
                    Hubungi Langsung
                </p>

                {{-- Tombol WA --}}
                @if($kost->user && $kost->user->no_telepon)
                @php
                $noWaCard = '62' . ltrim(preg_replace('/[^0-9]/', '', $kost->user->no_telepon), '0');
                @endphp
                <a href="https://wa.me/{{ $noWaCard }}?text=Halo,%20saya%20tertarik%20dengan%20{{ urlencode($kost->nama_kost) }}"
                    target="_blank"
                    style="display:flex;align-items:center;justify-content:center;gap:10px;width:100%;text-decoration:none;font-weight:700;font-size:0.85rem;color:#fff;border-radius:12px;padding:12px;background:#6C8B6B;margin-bottom:10px;transition:background .2s;"
                    onmouseover="this.style.background='#5a7a59'" onmouseout="this.style.background='#6C8B6B'">
                    <svg style="width:20px;height:20px;flex-shrink:0;" fill="white" viewBox="0 0 24 24">
                        <path
                            d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                    </svg>
                    Chat Whatsapp
                </a>
                @endif

                {{-- Tombol Email --}}
                @if($kost->user && $kost->user->email)
                <a href="mailto:{{ $kost->user->email }}"
                    style="display:flex;align-items:center;justify-content:center;gap:10px;width:100%;text-decoration:none;font-weight:700;font-size:0.85rem;color:#fff;border-radius:12px;padding:12px;background:#6C8B6B;transition:background .2s;"
                    onmouseover="this.style.background='#5a7a59'" onmouseout="this.style.background='#6C8B6B'">
                    <svg style="width:20px;height:20px;flex-shrink:0;" fill="white" viewBox="0 0 24 24">
                        <path
                            d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z" />
                    </svg>
                    Kirim Email
                </a>
                @endif

            </div>
            {{-- akhir pemilik card --}}

        </div>
        {{-- akhir kolom kanan --}}

    </div>
    {{-- akhir detail-layout --}}

    {{-- MODAL FOTO --}}
    <div class="modal-foto" id="modalFoto" onclick="tutupModal()">
        <button class="modal-close" onclick="tutupModal()">✕</button>
        <img id="modalImg" src="" alt="Foto">
    </div>

    <script>
    function bukaModal(src) {
        document.getElementById('modalImg').src = src;
        document.getElementById('modalFoto').classList.add('active');
    }

    function tutupModal() {
        document.getElementById('modalFoto').classList.remove('active');
    }
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') tutupModal();
    });
    </script>

</div>

@endsection