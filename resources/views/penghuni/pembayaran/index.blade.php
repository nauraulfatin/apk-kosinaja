@extends('layouts.penghuni')
@section('content')

@php
$grouped = $tagihanAktif->groupBy(fn($i) => $i->tanggal_mulai->format('F Y'));
@endphp

{{-- HEADER --}}
<div class="mb-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-[#0F0937]">Pembayaran Saya</h1>
            <p class="text-gray-500 mt-1 text-sm">Kelola tagihan dan pembayaran kost anda.</p>
        </div>

        <button onclick="openModal()"
            class="bg-[#6C8B6B] hover:bg-[#5B765A] text-white px-5 py-2.5 rounded-2xl font-semibold transition text-sm">
            + Bayar Tagihan
        </button>
    </div>

    {{-- TABS --}}
    <div class="mt-6 flex items-center gap-8 border-b border-gray-200">
        <a href="{{ route('penghuni.pembayaran.index') }}"
            class="pb-3 text-sm font-semibold border-b-2 border-[#6C8B6B] text-[#6C8B6B]">
            Tagihan
        </a>

        <a href="{{ route('penghuni.riwayat-pembayaran') }}"
            class="pb-3 text-sm font-semibold text-gray-400 hover:text-[#6C8B6B] border-b-2 border-transparent">
            Riwayat Pembayaran
        </a>
    </div>
</div>


{{-- ========================================================= --}}
{{-- DAFTAR TAGIHAN GROUPED BY BULAN --}}
{{-- ========================================================= --}}

<div class="space-y-6">

    @forelse($grouped as $bulan => $tagihanBulan)

    <div>

        {{-- LABEL BULAN --}}
        <div class="flex items-center gap-3 mb-3">
            <span class="text-xs font-semibold text-gray-400 uppercase tracking-widest">
                {{ $bulan }}
            </span>

            <div class="flex-1 h-px bg-gray-100"></div>
        </div>


        {{-- CARD TIAP TAGIHAN --}}
        <div class="space-y-2">

            @foreach($tagihanBulan as $i)

            @php
            $totalDibayar = $i->pembayaran
            ->where('status_validasi', 'diterima')
            ->sum('nominal_pembayaran');

            $totalTagihan = $i->hargaKamar?->harga ?? 0;

            $sisa = $totalTagihan - $totalDibayar;
            @endphp


            <div class="bg-white border border-gray-100 rounded-2xl overflow-hidden">

                {{-- BARIS RINGKAS --}}
                <button type="button" onclick="toggleDetail('detail-{{ $i->id_tagihan }}')"
                    class="w-full flex items-center justify-between px-5 py-4 hover:bg-gray-50 transition text-left">

                    <div>
                        <div class="text-sm font-semibold text-[#0F0937]">
                            {{ $i->tanggal_mulai->format('d M') }}
                            –
                            {{ $i->tanggal_selesai->format('d M Y') }}
                        </div>

                        <div class="text-xs text-gray-400 mt-0.5">
                            Jatuh tempo:
                            {{ $i->tanggal_jatuh_tempo?->format('d M Y') ?? '-' }}
                        </div>
                    </div>


                    <div class="flex items-center gap-3">

                        <span class="text-sm font-semibold text-[#0F0937]">
                            Rp {{ number_format($totalTagihan, 0, ',', '.') }}
                        </span>


                        @if($i->status_label === 'lunas')

                        <span class="text-xs px-3 py-1 rounded-full bg-green-100 text-green-700 font-semibold">
                            Lunas
                        </span>

                        @elseif($i->status_label === 'menunggu_verifikasi')

                        <span class="text-xs px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 font-semibold">
                            Menunggu Verifikasi
                        </span>

                        @elseif($i->status_label === 'telat')

                        <span class="text-xs px-3 py-1 rounded-full bg-red-100 text-red-700 font-semibold">
                            Telat
                        </span>

                        @elseif($i->status_label === 'ditolak')

                        <span class="text-xs px-3 py-1 rounded-full bg-red-100 text-red-700 font-semibold">
                            Ditolak
                        </span>

                        @else

                        <span class="text-xs px-3 py-1 rounded-full bg-gray-100 text-gray-600 font-semibold">
                            Belum Lunas
                        </span>

                        @endif


                        <svg id="chevron-{{ $i->id_tagihan }}" xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4 text-gray-400 transition-transform duration-200" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />

                        </svg>

                    </div>

                </button>


                {{-- DETAIL --}}
                <div id="detail-{{ $i->id_tagihan }}" class="hidden border-t border-gray-100 bg-[#FDFBF7] px-5 py-4">

                    <div class="space-y-2 text-sm">

                        <div class="flex justify-between">
                            <span class="text-gray-500">
                                Total tagihan
                            </span>

                            <span class="font-semibold text-[#0F0937]">
                                Rp {{ number_format($totalTagihan, 0, ',', '.') }}
                            </span>
                        </div>


                        <div class="flex justify-between">
                            <span class="text-gray-500">
                                Sudah dibayar
                            </span>

                            <span class="font-semibold text-green-600">
                                Rp {{ number_format($totalDibayar, 0, ',', '.') }}
                            </span>
                        </div>


                        <div class="flex justify-between">
                            <span class="text-gray-500">
                                Sisa
                            </span>

                            <span class="font-semibold {{ $sisa > 0 ? 'text-red-500' : 'text-gray-400' }}">
                                Rp {{ number_format($sisa, 0, ',', '.') }}
                            </span>
                        </div>


                        @if($i->status_label === 'menunggu_verifikasi')

                        <div
                            class="mt-3 pt-3 border-t border-gray-100 text-xs text-yellow-700 bg-yellow-50 rounded-xl px-3 py-2">
                            Pembayaran sedang dicek oleh admin.
                        </div>

                        @elseif($i->status_label === 'ditolak')

                        <div
                            class="mt-3 pt-3 border-t border-gray-100 text-xs text-red-600 bg-red-50 rounded-xl px-3 py-2">
                            Pembayaran ditolak. Silakan upload ulang bukti pembayaran.
                        </div>

                        @elseif($totalDibayar > 0 && $sisa > 0)

                        <div class="mt-3 pt-3 border-t border-gray-100 text-xs text-[#6C8B6B] font-semibold">
                            Pembayaran dicicil.
                        </div>

                        @endif

                    </div>

                </div>

            </div>

            @endforeach

        </div>

    </div>

    @empty

    <div class="bg-white border border-gray-100 rounded-2xl px-6 py-10 text-center text-gray-400 text-sm">
        Belum ada tagihan.
    </div>

    @endforelse

</div>



{{-- ========================================================= --}}
{{-- MODAL BAYAR --}}
{{-- ========================================================= --}}

<div id="modal-bayar" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50 px-4">

    <div class="bg-white rounded-3xl w-full max-w-xl p-8 relative">

        <button onclick="closeModal()" class="absolute top-5 right-5 text-gray-400 hover:text-black">
            ✕
        </button>


        <h2 class="text-2xl font-bold text-[#0F0937]">
            Bayar Tagihan
        </h2>

        <p class="text-gray-500 mt-2 text-sm">
            Upload pembayaran tagihan kost anda.
        </p>


        <form method="POST" enctype="multipart/form-data" action="{{ route('penghuni.pembayaran.store') }}"
            class="space-y-5 mt-8">

            @csrf


            {{-- PILIH TAGIHAN --}}
            <div>

                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Pilih Tagihan
                </label>


                <select name="id_tagihan" required class="w-full border border-gray-300 rounded-2xl px-4 py-3">

                    <option value="">
                        -- Pilih Tagihan --
                    </option>


                    @foreach($tagihanAktif as $t)

                    @php

                    $dibayar = $t->pembayaran
                    ->where('status_validasi', 'diterima')
                    ->sum('nominal_pembayaran');

                    $sisa = ($t->hargaKamar?->harga ?? 0) - $dibayar;

                    @endphp


                    @if(in_array($t->status_label, ['pending', 'telat', 'ditolak'], true))

                    <option value="{{ $t->id_tagihan }}">

                        {{ $t->tanggal_mulai->format('d M Y') }}
                        -
                        {{ $t->tanggal_selesai->format('d M Y') }}

                        | Sisa:
                        Rp {{ number_format($sisa, 0, ',', '.') }}

                    </option>

                    @endif

                    @endforeach

                </select>

            </div>



            {{-- NOMINAL PEMBAYARAN --}}
            <div>

                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Nominal Pembayaran
                </label>


                <input type="number" name="nominal_pembayaran" required min="1000"
                    class="w-full border border-gray-300 rounded-2xl px-4 py-3" placeholder="Masukkan nominal">

            </div>



            {{-- ================================================= --}}
            {{-- BUKTI PEMBAYARAN --}}
            {{-- ================================================= --}}

            <div>

                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Bukti Pembayaran
                </label>


                <label for="bukti_bayar"
                    class="flex items-center px-5 py-4 border border-gray-300 rounded-2xl cursor-pointer hover:border-[#6C8B6B] transition">

                    <span class="bg-[#6C8B6B] text-white px-4 py-2 rounded-xl text-sm font-semibold">
                        Pilih File
                    </span>


                    <p id="file-name" class="text-sm text-gray-500 ml-4 truncate">
                        Belum ada file
                    </p>

                </label>


                <input type="file" name="bukti_bayar" id="bukti_bayar" accept=".jpg,.jpeg,.png" class="hidden" required>


                {{-- INFO FORMAT DAN UKURAN --}}
                <p class="text-xs text-gray-500 mt-2">
                    Format: JPG, JPEG, PNG.
                    <strong>Maksimal ukuran file 10 MB.</strong>
                </p>


                {{-- ERROR FILE --}}
                <p id="file-error" class="hidden text-xs text-red-600 mt-2 font-medium">
                </p>


                {{-- PREVIEW BUTTON --}}
                <button type="button" id="preview-button"
                    class="hidden mt-3 text-sm font-semibold text-[#6C8B6B] hover:underline">

                    Lihat Bukti Pembayaran

                </button>


                @error('bukti_bayar')

                <p class="text-xs text-red-600 mt-2 font-medium">
                    {{ $message }}
                </p>

                @enderror

            </div>



            {{-- BUTTON --}}
            <div class="flex gap-3 pt-2">

                <button type="button" onclick="closeModal()"
                    class="flex-1 border border-gray-300 py-3 rounded-2xl font-semibold text-sm">

                    Kembali

                </button>


                <button type="submit"
                    class="flex-1 bg-[#6C8B6B] hover:bg-[#5B765A] text-white py-3 rounded-2xl font-semibold transition text-sm">

                    Bayar

                </button>

            </div>

        </form>

    </div>

</div>



{{-- ========================================================= --}}
{{-- MODAL PREVIEW BUKTI PEMBAYARAN --}}
{{-- ========================================================= --}}

<div id="image-modal" class="fixed inset-0 bg-black/70 hidden items-center justify-center z-[60] px-4">

    <div class="relative bg-white rounded-2xl p-4 max-w-lg w-full shadow-xl">

        {{-- CLOSE --}}
        <button type="button" id="close-image-modal"
            class="absolute -top-3 -right-3 w-9 h-9 bg-white rounded-full shadow flex items-center justify-center text-gray-600 hover:text-red-500 text-xl z-10">

            &times;

        </button>


        <h3 class="text-lg font-semibold text-gray-800 mb-4">

            Preview Bukti Pembayaran

        </h3>


        <div class="flex justify-center">

            <img id="preview-image" src="" alt="Preview Bukti Pembayaran"
                class="max-h-[70vh] max-w-full rounded-xl object-contain">

        </div>

    </div>

</div>



{{-- ========================================================= --}}
{{-- JAVASCRIPT --}}
{{-- ========================================================= --}}

<script>
// =========================================================
// DETAIL TAGIHAN
// =========================================================

function toggleDetail(id) {

    const detail = document.getElementById(id);

    const tagId = id.replace('detail-', '');

    const chevron = document.getElementById('chevron-' + tagId);

    const isOpen = !detail.classList.contains('hidden');


    document.querySelectorAll('[id^="detail-"]').forEach(d => {
        d.classList.add('hidden');
    });


    document.querySelectorAll('[id^="chevron-"]').forEach(c => {
        c.style.transform = '';
    });


    if (!isOpen) {

        detail.classList.remove('hidden');

        chevron.style.transform = 'rotate(180deg)';

    }

}



// =========================================================
// MODAL BAYAR
// =========================================================

