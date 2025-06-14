@extends('layouts.app')

@section('title', 'Tambah Produk Baru')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Produk Baru</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Produk</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tambah Baru</li>
            </ol>
        </nav>
    </div>

    <!-- Form Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-primary text-white">
            <h6 class="m-0 font-weight-bold">Form Tambah Produk</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <!-- Kolom Kiri -->
                    <div class="col-lg-6">
                        <div class="mb-4">
                            <label for="name" class="form-label fw-bold">Nama Produk <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="category_id" class="form-label fw-bold">Kategori <span class="text-danger">*</span></label>
                            <select class="form-select form-select-lg @error('category_id') is-invalid @enderror" 
                                    id="category_id" name="category_id" required>
                                <option value="" disabled selected>Pilih Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="price" class="form-label fw-bold">Harga (Rp) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control form-control-lg @error('price') is-invalid @enderror" 
                                           id="price" name="price" value="{{ old('price') }}" min="0" step="100" required>
                                </div>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-4">
                                <label for="stock" class="form-label fw-bold">Stok <span class="text-danger">*</span></label>
                                <input type="number" class="form-control form-control-lg @error('stock') is-invalid @enderror" 
                                       id="stock" name="stock" value="{{ old('stock') }}" min="0" required>
                                @error('stock')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <!-- Kolom Kanan -->
                    <div class="col-lg-6">
                        <div class="mb-4">
                            <label for="image" class="form-label fw-bold">Gambar Produk</label>
                            <input type="file" class="form-control form-control-lg @error('image') is-invalid @enderror" 
                                   id="image" name="image" accept="image/*">
                            <div class="form-text">Format: JPG, PNG, JPEG (Maks. 2MB)</div>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="mt-2" id="image-preview-container" style="display: none;">
                                <img id="image-preview" src="#" alt="Preview Gambar" class="img-thumbnail" style="max-height: 150px;">
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="description" class="form-label fw-bold">Deskripsi</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold">Status</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" 
                                       id="status" name="status" value="1" checked>
                                <label class="form-check-label" for="status">Aktif</label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Atribut Produk -->
                <div class="mb-4 border-top pt-4">
                    <h5 class="fw-bold mb-3">
                        <i class="fas fa-tags me-2"></i>Atribut Produk
                        <small class="text-muted fs-6">(Opsional)</small>
                    </h5>
                    
                    <div id="attributes-container">
                        @if(old('attributes'))
                            @foreach(old('attributes') as $index => $attribute)
                            <div class="row attribute-row mb-3">
                                <div class="col-md-5 mb-2">
                                    <select class="form-select @error('attributes.'.$index.'.attribute_id') is-invalid @enderror" 
                                            name="attributes[{{ $index }}][attribute_id]">
                                        <option value="">Pilih Atribut</option>
                                        @foreach($attributes as $attributeOption)
                                            <option value="{{ $attributeOption->id }}" 
                                                {{ $attribute['attribute_id'] == $attributeOption->id ? 'selected' : '' }}>
                                                {{ $attributeOption->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('attributes.'.$index.'.attribute_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-5 mb-2">
                                    <input type="text" class="form-control @error('attributes.'.$index.'.value') is-invalid @enderror" 
                                           name="attributes[{{ $index }}][value]" 
                                           value="{{ $attribute['value'] }}" 
                                           placeholder="Nilai Atribut">
                                    @error('attributes.'.$index.'.value')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-2 mb-2 d-flex align-items-center">
                                    <button type="button" class="btn btn-outline-danger remove-attribute" 
                                            {{ $loop->first ? 'disabled' : '' }}>
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div class="row attribute-row mb-3">
                                <div class="col-md-5 mb-2">
                                    <select class="form-select" name="attributes[0][attribute_id]">
                                        <option value="" selected>Pilih Atribut</option>
                                        @foreach($attributes as $attribute)
                                            <option value="{{ $attribute->id }}">{{ $attribute->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-5 mb-2">
                                    <input type="text" class="form-control" name="attributes[0][value]" placeholder="Nilai Atribut">
                                </div>
                                <div class="col-md-2 mb-2 d-flex align-items-center">
                                    <button type="button" class="btn btn-outline-danger remove-attribute" disabled>
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <a href="{{ route('attributes.index') }}" class="text-primary">
                            <i class="fas fa-cog me-1"></i>Kelola Atribut
                        </a>
                        <a href="{{ route('categories.index') }}" class="text-primary">
                            <i class="fas fa-cog me-1"></i>Kelola Kategori
                        </a>
                    </div>
                </div>
                
                <!-- Tombol Aksi -->
                <div class="d-flex justify-content-between border-top pt-4">
                    <a href="{{ route('products.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Simpan Produk
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .form-control-lg, .form-select-lg {
        padding: 0.75rem 1rem;
    }
    .attribute-row {
        transition: all 0.3s ease;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inisialisasi CKEditor untuk textarea deskripsi
        CKEDITOR.replace('description', {
            toolbar: [
                { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline'] },
                { name: 'paragraph', items: ['NumberedList', 'BulletedList'] },
                { name: 'links', items: ['Link', 'Unlink'] },
                { name: 'tools', items: ['Maximize'] }
            ],
            height: 150
        });

        // Preview gambar sebelum upload
        document.getElementById('image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    document.getElementById('image-preview').src = event.target.result;
                    document.getElementById('image-preview-container').style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });

        // Tambah atribut dinamis
        let attributeIndex = {{ old('attributes') ? count(old('attributes')) : 1 }};
        document.getElementById('add-attribute').addEventListener('click', function() {
            const container = document.getElementById('attributes-container');
            const newRow = document.createElement('div');
            newRow.className = 'row attribute-row mb-3';
            newRow.innerHTML = `
                <div class="col-md-5 mb-2">
                    <select class="form-select" name="attributes[${attributeIndex}][attribute_id]">
                        <option value="" selected>Pilih Atribut</option>
                        @foreach($attributes as $attribute)
                            <option value="{{ $attribute->id }}">{{ $attribute->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-5 mb-2">
                    <input type="text" class="form-control" name="attributes[${attributeIndex}][value]" placeholder="Nilai Atribut">
                </div>
                <div class="col-md-2 mb-2 d-flex align-items-center">
                    <button type="button" class="btn btn-outline-danger remove-attribute">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
            `;
            container.appendChild(newRow);
            attributeIndex++;
            
            // Aktifkan tombol hapus jika ada lebih dari satu baris
            document.querySelectorAll('.remove-attribute').forEach(btn => {
                btn.disabled = document.querySelectorAll('.attribute-row').length <= 1;
            });
        });

        // Hapus atribut
        document.getElementById('attributes-container').addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-attribute') || 
                e.target.closest('.remove-attribute')) {
                const btn = e.target.classList.contains('remove-attribute') ? 
                           e.target : e.target.closest('.remove-attribute');
                const row = btn.closest('.attribute-row');
                
                // Animasi fade out sebelum menghapus
                row.style.opacity = '0';
                setTimeout(() => {
                    row.remove();
                    
                    // Nonaktifkan tombol hapus jika hanya tersisa satu baris
                    if (document.querySelectorAll('.attribute-row').length === 1) {
                        document.querySelector('.remove-attribute').disabled = true;
                    }
                }, 300);
            }
        });
    });
</script>
@endpush