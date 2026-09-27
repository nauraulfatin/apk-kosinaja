@extends('layouts.penghuni')

@section('content')

<div class="p-6 space-y-7">

    {{-- =========================================================
        HEADER
    ========================================================== --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

        <div class="flex items-center gap-3">

            <div class="w-11 h-11 rounded-2xl bg-[#F3F0E9]
                       flex items-center justify-center">
                <svg class="w-5 h-5 text-[#7A806F]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M21 11.5a8.38 8.38 0 01-.9 3.8
                           8.5 8.5 0 01-7.6 4.7
                           8.38 8.38 0 01-3.8-.9
                           L3 21l1.9-5.7
                           A8.38 8.38 0 014 11.5
                           8.5 8.5 0 0112.5 3
                           8.5 8.5 0 0121 11.5z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M8 11h.01M12 11h.01M16 11h.01" />
                </svg>
            </div>

            <div>
                <h1 class="text-2xl font-bold text-[#0F0937]">
                    Aduan Kos
                </h1>

                <p class="text-sm text-gray-500 mt-1">
                    Daftar aduan yang telah kamu kirimkan.
                </p>
            </div>

        </div>


        {{-- TAMBAH ADUAN --}}
        <a href="{{ route('penghuni.aduan.create') }}" class="inline-flex items-center justify-center
                   bg-[#7A806F] hover:bg-[#686D60]
                   text-white px-5 py-3
                   rounded-xl transition
                   text-sm font-semibold shadow-sm">
            Tambah Aduan
        </a>

    </div>


    {{-- =========================================================
        CARD UTAMA
    ========================================================== --}}
    <div class="bg-white rounded-3xl
               border border-gray-100
               shadow-sm overflow-hidden">

        {{-- HEADER CARD --}}
        <div class="px-6 py-5
                   border-b border-gray-100
                   bg-[#FBFAF7]
                   flex items-center justify-between">

            <div>
                <h2 class="text-base font-bold text-[#0F0937]">
                    Riwayat Aduan
                </h2>

                <p class="text-xs text-gray-400 mt-1">
                    Pantau status dan tanggapan dari setiap aduan.
                </p>
            </div>

            @if($aduans->count())

            <span class="px-3 py-1.5
                           rounded-full
                           bg-[#F3F0E9]
                           text-[#777C6D]
                           text-xs font-semibold">
                {{ $aduans->count() }} Aduan
            </span>

            @endif

        </div>


        {{-- =====================================================
            DESKTOP TABLE
        ====================================================== --}}
        <div class="hidden md:block overflow-x-auto">

            <table class="w-full min-w-[1000px]">

                <thead>

                    <tr class="border-b border-gray-100">

                        <th class="px-6 py-4 text-left
                                   text-xs font-semibold
                                   text-gray-400 uppercase
                                   tracking-wide w-16">
                            No
                        </th>

                        <th class="px-4 py-4 text-left
                                   text-xs font-semibold
                                   text-gray-400 uppercase
                                   tracking-wide">
                            Tanggal
                        </th>

                        <th class="px-4 py-4 text-left
                                   text-xs font-semibold
                                   text-gray-400 uppercase
                                   tracking-wide
                                   min-w-[260px]">
                            Aduan
                        </th>

                        <th class="px-4 py-4 text-left
                                   text-xs font-semibold
                                   text-gray-400 uppercase
                                   tracking-wide">
                            Foto
                        </th>

                        <th class="px-4 py-4 text-left
                                   text-xs font-semibold
                                   text-gray-400 uppercase
                                   tracking-wide">
                            Status
                        </th>

                        <th class="px-6 py-4 text-left
                                   text-xs font-semibold
                                   text-gray-400 uppercase
                                   tracking-wide
                                   min-w-[250px]">
                            Tanggapan
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($aduans as $aduan)

                    <tr class="border-b border-gray-100
                                   last:border-0
                                   hover:bg-[#FAFAF7]
                                   transition">

                        {{-- NO --}}
                        <td class="px-6 py-5">

                            <span class="w-8 h-8
                                           rounded-xl
                                           bg-[#F3F0E9]
                                           text-[#777C6D]
                                           flex items-center
                                           justify-center
                                           text-xs font-bold">
                                {{ $loop->iteration }}
                            </span>

                        </td>


                        {{-- TANGGAL --}}
                        <td class="px-4 py-5">

                            <p class="text-sm font-medium
                                           text-gray-700
                                           whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($aduan->created_at)->format('d M Y') }}
                            </p>

                        </td>


                        {{-- ISI ADUAN --}}
                        <td class="px-4 py-5">

                            <p class="text-sm
                                           text-gray-700
                                           leading-6
                                           max-w-[320px]">
                                {{ $aduan->isi_aduan }}
                            </p>

                        </td>


                        {{-- FOTO --}}
                        <td class="px-4 py-5">

                            @if($aduan->foto_aduan)

                            <button type="button"
                                onclick="openFotoAduan('{{ asset('storage/' . $aduan->foto_aduan) }}')"
                                class="group relative block">

                                <img src="{{ asset('storage/' . $aduan->foto_aduan) }}" alt="Foto Aduan" class="w-16 h-16
                                                   object-cover
                                                   rounded-xl
                                                   border border-gray-200
                                                   group-hover:opacity-80
                                                   transition">

                                <div class="absolute inset-0
                                                   rounded-xl
                                                   bg-black/0
                                                   group-hover:bg-black/20
                                                   transition
                                                   flex items-center
                                                   justify-center">

                                    <svg class="w-5 h-5 text-white
                                                       opacity-0
                                                       group-hover:opacity-100
                                                       transition" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                            d="M15 3h6v6M14 10l7-7M21 14v5a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h5" />
                                    </svg>

                                </div>

                            </button>

                            @else

                            <span class="text-sm text-gray-400">
                                Tidak ada foto
                            </span>

                            @endif

                        </td>


                        {{-- STATUS --}}
                        <td class="px-4 py-5">

                            @if($aduan->status == 'baru')

                            <span class="inline-flex items-center gap-2
                                               bg-blue-50
                                               text-blue-700
                                               border border-blue-100
                                               px-3 py-1.5
                                               rounded-full
                                               text-xs font-semibold
                                               whitespace-nowrap">
                                <span class="w-1.5 h-1.5
                                                   rounded-full
                                                   bg-blue-500"></span>

                                Baru
                            </span>

                            @elseif($aduan->status == 'diproses')

                            <span class="inline-flex items-center gap-2
                                               bg-amber-50
                                               text-amber-700
                                               border border-amber-100
                                               px-3 py-1.5
                                               rounded-full
                                               text-xs font-semibold
                                               whitespace-nowrap">
                                <span class="w-1.5 h-1.5
                                                   rounded-full
                                                   bg-amber-500"></span>

                                Diproses
                            </span>

                            @else

                            <span class="inline-flex items-center gap-2
                                               bg-emerald-50
                                               text-emerald-700
                                               border border-emerald-100
                                               px-3 py-1.5
                                               rounded-full
                                               text-xs font-semibold
                                               whitespace-nowrap">
                                <span class="w-1.5 h-1.5
                                                   rounded-full
                                                   bg-emerald-500"></span>

                                Selesai
                            </span>

                            @endif

                        </td>


                        {{-- TANGGAPAN --}}
                        <td class="px-6 py-5">

                            @if($aduan->tanggapan_admin)

                            <p class="text-sm
                                               text-gray-600
                                               leading-6
                                               max-w-[320px]">
                                {{ $aduan->tanggapan_admin }}
                            </p>

                            @else

                            <span class="text-sm text-gray-400">
                                Belum ada tanggapan
                            </span>

                            @endif

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="6" class="px-6 py-16">

                            <div class="text-center">

                                <div class="w-16 h-16 mx-auto
                                               rounded-2xl
                                               bg-[#F3F0E9]
                                               flex items-center
                                               justify-center">

                                    <svg class="w-7 h-7 text-[#858979]" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M8 10h8M8 14h5M5 20l-1-4
                                                   a8 8 0 1116 0l-1 4H5z" />
                                    </svg>

                                </div>

                                <h3 class="mt-4
                                               text-base
                                               font-semibold
                                               text-[#0F0937]">
                                    Belum Ada Aduan
                                </h3>

                                <p class="mt-1
                                               text-sm
                                               text-gray-400">
                                    Kamu belum mengirimkan aduan apa pun.
                                </p>

                                <a href="{{ route('penghuni.aduan.create') }}" class="inline-block mt-5
                                               text-sm font-semibold
                                               text-[#7A806F]
                                               hover:text-[#686D60]">
                                    Buat Aduan
                                </a>

                            </div>

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- =====================================================
            MOBILE
        ====================================================== --}}
        <div class="md:hidden p-4 space-y-3">

            @forelse($aduans as $aduan)

            <div class="border border-gray-100
                           rounded-2xl
                           p-4
                           bg-white">

                {{-- TOP --}}
                <div class="flex items-start
                               justify-between
                               gap-3 mb-4">

                    <div>

                        <p class="text-xs
                                       text-gray-400 mb-1">
                            Aduan #{{ $loop->iteration }}
                        </p>

                        <p class="text-sm
                                       font-medium
                                       text-gray-700">
                            {{ \Carbon\Carbon::parse($aduan->created_at)->format('d M Y') }}
                        </p>

                    </div>


                    @if($aduan->status == 'baru')

                    <span class="bg-blue-50
                                       text-blue-700
                                       border border-blue-100
                                       px-2.5 py-1
                                       rounded-full
                                       text-xs font-semibold">
                        Baru
                    </span>

                    @elseif($aduan->status == 'diproses')

                    <span class="bg-amber-50
                                       text-amber-700
                                       border border-amber-100
                                       px-2.5 py-1
                                       rounded-full
                                       text-xs font-semibold">
                        Diproses
                    </span>

                    @else

                    <span class="bg-emerald-50
                                       text-emerald-700
                                       border border-emerald-100
                                       px-2.5 py-1
                                       rounded-full
                                       text-xs font-semibold">
                        Selesai
                    </span>

                    @endif

                </div>


                {{-- ADUAN --}}
                <div class="mb-4">

                    <p class="text-xs
                                   text-gray-400 mb-1">
                        Aduan
                    </p>

                    <p class="text-sm
                                   text-gray-700
                                   leading-6">
                        {{ $aduan->isi_aduan }}
                    </p>

                </div>


                {{-- FOTO --}}
                @if($aduan->foto_aduan)

                <div class="mb-4">

                    <p class="text-xs
                                       text-gray-400 mb-2">
                        Foto Aduan
                    </p>

                    <button type="button" onclick="openFotoAduan('{{ asset('storage/' . $aduan->foto_aduan) }}')"
                        class="block">

                        <img src="{{ asset('storage/' . $aduan->foto_aduan) }}" alt="Foto Aduan" class="w-full
                                           max-w-[220px]
                                           h-36
                                           object-cover
                                           rounded-xl
                                           border border-gray-200">

                    </button>

                </div>

                @endif


                {{-- TANGGAPAN --}}
                <div class="pt-4
                               border-t
                               border-gray-100">

                    <p class="text-xs
                                   text-gray-400 mb-1">
                        Tanggapan Admin
                    </p>

                    @if($aduan->tanggapan_admin)

                    <p class="text-sm
                                       text-gray-600
                                       leading-6">
                        {{ $aduan->tanggapan_admin }}
                    </p>

                    @else

                    <p class="text-sm
                                       text-gray-400">
                        Belum ada tanggapan
                    </p>

                    @endif

                </div>

            </div>

            @empty

            <div class="py-12 text-center">

                <div class="w-16 h-16 mx-auto
                               rounded-2xl
                               bg-[#F3F0E9]
                               flex items-center
                               justify-center">

                    <svg class="w-7 h-7 text-[#858979]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M8 10h8M8 14h5M5 20l-1-4
                                   a8 8 0 1116 0l-1 4H5z" />
                    </svg>

                </div>

                <h3 class="mt-4
                               text-base
                               font-semibold
                               text-[#0F0937]">
                    Belum Ada Aduan
                </h3>

                <p class="mt-1
                               text-sm
                               text-gray-400">
                    Kamu belum mengirimkan aduan apa pun.
                </p>

            </div>

            @endforelse

        </div>

    </div>

</div>


{{-- =========================================================
    MODAL FOTO
========================================================== --}}
<div id="fotoAduanModal" class="hidden fixed inset-0
           bg-black/80
           z-50
           items-center
           justify-center
           p-4" onclick="closeFotoAduan()">

    <div class="relative
               max-w-5xl
               max-h-[90vh]" onclick="event.stopPropagation()">

        <img id="fotoAduanPreview" src="" alt="Foto Aduan" class="max-w-full
                   max-h-[85vh]
                   object-contain
                   rounded-2xl
                   shadow-2xl">


        {{-- CLOSE --}}
        <button type="button" onclick="closeFotoAduan()" class="absolute
                   top-3 right-3
                   w-9 h-9
                   rounded-full
                   bg-black/60
                   hover:bg-black/80
                   text-white
                   flex items-center
                   justify-center
                   transition
                   z-10">

            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>

        </button>

    </div>

</div>


{{-- =========================================================
    JAVASCRIPT MODAL
========================================================== --}}
<script>
function openFotoAduan(url) {

    const modal =
        document.getElementById('fotoAduanModal');

    const image =
        document.getElementById('fotoAduanPreview');

    image.src = url;

    modal.classList.remove('hidden');
    modal.classList.add('flex');

    document.body.classList.add('overflow-hidden');
}


function closeFotoAduan() {

    const modal =
        document.getElementById('fotoAduanModal');

    const image =
        document.getElementById('fotoAduanPreview');

    modal.classList.add('hidden');
    modal.classList.remove('flex');

    image.src = '';

    document.body.classList.remove('overflow-hidden');
}


document.addEventListener('keydown', function(event) {

    if (event.key === 'Escape') {
        closeFotoAduan();
    }

});
</script>

@endsection