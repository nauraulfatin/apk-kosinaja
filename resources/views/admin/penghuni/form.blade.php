@extends('layouts.app')

@section('content')
<div class="card">
    <h2>Tambah Penghuni</h2>
    <form method="post" action="{{ route('admin.penghuni.store') }}">
        @csrf
        <label>Username</label>
        <input name="username" value="{{ old('username') }}">

        <label>NIK</label>
        <input name="nik" value="{{ old('nik') }}">

        <label>Nama</label>
        <input name="nama" value="{{ old('nama') }}">

        <label>No HP</label>
        <input name="no_hp" value="{{ old('no_hp') }}">

        <label>Password</label>
        <input type="password" name="password">

        <label>Konfirmasi Password</label>
        <input type="password" name="password_confirmation">

        <label>Kamar Kosong</label>
        <select name="id_kamar" id="kamar">
            <option value="">Pilih kamar</option>
            @foreach($kamars as $k)
                <option value="{{ $k->id_kamar }}" @selected(old('id_kamar') == $k->id_kamar)>{{ $k->nama_kamar }} - {{ $k->nomor_kamar }}</option>
            @endforeach
        </select>

        <label>Harga Kamar</label>
        <select name="id_harga_kamar" id="harga-kamar">
            <option value="">Pilih harga kamar</option>
            @foreach($kamars as $k)
                @foreach($k->hargaKamars as $h)
                    <option value="{{ $h->id_harga_kamar }}" data-kamar="{{ $k->id_kamar }}" @selected(old('id_harga_kamar') == $h->id_harga_kamar)>
                        {{ $k->nama_kamar }} - Rp {{ number_format($h->harga, 0, ',', '.') }} / {{ $h->periode?->periode_penagihan }}
                        @if($h->periode)
                            (setiap {{ $h->periode->jumlah_interval }} {{ $h->periode->satuan_interval }})
                        @endif
                    </option>
                @endforeach
            @endforeach
        </select>

        <label>Tanggal Mulai</label>
        <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}">

        <label>Tanggal Selesai</label>
        <input type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}">

        <button>Simpan dan Generate Tagihan</button>
    </form>
</div>

<script>
    const kamarSelect = document.getElementById('kamar');
    const hargaSelect = document.getElementById('harga-kamar');

    function filterHargaByKamar() {
        const selectedKamar = kamarSelect.value;
        [...hargaSelect.options].forEach((option) => {
            if (!option.dataset.kamar) return;
            option.hidden = selectedKamar && option.dataset.kamar !== selectedKamar;
        });

        const selectedOption = hargaSelect.options[hargaSelect.selectedIndex];
        if (selectedOption && selectedOption.hidden) {
            hargaSelect.value = '';
        }
    }

    kamarSelect.addEventListener('change', filterHargaByKamar);
    filterHargaByKamar();
</script>
@endsection
