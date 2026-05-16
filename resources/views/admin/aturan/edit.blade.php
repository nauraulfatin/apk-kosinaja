@extends('layouts.admin')

@section('content')

<div class="p-6">

    <div class="bg-white rounded-2xl shadow p-6 max-w-3xl mx-auto">

        <h1 class="text-2xl font-bold text-[#5C3B1E] mb-5">
            Edit Aturan Kos
        </h1>

        <form action="{{ route('admin.aturan.update', $aturan->id_aturan) }}"
              method="POST">

            @csrf
            @method('PUT')

            <div class="mb-4">

                <label class="block mb-2 font-medium">
                    Isi Aturan
                </label>

                <textarea
                    name="isi_aturan"
                    rows="5"
                    class="w-full border rounded-xl px-4 py-3"
                    required>{{ $aturan->isi_aturan }}</textarea>

            </div>

            <button
                type="submit"
                class="bg-[#8B5E3C] hover:bg-[#6f472b] text-white px-5 py-3 rounded-xl">

                Update

            </button>

        </form>

    </div>

</div>

@endsection