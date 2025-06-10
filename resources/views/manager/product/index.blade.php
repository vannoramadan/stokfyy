@extends('layouts.manager') {{-- Sesuaikan jika layout utamamu bernama lain --}}

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Daftar Produk</h1>

    <a href="{{ route('manager.products.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block">+ Tambah Produk</a>

    <div class="overflow-x-auto">
        <table class="table-auto w-full bg-black shadow rounded-lg">
            <thead class="bg-gray-500">
                <tr>
                    <th class="px-4 py-2 text-left">#</th>
                    <th class="px-4 py-2 text-left">Nama Produk</th>
                    <th class="px-4 py-2 text-left">Kategori</th>
                    <th class="px-4 py-2 text-left">Harga</th>
                    <th class="px-4 py-2 text-left">Stok</th>
                    <th class="px-4 py-2 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $index => $product)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $index + 1 }}</td>
                    <td class="px-4 py-2">{{ $product->name }}</td>
                    <td class="px-4 py-2">{{ $product->category->name ?? '-' }}</td>
                    <td class="px-4 py-2">Rp{{ number_format($product->price, 0, ',', '.') }}</td>
                    <td class="px-4 py-2">{{ $product->stock }}</td>
                    <td class="px-4 py-2">
                        <a href="{{ route('manager.products.show', $product->id) }}" class="text-blue-500 hover:underline">Lihat</a>
                        |
                        <a href="{{ route('manager.products.edit', $product->id) }}" class="text-yellow-500 hover:underline">Edit</a>
                        |
                        <form action="{{ route('manager.products.destroy', $product->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus produk ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:underline">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-gray-500">Belum ada produk.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