function openModal() {

    const modal = document.getElementById('modal-bayar');

    modal.classList.remove('hidden');

    modal.classList.add('flex');

}


function closeModal() {

    const modal = document.getElementById('modal-bayar');

    modal.classList.remove('flex');

    modal.classList.add('hidden');

}



// =========================================================
// ELEMENT BUKTI PEMBAYARAN
// =========================================================

const buktiBayar = document.getElementById('bukti_bayar');

const fileName = document.getElementById('file-name');

const fileError = document.getElementById('file-error');

const previewButton = document.getElementById('preview-button');



// =========================================================
// ELEMENT MODAL PREVIEW
// =========================================================

const imageModal = document.getElementById('image-modal');

const previewImage = document.getElementById('preview-image');

const closeImageModal = document.getElementById('close-image-modal');


let selectedImage = null;



// =========================================================
// PILIH FILE
// =========================================================

buktiBayar.addEventListener('change', function() {

    const file = this.files[0];


    // Reset error

    fileError.classList.add('hidden');

    fileError.innerText = '';


    // Sembunyikan tombol preview

    previewButton.classList.add('hidden');


    // Reset gambar sebelumnya

    previewImage.src = '';

    selectedImage = null;



    if (!file) {

        fileName.innerText = 'Belum ada file';

        return;

    }



    // =====================================================
    // CEK UKURAN FILE
    // =====================================================

    const maxSize = 10 * 1024 * 1024;


    if (file.size > maxSize) {

        fileError.innerText =
            'Ukuran file terlalu besar. Maksimal ukuran bukti pembayaran adalah 10 MB.';


        fileError.classList.remove('hidden');


        fileName.innerText = 'File terlalu besar';


        this.value = '';


        return;

    }



    // =====================================================
    // CEK FORMAT FILE
    // =====================================================

    const allowedTypes = [

        'image/jpeg',

        'image/png'

    ];


    if (!allowedTypes.includes(file.type)) {

        fileError.innerText =
            'Format file tidak sesuai. Silakan pilih JPG, JPEG, atau PNG.';


        fileError.classList.remove('hidden');


        fileName.innerText = 'Format file tidak sesuai';


        this.value = '';


        return;

    }



    // =====================================================
    // TAMPILKAN NAMA DAN UKURAN FILE
    // =====================================================

    const sizeMB = (file.size / (1024 * 1024)).toFixed(2);


    fileName.innerText =
        file.name + ' (' + sizeMB + ' MB)';



    // =====================================================
    // BUAT PREVIEW
    // =====================================================

    selectedImage = URL.createObjectURL(file);


    previewImage.src = selectedImage;


    // Tampilkan tombol preview

    previewButton.classList.remove('hidden');

});



// =========================================================
// BUKA PREVIEW
// =========================================================

previewButton.addEventListener('click', function() {

    if (!selectedImage) {
        return;
    }


    // Tutup modal Bayar Tagihan

    const paymentModal = document.getElementById('modal-bayar');


    paymentModal.classList.remove('flex');

    paymentModal.classList.add('hidden');


    // Buka modal Preview

    imageModal.classList.remove('hidden');

    imageModal.classList.add('flex');

});



// =========================================================
// TUTUP PREVIEW
// =========================================================

function closeImagePreview() {

    // Tutup modal Preview

    imageModal.classList.remove('flex');

    imageModal.classList.add('hidden');


    // Buka kembali modal Bayar Tagihan

    const paymentModal = document.getElementById('modal-bayar');


    paymentModal.classList.remove('hidden');

    paymentModal.classList.add('flex');

}



// =========================================================
// TUTUP DENGAN X
// =========================================================

closeImageModal.addEventListener('click', function() {

    closeImagePreview();

});



// =========================================================
// TUTUP DENGAN KLIK AREA LUAR
// =========================================================

imageModal.addEventListener('click', function(event) {

    if (event.target === imageModal) {

        closeImagePreview();

    }

});



// =========================================================
// TUTUP DENGAN ESC
// =========================================================

document.addEventListener('keydown', function(event) {

    if (event.key === 'Escape') {

        if (!imageModal.classList.contains('hidden')) {

            closeImagePreview();

        }

    }

});
</script>

@endsection