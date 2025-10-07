@extends('admin.layouts.app')

@section('title', 'View Transaction')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">View Transaction</h1>
    <div>
        <a href="{{ route('admin.transactions.edit', $transaction->id) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Edit
        </a>
        <a href="{{ route('admin.transactions.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Transaction Details</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Transaction ID:</strong>
                    <p class="mb-0">{{ $transaction->transaction_id }}</p>
                </div>

                <div class="mb-3">
                    <strong>Order:</strong>
                    <p class="mb-0">{{ $transaction->order->order_number ?? 'N/A' }}</p>
                </div>

                <div class="mb-3">
                    <strong>Amount:</strong>
                    <p class="mb-0">${{ number_format($transaction->amount, 2) }}</p>
                </div>

                <div class="mb-3">
                    <strong>Payment Method:</strong>
                    <p class="mb-0">{{ $transaction->payment_method }}</p>
                </div>

                <div class="mb-3">
                    <strong>Status:</strong>
                    <p class="mb-0">
                        <span class="badge bg-{{ 
                            $transaction->status === 'completed' ? 'success' : 
                            ($transaction->status === 'failed' ? 'danger' : 
                            ($transaction->status === 'refunded' ? 'info' : 'warning')) 
                        }}">
                            {{ ucfirst($transaction->status) }}
                        </span>
                    </p>
                </div>

                <div class="mb-3">
                    <strong>Payment Date:</strong>
                    <p class="mb-0">{{ $transaction->payment_date ? $transaction->payment_date->format('M d, Y h:i A') : 'N/A' }}</p>
                </div>

                <div class="mb-3">
                    <strong>Created:</strong>
                    <p class="mb-0">{{ $transaction->created_at->format('M d, Y h:i A') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Actions</h6>
            </div>
            <div class="card-body">
                <a href="{{ route('admin.transactions.edit', $transaction->id) }}" class="btn btn-warning btn-block w-100 mb-2">
                    <i class="fas fa-edit"></i> Edit Transaction
                </a>
                
                <form action="{{ route('admin.transactions.destroy', $transaction->id) }}" method="POST" 
                      onsubmit="return confirm('Are you sure you want to delete this transaction?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-block w-100">
                        <i class="fas fa-trash"></i> Delete Transaction
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
