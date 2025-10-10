@extends('admin.layouts.app')

@section('title', 'View Shipping Zone')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">View Shipping Zone</h1>
    <div>
        <a href="{{ route('admin.shipping-zones.edit', $shippingZone->id) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Edit
        </a>
        <a href="{{ route('admin.shipping-zones.index') }}" class="btn btn-secondary">
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
                    <strong>Name:</strong>
                    <p class="mb-0">{{ $shippingZone->name }}</p>
                </div>

                <div class="mb-3">
                    <strong>States:</strong>
                    <p class="mb-0">
                        @if ($shippingZone->states && is_array($shippingZone->states) && !empty($shippingZone->states))
                            {{ implode(', ', $shippingZone->states) }}
                        @else
                            N/A
                        @endif
                    </p>
                </div>

                <div class="mb-3">
                    <strong>Shipping Method:</strong>
                    <p class="mb-0">{{ $shippingZone->shippingMethod ? $shippingZone->shippingMethod->name : 'N/A' }}</p>
                </div>

                <div class="mb-3">
                    <strong>Rate:</strong>
                    <p class="mb-0">${{ number_format($shippingZone->rate, 2) }}</p>
                </div>

                <div class="mb-3">
                    <strong>Status:</strong>
                    <p class="mb-0">
                        <span class="badge bg-{{ $shippingZone->status ? 'success' : 'danger' }}">
                            {{ $shippingZone->status ? 'Active' : 'Inactive' }}
                        </span>
                    </p>
                </div>

                <div class="mb-3">
                    <strong>Created:</strong>
                    <p class="mb-0">{{ $shippingZone->created_at->format('M d, Y h:i A') }}</p>
                </div>

                <div class="mb-3">
                    <strong>Last Updated:</strong>
                    <p class="mb-0">{{ $shippingZone->updated_at->format('M d, Y h:i A') }}</p>
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
                <a href="{{ route('admin.shipping-zones.edit', $shippingZone->id) }}" class="btn btn-warning btn-block w-100 mb-2">
                    <i class="fas fa-edit"></i> Edit
                </a>

                <form action="{{ route('admin.shipping-zones.destroy', $shippingZone->id) }}" method="POST"
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
