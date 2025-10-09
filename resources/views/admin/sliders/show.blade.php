@extends('admin.layouts.app')

@section('title', 'View Slider')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">View Slider</h1>
    <div>
        <a href="{{ route('admin.sliders.edit', $slider->id) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Edit
        </a>
        <a href="{{ route('admin.sliders.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Details</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Title:</strong>
                    <p class="mb-0">{{ $slider->title }}</p>
                </div>

                <div class="mb-3">
                    <strong>Image:</strong>
                    <p class="mb-0">
                        @if($slider->image)
                            <img src="/storage/{{ $slider->image }}" class="img-fluid" style="max-height: 200px; border-radius: 5px;">
                        @else
                            No Image
                        @endif
                    </p>
                </div>

                <div class="mb-3">
                    <strong>Link:</strong>
                    <p class="mb-0">{{ $slider->link ?? 'N/A' }}</p>
                </div>

                <div class="mb-3">
                    <strong>Order:</strong>
                    <p class="mb-0">{{ $slider->order }}</p>
                </div>

                <div class="mb-3">
                    <strong>Status:</strong>
                    <p class="mb-0">
                        <span class="badge bg-{{ $slider->status ? 'success' : 'danger' }}">
                            {{ $slider->status ? 'Active' : 'Inactive' }}
                        </span>
                    </p>
                </div>

                <div class="mb-3">
                    <strong>Created:</strong>
                    <p class="mb-0">{{ $slider->created_at->format('M d, Y h:i A') }}</p>
                </div>

                <div class="mb-3">
                    <strong>Last Updated:</strong>
                    <p class="mb-0">{{ $slider->updated_at->format('M d, Y h:i A') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Actions</h6>
            </div>
            <div class="card-body">
                <a href="{{ route('admin.sliders.edit', $slider->id) }}" class="btn btn-warning btn-block w-100 mb-2">
                    <i class="fas fa-edit"></i> Edit
                </a>

                <form action="{{ route('admin.sliders.destroy', $slider->id) }}" method="POST"
                      onsubmit="return confirm('Are you sure you want to delete this item?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-block w-100">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
