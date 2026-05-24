@extends('layouts.admin')

@section('content')

<div class="p-6">

    <div class="bg-white rounded-2xl shadow p-6 max-w-3xl mx-auto">

        <h1 class="text-2xl font-bold text-black mb-5">
            Edit Aturan Kos
        </h1>

        <form action="{{ route('admin.aturan.update', $aturan->id) }}"
              method="POST">

            @csrf
            @method('PUT')

            <div class="mb-4">

                <label class="block mb-2 font-medium text-black">
                    Isi Aturan
                </label>

                <textarea
                    name="isi_aturan"
                    rows="5"
                    class="w-full border rounded-xl px-4 py-3"
                    required>{{ old('isi_aturan', $aturan->isi) }}</textarea>

            </div>

            <button
                type="submit"
                class="bg-[#6E8B74] hover:bg-[#5c7764] text-white px-5 py-3 rounded-xl transition">

                Update

            </button>

        </form>

    </div>

</div>

@endsection