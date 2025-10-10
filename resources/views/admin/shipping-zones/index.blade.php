@extends('admin.layouts.app')

@section('title', 'Shipping Zones')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Shipping Zones</h1>
    <a href="{{ route('admin.shipping-zones.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50"></i> Add New Zone
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Shipping Zones List</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="shipping-zones-table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="select-all"></th>
                        <th>Name</th>
                        <th>States</th>
                        <th>Shipping Method</th>
                        <th>Rate</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    var table = $('#shipping-zones-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('admin.shipping-zones.index') }}",
            error: function(xhr, error, thrown) {
                console.log('DataTables AJAX error:', xhr.responseText, error, thrown);
                alert('Failed to load data. Check console for details.');
            }
        },
        columns: [
            { data: 'checkbox', name: 'checkbox', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'states', name: 'states' },
            { data: 'shipping_method', name: 'shipping_method' },
            { data: 'rate', name: 'rate' },
            { data: 'status', name: 'status' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        order: [[1, 'asc']],
        pageLength: 10
    });

    $('#select-all').on('click', function() {
        $('input.select-item').prop('checked', this.checked);
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
        if (confirm('Are you sure you want to delete selected items?')) {
            var ids = $('.select-item:checked').map(function() {
                return $(this).val();
            }).get();
            $.ajax({
                url: "{{ route('admin.shipping-zones.bulk-delete') }}",
                type: 'POST',
                data: { _token: '{{ csrf_token() }}', ids: ids },
                success: function(response) {
                    table.ajax.reload();
                    alert(response.success);
                },
                error: function(xhr) {
                    alert('Error deleting items.');
                    console.log(xhr.responseText);
                }
            });
        }
    });

    $(document).on('submit', '.delete-form', function(e) {
        if (!confirm('Are you sure you want to delete this item?')) {
            e.preventDefault();
        }
    });
});
</script>
@endpush
