@extends('layouts.penghuni')

@section('content')

@php

$periode =
$tagihanAktif->first()?->hargaKamar?->periode;

@endphp

{{-- ========================================================= --}}
{{-- HEADER --}}
{{-- ========================================================= --}}
<div class="mb-8">

    <h1 class="text-3xl font-bold text-[#0F0937]">

        Pembayaran Saya

    </h1>

    <p class="text-gray-500 mt-2">

        Lihat tagihan kost dan upload bukti pembayaran.

    </p>

    @if($periode)

    <div class="mt-4 inline-flex items-center
               gap-2 bg-white border border-gray-200
               px-5 py-3 rounded-2xl">

        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-[#6C8B6B]" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">

            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M8 7V3m8 4V3m-9 8h10m-11 9h12a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v11a2 2 0 002 2z" />

        </svg>

        <span class="text-sm font-semibold text-[#0F0937]">

            Pembayaran setiap
            {{ $periode->jumlah_interval }}
            {{ $periode->satuan_interval }}

        </span>

    </div>

    @endif

</div>

{{-- ========================================================= --}}
{{-- TABLE --}}
{{-- ========================================================= --}}
<div class="bg-white rounded-3xl shadow-sm
           border border-gray-100 overflow-hidden">

    <div class="overflow-x-auto">

        <table class="w-full">

            <thead class="bg-[#F8F5F0]">

                <tr>

                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">

                        Periode

                    </th>

                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">

                        Harga

                    </th>

                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">

                        Jatuh Tempo

                    </th>

                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">

                        Status

                    </th>

                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">

                        Pembayaran

                    </th>

                </tr>

            </thead>

            <tbody class="divide-y divide-gray-100">

                @forelse($tagihanAktif as $i)

                <tr class="align-middle hover:bg-gray-50">

                    {{-- PERIODE --}}
                    <td class="px-6 py-4 min-w-[200px]">

                        <div class="font-medium text-[#0F0937]">

                            {{ $i->tanggal_mulai->format('d/m/Y') }}

                        </div>

                        <div class="text-gray-400 text-sm">

                            sampai

                        </div>

                        <div class="font-medium text-[#0F0937]">

                            {{ $i->tanggal_selesai->format('d/m/Y') }}

                        </div>

                    </td>

                    {{-- HARGA --}}
                    <td class="px-6 py-4 min-w-[180px]">

                        <div class="text-2xl font-bold text-[#0F0937]">

                            Rp
                            {{ number_format($i->hargaKamar?->harga,0,',','.') }}

                        </div>

                    </td>

                    {{-- JATUH TEMPO --}}
                    <td class="px-6 py-4 min-w-[160px]">

                        <div class="font-medium text-[#0F0937]">

                            {{ $i->tanggal_jatuh_tempo?->format('d/m/Y') ?? '-' }}

                        </div>

                    </td>

                    {{-- STATUS --}}
                    <td class="px-6 py-4 min-w-[170px]">

                        @if(
                        $i->status === 'pending' &&
                        $i->status_bukti === 'belum_upload'
                        )

                        <span class="px-3 py-1.5 rounded-full
                                   bg-gray-100 text-gray-700
                                   text-sm font-semibold">

                            Belum Bayar

                        </span>

                        @elseif(
                        $i->status === 'pending' &&
                        $i->status_bukti === 'menunggu'
                        )

                        <span class="px-3 py-1.5 rounded-full
                                   bg-yellow-100 text-yellow-700
                                   text-sm font-semibold">

                            Menunggu Verifikasi

                        </span>

                        @elseif(
                        $i->status === 'pending' &&
                        $i->status_bukti === 'ditolak'
                        )

                        <span class="px-3 py-1.5 rounded-full
                                   bg-red-100 text-red-700
                                   text-sm font-semibold">

                            Ditolak

                        </span>

                        @elseif($i->status === 'lunas')

                        <span class="px-3 py-1.5 rounded-full
                                   bg-green-100 text-green-700
                                   text-sm font-semibold">

                            Lunas

                        </span>

                        @elseif($i->status === 'telat')

                        <span class="px-3 py-1.5 rounded-full
                                   bg-red-100 text-red-700
                                   text-sm font-semibold">

                            Telat

                        </span>

                        @endif

                    </td>

                    {{-- PEMBAYARAN --}}
                    <td class="px-6 py-4 min-w-[320px]">

                        {{-- SUDAH UPLOAD --}}
                        @if(
                        $i->pembayaran &&
                        $i->status_bukti !== 'ditolak'
                        )

                        <div class="bg-[#F8F5F0]
                                   rounded-2xl p-4">

                            <p class="text-sm text-gray-600 mb-4">

                                Bukti pembayaran sudah diupload.

                            </p>

                            {{-- PREVIEW --}}
                            <div class="relative group w-fit">

                                <img src="{{ asset('storage/' . $i->pembayaran->bukti_bayar) }}" class="w-32 h-32 object-cover rounded-2xl
                                           border border-gray-200 cursor-pointer" onclick="
                                        document.getElementById(
                                            'modal-{{ $i->id_tagihan }}'
                                        ).classList.remove('hidden')
                                    ">

                                <div class="absolute inset-0 bg-black/40
                                           rounded-2xl opacity-0
                                           group-hover:opacity-100
                                           transition flex items-center
                                           justify-center cursor-pointer" onclick="
                                        document.getElementById(
                                            'modal-{{ $i->id_tagihan }}'
                                        ).classList.remove('hidden')
                                    ">

                                    <span class="text-white text-sm font-semibold">

                                        Preview

                                    </span>

                                </div>

                            </div>

                        </div>

                        {{-- MODAL --}}
                        <div id="modal-{{ $i->id_tagihan }}" class="fixed inset-0 bg-black/70
                                   hidden z-50 flex items-center
                                   justify-center p-6">

                            <div class="relative">

                                {{-- CLOSE --}}
                                <button type="button" onclick="
                                        document.getElementById(
                                            'modal-{{ $i->id_tagihan }}'
                                        ).classList.add('hidden')
                                    " class="absolute -top-4 -right-4
                                           w-10 h-10 rounded-full
                                           bg-white text-black
                                           flex items-center
                                           justify-center shadow-lg">

                                    ✕

                                </button>

                                {{-- IMAGE --}}
                                <img src="{{ asset('storage/' . $i->pembayaran->bukti_bayar) }}" class="max-w-[90vw] max-h-[85vh]
                                           rounded-3xl shadow-2xl">

                            </div>

                        </div>

                        @else

                        {{-- FORM --}}
                        <form method="POST" enctype="multipart/form-data"
                            action="{{ route('penghuni.pembayaran.store') }}" class="space-y-3">

                            @csrf

                            <input type="hidden" name="id_tagihan" value="{{ $i->id_tagihan }}">

                            {{-- INPUT --}}
                            <div>

                                <label for="bukti-{{ $i->id_tagihan }}" class="border-2 border-dashed
                                           border-gray-300
                                           rounded-2xl p-4
                                           flex flex-col items-center
                                           justify-center cursor-pointer
                                           hover:border-[#6C8B6B]
                                           transition relative">

                                    {{-- PREVIEW --}}
                                    <div class="preview-wrapper hidden w-full">

                                        <div class="relative w-fit mx-auto">

                                            <img class="preview-image
                                                       w-28 h-28 object-cover
                                                       rounded-2xl border border-gray-200">

                                            {{-- REMOVE --}}
                                            <button type="button" class="remove-image
                                                       absolute -top-2 -right-2
                                                       w-7 h-7 rounded-full
                                                       bg-red-500 text-white
                                                       flex items-center
                                                       justify-center
                                                       text-sm shadow-lg">

                                                ✕

                                            </button>

                                        </div>

                                    </div>

                                    {{-- PLACEHOLDER --}}
                                    <div class="upload-placeholder text-center">

                                        <p class="font-semibold text-[#0F0937]">

                                            Upload bukti pembayaran

                                        </p>

                                        <p class="text-sm text-gray-400 mt-1">

                                            JPG, PNG, JPEG

                                        </p>

                                    </div>

                                    {{-- INPUT --}}
                                    <input id="bukti-{{ $i->id_tagihan }}" type="file" name="bukti_bayar"
                                        accept="image/*" class="hidden payment-input" required>

                                </label>

                            </div>

                            {{-- BUTTON --}}
                            <button type="submit" class="w-full bg-[#6C8B6B]
                                       hover:bg-[#5B765A]
                                       text-white py-3 rounded-2xl
                                       font-semibold transition">

                                Bayar Sekarang

                            </button>

                        </form>

                        @endif

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="5" class="px-6 py-10 text-center text-gray-500">

                        Belum ada tagihan.

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

{{-- ========================================================= --}}
{{-- PREVIEW --}}
{{-- ========================================================= --}}
<script>
document.querySelectorAll('.payment-input')
    .forEach(input => {

        input.addEventListener('change', function(e) {

            const file = e.target.files[0];

            if (!file) return;

            const wrapper =
                this.closest('label');

            const previewWrapper =
                wrapper.querySelector('.preview-wrapper');

            const previewImage =
                wrapper.querySelector('.preview-image');

            const placeholder =
                wrapper.querySelector('.upload-placeholder');

            const reader = new FileReader();

            reader.onload = function(ev) {

                previewImage.src = ev.target.result;

                previewImage.dataset.full =
                    ev.target.result;

                previewWrapper.classList.remove('hidden');

                placeholder.classList.add('hidden');

            }

            reader.readAsDataURL(file);

        });

    });

/*
|--------------------------------------------------------------------------
| REMOVE IMAGE
|--------------------------------------------------------------------------
*/

document.querySelectorAll('.remove-image')
    .forEach(btn => {

        btn.addEventListener('click', function(e) {

            e.preventDefault();

            e.stopPropagation();

            const wrapper =
                this.closest('label');

            const input =
                wrapper.querySelector('.payment-input');

            const previewWrapper =
                wrapper.querySelector('.preview-wrapper');

            const placeholder =
                wrapper.querySelector('.upload-placeholder');

            input.value = '';

            previewWrapper.classList.add('hidden');

            placeholder.classList.remove('hidden');

        });

    });

/*
|--------------------------------------------------------------------------
| PREVIEW IMAGE CLICK
|--------------------------------------------------------------------------
*/

document.querySelectorAll('.preview-image')
    .forEach(img => {

        img.addEventListener('click', function(e) {

            e.preventDefault();

            e.stopPropagation();

            const src =
                this.dataset.full;

            if (!src) return;

            /*
            |--------------------------------------------------------------------------
            | MODAL
            |--------------------------------------------------------------------------
            */

            const modal =
                document.createElement('div');

            modal.className =
                'fixed inset-0 bg-black/80 z-50 flex items-center justify-center p-6';

            modal.innerHTML = `

            <div class="relative">

                <button
                    class="absolute -top-4 -right-4
                           w-10 h-10 rounded-full
                           bg-white text-black
                           flex items-center justify-center"
                >

                    ✕

                </button>

                <img
                    src="${src}"
                    class="max-w-[90vw] max-h-[85vh]
                           rounded-3xl shadow-2xl"
                >

            </div>

        `;

            /*
            |--------------------------------------------------------------------------
            | CLOSE
            |--------------------------------------------------------------------------
            */

            modal.querySelector('button')
                .addEventListener('click', () => {

                    modal.remove();

                });

            modal.addEventListener('click', function(ev) {

                if (ev.target === modal) {

                    modal.remove();

                }

            });

            document.body.appendChild(modal);

        });

    });
</script>

@endsection