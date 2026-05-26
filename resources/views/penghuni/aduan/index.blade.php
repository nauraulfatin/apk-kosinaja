@extends('layouts.penghuni')

@section('content')

<div class="p-6">

    <div class="flex justify-between items-center mb-6">

        <div>
            <h1 class="text-2xl font-bold text-black">
                Aduan Kos
            </h1>
            <p class="text-sm text-gray-400 mt-1">
                Daftar aduan yang telah kamu kirimkan.
            </p>
        </div>

        <a href="{{ route('penghuni.aduan.create') }}"
            class="bg-[#6E8B74] hover:bg-[#5c7764] text-white px-5 py-2 rounded-xl transition">
            Tambah Aduan
        </a>

    </div>

    <div class="bg-white rounded-2xl shadow p-6">

        <table class="w-full">

            <thead>
                <tr class="border-b border-gray-200 text-left text-gray-500">
                    <th class="pb-3 font-medium">No</th>
                    <th class="pb-3 font-medium">Tanggal</th>
                    <th class="pb-3 font-medium">Aduan</th>
                    <th class="pb-3 font-medium">Status</th>
                    <th class="pb-3 font-medium">Tanggapan</th>
                </tr>
            </thead>

            <tbody>

                @forelse($aduans as $aduan)

                <tr class="border-b border-gray-100 hover:bg-gray-50 transition">

                    <td class="py-4">
                        {{ $loop->iteration }}
                    </td>

                    <td class="py-4">
                        {{ \Carbon\Carbon::parse($aduan->created_at)->format('d M Y') }}
                    </td>

                    <td class="py-4">
                        {{ $aduan->isi_aduan }}
                    </td>

                    <td class="py-4">

                        @if($aduan->status == 'baru')
                        <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-lg text-sm">
                            Baru
                        </span>
                        @elseif($aduan->status == 'diproses')
                        <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-lg text-sm">
                            Diproses
                        </span>
                        @else
                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-lg text-sm">
                            Selesai
                        </span>
                        @endif

                    </td>

                    <td class="py-4 text-gray-700">
                        {{ $aduan->tanggapan_admin ?? '-' }}
                    </td>

                </tr>

                @empty

                <tr>
                    <td colspan="5" class="text-center py-6 text-gray-400">
                        Belum ada aduan
                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection