@extends('layouts.penghuni')

@section('content')

<div class="p-6">

    <div class="bg-white rounded-2xl shadow p-6">

        <h1 class="text-2xl font-bold text-black mb-6">
            Aturan Kos
        </h1>

        @forelse($aturans as $aturan)

            <div class="border-b py-4">

                {{-- JUDUL --}}
                @if(!empty($aturan->judul))

                    <h2 class="font-semibold text-lg text-black mb-2">
                        {{ $aturan->judul }}
                    </h2>

                @endif

                {{-- ISI ATURAN --}}
                <p class="text-gray-700 leading-relaxed">
                    {{ $aturan->isi }}
                </p>

            </div>

        @empty

            <p class="text-gray-500 text-center">
                Belum ada aturan kos
            </p>

        @endforelse

    </div>

</div>

@endsection