@extends('layouts.manager')

@section('content')
<div class="max-w-4xl mx-auto p-6">
    <h1 class="text-2xl font-bold text-white mb-6">Tambah Produk</h1>

    <form action="{{ route('manager.products.store') }}" method="POST" class="bg-slate-800 p-6 rounded-lg shadow">
        @csrf

        <div class="mb-4">
            <label for="code" class="block text-white font-medium mb-2">Kode Produk</label>
            <input type="text" name="code" id="code" class="w-full bg-slate-700 text-white border border-slate-600 rounded-lg p-2" required>
        </div>

        <div class="mb-4">
            <label for="name" class="block text-white font-medium mb-2">Nama Produk</label>
            <input type="text" name="name" id="name" class="w-full bg-slate-700 text-white border border-slate-600 rounded-lg p-2" required>
        </div>

        <div class="mb-4">
            <label for="category_id" class="block text-white font-medium mb-2">Kategori</label>
            <select name="category_id" id="category_id" class="w-full bg-slate-700 text-white border border-slate-600 rounded-lg p-2" required>
                <option value="" disabled selected>-- Pilih Kategori --</option>
                @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="price" class="block text-white font-medium mb-2">Harga</label>
            <input type="number" name="price" id="price" class="w-full bg-slate-700 text-white border border-slate-600 rounded-lg p-2" required>
        </div>

        <div class="mb-4">
            <label for="stock" class="block text-white font-medium mb-2">Stok</label>
            <input type="number" name="stock" id="stock" class="w-full bg-slate-700 text-white border border-slate-600 rounded-lg p-2" required>
        </div>

        <div class="mb-4">
            <label for="unit" class="block text-white font-medium mb-2">Satuan</label>
            <input type="text" name="unit" id="unit" class="w-full bg-slate-700 text-white border border-slate-600 rounded-lg p-2" required>
        </div>

        <div class="mb-6">
            <label for="description" class="block text-white font-medium mb-2">Deskripsi</label>
            <textarea name="description" id="description" rows="4" class="w-full bg-slate-700 text-white border border-slate-600 rounded-lg p-2"></textarea>
        </div>

        <div class="flex justify-end">
            <a href="{{ route('manager.products.index') }}" class="text-gray-300 hover:underline mr-4">Batal</a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">Simpan</button>
        </div>
    </form>
</div>
@endsection
