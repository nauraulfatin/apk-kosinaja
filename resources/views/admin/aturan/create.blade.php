@extends('layouts.admin')

@section('content')

<div class="p-6">

    <div class="bg-white rounded-2xl shadow p-6 max-w-3xl mx-auto">

       <h1 class="text-3xl font-bold text-black">
            Tambah Aturan Kos
        </h1>

        <form action="{{ route('admin.aturan.store') }}"
              method="POST">

            @csrf

            <div class="mb-4">

                <label class="block mb-2 font-medium">
                    Isi Aturan
                </label>

                <textarea
                    name="isi_aturan"
                    rows="5"
                    class="w-full border rounded-xl px-4 py-3"
                    required></textarea>

            </div>

            <button
                type="submit"
                class="bg-[#3A5C3A] hover:bg-[#2f4b2f] text-white px-6 py-3 rounded-xl transition"
>
                 Simpan
            </button>

        </form>

    </div>

</div>

@endsection