@extends('layouts.superadmin')

@section('content')

<div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-8">
    <div>
        <h1 class="text-3xl font-bold text-[#0F0937]">
            Master Periode Penagihan
        </h1>
        <p class="text-gray-500 mt-2 max-w-2xl">
            Periode ini berlaku secara global untuk seluruh kos. Admin Kos hanya dapat memilih periode yang tersedia saat mengatur harga kamar.
        </p>
    </div>

    <div class="flex gap-3">
        <a href="{{ route('superadmin.periode.create') }}"
            class="bg-[#6C8B6B] hover:bg-[#5B765A] text-white px-5 py-2.5 rounded-xl font-medium text-sm transition">
            + Tambah Periode
        </a>

        <a href="{{ route('superadmin.dashboard') }}"
            class="bg-gray-100 hover:bg-gray-200 text-gray-600 px-5 py-2.5 rounded-xl font-medium text-sm transition">
            Kembali
        </a>
    </div>
</div>

<div class="mb-6 bg-[#EEF5EE] border border-[#D6E5D6] rounded-2xl p-5">
    <p class="text-sm text-[#3A5C3A] leading-relaxed">
        <span class="font-semibold">Catatan:</span>
        Jika suatu periode sudah digunakan pada harga kamar, intervalnya akan dikunci dan periode tersebut tidak dapat dihapus. Hal ini mencegah perubahan master memengaruhi tagihan kos yang sudah menggunakan periode tersebut.
    </p>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-[#E6F4EC]">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500">ID</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500">Nama Periode</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500">Interval</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500">Digunakan</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">
                @forelse($items as $i)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-xs text-gray-400">
                            #{{ $i->id_penagihan }}
                        </td>

                        <td class="px-6 py-4">
                            <p class="font-semibold text-[#0F0937]">
                                {{ $i->periode_penagihan }}
                            </p>
                        </td>

                        <td class="px-6 py-4 text-sm text-gray-600">
                            Setiap
                            <span class="font-semibold text-[#0F0937]">
                                {{ $i->jumlah_interval }} {{ $i->satuan_interval }}
                            </span>
                        </td>

                        <td class="px-6 py-4">
                            @if($i->harga_kamars_count > 0)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-amber-50 text-amber-700 border border-amber-100">
                                    {{ $i->harga_kamars_count }} harga kamar
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-500">
                                    Belum digunakan
                                </span>
                            @endif
                        </td>

                        <td class="px-6 py-4">
                            <div class="flex flex-wrap gap-2">
                                <a href="{{ route('superadmin.periode.edit', $i) }}"
                                    class="bg-[#E6F1FB] hover:bg-[#B5D4F4] text-[#0C447C] px-3 py-1.5 rounded-lg text-xs font-medium transition">
                                    Edit
                                </a>

                                @if($i->harga_kamars_count === 0)
                                    <form method="POST"
                                        action="{{ route('superadmin.periode.destroy', $i) }}"
                                        onsubmit="return confirm('Hapus periode penagihan ini?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                            class="bg-[#FCEBEB] hover:bg-[#F7C1C1] text-[#791F1F] px-3 py-1.5 rounded-lg text-xs font-medium transition">
                                            Hapus
                                        </button>
                                    </form>
                                @else
                                    <button type="button" disabled
                                        title="Periode sedang digunakan pada harga kamar"
                                        class="bg-gray-100 text-gray-400 px-3 py-1.5 rounded-lg text-xs font-medium cursor-not-allowed">
                                        Hapus
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-sm text-gray-400">
                            Belum ada master periode penagihan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
