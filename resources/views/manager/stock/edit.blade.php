@extends('layouts.manager')

@section('content')
<div class="max-w-3xl mx-auto bg-white dark:bg-slate-800 shadow-md rounded-lg p-6">
    <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">Edit Transaksi Stok</h2>

    <form action="{{ route('manager.stock.update', $transaction->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <!-- Tanggal Transaksi -->
        <div>
            <label for="transaction_date" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Tanggal Transaksi</label>
            <input type="date" name="transaction_date" id="transaction_date" value="{{ \Carbon\Carbon::parse($transaction->transaction_date)->format('Y-m-d') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-slate-700 dark:text-white" required>
        </div>

        <!-- Produk -->
        <div>
            <label for="product_id" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Produk</label>
            <select name="product_id" id="product_id" class="mt-1 block w-full rounded-md dark:bg-slate-700 dark:text-white" required>
                @foreach ($products as $product)
                <option value="{{ $product->id }}" {{ $transaction->product_id == $product->id ? 'selected' : '' }}>
                    {{ $product->name }}
                </option>
                @endforeach
            </select>
        </div>

        <!-- Supplier -->
        <div>
            <label for="supplier_id" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Supplier</label>
            <select name="supplier_id" id="supplier_id" class="mt-1 block w-full rounded-md dark:bg-slate-700 dark:text-white" required>
                @foreach ($suppliers as $supplier)
                <option value="{{ $supplier->id }}" {{ $transaction->supplier_id == $supplier->id ? 'selected' : '' }}>
                    {{ $supplier->name }}
                </option>
                @endforeach
            </select>
        </div>

        <!-- Jumlah -->
        <div>
            <label for="quantity" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Jumlah</label>
            <input type="number" name="quantity" id="quantity" min="1" value="{{ $transaction->quantity }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-slate-700 dark:text-white" required>
        </div>

        <!-- Tipe Transaksi -->
        <div>
            <label for="type" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Tipe Transaksi</label>
            <select name="type" id="type" class="mt-1 block w-full rounded-md dark:bg-slate-700 dark:text-white" required>
                <option value="in" {{ $transaction->type == 'in' ? 'selected' : '' }}>Masuk</option>
                <option value="out" {{ $transaction->type == 'out' ? 'selected' : '' }}>Keluar</option>
            </select>
        </div>

        <!-- Catatan -->
        <div>
            <label for="note" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Catatan</label>
            <textarea name="note" id="note" rows="3" class="mt-1 block w-full rounded-md dark:bg-slate-700 dark:text-white">{{ $transaction->note }}</textarea>
        </div>

        <!-- Tombol -->
        <div class="flex justify-end gap-2">
            <a href="{{ route('manager.stock.index') }}" class="px-4 py-2 bg-gray-300 dark:bg-gray-600 text-black dark:text-white rounded hover:bg-gray-400 dark:hover:bg-gray-700">Batal</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Perbarui</button>
        </div>
    </form>
</div>
@endsection
