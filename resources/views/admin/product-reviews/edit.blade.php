@extends('admin.layouts.app')

@section('title', 'Edit Product Review')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Product Review</h1>
    <a href="{{ route('admin.product-reviews.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back to List
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <form action="{{ route('admin.product-reviews.update', $productReview->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="product_id" class="form-label">Product <span class="text-danger">*</span></label>
                    <select class="form-select @error('product_id') is-invalid @enderror" 
                            id="product_id" name="product_id" required>
                        <option value="">Select Product</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" 
                                {{ old('product_id', $productReview->product_id) == $product->id ? 'selected' : '' }}>
                                {{ $product->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('product_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="customer_id" class="form-label">Customer <span class="text-danger">*</span></label>
                    <select class="form-select @error('customer_id') is-invalid @enderror" 
                            id="customer_id" name="customer_id" required>
                        <option value="">Select Customer</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}" 
                                {{ old('customer_id', $productReview->customer_id) == $customer->id ? 'selected' : '' }}>
                                {{ $customer->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('customer_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="rating" class="form-label">Rating <span class="text-danger">*</span></label>
                    <select class="form-select @error('rating') is-invalid @enderror" 
                            id="rating" name="rating" required>
                        <option value="">Select Rating</option>
                        <option value="5" {{ old('rating', $productReview->rating) == 5 ? 'selected' : '' }}>⭐⭐⭐⭐⭐ (5 Stars)</option>
                        <option value="4" {{ old('rating', $productReview->rating) == 4 ? 'selected' : '' }}>⭐⭐⭐⭐ (4 Stars)</option>
                        <option value="3" {{ old('rating', $productReview->rating) == 3 ? 'selected' : '' }}>⭐⭐⭐ (3 Stars)</option>
                        <option value="2" {{ old('rating', $productReview->rating) == 2 ? 'selected' : '' }}>⭐⭐ (2 Stars)</option>
                        <option value="1" {{ old('rating', $productReview->rating) == 1 ? 'selected' : '' }}>⭐ (1 Star)</option>
                    </select>
                    @error('rating')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Status</label>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="approved" name="approved" value="1" 
                            {{ old('approved', $productReview->approved) ? 'checked' : '' }}>
                        <label class="form-check-label" for="approved">Approved</label>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="comment" class="form-label">Comment</label>
                <textarea class="form-control @error('comment') is-invalid @enderror" 
                          id="comment" name="comment" rows="6">{{ old('comment', $productReview->comment) }}</textarea>
                @error('comment')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.product-reviews.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update Review
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
