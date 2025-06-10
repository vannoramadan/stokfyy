@extends('layouts.manager')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">Laporan Transaksi</h1>

    <div class="overflow-x-auto bg-white p-4 rounded shadow">
        <table class="min-w-full table-auto">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-4 py-2">#</th>
                    <th class="px-4 py-2">Produk</th>
                    <th class="px-4 py-2">Tipe</th>
                    <th class="px-4 py-2">Jumlah</th>
                    <th class="px-4 py-2">Tanggal</th>
                    <th class="px-4 py-2">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $index => $transaction)
                <tr class="border-b">
                    <td class="px-4 py-2">{{ $index + 1 }}</td>
                    <td class="px-4 py-2">{{ $transaction->product->name ?? '-' }}</td>
                    <td class="px-4 py-2 capitalize">{{ $transaction->type }}</td>
                    <td class="px-4 py-2">{{ $transaction->quantity }}</td>
                    <td class="px-4 py-2">{{ $transaction->date }}</td>
                    <td class="px-4 py-2">{{ $transaction->notes ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4">Tidak ada data transaksi.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
