@extends('layouts.app')

@section('content')
<div class="card">
    <h2>Periode Penagihan</h2>
    <a class="btn" href="{{ route('admin.periode.create') }}">Tambah</a>
    <a class="btn muted" href="{{ route('admin.dashboard') }}">Kembali</a>
</div>

<table>
    <tr>
        <th>ID</th>
        <th>Periode</th>
        <th>Interval Hitung</th>
        <th>Aksi</th>
    </tr>
    @foreach($items as $i)
        <tr>
            <td>{{ $i->id_penagihan }}</td>
            <td>{{ $i->periode_penagihan }}</td>
            <td>Setiap {{ $i->jumlah_interval }} {{ $i->satuan_interval }}</td>
            <td>
                <a class="btn" href="{{ route('admin.periode.edit', $i) }}">Edit</a>
                <form method="post" action="{{ route('admin.periode.destroy', $i) }}" style="display:inline" onsubmit="return confirm('Hapus periode ini?')">
                    @csrf
                    @method('delete')
                    <button class="danger">Hapus</button>
                </form>
            </td>
        </tr>
    @endforeach
</table>
@endsection
