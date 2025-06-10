@extends('layouts.manager')

@section('content')
<div class="max-w-4xl mx-auto p-6">
    <h1 class="text-2xl font-bold text-white mb-6">Tambah Kategori</h1>

    <form action="{{ route('manager.categories.store') }}" method="POST" class="bg-slate-800 p-6 rounded-lg shadow">
        @csrf

        <div class="mb-4">
            <label for="name" class="block text-white font-medium mb-2">Nama Kategori</label>
            <input type="text" name="name" id="name" class="w-full bg-slate-700 text-white border border-slate-600 rounded-lg p-2" required>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">Simpan</button>
        </div>
    </form>
</div>
@endsection
