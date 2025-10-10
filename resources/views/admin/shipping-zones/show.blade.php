@extends('admin.layouts.app')

@section('title', 'Shipping Zones')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Shipping Zones</h1>
    <a href="{{ route('admin.shipping-zones.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add
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
            <h6 class="m-0 font-weight-bold text-primary">Shipping Zones List</h6>
            <button id="bulk-delete" class="btn btn-danger btn-sm" style="display:none;">
                <i class="fas fa-trash"></i> Delete Selected
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="shipping-zones-table" width="100%">
                <thead>
                    <tr>
                        <th width="30"><input type="checkbox" id="select-all"></th>
                        <th>Name</th>
                        <th>States</th>
                        <th>Shipping Method</th>
                        <th>Rate</th>
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
    var indianStates = {
        'AN': 'Andaman and Nicobar Islands',
        'AP': 'Andhra Pradesh',
        'AR': 'Arunachal Pradesh',
        'AS': 'Assam',
        'BR': 'Bihar',
        'CH': 'Chandigarh',
        'CT': 'Chhattisgarh',
        'DL': 'Delhi',
        'DN': 'Dadra and Nagar Haveli and Daman and Diu',
        'GA': 'Goa',
        'GJ': 'Gujarat',
        'HP': 'Himachal Pradesh',
        'HR': 'Haryana',
        'JH': 'Jharkhand',
        'JK': 'Jammu and Kashmir',
        'KA': 'Karnataka',
        'KL': 'Kerala',
        'LA': 'Ladakh',
        'LD': 'Lakshadweep',
        'MH': 'Maharashtra',
        'ML': 'Meghalaya',
        'MN': 'Manipur',
        'MP': 'Madhya Pradesh',
        'MZ': 'Mizoram',
        'NL': 'Nagaland',
        'OR': 'Odisha',
        'PB': 'Punjab',
        'PY': 'Puducherry',
        'RJ': 'Rajasthan',
        'SK': 'Sikkim',
        'TN': 'Tamil Nadu',
        'TG': 'Telangana',
        'TR': 'Tripura',
        'UP': 'Uttar Pradesh',
        'UT': 'Uttarakhand',
        'WB': 'West Bengal'
    };

    var table = $('#shipping-zones-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('admin.shipping-zones.index') }}",
            error: function(xhr, error, thrown) {
                console.log('DataTables AJAX error:', xhr, error, thrown);
                alert('Failed to load data. Please check the console for details.');
            }
        },
        columns: [
            {data: 'checkbox', name: 'checkbox', orderable: false, searchable: false},
            {data: 'name', name: 'name'},
            {
                data: 'states',
                name: 'states',
                render: function(data) {
                    if (data && Array.isArray(data) && data.length > 0) {
                        return data.map(function(code) {
                            return indianStates[code] || code;
                        }).join(', ');
                    }
                    return 'N/A';
                }
            },
            {data: 'shipping_method', name: 'shipping_method'},
            {data: 'rate', name: 'rate'},
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
                url: "{{ route('admin.shipping-zones.bulk-delete') }}",
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
                error: function(xhr) {
                    alert('Failed to delete items. Please check the console for details.');
                    console.log('Bulk delete error:', xhr);
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
