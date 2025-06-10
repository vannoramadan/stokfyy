@extends('layouts.manager')

@section('content')
<div class="max-w-4xl mx-auto p-6">
    <h1 class="text-2xl font-bold text-white mb-6">Tambah Transaksi Stok</h1>

    @if(session('error'))
    <div class="bg-red-800 text-red-100 px-4 py-2 rounded mb-4">
        {{ session('error') }}
    </div>
    @endif

    <form action="{{ route('manager.stock.store') }}" method="POST" class="space-y-6 bg-slate-800 p-6 rounded-lg shadow">
        @csrf

        <div>
            <label for="product_id" class="block text-white font-medium mb-2">Produk</label>
            <select name="product_id" id="product_id" required class="w-full bg-slate-700 text-white border border-slate-600 rounded-lg p-2">
                <option value="" disabled selected>-- Pilih Produk --</option>
                @foreach ($products as $product)
                <option value="{{ $product->id }}">{{ $product->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="type" class="block text-white font-medium mb-2">Tipe Transaksi</label>
            <select name="type" id="type" required class="w-full bg-slate-700 text-white border border-slate-600 rounded-lg p-2">
                <option value="in">Masuk</option>
                <option value="out">Keluar</option>
            </select>
        </div>

        <div>
            <label for="quantity" class="block text-white font-medium mb-2">Jumlah</label>
            <input type="number" name="quantity" id="quantity" min="1" required class="w-full bg-slate-700 text-white border border-slate-600 rounded-lg p-2" />
        </div>

        <div>
            <label for="transaction_date" class="block text-white font-medium mb-2">Tanggal</label>
            <input type="date" name="transaction_date" id="transaction_date" required class="w-full bg-slate-700 text-white border border-slate-600 rounded-lg p-2">
        </div>

        <div>
            <label for="note" class="block text-white font-medium mb-2">Keterangan</label>
            <textarea name="note" id="note" required rows="3" class="w-full bg-slate-700 text-white border border-slate-600 rounded-lg p-2"></textarea>
        </div>

        <div class="flex justify-end">
            <a href="{{ route('manager.stock.index') }}" class="text-gray-300 hover:underline mr-4">Kembali</a>
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg">Simpan</button>
        </div>
    </form>
</div>
@endsection