@extends('layouts.app')

@section('title', 'Edit Attribute')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Edit Attribute</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('attributes.update', $attribute->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">Attribute Name</label>
                <input type="text" class="form-control" id="name" name="name" 
                       value="{{ old('name', $attribute->name) }}" required>
            </div>
            
            <div class="mb-3">
                <label for="values" class="form-label">Possible Values</label>
                <textarea class="form-control" id="values" name="values" rows="3">
                @if($attribute->values)
    @php
        $values = json_decode($attribute->values, true);
    @endphp

    @if(is_array($values))
        {{ implode(', ', $values) }}
    @else
        {{ $attribute->values }}
    @endif
@endif

                </textarea>
                <div class="form-text">Enter comma-separated values (e.g. Red, Green, Blue)</div>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Status</label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="status" name="status" value="1" {{ $attribute->status ? 'checked' : '' }}>
                    <label class="form-check-label" for="status">Active</label>
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary">Update Attribute</button>
            <a href="{{ route('attributes.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection