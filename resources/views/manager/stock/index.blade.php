@extends('layouts.manager')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-100 mb-2">Daftar Transaksi Stok</h2>
        <a href="{{ route('manager.stock.create') }}" class="mt-3 inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
            + Tambah Transaksi
        </a>
    </div>

    <div class="bg-black shadow-md rounded-lg overflow-x-auto">
        <table class="min-w-full text-sm text-left text-gray-100">
            <thead class="bg-gray-500 text-gray-100 text-sm font-semibold">
                <tr>
                    <th class="px-6 py-3">Tanggal</th>
                    <th class="px-6 py-3">Produk</th>
                    <th class="px-6 py-3">Tipe</th>
                    <th class="px-6 py-3">Jumlah</th>
                    <th class="px-6 py-3">Keterangan</th>
                    <th class="px-6 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($transactions as $transaction)
                <tr class="border-b hover:bg-gray-900">
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ \Carbon\Carbon::parse($transaction->transaction_date)->format('d M Y') }}
                    </td>
                    <td class="px-6 py-4">{{ $transaction->product->name }}</td>
                    <td class="px-6 py-4">
                        @if($transaction->type === 'in')
                        <span class="text-green-600 font-semibold">Masuk</span>
                        @else
                        <span class="text-red-600 font-semibold">Keluar</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">{{ $transaction->quantity }}</td>
                    <td class="px-6 py-4">{{ $transaction->note ?? '-' }}</td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <a href="{{ route('manager.stock.edit', $transaction->id) }}" class="text-blue-600 hover:underline">Edit</a>
                        <form action="{{ route('manager.stock.destroy', $transaction->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">Belum ada transaksi stok.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
