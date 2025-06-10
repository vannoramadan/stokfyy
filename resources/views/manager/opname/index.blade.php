@extends('layouts.manager')

@section('content')
<div class="max-w-5xl mx-auto p-6">
    <h1 class="text-2xl font-bold text-white mb-6">Stock Opname</h1>

    {{-- Form Pencatatan Opname --}}
    <div class="bg-slate-800 p-6 rounded-lg shadow mb-8">
        <form method="POST" action="{{ route('manager.opname.store') }}" class="space-y-4">
            @csrf

            <div>
                <label for="product_id" class="block text-sm font-medium text-gray-200 mb-1">Produk</label>
                <select name="product_id" id="product_id" required class="w-full bg-slate-700 text-white border border-gray-700 rounded px-3 py-2">
                    <option value="">-- Pilih Produk --</option>
                    @foreach($products as $product)
                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex flex-col md:flex-row md:space-x-4 space-y-4 md:space-y-0">
                <div class="w-full md:w-1/2">
                    <label for="system_stock" class="block text-sm font-medium text-gray-200 mb-1">Stok Sistem</label>
                    <input type="number" name="system_stock" id="system_stock" required min="0" class="w-full bg-slate-700 text-white border border-gray-700 rounded px-3 py-2">
                </div>
                <div class="w-full md:w-1/2">
                    <label for="physical_stock" class="block text-sm font-medium text-gray-200 mb-1">Stok Fisik</label>
                    <input type="number" name="physical_stock" id="physical_stock" required min="0" class="w-full bg-slate-700 text-white border border-gray-700 rounded px-3 py-2">
                </div>
            </div>

            <div>
                <label for="note" class="block text-sm font-medium text-gray-200 mb-1">Catatan (opsional)</label>
                <textarea name="note" id="note" rows="3" class="w-full bg-slate-700 text-white border border-gray-700 rounded px-3 py-2"></textarea>
            </div>

            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded transition">
                Simpan
            </button>
        </form>
    </div>

    {{-- Tabel Data Opname --}}
    <div class="bg-slate-800 p-6 rounded-lg shadow">
        <h2 class="text-xl font-semibold text-white mb-4">Riwayat Opname</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left text-white">
                <thead>
                    <tr class="bg-slate-700 text-gray-200">
                        <th class="px-4 py-2">#</th>
                        <th class="px-4 py-2">Produk</th>
                        <th class="px-4 py-2">Stok Sistem</th>
                        <th class="px-4 py-2">Stok Fisik</th>
                        <th class="px-4 py-2">Selisih</th>
                        <th class="px-4 py-2">Catatan</th>
                        <th class="px-4 py-2">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($opnames as $index => $item)
                    <tr class="border-b border-gray-700">
                        <td class="px-4 py-2">{{ $index + 1 }}</td>
                        <td class="px-4 py-2">{{ $item->product->name ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $item->system_stock }}</td>
                        <td class="px-4 py-2">{{ $item->physical_stock }}</td>
                        <td class="px-4 py-2">{{ $item->physical_stock - $item->system_stock }}</td>
                        <td class="px-4 py-2">{{ $item->note ?? '-' }}</td>
                        <td class="px-4 py-2">{{ \Carbon\Carbon::parse($item->opname_date)->format('d-m-Y H:i') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-gray-400">Belum ada data stock opname.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
