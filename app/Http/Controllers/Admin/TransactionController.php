<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Order;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Transaction::with('order.customer');

            // Apply filters
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            if ($request->filled('payment_method')) {
                $query->where('payment_method', $request->payment_method);
            }

            if ($request->filled('date_from')) {
                $query->whereDate('payment_date', '>=', $request->date_from);
            }

            if ($request->filled('date_to')) {
                $query->whereDate('payment_date', '<=', $request->date_to);
            }

            return DataTables::of($query)
                ->addColumn('checkbox', function($row) {
                    return '<input type="checkbox" class="select-item" value="'.$row->id.'">';
                })
                ->addColumn('customer', function($row) {
                    return $row->order && $row->order->customer ? $row->order->customer->name : 'N/A';
                })
                ->addColumn('order', function($row) {
                    return $row->order ? '<a href="'.route('admin.orders.show', $row->order->id).'">'.$row->order->order_number.'</a>' : 'N/A';
                })
                ->addColumn('transaction_id', function($row) {
                    return $row->transaction_id ?? 'N/A';
                })
                ->addColumn('amount', function($row) {
                    return '₹'.number_format($row->amount, 2);
                })
                ->addColumn('payment_method', function($row) {
                    return ucfirst($row->payment_method ?? 'N/A');
                })
                ->addColumn('payment_mode', function($row) {
                    return ucfirst($row->payment_mode ?? 'N/A');
                })
                ->addColumn('status', function($row) {
                    $badges = [
                        'pending' => 'warning',
                        'paid' => 'success',
                        'failed' => 'danger',
                        'refunded' => 'info'
                    ];
                    $badge = $badges[$row->status] ?? 'secondary';
                    return '<span class="badge bg-'.$badge.'">'.ucfirst($row->status).'</span>';
                })
                ->addColumn('payment_date', function($row) {
                    return $row->payment_date ? $row->payment_date->format('d M Y H:i') : 'N/A';
                })
                ->addColumn('action', function($row) {
                    return '<a href="'.route('admin.transactions.show', $row->id).'" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>';
                })
                ->rawColumns(['checkbox', 'order', 'status', 'action'])
                ->make(true);
        }
        return view('admin.transactions.index');
    }

    public function create()
    {
        $orders = Order::all();
        return view('admin.transactions.create', compact('orders'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'transaction_id' => 'required|string|unique:transactions,transaction_id',
            'gateway_transaction_id' => 'nullable|string',
            'amount' => 'required|numeric|min:0',
            'currency' => 'required|string|size:3',
            'payment_response' => 'nullable|json',
            'payment_method' => 'required|string',
            'payment_gateway' => 'nullable|string',
            'status' => 'required|in:pending,paid,failed,refunded',
            'payment_date' => 'nullable|date'
        ]);

        Transaction::create($validated);

        return redirect()->route('admin.transactions.index')->with('success', 'Transaction created successfully');
    }

    public function show(Transaction $transaction)
    {
        $transaction->load('order');
        return view('admin.transactions.show', compact('transaction'));
    }

    public function edit(Transaction $transaction)
    {
        $orders = Order::all();
        return view('admin.transactions.edit', compact('transaction', 'orders'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'transaction_id' => 'required|string|unique:transactions,transaction_id,'.$transaction->id,
            'gateway_transaction_id' => 'nullable|string',
            'amount' => 'required|numeric|min:0',
            'currency' => 'required|string|size:3',
            'payment_response' => 'nullable|json',
            'payment_method' => 'required|string',
            'payment_gateway' => 'nullable|string',
            'status' => 'required|in:pending,paid,failed,refunded',
            'payment_date' => 'nullable|date'
        ]);

        $transaction->update($validated);

        return redirect()->route('admin.transactions.index')->with('success', 'Transaction updated successfully');
    }


}
