@extends('layouts.admin')

@section('content')

<div class="p-6 space-y-6">

    {{-- =========================================================
        HEADER
    ========================================================== --}}
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5">

        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-[#EAF1EC] flex items-center justify-center shrink-0">
                <svg class="w-6 h-6 text-[#6C8B6B]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19.428 15.341A8 8 0 1 0 4.572 15.34M12 3v1m0 16v1m9-9h-1M4 12H3" />
                </svg>
            </div>

            <div>
                <h1 class="text-2xl font-bold text-[#0F0937]">
                    Detail Tagihan
                </h1>
                <p class="text-sm text-gray-500 mt-1">
                    Kelola tagihan dan riwayat pembayaran penghuni.
                </p>
            </div>
        </div>

        <a href="{{ route('admin.tagihan.index') }}" class="inline-flex items-center justify-center gap-2
                   bg-gray-100 hover:bg-gray-200
                   text-gray-700 px-5 py-3 rounded-2xl
                   font-semibold text-sm transition w-fit">

            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>

            Kembali
        </a>

    </div>


    {{-- =========================================================
        CARD PENGHUNI
    ========================================================== --}}
    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">

        <div class="flex items-center gap-4">

            {{-- Avatar --}}
            <div class="w-14 h-14 rounded-2xl bg-[#EAF1EC]
                        flex items-center justify-center shrink-0">
                <span class="text-xl font-bold text-[#6C8B6B]">
                    {{ strtoupper(substr($user->nama, 0, 1)) }}
                </span>
            </div>

            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">
                    Penghuni
                </p>

                <h2 class="text-xl font-bold text-[#0F0937] mt-1">
                    {{ $user->nama }}
                </h2>

                <p class="text-sm text-gray-500 mt-0.5">
                    {{ $user->username }}
                </p>
            </div>

        </div>

    </div>


    {{-- =========================================================
        LIST TAGIHAN
    ========================================================== --}}
    <div class="space-y-6">

        @forelse($items as $i)

        @php
        $totalBayar = $i->pembayaran
        ->where('status_validasi', 'diterima')
        ->sum('nominal_pembayaran');

        $sisa = ($i->hargaKamar?->harga ?? 0) - $totalBayar;

        $pembayaranTerakhir = $i->pembayaran
        ->sortByDesc('created_at')
        ->first();
        @endphp


        {{-- =====================================================
            CARD TAGIHAN
        ====================================================== --}}
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">

            {{-- HEADER TAGIHAN --}}
            <div class="px-6 py-5 border-b border-gray-100
                        flex flex-col sm:flex-row sm:items-center
                        sm:justify-between gap-4">

                <div class="flex items-center gap-3">

                    <div class="w-10 h-10 rounded-xl bg-[#F1F6F2]
                                flex items-center justify-center">
                        <svg class="w-5 h-5 text-[#6C8B6B]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 14l6-6m-5-5h8a2 2 0 012 2v14a2 2 0 01-2 2H6a2 2 0 01-2-2V5a2 2 0 012-2h4z" />
                        </svg>
                    </div>

                    <div>
                        <p class="text-xs text-gray-400">
                            Tagihan
                        </p>

                        <h3 class="text-lg font-bold text-[#0F0937]">
                            Kamar {{ $i->kamar?->nomor_kamar ?? '-' }}
                        </h3>
                    </div>

                </div>


                {{-- STATUS --}}
                <div>

                    @if($i->status_label === 'lunas')

                    <span class="inline-flex items-center gap-1.5
                                 px-3 py-1.5 rounded-full
                                 bg-green-100 text-green-700
                                 text-xs font-semibold">

                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                        Lunas
                    </span>

                    @elseif($i->status_label === 'telat')

                    <span class="inline-flex items-center gap-1.5
                                 px-3 py-1.5 rounded-full
                                 bg-red-100 text-red-700
                                 text-xs font-semibold">

                        <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                        Telat
                    </span>

                    @elseif($pembayaranTerakhir?->status_validasi === 'menunggu')

                    <span class="inline-flex items-center gap-1.5
                                 px-3 py-1.5 rounded-full
                                 bg-yellow-100 text-yellow-700
                                 text-xs font-semibold">

                        <span class="w-1.5 h-1.5 rounded-full bg-yellow-500"></span>
                        Menunggu Verifikasi
                    </span>

                    @elseif($pembayaranTerakhir?->status_validasi === 'ditolak')

                    <span class="inline-flex items-center gap-1.5
                                 px-3 py-1.5 rounded-full
                                 bg-red-100 text-red-700
                                 text-xs font-semibold">

                        <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                        Ditolak
                    </span>

                    @else

                    <span class="inline-flex items-center gap-1.5
                                 px-3 py-1.5 rounded-full
                                 bg-gray-100 text-gray-600
                                 text-xs font-semibold">

                        <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                        Belum Lunas
                    </span>

                    @endif

                </div>

            </div>


            {{-- =================================================
                INFORMASI TAGIHAN
            ================================================== --}}
            <div class="p-6">

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">


                    {{-- KAMAR --}}
                    <div class="bg-[#F8FAF8] rounded-2xl p-4">

                        <div class="flex items-center gap-2 mb-3">
                            <div class="w-8 h-8 rounded-lg bg-[#EAF1EC]
                                        flex items-center justify-center">
                                <svg class="w-4 h-4 text-[#6C8B6B]" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 21h18M5 21V7l7-4 7 4v14M9 21v-6h6v6" />
                                </svg>
                            </div>

                            <span class="text-xs text-gray-500">
                                Kamar
                            </span>
                        </div>

                        <p class="text-lg font-bold text-[#0F0937]">
                            {{ $i->kamar?->nomor_kamar ?? '-' }}
                        </p>

                    </div>


                    {{-- PERIODE --}}
                    <div class="bg-[#F8FAF8] rounded-2xl p-4">

                        <div class="flex items-center gap-2 mb-3">
                            <div class="w-8 h-8 rounded-lg bg-[#EAF1EC]
                                        flex items-center justify-center">
                                <svg class="w-4 h-4 text-[#6C8B6B]" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>

                            <span class="text-xs text-gray-500">
                                Periode
                            </span>
                        </div>

                        <p class="text-sm font-semibold text-[#0F0937]">
                            {{ $i->tanggal_mulai->format('d M Y') }}
                        </p>

                        <p class="text-xs text-gray-400 my-1">
                            sampai
                        </p>

                        <p class="text-sm font-semibold text-[#0F0937]">
                            {{ $i->tanggal_selesai->format('d M Y') }}
                        </p>

                    </div>


                    {{-- NOMINAL --}}
                    <div class="bg-[#F8FAF8] rounded-2xl p-4">

                        <div class="flex items-center gap-2 mb-3">
                            <div class="w-8 h-8 rounded-lg bg-[#EAF1EC]
                                        flex items-center justify-center">
                                <svg class="w-4 h-4 text-[#6C8B6B]" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3zm0 0V6m0 8v2m0 4a8 8 0 100-16 8 8 0 000 16z" />
                                </svg>
                            </div>

                            <span class="text-xs text-gray-500">
                                Nominal Tagihan
                            </span>
                        </div>

                        <p class="text-lg font-bold text-[#0F0937]">
                            Rp {{ number_format($i->hargaKamar?->harga ?? 0, 0, ',', '.') }}
                        </p>

                        <p class="text-xs text-gray-500 mt-2">
                            Dibayar:
                            <span class="font-semibold text-gray-700">
                                Rp {{ number_format($totalBayar, 0, ',', '.') }}
                            </span>
                        </p>

                        <p class="text-xs font-semibold text-red-500 mt-1">
                            Sisa:
                            Rp {{ number_format($sisa, 0, ',', '.') }}
                        </p>

                    </div>


                    {{-- STATUS --}}
                    <div class="bg-[#F8FAF8] rounded-2xl p-4">

                        <div class="flex items-center gap-2 mb-3">
                            <div class="w-8 h-8 rounded-lg bg-[#EAF1EC]
                                        flex items-center justify-center">
                                <svg class="w-4 h-4 text-[#6C8B6B]" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622C17.176 19.29 21 14.591 21 9c0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>

                            <span class="text-xs text-gray-500">
                                Status
                            </span>
                        </div>

                        @if($i->status_label === 'lunas')
                        <p class="text-lg font-bold text-green-600">
                            Lunas
                        </p>
                        @elseif($i->status_label === 'telat')
                        <p class="text-lg font-bold text-red-600">
                            Telat
                        </p>
                        @elseif($pembayaranTerakhir?->status_validasi === 'menunggu')
                        <p class="text-lg font-bold text-yellow-600">
                            Menunggu
                        </p>
                        @elseif($pembayaranTerakhir?->status_validasi === 'ditolak')
                        <p class="text-lg font-bold text-red-600">
                            Ditolak
                        </p>
                        @else
                        <p class="text-lg font-bold text-gray-600">
                            Belum Lunas
                        </p>
                        @endif

                    </div>

                </div>


                {{-- =================================================
                    RIWAYAT PEMBAYARAN
                ================================================== --}}
                <div class="mt-7 pt-6 border-t border-gray-100">

                    <div class="flex items-center justify-between mb-4">

                        <div>
                            <h4 class="text-base font-bold text-[#0F0937]">
                                Riwayat Pembayaran
                            </h4>

                            <p class="text-xs text-gray-400 mt-1">
                                Bukti pembayaran yang telah dikirim penghuni.
                            </p>
                        </div>

                        @if($i->pembayaran->count())
                        <span class="px-3 py-1.5 rounded-full
                                         bg-[#EAF1EC] text-[#5B765A]
                                         text-xs font-semibold">
                            {{ $i->pembayaran->count() }} Pembayaran
                        </span>
                        @endif

                    </div>


                    @if($i->pembayaran->count())

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">

                        @foreach($i->pembayaran->sortByDesc('created_at') as $p)

                        <div class="border border-gray-100 bg-gray-50/50
                                    rounded-2xl p-3
                                    flex flex-col gap-3
                                    hover:border-[#C9D9CC]
                                    hover:shadow-sm transition">


                            {{-- FOTO --}}
                            <button type="button" onclick="openImageModal('{{ asset('storage/' . $p->bukti_bayar) }}')"
                                class="relative block w-full aspect-[4/3]
                                       overflow-hidden rounded-xl
                                       border border-gray-200 bg-gray-100
                                       cursor-pointer group">

                                <img src="{{ asset('storage/' . $p->bukti_bayar) }}" alt="Bukti Pembayaran" class="w-full h-full object-cover
                                           group-hover:scale-105
                                           transition-transform duration-300">

                                <div class="absolute inset-0 bg-black/0
                                            group-hover:bg-black/20
                                            transition flex items-center
                                            justify-center">

                                    <div class="w-9 h-9 rounded-full
                                                bg-white/90
                                                opacity-0 group-hover:opacity-100
                                                transition
                                                flex items-center justify-center">

                                        <svg class="w-4 h-4 text-gray-700" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-4.35-4.35m2.35-5.65a8 8 0 11-16 0 8 8 0 0116 0z" />
                                        </svg>

                                    </div>

                                </div>

                            </button>


                            {{-- INFO --}}
                            <div>

                                <p class="text-sm font-bold text-[#0F0937]">
                                    Rp {{ number_format($p->nominal_pembayaran, 0, ',', '.') }}
                                </p>

                                <div class="flex items-center gap-1.5 mt-1 text-xs text-gray-400">

                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>

                                    {{ $p->tanggal_bayar?->format('d M Y') }}

                                    <span>•</span>

                                    {{ $p->tanggal_bayar?->format('H:i') }}

                                </div>

                            </div>


                            {{-- STATUS --}}
                            <div class="mt-auto">

                                @if($p->status_validasi === 'diterima')

                                <div class="flex items-center justify-center gap-1.5
                                            px-3 py-2 rounded-xl
                                            bg-green-50 text-green-700
                                            text-xs font-semibold">

                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                    Diterima

                                </div>

                                @elseif($p->status_validasi === 'ditolak')

                                <div class="flex items-center justify-center gap-1.5
                                            px-3 py-2 rounded-xl
                                            bg-red-50 text-red-700
                                            text-xs font-semibold">

                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                    Ditolak

                                </div>

                                @else

                                <div class="flex items-center justify-center gap-1.5
                                            px-3 py-2 rounded-xl
                                            bg-yellow-50 text-yellow-700
                                            text-xs font-semibold">

                                    <span class="w-1.5 h-1.5 rounded-full bg-yellow-500"></span>
                                    Menunggu

                                </div>

                                @endif


                                {{-- TOMBOL --}}
                                @if($p->status_validasi === 'menunggu')

                                <div class="grid grid-cols-2 gap-2 mt-2">

                                    <form method="POST"
                                        action="{{ route('admin.tagihan.validasi', $p->id_pembayaran) }}">
                                        @csrf

                                        <button type="submit" class="w-full bg-[#6C8B6B]
                                                   hover:bg-[#5B765A]
                                                   text-white py-2
                                                   rounded-xl text-xs
                                                   font-semibold transition">
                                            Validasi
                                        </button>

                                    </form>


                                    <form method="POST" action="{{ route('admin.tagihan.tolak', $p) }}">
                                        @csrf

                                        <button type="submit" class="w-full bg-red-500
                                                   hover:bg-red-600
                                                   text-white py-2
                                                   rounded-xl text-xs
                                                   font-semibold transition">
                                            Tolak
                                        </button>

                                    </form>

                                </div>

                                @endif

                            </div>

                        </div>

                        @endforeach

                    </div>

                    @else

                    <div class="rounded-2xl border border-dashed
                                border-gray-200 bg-gray-50
                                py-10 text-center">

                        <div class="w-12 h-12 mx-auto rounded-2xl
                                    bg-white border border-gray-100
                                    flex items-center justify-center mb-3">

                            <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 14h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h7l5 5v13a2 2 0 01-2 2z" />

                            </svg>

                        </div>

                        <p class="text-sm font-medium text-gray-500">
                            Belum ada bukti pembayaran.
                        </p>

                        <p class="text-xs text-gray-400 mt-1">
                            Penghuni belum mengirimkan bukti pembayaran untuk tagihan ini.
                        </p>

                    </div>

                    @endif

                </div>

            </div>

        </div>

        @empty

        {{-- EMPTY --}}
        <div class="bg-white rounded-3xl border border-gray-100
                    shadow-sm p-12 text-center">

            <div class="w-14 h-14 mx-auto rounded-2xl
                        bg-gray-50 border border-gray-100
                        flex items-center justify-center mb-4">

                <svg class="w-7 h-7 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 14h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h7l5 5v13a2 2 0 01-2 2z" />

                </svg>

            </div>

            <h3 class="text-base font-semibold text-gray-600">
                Belum ada data tagihan
            </h3>

            <p class="text-sm text-gray-400 mt-1">
                Belum terdapat tagihan yang tercatat untuk penghuni ini.
            </p>

        </div>

        @endforelse

    </div>

</div>


{{-- =============================================================
    MODAL PREVIEW BUKTI PEMBAYARAN
============================================================= --}}
<div id="imageModal" class="fixed inset-0 z-[9999] hidden items-center justify-center
           bg-black/75 backdrop-blur-sm p-5" onclick="closeImageModal(event)">

    <div class="relative inline-block max-w-5xl max-h-[90vh]" onclick="event.stopPropagation()">

        {{-- GAMBAR --}}
        <img id="modalImage" src="" alt="Bukti Pembayaran" class="max-w-full max-h-[85vh]
                   object-contain rounded-2xl
                   shadow-2xl bg-white">

        {{-- TOMBOL X --}}
        <button type="button" onclick="closeImageModal()" aria-label="Tutup gambar" class="absolute top-3 right-3
                   w-10 h-10 rounded-full
                   bg-white/95 text-gray-700
                   shadow-lg
                   hover:bg-gray-100
                   hover:scale-105
                   transition
                   flex items-center justify-center">

            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />

            </svg>

        </button>

    </div>
</div>


{{-- =============================================================
    JAVASCRIPT
============================================================= --}}
<script>
function openImageModal(imageUrl) {

    const modal = document.getElementById('imageModal');
    const image = document.getElementById('modalImage');

    image.src = imageUrl;

    modal.classList.remove('hidden');
    modal.classList.add('flex');

    document.body.classList.add('overflow-hidden');
}


function closeImageModal(event = null) {

    if (event && event.target !== event.currentTarget) {
        return;
    }

    const modal = document.getElementById('imageModal');
    const image = document.getElementById('modalImage');

    modal.classList.add('hidden');
    modal.classList.remove('flex');

    image.src = '';

    document.body.classList.remove('overflow-hidden');
}


// Tutup dengan ESC
document.addEventListener('keydown', function(event) {

    if (event.key === 'Escape') {
        closeImageModal();
    }

});
</script>

@endsection