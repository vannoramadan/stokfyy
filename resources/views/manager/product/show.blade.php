@extends('layouts.manager')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Detail Produk</h1>

    <div class="bg-white shadow rounded-lg p-6">
        <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
            <div>
                <dt class="text-sm font-medium text-gray-500">Nama Produk</dt>
                <dd class="text-lg font-semibold text-gray-900">{{ $product->name }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Kategori</dt>
                <dd class="text-lg font-semibold text-gray-900">{{ $product->category->name }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Harga</dt>
                <dd class="text-lg font-semibold text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Stok</dt>
                <dd class="text-lg font-semibold text-gray-900">{{ $product->stock }}</dd>
            </div>
            <div class="md:col-span-2">
                <dt class="text-sm font-medium text-gray-500">Deskripsi</dt>
                <dd class="text-gray-900">{{ $product->description ?: '-' }}</dd>
            </div>
        </dl>

        <div class="mt-6 flex justify-between">
            <a href="{{ route('manager.products.index') }}" class="text-blue-600 hover:underline">← Kembali ke daftar</a>
            <a href="{{ route('manager.products.edit', $product->id) }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Edit Produk</a>
        </div>
    </div>
</div>
@endsection
