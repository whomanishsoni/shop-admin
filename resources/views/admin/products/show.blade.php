@extends('admin.layouts.app')

@section('title', 'View Product')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">View Product</h1>
    <div>
        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Edit
        </a>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">{{ $product->name }}</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <h5>Short Description</h5>
                    <p>{{ $product->short_description ?? 'N/A' }}</p>
                </div>

                <div class="mb-3">
                    <h5>Description</h5>
                    <div>
                        {!! nl2br(e($product->description)) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Product Details</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>SKU:</strong>
                    <p class="mb-0 text-muted">{{ $product->sku ?? 'N/A' }}</p>
                </div>

                <div class="mb-3">
                    <strong>Slug:</strong>
                    <p class="mb-0 text-muted">{{ $product->slug }}</p>
                </div>

                <div class="mb-3">
                    <strong>Category:</strong>
                    <p class="mb-0">
                        <span class="badge bg-primary">{{ $product->category->name ?? 'N/A' }}</span>
                    </p>
                </div>

                <div class="mb-3">
                    <strong>Subcategory:</strong>
                    <p class="mb-0">
                        <span class="badge bg-secondary">{{ $product->subcategory->name ?? 'N/A' }}</span>
                    </p>
                </div>

                <div class="mb-3">
                    <strong>Price:</strong>
                    <p class="mb-0">${{ number_format($product->price, 2) }}</p>
                </div>

                @if($product->sale_price)
                <div class="mb-3">
                    <strong>Sale Price:</strong>
                    <p class="mb-0 text-danger">${{ number_format($product->sale_price, 2) }}</p>
                </div>
                @endif

                <div class="mb-3">
                    <strong>Stock:</strong>
                    <p class="mb-0">{{ $product->stock }} units</p>
                </div>

                <div class="mb-3">
                    <strong>Status:</strong>
                    <p class="mb-0">
                        <span class="badge bg-{{ $product->status === 'active' ? 'success' : 'danger' }}">
                            {{ ucfirst($product->status) }}
                        </span>
                    </p>
                </div>

                <div class="mb-3">
                    <strong>Created:</strong>
                    <p class="mb-0 text-muted">{{ $product->created_at->format('M d, Y h:i A') }}</p>
                </div>

                <div class="mb-3">
                    <strong>Last Updated:</strong>
                    <p class="mb-0 text-muted">{{ $product->updated_at->format('M d, Y h:i A') }}</p>
                </div>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">SEO Information</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Meta Title:</strong>
                    <p class="mb-0 text-muted">{{ $product->meta_title ?? 'N/A' }}</p>
                </div>

                <div class="mb-3">
                    <strong>Meta Keywords:</strong>
                    <p class="mb-0 text-muted">{{ $product->meta_keywords ?? 'N/A' }}</p>
                </div>

                <div class="mb-3">
                    <strong>Meta Description:</strong>
                    <p class="mb-0 text-muted">{{ $product->meta_description ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Actions</h6>
            </div>
            <div class="card-body">
                <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-warning btn-block w-100 mb-2">
                    <i class="fas fa-edit"></i> Edit Product
                </a>
                
                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" 
                      onsubmit="return confirm('Are you sure you want to delete this product?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-block w-100">
                        <i class="fas fa-trash"></i> Delete Product
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
