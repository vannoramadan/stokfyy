@extends('layouts.manager')

@section('title', 'Edit Kategori')

@section('content')
<div class="max-w-xl mx-auto px-4 py-6 bg-white dark:bg-slate-800 rounded shadow">
    <h1 class="text-2xl font-bold mb-4 text-gray-800 dark:text-white">Edit Kategori</h1>

    @if ($errors->any())
    <div class="bg-red-100 dark:bg-red-800 text-red-700 dark:text-red-200 px-4 py-2 rounded mb-4">
        <ul class="list-disc list-inside">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('manager.categories.update', $category->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Kategori</label>
            <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-slate-700 dark:text-white focus:ring-blue-500 focus:border-blue-500" required>
        </div>

        <div class="flex justify-end gap-2">
            <a href="{{ route('manager.categories.index') }}" class="px-4 py-2 bg-gray-300 dark:bg-gray-600 text-black dark:text-white rounded hover:bg-gray-400 dark:hover:bg-gray-700">
                Batal
            </a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
