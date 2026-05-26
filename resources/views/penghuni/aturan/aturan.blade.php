@extends('layouts.penghuni')

@section('content')

<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-3xl font-bold text-[#0F0937]">Aturan Kos</h1>
        <p class="text-gray-500 mt-2">Harap dipatuhi aturan yang berlaku</p>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-2 space-y-2">

    @forelse($aturans as $aturan)

    <div class="flex items-center px-4 py-3 rounded-xl border border-gray-100 hover:bg-gray-50 transition">

        <div class="flex items-center gap-4">
            <span
                class="w-7 h-7 flex items-center justify-center rounded-full bg-[#EEF3EE] text-[#6C8B6B] text-sm font-bold">
                {{ $loop->iteration }}
            </span>
            <p class="text-gray-700 font-medium">
                {{ $aturan->isi }}
            </p>
        </div>

    </div>

    @empty

    <div class="text-center py-12 text-gray-500">
        Belum ada aturan kos
    </div>

    @endforelse

</div>

@endsection