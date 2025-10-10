@extends('admin.layouts.app')

@section('title', 'Create Language')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Create Language</h1>
    <a href="{{ route('admin.languages.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back to List
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <form action="{{ route('admin.languages.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('name') is-invalid @enderror"
                       id="name" name="name" value="{{ old('name') }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="code" class="form-label">Code <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('code') is-invalid @enderror"
                       id="code" name="code" value="{{ old('code') }}" required>
                @error('code')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="locale" class="form-label">Locale <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('locale') is-invalid @enderror"
                       id="locale" name="locale" value="{{ old('locale') }}" required>
                @error('locale')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="direction" class="form-label">Direction <span class="text-danger">*</span></label>
                <select class="form-control @error('direction') is-invalid @enderror" id="direction" name="direction" required>
                    <option value="ltr" {{ old('direction') == 'ltr' ? 'selected' : '' }}>LTR</option>
                    <option value="rtl" {{ old('direction') == 'rtl' ? 'selected' : '' }}>RTL</option>
                </select>
                @error('direction')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
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
                <a href="{{ route('admin.languages.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Create
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
