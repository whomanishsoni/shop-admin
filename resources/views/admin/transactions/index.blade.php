@extends('admin.layouts.app')

@section('title', 'Transactions')

@section('content')

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<!-- Filters -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Filter Transactions</h6>
    </div>
    <div class="card-body">
        <form id="filter-form" class="row g-3">
            <div class="col-md-3">
                <label for="status_filter" class="form-label">Status</label>
                <select class="form-select" id="status_filter" name="status">
                    <option value="">All Status</option>
                    <option value="paid">Paid</option>
                    <option value="pending">Pending</option>
                    <option value="failed">Failed</option>
                    <option value="refunded">Refunded</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="payment_method_filter" class="form-label">Payment Method</label>
                <select class="form-select" id="payment_method_filter" name="payment_method">
                    <option value="">All Methods</option>
                    <option value="razorpay">Razorpay</option>
                    <option value="cod">Cash on Delivery</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="date_from" class="form-label">From Date</label>
                <input type="date" class="form-control" id="date_from" name="date_from">
            </div>
            <div class="col-md-3">
                <label for="date_to" class="form-label">To Date</label>
                <input type="date" class="form-control" id="date_to" name="date_to">
            </div>
        </form>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Transactions List</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="transactions-table" width="100%">
                <thead>
                    <tr>
                        <th width="30"><input type="checkbox" id="select-all"></th>
                        <th>Customer</th>
                        <th>Order</th>
                        <th>Transaction ID</th>
                        <th>Amount</th>
                        <th>Payment Method</th>
                        <th>Payment Mode</th>
                        <th>Status</th>
                        <th>Payment Date</th>
                        <th width="80">Actions</th>
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
    var table = $('#transactions-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('admin.transactions.index') }}",
            data: function(d) {
                d.status = $('#status_filter').val();
                d.payment_method = $('#payment_method_filter').val();
                d.date_from = $('#date_from').val();
                d.date_to = $('#date_to').val();
            }
        },
        columns: [
            {data: 'checkbox', name: 'checkbox', orderable: false, searchable: false},
            {data: 'customer', name: 'customer'},
            {data: 'order', name: 'order'},
            {data: 'transaction_id', name: 'transaction_id'},
            {data: 'amount', name: 'amount'},
            {data: 'payment_method', name: 'payment_method'},
            {data: 'payment_mode', name: 'payment_mode'},
            {data: 'status', name: 'status'},
            {data: 'payment_date', name: 'payment_date'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });

    // Select all functionality for future import/export
    $('#select-all').on('click', function() {
        $('.select-item').prop('checked', this.checked);
    });

    // Auto-apply filters on change
    $('#status_filter, #payment_method_filter, #date_from, #date_to').on('change', function() {
        table.ajax.reload();
    });
});
</script>
@endpush
