@extends('layouts.admin')

@section('content')

<div class="p-6 space-y-6">

    {{-- ========================================================= --}}
    {{-- HEADER --}}
    {{-- ========================================================= --}}
    <div class="flex items-start gap-4">

        <div class="w-12 h-12 rounded-2xl bg-[#EEF4EF]
                    flex items-center justify-center shrink-0">

            <svg class="w-6 h-6 text-[#6C8B6B]" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                    d="M3 10h18M5 6h14a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2z" />

            </svg>

        </div>

        <div>

            <h1 class="text-2xl sm:text-3xl font-bold text-[#0F0937]">
                Pembayaran
            </h1>

            <p class="text-gray-500 mt-1">
                Monitor tagihan dan pembayaran penghuni kost.
            </p>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- TAB NAVIGATION --}}
    {{-- ========================================================= --}}
    <div class="flex items-center gap-8 border-b border-gray-200">

        <a href="{{ route('admin.tagihan.index') }}" class="relative pb-3 text-sm font-semibold transition
                {{ request()->routeIs('admin.tagihan.index')
                    ? 'text-[#6C8B6B]'
                    : 'text-gray-400 hover:text-[#6C8B6B]' }}">

            Tagihan

            @if(request()->routeIs('admin.tagihan.index'))

            <span class="absolute left-0 right-0 bottom-0
                             h-0.5 bg-[#6C8B6B] rounded-full"></span>

            @endif

        </a>


        <a href="{{ route('admin.tagihan.riwayat') }}" class="relative pb-3 text-sm font-semibold transition
                {{ request()->routeIs('admin.tagihan.riwayat')
                    ? 'text-[#6C8B6B]'
                    : 'text-gray-400 hover:text-[#6C8B6B]' }}">

            Riwayat Pembayaran

            @if(request()->routeIs('admin.tagihan.riwayat'))

            <span class="absolute left-0 right-0 bottom-0
                             h-0.5 bg-[#6C8B6B] rounded-full"></span>

            @endif

        </a>

    </div>


    {{-- ========================================================= --}}
    {{-- FILTER + EXPORT --}}
    {{-- ========================================================= --}}
    <div class="bg-white rounded-3xl
                border border-gray-100
                shadow-sm p-6">

        <form method="GET" action="{{ route('admin.tagihan.riwayat') }}" class="flex flex-col lg:flex-row
                   lg:items-end gap-4">

            {{-- BULAN & TAHUN --}}
            <div class="flex-1">

                <label for="bulan" class="block text-sm font-semibold
                           text-gray-700 mb-2">
                    Bulan & Tahun
                </label>

                <input id="bulan" name="bulan" type="text" value="{{ $bulanTahun ?? now()->format('Y-m') }}" class="w-full bg-[#F8FAF8]
                           border border-gray-200
                           rounded-2xl px-4 py-3.5
                           text-sm text-gray-700
                           focus:outline-none
                           focus:border-[#6C8B6B]
                           focus:ring-2
                           focus:ring-[#6C8B6B]/10
                           transition">

            </div>


            {{-- TAMPILKAN --}}
            <button type="submit" class="bg-[#6C8B6B]
                       hover:bg-[#5B765A]
                       text-white
                       px-6 py-3.5
                       rounded-2xl
                       font-semibold
                       text-sm
                       transition">
                Tampilkan
            </button>


            {{-- EXPORT PDF --}}
            <a href="{{ route(
                    'admin.tagihan.export-pdf',
                    ['bulan' => $bulanTahun ?? now()->format('Y-m')]
                ) }}" class="bg-[#C94A4A]
                       hover:bg-[#B63D3D]
                       text-white
                       px-6 py-3.5
                       rounded-2xl
                       font-semibold
                       text-sm
                       transition
                       text-center">
                Export PDF
            </a>

        </form>

    </div>


    {{-- ========================================================= --}}
    {{-- SUMMARY --}}
    {{-- ========================================================= --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

        {{-- TOTAL TRANSAKSI --}}
        <div class="bg-white rounded-3xl
                    p-6 border border-gray-100
                    shadow-sm">

            <p class="text-sm text-gray-500">
                Total Transaksi
            </p>

            <h2 class="text-3xl font-bold text-[#0F0937] mt-2">
                {{ $riwayat->count() }}
            </h2>

            <p class="text-xs text-gray-400 mt-1">
                Pembayaran pada periode yang dipilih
            </p>

        </div>


        {{-- TOTAL NOMINAL --}}
        <div class="bg-white rounded-3xl
                    p-6 border border-gray-100
                    shadow-sm">

            <p class="text-sm text-gray-500">
                Total Nominal
            </p>

            <h2 class="text-2xl font-bold text-[#0F0937] mt-2">
                Rp {{ number_format(
                    $totalNominalRiwayat,
                    0,
                    ',',
                    '.'
                ) }}
            </h2>

            <p class="text-xs text-gray-400 mt-1">
                Total pembayaran yang tercatat
            </p>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- TABLE --}}
    {{-- ========================================================= --}}
    <div class="bg-white rounded-3xl
                border border-gray-100
                shadow-sm overflow-hidden">

        {{-- TABLE HEADER --}}
        <div class="px-6 sm:px-7 py-5
                    border-b border-gray-100
                    flex flex-col sm:flex-row
                    sm:items-center
                    sm:justify-between gap-2">

            <div>

                <h2 class="text-lg font-bold text-[#0F0937]">
                    Riwayat Pembayaran
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Daftar pembayaran yang tercatat pada periode ini.
                </p>

            </div>

            <span class="text-sm text-gray-400">
                {{ $riwayat->count() }} transaksi
            </span>

        </div>


        <div class="overflow-x-auto">

            <table class="w-full min-w-[950px]">

                {{-- ================================================= --}}
                {{-- TABLE HEADER --}}
                {{-- ================================================= --}}
                <thead class="bg-[#F8F5F0]">

                    <tr>

                        <th class="px-6 py-4 text-left
                                   text-xs font-semibold
                                   uppercase tracking-wide
                                   text-gray-500">
                            No
                        </th>

                        <th class="px-6 py-4 text-left
                                   text-xs font-semibold
                                   uppercase tracking-wide
                                   text-gray-500">
                            Penghuni
                        </th>

                        <th class="px-6 py-4 text-left
                                   text-xs font-semibold
                                   uppercase tracking-wide
                                   text-gray-500">
                            Kamar
                        </th>

                        <th class="px-6 py-4 text-left
                                   text-xs font-semibold
                                   uppercase tracking-wide
                                   text-gray-500">
                            Periode
                        </th>

                        <th class="px-6 py-4 text-left
                                   text-xs font-semibold
                                   uppercase tracking-wide
                                   text-gray-500">
                            Nominal
                        </th>

                        <th class="px-6 py-4 text-left
                                   text-xs font-semibold
                                   uppercase tracking-wide
                                   text-gray-500">
                            Tanggal Bayar
                        </th>

                    </tr>

                </thead>


                {{-- ================================================= --}}
                {{-- TABLE BODY --}}
                {{-- ================================================= --}}
                <tbody class="divide-y divide-gray-100">

                    @forelse($riwayat as $i => $p)

                    <tr class="hover:bg-[#FAFCFA] transition">

                        {{-- NO --}}
                        <td class="px-6 py-5">

                            <span class="text-sm text-gray-500">
                                {{ $i + 1 }}
                            </span>

                        </td>


                        {{-- PENGHUNI --}}
                        <td class="px-6 py-5">

                            <div class="flex items-center gap-3">

                                <div class="w-10 h-10 rounded-full
                                                bg-[#EEF4EF]
                                                flex items-center
                                                justify-center
                                                shrink-0">

                                    <span class="text-sm font-bold
                                                     text-[#6C8B6B]">

                                        {{ strtoupper(
                                                substr(
                                                    $p->tagihan->user?->nama ?? '-',
                                                    0,
                                                    1
                                                )
                                            ) }}

                                    </span>

                                </div>

                                <div>

                                    <p class="font-semibold
                                                  text-[#0F0937]">

                                        {{ $p->tagihan->user?->nama ?? '-' }}

                                    </p>

                                </div>

                            </div>

                        </td>


                        {{-- KAMAR --}}
                        <td class="px-6 py-5">

                            <span class="inline-flex
                                             px-3 py-1.5
                                             rounded-lg
                                             bg-gray-50
                                             border border-gray-100
                                             text-sm font-medium
                                             text-gray-700">

                                {{ $p->tagihan->kamar?->nomor_kamar ?? '-' }}

                            </span>

                        </td>


                        {{-- PERIODE --}}
                        <td class="px-6 py-5">

                            <div class="text-sm text-gray-600">

                                <p>
                                    {{ $p->tagihan->tanggal_mulai?->format('d M Y') ?? '-' }}
                                </p>

                                <p class="text-xs text-gray-400 mt-1">

                                    s/d
                                    {{ $p->tagihan->tanggal_selesai?->format('d M Y') ?? '-' }}

                                </p>

                            </div>

                        </td>


                        {{-- NOMINAL --}}
                        <td class="px-6 py-5">

                            <span class="font-semibold
                                             text-[#0F0937]">

                                Rp {{ number_format(
                                        $p->nominal_pembayaran,
                                        0,
                                        ',',
                                        '.'
                                    ) }}

                            </span>

                        </td>


                        {{-- TANGGAL BAYAR --}}
                        <td class="px-6 py-5">

                            @if($p->tanggal_bayar)

                            <p class="text-sm font-medium
                                              text-gray-700">

                                {{ $p->tanggal_bayar->format('d M Y') }}

                            </p>

                            <p class="text-xs text-gray-400 mt-1">

                                {{ $p->tanggal_bayar->format('H:i') }}

                            </p>

                            @else

                            <span class="text-sm text-gray-400">
                                -
                            </span>

                            @endif

                        </td>

                    </tr>


                    @empty

                    {{-- ================================================= --}}
                    {{-- EMPTY STATE --}}
                    {{-- ================================================= --}}
                    <tr>

                        <td colspan="6" class="px-6 py-16">

                            <div class="flex flex-col
                                            items-center
                                            justify-center
                                            text-center">

                                <div class="w-14 h-14 rounded-2xl
                                                bg-[#EEF4EF]
                                                flex items-center
                                                justify-center mb-4">

                                    <svg class="w-6 h-6 text-[#6C8B6B]" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">

                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                            d="M3 10h18M5 6h14a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2z" />

                                    </svg>

                                </div>

                                <h3 class="text-lg font-semibold
                                               text-gray-700">

                                    Tidak Ada Pembayaran

                                </h3>

                                <p class="text-sm text-gray-400 mt-1">

                                    Tidak ada pembayaran pada bulan ini.

                                </p>

                            </div>

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>


{{-- ========================================================= --}}
{{-- FLATPICKR --}}
{{-- ========================================================= --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/index.js"></script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/style.css">


<script>
flatpickr("#bulan", {

    plugins: [

        new monthSelectPlugin({

            shorthand: false,

            dateFormat: "Y-m",

            altFormat: "F Y"

        })

    ]

});
</script>

@endsection