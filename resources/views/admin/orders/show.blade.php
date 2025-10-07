@extends('admin.layouts.app')

@section('title', 'View Order')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Order #{{ $order->order_number }}</h1>
    <div>
        <a href="{{ route('admin.orders.edit', $order->id) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Edit
        </a>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Order Information</h6>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Order Number:</strong>
                        <p class="mb-0">{{ $order->order_number }}</p>
                    </div>
                    <div class="col-md-6">
                        <strong>Customer:</strong>
                        <p class="mb-0">{{ $order->customer->name ?? 'N/A' }}</p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Status:</strong>
                        <p class="mb-0">
                            <span class="badge bg-{{ 
                                $order->status === 'completed' ? 'success' : 
                                ($order->status === 'processing' ? 'info' : 
                                ($order->status === 'cancelled' ? 'danger' : 'warning')) 
                            }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <strong>Payment Status:</strong>
                        <p class="mb-0">
                            <span class="badge bg-{{ $order->payment_status === 'paid' ? 'success' : 'warning' }}">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Payment Method:</strong>
                        <p class="mb-0">{{ $order->payment_method ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-6">
                        <strong>Order Date:</strong>
                        <p class="mb-0">{{ $order->created_at->format('M d, Y h:i A') }}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>Shipping Address:</strong>
                        <p class="mb-0 text-muted">{{ $order->shipping_address ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Billing Address:</strong>
                        <p class="mb-0 text-muted">{{ $order->billing_address ?? 'N/A' }}</p>
                    </div>
                </div>

                @if($order->notes)
                <div class="mb-3">
                    <strong>Notes:</strong>
                    <p class="mb-0 text-muted">{{ $order->notes }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Order Summary</h6>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span>Subtotal:</span>
                    <span>${{ number_format($order->subtotal, 2) }}</span>
                </div>
                @if($order->tax)
                <div class="d-flex justify-content-between mb-2">
                    <span>Tax:</span>
                    <span>${{ number_format($order->tax, 2) }}</span>
                </div>
                @endif
                @if($order->shipping)
                <div class="d-flex justify-content-between mb-2">
                    <span>Shipping:</span>
                    <span>${{ number_format($order->shipping, 2) }}</span>
                </div>
                @endif
                @if($order->discount)
                <div class="d-flex justify-content-between mb-2 text-danger">
                    <span>Discount:</span>
                    <span>-${{ number_format($order->discount, 2) }}</span>
                </div>
                @endif
                <hr>
                <div class="d-flex justify-content-between">
                    <strong>Total:</strong>
                    <strong>${{ number_format($order->total, 2) }}</strong>
                </div>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Actions</h6>
            </div>
            <div class="card-body">
                <a href="{{ route('admin.orders.edit', $order->id) }}" class="btn btn-warning btn-block w-100 mb-2">
                    <i class="fas fa-edit"></i> Edit Order
                </a>
                
                <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" 
                      onsubmit="return confirm('Are you sure you want to delete this order?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-block w-100">
                        <i class="fas fa-trash"></i> Delete Order
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
