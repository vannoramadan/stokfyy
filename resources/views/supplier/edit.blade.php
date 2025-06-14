@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2>Edit Supplier</h2>
    <form action="{{ route('suppliers.update', $supplier) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="name" class="form-control" required value="{{ old('name', $supplier->name) }}">
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $supplier->email) }}">
        </div>
        <div class="mb-3">
            <label>Telepon</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone', $supplier->phone) }}">
        </div>
        <div class="mb-3">
            <label>Alamat</label>
            <textarea name="address" class="form-control">{{ old('address', $supplier->address) }}</textarea>
        </div>
        <button class="btn btn-primary">Update</button>
        <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
