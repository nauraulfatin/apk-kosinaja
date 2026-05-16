@extends('layouts.admin')

@section('content')

<div class="bg-white rounded-2xl shadow-sm p-6">

    {{-- HEADER --}}
    <div class="flex items-center justify-between mb-6">

        <div>
            <h1 class="text-2xl font-bold text-[#0F0937]">
                Data Aduan Penghuni
            </h1>

            <p class="text-sm text-gray-400 mt-1">
                Daftar aduan dari penghuni kost
            </p>
        </div>

    </div>

    {{-- TABLE --}}
    <div class="overflow-x-auto">

        <table class="w-full border-separate border-spacing-y-3">

            <thead>
                <tr class="text-left text-sm text-gray-500">

                    <th class="px-4 py-3">
                        No
                    </th>

                    <th class="px-4 py-3">
                        Nama Penghuni
                    </th>

                    <th class="px-4 py-3">
                        Tanggal
                    </th>

                    <th class="px-4 py-3">
                        Status
                    </th>

                    <th class="px-4 py-3">
                        Detail
                    </th>

                </tr>
            </thead>

            <tbody>

                @forelse($aduan as $item)

                    <tr class="bg-[#F9FAFB] shadow-sm rounded-xl">

                        {{-- NO --}}
                        <td class="px-4 py-4 rounded-l-xl">
                            {{ $loop->iteration }}
                        </td>

                        {{-- NAMA --}}
                        <td class="px-4 py-4 font-medium text-[#0F0937]">
                            {{ $item->user->nama }}
                        </td>

                        {{-- TANGGAL --}}
                        <td class="px-4 py-4 text-gray-500">
                            {{ $item->tanggal }}
                        </td>

                        {{-- STATUS --}}
                        <td class="px-4 py-4">

                            @if($item->status == 'baru')

                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-600">
                                    Baru
                                </span>

                            @elseif($item->status == 'diproses')

                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-600">
                                    Diproses
                                </span>

                            @else

                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-600">
                                    Selesai
                                </span>

                            @endif

                        </td>

                        {{-- AKSI --}}
                        <td class="px-4 py-4 rounded-r-xl">

                            <a href="{{ route('admin.aduan.show', $item->id_aduan) }}"
                               class="bg-[#3A5C3A] hover:bg-[#2f4b2f] text-white px-4 py-2 rounded-xl text-sm transition">

                                Detail

                            </a>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="5"
                            class="text-center py-10 text-gray-400">

                            Belum ada aduan.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection