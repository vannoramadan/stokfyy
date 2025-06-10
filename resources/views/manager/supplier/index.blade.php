@extends('layouts.manager')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold text-white mb-6">Manajemen Supplier</h1>

    {{-- Form Tambah Supplier --}}
    <div class="bg-slate-800 p-6 rounded-lg shadow mb-8">
        <form action="{{ route('manager.suppliers.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-white mb-1">Nama Supplier</label>
                    <input type="text" name="name" id="name" class="w-full bg-slate-700 text-white border border-slate-600 rounded p-2" required>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-white mb-1">Email</label>
                    <input type="email" name="email" id="email" class="w-full bg-slate-700 text-white border border-slate-600 rounded p-2">
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-white mb-1">Nomor Telepon</label>
                    <input type="text" name="phone" id="phone" class="w-full bg-slate-700 text-white border border-slate-600 rounded p-2">
                </div>

                <div>
                    <label for="address" class="block text-sm font-medium text-white mb-1">Alamat</label>
                    <textarea name="address" id="address" rows="2" class="w-full bg-slate-700 text-white border border-slate-600 rounded p-2"></textarea>
                </div>
            </div>
            <div class="mt-6">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                    Tambah Supplier
                </button>
            </div>
        </form>
    </div>

    {{-- Tabel Supplier --}}
    <div class="bg-slate-800 p-4 rounded-lg shadow">
        <h2 class="text-xl font-semibold text-white mb-4">Daftar Supplier</h2>
        <table class="min-w-full table-auto text-white">
            <thead>
                <tr class="bg-slate-700 text-white">
                    <th class="px-4 py-2 text-left">#</th>
                    <th class="px-4 py-2 text-left">Nama</th>
                    <th class="px-4 py-2 text-left">Telepon</th>
                    <th class="px-4 py-2 text-left">Email</th>
                    <th class="px-4 py-2 text-left">Alamat</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($suppliers as $index => $supplier)
                <tr class="border-b border-slate-600">
                    <td class="px-4 py-2">{{ $index + 1 }}</td>
                    <td class="px-4 py-2">{{ $supplier->name }}</td>
                    <td class="px-4 py-2">{{ $supplier->phone ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $supplier->email ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $supplier->address ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-4 text-gray-300">Belum ada supplier.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
