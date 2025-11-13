@extends('admin.layouts.app')

@section('title', 'Collections')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Collections</h1>
    <a href="{{ route('admin.collections.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add Collection
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">All Collections</h6>
            <div>
                <button type="button" class="btn btn-danger btn-sm" id="bulk-delete-btn" style="display: none;">
                    <i class="fas fa-trash"></i> Delete Selected
                </button>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="collections-table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th width="30">
                            <input type="checkbox" id="select-all">
                        </th>
                        <th width="80">Image</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Description</th>
                        <th>Products</th>
                        <th>Sort Order</th>
                        <th>Status</th>
                        <th width="120">Actions</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#collections-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("admin.collections.index") }}',
        columns: [
            {
                data: 'checkbox',
                orderable: false,
                searchable: false
            },
            {
                data: 'image',
                orderable: false,
                searchable: false
            },
            { data: 'name' },
            { data: 'slug' },
            {
                data: 'description',
                render: function(data) {
                    return data ? data.substring(0, 50) + (data.length > 50 ? '...' : '') : 'N/A';
                }
            },
            { data: 'products_count' },
            { data: 'sort_order' },
            { data: 'status' },
            {
                data: 'action',
                orderable: false,
                searchable: false
            }
        ],
        order: [[5, 'asc']]
    });

    // Handle select all checkbox
    $('#select-all').on('change', function() {
        $('.select-item').prop('checked', $(this).prop('checked'));
        toggleBulkDelete();
    });

    // Handle individual checkboxes
    $(document).on('change', '.select-item', function() {
        toggleBulkDelete();
    });

    function toggleBulkDelete() {
        var checkedBoxes = $('.select-item:checked').length;
        if (checkedBoxes > 0) {
            $('#bulk-delete-btn').show();
        } else {
            $('#bulk-delete-btn').hide();
            $('#select-all').prop('checked', false);
        }
    }

    // Handle bulk delete
    $('#bulk-delete-btn').on('click', function() {
        var selectedIds = [];
        $('.select-item:checked').each(function() {
            selectedIds.push($(this).val());
        });

        if (selectedIds.length > 0) {
            if (confirm('Are you sure you want to delete the selected collections?')) {
                $.ajax({
                    url: '{{ route("admin.collections.bulk-delete") }}',
                    method: 'POST',
                    data: {
                        ids: selectedIds,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('#collections-table').DataTable().ajax.reload();
                        $('#bulk-delete-btn').hide();
                        $('#select-all').prop('checked', false);
                        alert(response.success);
                    },
                    error: function(xhr) {
                        alert('Error deleting collections');
                    }
                });
            }
        }
    });

    // Handle individual delete
    $(document).on('submit', '.delete-form', function(e) {
        if (!confirm('Are you sure you want to delete this collection?')) {
            e.preventDefault();
        }
    });
});
</script>
@endpush
