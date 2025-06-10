@extends('layouts.manager')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">📦 Laporan Stok</h1>
        <span class="text-sm text-gray-500">Periode: {{ $start }} - {{ $end }}</span>
    </div>

    <div class="overflow-x-auto rounded-xl shadow">
        <table class="w-full text-sm text-left text-gray-100">
            <thead class="text-xs uppercase bg-gray-500 text-gray-100">
                <tr>
                    <th class="px-4 py-3">Nama Produk</th>
                    <th class="px-4 py-3">Kategori</th>
                    <th class="px-4 py-3 text-center">Stok Sekarang</th>
                    <th class="px-4 py-3 text-center">Total Masuk</th>
                    <th class="px-4 py-3 text-center">Total Keluar</th>
                </tr>
            </thead>
            <tbody class="bg-black divide-y">
                @forelse ($reports as $product)
                <tr>
                    <td class="px-4 py-3">{{ $product->name }}</td>
                    <td class="px-4 py-3">{{ $product->category->name ?? '-' }}</td>
                    <td class="px-4 py-3 text-center">{{ $product->stock }}</td>
                    <td class="px-4 py-3 text-center text-green-600 font-semibold">
                        {{ $product->total_incoming }}
                    </td>
                    <td class="px-4 py-3 text-center text-red-600 font-semibold">
                        {{ $product->total_outgoing }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-4 py-3 text-center text-gray-500">Tidak ada data stok untuk periode ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
