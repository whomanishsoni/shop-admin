@extends('admin.layouts.app')

@section('title', 'View Product Review')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">View Product Review</h1>
    <div>
        <a href="{{ route('admin.product-reviews.edit', $productReview->id) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Edit
        </a>
        <a href="{{ route('admin.product-reviews.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Review Details</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <h5>Product</h5>
                    <p>{{ $productReview->product->name ?? 'N/A' }}</p>
                </div>

                <div class="mb-3">
                    <h5>Customer</h5>
                    <p>{{ $productReview->customer->name ?? 'N/A' }}</p>
                </div>

                <div class="mb-3">
                    <h5>Rating</h5>
                    <p>{{ str_repeat('⭐', $productReview->rating) }} ({{ $productReview->rating }} stars)</p>
                </div>

                <div class="mb-3">
                    <h5>Comment</h5>
                    <div>
                        {!! nl2br(e($productReview->comment)) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Review Information</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Status:</strong>
                    <p class="mb-0">
                        <span class="badge bg-{{ $productReview->approved ? 'success' : 'warning' }}">
                            {{ $productReview->approved ? 'Approved' : 'Pending' }}
                        </span>
                    </p>
                </div>

                <div class="mb-3">
                    <strong>Created:</strong>
                    <p class="mb-0 text-muted">{{ $productReview->created_at->format('M d, Y h:i A') }}</p>
                </div>

                <div class="mb-3">
                    <strong>Last Updated:</strong>
                    <p class="mb-0 text-muted">{{ $productReview->updated_at->format('M d, Y h:i A') }}</p>
                </div>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Actions</h6>
            </div>
            <div class="card-body">
                <a href="{{ route('admin.product-reviews.edit', $productReview->id) }}" class="btn btn-warning btn-block w-100 mb-2">
                    <i class="fas fa-edit"></i> Edit Review
                </a>
                
                <form action="{{ route('admin.product-reviews.destroy', $productReview->id) }}" method="POST" 
                      onsubmit="return confirm('Are you sure you want to delete this review?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-block w-100">
                        <i class="fas fa-trash"></i> Delete Review
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
