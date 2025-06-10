@extends('layouts.manager')

@section('content')
<div class="max-w-3xl mx-auto bg-white dark:bg-slate-800 p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">Edit Produk</h2>

    <form action="{{ route('manager.products.update', $product->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <!-- Kode Produk -->
        <div>
            <label for="code" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kode Produk</label>
            <input type="text" name="code" id="code" value="{{ old('code', $product->code) }}" class="mt-1 block w-full rounded-md dark:bg-slate-700 dark:text-white" required>
        </div>

        <!-- Nama Produk -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Produk</label>
            <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" class="mt-1 block w-full rounded-md dark:bg-slate-700 dark:text-white" required>
        </div>

        <!-- Kategori -->
        <div>
            <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kategori</label>
            <select name="category_id" id="category_id" class="mt-1 block w-full rounded-md dark:bg-slate-700 dark:text-white" required>
                @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
                @endforeach
            </select>
        </div>

        <!-- Harga -->
        <div>
            <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Harga</label>
            <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}" class="mt-1 block w-full rounded-md dark:bg-slate-700 dark:text-white" required>
        </div>

        <!-- Satuan -->
        <div>
            <label for="unit" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Satuan</label>
            <input type="text" name="unit" id="unit" value="{{ old('unit', $product->unit) }}" class="mt-1 block w-full rounded-md dark:bg-slate-700 dark:text-white" required>
        </div>

        <!-- Stok -->
        <div>
            <label for="stock" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Stok</label>
            <input type="number" name="stock" id="stock" value="{{ old('stock', $product->stock) }}" class="mt-1 block w-full rounded-md dark:bg-slate-700 dark:text-white" required>
        </div>

        <!-- Deskripsi -->
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Deskripsi</label>
            <textarea name="description" id="description" class="mt-1 block w-full rounded-md dark:bg-slate-700 dark:text-white">{{ old('description', $product->description) }}</textarea>
        </div>

        <!-- Tombol Aksi -->
        <div class="flex justify-end gap-2">
            <a href="{{ route('manager.products.index') }}" class="px-4 py-2 bg-gray-300 dark:bg-gray-600 text-black dark:text-white rounded hover:bg-gray-400 dark:hover:bg-gray-700">Batal</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection
