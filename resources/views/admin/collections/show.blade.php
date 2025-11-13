@extends('admin.layouts.app')

@section('title', 'View Collection')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">View Collection</h1>
    <div>
        <a href="{{ route('admin.collections.edit', $collection->id) }}" class="btn btn-primary">
            <i class="fas fa-edit"></i> Edit Collection
        </a>
        <a href="{{ route('admin.collections.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Collection Information</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Collection Name:</label>
                            <p class="mb-0">{{ $collection->name }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Slug:</label>
                            <p class="mb-0">{{ $collection->slug }}</p>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Description:</label>
                    <p class="mb-0">{{ $collection->description ?: 'No description provided.' }}</p>
                </div>

                @if($collection->image)
                <div class="mb-3">
                    <label class="form-label fw-bold">Collection Image:</label>
                    <div>
                        <img src="{{ asset('storage/' . $collection->image) }}" alt="{{ $collection->name }}"
                             style="max-width: 300px; max-height: 300px; object-fit: cover;" class="img-thumbnail">
                    </div>
                </div>
                @endif
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Products in this Collection ({{ $collection->products->count() }})</h6>
            </div>
            <div class="card-body">
                @if($collection->products->count() > 0)
                    <div class="row">
                        @foreach($collection->products as $product)
                            <div class="col-md-4 mb-3">
                                <div class="card h-100">
                                    @if($product->images->where('is_primary', 1)->first())
                                        <img src="{{ asset('storage/' . $product->images->where('is_primary', 1)->first()->image) }}"
                                             class="card-img-top" style="height: 150px; object-fit: cover;" alt="{{ $product->name }}">
                                    @else
                                        <div class="card-img-top d-flex align-items-center justify-content-center bg-light"
                                             style="height: 150px;">
                                            <span class="text-muted">No Image</span>
                                        </div>
                                    @endif
                                    <div class="card-body">
                                        <h6 class="card-title">{{ $product->name }}</h6>
                                        <p class="card-text text-primary fw-bold">${{ number_format($product->price, 2) }}</p>
                                        <a href="{{ route('admin.products.show', $product->id) }}" class="btn btn-sm btn-outline-primary">
                                            View Product
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No Products in this Collection</h5>
                        <p class="text-muted">Products can be added to this collection when creating or editing products.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Collection Settings</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">Sort Order:</label>
                    <p class="mb-0">{{ $collection->sort_order }}</p>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Status:</label>
                    <p class="mb-0">
                        @if($collection->status)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-danger">Inactive</span>
                        @endif
                    </p>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Created At:</label>
                    <p class="mb-0">{{ $collection->created_at->format('M d, Y H:i') }}</p>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Updated At:</label>
                    <p class="mb-0">{{ $collection->updated_at->format('M d, Y H:i') }}</p>
                </div>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
            </div>
            <div class="card-body">
                <a href="{{ route('admin.collections.edit', $collection->id) }}" class="btn btn-primary w-100 mb-2">
                    <i class="fas fa-edit"></i> Edit Collection
                </a>
                <form action="{{ route('admin.collections.destroy', $collection->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger w-100"
                            onclick="return confirm('Are you sure you want to delete this collection? This will also remove it from all associated products.')">
                        <i class="fas fa-trash"></i> Delete Collection
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
