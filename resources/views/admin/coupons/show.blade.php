@extends('admin.layouts.app')

@section('title', 'View Coupon')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">View Coupon</h1>
    <div>
        <a href="{{ route('admin.coupons.edit', $coupon->id) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Edit
        </a>
        <a href="{{ route('admin.coupons.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Coupon Details</h6>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Code:</strong>
                        <p class="mb-0">{{ $coupon->code }}</p>
                    </div>
                    <div class="col-md-6">
                        <strong>Type:</strong>
                        <p class="mb-0">{{ ucfirst($coupon->type) }}</p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Value:</strong>
                        <p class="mb-0">
                            @if($coupon->type == 'percentage')
                                {{ $coupon->value }}%
                            @else
                                ${{ number_format($coupon->value, 2) }}
                            @endif
                        </p>
                    </div>
                    <div class="col-md-6">
                        <strong>Status:</strong>
                        <p class="mb-0">
                            <span class="badge bg-{{ $coupon->status ? 'success' : 'danger' }}">
                                {{ $coupon->status ? 'Active' : 'Inactive' }}
                            </span>
                        </p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Usage Limit:</strong>
                        <p class="mb-0">{{ $coupon->usage_limit ?? 'Unlimited' }}</p>
                    </div>
                    <div class="col-md-6">
                        <strong>Times Used:</strong>
                        <p class="mb-0">{{ $coupon->used ?? 0 }}</p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Min Purchase Amount:</strong>
                        <p class="mb-0">${{ number_format($coupon->min_purchase ?? 0, 2) }}</p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Valid From:</strong>
                        <p class="mb-0">{{ $coupon->valid_from ? $coupon->valid_from->format('M d, Y') : 'N/A' }}</p>
                    </div>
                    <div class="col-md-6">
                        <strong>Valid To:</strong>
                        <p class="mb-0">{{ $coupon->valid_to ? $coupon->valid_to->format('M d, Y') : 'N/A' }}</p>
                    </div>
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
                <a href="{{ route('admin.coupons.edit', $coupon->id) }}" class="btn btn-warning btn-block w-100 mb-2">
                    <i class="fas fa-edit"></i> Edit Coupon
                </a>
                
                <form action="{{ route('admin.coupons.destroy', $coupon->id) }}" method="POST" 
                      onsubmit="return confirm('Are you sure you want to delete this coupon?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-block w-100">
                        <i class="fas fa-trash"></i> Delete Coupon
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
