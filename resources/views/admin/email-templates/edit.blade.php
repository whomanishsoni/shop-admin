@extends('admin.layouts.app')

@section('title', 'Edit Email Template')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Email Template</h1>
    <a href="{{ route('admin.email-templates.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back to List
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <form action="{{ route('admin.email-templates.update', $emailTemplate->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label for="name" class="form-label">Template Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                               id="name" name="name" value="{{ old('name', $emailTemplate->name) }}" required placeholder="e.g., Welcome Email">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="subject" class="form-label">Email Subject <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('subject') is-invalid @enderror"
                               id="subject" name="subject" value="{{ old('subject', $emailTemplate->subject) }}" required placeholder="Welcome to {{{ '{{site_name}}' }}}!">
                        @error('subject')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">You can use variables like @{{ 'site_name' }}, @{{ 'user_name' }}, etc.</small>
                    </div>

                    <div class="mb-3">
                        <label for="body" class="form-label">Email Body <span class="text-danger">*</span></label>
                        <textarea class="form-control ckeditor @error('body') is-invalid @enderror"
                                  id="body" name="body" rows="15" required>{{ old('body', $emailTemplate->body) }}</textarea>
                        @error('body')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Use HTML and variables like @{{ 'user_name' }}, @{{ 'order_number' }}, etc.</small>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card bg-light mb-3">
                        <div class="card-header">
                            <strong>Available Variables</strong>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="variables" class="form-label">Variables (one per line)</label>
                                <textarea class="form-control @error('variables') is-invalid @enderror"
                                          id="variables" name="variables" rows="8" placeholder="{{{ '{{user_name}}' }}}&#10;{{{ '{{user_email}}' }}}&#10;{{{ '{{site_name}}' }}}&#10;{{{ '{{order_number}}' }}}">{{ old('variables', is_array(json_decode($emailTemplate->variables, true)) ? implode("\n", json_decode($emailTemplate->variables, true)) : $emailTemplate->variables) }}</textarea>
                                @error('variables')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Add custom variables for this template</small>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="form-check mb-3">
                                <input type="checkbox" class="form-check-input" id="status" name="status" value="1" {{ old('status', $emailTemplate->status) ? 'checked' : '' }}>
                                <label class="form-check-label" for="status">
                                    <strong>Active</strong>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <h6 class="text-white">💡 Common Variables:</h6>
                            <ul class="mb-0 small">
                                <li>@{{ 'user_name' }}</li>
                                <li>@{{ 'user_email' }}</li>
                                <li>@{{ 'site_name' }}</li>
                                <li>@{{ 'site_url' }}</li>
                                <li>@{{ 'order_number' }}</li>
                                <li>@{{ 'order_total' }}</li>
                                <li>@{{ 'customer_name' }}</li>
                                <li>@{{ 'order_id' }}</li>
                                <li>@{{ 'product_name' }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('admin.email-templates.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update Template
                </button>
                <form action="{{ route('admin.email-templates.send-test', $emailTemplate->id) }}" method="POST" style="display:inline;" class="d-inline ms-2">
                    @csrf
                    <div class="input-group input-group-sm" style="width: 250px;">
                        <input type="email" name="test_email" placeholder="test@example.com" required
                               class="form-control" value="{{ old('test_email') }}">
                        <button type="submit" class="btn btn-info">
                            <i class="fas fa-paper-plane"></i> Test Email
                        </button>
                    </div>
                </form>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(function() {
    CKEDITOR.replace('body', {
        height: 300,
        toolbar: [{
                name: 'document',
                items: ['Source']
            },
            {
                name: 'clipboard',
                items: ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo',
                    'Redo'
                ]
            },
            {
                name: 'editing',
                items: ['Find', 'Replace', '-', 'SelectAll']
            },
            {
                name: 'basicstyles',
                items: ['Bold', 'Italic', 'Underline', 'Strike', '-', 'RemoveFormat']
            },
            {
                name: 'paragraph',
                items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-',
                    'Blockquote'
                ]
            },
            {
                name: 'links',
                items: ['Link', 'Unlink']
            },
            {
                name: 'insert',
                items: ['Image', 'Table', 'HorizontalRule']
            },
            {
                name: 'styles',
                items: ['Styles', 'Format', 'Font', 'FontSize']
            },
            {
                name: 'colors',
                items: ['TextColor', 'BGColor']
            },
            {
                name: 'tools',
                items: ['Maximize']
            }
        ]
    });
});
</script>
@endpush
