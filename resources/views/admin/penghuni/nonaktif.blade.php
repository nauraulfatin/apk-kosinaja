@extends('layouts.admin')

@section('content')

<div class="flex items-center justify-between mb-8">

    <div>

        <h1 class="text-3xl font-bold text-[#0F0937]">

            Riwayat Penghuni

        </h1>

        <p class="text-gray-500 mt-2">

            Daftar penghuni yang sudah keluar dari kost.

        </p>

    </div>
</div>
<div class="flex items-center gap-8 mb-10 border-b border-gray-200">

    <a
        href="{{ route('admin.penghuni.aktif') }}"
        class="pb-3 text-sm font-semibold transition
        {{ request()->routeIs('admin.penghuni.aktif')
            ? 'text-[#6C8B6B] border-b-2 border-[#6C8B6B]'
            : 'text-gray-400 hover:text-[#6C8B6B]'
        }}"
    >

        Penghuni Aktif

    </a>

    <a
        href="{{ route('admin.penghuni.antrian') }}"
        class="pb-3 text-sm font-semibold transition
        {{ request()->routeIs('admin.penghuni.antrian')
            ? 'text-[#E8B44D] border-b-2 border-[#E8B44D]'
            : 'text-gray-400 hover:text-[#E8B44D]'
        }}"
    >

        Dalam Antrian

    </a>

    <a
        href="{{ route('admin.penghuni.nonaktif') }}"
        class="pb-3 text-sm font-semibold transition
        {{ request()->routeIs('admin.penghuni.nonaktif')
            ? 'text-red-500 border-b-2 border-red-500'
            : 'text-gray-400 hover:text-red-500'
        }}"
    >

        Riwayat Penghuni

    </a>

</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

    <div class="overflow-x-auto">

        <table class="w-full">

            <thead class="bg-[#F8F5F0]">

                <tr>

                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                        Nama
                    </th>

                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                        Kamar Terakhir
                    </th>

                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                        Tanggal Keluar
                    </th>

                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                        Status
                    </th>

                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                        Aksi
                    </th>

                </tr>

            </thead>

            <tbody class="divide-y divide-gray-100">

                @forelse($items as $i)

                    <tr class="hover:bg-gray-50">

                        <td class="px-6 py-4">

                            <div>

                                <h4 class="font-semibold text-gray-800">

                                    {{ $i->user->nama }}

                                </h4>

                                <p class="text-sm text-gray-400">

                                    {{ $i->user->username }}

                                </p>

                            </div>

                        </td>

                        <td class="px-6 py-4 text-gray-600">

                            {{ $i->kamar->nomor_kamar ?? '-' }}

                        </td>

                        <td class="px-6 py-4 text-gray-600">

                            {{ \Carbon\Carbon::parse($i->tanggal_keluar)->format('d M Y') }}

                        </td>

                        <td class="px-6 py-4">

                            <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">

                                Nonaktif

                            </span>

                        </td>

                        <td class="px-6 py-4">

                            <a
                                href="{{ route('admin.penghuni.formAktifkan', ['riwayatHunian' => $i,'from' => 'nonaktif']) }}"
                                class="bg-[#6C8B6B] hover:bg-[#5B765A]
                                       text-white px-4 py-2 rounded-lg text-sm"
                            >

                                Aktifkan Kembali

                            </a>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="5"
                            class="px-6 py-10 text-center text-gray-500">

                            Belum ada riwayat penghuni

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection