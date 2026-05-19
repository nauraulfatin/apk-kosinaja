@extends('layouts.admin')

@section('content')

{{-- ========================================================= --}}
{{-- HEADER --}}
{{-- ========================================================= --}}
<div class="mb-8">

    <h1 class="text-3xl font-bold text-[#0F0937]">
        Dashboard Admin Kost
    </h1>

    <p class="text-gray-500 mt-2">
        Kelola usaha kost anda dengan mudah.
    </p>

</div>

{{-- ========================================================= --}}
{{-- CARD INFO --}}
{{-- ========================================================= --}}
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">

    {{-- NAMA KOST --}}
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">

        <div class="flex items-center justify-between">

            <div>

                <p class="text-sm text-gray-500">
                    Nama Kost
                </p>

                <h2 class="text-xl font-bold text-[#0F0937] mt-2">
                    {{ $kost?->nama_kost ?? '-' }}
                </h2>

            </div>

        </div>

    </div>

    {{-- KODE UNDANGAN --}}
<div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">

    <div class="flex items-center justify-between gap-4">

        <div>

            <p class="text-sm text-gray-500">

                Kode Undangan

            </p>

            <h2
                id="kodeUndangan"
                class="text-2xl font-bold text-[#0F0937] mt-2 tracking-widest"
            >

                {{ $kost?->kode_undangan ?? '-' }}

            </h2>

        </div>

        {{-- BUTTON COPY --}}
        <button
            type="button"
            onclick="copyKodeUndangan()"
            class="bg-[#6C8B6B] hover:bg-[#5B765A] text-white px-4 py-2 rounded-xl text-sm font-semibold transition"
        >

            Copy

        </button>

    </div>

</div>

    {{-- TOTAL KAMAR --}}
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">

        <div class="flex items-center justify-between">

            <div>

                <p class="text-sm text-gray-500">
                    Total Kamar
                </p>

                <h2 class="text-3xl font-bold text-[#0F0937] mt-2">
                    {{ $totalKamar ?? 0 }}
                </h2>

            </div>

        </div>

    </div>

    {{-- TOTAL PENGHUNI --}}
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">

        <div class="flex items-center justify-between">

            <div>

                <p class="text-sm text-gray-500">
                    Penghuni
                </p>

                <h2 class="text-3xl font-bold text-[#0F0937] mt-2">
                    {{ $totalPenghuni ?? 0 }}
                </h2>

            </div>

        </div>

    </div>

    {{-- PEMBAYARAN MENUNGGU --}}
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">

        <div class="flex items-center justify-between">

            <div>

                <p class="text-sm text-gray-500">
                    Menunggu Verifikasi
                </p>

                <h2 class="text-3xl font-bold text-[#0F0937] mt-2">
                    {{ $pendingPembayaran ?? 0 }}
                </h2>

            </div>

        </div>

    </div>

</div>

{{-- ========================================================= --}}
{{-- DASHBOARD BAWAH --}}
{{-- ========================================================= --}}
<div class="grid grid-cols-1 xl:grid-cols-2 gap-6">

    {{-- ========================================================= --}}
    {{-- PEMBAYARAN TERBARU --}}
    {{-- ========================================================= --}}
    <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100">

        <div class="flex items-center justify-between mb-6">

            <div>

                <h2 class="text-xl font-bold text-[#0F0937]">
                    Pembayaran Terbaru
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Pembayaran yang menunggu verifikasi admin.
                </p>

            </div>

        </div>

        @forelse($pembayaranTerbaru ?? [] as $item)

        <div
            class="flex items-center justify-between py-4 border-b border-gray-100 last:border-0"
        >

            {{-- LEFT --}}
            <div>

                <h3 class="font-semibold text-[#0F0937]">
                    {{ $item->user?->nama }}
                </h3>

                <p class="text-sm text-gray-500 mt-1">

                    Kamar
                    {{ $item->kamar?->nomor_kamar }}

                </p>

                <p class="text-xs text-gray-400 mt-1">

                    {{ $item->pembayaran?->tanggal_bayar?->format('d M Y') ?? '-' }}

                </p>

            </div>

            {{-- RIGHT --}}
            <div class="text-right">

                <h3 class="font-bold text-[#0F0937]">

                    Rp
                    {{ number_format($item->hargaKamar?->harga ?? 0,0,',','.') }}

                </h3>

                @if($item->status_bukti === 'menunggu')

                <span
                    class="inline-flex mt-2 px-3 py-1
                           rounded-full text-xs font-semibold
                           bg-yellow-100 text-yellow-700"
                >

                    Menunggu Verifikasi

                </span>

                @elseif($item->status === 'lunas')

                <span
                    class="inline-flex mt-2 px-3 py-1
                           rounded-full text-xs font-semibold
                           bg-green-100 text-green-700"
                >

                    Lunas

                </span>

                @endif

            </div>

        </div>

        @empty

        <div class="text-center py-10 text-gray-400">
            Belum ada pembayaran terbaru.
        </div>

        @endforelse

        <div class="mt-6">

            <a
                href="{{ route('admin.tagihan.index') }}"
                class="text-sm font-semibold text-[#6C8B6B] hover:underline"
            >

                Lihat Semua

            </a>

        </div>

    </div>

    {{-- ========================================================= --}}
    {{-- ADUAN TERBARU --}}
    {{-- ========================================================= --}}
    <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100">

        <div class="flex items-center justify-between mb-6">

            <div>

                <h2 class="text-xl font-bold text-[#0F0937]">
                    Aduan Terbaru
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Keluhan terbaru dari penghuni kost.
                </p>

            </div>

        </div>

        @forelse($aduanTerbaru ?? [] as $item)

        <div
            class="py-4 border-b border-gray-100 last:border-0"
        >

            <div class="flex items-center justify-between">

                <h3 class="font-semibold text-[#0F0937]">
                    {{ $item->user?->nama }}
                </h3>

                <span
                    class="inline-flex px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700"
                >

                    {{ $item->status ?? 'pending' }}

                </span>

            </div>

            <p class="text-sm text-gray-500 mt-2 line-clamp-2">
                {{ $item->isi_aduan }}
            </p>

        </div>

        @empty

        <div class="text-center py-10 text-gray-400">
            Belum ada aduan terbaru.
        </div>

        @endforelse

    </div>

</div>

<script>

function copyKodeUndangan()
{
    const kode = document
        .getElementById(
            'kodeUndangan'
        )
        .innerText;

    navigator.clipboard.writeText(
        kode
    );

    alert(
        'Kode undangan berhasil disalin!'
    );
}

</script>
@endsection