@extends('admin.layouts.app')

@section('title', 'View Transaction')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">View Transaction</h1>
    <div>
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
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <strong>Transaction ID:</strong>
                            <p class="mb-0">{{ $transaction->transaction_id ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <strong>Gateway Transaction ID:</strong>
                            <p class="mb-0">{{ $transaction->gateway_transaction_id ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <strong>Order:</strong>
                            <p class="mb-0">
                                @if($transaction->order)
                                    <a href="{{ route('admin.orders.show', $transaction->order->id) }}">{{ $transaction->order->order_number }}</a>
                                @else
                                    N/A
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <strong>Customer:</strong>
                            <p class="mb-0">
                                @if($transaction->order && $transaction->order->customer)
                                    {{ $transaction->order->customer->name }}
                                @else
                                    N/A
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <strong>Amount:</strong>
                            <p class="mb-0">₹{{ number_format($transaction->amount, 2) }} {{ $transaction->currency ?? 'INR' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <strong>Payment Method:</strong>
                            <p class="mb-0">{{ ucfirst($transaction->payment_method ?? 'N/A') }}</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <strong>Payment Mode:</strong>
                            <p class="mb-0">{{ ucfirst($transaction->payment_mode ?? 'N/A') }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <strong>Bank Name:</strong>
                            <p class="mb-0">{{ $transaction->bank_name ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <strong>Card Type:</strong>
                            <p class="mb-0">{{ ucfirst($transaction->card_type ?? 'N/A') }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <strong>Card Network:</strong>
                            <p class="mb-0">{{ $transaction->card_network ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <strong>Wallet Name:</strong>
                            <p class="mb-0">{{ $transaction->wallet_name ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <strong>VPA:</strong>
                            <p class="mb-0">{{ $transaction->vpa ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <strong>Fee:</strong>
                            <p class="mb-0">{{ $transaction->fee ? '₹'.number_format($transaction->fee, 2) : 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <strong>Tax:</strong>
                            <p class="mb-0">{{ $transaction->tax ? '₹'.number_format($transaction->tax, 2) : 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <strong>Status:</strong>
                            <p class="mb-0">
                                <span class="badge bg-{{ $transaction->status === 'paid' ? 'success' : ($transaction->status === 'failed' ? 'danger' : ($transaction->status === 'refunded' ? 'info' : 'warning')) }}">
                                    {{ ucfirst($transaction->status) }}
                                </span>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <strong>Payment Date:</strong>
                            <p class="mb-0">{{ $transaction->payment_date ? $transaction->payment_date->format('M d, Y h:i A') : 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Transaction Summary</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Status:</strong>
                    <span class="badge bg-{{ $transaction->status === 'paid' ? 'success' : ($transaction->status === 'failed' ? 'danger' : ($transaction->status === 'refunded' ? 'info' : 'warning')) }} ms-2">
                        {{ ucfirst($transaction->status) }}
                    </span>
                </div>
                <div class="mb-3">
                    <strong>Total Amount:</strong>
                    <p class="mb-0 text-success fw-bold">₹{{ number_format($transaction->amount, 2) }}</p>
                </div>
                <div class="mb-3">
                    <strong>Payment Method:</strong>
                    <p class="mb-0">{{ ucfirst($transaction->payment_method ?? 'N/A') }}</p>
                </div>
                <div class="mb-3">
                    <strong>Transaction Date:</strong>
                    <p class="mb-0">{{ $transaction->payment_date ? $transaction->payment_date->format('M d, Y') : 'N/A' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
