@extends('admin.layouts.app')

@section('title', 'Product Reviews')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Reviews List</h6>
            <button id="bulk-delete" class="btn btn-danger btn-sm" style="display:none;">
                <i class="fas fa-trash"></i> Delete Selected
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="reviews-table" width="100%">
                <thead>
                    <tr>
                        <th width="30"><input type="checkbox" id="select-all"></th>
                        <th>Product</th>
                        <th>Customer</th>
                        <th>Rating</th>
                        <th>Comment</th>
                        <th>Date</th>
                        <th width="150">Actions</th>
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
    var table = $('#reviews-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('admin.product-reviews.index') }}",
            type: "GET",
            error: function(xhr, error, thrown) {
                console.log('AJAX Error: ', xhr.responseText);
            }
        },
        columns: [
            {data: 'checkbox', name: 'checkbox', orderable: false, searchable: false},
            {data: 'product', name: 'product'},
            {data: 'customer', name: 'customer'},
            {data: 'rating', name: 'rating'},
            {data: 'comment', name: 'comment'},
            {data: 'created_at', name: 'created_at'},
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

        if (confirm('Are you sure you want to delete selected reviews?')) {
            $.ajax({
                url: "{{ route('admin.product-reviews.bulk-delete') }}",
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    ids: ids
                },
                success: function(response) {
                    table.ajax.reload();
                    $('#bulk-delete').hide();
                    alert(response.success);
                },
                error: function(xhr, error, thrown) {
                    console.log('Bulk Delete Error: ', xhr.responseText);
                }
            });
        }
    });

    $(document).on('submit', '.delete-form', function(e) {
        if (!confirm('Are you sure you want to delete this review?')) {
            e.preventDefault();
        }
    });
});
</script>
@endpush
