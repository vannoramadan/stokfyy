@extends('layouts.app')

@section('title', 'Product Attributes')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Product Attributes</h5>
        <a href="{{ route('attributes.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Attribute
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Values</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($attributes as $attribute)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $attribute->name }}</td>
                        <td>
                            @if($attribute->values)
                                {{ implode(', ', json_decode($attribute->values, true)) }}
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-{{ $attribute->status ? 'success' : 'danger' }}">
                                {{ $attribute->status ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('attributes.edit', $attribute->id) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('attributes.destroy', $attribute->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <a href="{{ route('products.create') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
            {{ $attributes->links() }}
        </div>
    </div>
</div>
@endsection