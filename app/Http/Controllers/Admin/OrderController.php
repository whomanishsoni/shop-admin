<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Customer;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $orders = Order::with('customer')->select('*');
            return DataTables::of($orders)
                ->addColumn('checkbox', function($row) {
                    return '<input type="checkbox" class="select-item" value="'.$row->id.'">';
                })
                ->addColumn('customer', function($row) {
                    return $row->customer ? $row->customer->name : 'N/A';
                })
                ->addColumn('total', function($row) {
                    return '$'.number_format($row->total, 2);
                })
                ->addColumn('status', function($row) {
                    $badges = [
                        'pending' => 'warning',
                        'processing' => 'info',
                        'completed' => 'success',
                        'cancelled' => 'danger'
                    ];
                    $badge = $badges[$row->status] ?? 'secondary';
                    return '<span class="badge bg-'.$badge.'">'.ucfirst($row->status).'</span>';
                })
                ->addColumn('payment_status', function($row) {
                    $badge = $row->payment_status == 'paid' ? 'success' : 'warning';
                    return '<span class="badge bg-'.$badge.'">'.ucfirst($row->payment_status).'</span>';
                })
                ->addColumn('action', function($row) {
                    return '
                        <a href="'.route('admin.orders.show', $row->id).'" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                        <a href="'.route('admin.orders.edit', $row->id).'" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                        <form action="'.route('admin.orders.destroy', $row->id).'" method="POST" class="d-inline delete-form">
                            '.csrf_field().'
                            '.method_field('DELETE').'
                            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    ';
                })
                ->rawColumns(['checkbox', 'status', 'payment_status', 'action'])
                ->make(true);
        }
        return view('admin.orders.index');
    }

    public function create()
    {
        $customers = Customer::all();
        return view('admin.orders.create', compact('customers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_number' => 'required|string|unique:orders,order_number',
            'customer_id' => 'required|exists:customers,id',
            'subtotal' => 'required|numeric|min:0',
            'tax' => 'nullable|numeric|min:0',
            'shipping' => 'nullable|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'status' => 'required|in:pending,processing,completed,cancelled',
            'payment_method' => 'nullable|string',
            'payment_status' => 'required|in:pending,paid,failed,refunded',
            'shipping_address' => 'nullable|string',
            'billing_address' => 'nullable|string',
            'notes' => 'nullable|string'
        ]);

        Order::create($validated);

        return redirect()->route('admin.orders.index')->with('success', 'Order created successfully');
    }

    public function show(Order $order)
    {
        $order->load(['customer', 'items', 'transactions']);
        return view('admin.orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        $customers = Customer::all();
        return view('admin.orders.edit', compact('order', 'customers'));
    }

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'order_number' => 'required|string|unique:orders,order_number,'.$order->id,
            'customer_id' => 'required|exists:customers,id',
            'subtotal' => 'required|numeric|min:0',
            'tax' => 'nullable|numeric|min:0',
            'shipping' => 'nullable|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'status' => 'required|in:pending,processing,completed,cancelled',
            'payment_method' => 'nullable|string',
            'payment_status' => 'required|in:pending,paid,failed,refunded',
            'shipping_address' => 'nullable|string',
            'billing_address' => 'nullable|string',
            'notes' => 'nullable|string'
        ]);

        $order->update($validated);

        return redirect()->route('admin.orders.index')->with('success', 'Order updated successfully');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('admin.orders.index')->with('success', 'Order deleted successfully');
    }

    public function bulkDelete(Request $request)
    {
        Order::whereIn('id', $request->ids)->delete();
        return response()->json(['success' => 'Orders deleted successfully']);
    }
}
