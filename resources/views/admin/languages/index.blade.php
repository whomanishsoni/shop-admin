@extends('admin.layouts.app')

@section('title', 'Languages')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Languages</h1>
    <a href="{{ route('admin.languages.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add Language
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Languages List</h6>
            <button id="bulk-delete" class="btn btn-danger btn-sm" style="display:none;">
                <i class="fas fa-trash"></i> Delete Selected
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="languages-table" width="100%">
                <thead>
                    <tr>
                        <th width="30"><input type="checkbox" id="select-all"></th>
                        <th>Name</th>
                        <th>Code</th>
                        <th>Locale</th>
                        <th>Direction</th>
                        <th>Status</th>
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
    var table = $('#languages-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.languages.index') }}",
        columns: [
            {data: 'checkbox', name: 'checkbox', orderable: false, searchable: false},
            {data: 'name', name: 'name'},
            {data: 'code', name: 'code'},
            {data: 'locale', name: 'locale'},
            {data: 'direction', name: 'direction'},
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

        if (confirm('Are you sure you want to delete selected items?')) {
            $.ajax({
                url: "{{ route('admin.languages.bulk-delete') }}",
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
        if (!confirm('Are you sure you want to delete this item?')) {
            e.preventDefault();
        }
    });
});
</script>
@endpush
