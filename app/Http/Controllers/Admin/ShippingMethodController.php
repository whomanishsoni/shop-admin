<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShippingMethod;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ShippingMethodController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $shippingMethods = ShippingMethod::select('*');
            return DataTables::of($shippingMethods)
                ->addColumn('checkbox', function($row) {
                    return '<input type="checkbox" class="select-item" value="'.$row->id.'">';
                })
                ->addColumn('cost', function($row) {
                    return '$'.number_format($row->cost, 2);
                })
                ->addColumn('delivery_time', function($row) {
                    return $row->delivery_time ? $row->delivery_time.' days' : 'N/A';
                })
                ->addColumn('status', function($row) {
                    return $row->status ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>';
                })
                ->addColumn('action', function($row) {
                    return '
                        <a href="'.route('admin.shipping-methods.edit', $row->id).'" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                        <form action="'.route('admin.shipping-methods.destroy', $row->id).'" method="POST" class="d-inline delete-form">
                            '.csrf_field().'
                            '.method_field('DELETE').'
                            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    ';
                })
                ->rawColumns(['checkbox', 'status', 'action'])
                ->make(true);
        }
        return view('admin.shipping-methods.index');
    }

    public function create()
    {
        return view('admin.shipping-methods.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cost' => 'required|numeric|min:0',
            'delivery_time' => 'nullable|integer|min:0',
            'status' => 'boolean'
        ]);

        ShippingMethod::create($validated);

        return redirect()->route('admin.shipping-methods.index')->with('success', 'Shipping Method created successfully');
    }

    public function show(ShippingMethod $shippingMethod)
    {
        return view('admin.shipping-methods.show', compact('shippingMethod'));
    }

    public function edit(ShippingMethod $shippingMethod)
    {
        return view('admin.shipping-methods.edit', compact('shippingMethod'));
    }

    public function update(Request $request, ShippingMethod $shippingMethod)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cost' => 'required|numeric|min:0',
            'delivery_time' => 'nullable|integer|min:0',
            'status' => 'boolean'
        ]);

        $validated['status'] = $request->has('status') ? true : false;

        $shippingMethod->update($validated);

        return redirect()->route('admin.shipping-methods.index')->with('success', 'Shipping Method updated successfully');
    }

    public function destroy(ShippingMethod $shippingMethod)
    {
        $shippingMethod->delete();
        return redirect()->route('admin.shipping-methods.index')->with('success', 'Shipping Method deleted successfully');
    }

    public function bulkDelete(Request $request)
    {
        ShippingMethod::whereIn('id', $request->ids)->delete();
        return response()->json(['success' => 'Shipping Methods deleted successfully']);
    }
}
