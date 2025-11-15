@extends('admin.layouts.app')

@section('title', 'Create Video')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Create Video</h1>
        <a href="{{ route('admin.videos.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>

    <form action="{{ route('admin.videos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <div class="col-md-8">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Video Information</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="title" class="form-label">Video Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                                name="title" value="{{ old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Upload Video <span class="text-danger">*</span></label>
                            <div id="video-drop-zone" class="border border-2 border-dashed rounded p-5 text-center"
                                style="cursor: pointer; background-color: #f8f9fc;">
                                <i class="fas fa-video fa-3x text-primary mb-3"></i>
                                <p class="mb-0">Drag and drop video here or click to browse</p>
                                <small class="text-muted">Supports: MP4, MOV, AVI, WMV (Max: 20MB)</small>
                                <input type="file" id="video-input" name="video" accept="video/*" class="d-none" required>
                            </div>

                            <!-- Progress Bar -->
                            <div id="upload-progress" class="mt-3" style="display: none;">
                                <div class="progress">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated"
                                         id="progress-bar" role="progressbar" style="width: 0%">
                                        <span id="progress-text">0%</span>
                                    </div>
                                </div>
                                <small class="text-muted mt-1" id="progress-status">Preparing upload...</small>
                            </div>

                            <div id="video-preview" class="mt-3 text-center" style="display: none;">
                                <video id="video-element" controls style="max-width: 100%; max-height: 300px;">
                                    <source id="video-source" src="" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                                <br>
                                <button type="button" class="btn btn-sm btn-danger mt-2" id="remove-video">
                                    <i class="fas fa-trash"></i> Remove Video
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Settings</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="sort_order" class="form-label">Sort Order</label>
                            <input type="number" class="form-control @error('sort_order') is-invalid @enderror"
                                id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}" min="0">
                            @error('sort_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Lower numbers appear first</small>
                        </div>
                    </div>
                </div>

                <div class="card shadow mb-4">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-save"></i> Create Video
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    let uploadedFilePath = null;
    let isUploading = false;

    // Video upload functionality with chunked upload
    const videoDropZone = document.getElementById('video-drop-zone');
    const videoInput = document.getElementById('video-input');
    const videoPreview = document.getElementById('video-preview');
    const videoElement = document.getElementById('video-element');
    const videoSource = document.getElementById('video-source');
    const removeVideoBtn = document.getElementById('remove-video');
    const uploadProgress = document.getElementById('upload-progress');
    const progressBar = document.getElementById('progress-bar');
    const progressText = document.getElementById('progress-text');
    const progressStatus = document.getElementById('progress-status');

    videoDropZone.addEventListener('click', () => {
        if (!isUploading) {
            videoInput.click();
        }
    });

    videoDropZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        if (!isUploading) {
            videoDropZone.classList.add('border-primary', 'bg-light');
        }
    });

    videoDropZone.addEventListener('dragleave', () => {
        if (!isUploading) {
            videoDropZone.classList.remove('border-primary', 'bg-light');
        }
    });

    videoDropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        if (!isUploading) {
            videoDropZone.classList.remove('border-primary', 'bg-light');
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                handleVideoFile(files[0]);
            }
        }
    });

    videoInput.addEventListener('change', (e) => {
        const file = e.target.files[0];
        if (file && !isUploading) {
            handleVideoFile(file);
        }
    });

    removeVideoBtn.addEventListener('click', () => {
        if (!isUploading) {
            videoInput.value = '';
            uploadedFilePath = null;
            videoPreview.style.display = 'none';
            uploadProgress.style.display = 'none';
            videoDropZone.style.display = 'block';
            updateProgress(0, 'Ready to upload');
        }
    });

    function handleVideoFile(file) {
        if (file && file.type.startsWith('video/')) {
            // Check file size (20MB limit)
            const maxSize = 20 * 1024 * 1024; // 20MB in bytes
            if (file.size > maxSize) {
                alert('File size exceeds 20MB limit. Please choose a smaller file.');
                return;
            }

            // Start chunked upload
            uploadFileInChunks(file);
        } else {
            alert('Please select a valid video file.');
        }
    }

    function uploadFileInChunks(file) {
        isUploading = true;
        const chunkSize = 1 * 1024 * 1024; // 1MB chunks to work with 2MB PHP limit
        const totalChunks = Math.ceil(file.size / chunkSize);
        const uploadId = generateUploadId();
        const maxConcurrent = 2; // Upload up to 2 chunks simultaneously for safety

        updateProgress(0, 'Preparing upload...');
        uploadProgress.style.display = 'block';

        let uploadedChunks = 0;
        let activeUploads = 0;
        let nextChunkIndex = 0;
        let failedChunks = new Set();

        function uploadChunk(chunkIndex) {
            if (failedChunks.has(chunkIndex)) {
                return; // Skip already failed chunks
            }

            const start = chunkIndex * chunkSize;
            const end = Math.min(start + chunkSize, file.size);
            const chunk = file.slice(start, end);

            const formData = new FormData();
            formData.append('chunk', chunk);
            formData.append('chunkIndex', chunkIndex);
            formData.append('totalChunks', totalChunks);
            formData.append('fileName', file.name);
            formData.append('uploadId', uploadId);
            formData.append('_token', '{{ csrf_token() }}');

            activeUploads++;

            fetch('{{ route("admin.videos.upload-chunk") }}', {
                method: 'POST',
                body: formData,
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                }
                return response.json();
            })
            .then(data => {
                activeUploads--;

                if (data.success) {
                    uploadedChunks++;
                    const progress = Math.round((uploadedChunks / totalChunks) * 90); // Reserve 10% for merging
                    updateProgress(progress, `Uploading... ${uploadedChunks}/${totalChunks} chunks`);

                    // Start next chunk if available
                    if (nextChunkIndex < totalChunks && activeUploads < maxConcurrent) {
                        uploadChunk(nextChunkIndex++);
                    }

                    // Check if all chunks are uploaded
                    if (uploadedChunks === totalChunks) {
                        updateProgress(95, 'Merging chunks...');
                        mergeChunks(uploadId, file.name, totalChunks);
                    }
                } else {
                    throw new Error('Chunk upload failed: ' + JSON.stringify(data));
                }
            })
            .catch(error => {
                activeUploads--;
                console.error(`Chunk ${chunkIndex} upload error:`, error);

                // Check for specific error types
                if (error.message.includes('413') || error.message.includes('Request Entity Too Large')) {
                    alert('Upload failed: File chunk is too large for server limits. Please contact administrator to increase upload limits.');
                    isUploading = false;
                    uploadProgress.style.display = 'none';
                    return;
                }

                failedChunks.add(chunkIndex);

                // Retry failed chunk up to 3 times
                const retryCount = [...failedChunks].filter(c => c === chunkIndex).length;
                if (retryCount < 3) {
                    console.log(`Retrying chunk ${chunkIndex} (attempt ${retryCount + 1})`);
                    setTimeout(() => {
                        failedChunks.delete(chunkIndex); // Allow retry
                        uploadChunk(chunkIndex);
                    }, 1000 * retryCount);
                } else {
                    alert(`Failed to upload chunk ${chunkIndex} after 3 attempts. Please try again.`);
                    isUploading = false;
                    uploadProgress.style.display = 'none';
                }
            });
        }

        // Start initial concurrent uploads
        for (let i = 0; i < Math.min(maxConcurrent, totalChunks); i++) {
            uploadChunk(nextChunkIndex++);
        }
    }

    function mergeChunks(uploadId, fileName, totalChunks) {
        updateProgress(100, 'Merging chunks...');

        const formData = new FormData();
        formData.append('uploadId', uploadId);
        formData.append('fileName', fileName);
        formData.append('totalChunks', totalChunks);
        formData.append('_token', '{{ csrf_token() }}');

        fetch('{{ route("admin.videos.merge-chunks") }}', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                uploadedFilePath = data.filePath;
                updateProgress(100, 'Upload completed successfully!');

                // Show video preview
                videoSource.src = data.fileUrl;
                videoElement.load();
                videoPreview.style.display = 'block';
                videoDropZone.style.display = 'none';

                setTimeout(() => {
                    uploadProgress.style.display = 'none';
                    updateProgress(0, 'Ready to upload');
                }, 2000);

                isUploading = false;
            } else {
                throw new Error('Merge failed');
            }
        })
        .catch(error => {
            console.error('Merge error:', error);
            alert('Upload failed during merge. Please try again.');
            isUploading = false;
            uploadProgress.style.display = 'none';
        });
    }

    function updateProgress(percent, status) {
        progressBar.style.width = percent + '%';
        progressText.textContent = percent + '%';
        progressStatus.textContent = status;
    }

    function generateUploadId() {
        return Date.now().toString() + Math.random().toString(36).substr(2, 9);
    }

    // Update form submission to use uploaded file path
    $('form').on('submit', function(e) {
        if (isUploading) {
            e.preventDefault();
            alert('Please wait for the upload to complete.');
            return false;
        }

        if (!uploadedFilePath) {
            e.preventDefault();
            alert('Please upload a video first.');
            return false;
        }

        // Add hidden input with file path
        if (!$('input[name="video_path"]').length) {
            $('<input>').attr({
                type: 'hidden',
                name: 'video_path',
                value: uploadedFilePath
            }).appendTo('form');
        }

        // Remove the file input to avoid validation issues
        $('#video-input').remove();
    });
});
</script>
@endpush
