@extends('admin.layouts.app')

@section('title', 'View Blog Post')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">View Blog Post</h1>
    <div>
        <a href="{{ route('admin.blog-posts.edit', $blogPost->id) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Edit
        </a>
        <a href="{{ route('admin.blog-posts.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">{{ $blogPost->title }}</h6>
            </div>
            <div class="card-body">
                @if($blogPost->featured_image)
                <div class="mb-4">
                    <img src="{{ asset('storage/' . $blogPost->featured_image) }}" 
                         alt="{{ $blogPost->title }}" 
                         class="img-fluid rounded" style="max-height: 400px; width: 100%; object-fit: cover;">
                </div>
                @endif

                <div class="mb-3">
                    <h5>Content</h5>
                    <div class="blog-content">
                        {!! nl2br(e($blogPost->content)) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Post Details</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Slug:</strong>
                    <p class="mb-0 text-muted">{{ $blogPost->slug }}</p>
                </div>

                <div class="mb-3">
                    <strong>Category:</strong>
                    <p class="mb-0">
                        <span class="badge bg-primary">{{ $blogPost->blogCategory->name ?? 'N/A' }}</span>
                    </p>
                </div>

                <div class="mb-3">
                    <strong>Author:</strong>
                    <p class="mb-0">{{ $blogPost->author->name ?? 'N/A' }}</p>
                </div>

                <div class="mb-3">
                    <strong>Status:</strong>
                    <p class="mb-0">
                        <span class="badge bg-{{ $blogPost->status === 'published' ? 'success' : 'secondary' }}">
                            {{ ucfirst($blogPost->status) }}
                        </span>
                    </p>
                </div>

                <div class="mb-3">
                    <strong>Created:</strong>
                    <p class="mb-0 text-muted">{{ $blogPost->created_at->format('M d, Y h:i A') }}</p>
                </div>

                <div class="mb-3">
                    <strong>Last Updated:</strong>
                    <p class="mb-0 text-muted">{{ $blogPost->updated_at->format('M d, Y h:i A') }}</p>
                </div>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Actions</h6>
            </div>
            <div class="card-body">
                <a href="{{ route('admin.blog-posts.edit', $blogPost->id) }}" class="btn btn-warning btn-block w-100 mb-2">
                    <i class="fas fa-edit"></i> Edit Post
                </a>
                
                <form action="{{ route('admin.blog-posts.destroy', $blogPost->id) }}" method="POST" 
                      onsubmit="return confirm('Are you sure you want to delete this blog post?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-block w-100">
                        <i class="fas fa-trash"></i> Delete Post
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
