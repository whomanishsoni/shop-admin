<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentGateway;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PaymentGatewayController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $paymentGateways = PaymentGateway::select(['id', 'name', 'gateway_key', 'mode', 'status']);
            return DataTables::of($paymentGateways)
                ->addColumn('checkbox', function($row) {
                    return '<input type="checkbox" class="select-item" value="'.$row->id.'">';
                })
                ->addColumn('mode', function($row) {
                    if ($row->gateway_key === 'cod') {
                        return '<span class="badge bg-secondary">N/A</span>';
                    }
                    return '<span class="badge bg-' . ($row->mode === 'live' ? 'success' : 'warning') . '">' . ucfirst($row->mode) . '</span>';
                })
                ->addColumn('status', function($row) {
                    return $row->status ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>';
                })
                ->addColumn('action', function($row) {
                    return '
                        <a href="'.route('admin.payment-gateways.show', $row->id).'" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                        <a href="'.route('admin.payment-gateways.edit', $row->id).'" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                        <form action="'.route('admin.payment-gateways.destroy', $row->id).'" method="POST" class="d-inline delete-form">
                            '.csrf_field().'
                            '.method_field('DELETE').'
                            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    ';
                })
                ->rawColumns(['checkbox', 'mode', 'status', 'action'])
                ->make(true);
        }
        return view('admin.payment-gateways.index');
    }

    public function create()
    {
        return view('admin.payment-gateways.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'gateway_key' => 'required|string|max:255|unique:payment_gateways,gateway_key',
            'mode' => 'nullable|in:test,live',
            'test_key_id' => 'nullable|string|max:255',
            'test_key_secret' => 'nullable|string|max:255',
            'live_key_id' => 'nullable|string|max:255',
            'live_key_secret' => 'nullable|string|max:255',
            'status' => 'required|in:0,1',
        ]);

        $data = $request->only([
            'name', 'gateway_key', 'mode', 'test_key_id', 'test_key_secret',
            'live_key_id', 'live_key_secret', 'status'
        ]);

        // Set default mode for Razorpay if not provided
        if ($request->gateway_key === 'razorpay' && empty($data['mode'])) {
            $data['mode'] = 'test';
        }

        PaymentGateway::create($data);

        return redirect()->route('admin.payment-gateways.index')->with('success', 'Payment Gateway created successfully');
    }

    public function show(PaymentGateway $paymentGateway)
    {
        return view('admin.payment-gateways.show', compact('paymentGateway'));
    }

    public function edit(PaymentGateway $paymentGateway)
    {
        return view('admin.payment-gateways.edit', compact('paymentGateway'));
    }

    public function update(Request $request, PaymentGateway $paymentGateway)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'gateway_key' => 'required|string|max:255|unique:payment_gateways,gateway_key,'.$paymentGateway->id,
            'mode' => 'nullable|in:test,live',
            'test_key_id' => 'nullable|string|max:255',
            'test_key_secret' => 'nullable|string|max:255',
            'live_key_id' => 'nullable|string|max:255',
            'live_key_secret' => 'nullable|string|max:255',
            'status' => 'required|in:0,1',
        ]);

        $data = $request->only([
            'name', 'gateway_key', 'mode', 'test_key_id', 'test_key_secret',
            'live_key_id', 'live_key_secret', 'status'
        ]);

        // Set default mode for Razorpay if not provided
        if ($request->gateway_key === 'razorpay' && empty($data['mode'])) {
            $data['mode'] = 'test';
        }

        $paymentGateway->update($data);

        return redirect()->route('admin.payment-gateways.index')->with('success', 'Payment Gateway updated successfully');
    }

    public function destroy(PaymentGateway $paymentGateway)
    {
        $paymentGateway->delete();
        return redirect()->route('admin.payment-gateways.index')->with('success', 'Payment Gateway deleted successfully');
    }

    public function bulkDelete(Request $request)
    {
        PaymentGateway::whereIn('id', $request->ids)->delete();
        return response()->json(['success' => 'Payment Gateways deleted successfully']);
    }
}
