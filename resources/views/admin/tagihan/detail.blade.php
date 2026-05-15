@extends('layouts.admin')

@section('content')

{{-- ========================================================= --}}
{{-- HEADER --}}
{{-- ========================================================= --}}
<div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5 mb-8">

    <div>

        <h1 class="text-3xl font-bold text-[#0F0937]">

            Detail Tagihan

        </h1>

        <p class="text-gray-500 mt-2">

            Daftar tagihan milik penghuni.

        </p>

    </div>

    {{-- BACK --}}
    <a
        href="{{ route('admin.tagihan.index') }}"
        class="bg-gray-100 hover:bg-gray-200
               text-gray-700 px-5 py-3
               rounded-2xl font-semibold transition w-fit"
    >

        Kembali

    </a>

</div>

{{-- ========================================================= --}}
{{-- PENGHUNI CARD --}}
{{-- ========================================================= --}}
<div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 mb-8">

    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5">

        <div>

            <h2 class="text-2xl font-bold text-[#0F0937]">

                {{ $user->nama }}

            </h2>

            <p class="text-gray-500 mt-1">

                {{ $user->username }}

            </p>

        </div>

        <div class="flex flex-wrap gap-3">

            <div class="px-4 py-3 rounded-2xl bg-[#F8F5F0]">

                <p class="text-xs text-gray-500 mb-1">
                    Total Tagihan
                </p>

                <p class="text-lg font-bold text-[#0F0937]">
                    {{ $items->count() }}
                </p>

            </div>

            <div class="px-4 py-3 rounded-2xl bg-yellow-50">

                <p class="text-xs text-yellow-700 mb-1">
                    Menunggu
                </p>

                <p class="text-lg font-bold text-yellow-800">
                    {{ $items->where('status_bukti','menunggu')->count() }}
                </p>

            </div>

            <div class="px-4 py-3 rounded-2xl bg-green-50">

                <p class="text-xs text-green-700 mb-1">
                    Lunas
                </p>

                <p class="text-lg font-bold text-green-800">
                    {{ $items->where('status','lunas')->count() }}
                </p>

            </div>

        </div>

    </div>

</div>

