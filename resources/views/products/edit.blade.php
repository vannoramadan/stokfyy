@extends('layouts.app')

@section('title', 'Edit Produk')

@section('content')
<div class="card border-0 shadow">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0"><i class="fas fa-edit me-2"></i>Edit Produk</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="row g-4">
                <!-- Kolom Kiri -->
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">Nama Produk <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name', $product->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="category_id" class="form-label fw-semibold">Kategori <span class="text-danger">*</span></label>
                        <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="price" class="form-label fw-semibold">Harga (Rp) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" 
                                           id="price" name="price" value="{{ old('price', $product->price) }}" required>
                                </div>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="stock" class="form-label fw-semibold">Stok <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('stock') is-invalid @enderror" 
                                       id="stock" name="stock" value="{{ old('stock', $product->stock) }}" required>
                                @error('stock')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Kolom Kanan -->
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label for="image" class="form-label fw-semibold">Gambar Produk</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" 
                               id="image" name="image" accept="image/*">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @if($product->image)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $product->image) }}" alt="Gambar Saat Ini" 
                                     class="img-thumbnail" width="120">
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="checkbox" id="remove_image" name="remove_image">
                                    <label class="form-check-label text-danger" for="remove_image">
                                        Hapus gambar saat ini
                                    </label>
                                </div>
                            </div>
                        @endif
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label fw-semibold">Deskripsi</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="3">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Status</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" 
                                   id="status" name="status" value="1" {{ $product->status ? 'checked' : '' }}>
                            <label class="form-check-label" for="status">Aktif</label>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Atribut Produk -->
            <div class="border-top pt-3 mt-4">
                <h5 class="mb-3 fw-semibold text-primary">
                    <i class="fas fa-tags me-2"></i>Atribut Produk
                </h5>
                
                <div id="attributes-container" class="mb-3">
                    @foreach($product->attributes as $index => $attribute)
                    <div class="row attribute-row mb-3 g-2 align-items-center">
                        <div class="col-md-5">
                            <select class="form-select attribute-select @error('attributes.'.$index.'.attribute_id') is-invalid @enderror" 
                                    name="attributes[{{ $index }}][attribute_id]">
                                <option value="">Pilih Atribut</option>
                                @foreach($attributes as $attr)
                                    <option value="{{ $attr->id }}" {{ $attribute->id == $attr->id ? 'selected' : '' }}>
                                        {{ $attr->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('attributes.'.$index.'.attribute_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-5">
                            <input type="text" class="form-control @error('attributes.'.$index.'.value') is-invalid @enderror" 
                                   name="attributes[{{ $index }}][value]" value="{{ $attribute->pivot->value }}" 
                                   placeholder="Nilai Atribut">
                            @error('attributes.'.$index.'.value')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-outline-danger remove-attribute" 
                                    {{ $loop->first && $loop->count == 1 ? 'disabled' : '' }}>
                                <i class="fas fa-trash-alt"></i> Hapus
                            </button>
                        </div>
                    </div>
                    @endforeach
        
                    @if(count($product->attributes) == 0)
                    <div class="row attribute-row mb-3 g-2 align-items-center">
                        <div class="col-md-5">
                            <select class="form-select attribute-select" name="attributes[0][attribute_id]">
                                <option value="">Pilih Atribut</option>
                                @foreach($attributes as $attribute)
                                    <option value="{{ $attribute->id }}">{{ $attribute->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-5">
                            <input type="text" class="form-control" name="attributes[0][value]" placeholder="Nilai Atribut">
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-outline-danger remove-attribute" disabled>
                                <i class="fas fa-trash-alt"></i> Hapus
                            </button>
                        </div>
                    </div>
                    @endif
                </div>
                
                <button type="button" id="add-attribute" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-plus-circle me-1"></i> Tambah Atribut
                </button>
            </div>
            
            <!-- Tombol Aksi -->
            <div class="d-flex justify-content-between mt-4 border-top pt-3">
                <a href="{{ route('products.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let attributeIndex = {{ count($product->attributes) > 0 ? count($product->attributes) : 1 }};
        
        // Tambah atribut baru
        document.getElementById('add-attribute').addEventListener('click', function() {
            const container = document.getElementById('attributes-container');
            const newRow = document.createElement('div');
            newRow.className = 'row attribute-row mb-3 g-2 align-items-center';
            newRow.innerHTML = `
                <div class="col-md-5">
                    <select class="form-select attribute-select" name="attributes[${attributeIndex}][attribute_id]">
                        <option value="">Pilih Atribut</option>
                        @foreach($attributes as $attribute)
                            <option value="{{ $attribute->id }}">{{ $attribute->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-5">
                    <input type="text" class="form-control" name="attributes[${attributeIndex}][value]" placeholder="Nilai Atribut">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-outline-danger remove-attribute">
                        <i class="fas fa-trash-alt"></i> Hapus
                    </button>
                </div>
            `;
            container.appendChild(newRow);
            attributeIndex++;
            
            // Aktifkan tombol hapus jika ada lebih dari satu baris
            updateRemoveButtons();
        });
        
        // Hapus atribut
        document.getElementById('attributes-container').addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-attribute') || 
                e.target.closest('.remove-attribute')) {
                const btn = e.target.classList.contains('remove-attribute') ? 
                            e.target : e.target.closest('.remove-attribute');
                const row = btn.closest('.attribute-row');
                row.remove();
                updateRemoveButtons();
            }
        });
        
        // Fungsi untuk mengupdate status tombol hapus
        function updateRemoveButtons() {
            const rows = document.querySelectorAll('.attribute-row');
            const removeButtons = document.querySelectorAll('.remove-attribute');
            
            if (rows.length === 1) {
                removeButtons.forEach(btn => {
                    btn.disabled = true;
                });
            } else {
                removeButtons.forEach(btn => {
                    btn.disabled = false;
                });
            }
        }
    });
</script>
@endpush