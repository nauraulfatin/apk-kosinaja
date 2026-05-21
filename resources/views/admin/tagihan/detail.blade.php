@extends('layouts.admin')

@section('content')

{{-- HEADER --}}
<div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5 mb-8">
    <div>
        <h1 class="text-3xl font-bold text-[#0F0937]">Detail Tagihan</h1>
        <p class="text-gray-500 mt-2">Daftar tagihan milik penghuni.</p>
    </div>
    <a href="{{ route('admin.tagihan.index') }}"
       class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-3 rounded-2xl font-semibold transition w-fit">
        Kembali
    </a>
</div>

{{-- CARD USER --}}
<div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 mb-8">
    <h2 class="text-2xl font-bold text-[#0F0937]">{{ $user->nama }}</h2>
    <p class="text-gray-500 mt-1">{{ $user->username }}</p>
</div>

{{-- LIST TAGIHAN --}}
<div class="space-y-5">
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

    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">

        {{-- BARIS ATAS: info tagihan --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 pb-6 border-b border-gray-100">

            {{-- Kamar --}}
            <div>
                <p class="text-xs text-gray-500 mb-1">Kamar</p>
                <h3 class="text-xl font-bold text-[#0F0937]">
                    {{ $i->kamar?->nomor_kamar }}
                </h3>
            </div>

            {{-- Periode --}}
            <div>
                <p class="text-xs text-gray-500 mb-1">Periode</p>
                <div class="text-sm font-medium text-[#0F0937]">
                    {{ $i->tanggal_mulai->format('d M Y') }}
                </div>
                <div class="text-xs text-gray-400 my-0.5">sampai</div>
                <div class="text-sm font-medium text-[#0F0937]">
                    {{ $i->tanggal_selesai->format('d M Y') }}
                </div>
            </div>

            {{-- Nominal --}}
            <div>
                <p class="text-xs text-gray-500 mb-1">Tagihan</p>
                <div class="text-xl font-bold text-[#0F0937]">
                    Rp {{ number_format($i->hargaKamar?->harga, 0, ',', '.') }}
                </div>
                <div class="text-xs text-gray-500 mt-1">
                    Dibayar: Rp {{ number_format($totalBayar, 0, ',', '.') }}
                </div>
                <div class="text-xs font-semibold text-red-500 mt-0.5">
                    Sisa: Rp {{ number_format($sisa, 0, ',', '.') }}
                </div>
            </div>

            {{-- Status --}}
            <div>
                <p class="text-xs text-gray-500 mb-1">Status</p>
                @if($i->status_label === 'lunas')
                    <span class="px-3 py-1.5 rounded-full bg-green-100 text-green-700 text-xs font-semibold">Lunas</span>
                @elseif($i->status_label === 'telat')
                    <span class="px-3 py-1.5 rounded-full bg-red-100 text-red-700 text-xs font-semibold">Telat</span>
                @elseif($pembayaranTerakhir?->status_validasi === 'menunggu')
                    <span class="px-3 py-1.5 rounded-full bg-yellow-100 text-yellow-700 text-xs font-semibold">Menunggu Verifikasi</span>
                @elseif($pembayaranTerakhir?->status_validasi === 'ditolak')
                    <span class="px-3 py-1.5 rounded-full bg-red-100 text-red-700 text-xs font-semibold">Ditolak</span>
                @else
                    <span class="px-3 py-1.5 rounded-full bg-gray-100 text-gray-700 text-xs font-semibold">Belum Lunas</span>
                @endif
            </div>

        </div>

        {{-- BARIS BAWAH: riwayat pembayaran --}}
        @if($i->pembayaran->count())

        <div class="mt-5">
            <p class="text-xs text-gray-500 mb-3">Riwayat Pembayaran</p>

            {{-- Grid foto-foto pembayaran --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">

                @foreach($i->pembayaran->sortByDesc('created_at') as $p)

                <div class="border border-gray-200 rounded-2xl p-3 flex flex-col gap-3">

                    {{-- FOTO --}}
                    <a href="{{ asset('storage/' . $p->bukti_bayar) }}" target="_blank"
                       class="block w-full aspect-square overflow-hidden rounded-xl border border-gray-100">
                        <img src="{{ asset('storage/' . $p->bukti_bayar) }}"
                             class="w-full h-full object-cover hover:scale-105 transition-transform duration-200">
                    </a>

                    {{-- INFO --}}
                    <div>
                        <div class="text-sm font-bold text-[#0F0937]">
                            Rp {{ number_format($p->nominal_pembayaran, 0, ',', '.') }}
                        </div>
                        <div class="text-xs text-gray-400 mt-0.5">
                            {{ $p->tanggal_bayar?->format('d M Y') }}
                        </div>
                        <div class="text-xs text-gray-400">
                            {{ $p->tanggal_bayar?->format('H:i') }}
                        </div>
                    </div>

                    {{-- STATUS + TOMBOL --}}
                    <div class="mt-auto flex flex-col gap-2">

                        @if($p->status_validasi === 'diterima')
                            <span class="text-center px-2 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">
                                Diterima
                            </span>
                        @elseif($p->status_validasi === 'ditolak')
                            <span class="text-center px-2 py-1 rounded-full bg-red-100 text-red-700 text-xs font-semibold">
                                Ditolak
                            </span>
                        @else
                            <span class="text-center px-2 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-semibold">
                                Menunggu
                            </span>
                        @endif

                        @if($p->status_validasi === 'menunggu')
                        <form method="POST" action="{{ route('admin.tagihan.validasi', $p->id_pembayaran) }}">
                            @csrf
                            <button class="w-full bg-green-500 hover:bg-green-600 text-white py-1.5 rounded-xl text-xs font-semibold transition">
                                Validasi
                            </button>
                        </form>
                        <form method="POST" action="{{ route('admin.tagihan.tolak', $p) }}">
                            @csrf
                            <button class="w-full bg-red-500 hover:bg-red-600 text-white py-1.5 rounded-xl text-xs font-semibold transition">
                                Tolak
                            </button>
                        </form>
                        @endif

                    </div>

                </div>

                @endforeach

            </div>
        </div>

        @else

        <div class="mt-5 text-sm text-gray-400">Belum ada bukti pembayaran.</div>

        @endif

    </div>

    @empty
    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-12 text-center text-gray-500">
        Belum ada data tagihan.
    </div>
    @endforelse

</div>
@endsection