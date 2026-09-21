@extends('layouts.admin')

@section('content')

<div class="max-w-4xl mx-auto">

    {{-- HEADER --}}

    <div class="mb-8">

        <h1 class="text-3xl font-bold text-[#0F0937]">

            {{ $item->exists ? 'Edit Kamar' : 'Tambah Kamar' }}

        </h1>

        <p class="text-gray-500 mt-2">

            {{ $item->exists
                ? 'Perbarui informasi kamar kost'
                : 'Tambahkan kamar baru ke kost anda'
            }}

        </p>

    </div>


    {{-- FORM --}}

    <form
        method="POST"
        action="{{ $item->exists
            ? route('admin.kamar.update', $item)
            : route('admin.kamar.store')
        }}"
        enctype="multipart/form-data"
        class="space-y-6"
    >

        @csrf

        @if($item->exists)
            @method('PUT')
        @endif


        {{-- INFORMASI KAMAR --}}

        <div
            class="bg-white rounded-2xl shadow-sm
                   border border-gray-100 p-6"
        >

            <h2 class="text-lg font-semibold text-[#0F0937] mb-6">

                Informasi Kamar

            </h2>


            {{-- NAMA KAMAR --}}

            <div class="mb-5">

                <label
                    for="nama_kamar"
                    class="block text-sm font-medium
                           text-gray-700 mb-2"
                >

                    Nama Kamar

                </label>

                <input
                    type="text"
                    id="nama_kamar"
                    name="nama_kamar"
                    value="{{ old(
                        'nama_kamar',
                        $item->nama_kamar
                    ) }}"
                    class="w-full rounded-xl border
                           border-gray-200 px-4 py-3
                           focus:border-[#6C8B6B]
                           focus:ring-[#6C8B6B]"
                    placeholder="Contoh: Kamar A"
                    required
                >

                @error('nama_kamar')
                    <p class="text-red-500 text-xs mt-1">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- NOMOR KAMAR --}}

            <div class="mb-5">

                <label
                    for="nomor_kamar"
                    class="block text-sm font-medium
                           text-gray-700 mb-2"
                >

                    Nomor Kamar

                </label>

                <input
                    type="text"
                    id="nomor_kamar"
                    name="nomor_kamar"
                    value="{{ old(
                        'nomor_kamar',
                        $item->nomor_kamar
                    ) }}"
                    class="w-full rounded-xl border
                           border-gray-200 px-4 py-3
                           focus:border-[#6C8B6B]
                           focus:ring-[#6C8B6B]"
                    placeholder="Contoh: A01"
                    required
                >

                @error('nomor_kamar')
                    <p class="text-red-500 text-xs mt-1">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- UKURAN KAMAR --}}

            <div>

                <label
                    for="ukuran_kamar"
                    class="block text-sm font-medium
                           text-gray-700 mb-2"
                >

                    Ukuran Kamar

                </label>

                <input
                    type="text"
                    id="ukuran_kamar"
                    name="ukuran_kamar"
                    value="{{ old(
                        'ukuran_kamar',
                        $item->ukuran_kamar
                    ) }}"
                    class="w-full rounded-xl border
                           border-gray-200 px-4 py-3
                           focus:border-[#6C8B6B]
                           focus:ring-[#6C8B6B]"
                    placeholder="Contoh: 3 x 4 meter"
                >

                @error('ukuran_kamar')
                    <p class="text-red-500 text-xs mt-1">
                        {{ $message }}
                    </p>
                @enderror

            </div>

        </div>


        {{-- FASILITAS --}}

        <div
            class="bg-white rounded-2xl shadow-sm
                   border border-gray-100 p-6"
        >

            <div class="mb-5">

                <h2 class="text-lg font-semibold text-[#0F0937]">

                    Fasilitas Kamar

                </h2>

                <p class="text-sm text-gray-500 mt-1">

                    Pilih fasilitas yang tersedia di kamar ini.

                </p>

            </div>


            @php
                $selectedFasilitas = old(
                    'fasilitas',
                    $selected ?? []
                );
            @endphp


            @if($fasilitas->count())

                <div class="grid grid-cols-1
                            sm:grid-cols-2
                            md:grid-cols-3
                            gap-3">

                    @foreach($fasilitas as $fasilitasItem)

                        <label
                            class="flex items-center gap-3
                                   p-3 rounded-xl
                                   border border-gray-200
                                   hover:bg-gray-50
                                   cursor-pointer
                                   transition"
                        >

                            <input
                                type="checkbox"
                                name="fasilitas[]"
                                value="{{ $fasilitasItem->id_fasilitas }}"
                                class="rounded
                                       border-gray-300
                                       text-[#6C8B6B]
                                       focus:ring-[#6C8B6B]"
                                {{ in_array(
                                    $fasilitasItem->id_fasilitas,
                                    $selectedFasilitas
                                ) ? 'checked' : '' }}
                            >

                            <span
                                class="text-sm text-gray-700"
                            >

                                {{ $fasilitasItem->nama_fasilitas }}

                            </span>

                        </label>

                    @endforeach

                </div>

            @else

                <div
                    class="rounded-xl bg-gray-50
                           p-4 text-sm text-gray-500"
                >

                    Belum ada data fasilitas.

                </div>

            @endif


            @error('fasilitas')
                <p class="text-red-500 text-xs mt-2">
                    {{ $message }}
                </p>
            @enderror

        </div>


  {{-- FOTO KAMAR --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">

<h2 class="text-lg font-semibold text-[#0F0937] mb-5">
    Foto Kamar
</h2>

<label class="block text-sm font-medium text-gray-700 mb-3">
    Tambahkan Foto
</label>

<input type="file"
       id="foto_kamar"
       name="foto_kamar[]"
       accept="image/jpeg,image/png,image/webp"
       multiple
       class="hidden">


<label for="foto_kamar"
       class="inline-flex items-center px-5 py-3 rounded-xl border border-gray-200 cursor-pointer hover:bg-gray-50 text-sm font-medium">
    Pilih Foto
</label>


<p id="jumlah-foto"
   class="mt-4 text-sm text-gray-500">
    Belum ada foto dipilih
</p>


<div id="preview-foto"
     class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 mt-6">
</div>


<p class="text-xs text-gray-400 mt-4">
    Format JPG, JPEG, PNG, atau WEBP. Maksimal 5MB per foto.
</p>


@error('foto_kamar')
<p class="text-red-500 text-xs mt-2">
    {{ $message }}
</p>
@enderror


@error('foto_kamar.*')
<p class="text-red-500 text-xs mt-2">
    {{ $message }}
</p>
@enderror



@if($item->exists && !empty($item->foto_kamar))

<div class="mt-8">

<p class="text-sm font-medium text-gray-700 mb-4">
    Foto Saat Ini
</p>


<div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">

@foreach($item->foto_kamar as $index => $foto)

<div class="relative rounded-xl overflow-hidden border">

<img src="{{ asset('storage/'.$foto) }}"
     class="w-full h-32 object-cover">


@if($index == 0)

<span class="absolute top-2 left-2 bg-[#6C8B6B] text-white text-xs px-2 py-1 rounded-full">
Foto Utama
</span>

@endif

</div>

@endforeach

</div>

</div>

@endif

</div>

        {{-- BUTTON --}}

        <div class="flex items-center
                    justify-end gap-3">

            <a
                href="{{ route('admin.kamar.index') }}"
                class="px-5 py-2.5 rounded-xl
                       border border-gray-200
                       text-gray-600
                       hover:bg-gray-50
                       text-sm font-semibold
                       transition"
            >

                Batal

            </a>


            <button
                type="submit"
                class="px-5 py-2.5 rounded-xl
                       bg-[#6C8B6B]
                       hover:bg-[#5B765A]
                       text-white
                       text-sm font-semibold
                       transition"
            >

                {{ $item->exists
                    ? 'Update Kamar'
                    : 'Simpan Kamar'
                }}

            </button>

        </div>

    </form>

</div>

<script>

let daftarFoto=[];

const inputFoto=document.getElementById('foto_kamar');
const preview=document.getElementById('preview-foto');
const jumlah=document.getElementById('jumlah-foto');


inputFoto.addEventListener('change',function(){

    Array.from(this.files).forEach(file=>{

        if(file.type.startsWith('image/')){
            daftarFoto.push(file);
        }

    });

    updatePreview();

    sinkronFile();

});


function updatePreview(){

    preview.innerHTML='';

    jumlah.innerHTML =
        daftarFoto.length
        ? daftarFoto.length+' foto dipilih'
        : 'Belum ada foto dipilih';


    daftarFoto.forEach((file,index)=>{

        let reader=new FileReader();


        reader.onload=function(e){

            preview.innerHTML+=`

            <div class="relative rounded-xl overflow-hidden border">

                <img src="${e.target.result}"
                     class="w-full h-36 object-cover">


                <button type="button"
                onclick="hapusFoto(${index})"
                class="absolute top-2 right-2
                bg-red-500 text-white
                w-8 h-8 rounded-full">

                ✕

                </button>

            </div>

            `;

        };


        reader.readAsDataURL(file);

    });

}



function hapusFoto(index){

    daftarFoto.splice(index,1);

    sinkronFile();

    updatePreview();

}



function sinkronFile(){

    let dataTransfer=new DataTransfer();


    daftarFoto.forEach(file=>{

        dataTransfer.items.add(file);

    });


    inputFoto.files=dataTransfer.files;

}

</script>
@endsection