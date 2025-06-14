@extends('layouts.app')

@section('title', 'Create Attribute')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Create New Attribute</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('attributes.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Attribute Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="e.g. Color, Size" required>
            </div>
            <div class="mb-3">
                <label for="values" class="form-label">Possible Values</label>
                <textarea class="form-control" id="values" name="values" rows="3" 
                          placeholder="Enter comma-separated values (e.g. Red, Green, Blue)"></textarea>
                <div class="form-text">Leave empty if values are not predefined.</div>
            </div>
            <div class="mb-3">
                <label class="form-label">Status</label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="status" name="status" value="1" checked>
                    <label class="form-check-label" for="status">Active</label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Save Attribute</button>
            <a href="{{ route('attributes.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection