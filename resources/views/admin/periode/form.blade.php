@extends('layouts.app')

@section('content')
<div class="card">
    <h2>{{ $item->exists ? 'Edit' : 'Tambah' }} Periode</h2>
    <p class="muted">Nama periode adalah label yang tampil di aplikasi. Jumlah dan satuan interval dipakai sistem untuk menghitung jumlah tagihan.</p>

    <form method="post" action="{{ $item->exists ? route('admin.periode.update', $item) : route('admin.periode.store') }}">
        @csrf
        @if($item->exists)
            @method('put')
        @endif

        <label>Nama Periode Penagihan</label>
        <input name="periode_penagihan" value="{{ old('periode_penagihan', $item->periode_penagihan) }}" placeholder="Contoh: Bulanan, 3 Bulan, Semester">

        <label>Jumlah Interval</label>
        <input type="number" min="1" name="jumlah_interval" value="{{ old('jumlah_interval', $item->jumlah_interval ?? 1) }}" placeholder="Contoh: 1, 3, 6">

        <label>Satuan Interval</label>
        <select name="satuan_interval">
            @foreach(['hari' => 'Hari', 'minggu' => 'Minggu', 'bulan' => 'Bulan', 'tahun' => 'Tahun'] as $value => $label)
                <option value="{{ $value }}" @selected(old('satuan_interval', $item->satuan_interval ?? 'bulan') === $value)>{{ $label }}</option>
            @endforeach
        </select>

        <button>Simpan</button>
        <a class="btn muted" href="{{ route('admin.periode.index') }}">Batal</a>
    </form>
</div>
@endsection
