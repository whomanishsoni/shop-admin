@extends('admin.layouts.app')

@section('title', 'Edit Product Attribute')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Product Attribute</h1>
    <a href="{{ route('admin.product-attributes.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <form action="{{ route('admin.product-attributes.update', $productAttribute->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Attribute Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $productAttribute->name) }}" required placeholder="e.g., color, size">
                    <small class="text-muted">This will be used internally (lowercase, no spaces)</small>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Display Name <span class="text-danger">*</span></label>
                    <input type="text" name="display_name" class="form-control @error('display_name') is-invalid @enderror" value="{{ old('display_name', $productAttribute->display_name) }}" required placeholder="e.g., Color, Size">
                    <small class="text-muted">This will be shown to users</small>
                    @error('display_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Attribute Values <span class="text-danger">*</span></label>
                <div id="attribute-values">
                    @if(old('values'))
                        @foreach(old('values') as $value)
                            <div class="input-group mb-2">
                                <input type="text" name="values[]" class="form-control" value="{{ $value }}" placeholder="Enter value" required>
                                <button type="button" class="btn btn-danger" onclick="removeValue(this)">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        @endforeach
                    @elseif($productAttribute->values)
                        @foreach(json_decode($productAttribute->values) as $value)
                            <div class="input-group mb-2">
                                <input type="text" name="values[]" class="form-control" value="{{ $value }}" placeholder="Enter value" required>
                                <button type="button" class="btn btn-danger" onclick="removeValue(this)">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        @endforeach
                    @endif
                </div>
                <button type="button" class="btn btn-success btn-sm mt-2" onclick="addValue()">
                    <i class="fas fa-plus"></i> Add Value
                </button>
                <br>
                <small class="text-muted">Add possible values for this attribute (e.g., Red, Blue, Green for color)</small>
                @error('values')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <div class="form-check">
                    <input type="checkbox" name="status" class="form-check-input" value="1" {{ old('status', $productAttribute->status) ? 'checked' : '' }}>
                    <label class="form-check-label">Active</label>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update Attribute
                </button>
                <a href="{{ route('admin.product-attributes.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function addValue() {
    const valueDiv = document.getElementById('attribute-values');
    const newInput = document.createElement('div');
    newInput.className = 'input-group mb-2';
    newInput.innerHTML = `
        <input type="text" name="values[]" class="form-control" placeholder="Enter value" required>
        <button type="button" class="btn btn-danger" onclick="removeValue(this)">
            <i class="fas fa-minus"></i>
        </button>
    `;
    valueDiv.appendChild(newInput);
}

function removeValue(button) {
    button.closest('.input-group').remove();
}
</script>
@endpush
@endsection
