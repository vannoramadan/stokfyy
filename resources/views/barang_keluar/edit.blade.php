@extends('layouts.staff')

@section('content')
<div class="container">
    <h3>Edit Barang Keluar</h3>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('barang-keluar.update', $barang->id) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3">
            <label for="nama_barang" class="form-label">Nama Barang</label>
            <input type="text" name="nama_barang" value="{{ $barang->nama_barang }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah</label>
            <input type="number" name="jumlah" value="{{ $barang->jumlah }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="tanggal_keluar" class="form-label">Tanggal Keluar</label>
            <input type="date" name="tanggal_keluar" value="{{ $barang->tanggal_keluar }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="catatan" class="form-label">Catatan</label>
            <textarea name="catatan" class="form-control">{{ $barang->catatan }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
