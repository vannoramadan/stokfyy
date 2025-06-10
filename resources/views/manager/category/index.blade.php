@extends('layouts.manager')

@section('title', 'Manajemen Kategori')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-4">Manajemen Kategori</h1>

    @if(session('success'))
    <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
        {{ session('success') }}
    </div>
    @endif

    <a href="{{ route('manager.categories.create') }}" class="bg-blue-500 hover:bg-blue-600 text-black px-4 py-2 rounded mb-4 inline-block">
        + Tambah Kategori
    </a>

    <div class="overflow-x-auto bg-black rounded shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-500 text-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-medium">#</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Nama Kategori</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 text-sm">
                @forelse($categories as $index => $category)
                <tr>
                    <td class="px-6 py-4">{{ $index + 1 }}</td>
                    <td class="px-6 py-4">{{ $category->name }}</td>
                    <td class="px-6 py-4 space-x-2">
                        <a href="{{ route('manager.categories.edit', $category->id) }}" class="text-blue-600">Edit</a>
                        <form action="{{ route('manager.categories.destroy', $category->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:underline">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="px-6 py-4 text-center text-gray-500">Belum ada kategori.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
