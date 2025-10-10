@extends('admin.layouts.app')

@section('title', 'Edit Shipping Method')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Shipping Method</h1>
    <a href="{{ route('admin.shipping-methods.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back to List
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <form action="{{ route('admin.shipping-methods.update', $shippingMethod->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('name') is-invalid @enderror"
                       id="name" name="name" value="{{ old('name', $shippingMethod->name) }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror"
                          id="description" name="description" rows="4">{{ old('description', $shippingMethod->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="cost" class="form-label">Cost ($)<span class="text-danger">*</span></label>
                <input type="number" step="0.01" class="form-control @error('cost') is-invalid @enderror"
                       id="cost" name="cost" value="{{ old('cost', $shippingMethod->cost) }}" required>
                @error('cost')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="delivery_time" class="form-label">Delivery Time (days)</label>
                <input type="number" class="form-control @error('delivery_time') is-invalid @enderror"
                       id="delivery_time" name="delivery_time" value="{{ old('delivery_time', $shippingMethod->delivery_time) }}">
                @error('delivery_time')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                    <option value="1" {{ old('status', $shippingMethod->status) == 1 ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ old('status', $shippingMethod->status) == 0 ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.shipping-methods.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
