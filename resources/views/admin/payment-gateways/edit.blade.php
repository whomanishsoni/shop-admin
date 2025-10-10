@extends('admin.layouts.app')

@section('title', 'Edit Payment Gateway')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Payment Gateway</h1>
    <a href="{{ route('admin.payment-gateways.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back to List
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <form action="{{ route('admin.payment-gateways.update', $paymentGateway->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('name') is-invalid @enderror"
                       id="name" name="name" value="{{ old('name', $paymentGateway->name) }}" placeholder="e.g., Razorpay" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="gateway_key" class="form-label">Gateway Key <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('gateway_key') is-invalid @enderror"
                       id="gateway_key" name="gateway_key" value="{{ old('gateway_key', $paymentGateway->gateway_key) }}" placeholder="e.g., razorpay" required>
                @error('gateway_key')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="api_key" class="form-label">API Key</label>
                <input type="text" class="form-control @error('api_key') is-invalid @enderror"
                       id="api_key" name="api_key" value="{{ old('api_key', $paymentGateway->api_key) }}" placeholder="e.g., rzp_test_xxxxxxxxxxxx">
                @error('api_key')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="api_secret" class="form-label">API Secret</label>
                <input type="text" class="form-control @error('api_secret') is-invalid @enderror"
                       id="api_secret" name="api_secret" value="{{ old('api_secret', $paymentGateway->api_secret) }}" placeholder="e.g., xxxxxxxxxxxxxxxx">
                @error('api_secret')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="config" class="form-label">Additional Config (JSON)</label>
                <textarea class="form-control @error('config') is-invalid @enderror"
                          id="config" name="config" rows="4" placeholder='e.g., {"webhook_url": "https://example.com/webhook"}'>{{ old('config', json_encode($paymentGateway->config, JSON_PRETTY_PRINT)) }}</textarea>
                @error('config')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                    <option value="1" {{ old('status', $paymentGateway->status) == 1 ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ old('status', $paymentGateway->status) == 0 ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.payment-gateways.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
