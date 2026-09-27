@extends('layouts.penghuni')

@section('content')

{{-- =========================================================
    HEADER
========================================================= --}}
<div class="mb-6">

    <div class="flex items-center justify-between">

        <div>
            <h1 class="text-2xl font-bold text-[#0F0937]">
                Riwayat Pembayaran
            </h1>

            <p class="text-gray-500 mt-1 text-sm">
                Semua transaksi pembayaran kost anda.
            </p>
        </div>

    </div>


    {{-- =====================================================
        TABS
    ====================================================== --}}
    <div class="mt-6 flex items-center gap-8 border-b border-gray-200">

        {{-- TAGIHAN --}}
        <a href="{{ route('penghuni.pembayaran.index') }}" class="pb-3 text-sm font-semibold
                   text-gray-400
                   hover:text-[#6C8B6B]
                   border-b-2 border-transparent">
            Tagihan
        </a>


        {{-- RIWAYAT PEMBAYARAN --}}
        <a href="{{ route('penghuni.riwayat-pembayaran') }}" class="pb-3 text-sm font-semibold
                   border-b-2 border-[#6C8B6B]
                   text-[#6C8B6B]">
            Riwayat Pembayaran
        </a>

    </div>

</div>


{{-- =========================================================
    TABEL RIWAYAT PEMBAYARAN
========================================================= --}}
<div class="bg-white rounded-3xl
           shadow-sm border border-gray-100
           overflow-hidden">

    <div class="overflow-x-auto">

        <table class="w-full">

            {{-- =================================================
                HEADER TABLE
            ================================================== --}}
            <thead class="bg-[#F8F5F0]">

                <tr>

                    <th class="px-6 py-4 text-left
                               text-sm font-semibold text-gray-600">
                        Tanggal
                    </th>


                    <th class="px-6 py-4 text-left
                               text-sm font-semibold text-gray-600">
                        Periode
                    </th>


                    <th class="px-6 py-4 text-left
                               text-sm font-semibold text-gray-600">
                        Nominal
                    </th>


                    <th class="px-6 py-4 text-left
                               text-sm font-semibold text-gray-600">
                        Status
                    </th>


                    <th class="px-6 py-4 text-left
                               text-sm font-semibold text-gray-600">
                        Bukti
                    </th>

                </tr>

            </thead>


            {{-- =================================================
                BODY TABLE
            ================================================== --}}
            <tbody class="divide-y divide-gray-100">

                @forelse($items as $i)

                <tr class="hover:bg-gray-50">


                    {{-- =========================================
                        TANGGAL
                    ========================================== --}}
                    <td class="px-6 py-4">

                        {{ $i->tanggal_bayar?->format('d M Y H:i') }}

                    </td>


                    {{-- =========================================
                        PERIODE
                    ========================================== --}}
                    <td class="px-6 py-4">

                        {{ $i->tagihan?->tanggal_mulai?->format('d M Y') }}

                        -

                        {{ $i->tagihan?->tanggal_selesai?->format('d M Y') }}

                    </td>


                    {{-- =========================================
                        NOMINAL
                    ========================================== --}}
                    <td class="px-6 py-4
                               font-semibold text-[#0F0937]">

                        Rp
                        {{ number_format($i->nominal_pembayaran, 0, ',', '.') }}

                    </td>


                    {{-- =========================================
                        STATUS
                    ========================================== --}}
                    <td class="px-6 py-4">

                        @if($i->status_validasi === 'diterima')

                        <span class="px-3 py-1 rounded-full
                                   bg-green-100 text-green-700
                                   text-xs font-semibold">
                            Diterima
                        </span>


                        @elseif($i->status_validasi === 'ditolak')

                        <span class="px-3 py-1 rounded-full
                                   bg-red-100 text-red-700
                                   text-xs font-semibold">
                            Ditolak
                        </span>


                        @else

                        <span class="px-3 py-1 rounded-full
                                   bg-yellow-100 text-yellow-700
                                   text-xs font-semibold">
                            Menunggu
                        </span>

                        @endif

                    </td>


                    {{-- =========================================
                        BUKTI PEMBAYARAN
                    ========================================== --}}
                    <td class="px-6 py-4">

                        @if($i->bukti_bayar)

                        <button type="button" onclick="openImageModal('{{ asset('storage/' . $i->bukti_bayar) }}')"
                            class="block cursor-pointer">

                            <img src="{{ asset('storage/' . $i->bukti_bayar) }}" alt="Bukti Pembayaran" class="w-20 h-20 rounded-2xl
                                       object-cover border
                                       hover:scale-105
                                       transition-transform duration-200">

                        </button>

                        @endif

                    </td>

                </tr>


                @empty

                {{-- =============================================
                    DATA KOSONG
                ============================================== --}}
                <tr>

                    <td colspan="5" class="px-6 py-10
                               text-center text-gray-500">
                        Belum ada riwayat pembayaran.
                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>


{{-- =========================================================
    MODAL PREVIEW BUKTI PEMBAYARAN
========================================================= --}}
<div id="imageModal" class="fixed inset-0 z-[9999]
           hidden items-center justify-center
           bg-black/70 backdrop-blur-sm
           p-5" onclick="closeImageModal(event)">

    {{-- WRAPPER GAMBAR --}}
    <div class="relative inline-block
               max-w-4xl max-h-[90vh]" onclick="event.stopPropagation()">

        {{-- GAMBAR --}}
        <img id="modalImage" src="" alt="Bukti Pembayaran" class="max-w-full max-h-[85vh]
                   object-contain
                   rounded-2xl
                   shadow-2xl
                   bg-white">


        {{-- ================================================
            TOMBOL X
            MENEMPEL DI POJOK KANAN ATAS GAMBAR
        ================================================= --}}
        <button type="button" onclick="closeImageModal()" class="absolute top-3 right-3
                   w-9 h-9
                   rounded-full
                   bg-white/95
                   text-gray-700
                   text-xl font-bold
                   shadow-md
                   hover:bg-gray-100
                   transition
                   flex items-center justify-center">
            &times;
        </button>

    </div>

</div>


{{-- =========================================================
    JAVASCRIPT MODAL
========================================================= --}}
<script>
function openImageModal(imageUrl) {

    const modal = document.getElementById('imageModal');
    const image = document.getElementById('modalImage');

    image.src = imageUrl;

    modal.classList.remove('hidden');
    modal.classList.add('flex');

    document.body.classList.add('overflow-hidden');
}


function closeImageModal() {

    const modal = document.getElementById('imageModal');
    const image = document.getElementById('modalImage');

    modal.classList.add('hidden');
    modal.classList.remove('flex');

    image.src = '';

    document.body.classList.remove('overflow-hidden');
}


// Tutup menggunakan tombol ESC
document.addEventListener('keydown', function(event) {

    if (event.key === 'Escape') {

        closeImageModal();

    }

});
</script>

@endsection