{{-- ========================================================= --}}
{{-- LIST TAGIHAN --}}
{{-- ========================================================= --}}
<div class="space-y-5">

    @forelse($items as $i)

    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">

        <div class="grid grid-cols-1 xl:grid-cols-5 gap-6 items-center">

            {{-- KAMAR --}}
            <div>

                <p class="text-xs text-gray-500 mb-2">
                    Kamar
                </p>

                <h3 class="text-xl font-bold text-[#0F0937]">

                    {{ $i->kamar?->nomor_kamar }}

                </h3>

                @if($i->kamar?->nama_kamar)

                <p class="text-sm text-gray-500 mt-1">
                    {{ $i->kamar?->nama_kamar }}
                </p>

                @endif

            </div>

            {{-- PERIODE --}}
            <div>

                <p class="text-xs text-gray-500 mb-2">
                    Periode
                </p>

                <div class="text-sm font-medium text-[#0F0937]">
                    {{ $i->tanggal_mulai->format('d M Y') }}
                </div>

                <div class="text-xs text-gray-400 my-1">
                    sampai
                </div>

                <div class="text-sm font-medium text-[#0F0937]">
                    {{ $i->tanggal_selesai->format('d M Y') }}
                </div>

            </div>

            {{-- HARGA --}}
            <div>

                <p class="text-xs text-gray-500 mb-2">
                    Harga
                </p>

                <div class="text-2xl font-bold text-[#0F0937]">

                    Rp {{ number_format($i->hargaKamar?->harga,0,',','.') }}

                </div>

                @if($i->hargaKamar?->periode)

                <div class="text-xs text-gray-500 mt-1">

                    /
                    {{ $i->hargaKamar->periode->jumlah_interval }}
                    {{ $i->hargaKamar->periode->satuan_interval }}

                </div>

                @endif

            </div>

            {{-- STATUS --}}
            <div>

                <p class="text-xs text-gray-500 mb-2">
                    Status
                </p>

                @if(
                    $i->status === 'pending' &&
                    $i->status_bukti === 'belum_upload'
                )

                <span class="px-3 py-1.5 rounded-full bg-gray-100 text-gray-700 text-xs font-semibold">
                    Belum Bayar
                </span>

                @elseif(
                    $i->status === 'pending' &&
                    $i->status_bukti === 'menunggu'
                )

                <span class="px-3 py-1.5 rounded-full bg-yellow-100 text-yellow-700 text-xs font-semibold">
                    Menunggu Verifikasi
                </span>

                @elseif(
                    $i->status === 'pending' &&
                    $i->status_bukti === 'ditolak'
                )

                <span class="px-3 py-1.5 rounded-full bg-red-100 text-red-700 text-xs font-semibold">
                    Ditolak
                </span>

                @elseif($i->status === 'lunas')

                <span class="px-3 py-1.5 rounded-full bg-green-100 text-green-700 text-xs font-semibold">
                    Lunas
                </span>

                @elseif($i->status === 'telat')

                <span class="px-3 py-1.5 rounded-full bg-red-100 text-red-700 text-xs font-semibold">
                    Telat
                </span>

                @endif

            </div>

            {{-- BUKTI + AKSI --}}
            <div>

                @if($i->pembayaran?->bukti_bayar)

                <div class="flex items-center gap-4 flex-wrap">

                    {{-- IMAGE --}}
                    <img
                        src="{{ asset('storage/' . $i->pembayaran->bukti_bayar) }}"
                        class="w-24 h-24 object-cover rounded-2xl border border-gray-200 cursor-pointer"
                        onclick="
                            document.getElementById(
                                'modal-{{ $i->id_tagihan }}'
                            ).classList.remove('hidden')
                        "
                    >

                    {{-- ACTION --}}
                    @if($i->status_bukti === 'menunggu')

                    <div class="flex flex-col gap-2">

                        <form
                            method="POST"
                            action="{{ route('admin.tagihan.validasi', $i) }}"
                        >

                            @csrf

                            <button
                                type="submit"
                                class="bg-green-500 hover:bg-green-600
                                       text-white px-4 py-2 rounded-xl
                                       text-sm font-semibold transition"
                            >

                                Validasi

                            </button>

                        </form>

                        <form
                            method="POST"
                            action="{{ route('admin.tagihan.tolak', $i) }}"
                        >

                            @csrf

                            <button
                                type="submit"
                                class="bg-red-500 hover:bg-red-600
                                       text-white px-4 py-2 rounded-xl
                                       text-sm font-semibold transition"
                            >

                                Tolak

                            </button>

                        </form>

                    </div>

                    @endif

                </div>

                {{-- MODAL --}}
                <div
                    id="modal-{{ $i->id_tagihan }}"
                    class="fixed inset-0 bg-black/70 hidden
                           z-50 flex items-center justify-center p-6"
                >

                    <div class="relative">

                        {{-- CLOSE --}}
                        <button
                            type="button"
                            onclick="
                                document.getElementById(
                                    'modal-{{ $i->id_tagihan }}'
                                ).classList.add('hidden')
                            "
                            class="absolute -top-4 -right-4
                                   w-10 h-10 rounded-full
                                   bg-white text-black
                                   flex items-center justify-center shadow-lg"
                        >

                            ✕

                        </button>

                        {{-- IMAGE --}}
                        <img
                            src="{{ asset('storage/' . $i->pembayaran->bukti_bayar) }}"
                            class="max-w-[90vw] max-h-[85vh]
                                   rounded-3xl shadow-2xl"
                        >

                    </div>

                </div>

                @else

                <span class="text-sm text-gray-400">

                    Belum Upload

                </span>

                @endif

            </div>

        </div>

    </div>

    @empty

    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-12 text-center text-gray-500">

        Belum ada data tagihan.

    </div>

    @endforelse

</div>

@endsection