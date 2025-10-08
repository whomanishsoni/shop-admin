@extends('admin.layouts.app')

@section('title', 'Create Product')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Create Product</h1>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <div class="col-md-8">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Basic Information</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Product Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="slug" class="form-label">Slug</label>
                            <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug"
                                name="slug" value="{{ old('slug') }}"
                                placeholder="Leave blank to auto-generate from name">
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="short_description" class="form-label">Short Description</label>
                            <textarea class="form-control @error('short_description') is-invalid @enderror" id="short_description"
                                name="short_description" rows="3">{{ old('short_description') }}</textarea>
                            @error('short_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control ckeditor @error('description') is-invalid @enderror" id="description" name="description"
                                rows="10">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Product Images</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Upload Images (Drag & Drop or Click)</label>
                            <div id="drop-zone" class="border border-2 border-dashed rounded p-5 text-center"
                                style="cursor: pointer; background-color: #f8f9fc;">
                                <i class="fas fa-cloud-upload-alt fa-3x text-primary mb-3"></i>
                                <p class="mb-0">Drag and drop images here or click to browse</p>
                                <small class="text-muted">Supports: JPG, PNG, GIF, WEBP (Max: 2MB each)</small>
                                <input type="file" id="file-input" name="images[]" multiple accept="image/*"
                                    class="d-none">
                            </div>
                            <div id="preview-container" class="row mt-3"></div>
                        </div>
                    </div>
                </div>

                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Product Attributes</h6>
                    </div>
                    <div class="card-body">
                        @foreach ($attributes as $attribute)
                            <div class="mb-3">
                                <label for="attribute_{{ $attribute->id }}"
                                    class="form-label">{{ $attribute->display_name }}</label>
                                @if ($attribute->values)
                                    <select class="form-select select2" name="attributes[{{ $attribute->id }}][]" multiple>
                                        @foreach (json_decode($attribute->values) as $val)
                                            <option value="{{ $val }}"
                                                {{ in_array($val, old('attributes.' . $attribute->id, [])) ? 'selected' : '' }}>
                                                {{ $val }}</option>
                                        @endforeach
                                    </select>
                                @else
                                    <input type="text" class="form-control" name="attributes[{{ $attribute->id }}]"
                                        value="{{ old('attributes.' . $attribute->id) }}">
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">SEO Settings</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="meta_title" class="form-label">Meta Title</label>
                            <input type="text" class="form-control @error('meta_title') is-invalid @enderror" id="meta_title" name="meta_title"
                                value="{{ old('meta_title') }}">
                            @error('meta_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="meta_description" class="form-label">Meta Description</label>
                            <textarea class="form-control @error('meta_description') is-invalid @enderror" id="meta_description" name="meta_description" rows="3">{{ old('meta_description') }}</textarea>
                            @error('meta_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="meta_keywords" class="form-label">Meta Keywords</label>
                            <input type="text" class="form-control @error('meta_keywords') is-invalid @enderror" id="meta_keywords" name="meta_keywords"
                                value="{{ old('meta_keywords') }}" placeholder="Separate with commas">
                            @error('meta_keywords')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Product Data</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="sku" class="form-label">SKU</label>
                            <div class="input-group">
                                <input type="text" class="form-control @error('sku') is-invalid @enderror"
                                    id="sku" name="sku" value="{{ old('sku') }}"
                                    placeholder="Leave blank to auto-generate">
                                <button type="button" class="btn btn-outline-secondary" id="generate-sku">Generate
                                    SKU</button>
                            </div>
                            @error('sku')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="price" class="form-label">Price <span class="text-danger">*</span></label>
                                <input type="number" step="0.01"
                                    class="form-control @error('price') is-invalid @enderror" id="price"
                                    name="price" value="{{ old('price') }}" required>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="sale_price" class="form-label">Discount Price</label>
                                <input type="number" step="0.01"
                                    class="form-control @error('sale_price') is-invalid @enderror" id="sale_price"
                                    name="sale_price" value="{{ old('sale_price') }}">
                                @error('sale_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="stock" class="form-label">Stock <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('stock') is-invalid @enderror"
                                id="stock" name="stock" value="{{ old('stock', 1) }}" required>
                            @error('stock')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="category_id" class="form-label">Category</label>
                            <select class="form-select @error('category_id') is-invalid @enderror" id="category_id"
                                name="category_id">
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="subcategory_id" class="form-label">Subcategory</label>
                            <select class="form-select @error('subcategory_id') is-invalid @enderror" id="subcategory_id"
                                name="subcategory_id">
                                <option value="">Select Subcategory</option>
                            </select>
                            @error('subcategory_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive
                                </option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="card shadow mb-4">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-save"></i> Create Product
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('scripts')
    <script src="https://cdn.ckeditor.com/4.20.1/standard/ckeditor.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "Select options",
                allowClear: true
            });

            CKEDITOR.replace('description', {
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

            const dropZone = document.getElementById('drop-zone');
            const fileInput = document.getElementById('file-input');
            const previewContainer = document.getElementById('preview-container');
            let selectedFiles = [];

            dropZone.addEventListener('click', () => fileInput.click());

            dropZone.addEventListener('dragover', (e) => {
                e.preventDefault();
                dropZone.classList.add('border-primary', 'bg-light');
            });

            dropZone.addEventListener('dragleave', () => {
                dropZone.classList.remove('border-primary', 'bg-light');
            });

            dropZone.addEventListener('drop', (e) => {
                e.preventDefault();
                dropZone.classList.remove('border-primary', 'bg-light');
                const files = Array.from(e.dataTransfer.files);
                handleFiles(files);
            });

            fileInput.addEventListener('change', (e) => {
                const files = Array.from(e.target.files);
                handleFiles(files);
            });

            function handleFiles(files) {
                selectedFiles = [...selectedFiles, ...files];
                updateFileInput();
                renderPreviews();
            }

            function updateFileInput() {
                const dt = new DataTransfer();
                selectedFiles.forEach(file => dt.items.add(file));
                fileInput.files = dt.files;
            }

            function renderPreviews() {
                previewContainer.innerHTML = '';
                selectedFiles.forEach((file, index) => {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        const col = document.createElement('div');
                        col.className = 'col-md-3 mb-3';
                        col.innerHTML = `
                    <div class="card">
                        <img src="${e.target.result}" class="card-img-top" style="height: 150px; object-fit: cover;">
                        <div class="card-body p-2">
                            <button type="button" class="btn btn-danger btn-sm w-100" onclick="removeImage(${index})">
                                <i class="fas fa-trash"></i> Remove
                            </button>
                        </div>
                    </div>
                `;
                        previewContainer.appendChild(col);
                    };
                    reader.readAsDataURL(file);
                });
            }

            window.removeImage = function(index) {
                selectedFiles.splice(index, 1);
                updateFileInput();
                renderPreviews();
            };

            document.getElementById('name').addEventListener('input', function(e) {
                const slug = e.target.value
                    .toLowerCase()
                    .replace(/[^a-z0-9]+/g, '-')
                    .replace(/^-+|-+$/g, '');
                document.getElementById('slug').value = slug;
            });

            document.getElementById('generate-sku').addEventListener('click', function() {
                const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
                let sku = 'PROD-';
                for (let i = 0; i < 8; i++) {
                    sku += chars.charAt(Math.floor(Math.random() * chars.length));
                }
                document.getElementById('sku').value = sku;
            });

            $('#category_id').change(function() {
                var categoryId = $(this).val();
                loadSubcategories(categoryId);
            });

            // Load subcategories on page load if a category is selected
            var categoryId = $('#category_id').val();
            var selectedSub = '{{ old("subcategory_id") }}';
            if (categoryId) {
                loadSubcategories(categoryId, selectedSub);
            }

            function loadSubcategories(categoryId, selectedSub = '') {
                if (categoryId) {
                    $.ajax({
                        url: '{{ route("admin.subcategories.get", ":categoryId") }}'.replace(':categoryId', categoryId),
                        type: 'GET',
                        success: function(data) {
                            var options = '<option value="">Select Subcategory</option>';
                            $.each(data, function(key, value) {
                                var sel = (value.id == selectedSub) ? 'selected' : '';
                                options += '<option value="' + value.id + '" ' + sel + '>' + value.name + '</option>';
                            });
                            $('#subcategory_id').html(options);
                        },
                        error: function(xhr, status, error) {
                            console.error('Error fetching subcategories:', xhr.responseText);
                            alert('Failed to load subcategories. Please try again.');
                            $('#subcategory_id').html('<option value="">Select Subcategory</option>');
                        }
                    });
                } else {
                    $('#subcategory_id').html('<option value="">Select Subcategory</option>');
                }
            }
        });
    </script>
@endpush
