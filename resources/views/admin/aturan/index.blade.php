@extends('layouts.admin')

@section('content')

<div class="p-6">

    <div class="flex justify-between mb-5">

        <!-- Judul -->
        <h1 class="text-2xl font-bold text-black">
            Aturan Kos
        </h1>

        <!-- Tombol Tambah -->
        <a href="{{ route('admin.aturan.create') }}"
           class="bg-[#6E8B74] text-white px-5 py-2 rounded-xl shadow hover:bg-[#5c7764] transition">
            Tambah
        </a>

    </div>

    <div class="bg-white rounded-2xl shadow p-5">

        @forelse($aturans as $aturan)

            <div class="border-b py-4 flex justify-between items-center">

                <div>
                    <p class="text-gray-700">
                        {{ $aturan->isi }}
                    </p>
                </div>

                <div class="flex gap-2">

                    <!-- Tombol Edit -->
                    <a href="{{ route('admin.aturan.edit', $aturan->id) }}"
                       class="bg-green-100 text-green-700 px-3 py-1 rounded-lg hover:bg-green-200 transition">
                        Edit
                    </a>

                    <!-- Tombol Hapus -->
                    <form action="{{ route('admin.aturan.destroy', $aturan->id) }}"
                          method="POST">

                        @csrf
                        @method('DELETE')

                        <button
                            onclick="return confirm('Yakin ingin menghapus aturan ini?')"
                            class="bg-red-500 text-white px-3 py-1 rounded-lg hover:bg-red-600 transition">
                            Hapus
                        </button>

                    </form>

                </div>

            </div>

        @empty

            <div class="text-center py-10 text-gray-400">
                Belum ada aturan kos
            </div>

        @endforelse

    </div>

</div>

@endsection