@extends('admin.layouts.app')

@section('title', 'Notifications')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Notifications</h1>
    <a href="{{ route('admin.notifications.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Create Notification
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
            <h6 class="m-0 font-weight-bold text-primary">Notifications List</h6>
            <button id="bulk-delete" class="btn btn-danger btn-sm" style="display:none;">
                <i class="fas fa-trash"></i> Delete Selected
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="notifications-table" width="100%">
                <thead>
                    <tr>
                        <th width="30"><input type="checkbox" id="select-all"></th>
                        <th>Title</th>
                        <th>User</th>
                        <th>Type</th>
                        <th>Status</th>
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
    var table = $('#notifications-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.notifications.index') }}",
        columns: [
            {data: 'checkbox', name: 'checkbox', orderable: false, searchable: false},
            {data: 'title', name: 'title'},
            {data: 'user', name: 'user'},
            {data: 'type', name: 'type'},
            {data: 'read_status', name: 'read_status'},
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

        if (confirm('Are you sure you want to delete selected notifications?')) {
            $.ajax({
                url: "{{ route('admin.notifications.bulk-delete') }}",
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
        if (!confirm('Are you sure you want to delete this notification?')) {
            e.preventDefault();
        }
    });
});
</script>
@endpush
