@extends('admin.layouts.app')

@section('title', 'Create Order')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Create Order</h1>
    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back to List
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <form action="{{ route('admin.orders.store') }}" method="POST">
            @csrf
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="order_number" class="form-label">Order Number <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('order_number') is-invalid @enderror" 
                           id="order_number" name="order_number" value="{{ old('order_number') }}" required>
                    @error('order_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="customer_id" class="form-label">Customer <span class="text-danger">*</span></label>
                    <select class="form-select @error('customer_id') is-invalid @enderror" 
                            id="customer_id" name="customer_id" required>
                        <option value="">Select Customer</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
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
                <div class="col-md-3 mb-3">
                    <label for="subtotal" class="form-label">Subtotal <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" class="form-control @error('subtotal') is-invalid @enderror" 
                           id="subtotal" name="subtotal" value="{{ old('subtotal', 0) }}" required>
                    @error('subtotal')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-3 mb-3">
                    <label for="tax" class="form-label">Tax</label>
                    <input type="number" step="0.01" class="form-control @error('tax') is-invalid @enderror" 
                           id="tax" name="tax" value="{{ old('tax', 0) }}">
                    @error('tax')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-3 mb-3">
                    <label for="shipping" class="form-label">Shipping</label>
                    <input type="number" step="0.01" class="form-control @error('shipping') is-invalid @enderror" 
                           id="shipping" name="shipping" value="{{ old('shipping', 0) }}">
                    @error('shipping')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-3 mb-3">
                    <label for="discount" class="form-label">Discount</label>
                    <input type="number" step="0.01" class="form-control @error('discount') is-invalid @enderror" 
                           id="discount" name="discount" value="{{ old('discount', 0) }}">
                    @error('discount')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-3 mb-3">
                    <label for="total" class="form-label">Total <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" class="form-control @error('total') is-invalid @enderror" 
                           id="total" name="total" value="{{ old('total', 0) }}" required>
                    @error('total')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-3 mb-3">
                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                    <select class="form-select @error('status') is-invalid @enderror" 
                            id="status" name="status" required>
                        <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ old('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-3 mb-3">
                    <label for="payment_status" class="form-label">Payment Status <span class="text-danger">*</span></label>
                    <select class="form-select @error('payment_status') is-invalid @enderror" 
                            id="payment_status" name="payment_status" required>
                        <option value="pending" {{ old('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="paid" {{ old('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="failed" {{ old('payment_status') == 'failed' ? 'selected' : '' }}>Failed</option>
                        <option value="refunded" {{ old('payment_status') == 'refunded' ? 'selected' : '' }}>Refunded</option>
                    </select>
                    @error('payment_status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-3 mb-3">
                    <label for="payment_method" class="form-label">Payment Method</label>
                    <input type="text" class="form-control @error('payment_method') is-invalid @enderror" 
                           id="payment_method" name="payment_method" value="{{ old('payment_method') }}">
                    @error('payment_method')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="shipping_address" class="form-label">Shipping Address</label>
                    <textarea class="form-control @error('shipping_address') is-invalid @enderror" 
                              id="shipping_address" name="shipping_address" rows="3">{{ old('shipping_address') }}</textarea>
                    @error('shipping_address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="billing_address" class="form-label">Billing Address</label>
                    <textarea class="form-control @error('billing_address') is-invalid @enderror" 
                              id="billing_address" name="billing_address" rows="3">{{ old('billing_address') }}</textarea>
                    @error('billing_address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="notes" class="form-label">Notes</label>
                <textarea class="form-control @error('notes') is-invalid @enderror" 
                          id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                @error('notes')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Create Order
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
