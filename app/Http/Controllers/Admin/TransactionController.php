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
            $transactions = Transaction::with('order')->select('*');
            return DataTables::of($transactions)
                ->addColumn('checkbox', function($row) {
                    return '<input type="checkbox" class="select-item" value="'.$row->id.'">';
                })
                ->addColumn('order', function($row) {
                    return $row->order ? $row->order->order_number : 'N/A';
                })
                ->addColumn('amount', function($row) {
                    return '$'.number_format($row->amount, 2);
                })
                ->addColumn('status', function($row) {
                    $badges = [
                        'pending' => 'warning',
                        'completed' => 'success',
                        'failed' => 'danger',
                        'refunded' => 'info'
                    ];
                    $badge = $badges[$row->status] ?? 'secondary';
                    return '<span class="badge bg-'.$badge.'">'.ucfirst($row->status).'</span>';
                })
                ->addColumn('action', function($row) {
                    return '
                        <a href="'.route('admin.transactions.show', $row->id).'" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                        <a href="'.route('admin.transactions.edit', $row->id).'" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                        <form action="'.route('admin.transactions.destroy', $row->id).'" method="POST" class="d-inline delete-form">
                            '.csrf_field().'
                            '.method_field('DELETE').'
                            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    ';
                })
                ->rawColumns(['checkbox', 'status', 'action'])
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
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string',
            'status' => 'required|in:pending,completed,failed,refunded',
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
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string',
            'status' => 'required|in:pending,completed,failed,refunded',
            'payment_date' => 'nullable|date'
        ]);

        $transaction->update($validated);

        return redirect()->route('admin.transactions.index')->with('success', 'Transaction updated successfully');
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();
        return redirect()->route('admin.transactions.index')->with('success', 'Transaction deleted successfully');
    }

    public function bulkDelete(Request $request)
    {
        Transaction::whereIn('id', $request->ids)->delete();
        return response()->json(['success' => 'Transactions deleted successfully']);
    }
}
