@extends('admin.layouts.app')

@section('title', 'Categories')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Categories</h1>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add Category
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
            <h6 class="m-0 font-weight-bold text-primary">Categories List</h6>
            <button id="bulk-delete" class="btn btn-danger btn-sm" style="display:none;">
                <i class="fas fa-trash"></i> Delete Selected
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="categories-table" width="100%">
                <thead>
                    <tr>
                        <th width="30"><input type="checkbox" id="select-all"></th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Order</th>
                        <th>Status</th>
                        <th width="100">Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(function() {
    var table = $('#categories-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.categories.index') }}",
        columns: [
            {data: 'checkbox', name: 'checkbox', orderable: false, searchable: false},
            {data: 'image', name: 'image', orderable: false},
            {data: 'name', name: 'name'},
            {data: 'slug', name: 'slug'},
            {data: 'order', name: 'order'},
            {data: 'status', name: 'status'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });

    $('#select-all').on('click', function() {
        $('.select-item').prop('checked', this.checked);
        toggleBulkDelete();
    });

    $(document).on('change', '.select-item', function() {
        toggleBulkDelete();
    });

    function toggleBulkDelete() {
        if ($('.select-item:checked').length > 0) {
            $('#bulk-delete').show();
        } else {
            $('#bulk-delete').hide();
        }
    }

    $('#bulk-delete').on('click', function() {
        var ids = $('.select-item:checked').map(function() {
            return $(this).val();
        }).get();

        if (confirm('Are you sure you want to delete selected categories?')) {
            $.ajax({
                url: "{{ route('admin.categories.bulk-delete') }}",
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    ids: ids
                },
                success: function(response) {
                    table.ajax.reload();
                    $('#bulk-delete').hide();
                    alert(response.success);
                }
            });
        }
    });

    $(document).on('submit', '.delete-form', function(e) {
        if (!confirm('Are you sure you want to delete this category?')) {
            e.preventDefault();
        }
    });
});
</script>
@endpush
