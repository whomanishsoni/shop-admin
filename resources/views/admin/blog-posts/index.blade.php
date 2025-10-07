@extends('admin.layouts.app')

@section('title', 'Blog Posts')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Blog Posts</h1>
    <a href="{{ route('admin.blog-posts.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add Blog Post
    </a>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Blog Posts List</h6>
            <button id="bulk-delete" class="btn btn-danger btn-sm" style="display:none;">
                <i class="fas fa-trash"></i> Delete Selected
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="blog-posts-table" width="100%">
                <thead>
                    <tr>
                        <th width="30"><input type="checkbox" id="select-all"></th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Author</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($blogPosts as $post)
                    <tr>
                        <td><input type="checkbox" class="select-item" value="{{ $post->id }}"></td>
                        <td>{{ $post->title }}</td>
                        <td>{{ $post->blogCategory->name ?? 'N/A' }}</td>
                        <td>{{ $post->author->name ?? 'N/A' }}</td>
                        <td>
                            <span class="badge bg-{{ $post->status === 'published' ? 'success' : 'secondary' }}">
                                {{ ucfirst($post->status) }}
                            </span>
                        </td>
                        <td>{{ $post->created_at->format('M d, Y') }}</td>
                        <td>
                            <a href="{{ route('admin.blog-posts.show', $post->id) }}" class="btn btn-info btn-sm" title="View">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.blog-posts.edit', $post->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.blog-posts.destroy', $post->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $blogPosts->links() }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(function() {
    $('#select-all').on('click', function() {
        $('.select-item').prop('checked', this.checked);
        toggleBulkDelete();
    });

    $(document).on('change', '.select-item', function() {
        toggleBulkDelete();
    });

    function toggleBulkDelete() {
        var checked = $('.select-item:checked').length;
        if (checked > 0) {
            $('#bulk-delete').show();
        } else {
            $('#bulk-delete').hide();
        }
    }

    $('#bulk-delete').on('click', function() {
        var ids = [];
        $('.select-item:checked').each(function() {
            ids.push($(this).val());
        });

        if (confirm('Are you sure you want to delete ' + ids.length + ' blog post(s)?')) {
            $.ajax({
                url: "{{ route('admin.blog-posts.bulk-delete') }}",
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    ids: ids
                },
                success: function(response) {
                    location.reload();
                }
            });
        }
    });
});
</script>
@endpush
