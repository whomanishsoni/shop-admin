@extends('admin.layouts.app')

@section('title', 'Create Payment Gateway')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Create Payment Gateway</h1>
    <a href="{{ route('admin.payment-gateways.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back to List
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <form action="{{ route('admin.payment-gateways.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('name') is-invalid @enderror"
                       id="name" name="name" value="{{ old('name') }}" placeholder="e.g., Razorpay" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="gateway_key" class="form-label">Gateway Type <span class="text-danger">*</span></label>
                <select class="form-control @error('gateway_key') is-invalid @enderror" id="gateway_key" name="gateway_key" required>
                    <option value="">Select Gateway</option>
                    <option value="razorpay" {{ old('gateway_key') == 'razorpay' ? 'selected' : '' }}>Razorpay</option>
                    <option value="cod" {{ old('gateway_key') == 'cod' ? 'selected' : '' }}>Cash on Delivery</option>
                </select>
                @error('gateway_key')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3" id="mode-section" style="display: none;">
                <label for="mode" class="form-label">Mode <span class="text-danger">*</span></label>
                <select class="form-control @error('mode') is-invalid @enderror" id="mode" name="mode">
                    <option value="test" {{ old('mode', 'test') == 'test' ? 'selected' : '' }}>Test</option>
                    <option value="live" {{ old('mode', 'test') == 'live' ? 'selected' : '' }}>Live</option>
                </select>
                @error('mode')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Razorpay API Keys Section -->
            <div id="razorpay-keys" style="display: none;">
                <h5 class="mb-3">API Credentials</h5>

                <div class="mb-3">
                    <label for="test_key_id" class="form-label">Test Key ID</label>
                    <input type="text" class="form-control @error('test_key_id') is-invalid @enderror"
                           id="test_key_id" name="test_key_id" value="{{ old('test_key_id') }}" placeholder="rzp_test_xxxxxxxxxxxx">
                    @error('test_key_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="test_key_secret" class="form-label">Test Key Secret</label>
                    <input type="password" class="form-control @error('test_key_secret') is-invalid @enderror"
                           id="test_key_secret" name="test_key_secret" value="{{ old('test_key_secret') }}" placeholder="xxxxxxxxxxxx">
                    @error('test_key_secret')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="live_key_id" class="form-label">Live Key ID</label>
                    <input type="text" class="form-control @error('live_key_id') is-invalid @enderror"
                           id="live_key_id" name="live_key_id" value="{{ old('live_key_id') }}" placeholder="rzp_live_xxxxxxxxxxxx">
                    @error('live_key_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="live_key_secret" class="form-label">Live Key Secret</label>
                    <input type="password" class="form-control @error('live_key_secret') is-invalid @enderror"
                           id="live_key_secret" name="live_key_secret" value="{{ old('live_key_secret') }}" placeholder="xxxxxxxxxxxx">
                    @error('live_key_secret')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                    <option value="1" {{ old('status', 1) == 1 ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ old('status', 1) == 0 ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.payment-gateways.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Create
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    function toggleFields() {
        var gatewayKey = $('#gateway_key').val();
        if (gatewayKey === 'razorpay') {
            $('#mode-section').show();
            $('#razorpay-keys').show();
            $('#mode').prop('required', true);
        } else {
            $('#mode-section').hide();
            $('#razorpay-keys').hide();
            $('#mode').prop('required', false);
        }
    }

    $('#gateway_key').on('change', function() {
        toggleFields();
    });

    // Initial check
    toggleFields();
});
</script>
@endpush
