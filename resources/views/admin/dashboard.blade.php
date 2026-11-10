@extends('layouts.admin')

@section('content')

{{-- ========================================================= --}}
{{-- HEADER --}}
{{-- ========================================================= --}}
<div class="mb-6 sm:mb-8">

    <h1 class="text-2xl sm:text-3xl font-bold text-[#0F0937]">Dashboard Admin Kost</h1>
    <p class="text-sm sm:text-base text-gray-500 mt-1 sm:mt-2">Kelola usaha kost anda dengan mudah.</p>
</div>

{{-- ========================================================= --}}
{{-- CARD STATISTIK --}}
{{-- Mobile : Nama Kost & Kode Undangan memanjang penuh, --}}
{{--          Total Kamar & Penghuni berdampingan --}}
{{-- ========================================================= --}}
<div class="grid grid-cols-2 xl:grid-cols-4 gap-3 sm:gap-6 mb-6 sm:mb-8">

    {{-- NAMA KOST --}}
    <div
        class="col-span-2 sm:col-span-1 bg-yellow-50 rounded-2xl p-4 sm:p-6 shadow-sm border border-yellow-100 min-w-0">
        <p class="text-xs sm:text-sm text-yellow-600">Nama Kost</p>
        <h2 class="text-lg sm:text-xl font-bold text-yellow-800 mt-1 sm:mt-2 break-words">
            {{ $kost?->nama_kost ?? '-' }}
        </h2>
    </div>

    {{-- KODE UNDANGAN --}}
    <div
        class="col-span-2 sm:col-span-1 bg-[#FFF8F0] rounded-2xl p-4 sm:p-6 shadow-sm border border-orange-100 overflow-hidden min-w-0">
        <div class="flex items-center sm:items-start justify-between gap-3">

            {{-- KIRI --}}
            <div class="min-w-0">
                <p class="text-xs sm:text-sm text-orange-600">
                    Kode Undangan
                </p>

                <h2 id="kodeUndangan"
                    class="text-lg sm:text-xl font-bold text-orange-800 mt-1 sm:mt-4 tracking-wide break-all">
                    {{ $kost?->kode_undangan ?? '-' }}
                </h2>
            </div>

            {{-- KANAN: tombol berjajar di mobile, bertumpuk di sm+ --}}
            <div class="flex items-center gap-2 shrink-0 sm:flex-col sm:items-end sm:gap-3">

                {{-- COPY --}}
                <button type="button" onclick="copyKodeUndangan()"
                    class="bg-[#6C8B6B] hover:bg-[#5B765A] text-white px-4 py-2 rounded-xl text-sm font-semibold transition">
                    Copy
                </button>

                {{-- REFRESH --}}
                <form method="POST" action="{{ route('admin.kost.refresh-kode') }}" class="inline">
                    @csrf
                    <button type="submit"
                        class="w-10 h-10 sm:w-auto sm:h-auto sm:p-2 flex items-center justify-center rounded-xl bg-yellow-100 hover:bg-yellow-200 text-yellow-700 transition"
                        title="Refresh Kode" aria-label="Refresh kode undangan">

                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                    </button>
                </form>

            </div>
        </div>
    </div>

    {{-- TOTAL KAMAR --}}
    <div class="bg-green-50 rounded-2xl p-4 sm:p-6 shadow-sm border border-green-100 min-w-0">
        <p class="text-xs sm:text-sm text-green-600">Total Kamar</p>
        <h2 class="text-2xl sm:text-3xl font-bold text-green-800 mt-1 sm:mt-2">{{ $totalKamar ?? 0 }}</h2>
    </div>

    {{-- TOTAL PENGHUNI --}}
    <div class="bg-blue-50 rounded-2xl p-4 sm:p-6 shadow-sm border border-blue-100 min-w-0">
        <p class="text-xs sm:text-sm text-blue-600">Penghuni</p>
        <h2 class="text-2xl sm:text-3xl font-bold text-blue-800 mt-1 sm:mt-2">{{ $totalPenghuni ?? 0 }}</h2>
    </div>

</div>

