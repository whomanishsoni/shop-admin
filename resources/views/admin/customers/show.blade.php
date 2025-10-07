@extends('admin.layouts.app')

@section('title', 'View Customer')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">View Customer</h1>
    <div>
        <a href="{{ route('admin.customers.edit', $customer->id) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Edit
        </a>
        <a href="{{ route('admin.customers.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Customer Information</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Name:</strong>
                    <p class="mb-0">{{ $customer->name }}</p>
                </div>

                <div class="mb-3">
                    <strong>Email:</strong>
                    <p class="mb-0">{{ $customer->email }}</p>
                </div>

                <div class="mb-3">
                    <strong>Phone:</strong>
                    <p class="mb-0">{{ $customer->phone ?? 'N/A' }}</p>
                </div>

                <div class="mb-3">
                    <strong>Address:</strong>
                    <p class="mb-0 text-muted">{{ $customer->address ?? 'N/A' }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Account Details</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Member Since:</strong>
                    <p class="mb-0 text-muted">{{ $customer->created_at->format('M d, Y') }}</p>
                </div>

                <div class="mb-3">
                    <strong>Last Updated:</strong>
                    <p class="mb-0 text-muted">{{ $customer->updated_at->format('M d, Y h:i A') }}</p>
                </div>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Actions</h6>
            </div>
            <div class="card-body">
                <a href="{{ route('admin.customers.edit', $customer->id) }}" class="btn btn-warning btn-block w-100 mb-2">
                    <i class="fas fa-edit"></i> Edit Customer
                </a>
                
                <form action="{{ route('admin.customers.destroy', $customer->id) }}" method="POST" 
                      onsubmit="return confirm('Are you sure you want to delete this customer?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-block w-100">
                        <i class="fas fa-trash"></i> Delete Customer
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
