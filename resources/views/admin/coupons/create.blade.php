@extends('admin.layouts.app')

@section('title', 'Create Coupon')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Create Coupon</h1>
    <a href="{{ route('admin.coupons.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back to List
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <form action="{{ route('admin.coupons.store') }}" method="POST">
            @csrf
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="code" class="form-label">Code <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('code') is-invalid @enderror" 
                           id="code" name="code" value="{{ old('code') }}" required>
                    @error('code')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="type" class="form-label">Type <span class="text-danger">*</span></label>
                    <select class="form-select @error('type') is-invalid @enderror" 
                            id="type" name="type" required>
                        <option value="percentage" {{ old('type') == 'percentage' ? 'selected' : '' }}>Percentage</option>
                        <option value="fixed" {{ old('type') == 'fixed' ? 'selected' : '' }}>Fixed Amount</option>
                    </select>
                    @error('type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="value" class="form-label">Value <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" class="form-control @error('value') is-invalid @enderror" 
                           id="value" name="value" value="{{ old('value') }}" required>
                    @error('value')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label for="usage_limit" class="form-label">Usage Limit</label>
                    <input type="number" class="form-control @error('usage_limit') is-invalid @enderror" 
                           id="usage_limit" name="usage_limit" value="{{ old('usage_limit') }}">
                    @error('usage_limit')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label for="min_purchase" class="form-label">Min Purchase Amount</label>
                    <input type="number" step="0.01" class="form-control @error('min_purchase') is-invalid @enderror" 
                           id="min_purchase" name="min_purchase" value="{{ old('min_purchase') }}">
                    @error('min_purchase')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="valid_from" class="form-label">Valid From</label>
                    <input type="date" class="form-control @error('valid_from') is-invalid @enderror" 
                           id="valid_from" name="valid_from" value="{{ old('valid_from') }}">
                    @error('valid_from')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="valid_to" class="form-label">Valid To</label>
                    <input type="date" class="form-control @error('valid_to') is-invalid @enderror" 
                           id="valid_to" name="valid_to" value="{{ old('valid_to') }}">
                    @error('valid_to')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="status" name="status" value="1" {{ old('status', 1) ? 'checked' : '' }}>
                    <label class="form-check-label" for="status">Active</label>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.coupons.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Create Coupon
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
