@extends('layouts.app')

@section('title', 'Create Category')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Tambah Kategori Baru</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('categories.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Nama Kategori</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            
            <div class="mb-3">
                <label for="description" class="form-label">Desckripsi</label>
                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Status</label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="status" name="status" value="1" checked>
                    <label class="form-check-label" for="status">Active</label>
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary">Simpan Kategori</button>
            <a href="{{ route('categories.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection