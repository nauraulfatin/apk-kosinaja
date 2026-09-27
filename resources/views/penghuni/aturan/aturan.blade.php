@extends('layouts.penghuni')

@section('content')

<div class="p-6 space-y-7">

    {{-- =========================================================
        HEADER
    ========================================================== --}}
    <div>

        <div class="flex items-center gap-3">

            <div class="w-11 h-11
                       rounded-2xl
                       bg-[#F3F0E9]
                       flex items-center
                       justify-center">

                <svg class="w-5 h-5 text-[#7A806F]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M12 3l8 4v5c0 5-3.4 8-8 9-4.6-1-8-4-8-9V7l8-4z" />

                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4" />
                </svg>

            </div>


            <div>

                <h1 class="text-2xl
                           font-bold
                           text-[#0F0937]">
                    Aturan Kos
                </h1>

                <p class="text-gray-500
                           mt-1
                           text-sm">
                    Harap dipatuhi aturan yang berlaku.
                </p>

            </div>

        </div>

    </div>


    {{-- =========================================================
        ATURAN
    ========================================================== --}}
    <div class="bg-white
               rounded-3xl
               border border-gray-100
               shadow-sm
               overflow-hidden">

        {{-- HEADER CARD --}}
        <div class="px-6 py-5
                   border-b border-gray-100
                   bg-[#FBFAF7]">

            <div class="flex items-center justify-between">

                <div>

                    <h2 class="text-base
                               font-bold
                               text-[#0F0937]">
                        Peraturan Penghuni
                    </h2>

                    <p class="text-xs
                               text-gray-400
                               mt-1">
                        Mohon dibaca dan dipahami sebelum tinggal di kos.
                    </p>

                </div>


                @if($aturans->count())

                <span class="px-3 py-1.5
                               rounded-full
                               bg-[#F3F0E9]
                               text-[#777C6D]
                               text-xs
                               font-semibold">

                    {{ $aturans->count() }} Aturan

                </span>

                @endif

            </div>

        </div>


        {{-- =====================================================
            LIST ATURAN
        ====================================================== --}}
        <div class="p-4">

            @forelse($aturans as $aturan)

            <div class="group
                           flex items-start
                           gap-4
                           px-4 py-4
                           rounded-2xl
                           hover:bg-[#FAFAF7]
                           transition">

                {{-- NOMOR --}}
                <div class="w-9 h-9
                               shrink-0
                               rounded-xl
                               bg-[#F3F0E9]
                               text-[#777C6D]
                               flex items-center
                               justify-center
                               text-sm
                               font-bold">

                    {{ $loop->iteration }}

                </div>


                {{-- ISI --}}
                <div class="pt-1">

                    <p class="text-[15px]
                                   leading-6
                                   text-gray-700">

                        {{ $aturan->isi }}

                    </p>

                </div>

            </div>


            @if(!$loop->last)

            <div class="mx-4
                               border-b
                               border-gray-100"></div>

            @endif


            @empty

            {{-- EMPTY STATE --}}
            <div class="py-16
                           text-center">

                <div class="w-16 h-16
                               mx-auto
                               rounded-2xl
                               bg-[#F3F0E9]
                               flex items-center
                               justify-center">

                    <svg class="w-7 h-7 text-[#858979]" fill="none" viewBox="0 0 24 24" stroke="currentColor">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M12 9v4m0 4h.01M10.3 3.5L2.8 17a2 2 0 001.7 3h15a2 2 0 001.7-3L13.7 3.5a2 2 0 00-3.4 0z" />

                    </svg>

                </div>


                <h3 class="mt-4
                               text-base
                               font-semibold
                               text-[#0F0937]">

                    Belum Ada Aturan

                </h3>


                <p class="mt-1
                               text-sm
                               text-gray-400">

                    Belum ada aturan kos yang ditambahkan.

                </p>

            </div>

            @endforelse

        </div>

    </div>

</div>

@endsection