{{-- ========================================================= --}}
{{-- DASHBOARD BAWAH --}}
{{-- ========================================================= --}}
<div class="grid grid-cols-1 xl:grid-cols-2 gap-4 sm:gap-6">

    {{-- ========================================================= --}}
    {{-- PEMBAYARAN TERBARU --}}
    {{-- ========================================================= --}}
    <div class="bg-white rounded-2xl p-4 sm:p-8 shadow-sm border border-gray-100 min-w-0">

        <div class="mb-4 sm:mb-6">
            <h2 class="text-lg sm:text-xl font-bold text-[#0F0937]">Pembayaran Terbaru</h2>
            <p class="text-xs sm:text-sm text-gray-500 mt-1">Pembayaran yang menunggu verifikasi admin.</p>
        </div>

        @forelse($pembayaranTerbaru ?? [] as $item)

        {{-- Mobile: info di atas, nominal + status di bawah | sm+: kiri-kanan --}}
        <div class="flex flex-col gap-2 py-4 border-b border-gray-100 last:border-0
                    sm:flex-row sm:items-center sm:justify-between sm:gap-4">

            {{-- KIRI --}}
            <div class="min-w-0">
                <h3 class="font-semibold text-sm sm:text-base text-[#0F0937] break-words">
                    {{ $item->tagihan?->user?->nama }}
                </h3>
                <p class="text-xs sm:text-sm text-gray-500 mt-1">
                    Kamar {{ $item->tagihan?->kamar?->nomor_kamar }}
                </p>
                <p class="text-xs text-gray-400 mt-1">
                    {{ $item->tanggal_bayar?->format('d M Y') ?? '-' }}
                </p>
            </div>

            {{-- KANAN --}}
            <div class="flex items-center justify-between gap-3 sm:block sm:text-right shrink-0">

                <h3 class="font-bold text-sm sm:text-base text-[#0F0937] whitespace-nowrap">
                    Rp {{ number_format($item->nominal_pembayaran ?? 0, 0, ',', '.') }}
                </h3>

                @if($item->status_validasi === 'menunggu')

                <span
                    class="inline-flex sm:mt-2 px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700 whitespace-nowrap">
                    Menunggu Verifikasi
                </span>

                @endif

            </div>
        </div>

        @empty

        <div class="text-center py-8 sm:py-10 text-sm text-gray-400">Belum ada pembayaran terbaru.</div>

        @endforelse

        <div class="mt-4 sm:mt-6">
            <a href="{{ route('admin.tagihan.index') }}" class="text-sm font-semibold text-[#6C8B6B] hover:underline">
                Lihat Semua
            </a>
        </div>
    </div>

    {{-- ========================================================= --}}
    {{-- ADUAN TERBARU --}}
    {{-- ========================================================= --}}
    <div class="bg-white rounded-2xl p-4 sm:p-8 shadow-sm border border-gray-100 min-w-0">

        <div class="mb-4 sm:mb-6">
            <h2 class="text-lg sm:text-xl font-bold text-[#0F0937]">Aduan Terbaru</h2>
            <p class="text-xs sm:text-sm text-gray-500 mt-1">Keluhan terbaru dari penghuni kost.</p>
        </div>

        @forelse($aduanTerbaru ?? [] as $item)
        <div class="py-4 border-b border-gray-100 last:border-0">

            <div class="flex items-start justify-between gap-3">
                <h3 class="font-semibold text-sm sm:text-base text-[#0F0937] min-w-0 break-words">
                    {{ $item->user?->nama }}
                </h3>

                @if($item->status === 'selesai')
                <span
                    class="inline-flex shrink-0 px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">Selesai</span>
                @elseif($item->status === 'baru')
                <span
                    class="inline-flex shrink-0 px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">Baru</span>
                @else
                <span
                    class="inline-flex shrink-0 px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">{{ $item->status }}</span>
                @endif
            </div>

            <p class="text-xs sm:text-sm text-gray-500 mt-2 line-clamp-2">{{ $item->isi_aduan }}</p>
        </div>
        @empty
        <div class="text-center py-8 sm:py-10 text-sm text-gray-400">Belum ada aduan terbaru.</div>
        @endforelse

        <div class="mt-4 sm:mt-6">
            <a href="{{ route('admin.aduan.index') }}" class="text-sm font-semibold text-[#6C8B6B] hover:underline">
                Lihat Semua
            </a>
        </div>
    </div>

</div>

<script>
function copyKodeUndangan() {
    const kode = document.getElementById('kodeUndangan').innerText.trim();

    function berhasil() {
        alert('Kode undangan berhasil disalin!');
    }

    // Fallback untuk koneksi non-HTTPS / browser lama
    function salinManual() {
        const input = document.createElement('textarea');
        input.value = kode;
        input.style.position = 'fixed';
        input.style.opacity = '0';
        document.body.appendChild(input);
        input.select();

        try {
            document.execCommand('copy');
            berhasil();
        } catch (e) {
            alert('Gagal menyalin kode. Silakan salin manual.');
        }

        document.body.removeChild(input);
    }

    if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard.writeText(kode).then(berhasil).catch(salinManual);
    } else {
        salinManual();
    }
}
</script>

@endsection