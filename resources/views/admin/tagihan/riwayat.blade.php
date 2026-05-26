@extends('layouts.admin')

@section('content')

<div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5 mb-8">
    <div>
        <h1 class="text-3xl font-bold text-[#0F0937]">Pembayaran</h1>
        <p class="text-gray-500 mt-2">Monitor tagihan dan pembayaran penghuni kost.</p>
    </div>
</div>


{{-- TAB NAVIGATION --}}
<div class="flex items-center gap-8 mb-10 border-b border-gray-200">

    <a href="{{ route('admin.tagihan.index') }}"
        class="pb-3 text-sm font-semibold transition {{ request()->routeIs('admin.tagihan.index') ? 'text-[#6C8B6B] border-b-2 border-[#6C8B6B]' : 'text-gray-400 hover:text-[#6C8B6B]' }}">
        Tagihan
    </a>

    <a href="{{ route('admin.tagihan.riwayat') }}"
        class="pb-3 text-sm font-semibold transition {{ request()->routeIs('admin.tagihan.riwayat') ? 'text-[#6C8B6B] border-b-2 border-[#6C8B6B]' : 'text-gray-400 hover:text-[#6C8B6B]' }}">
        Riwayat Pembayaran
    </a>

</div>

{{-- FILTER + EXPORT --}}
<div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 mb-6">
    <form method="GET" action="{{ route('admin.tagihan.riwayat') }}" class="flex flex-col sm:flex-row gap-4 items-end">

        <div class="flex-1">
            <label class="text-sm font-semibold text-gray-600 mb-2 block">Pilih Bulan</label>
            <input type="month" name="bulan" value="{{ $bulan }}" class="w-full border border-gray-200 rounded-2xl px-4 py-3
                          text-sm focus:outline-none focus:ring-2 focus:ring-[#6C8B6B]">
        </div>

        <button type="submit" class="bg-[#6C8B6B] hover:bg-[#5B765A] text-white
                       px-6 py-3 rounded-2xl font-semibold text-sm transition">
            Tampilkan
        </button>

        <a href="{{ route('admin.tagihan.export-pdf', ['bulan' => $bulan]) }}" class="bg-red-500 hover:bg-red-600 text-white
                  px-6 py-3 rounded-2xl font-semibold text-sm transition">
            Export PDF
        </a>

    </form>
</div>

{{-- SUMMARY --}}
<div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-6">
    <div class="bg-green-50 rounded-3xl p-6 border border-green-100">
        <p class="text-sm text-green-700 mb-1">Total Transaksi</p>
        <h2 class="text-3xl font-bold text-green-800">{{ $riwayat->count() }}</h2>
    </div>
    <div class="bg-blue-50 rounded-3xl p-6 border border-blue-100">
        <p class="text-sm text-blue-700 mb-1">Total Nominal</p>
        <h2 class="text-2xl font-bold text-blue-800">
            Rp {{ number_format($totalNominalRiwayat, 0, ',', '.') }}
        </h2>
    </div>
</div>

{{-- TABLE --}}
<div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-[#F8F5F0]">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">No</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">Penghuni</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">Kamar</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">Periode</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">Nominal</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">Tanggal Bayar</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($riwayat as $i => $p)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $i + 1 }}</td>
                    <td class="px-6 py-4">
                        <div class="font-semibold text-[#0F0937]">{{ $p->tagihan->user?->nama }}</div>
                        <div class="text-sm text-gray-500">{{ $p->tagihan->user?->username }}</div>
                    </td>
                    <td class="px-6 py-4 text-sm text-[#0F0937]">
                        {{ $p->tagihan->kamar?->nomor_kamar }}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">
                        {{ $p->tagihan->tanggal_mulai?->format('d M Y') }}
                        <div class="text-xs text-gray-400">sampai</div>
                        {{ $p->tagihan->tanggal_selesai?->format('d M Y') }}
                    </td>
                    <td class="px-6 py-4 font-semibold text-[#0F0937]">
                        Rp {{ number_format($p->nominal_pembayaran, 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">
                        {{ $p->tanggal_bayar?->format('d M Y, H:i') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                        Tidak ada pembayaran pada bulan ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection