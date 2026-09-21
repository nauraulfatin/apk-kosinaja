@extends('layouts.public')

@section('title', 'Semua Kos - KosinAja')

@section('content')

<div class="min-h-screen bg-[#F8FAF7] py-12">

    <div class="max-w-7xl mx-auto px-5">


        {{-- HEADER --}}
        <div class="mb-10">

            <h1 class="text-3xl font-bold text-[#314233]">
                Semua Kos
            </h1>

            <p class="mt-2 text-gray-500">
                Temukan kos yang sesuai dengan kebutuhan kamu.
            </p>

        </div>



        {{-- SEARCH --}}
        <form method="GET"
              action="{{ route('katalog') }}"
              class="mb-10 flex gap-3">


            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari nama atau alamat kos..."
                class="flex-1 rounded-xl border border-gray-200 px-5 py-3 focus:outline-none focus:ring-2 focus:ring-[#6C8B6B]"
            >


            <button
                type="submit"
                class="px-7 py-3 rounded-xl bg-[#6C8B6B] text-white font-semibold hover:bg-[#314233]">

                Cari

            </button>


        </form>




        {{-- LIST KOS --}}
        <div class="grid md:grid-cols-3 gap-6">


            @forelse($kost as $item)


            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">


{{-- FOTO --}}
<div class="h-48 bg-gray-100">

    @if(!empty($item->foto_kost))

        <img
            src="{{ asset('storage/'.$item->foto_kost[0]) }}"
            class="w-full h-full object-cover"
            alt="{{ $item->nama_kost }}"
        >
    @else

        <div class="w-full h-full flex items-center justify-center text-gray-400">
            Tidak ada foto</div>
    @endif
</div>

                {{-- CONTENT --}}
                <div class="p-5">


                    <h2 class="text-xl font-bold text-[#314233]">

                        {{ $item->nama_kost }}

                    </h2>



                    <p class="mt-2 text-sm text-gray-500 line-clamp-2">

                        {{ $item->alamat }}

                    </p>



                    <a href="{{ route('detailKost',$item->id) }}"
                       class="inline-block mt-5 text-[#6C8B6B] font-semibold hover:underline">

                        Lihat Detail →

                    </a>


                </div>


            </div>


            @empty


            <div class="col-span-3 text-center py-20">

                <h3 class="text-xl font-semibold text-gray-600">
                    Kos tidak ditemukan
                </h3>

                <p class="text-gray-400 mt-2">
                    Coba gunakan kata kunci lain.
                </p>

            </div>


            @endforelse


        </div>




        {{-- PAGINATION --}}
        <div class="mt-10">

            {{ $kost->links() }}

        </div>


    </div>


</div>


@endsection